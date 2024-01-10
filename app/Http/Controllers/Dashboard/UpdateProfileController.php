<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\userRequest;
use App\Models\notification;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateProfileController extends Controller
{
    public function update_profile(userRequest $request, $id){
        try {
            $User = User::findOrFail($id);
            $User->update([
                $request->all()
            ]);

            $notifications = new Notification();
            $notifications->user_id = $id;
            $notifications->message = "تم عمل تعديل : ".$User->User_name;
            $notifications->save();
            return response()->json(['message' => 'تم حفظ البيانات بنجاح',['User' => $User]]);

        }
        catch (\Exception $e) {
            return response()->json(['message' => 'خطا',['error' => $e->getMessage()]]);

        }
    }

    public function updatePassword( Request $request, $id){

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validatedData = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->password = Hash::make($validatedData['password']);
        $user->save();

        return response()->json(['message' => 'Password updated successfully'], 200);


    }
}
