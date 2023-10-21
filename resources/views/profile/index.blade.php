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
{{--        <div class="page-rightheader">--}}
{{--            <div class="btn btn-list">--}}
{{--                <a href="{{url('/' . $page='#')}}" class="btn btn-info"><i class="fe fe-settings mr-1"></i> General Settings </a>--}}
{{--                <a href="{{url('/' . $page='#')}}" class="btn btn-danger"><i class="fe fe-printer mr-1"></i> Print </a>--}}
{{--                <a href="{{url('/' . $page='#')}}" class="btn btn-warning"><i class="fe fe-shopping-cart mr-1"></i> Buy Now </a>--}}
{{--            </div>--}}
{{--        </div>--}}
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
{{--        <div class="col-lg-4 col-md-auto">--}}
{{--            <div class="text-lg-right btn-list mt-4 mt-lg-0">--}}
{{--                <a href="#" class="btn btn-light">Message</a>--}}
{{--                <a href="#" class="btn btn-primary">Edit Profile</a>--}}
{{--            </div>--}}
{{--            <div class="mt-5">--}}
{{--                <div class="main-profile-contact-list row">--}}
{{--                    <div class="media col-sm-4">--}}
{{--                        <div class="media-icon bg-primary text-white mr-3 mt-1">--}}
{{--                            <i class="fa fa-comments fs-18"></i>--}}
{{--                        </div>--}}
{{--                        <div class="media-body">--}}
{{--                            <small class="text-muted">Posts</small>--}}
{{--                            <div class="font-weight-bold number-font">--}}
{{--                                245--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="media col-sm-4">--}}
{{--                        <div class="media-icon bg-secondary text-white mr-3 mt-1">--}}
{{--                            <i class="fa fa-users fs-18"></i>--}}
{{--                        </div>--}}
{{--                        <div class="media-body">--}}
{{--                            <small class="text-muted">Followers</small>--}}
{{--                            <div class="font-weight-normal1">--}}
{{--                                689k--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="media col-sm-4">--}}
{{--                        <div class="media-icon bg-info text-white mr-3 mt-1">--}}
{{--                            <i class="fa fa-feed fs-18"></i>--}}
{{--                        </div>--}}
{{--                        <div class="media-body">--}}
{{--                            <small class="text-muted">Following</small>--}}
{{--                            <div class="font-weight-bold number-font">--}}
{{--                                3,765--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
    <div class="profile-cover">
        <div class="wideget-user-tab">
            <div class="tab-menu-heading p-0">
                <div class="tabs-menu1 px-3">
                    <ul class="nav">
                        <li><a href="#myProfile" class="active fs-14" data-toggle="tab">My Profile</a></li>
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
{{--                                <div class="card-title font-weight-bold">Basic info:</div>--}}
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
                                            <label class="form-label">Email address</label>
                                            <input type="email" disabled value="{{ $user->email }}" class="form-control" placeholder="Email">
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
</script>
@endpush
