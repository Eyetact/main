@extends('layouts.master')
@section('css')
    <!-- Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <!-- Slect2 css -->
    <link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/sweet-alert/jquery.sweet-modal.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />

@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Swift Mailer</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">SMTP Settings</a></li>
            </ol>
        </div>
        <div class="page-rightheader">
            <div class="btn btn-list">
                <a id="add_new" href="javascript:void(0)" class="btn btn-info" title="" data-original-title="Add new"><i class="fe fe-plus mr-1"></i> Add Swift Mailer </a>
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
                    <div class="card-title">Swift Mailer</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap" id="smtp-tabel">
                            <thead>
                            <tr>
                                <th>Mailer ID</th>
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
    <!-- /Row -->

    <div class="modal fade bd-example-modal-lg" id="smtp_form_modal" tabindex="-1" role="dialog" aria-labelledby="mailbox_form_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Add Swift Mailer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <!-- INTERNAL Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/datatables.js')}}"></script>
    <script src="{{URL::asset('assets/js/popover.js')}}"></script>

    <!-- INTERNAL Sweet alert js -->
    <script src="{{URL::asset('assets/plugins/sweet-alert/jquery.sweet-modal.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/sweet-alert.js')}}"></script>


    <!-- INTERNAL Select2 js -->
    <script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
    <!--INTERNAL Sumoselect js-->
    <script src="{{ asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

    <!--INTERNAL Form Advanced Element -->
    {{--    <script src="{{ asset('assets/js/formelementadvnced.js') }}"></script>--}}
    {{--    <script src="{{ asset('assets/js/form-elements.js') }}"></script>--}}

    <!-- INTERNAL Select2 js -->
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>


    <script type="text/javascript">
        var table = $('#smtp-tabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('smtp.index') }}",
            columns: [{
                data: 'mailer_id',
                name: 'mailer_id'
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
            $("#transport_type").on('change', function() {
                var transport_type = $(this).val();
                if (transport_type == 'smtp') {
                    $("#server").show();
                } else {
                    $("#server").hide();
                }
            });
        }

        $(document).on('click', '#add_new', function() {
            $.ajax({
                url: "{{ route('smtp.create') }}",
                success: function(response) {
                    // console.log(response);
                    $(".modal-body").html(response);
                    $(".modal-title").html("Add Swift Mailer");
                    checkInput();
                    $(".select2").select2();
                    // checkValidation();
                    transport_type();
                    $("#smtp_form_modal").modal('show');
                }
            });
        });

        $(document).on('click', '.edit_form', function() {
            var id = $(this).data('id');

            $.ajax({
                url: $(this).data('path'),
                success: function(response) {
                    // console.log(response);
                    $(".modal-body").html(response);
                    $(".modal-title").html("Update Swift Mailer");
                    checkInput();
                    $(".select2").select2();
                    // checkValidation();
                    transport_type();
                    $("#smtp_form_modal").modal('show');
                }
            });
        });

        $(document).on('click', '.delete-smtp', function() {
            if (confirm("Are you sure to delete this smtp?")) {
                let id = $(this).data("id");
                $.ajax({
                    type: 'DELETE',
                    url: 'smtp/' + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        table.draw();
                    },
                    error: function(data) {
                        table.draw();
                    }
                });
            }
        });

        function transport_type() {
            $("#transport_type").on('change', function() {
                var type = $(this).val();
                $.ajax({
                    url: "{{ url('globalmail/get_mail_data') }}/" + type,
                    dataType: "json",
                    success: function(data) {
                        if (data.server) {
                            $("#email").val(data.email);
                            $("#password").val(data.password);
                            $("#mail_server").val(data.server);
                            $("#port").val(data.port);
                            $("#encryption_mode").val(data.encryption).trigger('change');;
                            $("#sender_address").val(data.from_address);
                        } else {
                            $("#email").val('');
                            $("#password").val('');
                            $("#mail_server").val('');
                            $("#port").val('');
                            $("#encryption_mode").val('');
                            $("#sender_address").val('');
                        }
                    },
                });
            });
        }
    </script>
@endpush
