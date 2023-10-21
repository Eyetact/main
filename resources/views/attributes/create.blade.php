@extends('layouts.master')
@section('css')
		<!--INTERNAL Select2 css -->
		<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
	<!--Page header-->
	<div class="page-header">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">Attributes</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#"><i class="fe fe-file-text mr-2 fs-14"></i>Settings</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#">Add Attributes</a></li>
			</ol>
		</div>
	</div>
    <!--End Page header-->
@endsection
@section('content')
@php
    $data = json_decode($attribute->fields_info, true);
@endphp
			<!-- Row -->
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="card">
						<form
			                action="{{ $attribute->id == null ? route('attribute.store') : route('attribute.update', ['attribute' => $attribute->id]) }}"
			                id="attributeCreate" method="POST" autocomplete="off">
							<div class="card-header">
								<h3 class="card-title">Add Attributes</h3>
							</div>
							<div class="card-body pb-2">							
			                    @csrf
			                    <div class="row">
			                        <div class="col-sm-6 form-group">
										<label class="form-label" for="name">Name/Label of Attribute <span class="text-red">*</span></label>
										<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" value="{{ old('name', $attribute->name) }}">
			                            <label id="name-error" class="error text-red hide" for="name"></label>
			                            @error('name')
			                                <span class="error name-error">{{ $message }}</span>
			                            @enderror
			                        </div>
			                        <div class="form-group col-sm-6">
			                            <label class="form-label" for="input_name">Slug(Attribute name) <span class="text-red">*</span></label>
			                            <input class="form-control @error('input_name') is-invalid @enderror" name="input_name"
			                                placeholder="Enter input name" type="text" value="{{ old('input_name', $attribute->input_name) }}"
			                                autocomplete="off">
			                            <label id="input_name-error" class="error text-red hide" for="input_name"></label>
			                            @error('input_name')
			                                <span class="error input_name-error">{{ $message }}</span>
			                            @enderror
			                        </div>
			                        <div class="form-group col-sm-6">
			                            <label class="form-label" for="input_class">Class <span class="text-red">*</span></label>
			                            <input class="form-control @error('input_class') is-invalid @enderror" name="input_class"
			                                placeholder="Enter input class" type="text" value="{{ old('input_class', $attribute->input_class) }}"
			                                autocomplete="off">
			                            <label id="input_class-error" class="error text-red hide" for="input_class"></label>
			                            @error('input_class')
			                                <span class="error input_class-error">{{ $message }}</span>
			                            @enderror
			                        </div>
			                        <div class="form-group col-sm-6">
			                            <label class="form-label" for="input_id">ID <span class="text-red">*</span></label>
			                            <input class="form-control @error('input_id') is-invalid @enderror" name="input_id"
			                                placeholder="Enter input id" type="text" value="{{ old('input_id', $attribute->input_id) }}"
			                                autocomplete="off">
			                            <label id="input_id-error" class="error text-red hide" for="input_id"></label>
			                            @error('input_id')
			                                <span class="error input_id-error">{{ $message }}</span>
			                            @enderror
			                        </div>
			                        <div class="form-group col-sm-12">
			                            <label class="form-label">Select Attribute type<span class="text-red">*</span></label>
			                            <select name="field_type" class="form-control field_type" id="field_type">
			                                <option value="" selected>Please select attribute field type</option>
			                                <option value="text" {{ ($attribute->field_type == 'text' ? 'selected' : '') }}>Text</option>
			                                <option value="password" {{ ($attribute->field_type == 'password' ? 'selected' : '') }}>Password</option>
			                                <option value="email" {{ ($attribute->field_type == 'email' ? 'selected' : '') }}>Email</option>
			                                <option value="number" {{ ($attribute->field_type == 'number' ? 'selected' : '') }}>Number</option>
			                                <option value="textarea" {{ ($attribute->field_type == 'textarea' ? 'selected' : '') }}>Textarea</option>
			                                <option value="select" {{ ($attribute->field_type == 'select' ? 'selected' : '') }}>Select dropdown</option>
			                                <option value="multiselect" {{ ($attribute->field_type == 'multiselect' ? 'selected' : '') }}>Multi select</option>
			                                <option value="radio" {{ ($attribute->field_type == 'radio' ? 'selected' : '') }}>Radio option</option>
			                                <option value="checkbox" {{ ($attribute->field_type == 'checkbox' ? 'selected' : '') }}>Checkbox</option>
			                                <option value="file" {{ ($attribute->field_type == 'file' ? 'selected' : '') }}>File</option>
			                                <option value="date" {{ ($attribute->field_type == 'date' ? 'selected' : '') }}>Date</option>
			                            </select>
			                            <label id="field_type-error" class="error text-red hide" for="field_type"></label>
			                            @error('input_id')
			                                <span class="error input_id-error">{{ $message }}</span>
			                            @enderror
			                        </div>
			                        </div>
			                        <div class="text_fields row">

			                        </div>
			                        <div class="option_fields form-group">

			                        </div>
			                        <div class="row">
			                        <div class="form-group col-sm-4">
			                        	<label class="custom-switch form-label">
											<input type="checkbox" name="is_required" class="custom-switch-input" id="is_required" {{ $attribute->is_required == 1 ? 'checked' : '' }}>
											<span class="custom-switch-indicator"></span>
											<span class="custom-switch-description">Is Required?</span>
										</label>
			                        </div>

			                        <div class="form-group col-sm-12 validation_message">
			                            <label for="validation_message">Validation message(if Required)</label>
			                            <input class="form-control @error('validation_message') is-invalid @enderror" name="validation_message"
			                                placeholder="Enter validation message" type="text" value="{{ old('validation_message', $attribute->validation_message) }}"
			                                autocomplete="off" id="validation_message">
			                            <label id="validation_message-error" class="error text-red hide" for="validation_message"></label>
			                            @error('validation_message')
			                                <span class="error validation_message-error">{{ $message }}</span>
			                            @enderror
			                        </div>
			                        <div class="form-group col-sm-12">
			                            <label class="form-label" for="description">Description</label>
			                            <textarea class="form-control" name="description" autocomplete="off" id="description"
			                                placeholder="Enter Description" rows="3">{{ old('description', $attribute->description) }}</textarea>
			                        </div>
			                    </div>	
					            
							</div>
							<div class="card-footer text-right">
								<input title="Save attribute" class="btn btn-primary" type="submit"
			                        value="{{ $attribute->id == null ? 'Create' : 'Update' }}">
			                    <input title="Reset form" class="btn btn-warning" type="reset" value="Reset">
			                    <a title="Cancel form" href="{{ route('attribute.index') }}" class="btn btn-danger">Cancel</a>
							</div>
						</form>
					</div>
				</div>
				
			</div>
			<!-- End Row -->

		</div>
	</div><!-- end app-content-->
</div>
@endsection
@section('js')
		<!--INTERNAL Select2 js -->
		<script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
		<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
		<script src="{{URL::asset('assets/js/select2.js')}}"></script>

		<script>
        $(document).ready(function() {
            $(".validation_message").fadeOut("slow");
            $(".text_fields").fadeOut("slow");
            $(".option_fields").fadeOut("slow");
            var field_type = "{{ $attribute->field_type }}";
            var is_required = "{{ $attribute->is_required }}";
            if(is_required == 1) {
                $(".validation_message").fadeIn("slow");
            }
            if (field_type != '' || field_type != null) {
                $(".field_type").trigger('change');
            }
            $("#is_required").change(function() {
                var isChecked = $(this).is(":checked");
                if (isChecked) {
                    $(".validation_message").fadeIn("slow");
                } else {
                    $(".validation_message").fadeOut("slow");
                }
            });
        });
        $(".field_type").change(function() {
            var field_val = $(this).val();
            var text_html = '<div class="form-group col-sm-4"><label class="form-label" for="min_length">Min length </label><input class="form-control min_length" name="fields_info[min_length]" placeholder="Enter min length" type="text" value="" autocomplete="off"></div><div class="form-group col-sm-4"><label class="form-label" for="max_length">Max length </label><input class="form-control max_length" name="fields_info[max_length]" placeholder="Enter max length" type="text" value="" autocomplete="off"></div><div class="form-group col-sm-4"><label class="form-label" for="placeholder">Placeholder </label><input class="form-control placeholder" name="fields_info[placeholder]" placeholder="Enter placeholder" type="text" value="" autocomplete="off"></div>';
            var option_html = '<div class="themeSection" data-id="0"><div class="input-group mb-3"><input type="text" name="fields_info[0][value]" class="form-control m-input mr-2" placeholder="Enter value" autocomplete="off"><input type="text" name="fields_info[0][label]" class="form-control m-input mr-2" placeholder="Enter label" autocomplete="off"><div class="input-group-append"><button id="addRow" type="button" class="btn btn-info"><i class="fa fa-plus"></i></button></div></div></div><div id="newSection"></div>';
            if (field_val === 'text') {
                $('.text_fields').html(text_html);
                $(".text_fields").fadeIn("slow");
                $(".option_fields").fadeOut("slow");
                $('.option_fields').html('');
            } else if(field_val === 'select' || field_val === 'multiselect' || field_val === 'radio' || field_val === 'checkbox' ) {
                $(".option_fields").fadeIn("slow");
                $(".text_fields").fadeOut("slow");
                $('.text_fields').html('');
                $('.option_fields').html(option_html);
            } else {
                $('.text_fields').html('');
                $(".text_fields").fadeOut("slow");
                $(".option_fields").fadeOut("slow");
                $('.option_fields').html('');
            }
        });

        @if($data)
	        setTimeout(() => {
	            var fields_value = @json($data);
	            if (fields_value.length === undefined) {
	                $('.min_length').val(fields_value.min_length);
	                $('.max_length').val(fields_value.max_length);
	                $('.placeholder').val(fields_value.placeholder);
	            } else {
	                var html_data = [];
	                $.each(fields_value, function(index, value) {
	                    var html = '';
	                    html += '<div class="themeSection" data-id="'+index+'"><div class="input-group mb-3"><input type="text" name="fields_info['+index+'][value]" value="'+value.value+'" class="form-control m-input mr-2" placeholder="Enter value" autocomplete="off"><input type="text" name="fields_info['+index+'][label]" class="form-control m-input mr-2" value="'+value.label+'" placeholder="Enter label" autocomplete="off">';
	                    if(index == 0) {
	                        html += '<div class="input-group-append"><button id="addRow" type="button" class="btn btn-info"><i class="fa fa-plus"></i></button></div>';
	                    } else {
	                        html += '<div class="input-group-append">';
	                        html += '<button id="removeSection" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
	                        html += '</div>';
	                    }
	                    html += '</div></div><div id="newSection"></div>';
	                    html_data.push(html);
	                });
	                $('.option_fields').html(html_data);
	            }
	        }, 1000);
        @endif

        $('#attributeCreate').validate({
            rules: {
                name: {
                    required: true,
                },
                input_name: {
                    required: true,
                },
                input_class: {
                    required: true,
                },
                input_id: {
                    required: true,
                },
                field_type: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter name.",
                },
                input_name: {
                    required: "Please enter input name.",
                },
                input_class: {
                    required: "Please enter input class.",
                },
                input_id: {
                    required: "Please enter input id.",
                },
                field_type: {
                    required: "Please select field type.",
                }
            }
        });

        var index = 1;
        $(document).on("click", "#addRow", function () {
            var html = '';
            html += '<div class="themeSection" data-id="'+index+'">';
            html += '<div class="input-group mb-3">';
            html += '<input type="text" name="fields_info['+index+'][value]" class="form-control m-input mr-2" placeholder="Enter value" autocomplete="off">';
            html += '<input type="text" name="fields_info['+index+'][label]" class="form-control m-input mr-2" placeholder="Enter label" autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button id="removeSection" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            $('#newSection').append(html);
            index++;
        });

        $(document).on('click', '#removeSection', function () {
            $(this).closest('.themeSection').remove();
            index--;
        });
    </script>
@endsection