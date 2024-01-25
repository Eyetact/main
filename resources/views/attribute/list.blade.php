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
    <style>
        .multi-item {
            background: #e9e9e9;
            padding: 15px;
            margin: 15px 0;
            border: 1px dashed:#ddd;
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

        #tbl-field>tbody>tr>td {
            min-height: 97px;
            max-height: 97px;
            text-align: center !important;
            line-height: 51px;
        }

        #tbl-field>tbody>tr>td label {
            line-height: 1;
        }

        #tbl-field .form-check.form-switch {
            padding: 0;
            display: flex;
            align-items: center;
            /* justify-content: center; */
            min-height: 50px;
        }

        #tbl-field .form-check.form-switch div {
            margin: 0;
        }
    </style>
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Attributes</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Attributes</a></li>
            </ol>
        </div>
        <div class="page-rightheader">
            <div class="btn btn-list">
                <a id="add_new" href="#" class="btn btn-info" data-toggle="tooltip" title=""
                    data-original-title="Add new"><i class="fe fe-plus mr-1"></i> Add new </a>
            </div>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <!-- Row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Attributes Data</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap" id="attribute_table">
                            <thead>
                                <tr>
                                    <th width="50px">No.</th>
                                    <th>Name</th>
                                    <th>Module</th>
                                    <th>Column Type</th>
                                    <th>Input Type</th>
                                    <th>Required</th>
                                    <th width="200px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->

    </div>
    </div><!-- end app-content-->
    </div>

    <div class="modal fade bd-example-modal-xl" id="role_form_modal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Add Role</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true">×</span> </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- INTERNAL Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datatables.js') }}"></script>
    <script src="{{ URL::asset('assets/js/popover.js') }}"></script>

    <!-- INTERNAL Sweet alert js -->
    <script src="{{ URL::asset('assets/plugins/sweet-alert/jquery.sweet-modal.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/sweet-alert.js') }}"></script>


    <!-- INTERNAL Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>

    <script type="text/javascript">
        $(document).on('click', '#add_new', function() {
            // window.addEventListener('load', function() {

            // }, false);
            $.ajax({
                url: "{{ route('attribute.create') }}",
                success: function(response) {
                    //  console.log(response);
                    $(".modal-body").html(response);
                    $(".modal-title").html("Add Attribute");
                    $("#role_form_modal").modal('show');
                }
            });
        });
        var table = $('#attribute_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('attribute.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'module',
                    name: 'module'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'input',
                    name: 'input'
                },
                {
                    data: 'required',
                    name: 'required'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [1, 'asc']
            ]
        });

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        $(document).on('click', '.toggle-btn', function(e) {
            var audit_typeId = $(this).attr("data-id");
            var currentState = $(this).attr('data-state');

            e.preventDefault();

            var toggleButton = $(this);
            swal({
                title: 'Confirm ' + currentState,
                text: 'Are you sure you want to ' + currentState + ' this attribute set?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
            }, function(value) {
                if (value) {
                    $.ajax({
                        url: '{{ url('/') }}/attribute/' + audit_typeId + '/updateStatus',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            state: currentState
                        },
                        success: function(response) {
                            // Toggle the button state
                            if (currentState === 'disabled') {
                                toggleButton.data('state', 'enabled');
                                toggleButton.removeClass('btn-danger').addClass(
                                    'btn-success');
                                toggleButton.text('Enable');
                            } else {
                                toggleButton.data('state', 'disabled');
                                toggleButton.removeClass('btn-success').addClass(
                                    'btn-danger');
                                toggleButton.text('Disable');
                            }
                        },
                        error: function(xhr, status, error) {}
                    });
                }
            });
        });

        $(document).on('click', '.delete-attribute', function() {
            var id = $(this).attr("data-id");
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this attribute!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }, function(willDelete) {
                if (willDelete) {

                    $.ajax({
                        type: "GET",
                        url: '{{ url('/') }}/remove_attribute/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            swal({
                                title: response.msg
                            }, function(result) {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });
    </script>

    @include('attribute.js.functions')

    <script>
        function generateNo() {
            let no = 1

            $('#tbl-field tbody tr').each(function(i) {
                $(this).find('td:nth-child(1)').html(no)
                if (i < 1) {
                    $(`.btn-delete:eq(${i})`).prop('disabled', true)
                } else {
                    $(`.btn-delete:eq(${i})`).prop('disabled', false)
                }
                no++
            })
        }

        $(document).on('click', '.btn-delete', function() {
            $(this).parent().parent().parent().remove()
            generateNo()
        })
        $(document).on('click', '#add_new_tr', function() {
            let table = $('#tbl-field tbody')

            let no = table.find('tr').length + 1

            let tr = `
            <tr draggable="true" containment="tbody" ondragstart="dragStart()" ondragover="dragOver()" style="cursor: move;">
                                            <td class="text-center">
                                                <div class="input-box">
                                                
                                                    ${no}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-box">
                                                    <input type="text" name="multi[${no}][name]"
                                                        class="form-control google-input"
                                                        placeholder="{{ __('Field Name') }}" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-box">
                                                    <select name="multi[${no}][type]"
                                                        class="form-select  google-input multi-type" required>
                                                        <option value="" disabled selected>
                                                            --{{ __('Select column type') }}--
                                                        </option>
                                                        <option value="text">Text</option>
                                                        <option value="textarea">Textarea</option>
                                                        <option value="email">Email</option>
                                                        <option value="tel">Telepon</option>
                                                        <option value="url">Url</option>
                                                        <option value="search">Search</option>
                                                        <option value="number">Number</option>
                                                        <option value="radio">Radio ( True, False )</option>
                                                        <option value="date">Date</option>
                                                        <option value="time">Time</option>
                                                        <option value="datalist">Datalist ( Year List )</option>
                                                        <option value="datetime-local">Datetime local</option>
                                                        <option value="select">Select</option>

                                                    </select>

                                                </div>
                                                <div class="select_options"></div>
                                            </td>





                                            <td>
                                                <div class="input-box">

                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-xs btn-delete">
                                                        x
                                                    </button>
                                                </div>
                                            </td>

                                        </tr>
            `

            table.append(tr)
        })

        $(document).on('change', '.multi-type', function() {
            let index = parseInt($(this).parent().parent().parent().find('.text-center').find('.input-box').html());
            // alert(index);
            if ($(this).val() == 'select') {
                $(this).parent().parent().find('.select_options').append(`<div class="input-box s-option mt-2">
                <input type="text" name="multi[${index}][select_options]" class="google-input" placeholder="Seperate with '|', e.g.: water|fire">
            </div>`);
            } else {
                $(this).parent().parent().find('.s-option').remove();

            }
        })

        $(document).on('change', '.form-column-types', function() {
            // alert($(this).val())
            var index = 0;
            let switchRequired = $(`.switch-requireds`)

            switchRequired.prop('checked', true)
            switchRequired.prop('disabled', false)

            $(`.form-default-value`).remove()
            $(`.custom-values`).append(`
            <div class="form-group form-default-value ">
                <input type="hidden" name="default_values">
            </div>
        `)

            if ($(this).val() == 'enum') {
                removeAllInputHidden(index)
                checkMinAndMaxLength(index)
                addColumTypeHidden(index)

                $(`.form-option`).remove()

                $(`.options`).append(`
            <div class="option_fields mt-5">
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-light draggable-table"
                                id="type_options">
                                <thead class="bg-gray-700 text-white">
                                    <tr>
                                        <th></th>
                                        <th class="text-white">Is Default</th>
                                        <th class="text-white">Label</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4"><button id="addRow" type="button"
                                                class="btn btn-info">Add Option</button></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
            `)
            } else if ($(this).val() == 'multi') {
                removeAllInputHidden(index)
                checkMinAndMaxLength(index)
                addColumTypeHidden(index)

                $(`.form-option`).remove()

                $(`.options`).append(`
                <div class="multi-options">
                                <div class="attr_header row flex justify-content-end my-5 align-items-end">
                                    <input title="Reset form" class="btn btn-success" id="add_new_tr" type="button"
                                        value="+ Add">
                                </div>

                                <table class="table table-bordered align-items-center mb-0" id="tbl-field">
                                    <thead>
                                        <tr>
                                            <th width="30">#</th>
                                            <th>{{ __('Field name') }}</th>
                                            <th>{{ __('Column Type') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr draggable="true" containment="tbody" ondragstart="dragStart()"
                                            ondragover="dragOver()" style="cursor: move;">
                                            <td class="text-center">
                                                <div class="input-box">
                                                
                                                1
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-box">
                                                    <input type="text" name="multi[1][name]"
                                                        class="form-control google-input"
                                                        placeholder="{{ __('Field Name') }}" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-box">
                                                    <select name="multi[1][type]"
                                                        class="form-select  google-input multi-type" required>
                                                        <option value="" disabled selected>
                                                            --{{ __('Select column type') }}--
                                                        </option>
                                                        <option value="text">Text</option>
                                                        <option value="textarea">Textarea</option>
                                                        <option value="email">Email</option>
                                                        <option value="tel">Telepon</option>
                                                        <option value="url">Url</option>
                                                        <option value="search">Search</option>
                                                        <option value="number">Number</option>
                                                        <option value="radio">Radio ( True, False )</option>
                                                        <option value="date">Date</option>
                                                        <option value="time">Time</option>
                                                        <option value="select">Select</option>

                                                    </select>
                                                </div>
                                                <div class="select_options"></div>
                                            </td>





                                            <td>
                                                <div class="input-box">

                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-xs btn-delete">
                                                        x
                                                    </button>
                                                </div>
                                            </td>

                                        </tr>




                                    </tbody>
                                </table>
                            </div>
                `)

                //     $(`.form-input-types`).html(`
            //     <option value="" disabled selected>-- Select input type --</option>
            //     <option value="select">Select</option>
            //     <option value="radio">Radio</option>
            //     <option value="datalist">Datalist</option>
            // `)


            } else if ($(this).val() == 'date') {
                removeAllInputHidden(index)
                checkMinAndMaxLength(index)
                addColumTypeHidden(index)

                //     $(`.form-input-types`).html(`
            //     <option value="" disabled selected>-- Select input type --</option>
            //     <option value="date">Date</option>
            //     <option value="month">Month</option>
            // `)

            } else if ($(this).val() == 'time') {
                checkMinAndMaxLength(index)
                removeAllInputHidden(index)
                addColumTypeHidden(index)

                //     $(`.form-input-types`).html(`
            //     <option value="" disabled selected>-- Select input type --</option>
            //     <option value="time">Time</option>
            // `)

                $(`.form-min-lengths`).prop('readonly', true).hide()
                $(`.form-max-lengths`).prop('readonly', true).hide()
                $(`.form-min-lengths`).val('')
                $(`.form-max-lengths`).val('')

            } else if ($(this).val() == 'year') {
                removeAllInputHidden(index)
                checkMinAndMaxLength(index)
                addColumTypeHidden(index)

                //     $(`.form-input-types`).html(`
            //     <option value="" disabled selected>-- Select input type --</option>
            //     <option value="select">Select</option>
            //     <option value="datalist">Datalist</option>
            // `)

            } else if ($(this).val() == 'dateTime') {
                removeAllInputHidden(index)
                checkMinAndMaxLength(index)
                addColumTypeHidden(index)

                //     $(`.form-input-types`).html(`
            //     <option value="" disabled selected>-- Select input type --</option>
            //     <option value="datetime-local">Datetime local</option>
            // `)

            } else if ($(this).val() == 'foreignId') {
                removeAllInputHidden(index)
                checkMinAndMaxLength(index)

                $(`.form-option`).remove()

                $(`.options`).append(`
                <input type="hidden" name="select_options" class="form-option">
            `)

            // var list = `<option>aaaa</option>`;
            var list = `{!! $all !!}`;
            // alert( list )

                $(`.options`).append(`
                <div class="input-box form-constrain mt-2">
                    <div class="input-box form-on-update mt-2 form-on-update-foreign">
                        <select class="google-input" name="constrains" required>
                           ${list}
                        </select>
                    </div>
                    <small class="text-secondary">
                        <ul class="my-1 mx-2 p-0">
                            <li>Use '/' if related model at sub folder, e.g.: Main/Product.</li>
                            <li>Field name must be related model + "_id", e.g.: user_id</li>
                        </ul>
                    </small>
                </div>
                <div class="input-box form-foreign-id mt-2">
                    <input type="hidden" name="foreign_ids" class="google-input" placeholder="Foreign key (optional)">
                </div>

                <input type="hidden" name="on_update_foreign" class="google-input" value="1">

                <input type="hidden" name="on_delete_foreign" class="google-input" value="1">

                
            `)

                //     $(`.form-input-types`).html(`
            //     <option value="" disabled selected>-- Select input type --</option>
            //     <option value="select">Select</option>
            //     <option value="datalist">Datalist</option>
            // `)

            } else if (
                $(this).val() == 'text' ||
                $(this).val() == 'longText' ||
                $(this).val() == 'mediumText' ||
                $(this).val() == 'tinyText' ||
                $(this).val() == 'string'
            ) {
                removeAllInputHidden(index)
                checkMinAndMaxLength(index)
                addColumTypeHidden(index)

                //     $(`.form-input-types`).html(`
            //     <option value="" disabled selected>-- Select input type --</option>
            //     <option value="text">Text</option>
            //     <option value="textarea">Textarea</option>
            //     <option value="email">Email</option>
            //     <option value="tel">Telepon</option>
            //     <option value="password">Password</option>
            //     <option value="url">Url</option>
            //     <option value="search">Search</option>
            //     <option value="file">File</option>
            //     <option value="hidden">Hidden</option>
            //     <option value="no-input">No Input</option>
            // `)

            } else if (
                $(this).val() == 'integer' ||
                $(this).val() == 'mediumInteger' ||
                $(this).val() == 'bigInteger' ||
                $(this).val() == 'decimal' ||
                $(this).val() == 'double' ||
                $(this).val() == 'float' ||
                $(this).val() == 'tinyInteger'
            ) {
                removeAllInputHidden(index)
                checkMinAndMaxLength(index)
                addColumTypeHidden(index)

                //     $(`.form-input-types`).html(`
            //     <option value="" disabled selected>-- Select input type --</option>
            //     <option value="number">Number</option>
            //     <option value="range">Range</option>
            //     <option value="hidden">Hidden</option>
            //     <option value="no-input">No Input</option>
            // `)

            } else if ($(this).val() == 'boolean') {
                removeAllInputHidden(index)
                checkMinAndMaxLength(index)
                addColumTypeHidden(index)

                //     $(`.form-input-types`).html(`
            //     <option value="" disabled selected>-- Select input type --</option>
            //     <option value="select">Select</option>
            //     <option value="radio">Radio</option>
            // `)

            } else {
                removeAllInputHidden(index)
                checkMinAndMaxLength(index)
                addColumTypeHidden(index)

                //     $(`.form-input-types`).html(`
            //     <option value="" disabled selected>-- Select input type --</option>
            //     <option value="text">Text</option>
            //     <option value="email">Email</option>
            //     <option value="tel">Telepon</option>
            //     <option value="url">Url</option>
            //     <option value="week">Week</option>
            //     <option value="color">Color</option>
            //     <option value="search">Search</option>
            //     <option value="file">File</option>
            //     <option value="hidden">Hidden</option>
            //     <option value="no-input">No Input</option>
            // `)
            }
        });

        $(document).on('change', '.switch-requireds', function() {
            let index = 0;
            $(`.form-default-value`).remove()

            let inputTypeDefaultValue = setInputTypeDefaultValue(index)

            if ($(this).is(':checked')) {
                $(`.custom-values`).append(`
                <div class="input-boc form-default-value ">
                    <input type="hidden" name="default_values">
                </div>
            `)
            } else {
                $(`.custom-values`).append(`
                <div class="input-box form-default-value ">
                    <input type="${inputTypeDefaultValue}" name="default_values" class="google-input" placeholder="Default Value (optional)">
                </div>
            `)
            }
        })

        $(document).on('change', '.form-input-types', function() {
            let index = 0
            let minLength = $(`.form-min-lengths`)
            let maxLength = $(`.form-max-lengths`)
            let switchRequired = $(`.switch-requireds`)

            removeInputTypeHidden(index)
            switchRequired.prop('checked', true)
            switchRequired.prop('disabled', false)

            $(`.form-default-value`).remove()
            $(`.custom-value`).append(`
            <div class="form-group form-default-value ">
                <input type="hidden" name="default_values">
            </div>
        `)

            switch ($(this).val()) {
                case 'text':
                case 'textarea':
                case 'file':
                case 'image':
                case 'email':
                case 'tel':
                case 'password':
                case 'url':
                case 'search':
                    $('#type').val('text').trigger('change')
                    break;
                case 'number':
                case 'range':
                    $('#type').val('double').trigger('change')
                    break;
                case 'radio':
                    $('#type').val('boolean').trigger('change')
                    break;
                case 'date':
                case 'month':
                    $('#type').val('date').trigger('change')
                    break;
                case 'time':
                    $('#type').val('time').trigger('change')
                    break;
                case 'datalist':
                    $('#type').val('year').trigger('change')
                    break;
                case 'datetime-local':
                    $('#type').val('dateTime').trigger('change')
                    break;
                case 'select':
                    $('#type').val('enum').trigger('change')
                    break;
                case 'multi':
                    $('#type').val('multi').trigger('change')
                    break;
                case 'foreignId':
                    $('#type').val('foreignId').trigger('change')
                    break;


                default:
                    break;
            }

            if ($(this).val() == 'file') {
                minLength.prop('readonly', true).hide()
                maxLength.prop('readonly', true).hide()
                minLength.val('')
                maxLength.val('')

                $(`.input-options`).append(`
            <div class="input-box mt-2 form-file-types">

            <input type="hidden" name="file_types" value="file" >

            </div>
            <div class="input-box form-file-sizes">
                <input type="hidden" name="files_sizes" class="google-input" placeholder="Max size(kb), e.g.: 1024" required>
            </div>
            <input type="hidden" name="mimes" class="form-mimes">

            <input type="hidden" name="steps" class="form-step" >
            `)
                return;

            }
            if ($(this).val() == 'image') {
                minLength.prop('readonly', true).hide()
                maxLength.prop('readonly', true).hide()
                minLength.val('')
                maxLength.val('')

                $(`.input-options`).append(`
            <div class="input-box mt-2 form-file-types">
                <input type="hidden" name="file_types" value="image" >

            </div>
            <div class="input-box form-file-sizes">
                <input type="number" name="files_sizes" class="google-input" placeholder="Max size(kb), e.g.: 1024" required>
            </div>
            <input type="hidden" name="mimes" class="form-mimes">
            <input type="hidden" name="steps" class="form-step">
            `)

            } else if (
                $(this).val() == 'email' ||
                $(this).val() == 'select' ||
                $(this).val() == 'datalist' ||
                $(this).val() == 'radio' ||
                $(this).val() == 'date' ||
                $(this).val() == 'month' ||
                $(this).val() == 'password' ||
                $(this).val() == 'number'
            ) {
                minLength.prop('readonly', true).hide()
                maxLength.prop('readonly', true).hide()
                minLength.val('')
                maxLength.val('')

                addInputTypeHidden(index)

            } else if ($(this).val() == 'text' || $(this).val() == 'tel') {
                minLength.prop('readonly', false).show()
                maxLength.prop('readonly', false).show()

                addInputTypeHidden(index)

            } else if ($(this).val() == 'range') {
                $(`.input-options`).append(`
                <div class="input-box form-step mt-4">
                    <input type="number" name="steps" class="google-input" placeholder="Step (optional)">
                </div>
                <input type="hidden" name="file_types" class="form-file-types">
                <input type="hidden" name="files_sizes" class="form-file-sizes">
                <input type="hidden" name="mimes" class="form-mimes">
            `)

                minLength.prop('readonly', false).show()
                maxLength.prop('readonly', false).show()
                minLength.prop('required', true)
                maxLength.prop('required', true)

                // addInputTypeHidden(index)

            } else if ($(this).val() == 'hidden' || $(this).val() == 'no-input') {
                minLength.prop('readonly', true).hide()
                maxLength.prop('readonly', true).hide()
                minLength.val('')
                maxLength.val('')

                let inputTypeDefaultValue = setInputTypeDefaultValue(index)

                $(`.form-default-value`).remove()

                $(`.input-options`).append(`
                <div class="input-box form-default-value ">
                    <input type="${inputTypeDefaultValue}" name="default_values" class="google-input" placeholder="Default Value (optional)">
                </div>
            `)

                switchRequired.prop('checked', false)
                switchRequired.prop('disabled', true)
                addInputTypeHidden(index)

            } else if (
                $(this).val() == 'time' ||
                $(this).val() == 'week' ||
                $(this).val() == 'color' ||
                $(this).val() == 'datetime-local'
            ) {
                minLength.prop('readonly', true).hide()
                maxLength.prop('readonly', true).hide()
                minLength.val('')
                maxLength.val('')
                addInputTypeHidden(index)

            } else {
                addInputTypeHidden(index)
                minLength.prop('readonly', false).show()
                maxLength.prop('readonly', false).show()
            }
        });

        var index = 1;
        $(document).on("click", "#addRow", function() {
            var html = '';
            html +=
                '<tr><td scope="row"></td><td><input type="radio" name="fields_info_radio" onchange="addValue(' +
                index + ')" class="m-input mr-2"><input type="hidden" value="0" id="fields_info[' + index +
                '][default]" name="fields_info[' + index +
                '][default]"></td><td><input type="text" name="fields_info[' + index +
                '][value]" class="form-control m-input mr-2"  autocomplete="off"></td><td><button type="button" class="btn btn-danger removeSection"><i class="fa fa-trash"></i></button></td></tr>';
            $('.option_fields tbody').append(html);
            index++;
        });

        function addValue(index) {
            console.log(index);
            $('[id^="fields_info"]').each(function() {
                $(this).val(0);
            });
            $("#fields_info\\[" + index + "\\]\\[default\\]").val(1);

        }
        $(document).on('click', '.removeSection', function() {
            $(this).closest('tr').remove();
            index--;
        });
    </script>
@endsection
