<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChatModel;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{    
    
    function createMsgId(){
    $userid="";
    
    for($i=0;$i<=rand(20,60);$i++){
        $userid.=rand(0,9);
    }
    return $userid;
}
    function sendMsg(Request $request){
        $chat=new ChatModel();

        $res=$chat->where("sender",$request->sender)->where("receiver",$request->userid)
                ->orWhere("sender",$request->userid)->where("receiver",$request->sender)->first();
         if(!empty($res)){
            $chat->insert(["msg_id"=>$res->msg_id,
                        "sender"=>$request->sender,
                        "receiver"=>$request->userid,
                        "msg"=>$request->msg,
                        "status"=>"0",
                        "created_at"=>date("Y-m-d H:i:s"),
                       "updated_at"=>date("Y-m-d H:i:s")]);
                       return response()->json(["res"=>"succeed"]);
 
         }else{
            $chat->insert(["msg_id"=>$this->createMsgId(),
            "sender"=>$request->sender,
            "receiver"=>$request->userid,
            "msg"=>$request->msg,
            "status"=>"0",
            "created_at"=>date("Y-m-d H:i:s"),
           "updated_at"=>date("Y-m-d H:i:s")]);
           return response()->json(["res"=>"succeed"]);
         }
      


    }
    function retrieveMsgs(Request $request){
        $msgs=DB::table("chat")
        ->where(function($query) use ($request) {
              $query->where("sender", $request->sender)
                    ->where("receiver", $request->receiver);
          })
        ->orWhere(function($query) use ($request) {
              $query->where("sender", $request->receiver)
                    ->where("receiver", $request->sender);
          })
        ->join('users as sender_user', 'sender_user.userid', '=', 'chat.sender')
        ->join('users as receiver_user', 'receiver_user.userid', '=', 'chat.receiver')
        ->select('chat.*', 'sender_user.userid as sender_user_id','sender_user.name as sender_user_name','sender_user.photo as sender_user_photo',
                  'receiver_user.userid as receiver_user_id','receiver_user.name as receiver_user_name','receiver_user.photo as receiver_user_photo')

                  ->orderBy("chat.created_at","asc") 
      ->get();
        return response()->json(["msgs"=>$msgs]);

    }

    function retrieveMessagedUsers(Request $request){
        $messagedUsers=DB::table("users")->where("userid","!=",$request->userid) 
                                       
                                       ->Join("chat",function($join){
                                        $join->on("users.userid","=","chat.sender")->orOn("users.userid","=","chat.receiver") ;
                                       })
                                       ->select("chat.*","users.userid","users.name","users.photo")
                                       ->orderBy("chat.id")->groupBy("chat.msg_id")->get();
        return response()->json(["messagedUsers"=>$messagedUsers]);
    
  }
}
