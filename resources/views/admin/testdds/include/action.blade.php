


<td>


        <div class="dropdown">
            <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

            </a>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li class="dropdown-item">
                    <a href="{{route('testdds.show', $model->id)}}"  >View </a>
                    </li>

                    <li class="dropdown-item">
                        <a href="#" id="edit_item"  data-path="{{route('testdds.edit', $model->id)}}">Edit</a>
                        </li>


                <li class="dropdown-item">
                <a  href="#" data-id="{{$model->id}}" class="model-delete">Delete</a>
                </li>
            </ul>
        </div>

</td>
