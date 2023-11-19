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
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Admin</h4>
                </div>
                <div class="card-body">
                    @include('module_manager.admin_nested_menu')
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
                    <div class="content-inner">
                        <div id="storfront_edit_div" class="">
                            @include('module_manager.storfront_form')
                        </div>
                        <div id="admin_edit_div" class="">
                            @include('module_manager.admin_form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

{{-- import model start --}}
@include('module_manager.menu_item_model')
{{-- import model end --}}

@section('js')
<script src="{{asset('assets/js/storfront_nestable.js')}}"></script>
<script src="{{asset('assets/js/admin_nestable.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $(document).ready(function(){
        $("#storfront_div").hide();
        $("#admin_div").hide();

        $("#storfront_edit_div").hide();
        $("#admin_edit_div").hide();

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

        $('#storfront_nestable').on('mousedown', '.dd-handle', function(event) {
            var type = 'storfront_form';

            $("#storfront_edit_div").show();
            $("#admin_edit_div").hide();

            var singleData = $(this).parent().data("json");

            $("#storfront_form #sname").val(singleData.name);
            $("#storfront_form #scode").val(singleData.code);
            $("#storfront_form #spath").val(singleData.path);
            $("#storfront_form #sis_enable").prop('checked', singleData.status);
            $("#storfront_form #sinclude_in_menu").prop('checked', singleData.include_in_menu);
            $("#storfront_form #smeta_title").val(singleData.meta_title);
            $("#storfront_form #smeta_description").val(singleData.meta_description);
            $("#storfront_form #screated_date").val(singleData.created_date);
            $("#storfront_form #sassigned_attributes").val(singleData.assigned_attributes);
        });

        $('#admin_nestable').on('mousedown', '.dd-handle', function(event) {
            var type = 'admin_form';

            $("#admin_edit_div").show();
            $("#storfront_edit_div").hide();

            var singleData = $(this).parent().data("json");
            console.log("PMD",singleData)

            $("#admin_form #aname").val(singleData.name);
            $("#admin_form #acode").val(singleData.code);
            $("#admin_form #apath").val(singleData.path);
            $("#admin_form #ais_enable").prop('checked', singleData.status);
            $("#admin_form #ainclude_in_menu").prop('checked', singleData.include_in_menu);
            $("#admin_form #acreated_date").val(singleData.created_date);
            $("#admin_form #aassigned_attributes").val(singleData.assigned_attributes);
        });

        $('body').on('change', '.storfront_nested_form .nestable', function() {
            var menu = $("#storfront_menu_list");
            var jsonResult = convertMenuToJson(menu,'storfront-menu');

            $("#storfront_json").text(JSON.stringify(jsonResult, null, 2));

            var data = {
                type:"storfront",
                storfront_json : JSON.stringify(jsonResult, null, 2)
            }
            saveMenu(data);
        });

        $('body').on('change', '.admin_nested_form .nestable', function() {
            var menu = $("#admin_menu_list");
            var jsonResult = convertMenuToJson(menu,'admin-menu');

            $("#admin_json").text(JSON.stringify(jsonResult, null, 2));
            var data = {
                type:"",
                admin_json : JSON.stringify(jsonResult, null, 2)
            }
            saveMenu(data);
        });

        function saveMenu(menuData){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ route("module_manager.menu_update") }}',
                type: 'POST',
                data: menuData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    // if (response.success) {
                    //     alert('Menu change successfully.');
                    // }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

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



@endsection
