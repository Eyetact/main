<form action="{{ route('menu.menu_update') }}" id="storfront_form" method="POST" autocomplete="off" novalidate="novalidate">
    @csrf
    <textarea name="storfront_json" class="hide" id="storfront_json" cols="30" rows="10"></textarea>
</form>
<div class="dd nestable" id="storfront_nestable">                                                    
    <ol class="dd-list" id="storfront_menu_list">
    @foreach ($storfrontMenu as $sMenu)
        <li class="dd-item" data-id="{{$sMenu->id}}">
            <div class="dd-handle">{{$sMenu->name}} <input type="hidden" class="storfront-menu" value="{{$sMenu->module_id}}"></div>
            

            <span class="button-delete btn btn-icon  btn-danger delete-attribute delete-attribute"
                data-owner-id="{{$sMenu->id}}">
            <i class="fa fa-trash-o"></i>
            </span>

            <span class="button-edit btn btn-icon btn-warning"
                data-owner-id="{{$sMenu->id}}">
            <i class="fa fa-edit" data-toggle="tooltip" title="" data-original-title="Edit"></i>
            </span>

            @if (!empty($sMenu->children))
            @foreach ($sMenu->children as $cMenu)            
                <ol class="dd-list">
                    <!--- Item4 --->
                    <li class="dd-item" data-id="{{$cMenu->id}}">
                        <div class="dd-handle">{{$cMenu->name}}<input type="hidden" class="storfront-menu" value="{{$cMenu->id}}"></div>
                        
                        <span class="button-delete btn btn-icon  btn-danger delete-attribute delete-attribute"
                            data-owner-id="{{$cMenu->id}}">
                        <i class="fa fa-trash-o"></i>
                        </span>
                        <span class="button-edit btn btn-icon btn-warning"
                            data-owner-id="{{$cMenu->id}}">
                        <i class="fa fa-edit" data-toggle="tooltip" title="" data-original-title="Edit"></i>
                        </span>
                        @if (!empty($cMenu->children))
                        @foreach ($cMenu->children as $ccMenu)
                        
                            <ol class="dd-list">
                                <!--- Item4 --->
                                <li class="dd-item" data-id="{{$ccMenu->id}}">
                                    <div class="dd-handle">{{$ccMenu->name}}<input type="hidden" class="storfront-menu" value="{{$ccMenu->id}}"></div>
                                    
                                    <span class="button-delete btn btn-icon  btn-danger delete-attribute delete-attribute"
                                        data-owner-id="{{$ccMenu->id}}">
                                    <i class="fa fa-trash-o"></i>
                                    </span>
                                    <span class="button-edit btn btn-icon btn-warning"
                                        data-owner-id="{{$ccMenu->id}}">
                                    <i class="fa fa-edit" data-toggle="tooltip" title="" data-original-title="Edit"></i>
                                    </span>

                                    @if (!empty($ccMenu->children))
                                    @foreach ($ccMenu->children as $cccMenu)
                                    
                                        <ol class="dd-list">
                                            <!--- Item4 --->
                                            <li class="dd-item" data-id="{{$cccMenu->id}}">
                                                <div class="dd-handle">{{$cccMenu->name}}<input type="hidden" class="storfront-menu" value="{{$cccMenu->id}}"></div>
                                                
                                                <span class="button-delete btn btn-icon  btn-danger delete-attribute delete-attribute"
                                                    data-owner-id="{{$cccMenu->id}}">
                                                <i class="fa fa-trash-o"></i>
                                                </span>
                                                <span class="button-edit btn btn-icon btn-warning"
                                                    data-owner-id="{{$cccMenu->id}}">
                                                <i class="fa fa-edit" data-toggle="tooltip" title="" data-original-title="Edit"></i>
                                                </span>
                                            </li>

                                        </ol>
                                    @endforeach
                                    @endif
                                </li>

                            </ol>
                        @endforeach
                        @endif
                    </li>

                </ol>
            @endforeach
            @endif
        </li>
    @endforeach
    </ol>
</div>

<div class="card-footer text-right">
    <input class="btn btn-primary" id="storfront_save" type="submit" value="Save Storfront Menu">
</div>