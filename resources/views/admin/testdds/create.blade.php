<form action="{{ route('testdds.store') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        @include('admin.testdds.include.form')

                        <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>

                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </form>