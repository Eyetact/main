<form action="{{ $role->id == null ? route('role.store') : route('role.update', ['role' => $role->id]) }}" method="POST"
    id="role_form" novalidate="" class="needs-validation">
    <div class="card-body">
        @csrf
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="form-group col-sm-6">
                    <label for="name">Role</label>
                    <input class="form-control @error('name') is-invalid @enderror" name="name" type="text"
                        value="{{ old('name', $role->name) }}" required="" placeholder="Role">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter role.</div>
                </div>
                <input type="hidden" value="web" name="guard_name">
            </div>
            <div class="form-group col-sm-12 col-lg-12">
                <div class="permission">
                    <label for="permission">Permission:</label>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <div class="row">
                            @foreach ($groupPermission as $key => $permissions)
                                <div class="col-sm-6 nav-item">
                                    <div class="custom-checkbox permission">
                                        <input id="{{ $key }}" type="checkbox" class="check-all"
                                            name="checkAll">
                                        <label for="{{ $key }}"> <b>{{ Str::ucfirst(explode('.',$permissions[0]->name)[1]) }}</b></label>
                                    </div>

                                    @foreach ($permissions as $permission)
                                        <div class="custom-control custom-checkbox ms-3 nav-treeview">
                                            <input id="{{ $permission->id }}" type="checkbox" class="check-one"
                                                name="permission_data[]" value="{{ $permission->id }}"
                                                {{ $role->id != null && count($role->permission_data) > 0 && isset($role->permission_data[$permission->id]) ? 'checked' : '' }}>
                                            <input id="{{ $permission->module }}" type="hidden"
                                                name="permission_module[{{$permission->id}}]" value="{{ $permission->module }}">
                                            <label for="{{ $permission->id }}">{{ Str::ucfirst($permission->name) }}</label>
                                            <?php
                                                $edit_no=0;
                                                $edit_type='';
                                                $permission_id=0;
                                                $scheduler_data=array('scheduler_no'=>'','type'=>'');
                                                if($role->scheduler->count()>0){
                                                    $scheduler=$role->scheduler->toArray();
                                                    if(array_search($permission->id, array_column($scheduler, 'permission_id')) !== false){
                                                        $key=array_search($permission->id, array_column($scheduler, 'permission_id'));
                                                        $scheduler_data=$scheduler[$key];
                                                    }

                                                    // dump($scheduler[$key]);

                                                    // if(array_search($permission->id, array_column($scheduler, 'permission_id')) !== false) {
                                                    //     // $edit_no=$scheduler['scheduler_no'];
                                                    //     // $edit_type=$scheduler['type'];
                                                    //     $permission_id=$scheduler;
                                                    // }
                                                    // echo $key;
                                                }
                                                // dump($scheduler_data);
                                                // echo $role->scheduler->count().$edit_no.$edit_type; 
                                            ?>
                                            @if (str_contains($permission->name, 'edit')) 
                                                <select name="schedule_no_edit[{{$permission->id}}]" class="schedule_no_edit schedule_no" title="Number">
                                                    <option value="">Number</option>
                                                    <option value="0" {{($scheduler_data['scheduler_no']=="0" ? 'selected' : '')}}>Inactive</option>
                                                    @for ($i=1;$i<=10;$i++)
                                                        <option value="{{$i}}" {{($scheduler_data['scheduler_no']==$i ? 'selected' : '')}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                <select name="schedule_time_edit[{{$permission->id}}]" class="schedule_time_edit schedule_time" title="Time">
                                                    <option value="">Time</option>
                                                    <option value="day" {{($scheduler_data['type']=='day' ? 'selected' : '')}}>Days</option>
                                                    <option value="week" {{($scheduler_data['type']=='week' ? 'selected' : '')}}>Weeks</option>
                                                    <option value="month" {{($scheduler_data['type']=='month' ? 'selected' : '')}}>Months</option>
                                                    <option value="year" {{($scheduler_data['type']=='0' ? 'selected' : '')}}>Years</option>
                                                </select>
                                            @endif   
                                            @if (str_contains($permission->name, 'delete')) 
                                                <select name="schedule_no_delete[{{$permission->id}}]" class="schedule_no_delete schedule_no" title="Number">
                                                    <option value="">Number</option>
                                                    <option value="0" {{($scheduler_data['scheduler_no']=="0" ? 'selected' : '')}}>Inactive</option>
                                                    @for ($i=1;$i<=10;$i++)
                                                        <option value="{{$i}}" {{($scheduler_data['scheduler_no']==$i ? 'selected' : '')}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                <select name="schedule_time_delete[{{$permission->id}}]" class="schedule_time_delete schedule_time" title="Time">
                                                    <option value="">Time</option>
                                                    <option value="day" {{($scheduler_data['type']=='day' ? 'selected' : '')}}>Days</option>
                                                    <option value="week" {{($scheduler_data['type']=='week' ? 'selected' : '')}}>Weeks</option>
                                                    <option value="month" {{($scheduler_data['type']=='month' ? 'selected' : '')}}>Months</option>
                                                    <option value="year" {{($scheduler_data['type']=='0' ? 'selected' : '')}}>Years</option>
                                                </select>
                                            @endif
                                        </div> 
                                                                                
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" type="submit">{{ $role->id == null ? 'Save' : 'Update' }}</button>
        <a href="{{ route('role.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
