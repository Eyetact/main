<div class="row mb-2">
<div class="multi-options col-12">
                        <div class="attr_header row flex justify-content-end my-5 align-items-end">
                            <input title="Reset form" class="btn btn-success" id="add_new_tr_8" type="button" value="+ Add">
                        </div>
                        @if(isset($mixture)  && $mixture->testllllo!= null )
                        @php

                        $ar = json_decode($mixture->testllllo);
                        $index = 0;
                        @endphp
                        @endif

                        <input type="hidden"  name="testllllo" />

                        <table class="table table-bordered align-items-center mb-0" id="tbl-field-8">
                        <thead><th>testllllo</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @if(isset($mixture)  && $mixture->testllllo!= null )

                        @foreach( $ar as $item )
                        @php
                            $index++;
                        @endphp
                        <tr draggable="true" containment="tbody" ondragstart="dragStart()" ondragover="dragOver()" style="cursor: move;"><td><div class="input-box"> <select name="testllllo[{{ $index }}][testllllo]" class="form-select  google-input multi-type" required="">@foreach( \App\Models\Material::all() as $item2 )<option @selected( $item->testllllo == "$item2->material_name" )  value="{{ $item2->material_name}}" >{{ $item2->material_name}}</option>@endforeach</select></div></td>
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