<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", "ProductController@index");
Route::any("search", "ProductController@search");
Route::get("product/{id}", "ProductController@getProduct");

Route::post("logout", function (){
    Auth::guard("producer")->logout();
    Auth::guard("admin")->logout();

    return redirect(url("/"));
});

/* Producer Routes */

Route::group(["prefix"=>"producer"], function (){

    Route::get("login", function (){

        if(Auth::guard("producer")->check())
            return redirect(url("producer"));

        return view("producer_login");
    });

    Route::post("login", "AuthController@login");

    Route::get("register", function(){
        return view("producer_register");
    });

    Route::post("register", "AuthController@register");

    Route::group(["middleware"=>["producer"]], function(){
        Route::get("/", "ProducerController@index");
        Route::get("addproduct", function (){
            return view("add_product");
        });

        Route::post("changedp", "ProducerController@changePhoto");
        Route::post("addproduct", "ProductController@addProduct");
        Route::post("addproductphoto", "PhotoHandler@addPhoto");

        Route::get("editproduct/{id}", "ProductController@editProductIndex");
        Route::post("editproduct/{id}", "ProductController@editProduct");
        Route::get("deleteproduct/{id}", "ProductController@deleteProduct");
    });
});

/* Admin Routes */

Route::group(["prefix"=> "admin"], function(){
    Route::get("login", function (){
        return view("admin_login");
    });

    Route::post("login", "AuthController@adminLogin");

    Route::group(["middleware"=>["admin"]], function (){
        Route::get("/", "AdminController@index");
    });
});