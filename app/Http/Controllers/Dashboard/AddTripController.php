<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddNewTrip;
use App\Models\notification;
use App\Models\Trip;
use App\traits\image_upload;
use Illuminate\Http\Request;

class AddTripController extends Controller
{
    use image_upload;

    public function add(AddNewTrip $request){
        $user_id = Auth()->user()->id;

        $trip = Trip::create([
            'address' => $request->address,
            'user_id' => $user_id,
            'type' => $request->type,
            'photo' =>  $this->verifyAndStoreImage($request,'photo','Trip','upload_image'),
            'Governorate' => $request->Governorate,
            'city' => $request->city,
            'attendees' => $request->attendees,
            'description' => $request->description,
            'date' => date('Y-m-d'),
            'time' => date('h:ma'),

        ]);

        $notifications = new Notification();
        $notifications->user_id = $user_id;
        $Trip = Trip::where('user_id',$user_id)->get();
        $notifications->message = "تم اضافه رحله جديده : ".$Trip->description;
        $notifications->save();

        return response()->json(['message' => 'تم حفظ الرحله',['trip' => $trip]]);



    }

    public function show(){
        $trip = Trip::orderBy('created_at', 'DESC')->paginate(6);

        return response()->json([['trip' => $trip]]);


    }

    public function show_single($id){
        $trip_single = Trip::where('id',$id)->get();
        return response()->json([['trip' => $trip_single]]);



    }

}
