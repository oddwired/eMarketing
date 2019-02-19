@extends('layouts.app')
@section('title', "Producer Login")
@section('csscontent')
    <link href="{{ asset('css/jquery.Jcrop.min.css') }}" rel="stylesheet">
@endsection
@section("content")
    <div class="container">
        <div class="card col-md-offset-3 col-md-6">
            <div class="card-title">Edit Product</div>
            <div class="card-body">
                @if(count($errors) > 0)
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{$error}}
                        </div>
                    @endforeach
                @endif

                <form action="" id="form" class="form" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="">Product Name</label>
                        <input type="text" class="form-control" name="name" value="{{$product->product_name}}" required>
                    </div>

                    <div class="form-group">
                        <label for="">Product Description</label>
                        <textarea name="description" class="form-control" required>{{$product->product_description}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Select a photo</label>
                        <input id="file" type="file" name="photo" /><br>
                        <div id="views">
                            <img src="{{url("img/".$product->photo)}}" alt="" height="200" width="200">
                        </div>
                        <br>
                        <button id="cropbutton" class="btn btn-default" type="button">Crop</button>
                    </div>

                    <div class="form-group">
                        <label for="">Price</label>
                        <input type="number" class="form-control" name="price" value="{{$product->price}}" required>
                    </div>

                    <button type="button" onclick="submitForm()" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('jscontent')
    <script src="{{ asset('js/jquery.Jcrop.min.js') }}"></script>
    <script>
        var crop_max_width = 300;
        var crop_max_height = 300;
        var jcrop_api;
        var canvas;
        var context;
        var image;

        var prefsize;

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

        $("#file").change(function() {
            loadImage(this);
        });

        function loadImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                canvas = null;
                reader.onload = function(e) {
                    image = new Image();
                    image.onload = validateImage;
                    image.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function dataURLtoBlob(dataURL) {
            var BASE64_MARKER = ';base64,';
            if (dataURL.indexOf(BASE64_MARKER) == -1) {
                var parts = dataURL.split(',');
                var contentType = parts[0].split(':')[1];
                var raw = decodeURIComponent(parts[1]);

                return new Blob([raw], {
                    type: contentType
                });
            }
            var parts = dataURL.split(BASE64_MARKER);
            var contentType = parts[0].split(':')[1];
            var raw = window.atob(parts[1]);
            var rawLength = raw.length;
            var uInt8Array = new Uint8Array(rawLength);
            for (var i = 0; i < rawLength; ++i) {
                uInt8Array[i] = raw.charCodeAt(i);
            }

            return new Blob([uInt8Array], {
                type: contentType
            });
        }

        function validateImage() {
            if (canvas != null) {
                image = new Image();
                image.onload = restartJcrop;
                image.src = canvas.toDataURL('image/png');
            } else restartJcrop();
        }

        function restartJcrop() {
            if (jcrop_api != null) {
                jcrop_api.destroy();
            }
            $("#views").empty();
            $("#views").append("<canvas id=\"canvas\">");
            canvas = $("#canvas")[0];
            context = canvas.getContext("2d");
            canvas.width = image.width;
            canvas.height = image.height;
            context.drawImage(image, 0, 0);
            $("#canvas").Jcrop({
                onSelect: selectcanvas,
                onRelease: clearcanvas,
                boxWidth: crop_max_width,
                boxHeight: crop_max_height,
                aspectRatio: 1
            }, function() {
                jcrop_api = this;
            });
            clearcanvas();
        }

        function clearcanvas() {
            prefsize = {
                x: 0,
                y: 0,
                w: canvas.width,
                h: canvas.height,
            };
        }

        function selectcanvas(coords) {
            prefsize = {
                x: Math.round(coords.x),
                y: Math.round(coords.y),
                w: Math.round(coords.w),
                h: Math.round(coords.h)
            };
        }

        function applyCrop() {
            canvas.width = prefsize.w;
            canvas.height = prefsize.h;
            context.drawImage(image, prefsize.x, prefsize.y, prefsize.w, prefsize.h, 0, 0, canvas.width, canvas.height);
            validateImage();
        }

        $("#cropbutton").click(function(e) {
            applyCrop();
        });

        function submitForm() {

            if(canvas === undefined)
                $('#form').submit();

            var blob = dataURLtoBlob(canvas.toDataURL('image/png'));
            var formData = new FormData();
            var file = new File([blob], "cropped.png");
            formData.append("cropped", file);
            $.ajax({
                url: "{{url('producer/addproductphoto')}}",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    //alert("Success");
                },
                error: function(data) {
                    alert("Error");
                },
                complete: function(data) {
                    var imagename = JSON.parse(data.responseText).imagename;

                    $('#file').remove();
                    $('<input />').attr('type', 'hidden')
                        .attr('name', "imagename")
                        .attr('value', imagename)
                        .appendTo('#form');


                    $('#form').submit();
                }
            });

        }
    </script>
@endsection