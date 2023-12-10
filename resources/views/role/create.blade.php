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

    <link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/wysiwyag/richtext.css"
        rel="stylesheet" />
    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sumoselect/sumoselect.css') }}    ">
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">add Roles</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Roles</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('role.index') }}">add</a></li>
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
    <h3 class="card-title">add Role</h3>
</div>
<div class="card-body pb-2">

<form action="{{ $role->id == null ? route('role.store') : route('role.update', ['role' => $role->id]) }}" method="POST"
    id="role_form" novalidate="" class="needs-validation">
    <div class="card-body">
        @csrf
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="form-group col-sm-6">
                    <label for="name">Role</label>
                    <input class="form-control @error('name') is-invalid @enderror" name="name" type="text"
                        value="{{ old('name', $role->name) }}" required="" placeholder="Role">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter role.</div>
                </div>
                <input type="hidden" value="web" name="guard_name">
            </div>
            <div class="form-group col-sm-12 col-lg-12">
                <div class="permission input-box">
                    <label for="permission">Permission:</label>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <div class="row">
                            @foreach ($groupPermission as $key => $permissions)
                                <div class="col-sm-6 ">
                                    <div class="custom-checkbox permission">
                                        <input id="{{ $key }}" type="checkbox" class=" check-all"
                                            name="checkAll">
                                        <label for="{{ $key }}"> <b>{{ Str::ucfirst(explode('.',$permissions[0]->name)[1]) }}</b></label>
                                    </div>

                                    @foreach ($permissions as $permission)
                                        <div class="custom-control custom-checkbox ms-3">
                                            <input id="{{ $permission->id }}" type="checkbox" class="check-one"
                                                name="permission_data[]" value="{{ $permission->id }}"
                                                {{ $role->id != null && count($role->permission_data) > 0 && isset($role->permission_data[$permission->id]) ? 'checked' : '' }}>
                                            <input id="{{ $permission->module }}" type="hidden"
                                                name="permission_module[{{$permission->id}}]" value="{{ $permission->module }}">
                                            <label for="{{ $permission->id }}">{{ Str::ucfirst($permission->name) }}</label>
                                            <?php
                                                $edit_no=0;
                                                $edit_type='';
                                                $permission_id=0;
                                                $scheduler_data=array('scheduler_no'=>'','type'=>'');
                                                // if($role->scheduler->count()>0){
                                                    // $scheduler=$role->scheduler->toArray();
                                                    // if(array_search($permission->id, array_column($scheduler, 'permission_id')) !== false){
                                                    //     $key=array_search($permission->id, array_column($scheduler, 'permission_id'));
                                                    //     $scheduler_data=$scheduler[$key];
                                                    // }

                                                    // dump($scheduler[$key]);

                                                    // if(array_search($permission->id, array_column($scheduler, 'permission_id')) !== false) {
                                                    //     // $edit_no=$scheduler['scheduler_no'];
                                                    //     // $edit_type=$scheduler['type'];
                                                    //     $permission_id=$scheduler;
                                                    // }
                                                    // echo $key;
                                                // }
                                                // dump($scheduler_data);
                                                // echo $role->scheduler->count().$edit_no.$edit_type;
                                            ?>
                                            @if (str_contains($permission->name, 'edit'))
                                                <select name="schedule_no_edit[{{$permission->id}}]" class="google-input" title="Number">
                                                    <option value="">Number</option>
                                                    <option value="0" {{($scheduler_data['scheduler_no']=="0" ? 'selected' : '')}}>Inactive</option>
                                                    @for ($i=1;$i<=10;$i++)
                                                        <option value="{{$i}}" {{($scheduler_data['scheduler_no']==$i ? 'selected' : '')}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                <select name="schedule_time_edit[{{$permission->id}}]" class="google-input schedule_time_edit schedule_time" title="Time">
                                                    <option value="">Time</option>
                                                    <option value="day" {{($scheduler_data['type']=='day' ? 'selected' : '')}}>Days</option>
                                                    <option value="week" {{($scheduler_data['type']=='week' ? 'selected' : '')}}>Weeks</option>
                                                    <option value="month" {{($scheduler_data['type']=='month' ? 'selected' : '')}}>Months</option>
                                                    <option value="year" {{($scheduler_data['type']=='0' ? 'selected' : '')}}>Years</option>
                                                </select>
                                            @endif
                                            @if (str_contains($permission->name, 'delete'))
                                                <select name="schedule_no_delete[{{$permission->id}}]" class="google-input schedule_no_delete schedule_no" title="Number">
                                                    <option value="">Number</option>
                                                    <option value="0" {{($scheduler_data['scheduler_no']=="0" ? 'selected' : '')}}>Inactive</option>
                                                    @for ($i=1;$i<=10;$i++)
                                                        <option value="{{$i}}" {{($scheduler_data['scheduler_no']==$i ? 'selected' : '')}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                <select name="schedule_time_delete[{{$permission->id}}]" class="google-input schedule_time_delete schedule_time" title="Time">
                                                    <option value="">Time</option>
                                                    <option value="day" {{($scheduler_data['type']=='day' ? 'selected' : '')}}>Days</option>
                                                    <option value="week" {{($scheduler_data['type']=='week' ? 'selected' : '')}}>Weeks</option>
                                                    <option value="month" {{($scheduler_data['type']=='month' ? 'selected' : '')}}>Months</option>
                                                    <option value="year" {{($scheduler_data['type']=='0' ? 'selected' : '')}}>Years</option>
                                                </select>
                                            @endif
                                        </div>

                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" type="submit">{{ $role->id == null ? 'Save' : 'Update' }}</button>
        <a href="{{ route('role.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
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
    <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/wysiwyag/jquery.richtext.js">
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

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

        $(function(e) {
            $('.content').richText();
            $('.content2').richText();
        });



    </script>
@endpush
