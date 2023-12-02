
    @csrf
    <input type="hidden" name="menu_type" value="admin">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
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
                                <input type="checkbox" name="is_enable" id="ais_enable" class="custom-switch-input" id="is_enable" >
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Status</span>
                            </label>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="custom-switch form-label">
                                <input type="checkbox" name="include_in_menu" id="ainclude_in_menu" class="custom-switch-input" id="is_enable" >
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
                            <label class="form-label" for="created_date">Created Date <span class="text-red">*</span></label>
                            <input type="date" name="created_date" id="acreated_date" class="form-control" value="">
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="form-label" for="assigned_attributes">Assigned Attributes <span class="text-red">*</span></label>
                            <textarea class="form-control" id="aassigned_attributes" name="assigned_attributes" autocomplete="off" id="description" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <input title="Save module" class="btn btn-primary" type="submit" value="Save">
                    {{-- <input title="Reset form" class="btn btn-warning" type="reset" value="Reset"> --}}
                </div>
            </div>
        </div>
    </div>


