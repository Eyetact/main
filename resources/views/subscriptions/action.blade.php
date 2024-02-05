
@if (Auth::user()->hasAnyPermission(['edit.subscription', 'delete.subscription']))
<div class="dropdown">
    <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

    </a>


    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        @can('edit.subscription')
    <li class="dropdown-item">
        <a  href="#" id="edit_item" data-path="{{ route('subscriptions.view', $model->id) }}">View or Edit</a>
        </li>
        @endcan

        @can('delete.subscription')
        <li class="dropdown-item">
        <a  href="#" data-id="{{$model->id}}" class="subscription-delete">Delete</a>
        </li>
        @endcan
    </ul>
</div>
@endif
