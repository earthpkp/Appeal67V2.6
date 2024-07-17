<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Appeal;
use App\Models\department;
use App\Models\appeal_emp_comment;
use App\Models\FrontUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{

    /* 
    public function login(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {

            return Response(['message' => $validator->errors()], 401);
        }



        if (!Auth::guard('employee')->attempt($request->only('email', 'password'))) {
            return  response()->json([
                'message' => 'login failed'
            ], 401);
        }

        $user = Employee::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('authTokenEmployee')->plainTextToken;

        return response()->json(['token' => $token]);
    }
 */


    public function login(Request $request)
    {
        try {
            if (!Auth::guard('employee')->attempt($request->only('email', 'password'))) {
                return  response()->json([
                    'message' => 'Email หรือ รหัสผ่านไม่ถูกต้อง'
                ], 401);
            }

            $user = Employee::where('email', $request['email'])->firstOrFail();
            $token = $user->createToken('authTokenEmployee', expiresAt: now()->addHour(8))->plainTextToken;

            return response()->json([
                'token' => $token,
                'employee_role_id' => $user->employee_role_id, // เพิ่ม employee_role_id ใน JSON
            ]);
        } catch (\Exception $e) {
            // Handle the exception and return a 500 error response
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }













    /*     public function employeeDetails(): Response
    {
        if (Auth::check()) {

            $user = Auth::user();

            return Response(['data' => $user], 200);
        }

        return Response(['data' => 'Unauthorized'], 404);
      
    }
 */



    public function employeeDetails(Request $request)
    {
        try {
            // ตรวจสอบการยืนยันตัวตนก่อนเข้าถึงข้อมูล
            if (!Auth::check()) {
                return response(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized
            }

            // ถ้าผู้ใช้ล็อกอินเข้าสู่ระบบ ดึงข้อมูลผู้ใช้งาน
            $user = $request->user();

            // ดึงข้อมูลแผนกที่เกี่ยวข้อง
            $userWithDepartment = $user->load('department');

            return response(['data' => $userWithDepartment], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }





    public function logout(Request $request)
    {
        $user = $request->user();

        // ลบ Token ที่ใช้ในการยืนยันตัวตนของผู้ใช้งานออกจากฐานข้อมูล
        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }


    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                $data = [
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                ];

                // ตรวจสอบว่ามีค่า 'department_id' ในคำขอ หากไม่มีกำหนดค่าเริ่มต้นเป็น 1
                if ($request->has('department_id')) {
                    $data['department_id'] = $request->input('department_id');
                } else {
                    $data['department_id'] = 1;
                }

                // ตรวจสอบว่ามีค่า 'employee_role_id' ในคำขอ หากไม่มีกำหนดค่าเริ่มต้นเป็น 2
                if ($request->has('employee_role_id')) {
                    $data['employee_role_id'] = $request->input('employee_role_id');
                } else {
                    $data['employee_role_id'] = 2;
                }

                $user = Employee::create($data);

                $token = $user->createToken('Employee_token_Register', expiresAt: now()->addHour(4))->plainTextToken;

                return response()->json([
                    'user' => $user,
                    'token' => $token
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Internal Server Error',
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Method Not Allowed'
            ], 405);
        }
    }


    /*  public function register(Request $request)
    {
        $user = Employee::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        $token = $user->createToken('Employee_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }
 */






    public function employeeUpdate(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response(['message' => 'ไม่พบข้อมูลพนักงาน'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'email' => 'required|email|unique:employees,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 400);
        }

        $data = $request->only('name', 'email');

        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response(['message' => 'อัปเดตข้อมูลพนักงานเรียบร้อยแล้ว'], 200);
    }


    /* public function employeeDelete($id)
    {
        // ตรวจสอบการยืนยันตัวตนก่อนการลบข้อมูล (Authentication)
        if (!Auth::check()) {
            return Response(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401);
        }

        // ค้นหาข้อมูลพนักงานที่ต้องการลบจากฐานข้อมูล
        $employee = Employee::find($id);

        // ตรวจสอบว่าพบข้อมูลพนักงานที่ต้องการลบหรือไม่
        if (!$employee) {
            return Response(['message' => 'ไม่พบข้อมูลพนักงาน'], 404);
        }

        // ลบข้อมูลพนักงานออกจากฐานข้อมูล
        $employee->delete();

        return Response(['message' => 'ลบข้อมูลพนักงานเรียบร้อยแล้ว'], 200);
    }
 */


    public function employeeDelete($id)
    {
        try {
            // ตรวจสอบการยืนยันตัวตนก่อนการลบข้อมูล (Authentication)
            if (!Auth::check()) {
                return Response(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401);
            }

            // ค้นหาข้อมูลพนักงานที่ต้องการลบจากฐานข้อมูล
            $employee = Employee::find($id);

            // ตรวจสอบว่าพบข้อมูลพนักงานที่ต้องการลบหรือไม่
            if (!$employee) {
                return Response(['message' => 'ไม่พบข้อมูลพนักงาน'], 404);
            }

            // ลบข้อมูลพนักงานออกจากฐานข้อมูล
            $employee->delete();

            return Response(['message' => 'ลบข้อมูลพนักงานเรียบร้อยแล้ว'], 200);
        } catch (\Exception $e) {
            // Handle the exception and return a 500 error response
            return Response(['message' => 'Internal Server Error'], 500);
        }
    }




    public function EmApperDetails(Request $request)
    {
        try {
            // ตรวจสอบการยืนยันตัวตนก่อนเข้าถึงข้อมูล
            if (!Auth::check()) {
                return response(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized
            }


            // ดึงข้อมูลการร้องเรียนทั้งหมด และโหลดข้อมูลสถานะด้วย
            $appeals = Appeal::with('status', 'dep')->get();

            return response(['data' => $appeals], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }



    public function getAppealByAppDocEm(Request $request, $app_doc)
    {
        try {
            // ตรวจสอบการยืนยันตัวตนก่อนเข้าถึงข้อมูล
            if (!Auth::check()) {
                return response()->json(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized
            }

            // ค้นหาข้อมูลการร้องเรียนโดยใช้ app_doc
            $appeal = Appeal::where('app_doc', $app_doc)
                ->with('comments') // โหลดข้อมูล status ด้วย
                ->with('status')
                ->with('dep')
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

    public function getAppealByAppid(Request $request, $app_id)
    {
        try {
            // ตรวจสอบการยืนยันตัวตนก่อนเข้าถึงข้อมูล
            if (!Auth::check()) {
                return response()->json(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized
            }

            // ค้นหาข้อมูลการร้องเรียนโดยใช้ app_doc
            $appeal = Appeal::where('app_id', $app_id)
                ->with(['comments.department' => function ($query) {
                    $query->select('dep_id', 'dep_name'); // เลือกฟิลด์ที่ต้องการแสดงเท่านั้น
                }])
                ->with('status')
                ->with('dep')
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

    public function updateStatusandComment(Request $request, $app_id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized
        }

        $appeal = Appeal::where('app_id', $app_id)->first();
        if ($appeal && ($appeal->status_id == 1 || $appeal->status_id == 5)) {
            $appeal->status_id = 2;
            $appeal->dep_id = $request->dep_id;

            $appeal->comments()->create([
                'dep_app_id' => $request->dep_id,
                'comm_status_id' => 1
            ]);

            $appeal->save();

            $email = $appeal->app_email; // เข้าถึง app_email ผ่าน $appeal
            Mail::send('process', ['app_doc' => $appeal->app_doc], function (Message $message) use ($email, $appeal) {
                $message->subject('หมายเลขเอกสารร้องเรียนร้องทุกข์ ที่ ' . $appeal->app_doc);
                $message->to($email);
            });

            $employees = Employee::where('department_id', $request->dep_id)->get();

            foreach ($employees as $employee) {
                $email = $employee->email;
                Mail::send('Appeal_em_dep', ['app_doc' => $appeal->app_doc], function (Message $message) use ($email, $appeal) {
                    $message->subject('แจ้งเตือน ระบบร้องเรียนร้องทุกข์ กรมอุตุนิยมวิทยา');
                    $message->to($email);
                });
            }

            return response()->json(['message' => 'ได้รับเรื่องร้องเรียนเรียบร้อยแล้ว'], 200);
        }
        if ($appeal->status_id == 2) {
            $appeal->comments()->create([
                'comment_details' => $request->comment_details,
                'emp_name' => $request->emp_name,
                'dep_app_id' => $request->department_id,

                'comm_status_id' => 2
            ]);

            return response()->json(['message' => 'อัพเดทข้อมูลเรียบร้อยแล้ว'], 200);
        }
    }


    public function closeappeal(Request $request, $app_id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized
        }

        $appeal = Appeal::where('app_id', $app_id)->first();
        if ($appeal->status_id == 2) {
            $appeal->status_id = 3;
            $appeal->save();
            $appeal->comments()->create([
                'comment_details' => $request->comment_details,
                'emp_name' => $request->emp_name,
                'dep_app_id' => $request->department_id,
                'comm_status_id' => 3
            ]);
            $email = $appeal->app_email; // เข้าถึง app_email ผ่าน $appeal
            Mail::send('finish', ['app_doc' => $appeal->app_doc, 'comment' => $request->comment_details, 'emp' =>  $request->emp_name], function (Message $message) use ($email, $appeal) {
                $message->subject('หมายเลขเอกสารร้องเรียนร้องทุกข์ ที่ ' . $appeal->app_doc);
                $message->to($email);
            });
            return response()->json(['message' => 'ปิดงานสำเร็จ'], 200);
        }
    }


    public function rejectappeal(Request $request, $app_id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized
        }
        $appeal = Appeal::where('app_id', $app_id)->first();
        $appeal->status_id = 4;
        $appeal->save();
        $appeal->comments()->create([
            'comm_status_id' => 4,
            'dep_app_id' => $request->department_id,
        ]);

        $email = $appeal->app_email; // เข้าถึง app_email ผ่าน $appeal
        Mail::send('reject', ['app_doc' => $appeal->app_doc], function (Message $message) use ($email, $appeal) {
            $message->subject('หมายเลขเอกสารร้องเรียนร้องทุกข์ ที่ ' . $appeal->app_doc);
            $message->to($email);
        });

        return response()->json(['message' => 'ปฏิเสธเอกสารเรียบร้อย'], 200);
    }

    public function returnappeal(Request $request, $app_id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized
        }

        $appeal = Appeal::where('app_id', $app_id)->first();
        if ($appeal->status_id == 2) {
            $appeal->status_id = 5;
            $appeal->save();
            $appeal->comments()->create([
                'comment_details' => $request->comment_details,
                'emp_name' => $request->emp_name,
                'comm_status_id' => 5,
                'dep_app_id' => $request->department_id,
            ]);

            return response()->json(['message' => 'ดำเนินการสำเร็จ'], 200);
        }
    }

    public function sendtoappeal(Request $request, $app_id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized
        }

        $appeal = Appeal::where('app_id', $app_id)->first();
        if ($appeal->status_id == 2) {
            $appeal->dep_id = $request->dep_id;

            $appeal->comments()->create([
                'comment_details' => $request->comment_details,
                'emp_name' => $request->emp_name,
                'dep_app_id' => $request->dep_id,
                'comm_status_id' => 6
            ]);

            $appeal->save();


            $employees = Employee::where('department_id', $request->dep_id)->get();

            foreach ($employees as $employee) {
                $email = $employee->email;
                Mail::send('Appeal_em_dep', ['app_doc' => $appeal->app_doc], function (Message $message) use ($email, $appeal) {
                    $message->subject('แจ้งเตือน ระบบร้องเรียนร้องทุกข์ กรมอุตุนิยมวิทยา');
                    $message->to($email);
                });
            }

            return response()->json(['message' => 'ได้รับเรื่องร้องเรียนเรียบร้อยแล้ว'], 200);
        }
        if ($appeal->status_id == 2) {
            $appeal->comments()->create([
                'comment_details' => $request->comment_details,
                'emp_name' => $request->emp_name,
                'dep_app_id' => $request->department_id,

                'comm_status_id' => 2
            ]);

            return response()->json(['message' => 'อัพเดทข้อมูลเรียบร้อยแล้ว'], 200);
        }
    }

    public function CountGrah()
    {
        /*$results = Appeal::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as record_count'))
                   ->groupBy(DB::raw('MONTH(created_at)'))
                   ->orderBy('month')
                   ->get();
                   return response()->json($results, 200);*/
        $results = Appeal::groupBy('app_typedetail')
            ->selectRaw('app_typedetail, COUNT(*) as record_count')
            ->get();
        return response()->json($results, 200);
    }




    public function getdepartment()
    { {
            try {
                // ตรวจสอบการยืนยันตัวตนก่อนเข้าถึงข้อมูล
                if (!Auth::check()) {
                    return response()->json(['message' => 'ไม่ได้เข้าสู่ระบบ'], 401); // Unauthorized
                }

                $Departments = department::all();
                return response()->json(['data' => $Departments], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Internal Server Error'], 500);
            }
        }
    }
}
