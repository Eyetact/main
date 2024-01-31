@php
    $data = json_decode($attribute->fields_info, true);
    // dump($data);
@endphp
<form action="{{ route('attribute.update', $attribute->id) }}" id="attributeCreate" method="POST" autocomplete="off"
    enctype="multipart/form-data">
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
                            <select disabled name="module" class="google-input module" id="module" required>
                                <option value="{{ $module->id }}" selected>{{ $module->name }}</option>

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
                            @error('name')
                                <span class="error name-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-12 input-box">
                            <label class="form-label" for="code">Code<span class="text-red">*</span></label>
                            <input disabled type="text" name="code"
                                class="google-input @error('code') is-invalid @enderror"
                                value="{{ old('code', $attribute->code) }}">
                                <small class="text-secondary">
                                    <ul class="my-1 mx-2 p-0">
                                        <li>is not allowed to use numbers or ( ID word ) or symbols</li>
                                    </ul>
                                </small>
                            @error('code')
                                <span class="error code-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">

                        <div class="input-box col-sm-12">
                            <label class="form-label">Select Attribute type<span class="text-red">*</span></label>
                            <select disabled name="input_types" class="form-select form-input-types  google-input" required>
                                <option @selected( $attribute->input == "" ) value="" disabled selected>-- {{ __('Select input type') }}--</option>
                                <option @selected( $attribute->input == "multi" ) value="multi">Multi Attribute</option>
                                <option @selected( $attribute->input == "text" ) value="text">Text</option>
                                <option @selected( $attribute->input == "textarea" ) value="textarea">Textarea</option>
                                <option @selected( $attribute->input == "email" ) value="email">Email</option>
                                <option @selected( $attribute->input == "tel" ) value="tel">Telepon</option>
                                <option @selected( $attribute->input == "password" ) value="password">Password</option>
                                <option @selected( $attribute->input == "url" ) value="url">Url</option>
                                <option @selected( $attribute->input == "search" ) value="search">Search</option>
                                <option @selected( $attribute->input == "image" ) value="image">Image</option>
                                <option @selected( $attribute->input == "file" ) value="file">File</option>
                                <option @selected( $attribute->input == "number" ) value="number">Number</option>
                                <option @selected( $attribute->input == "range" ) value="range">Range</option>
                                <option @selected( $attribute->input == "radio" ) value="radio">Radio ( True, False )</option>
                                <option @selected( $attribute->input == "date" ) value="date">Date</option>
                                <option @selected( $attribute->input == "month" ) value="month">Month</option>
                                <option @selected( $attribute->input == "time" ) value="time">Time</option>
                                <option @selected( $attribute->input == "datalist" ) value="datalist">Datalist ( Year List )</option>
                                <option @selected( $attribute->input == "datetime-local" ) value="datetime-local">Datetime local</option>
                                <option @selected( $attribute->input == "select" ) value="select">Select</option>
                                <option @selected( $attribute->input == "foreignId" ) value="foreignId">Lookup</option>
                            </select>
                            <label id="field_type-error" class="error text-red hide" for="field_type"></label>
                            @error('field_type')
                                <span class="error field_type-error">{{ $message }}</span>
                            @enderror
                            <div class="input-options">
                               @if ($attribute->input == "multi")
                               <div class="multi-options">
                                <div class="attr_header row flex justify-content-end my-5 align-items-end">
                                    <input title="Reset form" class="btn btn-success" id="add_new_tr" type="button"
                                        value="+ Add">
                                </div>

                                <table class="table table-bordered align-items-center mb-0" id="tbl-field">
                                    <thead>
                                        <tr>
                                            <th width="30">#</th>
                                            <th>{{ __('Field name') }}</th>
                                            <th>{{ __('Column Type') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @foreach ($attribute->multis as $index => $multi )

                                        @php
                                            $index += 1;
                                        @endphp
                                        <tr draggable="true" containment="tbody" ondragstart="dragStart()"
                                            ondragover="dragOver()" style="cursor: move;">
                                            <td class="text-center">
                                                <div class="input-box">

                                                {{$index}}

                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-box">
                                                    <input type="text" name="multi[{{$index}}][name]"
                                                        class="form-control google-input"
                                                        placeholder="{{ __('Field Name') }}" value="{{$multi->name}}" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-box">
                                                    <select name="multi[{{$index}}][type]"
                                                        class="form-select  google-input multi-type" required>
                                                        <option value="" disabled selected>
                                                            --{{ __('Select column type') }}--
                                                        </option>
                                                        <option @selected( $multi->type == "text" ) value="text">Text</option>
                                                        <option @selected( $multi->type == "textarea" ) value="textarea">Textarea</option>
                                                        <option @selected( $multi->type == "email" ) value="email">Email</option>
                                                        <option @selected( $multi->type == "tel" ) value="tel">Telepon</option>
                                                        <option @selected( $multi->type == "url" ) value="url">Url</option>
                                                        <option @selected( $multi->type == "search" ) value="search">Search</option>
                                                        <option @selected( $multi->type == "number" ) value="number">Number</option>
                                                        <option @selected( $multi->type == "radio" ) value="radio">Radio ( True, False )</option>
                                                        <option @selected( $multi->type == "date" ) value="date">Date</option>
                                                        <option @selected( $multi->type == "time" ) value="time">Time</option>
                                                        <option @selected( $multi->type == "select" ) value="select">Select</option>
                                                        <option @selected( $multi->type == "foreignId" ) value="foreignId">Lookup</option>

                                                    </select>
                                                </div>
                                                <div class="select_options">
                                                  @if ($multi->type == "select")

                                                  <div class="input-box s-option mt-2">
                                                    <input type="text" name="multi[{{$index}}][select_options]" value="{{$multi->select_options}}" class="google-input" placeholder="Seperate with '|', e.g.: water|fire">
                                                </div>

                                                  @endif

                                                  @if ($multi->type == "foreignId")

                                                  <div class="input-box c-f form-constrain mt-2">
                                                    <div class="input-box form-on-update mt-2 form-on-update-foreign">
                                                        <select class="google-input select-module" name="multi[{{$index}}][constrain]" required>
                                                            @foreach (\App\Models\Module::all() as $key => $value)
                                                                <option data-id="{{ $value->id }}" value="{{ $value->code }}" @selected($value->code == $multi->constrain) >{{ $value->name }}</option>;
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <small class="text-secondary">
                                                        <ul class="my-1 mx-2 p-0">
                                                            <li>Use '/' if related model at sub folder, e.g.: Main/Product.</li>
                                                            <li>Field name must be related model + "_id", e.g.: user_id</li>
                                                        </ul>
                                                    </small>

                                                    @php
                                                        $module = \App\Models\Module::where('name', $multi->constrain)->first();
                                                    @endphp

                                                <div class="input-box child-drop form-constrain mt-2">
                                                    <div class="input-box form-on-update mt-2 form-on-update-foreign">
                                                        <select class="google-input " name="multi[{{$index}}][attribute]" required>
                                                            @foreach ($module->fields as $key => $value)
                                                            <option data-id="{{ $value->id }}" value="{{ $value->code }}" @selected($value->code == $multi->attribute) >{{ $value->name }}</option>;
                                                        @endforeach
                                                        </select>
                                                    </div></div>
                                                </div>

                                                  @endif

                                                </div>
                                            </td>





                                            <td>
                                                <div class="input-box">

                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-xs btn-delete">
                                                        x
                                                    </button>
                                                </div>
                                            </td>

                                        </tr>

                                        @endforeach



                                    </tbody>
                                </table>
                            </div>

                               @endif


                            </div>

                            {{-- <div class="multi">
                                <div class="attr_header row flex justify-content-end my-5 align-items-end pr-5">
                                    <input title="Reset form" class="btn btn-success" id="add_new" type="button"
                                        value="+ Add Another">
                                </div>

                                <div class="multi-item">
                                    <input type="text" name="name" value="Size" class="google-input" />
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="attr_header row flex justify-content-end my-5 align-items-end pr-5">
                                                <input title="Reset form" class="btn btn-success" id="add_new" type="button"
                                                    value="+ Add Value">
                                            </div>
                                            <ul>
                                                <li><input type="text" name="name" value="S" class="google-input" />
                                                </li>
                                                <li><input type="text" name="name" value="M" class="google-input" />
                                                </li>
                                                <li><input type="text" name="name" value="L" class="google-input" />
                                                </li>
                                                <li><input type="text" name="name" value="XL" class="google-input" />
                                                </li>
                                                <li><input type="text" name="name" value="XXL" class="google-input" />
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-4">
                                            <div class="attr_header row flex justify-content-end my-5 align-items-end pr-5">
                                                <input title="Reset form" class="btn btn-success" id="add_new" type="button"
                                                    value="+ Add Extra">
                                            </div>
                                            <ul>
                                                <li><input type="text" name="name" value="QTY" class="google-input" /></li>
                                                <li><input type="text" name="name" value="Price" class="google-input" /></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div> --}}

                        </div>
                    </div>
                    <div class="input-box col-sm-12">
                        {{-- <label class="form-label">Select Colmun type<span class="text-red">*</span></label> --}}

                        {{-- <select name="column_types" class="form-select  google-input form-column-types" required>
                                <option value="" disabled selected>--{{ __('Select column type') }}--
                                </option>
                                @foreach (['string', 'integer', 'text', 'bigInteger', 'boolean', 'char', 'date', 'time', 'year', 'dateTime', 'decimal', 'double', 'enum', 'float', 'foreignId', 'tinyInteger', 'mediumInteger', 'tinyText', 'mediumText', 'longText'] as $type)
                                    <option value="{{ $type }}">{{ ucwords($type) }}</option>
                                @endforeach
                            </select> --}}

                        <input type="hidden" name="column_types" id="type" class="form-column-types" />


                        <div class="options">
                            <input type="hidden" name="select_options" class="form-option">
                            <input type="hidden" name="constrains" class="form-constrain">
                            <input type="hidden" name="foreign_ids" class="form-foreign-id">

                        </div>
                    </div>
                </div>
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
