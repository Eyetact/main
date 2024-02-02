<div class="row mb-2">
    <div class="col-md-12">
        <div class="input-box">
            <label class="input-label" for="name">{{ __('Name') }}</label>
            <input type="text" name="material_name" id="name" class="google-input @error('material_name') is-invalid @enderror" value="{{ isset($material) ? $material->material_name : old('material_name') }}"  required />
            @error('material_name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-box">
            <label class="input-label" for="id">{{ __('Id') }}</label>
            <input type="text" name="material_id" id="id" class="google-input @error('material_id') is-invalid @enderror" value="{{ isset($material) ? $material->material_id : old('material_id') }}"  required />
            @error('material_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
<div class="multi-options col-12">
                        <div class="attr_header row flex justify-content-end my-5 align-items-end">
                            <input title="Reset form" class="btn btn-success" id="add_new_tr_3" type="button" value="+ Add">
                        </div>
                        @if(isset($material)  && $material->materials_eu_category!= null )
                        @php

                        $ar = json_decode($material->materials_eu_category);
                        $index = 0;
                        @endphp
                        @endif

                        <input type="hidden"  name="eu_category" />
                        
                        <table class="table table-bordered align-items-center mb-0" id="tbl-field-3">
                        <thead><th>category</th><th>minimum</th><th>maximum</th> 
                        <th></th>
                        </thead>
                        <tbody>
                        @if(isset($material)  && $material->materials_eu_category!= null )
                        
                        @foreach( $ar as $item )
                        @php
                            $index++;
                        @endphp
                        <tr draggable="true" containment="tbody" ondragstart="dragStart()" ondragover="dragOver()" style="cursor: move;"><td><div class="input-box"> <select name="materials_eu_category[{{ $index }}][category]" class="form-select  google-input multi-type" required=""><option @selected( $item->category == "All Species" ) value="All Species" >All Species</option><option @selected( $item->category == "Broiler" ) value="Broiler" >Broiler</option><option @selected( $item->category == "Layer" ) value="Layer" >Layer</option><option @selected( $item->category == "Sheep" ) value="Sheep" >Sheep</option><option @selected( $item->category == "Cows" ) value="Cows" >Cows</option></select></div></td> <td>
                                        <div class="input-box">
                                            <input type="text" name="materials_eu_category[{{ $index }}][minimum]"
                                                class="form-control google-input"
                                                placeholder="minimum" value="{{ $item->minimum }}" required>
                                        </div>
                                    </td>
                                     <td>
                                        <div class="input-box">
                                            <input type="text" name="materials_eu_category[{{ $index }}][maximum]"
                                                class="form-control google-input"
                                                placeholder="maximum" value="{{ $item->maximum }}" required>
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
                            <div class="col-md-12">
        <div class="input-box">
            <label for="unit">{{ __('Unit') }}</label>
            <select class="google-input @error('material_unit') is-invalid @enderror" name="material_unit" id="unit" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select unit') }} --</option>
                <option value="I.U." {{ isset($material) && $material->material_unit == 'I.U.' ? 'selected' : ('' == 'I.U.' ? 'selected' : '') }}>I.U.</option>
		<option value="mg" {{ isset($material) && $material->material_unit == 'mg' ? 'selected' : ('' == 'mg' ? 'selected' : '') }}>mg</option>
		<option value="mcg" {{ isset($material) && $material->material_unit == 'mcg' ? 'selected' : ('' == 'mcg' ? 'selected' : '') }}>mcg</option>			
            </select>
            @error('material_unit')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>