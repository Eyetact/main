<!-- https://codepen.io/Gobi_Ilai/pen/LLQdqJ -->
@extends('layouts.master')
<style>
    /* Add your styles for the selected item here */
    .selected-item {
        background-color: #ffeeba !important;
        /* Change this to the desired color */
        color: #856404 !important;
        /* Change this to the desired text color */
    }

    .tag-deleted {
        float: right;
        margin: -3px -10px 0 0;
    }

    .modal-xl {
        max-width: 1140px !important;
    }

    .attr_header {
        width: 100% !important;
    }

    #attr_tbl {
        cursor: move;
    }
</style>
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/nested_menu.css') }}">

    <link href="{{ URL::asset('assets/plugins/sweet-alert/jquery.sweet-modal.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
        $storfrontMenu = \App\Helpers\Helper::getMenu('storfront');
        $adminMenu = \App\Helpers\Helper::getMenu('admin');
    @endphp

    <div class="row">
        <div class="col-lg-12 col-xl-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Storfront</h4>
                </div>
                {{-- @dump($errors->all()) --}}
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
                        <button type="button" data-target="#addMenuModal" data-toggle="modal"
                            class="btn btn-primary">Action</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="content-inner">
                        <div id="storfront_edit_div" class="">
                            <form action="{{ route('module_manager.store') }}" id="storfront_form_edit" method="POST"
                                autocomplete="off" novalidate="novalidate">
                                @include('module_manager.storfront_form')
                            </form>
                        </div>
                        <div id="admin_edit_div" class="">
                            <form action="{{ route('module_manager.store') }}" id="admin_form_edit" method="POST"
                                autocomplete="off" novalidate="novalidate">
                                @include('module_manager.admin_form')
                            </form>
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
    <script src="{{ asset('assets/js/storfront_nestable.js') }}"></script>
    <script src="{{ asset('assets/js/admin_nestable.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- INTERNAL Sweet alert js -->
    <script src="{{ URL::asset('assets/plugins/sweet-alert/jquery.sweet-modal.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/sweet-alert.js') }}"></script>
    <script src="//code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            // console.log($(".storfront_nested_form").find('li:first').find('.dd-handle:first'));
            // $(".storfront_nested_form").find('li:first').find('.dd-handle:first').trigger('mousedown');

            $('#storfront_form_edit').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting the traditional way

                // Serialize the form data
                var formData = $(this).serialize();

                var edit_sid = $(this).find('#sid').val();
                // Send an AJAX request
                $.ajax({
                    type: 'POST',
                    url: '{{ route('module_manager.update') }}' + '/' +
                    edit_sid, // Replace with your actual route
                    data: formData,
                    success: function(response) {
                        // Handle the success response
                        console.log('AJAX request succeeded:', response);
                        $('#addMenuModal').modal(
                        'hide'); // Hide the modal after successful submission
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error('AJAX request failed:', status, error);

                        if (xhr.status === 422) {
                            // If it's a validation error, display the errors in the modal
                            var errors = xhr.responseJSON.errors;
                            displayValidationErrors(errors);
                        } else {
                            // Handle other types of errors as needed
                            alert('An unexpected error occurred. Please try again.');
                        }
                    }
                });
            });

            $('#storfront_form').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting the traditional way

                // Serialize the form data
                var formData = $(this).serialize();

                // Send an AJAX request
                $.ajax({
                    type: 'POST',
                    url: '{{ route('module_manager.store') }}', // Replace with your actual route
                    data: formData,
                    success: function(response) {
                        // Handle the success response
                        console.log('AJAX request succeeded:', response);
                        $('#addMenuModal').modal(
                        'hide'); // Hide the modal after successful submission
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error('AJAX request failed:', status, error);

                        if (xhr.status === 422) {
                            // If it's a validation error, display the errors in the modal
                            var errors = xhr.responseJSON.errors;
                            displayValidationErrors(errors);
                        } else {
                            // Handle other types of errors as needed
                            alert('An unexpected error occurred. Please try again.');
                        }
                    }
                });
            });

            $('#admin_form').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting the traditional way

                // Serialize the form data
                var formData = $(this).serialize();

                // Send an AJAX request
                $.ajax({
                    type: 'POST',
                    url: '{{ route('module_manager.store') }}', // Replace with your actual route
                    data: formData,
                    success: function(response) {
                        // Handle the success response
                        console.log('AJAX request succeeded:', response);
                        $('#addMenuModal').modal(
                        'hide'); // Hide the modal after successful submission
                        // location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error('AJAX request failed:', status, error);

                        if (xhr.status === 422) {
                            // If it's a validation error, display the errors in the modal
                            var errors = xhr.responseJSON.errors;
                            displayValidationErrors(errors);
                        } else {
                            // Handle other types of errors as needed
                            alert('An unexpected error occurred. Please try again.');
                        }
                    }
                });
            });

            // Function to display validation errors in the modal
            function displayValidationErrors(errors) {
                var errorList = '<ul>';
                $.each(errors, function(key, value) {
                    errorList += '<li>' + value[0] +
                    '</li>'; // Assuming you only want to display the first error message
                });
                errorList += '</ul>';

                // Display errors in the modal or wherever you want
                $('#validationErrors').removeClass('hide');
                $('#validationErrors').html(errorList);
                $('.modal-body').scrollTop(0);
            }

            $("#storfront_div").hide();
            $("#admin_div").hide();

            $("#storfront_edit_div").hide();
            $("#admin_edit_div").hide();

            $('body').on('change', '#module_type', function() {
                console.log($(this).val())
                if ($(this).val() == "storfront") {
                    $("#admin_div").hide();
                    $("#storfront_div").show();
                } else if ($(this).val() == "admin") {
                    $("#storfront_div").hide();
                    $("#admin_div").show();
                } else {
                    $("#storfront_div").hide();
                    $("#admin_div").hide();
                }
            });

            $('#storfront_nestable').on('mousedown', '.dd-handle', function(event) {
                var type = '#storfront_form_edit';

                $("#storfront_edit_div").show();
                $("#admin_edit_div").hide();

                $('#storfront_nestable .dd-handle').removeClass('selected-item');
                $('#admin_nestable .dd-handle').removeClass('selected-item');
                $(this).addClass('selected-item');

                var singleData = $(this).parent().data("json");
                console.log(singleData);

                console.log("PMD isDeleted", singleData.is_deleted)
                if (singleData.is_deleted == 1) {
                    $(this).addClass('deleted-item');
                } else {
                    $(this).removeClass('deleted-item');
                }

                enabledDisabledStoreFrontFormField(type, singleData)

                $("#storfront_form_edit #sid").val(singleData.id);
                $("#storfront_form_edit #sname").val(singleData.name);
                $("#storfront_form_edit #scode").val(singleData.code);
                $("#storfront_form_edit #spath").val(singleData.path);
                $("#storfront_form_edit #sis_enable").prop('checked', singleData.status);
                $("#storfront_form_edit #sinclude_in_menu").prop('checked', singleData.include_in_menu);
                $("#storfront_form_edit #smeta_title").val(singleData.meta_title);
                $("#storfront_form_edit #smeta_description").val(singleData.meta_description);
                $("#storfront_form_edit #screated_date").val(singleData.created_date);
                $("#storfront_form_edit #sassigned_attributes").val(singleData.assigned_attributes);
            });

            $('#admin_nestable').on('mousedown', '.dd-handle', function(event) {
                var type = '#admin_form_edit';

                $("#admin_edit_div").show();
                $("#storfront_edit_div").hide();

                $('#admin_nestable .dd-handle').removeClass('selected-item');
                $('#storfront_nestable .dd-handle').removeClass('selected-item');
                $(this).addClass('selected-item');

                var singleData = $(this).parent().data("json");
                console.log("PMD", singleData)
                console.log("PMD isDeleted", singleData.is_deleted)
                enabledDisabledAdminFormField(type, singleData)

                $("#admin_form_edit #aid").val(singleData.id);
                $("#admin_form_edit #aname").val(singleData.name);
                $("#admin_form_edit #acode").val(singleData.code);
                $("#admin_form_edit #apath").val(singleData.path);
                $("#admin_form_edit #ais_enable").prop('checked', singleData.status);
                $("#admin_form_edit #ainclude_in_menu").prop('checked', singleData.include_in_menu);
                $("#admin_form_edit #acreated_date").val(singleData.created_date);
                $("#admin_form_edit #aassigned_attributes").val(singleData.assigned_attributes);
            });

            $('body').on('change', '.storfront_nested_form .nestable', function() {
                var menu = $("#storfront_menu_list");
                var jsonResult = convertMenuToJson(menu, 'storfront-menu');

                $("#storfront_json").text(JSON.stringify(jsonResult, null, 2));

                var data = {
                    type: "storfront",
                    storfront_json: JSON.stringify(jsonResult, null, 2)
                }
                saveMenu(data);
            });

            $('body').on('change', '.admin_nested_form .nestable', function() {
                var menu = $("#admin_menu_list");
                var jsonResult = convertMenuToJson(menu, 'admin-menu');

                $("#admin_json").text(JSON.stringify(jsonResult, null, 2));
                var data = {
                    type: "",
                    admin_json: JSON.stringify(jsonResult, null, 2)
                }
                saveMenu(data);
            });

            function saveMenu(menuData) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{ route('module_manager.menu_update') }}',
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
                    }
                }
            });

            $("#storfront_li").click(function() {
                $("#admin_div").hide();
                $("#storfront_div").show();
            });

            $("#admin_li").click(function() {
                $("#storfront_div").hide();
                $("#admin_div").show();
            });

            // Storefront remove event
            $('body').on('click', '#remove-store-front-menu', function() {
                var type = '#storfront_form_edit';
                let menuId = $("#storfront_form_edit #sid").val();
                let isDeleted = 1;
                updateIsdeleted(type, menuId, isDeleted);
            });

            // Storefront restore event
            $('body').on('click', '#restore-store-front-menu', function() {
                var type = '#storfront_form_edit';
                let menuId = $("#storfront_form_edit #sid").val();
                let isDeleted = 0;
                updateIsdeleted(type, menuId, isDeleted);
            });

            // Admin remove event
            $('body').on('click', '#remove-admin-menu', function() {
                var type = '#admin_form_edit';
                let menuId = $("#admin_form_edit #aid").val();
                let isDeleted = 1;
                // let selectedItem = $('#admin_menu_list li[data-id="'+menuId+'"]');
                // let selectedItemDataAttr = selectedItem.data("json");
                // selectedItemDataAttr.is_deleted=1
                // selectedItem.attr('json', selectedItemDataAttr);
                updateIsdeleted(type, menuId, isDeleted);
            });

            // Admin restore event
            $('body').on('click', '#restore-admin-menu', function() {
                var type = '#admin_form_edit';
                let menuId = $("#admin_form_edit #aid").val();
                let isDeleted = 0;
                updateIsdeleted(type, menuId, isDeleted);
            });
        });

        function convertMenuToJson(menu, includeClass, parentId = 0) {
            var result = [];
            menu.children("li").each(function(index) {
                var menuItem = $(this).find('.' + includeClass);
                var id = menuItem.val();
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

        function updateIsdeleted(type, menuId, isDeleted, current) {
            var deleteText =
                "Data would be there till 30 days and Once deleted, you will not be able to recover this details !"
            swal({
                title: "Are you sure?",
                text: deleteText,
                icon: "warning",
                showCancelButton: true,
                type: "warning",
                // confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                // closeOnConfirm: false,
                // closeOnCancel: false,
                dangerMode: true,
            }, function(willDelete) {
                if (willDelete) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: '{{ route('module_manager.menu_delete') }}',
                        type: 'POST',
                        data: {
                            menu_id: menuId,
                            is_deleted: isDeleted
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            if (type == "#storfront_form_edit") {
                                enabledDisabledStoreFrontFormField(type, response, menuId);
                            } else if (type == "#admin_form_edit") {
                                enabledDisabledAdminFormField(type, response, menuId);
                            }
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
            });
        }

        function enabledDisabledStoreFrontFormField(type, data, menuId) {
            if (data.is_deleted == 1) {
                let isDeletedHtml = `<span class="tag tag-deleted tag-red">Deleted</span>`;
                $('#storfront_menu_list li[data-id="' + menuId + '"] .storfront-menu:first').after(isDeletedHtml)

                let selectedItem = $('#storfront_menu_list li[data-id="' + menuId + '"]');
                let selectedItemDataAttr = selectedItem.data("json");
                if (selectedItemDataAttr && selectedItemDataAttr.is_deleted == 0) {
                    selectedItemDataAttr.is_deleted = 1
                }
                selectedItem.attr('json', selectedItemDataAttr);

                $(type + ' input').prop("disabled", true);
                $(type + ' input[type=checkbox]').attr('disabled', true);
                $(type + ' textarea').attr("disabled", true);
                $(type + ' #restore-store-front-menu').attr("disabled", false);
                $(type + ' #submit-store-front-menu').attr("disabled", false);

                $(type + ' #restore-store-front-menu').removeClass("d-none");
                $(type + ' #remove-store-front-menu').addClass("d-none");
            } else {
                $('#storfront_menu_list li[data-id="' + menuId + '"]').find(".tag-deleted").remove()

                let selectedItem = $('#storfront_menu_list li[data-id="' + menuId + '"]');
                let selectedItemDataAttr = selectedItem.data("json");
                if (selectedItemDataAttr && selectedItemDataAttr.is_deleted == 1) {
                    selectedItemDataAttr.is_deleted = 0
                }
                selectedItem.attr('json', selectedItemDataAttr);

                $(type + ' input').prop("disabled", false);
                $(type + ' input[type=checkbox]').attr('disabled', false);
                $(type + ' textarea').attr("disabled", false);

                $(type + ' #remove-store-front-menu').removeClass("d-none");
                $(type + ' #restore-store-front-menu').addClass("d-none");
            }
        }

        function enabledDisabledAdminFormField(type, data, menuId) {
            if (data.is_deleted == 1) {
                let isDeletedHtml = `<span class="tag tag-deleted tag-red">Deleted</span>`;
                $('#admin_menu_list li[data-id="' + menuId + '"] .admin-menu:first').after(isDeletedHtml)

                let selectedItem = $('#admin_menu_list li[data-id="' + menuId + '"]');
                let selectedItemDataAttr = selectedItem.data("json");
                if (selectedItemDataAttr && selectedItemDataAttr.is_deleted == 0) {
                    selectedItemDataAttr.is_deleted = 1
                }
                selectedItem.attr('json', selectedItemDataAttr);

                $(type + ' input').prop("disabled", true);
                $(type + ' input[type=checkbox]').attr('disabled', true);
                $(type + ' textarea').attr("disabled", true);
                $(type + ' #restore-admin-menu').attr("disabled", false);
                $(type + ' #submit-admin-menu').attr("disabled", false);

                $(type + ' #restore-admin-menu').removeClass("d-none");
                $(type + ' #remove-admin-menu').addClass("d-none");
            } else {
                $('#admin_menu_list li[data-id="' + menuId + '"]').find(".tag-deleted").remove()

                let selectedItem = $('#admin_menu_list li[data-id="' + menuId + '"]');
                let selectedItemDataAttr = selectedItem.data("json");
                if (selectedItemDataAttr && selectedItemDataAttr.is_deleted == 1) {
                    selectedItemDataAttr.is_deleted = 0
                }
                selectedItem.attr('json', selectedItemDataAttr);

                $(type + ' input').prop("disabled", false);
                $(type + ' input[type=checkbox]').attr('disabled', false);
                $(type + ' textarea').attr("disabled", false);

                $(type + ' #remove-admin-menu').removeClass("d-none");
                $(type + ' #restore-admin-menu').addClass("d-none");
            }
        }
    </script>

    <script>
        function dragTr() {
           
            $(".tbl_drag").draggable();
            console.log('work')
        }
        dragTr();
        var i = 1;
        $("#add_new").on('click', function() {
            var alaa = ""
            $('#attr_tbl tbody').append(`<tr>
                                <td>
                                    <div class="col-sm-12 form-group">
                                        <label class="form-label" for="name">Label<span class="text-red">*</span></label>
                                        <input type="text" name="attr[`+i+`][name]" class="form-control " value="">
                                        <label id="name-error" class="error text-red hide" for="name"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-12 form-group">
                                        <label class="form-label" for="name">Name<span class="text-red">*</span></label>
                                        <input type="text" name="attr[`+i+`][input_name]" class="form-control " value="">
                                        <label id="name-error" class="error text-red hide" for="name"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-12 form-group">
                                        <input type="text" name="attr[`+i+`][input_id]" class="form-control " value="" placeholder="ID">
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <input type="text" name="attr[`+i+`][input_class]" class="form-control " value="" placeholder="Class">
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label class="custom-switch form-label">
                                                <input type="checkbox" name="attr[`+i+`][is_enable]" class="custom-switch-input" id="is_enable">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Status</span>
                                            </label>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label class="custom-switch form-label">
                                                <input type="checkbox" name="attr[`+i+`][is_system]" class="custom-switch-input" id="is_system">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">System </span>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group col-sm-12">
                                        <label class="form-label">Select Attribute type<span class="text-red">*</span></label>
                                        <select name="attr[`+i+`][field_type]" class="form-control field_type" id="field_type">
                                            <option value="" selected="">Please select attribute field type
                                            </option>
                                            <option value="text">Text</option>
                                            <option value="email">Email</option>
                                            <option value="number">Number</option>
                                            <option value="date">Date</option>
                                            <option value="date">Date and Time</option>
                                            <option value="textarea">Textarea</option>
                                            <option value="select">Dropdown</option>
                                            <option value="multiselect">Multiple Select</option>
                                            <option value="switch">Yes/No</option>
                                            <option value="radio">Radiobox</option>
                                            <option value="checkbox">Checkbox</option>
                                            <option value="file">File</option>
                                        </select>
                                        <label id="field_type-error" class="error text-red hide" for="field_type"></label>
                                    </div>
                                </td>
                            </tr>`);
                            i++;
                            dragTr();
        });
    </script>
@endsection
