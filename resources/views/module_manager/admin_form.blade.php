@csrf
<input type="hidden" name="menu_type" value="admin">
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="">
            <div class="card-header">
                <h3 class="card-title">Admin </h3>
                &nbsp &nbsp
                <span id="currentEditName"></span>
            </div>
            <div class="card-body pb-2">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label class="form-label" for="name">Name <span class="text-red">*</span></label>
                        <input type="text" name="name" id="aname" class="form-control" value="">
                        <input type="hidden" name="id" id="aid" value="">
                    </div>
                    <div class="col-sm-12 form-group">
                        <label class="form-label" for="code">Code <span class="text-red">*</span></label>
                        <input type="text" name="code" id="acode" class="form-control" value="">
                    </div>
                    <div class="col-sm-12 form-group">
                        <label class="form-label" for="path">Path <span class="text-red">*</span></label>
                        <input type="text" name="path" id="apath" class="form-control" value="">
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="custom-switch form-label">
                            <input type="checkbox" name="is_enable" id="ais_enable" class="custom-switch-input"
                                id="is_enable">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Status</span>
                        </label>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="custom-switch form-label">
                            <input type="checkbox" name="include_in_menu" id="ainclude_in_menu"
                                class="custom-switch-input" id="is_enable">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Include in menu</span>
                        </label>
                    </div>
                    {{-- <div class="col-sm-12 form-group">
                            <label class="form-label" for="meta_title">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="">
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="form-label" for="meta_description">Meta Description</label>
                            <textarea class="form-control" name="meta_description" autocomplete="off" id="description" rows="2"></textarea>
                        </div> --}}
                    <div class="col-sm-12 form-group">
                        <label class="form-label" for="created_date">Created Date <span
                                class="text-red">*</span></label>
                        <input type="date" name="created_date" id="acreated_date" class="form-control"
                            value="">
                    </div>

                    <div class="attr_header row flex justify-content-end my-5 align-items-end">
                        <input title="Reset form" class="btn btn-success" id="add_new" type="button"
                    value="+ Add">
                    </div>

                    <table class="table table-bordered text-nowrap" id="attr_tbl">
                        <thead>
                            <tr>
                                <td>Label</td>
                                <td>Name</td>
                                <td>class + id</td>
                                <td>Option</td>
                                <td>Type</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tbl_drag">
                                <td>
                                    <div class="col-sm-12 form-group">
                                        <label class="form-label" for="name">Label<span
                                                class="text-red">*</span></label>
                                        <input type="text" name="attr[0][name]" class="form-control " value="">
                                        <label id="name-error" class="error text-red hide" for="name"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-12 form-group">
                                        <label class="form-label" for="name">Name<span
                                                class="text-red">*</span></label>
                                        <input type="text" name="attr[0][input_name]" class="form-control "
                                            value="">
                                        <label id="name-error" class="error text-red hide" for="name"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-12 form-group">
                                        <input type="text" name="attr[0][input_id]" class="form-control "
                                            value="" placeholder="ID">
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <input type="text" name="attr[0][input_class]" class="form-control "
                                            value="" placeholder="Class">
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label class="custom-switch form-label">
                                                <input type="checkbox" name="attr[0][is_enable]" class="custom-switch-input" id="is_enable" >
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Status</span>
                                            </label>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label class="custom-switch form-label">
                                                <input type="checkbox" name="attr[0][is_system]" class="custom-switch-input" id="is_system">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">System </span>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group col-sm-12">
                                        <label class="form-label">Select Attribute type<span
                                                class="text-red">*</span></label>
                                        <select name="attr[0][field_type]" class="form-control field_type" id="field_type">
                                            <option value="" selected="">Please select attribute field type
                                            </option>
                                            <option value="text">Text</option>
                                            <option value="email">Email</option>
                                            <option value="number">Number</option>
                                            <option value="date">Date</option>
                                            <option value="date">Date and Time</option>
                                            <option value="textarea">Textarea</option>
                                            <option value="select">Dropdown</option>
                                            <option value="multiselect">Multiple Select</option>
                                            <option value="switch">Yes/No</option>
                                            <option value="radio">Radiobox</option>
                                            <option value="checkbox">Checkbox</option>
                                            <option value="file">File</option>
                                        </select>
                                        <label id="field_type-error" class="error text-red hide"
                                            for="field_type"></label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>





                </div>
            </div>
            <div class="card-footer text-right">
                <input title="Reset form" class="btn btn-danger d-none" id="remove-admin-menu" type="button"
                    value="Delete">
                <input title="Reset form" class="btn btn-success d-none" id="restore-admin-menu" type="button"
                    value="Restore">
                <input title="Save module" class="btn btn-primary" id="submit-admin-menu" type="submit"
                    value="Save">
                {{-- <input title="Reset form" class="btn btn-warning" type="reset" value="Reset"> --}}
            </div>
        </div>
    </div>
</div>


