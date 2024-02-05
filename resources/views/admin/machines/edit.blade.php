

                    <form action="{{ route('machines.update', $machine->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('admin.machines.include.form')

                        <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>

                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </form>
