<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;

class UserdataController extends Controller
{
    function getUserdata(Request $request){
    
        $user=new User();
        $userdata=$user->where("userid",$request->userid)->first();
     return response()->json(["data"=> $userdata]);
    }
    function updateProfile(Request $request){
        $user=new User();
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(["res"=>"your old password is incorrect!"]);
        }
                 
        $data=["name"=>$request->name,"country"=>$request->country,"city"=>$request->city,"address"=>$request->address,
               "phone"=>$request->phone,"password"=>bcrypt($request->newPassword)];
       $user->where("userid",$request->userid)->update($data);
       $newUser=$user->where("userid",$request->userid)->first();
               return response()->json(["res"=>"your profile has been updated","data"=>$newUser]);
    }
  
    
}
