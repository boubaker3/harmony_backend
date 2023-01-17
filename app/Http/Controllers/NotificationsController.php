<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Models\User;
use App\Models\ProductsModel;
use App\Models\NotificationsModel;
use App\Models\ChefShipperModel;
 
use App\Http\Controllers\Controller;
class NotificationsController extends Controller
{
    function createNotifId(){
        $userid="";
        
        for($i=0;$i<=rand(5,20);$i++){
            $userid.=rand(0,9);
        }
        return $userid;
    }
    function sendRating(Request $request){
        $user=new User();
        
        $where="";
        switch($request->rating){
        case 1:
        $where="oneStar";
        break;
        case 2:
        $where="twoStars";
        break;
        case 3:
        $where="threeStars";
        break;
        case 4:
        $where="fourStars";
        break;
        case 5:
        $where="fiveStars";
        break;
                       
        }
        $ratingData=$user->where("userid",$request->userid)->value($where);
       $updateStars=[$where=>$ratingData+=1];
       $user->where("userid",$request->userid)->update($updateStars);
        $userdata=$user->where("userid",$request->userid)->first();
        $score=$userdata->fiveStars*5+$userdata->fourStars*4+$userdata->threeStars*3+$userdata->twoStars*2+$userdata->oneStar*1;
        $response= $userdata->fiveStars+$userdata->fourStars+$userdata->threeStars+$userdata->twoStars+$userdata->oneStar;
        $newRating=$score/$response;
        $rating=["rating"=>$newRating];
        $user->where("userid",$request->userid)->update( $rating);
      $rm=new NotificationsModel(); 
      $rm->type="user_rating";
      $rm->notif_id=$this->createNotifId();
      $rm->notif_sender=$request->sender;
      $rm->notif_receiver=$request->userid;
      $rm->rating=$rating["rating"];
      $rm->save();
return response()->json(["res"=> "succeed"]);

    }


   
    function saveFeedbacks(Request $request){
        $pm=new NotificationsModel();
        $pm->insert(["notif_id"=>$this->createNotifId(),
                         "type"=>"user_feedback",
                         "feedback"=>$request->feedback,
                         "notif_sender"=>$request->sender, 
                         "notif_receiver"=>$request->userid, 
                        "created_at"=>date("Y-m-d H:i:s"),
                        "updated_at"=>date("Y-m-d H:i:s")]);
       return response()->json(["res"=>"succeed"]);
                    }
    function retrieveFeedbacks(Request $request){
             $feedbacks=DB::table("notifications")->where("notifications.type","user_feedback")->where("notif_receiver",$request->userid)
                                             ->join("users","users.userid","=","notifications.notif_sender")
                                             ->select("notifications.*","users.name","users.photo")->orderBy("notifications.notif_id","desc")->get();
            return response()->json(["feedbacks"=>$feedbacks]);
                        }

 
    function saveOrders(Request $request){
    $om=new NotificationsModel();
    $om->insert(["product_id"=>$request->product_id,
                "notif_id"=>$this->createNotifId(),
                "type"=>"order",
                "notif_sender"=>$request->sender,
                "notif_receiver"=>$request->receiver,          
                "quantity"=>$request->quantity,
                "status"=>"0",
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s")]);
    return response()->json(["res"=>"succeed"]);
}
    function retrieveOrders(Request $request){
         $om=new NotificationsModel();
        $orders= DB::table("notifications")->where("notif_sender",$request->userid)->where("notifications.type","order")
                                    ->join("users","users.userid","=","notifications.notif_receiver")
                                    ->join("products","products.product_id","=","notifications.product_id")
                                    ->select("notifications.*","users.name","users.photo","products.product_name","products.product_id")
                                     ->get();
        return response()->json(["orders"=>$orders]);
    }
    function deleteOrders(Request $request){
        $om->where("notif_id",$request->orderid)->delete();
        return response()->json(["res"=>"succeed"]);
    }

    function retrieveNotifications(Request $request){
        $notifications=DB::table("notifications")->where("notif_receiver","$request->userid")
                            ->join("users","users.userid","=","notifications.notif_sender")
                            ->join("products","products.product_id","=","notifications.product_id","left outer")
                            ->select("notifications.*","users.userid","users.name","users.photo","products.product_name","products.product_id","notifications.created_at as notif_date")
                            ->get();
                        
        return response()->json(["notifications"=>$notifications]);
    }
    function updateNotifStatus(Request $request){
        $om=new NotificationsModel();
        $data=["status"=>$request->status];
        $res=$om->where("notif_id",$request->notif_id)->update($data);
        return response()->json(["res"=>"succeed"]);
    }
    function retrieveShipperNotifications(Request $request){
        $csm=new ChefShipperModel();
        $res=$csm->where("shipper_id",$request->userid)->where("status","=","0")->get();
        if(!empty($res) && isset($res[0])){
            $notifications=DB::table("chef_shipper")->where("chef_shipper.chef_id",$res[0]->chef_id)
                               ->join("users","userid","=","chef_shipper.chef_id")
                               ->select("chef_shipper.*","users.*")
                               ->get();
            return response()->json(["notifications"=>$notifications]);
        }
        $res2=$csm->where("shipper_id",$request->userid)->where("status","1")->get();
        if(!empty($res2) && isset($res2[0])){
            $notifications=DB::table("notifications")->where("notifications.notif_receiver",$res2[0]->chef_id)
                                ->where("notifications.status","1")
                               ->join("users","userid","=","notifications.notif_sender")
                               ->join("products","products.product_id","=","notifications.product_id")
                               ->select("notifications.*","users.*","products.*")
                               ->get();
            return response()->json(["notifications"=>$notifications]);
        }

    }

    function saveProductFeedback(Request $request){
        $pm=new NotificationsModel();
        $pm->insert(["notif_id"=>$this->createNotifId(),
                         "type"=>"product_feedback",
                         "product_feedback"=>$request->feedback,
                         "notif_sender"=>$request->sender, 
                         "product_id"=>$request->productId,
                         "notif_receiver"=>$request->userid, 
                        "created_at"=>date("Y-m-d H:i:s"),
                        "updated_at"=>date("Y-m-d H:i:s")]);
       return response()->json(["res"=>"succeed"]);
                    }
    function retrieveProductsFeedbacks(Request $request){
             $feedbacks=DB::table("notifications")->where("notifications.type","product_feedback")->where("product_id",$request->productId)
                                             ->join("users","users.userid","=","notifications.notif_sender")
                                             ->select("notifications.*","users.name","users.photo")->orderBy("notifications.notif_id","desc")->get();
            return response()->json(["feedbacks"=>$feedbacks]);

    }
    function sendProductRating(Request $request){
        $pm=new ProductsModel();
        
        $where="";
        switch($request->rating){
        case 1:
        $where="oneStar";
        break;
        case 2:
        $where="twoStars";
        break;
        case 3:
        $where="threeStars";
        break;
        case 4:
        $where="fourStars";
        break;
        case 5:
        $where="fiveStars";
        break;
                       
        }
        $ratingData=$pm->where("userid",$request->receiver)->value($where);
       $updateStars=[$where=>$ratingData+=1];
       $pm->where("product_id",$request->productId)->update($updateStars);
        $productdata=$pm->where("product_id",$request->productId)->first();
        $score=$productdata->fiveStars*5+$productdata->fourStars*4+$productdata->threeStars*3+$productdata->twoStars*2+$productdata->oneStar*1;
        $response= $productdata->fiveStars+$productdata->fourStars+$productdata->threeStars+$productdata->twoStars+$productdata->oneStar;
        $newRating=$score/$response;
        $rating=["rating"=>$newRating];
        $pm->where("product_id",$request->productId)->update( $rating);
      $rm=new NotificationsModel(); 
      $rm->type="product_rating";
      $rm->notif_id=$this->createNotifId();
      $rm->notif_sender=$request->sender;
      $rm->notif_receiver=$request->receiver;
      $rm->product_id=$request->productId;
      $rm->rating=$rating["rating"];
      $rm->save();
return response()->json(["res"=> "succeed"]);

    }
    function checkRating(Request $request){
      $rm=new NotificationsModel(); 
       $res=$rm->where("notif_sender",$request->sender)->where("notif_receiver",$request->receiver)->where("type","user_rating")->first();
       if(empty($res)){
        return response()->json(["res"=>true]);
       }else{
        return response()->json(["res"=>false]);
       }
    }
}
