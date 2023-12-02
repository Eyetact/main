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

    <style>
        .each-input,
        .each-input input {
            margin-bottom: 10px;
        }
    </style>
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">add Permission</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Permission</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">add</a></li>
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
            <form action="{{ route('permission.store') }}" method="POST" id="mailboxForm" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="name">Permission</label>
                        <div class="permission">
                            <div class="each-input">
                                <input
                                    class="permission Input permissionInput form-control @error('name') is-invalid @enderror"
                                    name="name[0]" type="text" placeholder="Enter permission name"
                                    value="{{ old('name[0]') }}">
                                <button type="button" name="add" id="add" class="btn btn-success">Add
                                    More</button>
                            </div>
                            <div class="append-list"></div>
                        </div>

                        <!-- <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" required="" placeholder="Name"> -->
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter name.</div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="module">Module</label>

                        <select class="form-control custom-select @error('module') is-invalid @enderror" name="module"
                            id="moduleId">
                            @if (count($moduleList))
                                @foreach ($moduleList as $module)
                                    <option value="{{ $module->id }}"
                                        {{ isset($value) && $module->id == $value->module ? 'selected' : '' }}>
                                        {{ $module->name }} </option>
                                @endforeach
                            @else
                                <option disabled value="No module found selected">No module found selected</option>
                            @endif
                        </select>
                        <!-- <input class="form-control @error('module') is-invalid @enderror" name="module" type="text" required="" placeholder="Module"> -->
                        @error('module')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter module.</div>
                    </div>
                    <input type="hidden" name="guard_name" value="web">

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
        $(document).ready(function() {
            let Testcount = $(".permission input:last").attr("name");
            let count = parseInt(Testcount.slice(5, 6)) + 1;

            $('#add').on('click', function() {
                let rules = '';
                let appendHtml =
                    '<div class="each-input"> <input class="permissionInput form-control" name="name[' +
                    count +
                    ']" type="text" placeholder="Enter permission name"> <button type="button" class="btn btn-danger btn-remove">Remove</button> </div>';
                $('.append-list').append(appendHtml);
                rules = {
                    required: true,
                    maxlength: 250,
                    messages: {
                        required: 'The Permission field is required'
                    }
                };

                $('.append-list').find("[name='name[" + count + "]']").rules('add', rules);
                count++;
            });

            $('body').on('click', '.btn-remove', function() {
                $(this).parent('.each-input').remove();
            });

            $('.remove-permission').on('click', function() {
                let id = $(this).data("id");
                $.ajax({
                    type: 'POST',
                    url: "{{ route('permission.delete') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': id
                    },
                    success: function(data) {
                        toastr.success(data.msg);
                    },
                    error: function(data) {
                        console.log('error while deleting')
                    }
                });
            });

            $('#submitform').on('click', function() {
                if ($("#submitform").hasClass("update-permission")) {
                    event.preventDefault();
                }
            });

            $("#saveModule").on('click', function() {
                let moduleValue = $('#moduleName').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('permission.module') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        'name': moduleValue
                    },
                    success: function(data) {
                        $('#moduleForm').trigger('reset');
                        $('<option value="' + data.id + '">' + data.name + '</option>')
                            .appendTo("#moduleId");
                        $('#module_form_modal').modal('toggle');
                        $('#moduleId').find('[value="No module found selected"]').remove();

                        toastr.success('Module added successfully');
                    },
                    error: function(data) {
                        let errormsg = JSON.parse(data.responseText);
                        if (errormsg.errors.name) {
                            $('#moduleName').after(
                                '<label id="name-error" class="error" for="modulename">' +
                                errormsg.errors.name + '</label>');
                            $('#moduleName').parent('.form-group').addClass('input-error')
                        }
                    }
                });
            });


        });


        function checkValidation() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }
    </script>

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
