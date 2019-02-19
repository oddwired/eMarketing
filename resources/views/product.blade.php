@extends('layouts.app')
@section("title", "Producer")
@section("content")
    <div class="card container">
        <div class="card-title">{{$product->product_name}}</div>
        <div class="card-body row">

            <div class="col-md-5">
                <img src="{{asset('img/'.$product->photo)}}" alt="" width="400" height="400">

            </div>
            <div class="col-md-7">
                <div class="row">
                    <div class="header">Description</div>
                    <div>
                        {{$product->product_description}}
                    </div>
                </div>

                <div class="row">
                    <div class="header">Producer</div>
                    <div class="col-md-3">
                        <img src="{{url("img/".$product->dp)}}" alt="" width="100" height="100">
                    </div>
                    <div>
                        {{$product->name}}
                    </div>
                </div>

                <div class="row">
                    <div class="header">Producer location</div>
                    <div>
                        {{$product->location}}
                    </div>
                </div>

                <div class="row">
                    <div class="header">Producer contact</div>
                    <div>
                        <label for="">Email</label>
                        {{$product->email}}
                    </div>

                    <div>
                        <label for="">Phone</label>
                        {{$product->phone}}
                    </div>
                </div>
                <div class="row">
                    <div class="header">Product price</div>
                    <div>
                        <label for="">Ksh</label>
                        {{$product->price}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection