<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\ChefShipperModel;
use App\Models\User;
use Illuminate\Support\Facades\DB; 

use Illuminate\Http\Request;

class ChefShipperController extends Controller
{

    function createChefShipperId(){
        $userid="";
        
        for($i=0;$i<=rand(5,20);$i++){
            $userid.=rand(0,9);
        }
        return $userid;
    }
function saveShippers(Request $request){
    $csm=new ChefShipperModel();
    $user=new User();
    $res=$user->where("email",$request->email)->first();
    $csm->insert(["chef_shipper_id"=>$this->createChefShipperId(),
                  "chef_id"=>$request->userid,
                  "status"=>"0",
                  "shipper_id"=>$res->userid,
                  "created_at"=>date("Y-m-d H:i:s"),
                  "updated_at"=>date("Y-m-d H:i:s")]);

}
function retrieveShippers(Request $request){
    $shippers=DB::table("chef_shipper")->where("chef_shipper.chef_id",$request->userid) 
    ->join("users","users.userid","=","chef_shipper.shipper_id")
    ->select("chef_shipper.*","users.name","users.userid","users.photo" ) 
    ->get();
return response()->json(["shippers"=>$shippers]);
}
  function updateRequestStatus(Request $request){
    $csm=new ChefShipperModel();
    $data=["status"=>$request->status];
    $res=$csm->where("chef_shipper_id",$request->notif_id)->update($data);
    return response()->json(["res"=>"succeed"]);
  }
}
