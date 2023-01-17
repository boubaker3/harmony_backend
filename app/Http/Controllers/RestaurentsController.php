<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\RestaurentsModel;
class RestaurentsController extends Controller
{

function retrieveRestaurents(Request $request){
    $rm=new RestaurentsModel();
    $order="asc";
    $by="created_at";
    if($request->order=="The Most Rated"){
        $order="desc";
        $by="rating";
    }else if($request->order=="The Newest"){
        $order="asc";
        $by="created_at";
    }else if($request->order=="The Oldest"){
        $order="desc";
        $by="created_at";
    }
    $restaurents=$rm->where("city",$request->city)->where("type","chef")->orderBy($by,$order)->get();
    return response()->json(["restaurents"=>$restaurents]);
}
function searchForRestaurents(Request $request){
    $rm=new RestaurentsModel();
    $restaurents=$rm->where("type","=","chef")->where(function($query) use ($request) {
                        $query->where("city","LIKE",'%'.$request->searchFor.'%')
                        ->orWhere("name","LIKE",'%'.$request->searchFor.'%');
                    })
    ->get();
    return response()->json(["restaurents"=>$restaurents]);
}

}
