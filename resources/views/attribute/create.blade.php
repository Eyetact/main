@php
    $data = json_decode($attribute->fields_info, true);
    // dump($data);
@endphp
<form
    action="{{ route('attribute.store') }}"
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
                        <div class="col-sm-12 input-box">
                            <label class="form-label" for="module">Module<span class="text-red">*</span></label>
                            <select name="module" class="google-input module" id="module">
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
                        <div class="col-sm-12 input-box">
                            <label class="form-label" for="name">Name<span class="text-red">*</span></label>
                            <input type="text" name="name"
                                class="google-input @error('name') is-invalid @enderror"
                                value="{{ old('name', $attribute->name) }}">
                            <label id="name-error" class="error text-red hide" for="name"></label>
                            @error('name')
                                <span class="error name-error">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                    <div class="row">
                        <div class="input-box col-sm-12">
                            <label class="form-label">Select Colmun type<span class="text-red">*</span></label>

                            <select name="column_types" class="form-select  google-input form-column-types" required>
                                <option value="" disabled selected>--{{ __('Select column type') }}--
                                </option>
                                @foreach (['string', 'integer', 'text', 'bigInteger', 'boolean', 'char', 'date', 'time', 'year', 'dateTime', 'decimal', 'double', 'enum', 'float', 'foreignId', 'tinyInteger', 'mediumInteger', 'tinyText', 'mediumText', 'longText'] as $type)
                                    <option value="{{ $type }}">{{ ucwords($type) }}</option>
                                @endforeach
                            </select>


                            <div class="options">
                                <input type="hidden" name="select_options" class="form-option">
                                            <input type="hidden" name="constrains" class="form-constrain">
                                            <input type="hidden" name="foreign_ids" class="form-foreign-id">
                            </div>
                        </div>
                        <div class="input-box col-sm-12">
                            <label class="form-label">Select Attribute type<span class="text-red">*</span></label>
                            <select name="input_types" class="form-select form-input-types  google-input" required>
                                <option value="" disabled selected>-- {{ __('Select input type') }}
                                    --</option>
                                <option value="" disabled>{{ __('Select the column type first') }}
                                </option>
                            </select>
                            <label id="field_type-error" class="error text-red hide" for="field_type"></label>
                            @error('field_type')
                                <span class="error field_type-error">{{ $message }}</span>
                            @enderror
                            <div class="input-options"></div>
                        </div>
                    </div>
                    <div class="text_fields row">

                    </div>
                    <div class="file_fields row">

                    </div>
                    



                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Admin</h3>
                </div>
                <div class="card-body pb-2">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="custom-switch form-label">
                                <input type="checkbox" name="is_enable" class="custom-switch-input" id="is_enable"
                                    {{ $attribute->is_enable == 1 ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Status</span>
                            </label>
                        </div>
                        <div class="form-group col-sm-8">
                            <label class="custom-switch form-label">
                                <input type="checkbox" name="is_system" class="custom-switch-input" id="is_system"
                                    {{ $attribute->is_system == 1 ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">System (This attribute is only available for
                                    admin)</span>
                            </label>
                        </div>
                        <div class="col-md-12">
                            <div class="row align-items-center justify-content-center">
                                <div class="form-group col-md-4">
                                    <label class="custom-switch form-label">
                                        <input type="checkbox" name="requireds"
                                            class="custom-switch-input switch-requireds" id="requireds" checked>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Required</span>
                                    </label>
                                </div>
                                <div class="custom-values col-md-8"></div>

                            </div>
                        </div>
                        <input type="hidden" name="default_values" class="form-default-value"
                            placeholder="{{ __('Default Value (optional)') }}">

                        <div class="col-md-6">
                            <div class="input-box">
                                <input type="number" name="min_lengths"
                                    class=" google-input form-control form-min-lengths" min="1"
                                    placeholder="Min">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-box">
                                <input type="number" name="max_lengths"
                                    class="  google-input form-control form-max-lengths" min="1"
                                    placeholder="Max">
                            </div>
                        </div>
                    </div>
                </div>


                {{-- <div class="row">
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
                </div> --}}
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-header">
                <h3 class="card-title">Storefront</h3>
            </div>
            <div class="card-body pb-2">
            </div>
        </div> --}}

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
