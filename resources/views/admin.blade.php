@extends('layouts.app')
@section("title", "Admin")
@section("content")
    <div class="container">
        <div class="row">
            <div class="card col-md-offset-2 col-md-8">
                <div class="card-title">Producers</div>
                <div class="card-body">
                    <table id="table1" class="table">
                        <thead>
                            <tr>
                                <th>photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($producers as $producer)
                                <tr>
                                    <td>
                                        <img src="{{url("img/".$producer->photo)}}" alt="" width="70" height="70">
                                    </td>
                                    <td>{{$producer->name}}</td>
                                    <td>{{$producer->email}}</td>
                                    <td>{{$producer->phone}}</td>
                                    <td>{{$producer->location}}</td>
                                    <td><a href="#" class="btn btn-danger">Delete</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="row">

            <div class="card col-md-offset-2 col-md-8">
                <div class="card-title">Products</div>
                <div class="card-body">
                    <table id="table2" class="table">
                        <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>price</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <img src="{{url("img/".$product->photo)}}" alt="" width="70" height="70">
                                </td>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->price}}</td>
                                <td>
                                    <a href="#" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("jscontent")
    <script>
        $(document).ready(function(){
            $("#table1.table").dataTable();
            $("#table2.table").dataTable();
        });
    </script>
@endsection
