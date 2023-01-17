<?php

namespace App\Http\Controllers;
use App\Models\ChefShipperModel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductsModel;
class ProductsController extends Controller
{
    function createProductId(){
        $userid="";
        
        for($i=0;$i<=rand(5,20);$i++){
            $userid.=rand(0,9);
        }
        return $userid;
    }
    function saveProduct(Request $request){
        $pm=new ProductsModel();
        $pm->insert(["product_name"=>$request->product_name,
                        "product_price"=>$request->product_price,
                        "product_desc"=>$request->product_desc,
                        "product_image"=>$request->product_image,
                        "product_id"=>$this->createProductId(),
                        "userid"=>$request->userid,
                        "rating"=>0.0,
                        "oneStar"=>"0",
                        "twoStars"=>"0",
                        "threeStars"=>"0",
                        "FourStars"=>"0",
                        "FiveStars"=>"0",
                        "created_at"=>date("Y-m-d H:i:s"),
                        "updated_at"=>date("Y-m-d H:i:s")],
                                     
);
    }
    function retrieveProducts(Request $request){
        $csm=new ChefShipperModel();
        $pm=new ProductsModel();
        if($request->type=="chef"){
            $products=$pm->where("userid",$request->userid)->get();
            return response()->json(["products"=>$products]);
        }else if($request->type=="shipper"){
            $res2=$csm->where("shipper_id",$request->userid)->where("status","1")->get();
            if(!empty($res2) && isset($res2[0])){
                $products=$pm->where("userid",$res2[0]->chef_id)->get();

                return response()->json(["products"=>$products]);
            }
        }
       
    }
    function retrieveProductDetails (Request $request){
        $pm=new ProductsModel();
        $product=$pm->where("product_id",$request->productId)->first();
        return response()->json(["product"=>$product]);
    }
    function deleteProducts(Request $request){
        $pm=new ProductsModel();
        $pm->where("product_id",$request->productId)->delete();
        return response()->json(["res"=>"succeed"]);
    }
}
 