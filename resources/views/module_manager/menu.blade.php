<!-- https://codepen.io/Gobi_Ilai/pen/LLQdqJ -->
@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/nested_menu.css')}}">
@endsection

@section('page-header')
	<div class="page-header">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">Modules</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#"><i class="fe fe-file-text mr-2 fs-14"></i>Settings</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#">Add Modules</a></li>
			</ol>
		</div>
	</div>
@endsection

@section('content')
    @php
        $storfrontMenu=\App\Helpers\Helper::getMenu('storfront');
        $adminMenu=\App\Helpers\Helper::getMenu('admin');
    @endphp

    <div class="row" style= "display :none">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="row no-gutters">
                    <div class="col-lg-6 col-xl-6">
                        <div class="mb-0 mb-lg-0">
                            <div class="card-body p-0">
                                <div class="main-content-left main-content-left-chat">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Storfront</h3>
                                        </div>
                                        <div class="card-body">

                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Admin</h3>
                                        </div>
                                        <div class="card-body">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Menu Item</h3>
                            </div>
                            <div class="card-body">
                                @include('module_manager.storfront_nested_menu')
                            </div>
                        </div>

                        <div class="border-left">
                            <div class="main-content-body main-content-body-chat">
                                <div class="main-chat-header">
                                    <ul>
                                        <li class="slide">
                                            <a class="side-menu__item" data-toggle="slide" href="">
                                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"></path></svg>
                                            <span class="side-menu__label">&nbsp;Menu Item</span>&nbsp;&nbsp;&nbsp;&nbsp;<i class="angle fa fa-angle-right"></i></a>
                                            <ul class="slide-menu">
                                                <li><a href="javascript:void(0)" class="slide-item" id="storfront_li">Storfront</a></li>
                                                <li><a href="javascript:void(0)" class="slide-item" id="admin_li">Admin</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="main-chat-body ps ps--active-y" id="ChatBody">
                                    <div class="content-inner">
                                        <div id="storfront_div">
                                            @include('module.storfront_form')
                                        </div>
                                        <div id="admin_div" class="hide">
                                            @include('module.admin_form')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xl-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Storfront</h4>
                </div>
                <div class="card-body">
                    @include('module_manager.storfront_nested_menu')
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Menu Item</h4>
                    <div class="card-options">
                        <button type="button" data-target="#largeModal" data-toggle="modal" class="btn btn-primary">Action</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="main-chat-header">
                        <ul>
                            <li class="slide">
                                <a class="side-menu__item" data-toggle="slide" href="">
                                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"></path></svg>
                                <span class="side-menu__label">&nbsp;Menu Item</span>&nbsp;&nbsp;&nbsp;&nbsp;<i class="angle fa fa-angle-right"></i></a>
                                <ul class="slide-menu">
                                    <li><a href="javascript:void(0)" class="slide-item" id="storfront_li">Storfront</a></li>
                                    <li><a href="javascript:void(0)" class="slide-item" id="admin_li">Admin</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="content-inner">
                        <div id="storfront_div">
                            @include('module_manager.storfront_form')
                        </div>
                        <div id="admin_div" class="hide">
                            @include('module_manager.admin_form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xl-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Admin</h4>
                </div>
                <div class="card-body">
                    @include('module.admin_nested_menu')
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- import model start --}}
{{-- @include('module_manager.menu_item_model') --}}
<div id="largeModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pd-x-20">
                <h6 class="modal-title">Message Preview</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pd-20">
                    <div class="form-group row">
                        <label for="inputName" class="col-md-3 form-label">Module Type</label>
                        <div class="col-md-9">
                            <select name="type" class="form-control custom-select select2" id="module_type">
                                <option value="">Select</option>
                                <option value="storfront">Storfront</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <form class="form-horizontal">
                        <div id="storfront_div">
                            @include('module_manager.storfront_form')
                        </div>
                        <div id="admin_div">
                            @include('module_manager.admin_form')
                        </div>

                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
{{-- import model end --}}

@section('js')
<script>
    $(document).ready(function(){
        $("#storfront_div").hide();
        $("#admin_div").hide();

        $('body').on('change', '#module_type', function() {
            console.log($(this).val())
            if($(this).val() == "storfront"){
                $("#admin_div").hide();
                $("#storfront_div").show();
            }else if($(this).val() == "admin"){
                $("#storfront_div").hide();
                $("#admin_div").show();
            }else{
                $("#storfront_div").hide();
                $("#admin_div").hide();
            }
        });

        $('#storfront_form').validate({
            rules: {
                name: {
                    required: true,
                },
                code: {
                    required: true,
                },
                path: {
                    required: true,
                },
                created_date: {
                    required: true,
                },
                assigned_attributes: {
                    required: true,
                }
            }
        });

        $('#admin_form').validate({
            rules: {
                module: {
                    required: true,
                },
                name: {
                    required: true,
                },
                code: {
                    required: true,
                },
                path: {
                    required: true,
                },
                created_date: {
                    required: true,
                },
                assigned_attributes: {
                    required: true,
                }
            }
        });
        $("#storfront_save").click(function(e){
            var menu = $("#storfront_menu_list");
            var jsonResult = convertMenuToJson(menu,'storfront-menu');
            $("#storfront_json").text(JSON.stringify(jsonResult, null, 2));

            $("#storfront_nested_form").submit();
        });

        $("#admin_save").click(function(e){
            var menu = $("#admin_menu_list");
            var jsonResult = convertMenuToJson(menu,'admin-menu');
            $("#admin_json").text(JSON.stringify(jsonResult, null, 2));

            $("#admin_nested_form").submit();
        });

        $("#storfront_li").click(function(){
            $("#admin_div").hide();
            $("#storfront_div").show();
        });

        $("#admin_li").click(function(){
            $("#storfront_div").hide();
            $("#admin_div").show();
        });
    });
    function convertMenuToJson(menu,includeClass, parentId = 0){
        var result = [];
        menu.children("li").each(function(index) {
            var menuItem = $(this).find('.' + includeClass);
            var id=menuItem.val();
            var sequence = index;

            var jsonItem = {
                id: id,
                parent: parentId,
                sequence: sequence,
            };

            var subMenu = $(this).children("ol");
            if (subMenu.length > 0) {
                jsonItem.children = convertMenuToJson(subMenu, includeClass, id);
            }
            result.push(jsonItem);
        });

        return result;
    }

</script>


<script src="{{asset('assets/js/storfront_nestable.js')}}"></script>
<script src="{{asset('assets/js/admin_nestable.js')}}"></script>
@endsection
