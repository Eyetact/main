ssh eyt_laravel@164.90.218.139
lrv@EYT23

hide master from dropdown --done
add master checkbok --done

change parent name -- done
attr belongs to model ----
hide not disable done
system readonly 
edit 
add more file types done
email,pw validation in req file done

def value validation in migration file done

redesign for forms deone


1 dropdown done


edit regenerate mifration done



sunday 7-1
--------------
redesign attrs page -- done
save module and menu to database done
rendering menu in sidebar dene
change defult route to path from request  --done
refactor attr page 
- index 

aaa


TODO
--------------

refactor roles and permissions
scoup logic 
move style to sparate file


model edit and delete attributes => regenerate model 







scripts for attrbuite create form
=================================
<!--INTERNAL Select2 js -->
		<!-- <script src="{{ asset('assets/js/jquery.validate.js') }}"></script> -->
		<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
		<script src="{{URL::asset('assets/js/select2.js')}}"></script>

		<script>
        $(document).ready(function() {
            $(".validation_message").fadeOut("slow");
            $(".text_fields").fadeOut("slow");
            $(".option_fields").fadeOut("slow");
            $(".file_fields").fadeOut("slow");
            var field_type = "{{ $attribute->field_type }}";
            var is_required = "{{ $attribute->is_required }}";
            if(is_required == 1) {
                $(".validation_message").fadeIn("slow");
            }
            if (field_type != '' || field_type != null) {
                $(".field_type").trigger('change');
            }
            $("#is_required").change(function() {
                var isChecked = $(this).is(":checked");
                if (isChecked) {
                    $(".validation_message").fadeIn("slow");
                } else {
                    $(".validation_message").fadeOut("slow");
                }
            });
        });
        $("#depend").change(function() {
            var depend=$(this).val();
            if(depend==""){
                $("#attr_div").hide();
            }else{
                $("#attr_div").show();
            }
        });

        $(".field_type").change(function() {
            $(".text_fields").fadeOut("slow");
            $(".option_fields").fadeOut("slow");
            $(".file_fields").fadeOut("slow");
            // $('.option_fields').html('');
            // $('.text_fields').html('');
            // $(".file_fields").html('');

            var field_val = $(this).val();
            var text_html = '<div class="form-group col-sm-6"><label class="form-label" for="min_length">Min length </label><input class="form-control min_length" name="fields_info[min_length]"  type="text" value="" autocomplete="off"></div><div class="form-group col-sm-6"><label class="form-label" for="max_length">Max length </label><input class="form-control max_length" name="fields_info[max_length]"  type="text" value="" autocomplete="off"></div>';
            // var option_html = '<tr><td scope="row"></td><td><input type="radio" name="fields_info[0][default]" class="m-input mr-2"></td><td><input type="text" name="fields_info[0][value]" class="form-control m-input mr-2"  autocomplete="off"></td><td><button type="button" class="btn btn-danger removeSection"><i class="fa fa-trash"></i></button></td></tr>';
            var file_html = '<div class="form-group col-sm-6"> <label class="form-label" for="file_ext">Allowed Extension</label> <select name="fields_info[file_ext][]" class="form-control fields_info[file_ext] file_ext" multiple> <option value="" selected>Allowed Extension</option> <option value="doc">Document(PDF/Doc/Docx)</option> <option value="image">Image(jpg/jpeg/png/svg)</option> <option value="media">Media(mp3/mp4)</option> </select> </div> <div class="form-group col-sm-6"><label class="form-label" for="max_length">File Size</label> <select name="fields_info[file_size]" class="form-control fields_info[file_size] file_size"> <option value="" selected>File Size</option> <option value="1">1 mb</option> <option value="2">2 mb</option> <option value="3">3 mb</option> <option value="4">4 mb</option> <option value="5">5 mb</option> <option value="6">6 mb</option> <option value="7">7 mb</option> <option value="8">8 mb</option> <option value="9">9 mb</option> <option value="10">10 mb</option> </select> </div>';
            if (field_val === 'text') {
                $('.text_fields').html(text_html);
                $(".text_fields").fadeIn("slow");
            } else if(field_val === 'select' || field_val === 'multiselect' || field_val === 'radio' || field_val === 'checkbox' ) {
                // $('.option_fields tbody').html(option_html);
                $(".option_fields").fadeIn("slow");
            } else if(field_val === 'file'){
                $(".file_fields").html(file_html);
                $(".file_fields").fadeIn("slow");
            }
        });

        @if($data)
	        setTimeout(() => {
                $('.min_length').val(null);
	            $('.max_length').val(null);
                $('.file_ext').val(null);
	            $('.file_size').val(null);
                $('.option_fields tbody').html('');

	            var fields_value = @json($data);
                var field_type_val=$("#field_type").val();
                console.log(fields_value,$.type(fields_value),Object.keys(fields_value).length);
	            if (field_type_val == 'text') {
	                $('.min_length').val(fields_value.min_length);
	                $('.max_length').val(fields_value.max_length);
	            } else if(field_type_val == 'file'){
                    $('.file_ext').val(fields_value.file_ext);
	                $('.file_size').val(fields_value.file_size);
                } else {
	                var html_data = [];
	                $.each(fields_value, function(index, value) {
                        console.log(index,value.value);
	                    var html = '';
	                    html += '<tr><td scope="row"></td><td><input type="radio" onchange="addValue('+index+')" name="fields_info_radio" class="m-input mr-2"' + (value.default == 1 ? ' checked' : '') + '><input type="hidden" value="'+value.default+'" id="fields_info['+index+'][default]" name="fields_info['+index+'][default]"></td><td><input type="text" name="fields_info['+index+'][value]" class="form-control m-input mr-2" value="'+value.value+'" autocomplete="off"></td><td><button type="button" class="btn btn-danger removeSection"><i class="fa fa-trash"></i></button></td></tr>';
	                    html_data.push(html);
	                });
                    console.log(html_data);
	                $('.option_fields tbody').append(html_data);
	            }
	        }, 500);
        @endif

        $('#attributeCreate').validate({
            rules: {
                name: {
                    required: true,
                },
                input_name: {
                    required: true,
                },
                input_class: {
                    required: true,
                },
                input_id: {
                    required: true,
                },
                field_type: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter name.",
                },
                input_name: {
                    required: "Please enter input name.",
                },
                input_class: {
                    required: "Please enter input class.",
                },
                input_id: {
                    required: "Please enter input id.",
                },
                field_type: {
                    required: "Please select field type.",
                }
            }
        });

        var index = 1;
        $(document).on("click", "#addRow", function () {
            var html = '';
            html += '<tr><td scope="row"></td><td><input type="radio" name="fields_info_radio" onchange="addValue('+index+')" class="m-input mr-2"><input type="hidden" value="0" id="fields_info['+index+'][default]" name="fields_info['+index+'][default]"></td><td><input type="text" name="fields_info['+index+'][value]" class="form-control m-input mr-2"  autocomplete="off"></td><td><button type="button" class="btn btn-danger removeSection"><i class="fa fa-trash"></i></button></td></tr>';
            $('.option_fields tbody').append(html);
            index++;
        });

        function addValue(index){
            console.log(index);
            $('[id^="fields_info"]').each(function() {
                $(this).val(0);
            });
            $("#fields_info\\[" + index + "\\]\\[default\\]").val(1);

        }




        $(document).on('click', '.removeSection', function () {
            $(this).closest('tr').remove();
            index--;
        });
    </script>

    <script>
        (function () {
            "use strict";
            const table = document.getElementById("type_options");
            const tbody = table.querySelector("tbody");
            var currRow = null,
                dragElem = null,
                mouseDownX = 0,
                mouseDownY = 0,
                mouseX = 0,
                mouseY = 0,
                mouseDrag = false;
            function init() {
                bindMouse();
            }
            function bindMouse() {
                document.addEventListener("mousedown", (event) => {
                    if (event.button != 0) return true;
                    let target = getTargetRow(event.target);
                    if (target) {
                        currRow = target;
                        addDraggableRow(target);
                        currRow.classList.add("is-dragging");
                        let coords = getMouseCoords(event);
                        mouseDownX = coords.x;
                        mouseDownY = coords.y;
                        mouseDrag = true;
                    }
                });
                document.addEventListener("mousemove", (event) => {
                    if (!mouseDrag) return;
                    let coords = getMouseCoords(event);
                    mouseX = coords.x - mouseDownX;
                    mouseY = coords.y - mouseDownY;
                    moveRow(mouseX, mouseY);
                });
                document.addEventListener("mouseup", (event) => {
                    if (!mouseDrag) return;
                    currRow.classList.remove("is-dragging");
                    table.removeChild(dragElem);
                    dragElem = null;
                    mouseDrag = false;
                });
            }
            function swapRow(row, index) {
                let currIndex = Array.from(tbody.children).indexOf(currRow),
                    row1 = currIndex > index ? currRow : row,
                    row2 = currIndex > index ? row : currRow;
                tbody.insertBefore(row1, row2);
            }
            function moveRow(x, y) {
                dragElem.style.transform = "translate3d(" + x + "px, " + y + "px, 0)";
                let dPos = dragElem.getBoundingClientRect(),
                    currStartY = dPos.y,
                    currEndY = currStartY + dPos.height,
                    rows = getRows();
                for (var i = 0; i < rows.length; i++) {
                    let rowElem = rows[i],
                        rowSize = rowElem.getBoundingClientRect(),
                        rowStartY = rowSize.y,
                        rowEndY = rowStartY + rowSize.height;
                    if (
                        currRow !== rowElem &&
                        isIntersecting(currStartY, currEndY, rowStartY, rowEndY)
                    ) {
                        if (Math.abs(currStartY - rowStartY) < rowSize.height / 2)
                            swapRow(rowElem, i);
                    }
                }
            }
            function addDraggableRow(target) {
                dragElem = target.cloneNode(true);
                dragElem.classList.add("draggable-table__drag");
                dragElem.style.height = getStyle(target, "height");
                dragElem.style.background = getStyle(target, "backgroundColor");
                for (var i = 0; i < target.children.length; i++) {
                    let oldTD = target.children[i],
                        newTD = dragElem.children[i];
                    newTD.style.width = getStyle(oldTD, "width");
                    newTD.style.height = getStyle(oldTD, "height");
                    newTD.style.padding = getStyle(oldTD, "padding");
                    newTD.style.margin = getStyle(oldTD, "margin");
                }
                table.appendChild(dragElem);
                let tPos = target.getBoundingClientRect(),
                    dPos = dragElem.getBoundingClientRect();
                dragElem.style.bottom = dPos.y - tPos.y - tPos.height + "px";
                dragElem.style.left = "-1px";
                document.dispatchEvent(
                    new MouseEvent("mousemove", {
                        view: window,
                        cancelable: true,
                        bubbles: true
                    })
                );
            }
            function getRows() {
                return table.querySelectorAll("tbody tr");
            }
            function getTargetRow(target) {
                let elemName = target.tagName.toLowerCase();
                if (elemName == "tr") return target;
                if (elemName == "td") return target.closest("tr");
            }
            function getMouseCoords(event) {
                return {
                    x: event.clientX,
                    y: event.clientY
                };
            }
            function getStyle(target, styleName) {
                let compStyle = getComputedStyle(target),
                    style = compStyle[styleName];
                return style ? style : null;
            }
            function isIntersecting(min0, max0, min1, max1) {
                return (
                    Math.max(min0, max0) >= Math.min(min1, max1) &&
                    Math.min(min0, max0) <= Math.max(min1, max1)
                );
            }
            init();
        })();
    </script>

