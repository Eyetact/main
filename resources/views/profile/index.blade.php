@extends('layouts.master')
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Hi! Welcome Back</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/' . $page='#')}}"><i class="fe fe-home mr-2 fs-14"></i>Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{url('/' . $page='#')}}">Profile</a></li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
<!--/app header-->
<div class="main-proifle">
    <div class="row">
        <div class="col-lg-8">
            <div class="box-widget widget-user">
                <div class="widget-user-image1 d-sm-flex">
                    <img alt="User Avatar" class="rounded-circle border p-0" src="../../assets/images/users/2.jpg">
                    <div class="mt-1 ml-lg-5">
                        <h4 class="pro-user-username mb-3 font-weight-bold">{{ $user->name }} <i class="fa fa-check-circle text-success"></i></h4>
                        <ul class="mb-0 pro-details">
                            <li><span class="profile-icon"><i class="fe fe-mail"></i></span><span class="h6 mt-3">{{ $user->email }}</span></li>
                            <li><span class="profile-icon"><i class="fe fe-phone-call"></i></span><span class="h6 mt-3">{{ $user->phone }}</span></li>
                            <li><span class="profile-icon"><i class="fe fe-globe"></i></span><span class="h6 mt-3">{{ $user->website }}</span></li>
                            <li><span class="profile-icon"><i class="fa fa-location-arrow"></i></span><span class="h6 mt-3">{{ $user->address }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="profile-cover">
        <div class="wideget-user-tab">
            <div class="tab-menu-heading p-0">
                <div class="tabs-menu1 px-3">
                    <ul class="nav">
                        <li><a href="#myProfile" class="active fs-14" data-toggle="tab">My Profile</a></li>
                        <li><a href="#changePassword" class=" fs-14" data-toggle="tab">Change Password</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div><!-- /.profile-cover -->
</div>
<!-- Row -->
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="border-0">
            <div class="tab-content">
                <div class="tab-pane active" id="myProfile">
                    <div class="card">
                        <form action="{{ route('profile.update') }}" method="POST" id="editProfile">
                        @csrf
                            <div class="card-header">
                                <div class="card-title">Edit Profile</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" placeholder="First Name">
                                        </div>
                                        @error('name')
                                            <label id="name-error" class="error" for="name">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Username</label>
                                            <input type="text" name="username" class="form-control" id="Username" value="{{ $user->username }}" placeholder="Username">
                                        </div>
                                        @error('username')
                                        <label id="name-error" class="error" for="name">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Email address</label>
                                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Phone Number</label>
                                            <input type="number" name="phone" id="phone" class="form-control" value="{{ $user->phone }}" placeholder="Phone Number">
                                        </div>
                                        @error('phone')
                                            <label id="phone-error" class="error" for="phone">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" id="address" name="address" rows="1" placeholder="Address">{{ $user->address }}</textarea>
                                        </div>
                                        @error('address')
                                            <label id="address-error" class="error" for="address">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Website</label>
                                            <input type="text" id="website" name="website" class="form-control" value="{{ $user->website }}" placeholder="https://www.domainname.com/">
                                        </div>
                                        @error('website')
                                            <label id="website-error" class="error" for="website">{{ $message }}</label>
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
                <div class="tab-pane" id="changePassword">
                    <div class="card">
                        <form action="{{ route('profile.change-password') }}" method="POST" id="changePasswordForm">
                            @csrf
                            <div class="card-header">
                                <div class="card-title">Change Password</div>
                            </div>
                            <div class="card-body">
                                {{--                                <div class="card-title font-weight-bold">Basic info:</div>--}}
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">New Password</label>
                                            <input type="password" name="password" class="form-control" id="password" value="{{ $user->name }}" placeholder="New Password">
                                        </div>
                                        @error('name')
                                        <label id="name-error" class="error" for="name">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control" id="PasswordConfirmation" placeholder="Confirm Password">
                                        </div>
                                        @error('password_confirmation')
                                        <label id="name-error" class="error" for="name">{{ $message }}</label>
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
<script>
    $(document).ready(function() {
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

        $("#changePasswordForm").validate({
            ignore: ":hidden",
            rules: {
                password:{
                    required:true,
                    min:6,
                },
                password_confirmation:{
                    required:true,
                    min:6,
                    equalTo: "#password"
                }
            },
            messages: {
                password_confirmation:{
                    equalTo: "To create a valid password, both the password and confirm password field values must be matched."
                }
            },
        });
    });
</script>
@endpush
