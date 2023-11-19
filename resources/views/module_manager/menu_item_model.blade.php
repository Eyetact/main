<div id="largeModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pd-x-20">
                <h6 class="modal-title">Message Preview</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pd-20">
                <form class="form-horizontal">
                    <div class="form-group row">
                        <label for="inputName" class="col-md-3 form-label">Type</label>
                        <div class="col-md-9">
                            <select name="type" class="form-control custom-select select2" id="module_type">
                                <option value="">Select</option>
                                <option value="storfront">Storfront</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <div id="storfront_div">
                        storfront_div
                    </div>
                    <div id="admin_div">
                        admin_div
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-md-3 form-label">Email</label>
                        <div class="col-md-9">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-md-3 form-label">Password</label>
                        <div class="col-md-9">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Password" />
                        </div>
                    </div>
                    <div class="form-group mb-0 row justify-content-end">
                        <div class="col-md-9">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2" />
                                <span class="custom-control-label">Check me Out</span>
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#storfront_div").hide();
        $("#admin_div").hide();

        $('body').on('change', '#module_type', function() {
            console.log($(this).val())
            if($(this).val() == "storfront"){
                $("#admin_div").hide();
                $("#storfront_div").show();
            }else if($(this).val() == "admin"){
                $("#storfront_div").hide();
                $("#admin_div").show();
            }else{
                $("#storfront_div").hide();
                $("#admin_div").hide();
            }
        });
    });
    function convertMenuToJson(menu,includeClass, parentId = 0){
        var result = [];
        menu.children("li").each(function(index) {
            var menuItem = $(this).find('.' + includeClass);
            var id=menuItem.val();
            var sequence = index;

            var jsonItem = {
                id: id,
                parent: parentId,
                sequence: sequence,
            };

            var subMenu = $(this).children("ol");
            if (subMenu.length > 0) {
                jsonItem.children = convertMenuToJson(subMenu, includeClass, id);
            }
            result.push(jsonItem);
        });

        return result;
    }

</script>
