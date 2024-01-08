@php
    $data = json_decode($attribute->fields_info, true);
    // dump($data);
@endphp
<form
    action="{{ $attribute->id == null ? route('attribute.store') : route('attribute.update', ['attribute' => $attribute->id]) }}"
    id="attributeCreate" method="POST" autocomplete="off" enctype="multipart/form-data">
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
                                @foreach ($moduleData as $module)
                                    <option value="{{ $module->id }}"
                                        {{ $module->id == $attribute->module ? 'selected' : '' }}>{{ $module->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label id="module-error" class="error text-red hide" for="module"></label>
                            @error('module')
                                <span class="error module-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form-label" for="name">Label<span class="text-red">*</span></label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $attribute->name) }}">
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
                                type="text" value="{{ old('input_id', $attribute->input_id) }}" autocomplete="off">
                            <label id="input_id-error" class="error text-red hide" for="input_id"></label>
                            @error('input_id')
                                <span class="error input_id-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="custom-switch form-label">
                                <input type="checkbox" name="is_enable" class="custom-switch-input" id="is_enable"
                                    {{ $attribute->is_enable == 1 ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Status</span>
                            </label>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="custom-switch form-label">
                                <input type="checkbox" name="is_system" class="custom-switch-input" id="is_system"
                                    {{ $attribute->is_system == 1 ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">System (This attribute is only available for
                                    admin)</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="form-label">Select Attribute type<span class="text-red">*</span></label>
                            <select name="field_type" class="form-control field_type" id="field_type">
                                <option value="" selected>Please select attribute field type</option>
                                <option value="text" {{ $attribute->field_type == 'text' ? 'selected' : '' }}>Text
                                </option>
                                <option value="email" {{ $attribute->field_type == 'email' ? 'selected' : '' }}>
                                    Email</option>
                                <option value="number" {{ $attribute->field_type == 'number' ? 'selected' : '' }}>
                                    Number</option>
                                <option value="date" {{ $attribute->field_type == 'date' ? 'selected' : '' }}>Date
                                </option>
                                <option value="date" {{ $attribute->field_type == 'date' ? 'selected' : '' }}>Date
                                    and Time</option>
                                <option value="textarea"
                                    {{ $attribute->field_type == 'textarea' ? 'selected' : '' }}>Textarea</option>
                                <option value="select" {{ $attribute->field_type == 'select' ? 'selected' : '' }}>
                                    Dropdown</option>
                                <option value="multiselect"
                                    {{ $attribute->field_type == 'multiselect' ? 'selected' : '' }}>Multiple Select
                                </option>
                                <option value="switch" {{ $attribute->field_type == 'switch' ? 'selected' : '' }}>
                                    Yes/No</option>
                                <option value="radio" {{ $attribute->field_type == 'radio' ? 'selected' : '' }}>
                                    Radiobox</option>
                                <option value="checkbox"
                                    {{ $attribute->field_type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                <option value="file" {{ $attribute->field_type == 'file' ? 'selected' : '' }}>File
                                </option>
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
                            <table class="table card-table table-vcenter text-nowrap table-light draggable-table"
                                id="type_options">
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
                                        <th colspan="4"><button id="addRow" type="button"
                                                class="btn btn-info">Add Option</button></th>
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
                            <textarea class="form-control" name="description" autocomplete="off" id="description" rows="1">{{ old('description', $attribute->description) }}</textarea>
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
