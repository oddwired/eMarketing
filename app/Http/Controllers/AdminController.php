<?php

namespace Emarketing\Http\Controllers;

use Emarketing\Producer;
use Emarketing\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $producers = Producer::where("deleted", false)->get();
        $products = Product::where("deleted", false)->get();

        return view("admin", ["producers"=>$producers, "products"=>$products]);
    }

    public function deleteProducer(Request $request){
        Producer::where('id', $request->id)->update([
            "deleted"=>true
        ]);

        return redirect(url("admin"));
    }

    public function deleteProduct(Request $request){
        Product::where('id', $request->id)->update([
            "deleted"=>true
        ]);

        return redirect(url("admin"));
    }
}
