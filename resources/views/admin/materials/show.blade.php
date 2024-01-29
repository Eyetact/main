@extends('layouts.master')

@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('Materials') }}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">{{ __('Materials') }}</a></li>
            </ol>
        </div>
        <div class="page-rightheader">
            <div class="btn btn-list">
                <a id="add_new" class="btn btn-info" data-toggle="tooltip" title="" data-original-title="Add new"><i
                        class="fe fe-plus mr-1"></i> Add new </a>
            </div>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
     <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                <div class="card-title">{{ __('Materials') }}</div>

                </div>
                 <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ">
                            <tr>
                                            <td class="fw-bold">{{ __('Name') }}</td>
                                            <td>{{ $material->material_name }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Id') }}</td>
                                            <td>{{ $material->material_id }}</td>
                                        </tr>
									<tr>
                                                    <td class="fw-bold">{{ __('Eu Category') }}</td>
                                                    <td>

                                                    @php

                                                    $ar = json_decode($material->materials_eu_category)

                                                    @endphp

                                                    <table>
                                                        <thead>
                                                        <th>category</th><th>minimum</th><th>maximum</th></thead>

                                                        <tbody>
                                                        @if(!empty($ar))
                                                        @foreach( $ar as $item )
                                                        <tr><td>{{ $item->category }}</td><td>{{ $item->minimum }}</td><td>{{ $item->maximum }}</td></tr>
                                                         @endforeach
                                                         @endif
                                                        </tbody>
                                                    </table>
                                                    
                                                    
                                                    </td>
                                                </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Unit') }}</td>
                                            <td>{{ $material->material_unit }}</td>
                                        </tr>
                            <tr>
                                <td class="fw-bold">{{ __('Created at') }}</td>
                                <td>{{ $material->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">{{ __('Updated at') }}</td>
                                <td>{{ $material->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>

                    <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true">×</span> </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection
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
        table {
            max-width: 99% !important;
            width: 99% !important;
        }
    </style>
@endsection


