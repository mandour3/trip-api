<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\userRequest;
use App\Models\User;
use App\traits\image_upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use image_upload;

    public function register(userRequest $request)
    {

//        $request->validate([
//            'User_name' => 'required|string|max:255',
//            'email' => 'required|email|unique:users',
//            'password' => 'required|string|min:8',
//            'phone_number' => 'required|string|unique:users',
//            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//            'Governorate' => 'required|string|max:255',
//            'city' => 'required|string|max:255',
//            'birthdate' => 'date_format:Y-M-D|before:today',
//            'gender' => 'in:m,f',
//
//
//        ]);

        $otp = mt_rand(1000, 9999);

        $user = User::create([
            'User_name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'photo' =>  $this->verifyAndStoreImage($request,'photo','user','upload_image'),
            'Governorate' => $request->Governorate,
            'city' => $request->city,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'otp' => $otp,
        ]);
        $basic  = new \Vonage\Client\Credentials\Basic("4306d10d", "HQJFos7GsApq6MgX");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS( $request->phone_numbe, jadaraa, 'الكود الخاص بك هو  ' .$otp)
        );
        return response()->json(['message' => 'User registered And sent OTP successfully']);
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'otp' => 'required|string',
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();



        if ($user->otp !== $request->otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }
        $user->is_confirmed = true;
        $user->save();

        return response()->json(['message' => 'Account verified successfully']);
    }

}
