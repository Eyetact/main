<form action="{{ route('module_manager.menu_update') }}" id="storfront_nested_form" method="POST" autocomplete="off" novalidate="novalidate">
    @csrf
    <textarea name="storfront_json" class="hide" id="storfront_json" cols="30" rows="10"></textarea>
    <input type="hidden" name="type" value="storfront">
</form>

<div class="storfront_nested_form">
    <div class="dd nestable" id="storfront_nestable">
        <ol class="dd-list" id="storfront_menu_list">
            @foreach ($storfrontMenu as $sMenu)
                <li class="dd-item" data-json="{{json_encode($sMenu)}}" data-id="{{$sMenu->id}}" data-name="{{$sMenu->name}}" data-meta_title="{{$sMenu->meta_title}}" data-meta_description="{{$sMenu->meta_description}}" data-code="{{$sMenu->code}}" data-path="{{$sMenu->path}}" data-is_enable="{{$sMenu->is_enable}}" data-include_in_menu="{{$sMenu->include_in_menu}}"  data-assigned_attributes="{{$sMenu->assigned_attributes}}" data-created_date="{{date('m-d-Y',strtotime($sMenu->created_date))}}">
                    <div class="dd-handle">
                        {{$sMenu->name}} <input type="hidden" class="storfront-menu" value="{{$sMenu->id}}">
                        @if ($sMenu->is_deleted)
                            <span class="tag tag-deleted  tag-red">Deleted</span>
                        @endif
                    </div>

                    @if ($sMenu->children->count())
                        <ol class="dd-list">
                            @foreach ($sMenu->children as $cMenu)
                                <li class="dd-item" data-json="{{json_encode($cMenu)}}" data-id="{{$cMenu->id}}" data-name="{{$cMenu->name}}" data-meta_title="{{$cMenu->meta_title}}" data-meta_description="{{$cMenu->meta_description}}" data-code="{{$cMenu->code}}" data-path="{{$cMenu->path}}" data-is_enable="{{$cMenu->is_enable}}" data-include_in_menu="{{$cMenu->include_in_menu}}"  data-assigned_attributes="{{$cMenu->assigned_attributes}}" data-created_date="{{date('m-d-Y',strtotime($cMenu->created_date))}}">
                                    <div class="dd-handle">
                                        {{$cMenu->name}}<input type="hidden" class="storfront-menu" value="{{$cMenu->id}}">
                                        @if ($cMenu->is_deleted)
                                            <span class="tag tag-deleted  tag-red">Deleted</span>
                                        @endif
                                    </div>

                                    @if ($cMenu->children->count())
                                        <ol class="dd-list">
                                            @foreach ($cMenu->children as $ccMenu)
                                                <li class="dd-item" data-json="{{json_encode($ccMenu)}}" data-id="{{$ccMenu->id}}" data-name="{{$ccMenu->name}}" data-meta_title="{{$ccMenu->meta_title}}" data-meta_description="{{$ccMenu->meta_description}}" data-code="{{$ccMenu->code}}" data-path="{{$ccMenu->path}}" data-is_enable="{{$ccMenu->is_enable}}" data-include_in_menu="{{$ccMenu->include_in_menu}}"  data-assigned_attributes="{{$ccMenu->assigned_attributes}}" data-created_date="{{date('m-d-Y',strtotime($ccMenu->created_date))}}">
                                                    <div class="dd-handle">
                                                        {{$ccMenu->name}}<input type="hidden" class="storfront-menu" value="{{$ccMenu->id}}">
                                                        @if ($ccMenu->is_deleted)
                                                            <span class="tag tag-deleted  tag-red">Deleted</span>
                                                        @endif
                                                    </div>

                                                    @if ($ccMenu->children->count())
                                                        <ol class="dd-list">
                                                            @foreach ($ccMenu->children as $cccMenu)
                                                                <li class="dd-item" data-json="{{json_encode($cccMenu)}}" data-id="{{$cccMenu->id}}" data-name="{{$cccMenu->name}}" data-meta_title="{{$cccMenu->meta_title}}" data-meta_description="{{$cccMenu->meta_description}}" data-code="{{$cccMenu->code}}" data-path="{{$cccMenu->path}}" data-is_enable="{{$cccMenu->is_enable}}" data-include_in_menu="{{$cccMenu->include_in_menu}}"  data-assigned_attributes="{{$cccMenu->assigned_attributes}}" data-created_date="{{date('m-d-Y',strtotime($cccMenu->created_date))}}">
                                                                    <div class="dd-handle">
                                                                        {{$cccMenu->name}}<input type="hidden" class="storfront-menu" value="{{$cccMenu->id}}">
                                                                        @if ($cccMenu->is_deleted)
                                                                            <span class="tag tag-deleted  tag-red">Deleted</span>
                                                                        @endif
                                                                    </div>
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
</div>

{{-- @if (!empty($storfrontMenu))
    <div class="card-footer text-right">
        <input class="btn btn-primary" id="storfront_save" type="submit" value="Save Storfront Menu">
    </div>
@endif --}}
