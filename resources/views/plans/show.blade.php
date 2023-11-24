@extends('layouts.master')
@section('css')
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <!-- Slect2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/sweet-alert/jquery.sweet-modal.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet" />

    <link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/wysiwyag/richtext.css" rel="stylesheet" />
    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sumoselect/sumoselect.css') }}    ">
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Plan Details</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/' . $page='#')}}"><i class="fe fe-home mr-2 fs-14"></i>Plan</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{url('/' . $page='#')}}">Details</a></li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
@push('styles')
<!-- INTERNAL Sumoselect css-->
<link rel="stylesheet" href="{{ asset('assets/plugins/sumoselect/sumoselect.css') }}    ">

  <!-- INTERNAL File Uploads css -->
<link href="{{ asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

<!-- INTERNAL File Uploads css-->
<link href="{{ asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
@endpush
    <style>
        .profile-upload {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 65px;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }
        .profile-upload i{
            font-size: 34px;
            color: #705ec8;
        }
        .img-container{
            position: relative;
            width: 17%;
        }
        .img-container:hover .profile-img {
            opacity: 0.3;
        }
        .img-container .profile-img {
            width: auto;
            height: 100%;
        }
        .img-container:hover .profile-upload {
            opacity: 1;
        }
        .profile-img {
            opacity: 1;
            display: block;
            transition: .5s ease;
            backface-visibility: hidden;
            max-height: 131px;
        }

    </style>
<!--/app header-->
<div class="main-proifle">
    <div class="row">
        <div class="col-lg-8">
            <div class="box-widget widget-user">
                <div class="widget-user-image1 d-sm-flex">
                    <div class="img-container">
                        <img alt="Plan Image" class="rounded-circle profile-img border p-2"
                             src="{{ asset($plan->image) }}">


                    </div>
                    <div class="mt-1 ml-lg-5">
                        <h4 class="pro-user-username mb-3 font-weight-bold">{{ $plan->name }} </h4>
                        <ul class="mb-0 pro-details">
                            <p class="mb-3"><strong>Details : </strong> {{ $plan->details }}</p>
                            <p class="mb-3"><strong>Period : </strong> {{ $plan->period }}</p>
                            <p class="mb-3"><strong>Price : </strong> {{ $plan->price }}</p>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row -->
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="border-0">
            <div class="tab-content">
                <div class="tab-pane active" id="myProfile">
                    <div class="card">
                        <form action="{{ route('plans.update',$plan->id) }}" method="POST" id="editProfile" enctype="multipart/form-data">
                        @csrf
                            <div class="card-header">
                                <div class="card-title">Edit Plan</div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-12 col-sm-12">
                                        <div class="input-box">
                                            <label class="input-label">Name</label>
                                            <input type="text" class="google-input" name="name" id="name" value="{{ $plan->name }}"  />
                                        </div>
                                        @error('name')
                                            <label id="name-error" class="error" for="name">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12 col-sm-12">
                                        <label class="form-label">image</label>
                                        <input type="file" class="dropify" name="image"
                                            data-default-file=""
                                            data-height="180" />
                                    </div>




                                    <div class="col-lg-12 col-sm-12">
                                        <div class="input-box">
                                            <label class="form-label">details<span class="text-danger"></span></label>
                                                <textarea class="content" name="details" id="details" value="{{ $plan->details }}">
                                                    {{ $plan->details }}
                                                </textarea>
                                            </div>


                                    @error('details')
                                    <label id="details-error" class="error" for="details">{{ $message }}</label>
                                @enderror
                                </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="input-box">
                                            <label class="input-label">Period</label>
                                            <input type="number" name="period" value="{{ $plan->period }}" class="google-input" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="input-box">
                                            <label class="input-label">Price</label>
                                            <input type="text" name="price" id="price" class="google-input" value="{{ $plan->price }}" >
                                        </div>
                                        @error('price')
                                            <label id="price-error" class="error" for="price">{{ $message }}</label>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
  <!--INTERNAL Sumoselect js-->
  <script src="{{ asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
  <script src="{{ asset('assets/js/formelementadvnced.js') }}"></script>

   <!-- INTERNAL File-Uploads Js-->
   <script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
   <script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
   <script src="{{ asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
   <script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
   <script src="{{ asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>

   <!-- INTERNAL File uploads js -->
   <script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
   <script src="{{ asset('assets/js/filupload.js') }}"></script>

   <!--INTERNAL Sumoselect js-->
   <script src="{{ asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

   <!--INTERNAL Form Advanced Element -->
   <script src="{{ asset('assets/js/formelementadvnced.js') }}"></script>
   <script src="{{ asset('assets/js/form-elements.js') }}"></script>
   <script src="{{ asset('assets/js/file-upload.js') }}"></script>

   <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/wysiwyag/jquery.richtext.js"></script>
<script>
    $(document).ready(function() {
        $("#ProfileUploadBtn").click(function(){
            $("#ProfileUpload").trigger('click');
        });
        $('#ProfileUpload').change(function(){
            $('#profileImageForm').submit()
        })
        $("#editProfile").validate({
            onkeyup: function(el, e) {
                $(el).valid();
            },
            // errorClass: "invalid-feedback is-invalid",
            // validClass: 'valid-feedback is-valid',
            ignore: ":hidden",
            rules: {
                name: {
                    required: true,
                    maxlength: 255,
                },
                username:{
                    required:true,
                    maxlength:255,
                },
                email:{
                  required:true,
                  email:true,
                  maxlength:255,
                },
                address:{
                    required:true,
                    maxlength: 500,
                },
                phone:{
                    required:true,
                    maxlength: 255,
                },
                website:{
                    required:true,
                    url: true,
                    maxlength: 255,
                }
            },
            messages: {
            },
            errorPlacement: function (error, element) {
                error.insertAfter($(element).parent());
            },
        });


    });

    $(function(e) {
	$('.content').richText();
	$('.content2').richText();
});
</script>
@endpush
