<?php
namespace App\Http\Controllers;


 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReviewsModel;


class ReviewsController extends Controller
{
    //
      function post(Request $request){
      $rm=new ReviewsModel();
      $rm->fullname=$request->fullname;
      $rm->email=$request->email;
      $rm->phonenumber=$request->phonenumber;
      $rm->message=$request->message;
      $rm->save();

      return response()->json(["msg"=>"your feedback has been sent",'status'=>200]);
      }
}
