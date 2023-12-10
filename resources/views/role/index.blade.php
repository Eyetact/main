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
        .dropdown-toggle:after {
            content: none !important;
        }

        li.dropdown-item button,
        li.dropdown-item a {
            border: none;
            background: transparent;
            color: #333;
            padding: 0px 10px;
        }

        li.dropdown-item {
            padding: 10px;
            text-align: left;
        }

        .dt-buttons.btn-group {
            float: left;
        }
        .parent {
    animation: unset !important;
}
    </style>
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Roles</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>roles</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">list</a></li>
            </ol>
        </div>
        <div class="page-rightheader">
            <div class="btn btn-list">
                <a href="{{ route('role.create') }}" class="btn btn-info" data-toggle="tooltip" title=""
                    data-original-title="Add new"><i class="fe fe-plus mr-1"></i> Add new </a>
            </div>
        </div>
    </div>
    <!--End Page header-->
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
                            {{-- <button class="btn btn-primary btn-md" id="add_new">
                                <i class="d-md-none d-block feather icon-plus white" ></i><span class="d-md-block d-none" href="javascript:void(0)"> &nbsp; Add Roles</span>
                            </button> --}}
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
