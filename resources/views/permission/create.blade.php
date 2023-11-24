@extends('layouts.master')

@section('title')
    Permissions
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/extensions/rowReorder.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/extensions/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/forms/selects/select2.min.css') }}">
    <style>
        .permissionLabel{
            float: left; 
            width: 100%;
        }
        .add-module, .add-module:focus{
            border: none;
            outline: none;
        }
        .permission {
            display: block;
        }
        .permission .permissionInput{
            width: 80%;
            float: left;
            margin-right: 20px;
        }
        .permission #add, .btn-remove{
            float: right;
            width: 95px;
        }
        .each-input{
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            margin-bottom: 15px;
        }
        .select2-search__field {
            width: 100% !important;
        }        
    </style>
@endsection

@section('content')

<div class="row company_module">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-head">
                <div class="card-header">
                    <h4 class="inline">Add Permission</h4>
                </div>
            </div>
            <div class="card-body">
                <form
                    action="{{ route('permission.store') }}"
                    method="POST" id="permission_form" novalidate="" class="needs-validation">
                    <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name">Permission</label>
                                <div class="permission">
                                    <div class="each-input">
                                        <input class="permission Input permissionInput form-control @error('name') is-invalid @enderror" name="name[0]" type="text" placeholder="Enter permission name" value="{{ old('name[0]') }}">
                                        <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
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
                                <button type="button" class="float-right add-module" title="Create Module" data-toggle="modal" data-target="#module_form_modal">+</button>
                                <select class="form-control custom-select @error('module') is-invalid @enderror" name="module" id="moduleId">
                                    @if(count($moduleList))
                                        @foreach ($moduleList as $module)
                                            <option value="{{ $module->id }}" {{ isset($value) && $module->id==$value->module ? 'selected' : ''}}> {{ $module->name }} </option>
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
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-primary" type="submit" value="Save">
                        <a href="{{ route('permission.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="module_form_modal" tabindex="-1" role="dialog"aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-content-contact-person">
            <form method="post" id="moduleForm">
                <div class="modal-header modal-header-contact-person">
                    <h4 class="modal-title modal-title-contact-person" id="myLargeModalLabel">Add Module</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
                <div class="modal-body modal-body-contact-person">
                    <div class="form-group">
                        <label for="name">Module Name</label>
                        <input class="form-control @error('module') is-invalid @enderror" name="modulename" id="moduleName" type="text" placeholder="Enter module name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="saveModule">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        let Testcount = $(".permission input:last").attr("name");
        let count = parseInt(Testcount.slice(5,6)) + 1;

        $('#add').on('click', function(){
            let rules = '';
            let appendHtml = '<div class="each-input"> <input class="permissionInput form-control" name="name['+count+']" type="text" placeholder="Enter permission name"> <button type="button" class="btn btn-danger btn-remove">Remove</button> </div>';
            $('.append-list').append(appendHtml);
            rules = {
                required: true,
                maxlength: 250,
                messages: {
                    required: 'The Permission field is required'
                }
            };

            $('.append-list').find("[name='name["+count+"]']").rules('add', rules);
            count++;
        });

        $('.btn-remove').on('click', function(){
            $(this).parent('.each-input').remove();
        });

        $('.remove-permission').on('click', function(){
            let id = $(this).data("id");
            $.ajax({
                type:'POST',
                url:"{{ route('permission.delete') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'id': id},
                success: function(data) {
                    toastr.success(data.msg);
                },
                error: function(data){
                    console.log('error while deleting')
                }
            });
        });

        $('#submitform').on('click', function(){
            if ($("#submitform").hasClass("update-permission")) {
                event.preventDefault();
            }
        });

        $("#saveModule").on('click', function() {
            let moduleValue = $('#moduleName').val();
            $.ajax({
                type:'POST',
                url:"{{ route('permission.module') }}",
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                data: {'name': moduleValue},
                success: function(data) {
                    $('#moduleForm').trigger('reset');
                    $('<option value="'+data.id+'">'+data.name+'</option>').appendTo("#moduleId");
                    $('#module_form_modal').modal('toggle');
                    $('#moduleId').find('[value="No module found selected"]').remove();

                    toastr.success('Module added successfully');
                },
                error: function(data){
                    let errormsg = JSON.parse(data.responseText);
                    if(errormsg.errors.name){
                        $('#moduleName').after('<label id="name-error" class="error" for="modulename">'+errormsg.errors.name+'</label>');
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
@endsection

