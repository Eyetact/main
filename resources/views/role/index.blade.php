@extends('layouts.master')

@section('title')
    Roles
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/extensions/rowReorder.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/extensions/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/forms/selects/select2.min.css') }}">

    <style>
        .permission .nav-sidebar .nav-item {
            position: relative;
        }

        .permission .nav-sidebar .menu-open .nav-link i.right {
            -webkit-transform: rotate(-90deg);
            transform: rotate(-90deg);
        }

        .checkbox input[type="checkbox"] {
            display: none;
        }

        .custom-control{
            padding-left: 10px;
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <!-- Zero Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="inline">Roles</h4>
                        <div class="heading-elements mt-0">
                            <button class="btn btn-primary btn-md" id="add_new">
                                <i class="d-md-none d-block feather icon-plus white" ></i><span class="d-md-block d-none" href="javascript:void(0)"> &nbsp; Add Roles</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display" id="role-tabel">
                            <thead>
                                <tr>
                                    <th style="width:15%">No.</th>
                                    <th>Role</th>
                                    <th>Guard</th>
                                    <th width="300px">Action</th>
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

    <div class="modal fade bd-example-modal-lg" id="role_form_modal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Add Role</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
      <script type="text/javascript">
        var table = $('#role-tabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('role.index') }}",
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
                    data: 'guard_name',
                    name: 'guard_name',
                    visible: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            order: [
                [1, 'asc']
            ]
        });

        $(function() {
            checkInput();
        });

        function checkInput() {
            $('.permission .check-all').click(function() {
                var check = this.checked;
                $(this).parents('.nav-item').find('.check-one').prop("checked", check);
            });
            $('.permission .check-one').click(function() {
                var parentItem = $(this).parents('.nav-treeview').parents('.nav-item');
                var check = $(parentItem).find('.check-one:checked').length == $(parentItem).find(
                    '.check-one').length;
                $(parentItem).find('.check-all').prop("checked", check)
            });
            $('.permission .check-all').each(function() {
                var parentItem = $(this).parents('.nav-item');
                var check = $(parentItem).find('.check-one:checked').length == $(parentItem).find(
                    '.check-one').length;
                $(parentItem).find('.check-all').prop("checked", check)
            });
        }

        $(document).on('change', '.schedule_no', function() {
            console.log($(this),$(this).parent().find('.schedule_time'));
            if($(this).val()==0){
                $(this).parent().find('.schedule_time').attr('disabled','disabled');
            }else{
                $(this).parent().find('.schedule_time').removeAttr('disabled');
            }
        });
            
        
            $(document).on('click', '#add_new', function() {
            // window.addEventListener('load', function() {

            // }, false);
            $.ajax({
                url: "{{ route('role.create') }}",
                success: function(response) {
                    // console.log(response);
                    $(".modal-body").html(response);
                    $(".modal-title").html("Add Role");
                    checkValidation();
                    checkInput();
                    $("#role_form_modal").modal('show');
                }
            });
        });

        $(document).on('click', '.edit_form', function() {
            var id = $(this).data('id');
            // console.log($(this).data('path'),"{{ route('users.view', '+id+') }}");
            $.ajax({
                url: $(this).data('path'),
                success: function(response) {
                    // console.log(response);
                    $(".modal-body").html(response);
                    $(".modal-title").html("Update Role");
                    checkValidation();
                    checkInput();
                    $("#role_form_modal").modal('show');
                }
            });
        });
        $(document).on('click', '.delete-role', function() {
            if (confirm("Are you sure to delete this role?")) {
                let id = $(this).data("id");

                $.ajax({
                    type: 'DELETE',
                    url: 'role/' + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        // toastr.success(data.msg);
                        table.draw();
                    },
                    error: function(data) {
                        table.draw();
                        // toastr.error('Something went wrong, Please try again');
                    }
                });
            }
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
@endsection
