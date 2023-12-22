@extends('layouts.master')
@section('css')
    <!-- INTERNAL File Uploads css -->
    <link href="{{ asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{ asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

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
@push('styles')
    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sumoselect/sumoselect.css') }}    ">

    <!-- INTERNAL File Uploads css -->
    <link href="{{ asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{ asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('page-header')
    <div class="page-header">

        <div class="page-leftheader">
            <h4 class="page-title mb-0">File Manager 01</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fe fe-grid mr-2 fs-14"></i>Apps</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">File Manager 01</a></li>
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
                        <a href="#" id="new_folder" class="btn btn-outline-secondary"><i class="fe fe-folder"></i> New
                            folder</a>
                    </div>
                </div>
                <div class="col-6 col-auto">
                    <div class="form-group">
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <i class="fe fe-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search Files" id="search"
                                fdprocessedid="lqp7z">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="files_container">
                @foreach (auth()->user()->folders as $folder)
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

                                        <a class="dropdown-item folder-edit"
                                            data-path="{{ route('showfolder', $folder->id) }}" href="#"><i
                                                class="fe fe-edit mr-2"></i> View Or Edit</a>
                                        <a class="dropdown-item" href="#"><i class="fe fe-share mr-2"></i> Share</a>
                                        <a class="dropdown-item" href="#"><i class="fe fe-download mr-2"></i>
                                            Download</a>
                                        <a class="dropdown-item folder-delete" data-id="{{ $folder->id }}"
                                            href="#"><i class="fe fe-trash mr-2"></i>
                                            Delete</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0 text-center">
                                <div class="file-manger-icon">
                                    <img src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/files/folder.png"
                                        alt="img" class="br-7">
                                </div>
                                <h6 class="mb-1 font-weight-semibold mt-4"><a
                                        href="{{ route('viewfolder', $folder->id) }}">{{ $folder->name }}</a></h6>
                            </div>
                        </div>
                    </div>
                @endforeach
                @foreach (auth()->user()->files->where('folder_id', 0) as $file)
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




                                        <a class="dropdown-item"
                                            href="{{ route('open.file',$file->id) }}"> <i class="fe fe-play-circle mr-2"></i>Play</a>

                                        <a class="dropdown-item file-edit" data-path="{{ route('showfile', $file->id) }}"
                                            href="#"><i class="fe fe-edit mr-2"></i>View Or Edit</a>
                                        {{-- <a class="dropdown-item" href="#"><i class="fe fe-share mr-2"></i> Share</a> --}}
                                        <a class="dropdown-item" href="{{ route('sharefile', $file->id) }}">
                                            <i class="fe fe-share mr-2"></i> Share
                                        </a>

                                        <a class="dropdown-item" href="{{ route('downloadfile', $file->id) }}">
                                            <i class="fe fe-download mr-2"></i> Download
                                        </a>

                                        <a class="dropdown-item file-delete" data-id="{{ $file->id }}"
                                            href="#"><i class="fe fe-trash mr-2"></i> Delete</a>
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
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>



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
                }
            });
        });
        //TODO :: change id
        $(document).on('click', '#images', function(event) {
            event.preventDefault()
            // window.addEventListener('load', function() {
            // }, false);
            $.ajax({
                url: "{{ route('images', auth()->user()->id) }}",
                success: function(response) {
                    //  console.log(response);
                    $("#files_container").html(response);

                }
            });
            return false;
        });

        $(document).on('click', '#videos', function(event) {
            event.preventDefault()
            // window.addEventListener('load', function() {
            // }, false);
            $.ajax({
                url: "{{ route('videos', auth()->user()->id) }}",
                success: function(response) {
                    //  console.log(response);
                    $("#files_container").html(response);

                }
            });
            return false;
        });

        $(document).on('click', '#home', function(event) {
            event.preventDefault()
            // window.addEventListener('load', function() {
            // }, false);
            $.ajax({
                url: "{{ route('files') }}",
                success: function(response) {
                    //  console.log(response);
                    $("#files_container").html(response);

                }
            });
            return false;
        });

        $(document).on('change', '#search', function(event) {
            event.preventDefault()
            // window.addEventListener('load', function() {
            // }, false);
            $.ajax({
                url: "/file/search/" + $('#search').val(),
                success: function(response) {
                    // alert('works')

                    //  console.log(response);
                    $("#files_container").html(response);

                }
            });
            return false;
        });

        $(document).on('click', '#docs', function(event) {
            event.preventDefault()
            // window.addEventListener('load', function() {
            // }, false);
            $.ajax({
                url: "{{ route('docs', auth()->user()->id) }}",
                success: function(response) {
                    //  console.log(response);
                    $("#files_container").html(response);

                }
            });
            return false;
        });

        $(document).on('click', '#music', function(event) {
            event.preventDefault()
            // window.addEventListener('load', function() {
            // }, false);
            $.ajax({
                url: "{{ route('music', auth()->user()->id) }}",
                success: function(response) {
                    //  console.log(response);
                    $("#files_container").html(response);

                }
            });
            return false;
        });




        $(document).on('click', '.folder-edit', function(e) {
            e.preventDefault(); // Prevent the default link behavior

            var path = $(this).data('path'); // Get the path from the data-path attribute

            $.ajax({
                url: path,
                success: function(response) {
                    $(".modal-body").html(response);
                    $(".modal-title").html("Edit Folder");
                    $("#role_form_modal").modal('show');
                    $('.dropify').dropify();
                }
            });
        });



        $(document).on('click', '.file-edit', function(e) {
            e.preventDefault(); // Prevent the default link behavior

            var path = $(this).data('path'); // Get the path from the data-path attribute

            $.ajax({
                url: path,
                success: function(response) {
                    $(".modal-body").html(response);
                    $(".modal-title").html("Edit File");
                    $("#role_form_modal").modal('show');
                    $('.dropify').dropify();
                }
            });
        });

        $(document).on('click', '.folder-delete', function() {
            var id = $(this).attr("data-id");
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this attribute!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,


            }, function(willDelete) {
                if (willDelete) {

                    $.ajax({
                        type: "POST",
                        url: '{{ url('/') }}/folder/delete/' + id,
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

        $(document).on('click', '.file-delete', function() {
            var id = $(this).attr("data-id");
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this attribute!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,


            }, function(willDelete) {
                if (willDelete) {

                    $.ajax({
                        type: "POST",
                        url: '{{ url('/') }}/file/delete/' + id,
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
@endsection
