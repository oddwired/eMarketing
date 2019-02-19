@extends('layouts.base')
@section('title', "Producer Register")
@section("content")
<div class="container">
    <div class="card col-md-offset-3 col-md-6">
        <div class="card-title">Register</div>
        <div class="card-body">
            @if(count($errors) > 0)
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>
                @endforeach
            @endif
            <form action="" class="form" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" class="form-control" name="phone" required>
                </div>

                <div class="form-group">
                    <label for="">Location</label>
                    <input type="text" class="form-control" name="location" required>
                </div>

                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="password" class="form-control" name="confpassword" required>
                </div>

                <button class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection