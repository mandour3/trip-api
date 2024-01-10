<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
        ]);

        $otp = mt_rand(1000, 9999);

        DB::table('password_resets')->insert([
            'phone_number' => $request->phone_number,
            'otp' => $otp,
            'created_at' => now(),
        ]);

        $basic  = new \Vonage\Client\Credentials\Basic("4306d10d", "HQJFos7GsApq6MgX");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS( $request->phone_numbe, jadaraa, 'الكود الخاص بك هو  ' .$otp)
        );

        return response()->json(['message' => 'Password reset OTP sent successfully']);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'otp' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8|confirmed',

        ]);

        $input =$request->all();

        $reset = DB::table('password_resets')
            ->where('phone_number', $request->phone_number)
            ->first();

        if (!$reset ) {
            return response()->json(['message' => 'Invalid or expired OTP'], 400);
        }
        if ($input['password'] === $input['password_confirmation']){
            $user = User::where('phone_number', $request->phone_number)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            DB::table('password_resets')
                ->where('phone_number', $request->phone_number)
                ->delete();

            $notifications = new Notification();
            $notifications->user_id = $user->id;
            $notifications->message = "تم عمل تعديل : ".$user->User_name;
            $notifications->save();
            return response()->json(['message' => 'Password reset successfully']);

        }
        return response()->json(['message' => 'الباسورد غير متوافقه']);



    }
}
