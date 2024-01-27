<div class="row mb-2">
<div class="multi-options col-12">
                        <div class="attr_header row flex justify-content-end my-5 align-items-end">
                            <input title="Reset form" class="btn btn-success" id="add_new_tr_3" type="button" value="+ Add">
                        </div>
                        @if(isset($machine)  && $machine->component!= null )
                        @php

                        $ar = json_decode($machine->component);
                        $index = 0;
                        @endphp
                        @endif

                        <input type="hidden"  name="component" />
                        
                        <table class="table table-bordered align-items-center mb-0" id="tbl-field-3">
                        <thead><th>i_d</th><th>name</th><th>date</th> 
                        <th></th>
                        </thead>
                        <tbody>
                        @if(isset($machine)  && $machine->component!= null )
                        
                        @foreach( $ar as $item )
                        @php
                            $index++;
                        @endphp
                        <tr draggable="true" containment="tbody" ondragstart="dragStart()" ondragover="dragOver()" style="cursor: move;"> <td>
                                        <div class="input-box">
                                            <input type="text" name="component[{{ $index }}][i_d]"
                                                class="form-control google-input"
                                                placeholder="i_d" value="{{ $item->i_d }}" required>
                                        </div>
                                    </td>
                                     <td>
                                        <div class="input-box">
                                            <input type="text" name="component[{{ $index }}][name]"
                                                class="form-control google-input"
                                                placeholder="name" value="{{ $item->name }}" required>
                                        </div>
                                    </td>
                                     <td>
                                        <div class="input-box">
                                            <input type="date" name="component[{{ $index }}][date]"
                                                class="form-control google-input"
                                                placeholder="date" value="{{ $item->date }}" required>
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