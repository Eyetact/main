
            <form action="{{ route('plans.store') }}" method="POST" id="mailboxForm" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-lg-12 col-sm-12">
                        <div class="input-box">
                            <label for="name" class="input-label">Name</label>
                            <input type="text" class="google-input" name="name" id="name" value="" />
                        </div>
                        @error('name')
                            <label id="name-error" class="error" for="name">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="col-lg-12 col-sm-12">
                        <label class="form-label">image</label>
                        <input type="file" class="dropify" name="image" data-default-file="" data-height="180" />
                    </div>




                    {{-- <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="details" class="input-label">details</label>
                            <input type="text" class="google-input" name="details" id="details" value="" />
                        </div>
                        @error('details')
                            <label id="details-error" class="error" for="details">{{ $message }}</label>
                        @enderror
                    </div> --}}


                    <div class="col-lg-12 col-sm-12">
                        <div class="input-box">
                            <label class="form-label">details<span class="text-danger"></span></label>
                            <textarea class="content" name="details" id="details" value="">

                                    </textarea>
                        </div>


                        @error('details')
                            <label id="details-error" class="error" for="details">{{ $message }}</label>
                        @enderror
                    </div>


                    <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="period" class="input-label">period</label>
                            <input type="number" class="google-input" name="period" id="period" value="" />
                        </div>
                        @error('period')
                            <label id="period-error" class="error" for="period">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="price" class="input-label">price</label>
                            <input type="text" class="google-input" name="price" id="price" value="" />
                        </div>
                        @error('price')
                            <label id="price-error" class="error" for="price">{{ $message }}</label>
                        @enderror
                    </div>



                    <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="model_limit" class="input-label">Module Limit</label>
                            <input type="number"  max="{{$availableModel}}" class="google-input" name="model_limit" id="model_limit" value="" />
                        </div>
                        @error('model_limit')
                            <label id="period-error" class="error" for="model_limit">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="data_limit" class="input-label">Data Limit</label>
                            <input type="number"  max="{{$availableData}}" class="google-input" name="data_limit" id="price" value="" />
                        </div>
                        @error('data_limit')
                            <label id="price-error" class="error" for="data_limit">{{ $message }}</label>
                        @enderror
                    </div>



                    <div class="col-sm-12 col-md-12">
                        <div class="form-group ">
                            <label class="form-label">Permissions :</label>
                            <div class="">

                                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                                data-accordion="false">
                                <div class="row">
                                    @foreach ($groupPermission as $key => $permissions)
                                        @canany([$permissions[0]->name,$permissions[1]->name,$permissions[2]->name,$permissions[3]->name])

                                        <div class="col-sm-6 role-group">
                                            <div class="custom-checkbox permission  input-box">
                                                <input id="{{ $key }}" type="checkbox" class=" check-all"
                                                    name="checkAll">
                                                <label for="{{ $key }}">
                                                    <b>{{ Str::ucfirst(explode('.', $permissions[0]->name)[1]) }}</b></label>
                                            </div>


                                            @foreach ($permissions as $permission)
                                                @can($permission->name)
                                                <div class="custom-control custom-checkbox ms-3 row  input-box">
                                                    <div class="col-md-12">
                                                        <input  id="{{ $permission->id }}" type="checkbox" class="check-one"
                                                            name="permissions[]" value="{{ $permission->id }}"
                                                           >

                                                        <label
                                                            for="{{ $permission->id }}">{{ Str::ucfirst($permission->name) }}</label>
                                                    </div>
                                                    <?php
                                                    // $edit_no = 0;
                                                    // $edit_type = '';
                                                    // $permission_id = 0;
                                                    // $scheduler_data = ['scheduler_no' => '', 'type' => ''];
                                                    // if ($role->scheduler->count() > 0) {
                                                    //     $scheduler = $role->scheduler->toArray();
                                                    //     if (array_search($permission->id, array_column($scheduler, 'permission_id')) !== false) {
                                                    //         $key = array_search($permission->id, array_column($scheduler, 'permission_id'));
                                                    //         $scheduler_data = $scheduler[$key];
                                                    //     }

                                                    //     // dump($scheduler[$key]);

                                                    //     if (array_search($permission->id, array_column($scheduler, 'permission_id')) !== false) {
                                                    //         // $edit_no=$scheduler['scheduler_no'];
                                                    //         // $edit_type=$scheduler['type'];
                                                    //         $permission_id = $scheduler;
                                                    //     }
                                                    //     // echo $key;
                                                    // }
                                                    // dump($scheduler_data);
                                                    // echo $role->scheduler->count().$edit_no.$edit_type;
                                                    ?>
                                                    {{-- <div class="col-md-7">
                                                        <div class="row">


                                                            @if (str_contains($permission->name, 'edit'))

                                                                <div class="col-md-6 select-box">

                                                                    <select name="schedule_no_edit[{{ $permission->id }}]"
                                                                        class="google-input" title="Number">

                                                                        @for ($i = 0; $i <= 10; $i++)
                                                                            <option value="{{ $i }}" @selected( $permission->getCountByrole($role->id) == $i )>
                                                                                {{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6  select-box">

                                                                    <select name="schedule_time_edit[{{ $permission->id }}]"
                                                                        class="google-input schedule_time_edit schedule_time"
                                                                        title="Time">
                                                                        <option value="day" @selected( $permission->getCountByrole($role->id,1) == 'day' )>
                                                                            Days</option>
                                                                        <option value="week" @selected( $permission->getCountByrole($role->id,1) == 'week' )>
                                                                            Weeks</option>
                                                                        <option value="month" @selected( $permission->getCountByrole($role->id,1) == 'month' )>
                                                                            Months</option>
                                                                        <option value="year" @selected( $permission->getCountByrole($role->id,1) == 'year' )>
                                                                            Years</option>
                                                                    </select>
                                                                </div>
                                                            @endif

                                                        </div>

                                                        @if (str_contains($permission->name, 'delete'))
                                                            <div class="row">
                                                                <div class="col-md-6  select-box">
                                                                    <select name="schedule_no_delete[{{ $permission->id }}]"
                                                                        class="google-input schedule_no_delete schedule_no"
                                                                        title="Number">

                                                                        @for ($i = 0; $i <= 10; $i++)
                                                                            <option value="{{ $i }}" @selected( $permission->getCountByrole($role->id) == $i )>
                                                                                {{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6  select-box">
                                                                    <select name="schedule_time_delete[{{ $permission->id }}]"
                                                                        class="google-input schedule_time_delete schedule_time"
                                                                        title="Time">
                                                                        <option value="day" @selected( $permission->getCountByrole($role->id,1) == 'day' )>
                                                                            Days</option>
                                                                        <option value="week" @selected( $permission->getCountByrole($role->id,1) == 'week' )>
                                                                            Weeks</option>
                                                                        <option value="month" @selected( $permission->getCountByrole($role->id,1) == 'month' )>
                                                                            Months</option>
                                                                        <option value="year" @selected( $permission->getCountByrole($role->id,1) == 'year' )>
                                                                            Years</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div> --}}

                                                </div>
                                                @endcan
                                            @endforeach
                                        </div>
                                        @endcanany


                                    @endforeach
                                </div>
                            </ul>

                            </div>
                        </div>
                    </div>




                </div>



                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="{{ route('plans.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>


    <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/wysiwyag/jquery.richtext.js">
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <script type="text/javascript">
        // $(document).ready(function() {
        $("#mailboxForm").validate({
            onkeyup: function(el, e) {
                $(el).valid();
            },
            // errorClass: "invalid-feedback is-invalid",
            // validClass: 'valid-feedback is-valid',
            ignore: ":hidden",
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                password: {
                    required: true,
                }

            },
            messages: {},
            errorPlacement: function(error, element) {
                error.insertAfter($(element).parent());
            },
        });

        $("input[type='text'], input[type='number'], input[type='password'], input[type='email'], input[type='tel']").on(
            "keyup",
            function() {
                var $input = $(this);
                if ($input.val() != '') {
                    $input.parents(".input-box").addClass("focus");
                } else {
                    $input.parents(".input-box").removeClass("focus");
                }
            });
        $("input[type='text'], input[type='number'], input[type='password'], input[type='email'], input[type='tel']").each(
            function(index, element) {
                var value = $(element).val();
                if (value != '') {
                    $(this).parents('.input-box').addClass('focus');
                } else {
                    $(this).parents('.input-box').removeClass('focus');
                }
            });
        // });

        $(function(e) {
            $('.content').richText();
            $('.content2').richText();
        });


        $(document).ready(function() {
            $('#permission_type option[value=customer]').attr('selected','selected');
            getPermissionsByType($('#permission_type').val());
            $('#permission_type').change(function() {
                var selectedType = $(this).val();
                getPermissionsByType(selectedType);
            });

            function getPermissionsByType(type) {
                var permissionsSelect = $('#permissions');
                permissionsSelect.empty();

                if (type === 'user') {
                    @foreach ($user_permissions as $permission)
                        var span =
                            ' <label class="selectgroup-item"><input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="selectgroup-input"><span class="selectgroup-button">{{ $permission->name }}</span></label>';
                        permissionsSelect.append(span);
                    @endforeach
                } else if (type === 'customer') {
                    @foreach ($customer_permissions as $permission)
                        var span =
                            ' <label class="selectgroup-item"><input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="selectgroup-input"><span class="selectgroup-button">{{ $permission->name }}</span></label>';

                        permissionsSelect.append(span);
                    @endforeach
                }
            }
        });
    </script>
