<form action="{{ route('products.store') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        @include('admin.products.include.form')

                        @include('admin.products.include.dropdown')

                        <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>

                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </form>