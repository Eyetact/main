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

    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sumoselect/sumoselect.css') }}    ">
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">add Users</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Users</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('smtp.index') }}">add</a></li>
            </ol>
        </div>
        <div class="page-rightheader">
            <div class="btn btn-list">
                {{--                <a href="{{ route('smtp.create') }}" class="btn btn-info" title="" data-original-title="Add new"><i class="fe fe-plus mr-1"></i> Add Swift Mailer </a> --}}
            </div>
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
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">add User</h3>
        </div>
        <div class="card-body pb-2">
            <form action="{{ route('users.store') }}" method="POST" id="mailboxForm" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="role" value="vendor"/>
                <div class="row">

                    <div class="col-lg-12 col-sm-12">
                        <label class="form-label">avatar</label>
                        <input type="file" class="dropify" name="avatar"
                            data-default-file=""
                            data-height="180" />
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="name" class="input-label">Name</label>
                            <input type="text" class="google-input" name="name" id="name" value="" />
                        </div>
                        @error('name')
                            <label id="name-error" class="error" for="name">{{ $message }}</label>
                        @enderror
                    </div>


                    <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="username" class="input-label">username</label>
                            <input type="text" class="google-input" name="username" id="username" value="" />
                        </div>
                        @error('username')
                            <label id="username-error" class="error" for="username">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="email" class="input-label">email</label>
                            <input type="email" class="google-input" name="email" id="email" value="" />
                        </div>
                        @error('email')
                            <label id="email-error" class="error" for="email">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="phone" class="input-label">phone</label>
                            <input type="text" class="google-input" name="phone" id="phone" value="" />
                        </div>
                        @error('phone')
                            <label id="phone-error" class="error" for="phone">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="address" class="input-label">address</label>
                            <input type="text" class="google-input" name="address" id="address" value="" />
                        </div>
                        @error('address')
                            <label id="address-error" class="error" for="address">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="website" class="input-label">website</label>
                            <input type="text" class="google-input" name="website" id="website" value="" />
                        </div>
                        @error('website')
                            <label id="website-error" class="error" for="website">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="name" class="input-label">password</label>
                            <input type="password" class="google-input" name="password" id="password" value="" />
                        </div>
                        @error('password')
                            <label id="password-error" class="error" for="password">{{ $message }}</label>
                        @enderror
                    </div>
                </div>



                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="{{ route('main_mailbox.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
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

    <script type="text/javascript">
        // $(document).ready(function() {
        $("#mailboxForm").validate({
            onkeyup: function(el, e) {
                $(el).valid();
            },
            // errorClass: "invalid-feedback is-invalid",
            // validClass: 'valid-feedback is-valid',
            ignore: ":hidden",
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                password: {
                    required: true,
                }
                
            },
            messages: {},
            errorPlacement: function(error, element) {
                error.insertAfter($(element).parent());
            },
        });

        $("input[type='text'], input[type='number'], input[type='password'], input[type='email'], input[type='tel']").on(
            "keyup",
            function() {
                var $input = $(this);
                if ($input.val() != '') {
                    $input.parents(".input-box").addClass("focus");
                } else {
                    $input.parents(".input-box").removeClass("focus");
                }
            });
        $("input[type='text'], input[type='number'], input[type='password'], input[type='email'], input[type='tel']").each(
            function(index, element) {
                var value = $(element).val();
                if (value != '') {
                    $(this).parents('.input-box').addClass('focus');
                } else {
                    $(this).parents('.input-box').removeClass('focus');
                }
            });
        // });
    </script>
@endpush
