<!-- https://codepen.io/Gobi_Ilai/pen/LLQdqJ -->
@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/nested_menu.css')}}">
@endsection
@section('page-header')
	<!--Page header-->
	<div class="page-header">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">Modules</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#"><i class="fe fe-file-text mr-2 fs-14"></i>Settings</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#">Add Modules</a></li>
			</ol>
		</div>
	</div>
    <!--End Page header-->
@endsection
@section('content')
@php
    $storfrontMenu=\App\Helpers\Helper::getMenu('storfront');
    // dump($storfrontMenu);
@endphp

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="col-lg-6 col-xl-6">
                                <div class="mb-0 mb-lg-0">
                                    <div class="card-body p-0">
                                        <div class="main-content-left main-content-left-chat">
                                            <div class="p-4 pb-0 border-bottom"></div>

                                            <div class="main-chat-contacts-wrapper">
                                                <label class="form-label mb-2 fs-13">Storfront</label>
                                                @include('module.storfront_nested_menu')
                                            </div>

                                            {{-- <div class="p-4 pb-0 border-bottom"></div> --}}
                                            <div class="main-chat-contacts-wrapper">
                                                <label class="form-label mb-2 fs-13">Admin</label>
                                                @include('module.admin_nested_menu')

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
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
                                                    <form action="{{ $menu->id == null ? route('menu.store') : route('menu.update', ['menu' => $menu->id]) }}" id="storfront_form" method="POST" autocomplete="off" novalidate="novalidate">
                                                        @csrf
                                                        <input type="hidden" name="menu_type" value="storfront">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h3 class="card-title">Storfront</h3>
                                                                        &nbsp &nbsp
                                                                        <span id="currentEditName"></span>
                                                                    </div>
                                                                    <div class="card-body pb-2">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 form-group">
                                                                                <label class="form-label" for="module">Module<span class="text-red">*</span></label>
                                                                                <select name="module" class="form-control module" id="module">
                                                                                    <option value="" selected>Select Module</option>
                                                                                    @foreach($moduleData as $module)
                                                                                        <option value="{{$module->id}}" >{{$module->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-sm-12 form-group">
                                                                                <label class="form-label" for="name">Name <span class="text-red">*</span></label>
                                                                                <input type="text" name="name" class="form-control" value="">
                                                                            </div>
                                                                            <div class="col-sm-12 form-group">
                                                                                <label class="form-label" for="code">Code <span class="text-red">*</span></label>
                                                                                <input type="text" name="code" class="form-control" value="">
                                                                            </div>
                                                                            <div class="col-sm-12 form-group">
                                                                                <label class="form-label" for="path">Path <span class="text-red">*</span></label>
                                                                                <input type="text" name="path" class="form-control" value="">
                                                                            </div>
                                                                            <div class="form-group col-sm-6">
                                                                                <label class="custom-switch form-label">
                                                                                    <input type="checkbox" name="is_enable" class="custom-switch-input" id="is_enable" >
                                                                                    <span class="custom-switch-indicator"></span>
                                                                                    <span class="custom-switch-description">Status</span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-group col-sm-6">
                                                                                <label class="custom-switch form-label">
                                                                                    <input type="checkbox" name="include_in_menu" class="custom-switch-input" id="is_enable" >
                                                                                    <span class="custom-switch-indicator"></span>
                                                                                    <span class="custom-switch-description">Include in menu</span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-sm-12 form-group">
                                                                                <label class="form-label" for="meta_title">Meta Title</label>
                                                                                <input type="text" name="meta_title" class="form-control" value="">
                                                                            </div>
                                                                            <div class="form-group col-sm-12">
                                                                                <label class="form-label" for="meta_description">Meta Description</label>
                                                                                <textarea class="form-control" name="meta_description" autocomplete="off" id="description" rows="2"></textarea>
                                                                            </div>
                                                                            <div class="col-sm-12 form-group">
                                                                                <label class="form-label" for="created_date">Created Date</label>
                                                                                <input type="date" name="created_date" class="form-control" value="">
                                                                            </div>
                                                                            <div class="form-group col-sm-12">
                                                                                <label class="form-label" for="assigned_attributes">Assigned Attributes</label>
                                                                                <textarea class="form-control" name="assigned_attributes" autocomplete="off" id="description" rows="2"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-footer text-right">
                                                                        <input title="Save module" class="btn btn-primary" type="submit" value="Create">
                                                                        <input title="Reset form" class="btn btn-warning" type="reset" value="Reset">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div id="admin_div" class="hide">
                                                    aaaa
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


		</div>
	</div><!-- end app-content-->
</div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $("#storfront_save").click(function(e){
            var menu = $("#storfront_menu_list");
            var jsonResult = convertMenuToJson(menu,'storfront-menu');
            $("#storfront_json").text(JSON.stringify(jsonResult, null, 2));

            $("#storfront_form").submit();
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
    function convertMenuToJson(menu,includeClass, parentModuleId = null){
        var result = [];
        menu.children("li").each(function(index) {
            var menuItem = $(this).find('.' + includeClass);

            var moduleId=menuItem.val();
            var sequence = index;
            // if(index > 0){
            //     sequence = (index-1) + 1;
            // }
            console.log(index,sequence);
            var jsonItem = {
                module: moduleId,
                parent_module_id: parentModuleId,
                sequence: sequence,
            };

            var subMenu = $(this).children("ol");
            if (subMenu.length > 0) {
                jsonItem.children = convertMenuToJson(subMenu, includeClass, moduleId);
            }
            result.push(jsonItem);
        });

        return result;
    }
</script>


<script src="{{asset('assets/js/storfront_nestable.js')}}"></script>
<script src="{{asset('assets/js/admin_nestable.js')}}"></script>
@endsection
