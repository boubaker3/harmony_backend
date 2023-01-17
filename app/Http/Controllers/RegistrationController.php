<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usermodel;
use App\Models\User;
  use Illuminate\Support\Facades\Auth;
use JWTAuth;

class RegistrationController extends Controller
{

    function createUserId(){
        $userid="";
        
        for($i=0;$i<=rand(5,20);$i++){
            $userid.=rand(0,9);
        }
        return $userid;
    }
    function signup(Request $request){
       $user=new User();
       $token = JWTAuth::fromUser($user);
       $user->remember_token = $token;
       $user->insert(["name"=>$request->name,
                       "userid"=>$this->createUserId(),
                       "email"=>$request->email,
                       "password"=>bcrypt($request->password),
                       "city"=>$request->city,
                       "country"=>$request->country,
                       "address"=>$request->address,
                       "phone"=>$request->phone,
                       "photo"=>"null",
                       "cover"=>"null",
                       "rating"=>"0.0",
                       "bio"=>$request->bio,
                       "type"=>$request->type,
                       "remember_token"=> $token,
                       "created_at"=>date("Y-m-d H:i:s"),
                       "updated_at"=>date("Y-m-d H:i:s")]);
            
        $user=$user->where("remember_token",$token)->first();  
                      
               return response()->json(["token"=> $token,"user"=>$user]);
          

    }
    function updatePicture(Request $request){
        $user=new User();
        $data=["photo"=>$request->photo];
        $user->where("userid",$request->userid)->update($data);
        return response()->json(["res"=>"succeed"]);
    }
   
     
}
