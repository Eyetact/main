@extends('layouts.master')
@section('css')
    <!-- INTERNAL File Uploads css -->
    <link href="{{ asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{ asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-header')
    <div class="page-header">

        <div class="page-leftheader">
            <h4 class="page-title mb-0">File Manager </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fe fe-grid mr-2 fs-14"></i>Apps</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('files') }}">File Manager </a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">{{ $folder->name }} </a></li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        @include('files.sidebar')
        <div class="col-lg-8 col-xl-9">
            <div class="row">
                <div class="col-6 mb-4">
                    <div class="btn-list">
                        <a href="#" id="new_file" class="btn btn-primary"><i class="fe fe-plus"></i> Upload New
                            Files</a>
                        {{-- <a href="#" id="new_folder" class="btn btn-outline-secondary"><i class="fe fe-folder"></i> New
                            folder</a> --}}
                    </div>
                </div>
                <div class="col-6 col-auto">
                    <div class="form-group">
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <i class="fe fe-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search Files" fdprocessedid="lqp7z">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
        
                @foreach (auth()->user()->files->where('folder_id', $folder->id) as $file)
                    <div class="col-xl-3 col-md-4 col-sm-6">
                        <div class="card border p-0 shadow-none">
                            <div class="d-flex align-items-center px-4 pt-4">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="example-checkbox2"
                                        value="option2">
                                    <span class="custom-control-label"></span>
                                </label>
                                <div class="float-right ml-auto">
                                    <a href="#" class="option-dots" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#"><i class="fe fe-edit mr-2"></i> Edit</a>
                                        <a class="dropdown-item" href="#"><i class="fe fe-share mr-2"></i> Share</a>
                                        <a class="dropdown-item" href="#"><i class="fe fe-download mr-2"></i>
                                            Download</a>
                                        <a class="dropdown-item" href="#"><i class="fe fe-trash mr-2"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0 text-center">
                                <div class="file-manger-icon">
                                    <img src="{{ asset($file->path) }}" alt="img" class="br-7">
                                </div>
                                <h6 class="mb-1 font-weight-semibold mt-4">{{ $file->name }}</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            


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
@section('js')
    <!-- INTERNAL File uploads js -->
    <script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
    <script src="{{ asset('assets/js/filupload.js') }}"></script>
    <script type="text/javascript">
        $(document).on('click', '#new_folder', function() {
            // window.addEventListener('load', function() {
            // }, false);
            $.ajax({
                url: "{{ route('newfolder') }}",
                success: function(response) {
                    //  console.log(response);
                    $(".modal-body").html(response);
                    $(".modal-title").html("Add Folder");
                    $("#role_form_modal").modal('show');
                    $('.dropify').dropify();
                }
            });
        });

        $(document).on('click', '#new_file', function() {
            // window.addEventListener('load', function() {
            // }, false);
            $.ajax({
                url: "{{ route('newfile') }}",
                success: function(response) {
                    //  console.log(response);
                    $(".modal-body").html(response);
                    $(".modal-title").html("Add File");
                    $("#role_form_modal").modal('show');
                    $('.dropify').dropify();
                    $('#folder_id').val({{ $folder->id }})
                }
            });
        });
    </script>
@endsection
