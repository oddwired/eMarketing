@extends('layouts.app')
@section("title", "Home")
@section("content")
    <div class="container">
        <div class="col-md-offset-2 col-md-8">
            <div class="header">Find Products</div>
            <form action="{{url("search")}}" method="POST" role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    @if(isset($q))
                        <input type="text" class="form-control" name="q"
                               value="{{$q}}"> <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                            </span>

                    @else
                        <input type="text" class="form-control" name="q"
                                placeholder="Search products"> <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    @endif

                </div>
            </form>
            @if($products->count() == 0)
                <div>No products found</div>
            @endif
            @foreach($products as $product)
                <a href="{{url('product/'.$product->id)}}">
                    <div class="product">
                        <div class="product-photo col-md-3">
                            <img src="{{asset("img/".$product->photo)}}" alt=""
                                 width="150" height="150">
                        </div>
                        <div class="product-body col-md-8">
                            <div class="product-name">
                                {{$product->product_name}}
                            </div>
                            <label for="">Description:</label>
                            <div class="product-description">
                                {{$product->product_description}}
                            </div>
                            <div>
                                <label for="">Producer:</label>
                                {{$product->name}}
                            </div>
                            <div>
                                <label for="">Producer Location:</label>
                                {{$product->location}}
                            </div>
                            <label for="">Price: Ksh</label>
                            <span class="product-price">
                                {{$product->price}}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach

            <a href="{{url('producer/addproduct')}}">
                <div class="product" style="background-color: #eeeeee">
                    <div class="product-photo col-md-3">
                        <img src="{{asset("img/add_service.png")}}" alt=""
                             width="150" height="150">
                    </div>
                    <div class="product-body col-md-8" style="padding: 50px">
                        <div class="product-name">
                            Add your product here
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection