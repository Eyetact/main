@if (Auth::user()->hasAnyPermission(['edit.plan', 'delete.plan']))
<div class="dropdown">
    <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

    </a>


    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        @can('edit.plan')
            <li class="dropdown-item">
                <a href="#" id="edit_item" data-path="{{ route('plans.view', $model->id) }}">View or Edit</a>
            </li>
        @endcan
        @can('delete.plan')
        <li class="dropdown-item">
            <a href="#" data-id="{{ $model->id }}" class="plan-delete">Delete</a>
        </li>
        @endcan
    </ul>
</div>
@endif
