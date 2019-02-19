<?php

namespace Emarketing\Http\Controllers;

use Emarketing\Producer;
use Emarketing\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProducerController extends Controller
{
    public function index(){
        $producer = Auth::guard("producer")->user();

        $products = Product::where('producer_id', $producer->id)->where("deleted", false)->get();
        return view("producer", ["producer"=>$producer, "products"=> $products]);
    }

    private function uploadPhoto(Request $request){
        // dd($request);
        //return $request->cropped;
        //$image = $request->cropped;

        $image_name= md5(time().rand()).'.png';

        $request->cropped->move(public_path('img/'), $image_name);


        return $image_name;
    }

    public function changePhoto(Request $request){
        $user = Producer::where('id', Auth::guard("producer")->id())->first();
        /*if($request->has('cropped')){


            return;
        }*/

        $user->photo = $this->uploadPhoto($request);
        $user->save();

        return;
    }

    public function getProducts(){

    }
}
