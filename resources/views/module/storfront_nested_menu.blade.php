<form action="{{ route('menu.menu_update') }}" id="storfront_form" method="POST" autocomplete="off" novalidate="novalidate">
    @csrf
    <textarea name="storfront_json" class="hide" id="storfront_json" cols="30" rows="10"></textarea>
    <input type="hidden" name="type" value="storfront">
</form>
<div class="dd nestable" id="storfront_nestable">
    <ol class="dd-list" id="storfront_menu_list">
    @foreach ($storfrontMenu as $sMenu)
        <li class="dd-item" data-id="{{$sMenu->id}}">
            <div class="dd-handle">{{$sMenu->name}} <input type="hidden" class="storfront-menu" value="{{$sMenu->id}}"></div>


            <span class="button-delete btn btn-icon  btn-danger delete-attribute delete-attribute"
                data-owner-id="{{$sMenu->id}}">
            <i class="fa fa-trash-o"></i>
            </span>

            <span class="button-edit btn btn-icon btn-warning"
                data-owner-id="{{$sMenu->id}}">
            <i class="fa fa-edit" data-toggle="tooltip" title="" data-original-title="Edit"></i>
            </span>

            @if ($sMenu->children->count())
            <ol class="dd-list">
                @foreach ($sMenu->children as $cMenu)
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
                        @if ($cMenu->children->count())
                        <ol class="dd-list">
                            @foreach ($cMenu->children as $ccMenu)
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

                                    @if ($ccMenu->children->count())
                                    <ol class="dd-list">
                                        @foreach ($ccMenu->children as $cccMenu)
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
                                        @endforeach
                                    </ol>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                        @endif
                    </li>

                @endforeach
            </ol>
            @endif
        </li>
    @endforeach
    </ol>
</div>
@if (!empty($storfrontMenu))

<div class="card-footer text-right">
    <input class="btn btn-primary" id="storfront_save" type="submit" value="Save Storfront Menu">
</div>

@endif
