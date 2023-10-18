@extends('layouts.master')
@section('css')
		<!-- Data table css -->
		<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
		<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
		<!-- Slect2 css -->
		<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

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
									<a href="{{route('attribute.create')}}" class="btn btn-info" data-toggle="tooltip" title="" data-original-title="Add new"><i class="fe fe-plus mr-1"></i> Add new </a>
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
														<th class="wd-15p border-bottom-0">No.</th>
														<th class="wd-15p border-bottom-0">Name</th>
														<th class="wd-20p border-bottom-0">Code</th>
														<th class="wd-15p border-bottom-0">Type</th>
														<th class="wd-10p border-bottom-0">Required</th>
														<th class="wd-25p border-bottom-0">Action</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>1</td>
														<td>First Name</td>
														<td>first_name</td>
														<td>Text Field</td>
														<td>Yes</td>
														<td>
															<a class="btn btn-icon  btn-warning" href=""><i class="fa fa-edit" data-toggle="tooltip" title="" data-original-title="Edit"></i></a>
															<a class="btn btn-icon  btn-danger" href=""><i class="fa fa-trash" data-toggle="tooltip" title="" data-original-title="Delete"></i></a>
														</td>
													</tr>
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
@endsection
@section('js')
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

		<!-- INTERNAL Select2 js -->
		<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>

		<script type="text/javascript">
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
	                    data: 'key',
	                    name: 'key'
	                },
	                {
	                    data: 'type',
	                    name: 'type'
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
	                },
	            ],
	            order: [
	                [1, 'asc']
	            ]
	        });
		</script>
@endsection