<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\notification;
use Illuminate\Http\Request;

class ShowNotificationController extends Controller
{
public function show(){
    $user_id =auth()->user()->id;
    $Notification = Notification::where('user_id',$user_id)->get();
    return response()->json([['Notification' => $Notification]]);



}

}
