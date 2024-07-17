<?php

namespace App\Http\Controllers;

use App\Models\FrontUser;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function SentResetPasswordMail(Request $request)
    {
        $email = $request->email;
        $user = Employee::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'ไม่พบอีเมลของคุณในระบบ'
            ], 404);
        }

        $token = Str::random(60);

        try {
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('reset', ['token' => $token], function (Message $message) use ($email) {
            $message->subject('รีเซ็ทรหัสผ่านระบบร้องเรียนร้องทุกข์');
            $message->to($email);
        });

        return response()->json([
            "message" => 'ดำเนินการจัดส่งลิ้งก์เพื่อรีเซ็ตรหัสผ่านเรียบร้อย... กรุณาโปรดเช็คอีเมล',
            'status' => 'success'
        ], 200);
    }catch (\Exception $e) {
        // Handle the exception and return a 500 error response
        return response()->json([
            'message' => 'Internal Server Error',
        ], 500);
    }

    }

    public function resetpassword(Request $request, $token)
    {
        $formatted = Carbon::now()->subMinute(3)->toDateTimeString();
        DB::table('password_reset_tokens')->where('created_at', '<=', $formatted)->delete();

        $passwordreset = DB::table('password_reset_tokens')->where('token', $token)->first();
        if (!$passwordreset) {
            return response()->json([
                'message' => 'ไม่เจอโทเคนหรือหมดอายุ'
            ], 404);
        }

        $user = Employee::where('email', $passwordreset->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        $passwordreset = DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        return response()->json([
            'message' => 'รีเซ็ทรหัสผ่านเรียบร้อย'
        ], 200);
    }
}
