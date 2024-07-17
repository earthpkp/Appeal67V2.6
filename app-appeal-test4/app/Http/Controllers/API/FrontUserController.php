<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FrontUser;
use App\Models\Employee;
use App\Models\Appeal;
use App\Models\status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use GuzzleHttp\Client;

class FrontUserController extends Controller
{
    public function login(Request $request)
    {
        try {
            if (!Auth::guard('frontuser')->attempt($request->only('email', 'password'))) {
                return  response()->json([
                    'message' => 'Email หรือ รหัสผ่านไม่ถูกต้อง'
                ], 401);
            }

            $user = Frontuser::where('email', $request['email'])->firstOrFail();

            $token = $user->createToken('authTokenUser', ['frontuser'])->plainTextToken;

            return response()->json(['token' => $token]);
        } catch (\Exception $e) {
            // Handle the exception and return a 500 error response
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }



    public function userDetails(Request $request)
    {
        try {
            // ตรวจสอบการยืนยันตัวตนก่อนเข้าถึงข้อมูล
            if (!Auth::check()) {
                return response(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized

            }


            // ถ้าผู้ใช้ล็อกอินเข้าสู่ระบบ ดึงข้อมูลผู้ใช้งาน
            $user = $request->user();
            if ($user->tokenCan('frontuser')) {
                $userWithRole = $user->load('role_user');
                return response(['data' => $userWithRole], 200);
            }


            // ดึงข้อมูลแผนกที่เกี่ยวข้อง
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }



    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            // ตรวจสอบว่า Email ซ้ำหรือไม่
            $existingUser = FrontUser::where('email', $request->input('email'))->first();

            if ($existingUser) {
                return response()->json([
                    'message' => 'Email นี้มีผู้ใช้งานแล้ว',
                ], 400); // ส่ง HTTP สถานะ 400 Bad Request
            }

            try {
                $data = [
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                ];

                if ($request->has('user_role_id')) {
                    $data['user_role_id'] = $request->input('user_role_id');
                } else {
                    $data['user_role_id'] = 2; // กำหนดค่าเริ่มต้นของ department_id เป็น 1
                }

                $user = FrontUser::create($data);

                $token = $user->createToken('User_token_Register', expiresAt: now()->addHour(8))->plainTextToken;

                return response()->json([
                    'user' => $user,
                    'token' => $token
                ], 200);
            } catch (\Exception $e) {
                // จัดการข้อผิดพลาดและส่งการตอบกลับแสดงข้อความข้อผิดพลาด โดยให้รหัสสถานะ 500 (Internal Server Error)
                return response()->json([
                    'message' => 'Internal Server Error',
                ], 500);
            }
        } else {
            // ไม่อนุญาตให้ใช้เมธอดนี้
            return response()->json([
                'message' => 'Method Not Allowed'
            ], 405);
        }
    }


    public function logout(Request $request)
    {
        $user = $request->user();

        // ลบ Token ที่ใช้ในการยืนยันตัวตนของผู้ใช้งานออกจากฐานข้อมูล
        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }


    /* public function addAppeal(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized
            }

            // ดึงข้อมูลที่ส่งมาจาก HTTP Request
            $data = $request->all();

            // ตรวจสอบว่ามีค่า app_doc ถูกส่งมาหรือไม่ ถ้าไม่มีให้สร้างค่าสุ่ม 6 ตัวอักษร
            if (!isset($data['app_doc'])) {
                do {
                    $newAppDoc = strval(mt_rand(100000, 999999));
                } while (Appeal::where('app_doc', $newAppDoc)->exists());

                $data['app_doc'] = $newAppDoc;
            }

            // สร้างข้อมูลในตาราง "appeals"
            $newAppeal = Appeal::create($data);

            return response()->json(['message' => 'successfully', 'data' => $newAppeal], 200);
        } catch (\Exception $e) {
            // จัดการข้อผิดพลาดและส่งการตอบกลับแสดงข้อความข้อผิดพลาด โดยให้รหัสสถานะ 500 (Internal Server Error)
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    } */




    public function addAppeal(Request $request)
    {
        try {

            $client = new Client([
                'verify' => false
            ]);
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret' => env('RECAPTCHA_SECRET_KEY'),
                    'response' => $request->gkey
                ]
            ]);
            $responseData = json_decode($response->getBody(), true);
            if ($responseData['success']) {
                // ดึงข้อมูลที่ส่งมาจาก HTTP Request
                $data = $request->all();

                // ตรวจสอบว่ามีค่า app_doc ถูกส่งมาหรือไม่ ถ้าไม่มีให้สร้างค่าสุ่ม 6 ตัวอักษร
                if (!isset($data['app_doc'])) {
                    do {
                        $newAppDoc = 'อต.' . strval(mt_rand(100000, 999999));
                    } while (Appeal::where('app_doc', $newAppDoc)->exists());

                    $data['app_doc'] = $newAppDoc;
                }

                // สร้างข้อมูลในตาราง "appeal"
                $newAppeal = Appeal::create($data);


                $email = $newAppeal->app_email; // เข้าถึง app_email ผ่าน $appeal
                Mail::send('Appeal_start', ['app_doc' => $newAppeal->app_doc], function (Message $message) use ($email, $newAppeal) {
                    $message->subject('หมายเลขเอกสารร้องเรียนร้องทุกข์ ที่ ' . $newAppeal->app_doc);
                    $message->to($email);
                });

                $employee = Employee::where('employee_role_id', 1)->first(); // ค้นหาพนักงานที่มี employee_role_id เป็น 1
                if (!$employee) {
                    return response()->json(['message' => 'ไม่พบข้อมูลพนักงานที่มีบทบาทเป็น 1'], 404);
                }
                $email = $employee->email; // เข้าถึงอีเมลของพนักงาน
                Mail::send('Appeal_start_em', ['app_doc' => $newAppeal->app_doc], function (Message $message) use ($email, $newAppeal) {
                    $message->subject('แจ้งเตือนระบบได้รับเรื่องร้องเรียน');
                    $message->to($email);
                });



                return response()->json(['message' => $newAppDoc, 'data' => $data], 200);
            } else {
                return response()->json([
                    'message' => 'YOU ARE ROBOT!'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }



    public function ApperDetails(Request $request)
    {
        try {
            // ตรวจสอบการยืนยันตัวตนก่อนเข้าถึงข้อมูล


            // ถ้าผู้ใช้ล็อกอินเข้าสู่ระบบ ดึงข้อมูลผู้ใช้งาน
            $user = $request->user();
            if (!$user) {
                return response()->json(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized
            }
            // ดึงข้อมูลการร้องเรียนที่เกี่ยวข้องกับผู้ใช้งาน
            $appeals = Appeal::where('user_id', $user->id)
                ->with('status') // โหลดข้อมูล status ด้วย
                ->get();

            return response(['data' => $appeals], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }

    public function getAppealByAppDoc($app_doc)
    {
        try {
            // ตรวจสอบการยืนยันตัวตนก่อนเข้าถึงข้อมูล
            if (!Auth::check()) {
                return response(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized
            }

            // ค้นหาข้อมูลการร้องเรียนโดยใช้ app_doc
            $appeal = Appeal::where('app_doc', $app_doc)
                ->with('comments')
                ->with('status')
                ->with('dep') // โหลดข้อมูล status ด้วย
                ->first();

            if (!$appeal) {
                return response(['message' => 'ไม่พบข้อมูลการร้องเรียนสำหรับ app_doc ที่ระบุ'], 404); // Not Found
            }

            return response(['data' => $appeal], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }
    public function searchappdoc(Request $request)
    {
        try {
            $appdoc = $request->app_doc;
            $idcard = $request->app_cardID;
            $appeal = Appeal::all()->where('app_cardID', $idcard)->where('app_doc', $appdoc)->load('status')->load('comments')->first();
            if ($appeal) {
                return response()->json(['appeal' => $appeal], 200);
            } else {
                return response()->json(['message' => 'ไม่พบข้อมูลการร้องเรียน'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
