@extends('layouts.master')

@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('Products') }}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">{{ __('Products') }}</a></li>
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
                <div class="card-title">{{ __('Products') }}</div>

                </div>
                 <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ">
                            


                               @if(isset($module))
                            @foreach ($module->fields as $field)
                                @php
                                    $code = str($field->code)->snake();
                                @endphp
                                <tr>
                                    <td class="fw-bold">{{ $field->name }}</td>
                                    <td>
                                        @switch($field->type)
                                            @case('file')
                                                @if ($field->file_type == 'image')
                                                    <img src="{{ asset($child->$code) }}" alt="{{ $code }}" class="rounded"
                                                        width="200" height="150" style="object-fit: cover">
                                                @else
                                                    {{ asset($child->$code) }}
                                                @endif
                                            @break

                                            @case('boolean')
                                                {{ $child->$code == 1 ? 'True' : 'False' }}
                                            @break

                                            @case('text')
                                                @if($field->input == 'texteditor')
                                                    {!! $child->$code !!}
                                                @else
                                                    {{ $child->$code }}
                                                @endif
                                            @break

                                            @case('foreignId')
                                                @php

                                                    $constrainModel = App\Generators\GeneratorUtils::setModelName($field->constrain, 'default');
                                                    $constrainCode = App\Generators\GeneratorUtils::singularSnakeCase($constrainModel);
                                                    $attr = $field->attribute;

                                                @endphp

                                                {{ $child->$constrainCode ? $child->$constrainCode->$attr : '' }}
                                            @break

                                            @case('multi')
                                                @php

                                                    $fieldSnakeCase = str($field->code)->snake();

                                                    $ar = json_decode($child->$fieldSnakeCase);

                                                @endphp

                                                <table>
                                                    <thead>


                                                        @foreach ($field->multis as $key => $value)
                                                            <th> {{ $value->name }} </th>
                                                        @endforeach


                                                    </thead>

                                                    <tbody>
                                                        @if (!empty($ar))
                                                            @foreach ($ar as $item)
                                                                <tr>
                                                                    @foreach ($field->multis as $key => $value)
                                                                        @php
                                                                            $a = $value->name ;
                                                                        @endphp
                                                                        @if($value->type == "texteditor")
                                                                             <td>{!! $item->$a !!}</td>
                                                                        @else
                                                                        <td>{{ $item->$a }}</td>
                                                                          @endif
                                                                    @endforeach

                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            @break

                                            @default
                                                @php

                                                    $fieldSnakeCase = str($field->code)->snake();

                                                @endphp

                                                {{ $child->$fieldSnakeCase }}
                                        @endswitch
                                    </td>
                                </tr>
                            @endforeach
                            @endif

                            <tr>

                            <tr>
                                <td class="fw-bold">{{ __('Created at') }}</td>
                                <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">{{ __('Updated at') }}</td>
                                <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
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



