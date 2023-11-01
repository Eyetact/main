@extends('layouts.master')
@section('css')
		<!--INTERNAL Select2 css -->
		<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
         <style>
        p {
            font-size: 0.75em;
            font-weight: bold;
            position: absolute;
            top: 15%;
            width: 100%;
            letter-spacing: 5px;
            text-transform: uppercase;
            text-align: center;
            color: white;
            user-select: none;
        }
        .draggable-table {
            /*position: absolute;*/
            top: 25%;
            left: 20%;
            /*width: 60%;*/
            height: auto;
            border-collapse: collapse;
            /*background: white;*/
            /*-webkit-box-shadow: 0px 0px 10px 8px rgba(0, 0, 0, 0.1);*/
            /*box-shadow: 0px 0px 10px 8px rgba(0, 0, 0, 0.1);*/
        }
        .draggable-table .draggable-table__drag {
            font-size: 0.95em;
            font-weight: lighter;
            text-transform: capitalize;
            position: absolute;
            width: 100%;
            text-indent: 50px;
            border: 1px solid #f1f1f1;
            z-index: 10;
            cursor: grabbing;
            -webkit-box-shadow: 2px 2px 3px 0px rgba(0, 0, 0, 0.05);
            box-shadow: 2px 2px 3px 0px rgba(0, 0, 0, 0.05);
            opacity: 1;
        }
        .draggable-table thead th {
            /*height: 25px;*/
            /*font-weight: bold;*/
            /*text-transform: capitalize;*/
            /*padding: 10px;*/
            /*user-select: none;*/
        }
        .draggable-table tbody tr {
            /*cursor: grabbing;*/
        }
        .draggable-table tbody tr td {
            /*font-size: 0.95em;*/
            /*font-weight: lighter;*/
            /*text-transform: capitalize;*/
            /*text-indent: 50px;*/
            /*padding: 10px;*/
            user-select: none;
            /*border-top: 1px solid whitesmoke;*/
        }
        .draggable-table tbody tr {
            background-color: #ffffff;
        }
        .draggable-table tbody tr.is-dragging {
            background: #a99af7;
        }
        .draggable-table tbody tr.is-dragging td {
            color: #ffffff;
        }
    </style>
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
    // dump($data);
@endphp
			<form action="{{ $attribute->id == null ? route('attribute.store') : route('attribute.update', ['attribute' => $attribute->id]) }}" id="attributeCreate" method="POST" autocomplete="off">
				@csrf
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Basics</h3>
							</div>
							<div class="card-body pb-2">
			                    <div class="row">
			                    	<div class="col-sm-6 form-group">
										<label class="form-label" for="module">Module<span class="text-red">*</span></label>
										<select name="module" class="form-control module" id="module">
			                                <option value="" selected>Select Module</option>
			                                @foreach($moduleData as $module)
			                                	<option value="{{$module->id}}" {{ ($module->id == $attribute->module ? 'selected' : '') }}>{{$module->name}}</option>
			                                @endforeach
			                            </select>
			                            <label id="module-error" class="error text-red hide" for="module"></label>
			                            @error('module')
			                                <span class="error module-error">{{ $message }}</span>
			                            @enderror
			                        </div>
			                        <div class="col-sm-6 form-group">
										<label class="form-label" for="name">Label<span class="text-red">*</span></label>
										<input type="text" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name', $attribute->name) }}">
			                            <label id="name-error" class="error text-red hide" for="name"></label>
			                            @error('name')
			                                <span class="error name-error">{{ $message }}</span>
			                            @enderror
			                        </div>
			                        <div class="form-group col-sm-6">
			                            <label class="form-label" for="input_name">Code<span class="text-red">*</span></label>
			                            <input class="form-control @error('input_name') is-invalid @enderror" name="input_name"
			                                 type="text" value="{{ old('input_name', $attribute->input_name) }}"
			                                autocomplete="off">
			                            <label id="input_name-error" class="error text-red hide" for="input_name"></label>
			                            @error('input_name')
			                                <span class="error input_name-error">{{ $message }}</span>
			                            @enderror
			                        </div>
			                        <div class="form-group col-sm-6">
			                            <label class="form-label" for="input_class">Class<span class="text-red">*</span></label>
			                            <input class="form-control @error('input_class') is-invalid @enderror" name="input_class"
			                                 type="text" value="{{ old('input_class', $attribute->input_class) }}"
			                                autocomplete="off">
			                            <label id="input_class-error" class="error text-red hide" for="input_class"></label>
			                            @error('input_class')
			                                <span class="error input_class-error">{{ $message }}</span>
			                            @enderror
			                        </div>
			                        <div class="form-group col-sm-6">
			                            <label class="form-label" for="input_id">ID<span class="text-red">*</span></label>
			                            <input class="form-control @error('input_id') is-invalid @enderror" name="input_id"
			                                 type="text" value="{{ old('input_id', $attribute->input_id) }}"
			                                autocomplete="off">
			                            <label id="input_id-error" class="error text-red hide" for="input_id"></label>
			                            @error('input_id')
			                                <span class="error input_id-error">{{ $message }}</span>
			                            @enderror
			                        </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
			                        	<label class="custom-switch form-label">
											<input type="checkbox" name="is_enable" class="custom-switch-input" id="is_enable" {{ $attribute->is_enable == 1 ? 'checked' : '' }}>
											<span class="custom-switch-indicator"></span>
											<span class="custom-switch-description">Status</span>
										</label>
			                        </div>
			                        <div class="form-group col-sm-6">
			                        	<label class="custom-switch form-label">
											<input type="checkbox" name="is_system" class="custom-switch-input" id="is_system" {{ $attribute->is_system == 1 ? 'checked' : '' }}>
											<span class="custom-switch-indicator"></span>
											<span class="custom-switch-description">System (This attribute is only available for admin)</span>
										</label>
			                        </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label class="form-label">Select Attribute type<span class="text-red">*</span></label>
                                        <select name="field_type" class="form-control field_type" id="field_type">
                                            <option value="" selected>Please select attribute field type</option>
                                            <option value="text" {{ ($attribute->field_type == 'text' ? 'selected' : '') }}>Text</option>
                                            <option value="email" {{ ($attribute->field_type == 'email' ? 'selected' : '') }}>Email</option>
                                            <option value="number" {{ ($attribute->field_type == 'number' ? 'selected' : '') }}>Number</option>
                                            <option value="date" {{ ($attribute->field_type == 'date' ? 'selected' : '') }}>Date</option>
                                            <option value="date" {{ ($attribute->field_type == 'date' ? 'selected' : '') }}>Date and Time</option>
                                            <option value="textarea" {{ ($attribute->field_type == 'textarea' ? 'selected' : '') }}>Textarea</option>
                                            <option value="select" {{ ($attribute->field_type == 'select' ? 'selected' : '') }}>Dropdown</option>
                                            <option value="multiselect" {{ ($attribute->field_type == 'multiselect' ? 'selected' : '') }}>Multiple Select</option>
                                            <option value="switch" {{ ($attribute->field_type == 'switch' ? 'selected' : '') }}>Yes/No</option>
                                            <option value="radio" {{ ($attribute->field_type == 'radio' ? 'selected' : '') }}>Radiobox</option>
                                            <option value="checkbox" {{ ($attribute->field_type == 'checkbox' ? 'selected' : '') }}>Checkbox</option>
                                            <option value="file" {{ ($attribute->field_type == 'file' ? 'selected' : '') }}>File</option>
                                        </select>
                                        <label id="field_type-error" class="error text-red hide" for="field_type"></label>
                                        @error('field_type')
                                            <span class="error field_type-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text_fields row">

                                </div>
                                <div class="file_fields row">

                                </div>
                                <div class="option_fields">
                                    <div class="table-responsive">
                                        <table class="table card-table table-vcenter text-nowrap table-light draggable-table" id="type_options">
                                            <thead class="bg-gray-700 text-white">
                                                <tr>
                                                    <th></th>
                                                    <th class="text-white">Is Default</th>
                                                    <th class="text-white">Label</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4"><button id="addRow" type="button" class="btn btn-info">Add Option</button></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                {{-- <div class="row">
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
                                        @error('field_type')
                                            <span class="error field_type-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text_fields row">

                                </div>
                                <div class="option_fields form-group">

                                </div> --}}


							</div>
						</div>
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Admin</h3>
							</div>
							<div class="card-body pb-2">
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label class="form-label">Values Required</label>
                                        <select name="is_required" class="form-control is_required" id="is_required">
                                            <option value="0" selected>No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label class="form-label">Validation</label>
                                        <select name="validation" class="form-control validation" id="validation">
                                            <option value="" selected>None</option>
                                            <option value="dec">Decimal Numbers</option>
                                            <option value="int">Integer Number</option>
                                            <option value="mail">Email</option>
                                            <option value="url">URL</option>
                                            <option value="ltr">Letters</option>
                                            <option value="ltrn">Letters (a-z, A-Z) or Numbers (0-9)</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label class="form-label">Scope</label>
                                        <select name="scope" class="form-control scope" id="scope">
                                            <option value="" selected>None</option>
                                            <option value="global">Global</option>
                                            <option value="admin">Admin</option>
                                            <option value="vendor">Vendor</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label class="form-label">Dependability</label>
                                        <select name="depend" class="form-control depend" id="depend">
                                            <option value="" selected>None</option>
                                            <option value="not_visible">Not Visible</option>
                                            <option value="disabled">Disabled</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 hide" id="attr_div">
                                        <label class="form-label">Attribute</label>
                                        <select name="attribute" class="form-control attribute" id="attribute">
                                            <option value="" selected>None</option>
                                            <option value="module">Module</option>
                                            <option value="not_visible">Not Visible</option>
                                            <option value="disabled">Disabled</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label class="form-label" for="description">Tip</label>
                                        <textarea class="form-control" name="description" autocomplete="off" id="description"
                                             rows="1">{{ old('description', $attribute->description) }}</textarea>
                                    </div>
                                </div>
							</div>
						</div>
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Storefront</h3>
							</div>
							<div class="card-body pb-2">
							</div>
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
			<!-- End Row -->

		</div>
	</div><!-- end app-content-->
</div>
@endsection
@section('js')
		<!--INTERNAL Select2 js -->
		<!-- <script src="{{ asset('assets/js/jquery.validate.js') }}"></script> -->
		<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
		<script src="{{URL::asset('assets/js/select2.js')}}"></script>

		<script>
        $(document).ready(function() {
            $(".validation_message").fadeOut("slow");
            $(".text_fields").fadeOut("slow");
            $(".option_fields").fadeOut("slow");
            $(".file_fields").fadeOut("slow");
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
        $("#depend").change(function() {
            var depend=$(this).val();
            if(depend==""){
                $("#attr_div").hide();
            }else{
                $("#attr_div").show();
            }
        });

        $(".field_type").change(function() {
            $(".text_fields").fadeOut("slow");
            $(".option_fields").fadeOut("slow");
            $(".file_fields").fadeOut("slow");
            // $('.option_fields').html('');
            // $('.text_fields').html('');
            // $(".file_fields").html('');

            var field_val = $(this).val();
            var text_html = '<div class="form-group col-sm-6"><label class="form-label" for="min_length">Min length </label><input class="form-control min_length" name="fields_info[min_length]"  type="text" value="" autocomplete="off"></div><div class="form-group col-sm-6"><label class="form-label" for="max_length">Max length </label><input class="form-control max_length" name="fields_info[max_length]"  type="text" value="" autocomplete="off"></div>';
            // var option_html = '<tr><td scope="row"></td><td><input type="radio" name="fields_info[0][default]" class="m-input mr-2"></td><td><input type="text" name="fields_info[0][value]" class="form-control m-input mr-2"  autocomplete="off"></td><td><button type="button" class="btn btn-danger removeSection"><i class="fa fa-trash"></i></button></td></tr>';
            var file_html = '<div class="form-group col-sm-6"> <label class="form-label" for="file_ext">Allowed Extension</label> <select name="fields_info[file_ext]" class="form-control fields_info[file_ext]" multiple> <option value="" selected>Allowed Extension</option> <option value="doc">Document(PDF/Doc/Docx)</option> <option value="image">Image(jpg/jpeg/png/svg)</option> <option value="media">Media(mp3/mp4)</option> </select> </div> <div class="form-group col-sm-6"><label class="form-label" for="max_length">File Size</label> <select name="fields_info[file_size]" class="form-control fields_info[file_size]"> <option value="" selected>File Size</option> <option value="1">1 mb</option> <option value="2">2 mb</option> <option value="3">3 mb</option> <option value="4">4 mb</option> <option value="5">5 mb</option> <option value="6">6 mb</option> <option value="7">7 mb</option> <option value="8">8 mb</option> <option value="9">9 mb</option> <option value="10">10 mb</option> </select> </div>';
            if (field_val === 'text') {
                $('.text_fields').html(text_html);
                $(".text_fields").fadeIn("slow");
            } else if(field_val === 'select' || field_val === 'multiselect' || field_val === 'radio' || field_val === 'checkbox' ) {
                // $('.option_fields tbody').html(option_html);
                $(".option_fields").fadeIn("slow");
            } else if(field_val === 'file'){
                $(".file_fields").html(file_html);
                $(".file_fields").fadeIn("slow");
            }
        });

        @if($data)
	        // setTimeout(() => {
	            var fields_value = @json($data);
                var field_type_val=$("#field_type").val();
                console.log(fields_value,$.type(fields_value),Object.keys(fields_value).length);
	            if (field_type_val == 'text') {
	                $('.min_length').val(fields_value.min_length);
	                $('.max_length').val(fields_value.max_length);
	            } else if(field_type_val == 'file'){

                } else {
	                var html_data = [];
	                $.each(fields_value, function(index, value) {
                        console.log(index,value.value);
	                    var html = '';
	                    html += '<tr><td scope="row"></td><td><input type="radio" onchange="addValue('+index+')" class="m-input mr-2"' + (value.default == 1 ? ' checked' : '') + '><input type="hidden" value="'+value.default+'" id="fields_info['+index+'][default]" name="fields_info['+index+'][default]"></td><td><input type="text" name="fields_info['+index+'][value]" class="form-control m-input mr-2" value="'+value.value+'" autocomplete="off"></td><td><button type="button" class="btn btn-danger removeSection"><i class="fa fa-trash"></i></button></td></tr>';
	                    html_data.push(html);
	                });
                    console.log(html_data);
	                $('.option_fields tbody').append(html_data);
	            }
	        // }, 1000);
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
            html += '<tr><td scope="row"></td><td><input type="radio" onchange="addValue('+index+')" class="m-input mr-2"><input type="hidden" value="0" id="fields_info['+index+'][default]" name="fields_info['+index+'][default]"></td><td><input type="text" name="fields_info['+index+'][value]" class="form-control m-input mr-2"  autocomplete="off"></td><td><button type="button" class="btn btn-danger removeSection"><i class="fa fa-trash"></i></button></td></tr>';
            $('.option_fields tbody').append(html);
            index++;
        });

        function addValue(index){
            console.log(index);
            $('[id^="fields_info"]').each(function() {
                $(this).val(0);
            });
            $("#fields_info\\[" + index + "\\]\\[default\\]").val(1);

        }




        $(document).on('click', '.removeSection', function () {
            $(this).closest('tr').remove();
            index--;
        });
    </script>

    <script>
        (function () {
            "use strict";
            const table = document.getElementById("type_options");
            const tbody = table.querySelector("tbody");
            var currRow = null,
                dragElem = null,
                mouseDownX = 0,
                mouseDownY = 0,
                mouseX = 0,
                mouseY = 0,
                mouseDrag = false;
            function init() {
                bindMouse();
            }
            function bindMouse() {
                document.addEventListener("mousedown", (event) => {
                    if (event.button != 0) return true;
                    let target = getTargetRow(event.target);
                    if (target) {
                        currRow = target;
                        addDraggableRow(target);
                        currRow.classList.add("is-dragging");
                        let coords = getMouseCoords(event);
                        mouseDownX = coords.x;
                        mouseDownY = coords.y;
                        mouseDrag = true;
                    }
                });
                document.addEventListener("mousemove", (event) => {
                    if (!mouseDrag) return;
                    let coords = getMouseCoords(event);
                    mouseX = coords.x - mouseDownX;
                    mouseY = coords.y - mouseDownY;
                    moveRow(mouseX, mouseY);
                });
                document.addEventListener("mouseup", (event) => {
                    if (!mouseDrag) return;
                    currRow.classList.remove("is-dragging");
                    table.removeChild(dragElem);
                    dragElem = null;
                    mouseDrag = false;
                });
            }
            function swapRow(row, index) {
                let currIndex = Array.from(tbody.children).indexOf(currRow),
                    row1 = currIndex > index ? currRow : row,
                    row2 = currIndex > index ? row : currRow;
                tbody.insertBefore(row1, row2);
            }
            function moveRow(x, y) {
                dragElem.style.transform = "translate3d(" + x + "px, " + y + "px, 0)";
                let dPos = dragElem.getBoundingClientRect(),
                    currStartY = dPos.y,
                    currEndY = currStartY + dPos.height,
                    rows = getRows();
                for (var i = 0; i < rows.length; i++) {
                    let rowElem = rows[i],
                        rowSize = rowElem.getBoundingClientRect(),
                        rowStartY = rowSize.y,
                        rowEndY = rowStartY + rowSize.height;
                    if (
                        currRow !== rowElem &&
                        isIntersecting(currStartY, currEndY, rowStartY, rowEndY)
                    ) {
                        if (Math.abs(currStartY - rowStartY) < rowSize.height / 2)
                            swapRow(rowElem, i);
                    }
                }
            }
            function addDraggableRow(target) {
                dragElem = target.cloneNode(true);
                dragElem.classList.add("draggable-table__drag");
                dragElem.style.height = getStyle(target, "height");
                dragElem.style.background = getStyle(target, "backgroundColor");
                for (var i = 0; i < target.children.length; i++) {
                    let oldTD = target.children[i],
                        newTD = dragElem.children[i];
                    newTD.style.width = getStyle(oldTD, "width");
                    newTD.style.height = getStyle(oldTD, "height");
                    newTD.style.padding = getStyle(oldTD, "padding");
                    newTD.style.margin = getStyle(oldTD, "margin");
                }
                table.appendChild(dragElem);
                let tPos = target.getBoundingClientRect(),
                    dPos = dragElem.getBoundingClientRect();
                dragElem.style.bottom = dPos.y - tPos.y - tPos.height + "px";
                dragElem.style.left = "-1px";
                document.dispatchEvent(
                    new MouseEvent("mousemove", {
                        view: window,
                        cancelable: true,
                        bubbles: true
                    })
                );
            }
            function getRows() {
                return table.querySelectorAll("tbody tr");
            }
            function getTargetRow(target) {
                let elemName = target.tagName.toLowerCase();
                if (elemName == "tr") return target;
                if (elemName == "td") return target.closest("tr");
            }
            function getMouseCoords(event) {
                return {
                    x: event.clientX,
                    y: event.clientY
                };
            }
            function getStyle(target, styleName) {
                let compStyle = getComputedStyle(target),
                    style = compStyle[styleName];
                return style ? style : null;
            }
            function isIntersecting(min0, max0, min1, max1) {
                return (
                    Math.max(min0, max0) >= Math.min(min1, max1) &&
                    Math.min(min0, max0) <= Math.max(min1, max1)
                );
            }
            init();
        })();
    </script>
@endsection
