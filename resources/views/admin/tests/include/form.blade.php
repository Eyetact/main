<div class="row mb-2">
    <div class="col-md-12">
        <div class="input-box">
            <label for="color">{{ __('Color') }}</label>
            <select class="google-input @error('color[]') is-invalid @enderror" name="color[]" id="color" class="form-control" required multiple>
                <option value="" selected disabled>-- {{ __('Select color') }} --</option>
                <option value="red" {{ isset($test) && (is_array( json_decode($test->color)) ?in_array('red', json_decode($test->color)) : $test->color == 'red') ? 'selected' :'' }}>red</option>
		<option value="blue" {{ isset($test) && (is_array( json_decode($test->color)) ?in_array('blue', json_decode($test->color)) : $test->color == 'blue') ? 'selected' :'' }}>blue</option>
		<option value="black" {{ isset($test) && (is_array( json_decode($test->color)) ?in_array('black', json_decode($test->color)) : $test->color == 'black') ? 'selected' :'' }}>black</option>
		<option value="white" {{ isset($test) && (is_array( json_decode($test->color)) ?in_array('white', json_decode($test->color)) : $test->color == 'white') ? 'selected' :'' }}>white</option>
		<option value="green" {{ isset($test) && (is_array( json_decode($test->color)) ?in_array('green', json_decode($test->color)) : $test->color == 'green') ? 'selected' :'' }}>green</option>
            </select>
            @error('color[]')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-box">
            <label for="material-id">{{ __('Material') }}</label>
            <select class="google-input @error('material_id') is-invalid @enderror" name="material_id" id="material-id" class="form-control" required >
                <option value="" selected disabled>-- {{ __('Select material') }} --</option>

                        @foreach ($materials as $material)
                            <option value="{{ $material->id }}" {{ isset($test) && $test->material_id == $material->id ? 'selected' : (old('material_id') == $material->id ? 'selected' : '') }}>
                                {{ $material->material_name }}
                            </option>
                        @endforeach
            </select>
            @error('material_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
<div class="multi-options col-12">
                        <div class="attr_header row flex justify-content-end my-5 align-items-end">
                            <input title="Reset form" class="btn btn-success" id="add_new_tr_13" type="button" value="+ Add">
                        </div>
                        @if(isset($test)  && $test->multi!= null )
                        @php

                        $ar = json_decode($test->multi);
                        $index = 0;
                        @endphp
                        @endif

                        <input type="hidden"  name="multi" />

                        <table class="table table-bordered align-items-center mb-0" id="tbl-field-13">
                        <thead><th>mat</th><th>name</th><th>sku</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @if(isset($test)  && $test->multi!= null )

                        @foreach( $ar as $item )
                        @php
                            $index++;
                        @endphp
                        <tr draggable="true" containment="tbody" ondragstart="dragStart()" ondragover="dragOver()" style="cursor: move;"><td><div class="input-box"> <select name="multi[{{ $index }}][mat]" class="form-select  google-input multi-type" required="">@foreach( \App\Models\Material::all() as $item2 )<option @selected( $item->mat == "$item2->material_name" )  value="{{ $item2->material_name}}" >{{ $item2->material_name}}</option>@endforeach</select></div></td> <td>
                                        <div class="input-box">
                                            <input type="text" name="multi[{{ $index }}][name]"
                                                class="form-control google-input"
                                                placeholder="name" value="{{ $item->name }}" required>
                                        </div>
                                    </td>
                                     <td>
                                        <div class="input-box">
                                            <input type="number" name="multi[{{ $index }}][sku]"
                                                class="form-control google-input"
                                                placeholder="sku" value="{{ $item?->sku }}" required>
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
                        @endif
                        </tbody>
                        </table>
                        </div>
                        </div>
