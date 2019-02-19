<?php

namespace Emarketing\Http\Controllers;

use Emarketing\Producer;
use Emarketing\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(){
        $products = DB::table("products as p")
            ->select("p.*", "u.name", "u.location")
            ->where("p.deleted", false)
            ->join("producers as u", "u.id", "=", "p.producer_id")
            ->get();

        return view("home", ["products"=> $products]);
    }

    public function search(Request $request){
        if(!$request->has("q")){
            return redirect(url("/"));
        }
        $this->q = $request->q;

        $products = Product::where(function($query){
            $query->where('product_name', 'LIKE', '%'.$this->q.'%')
                ->orWhere('product_description', 'LIKE', '%'.$this->q.'%');
        })
            ->where("deleted", false)
            ->get();
        return view("home", ["products"=> $products, "q" => $request->q]);
    }

    public function addProduct(Request $request){
        $this->validate($request, [
            'name'=> 'required',
            'description'=> 'required',
            'price'=> 'required',
            'imagename'=> 'required'
        ]);

        $details = [
            'product_name' => $request->name,
            'product_description'=> $request->description,
            'price'=> $request->price,
            'photo'=> $request->imagename,
            'producer_id' => Auth::guard('producer')->id()
        ];

        if(is_null(Product::create($details))){
            return redirect(url('producer/addproduct'))->withErrors(['error'=> 'An error occured. Please try again!']);
        }

        return redirect('producer');
    }

    public function getProduct(Request $request){
        $product = DB::table("products as p")
            ->select("p.*", "u.name", "u.location", "u.email", "u.phone", "u.photo as dp")
            ->where('p.id', $request->id)
            ->where("p.deleted", false)
            ->join("producers as u", "u.id", "=", "p.producer_id")
            ->first();

        return view("product",["product"=>$product]);
    }

    public function editProductIndex(Request $request){
        $product = Product::where('id', $request->id)->first();

        return view("edit_product", ["product"=>$product]);
    }

    public function editProduct(Request $request){
        $this->validate($request, [
            'name'=> 'required',
            'description'=> 'required',
            'price'=> 'required',
        ]);
        $product = Product::where('id', $request->id)->first();
        $product->product_name = $request->name;
        $product->product_description = $request->description;
        $product->price = $request->price;

        if($request->has('imagename'))
            $product->photo = $request->imagename;

        $product->save();

        return redirect(url("producer"));
    }

    public function deleteProduct(Request $request){
        Product::where('id', $request->id)->update([
            "deleted"=> true
        ]);

        return redirect(url("producer"));
    }

}
