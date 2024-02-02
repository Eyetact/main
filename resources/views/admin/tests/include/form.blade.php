<div class="row mb-2">
    <div class="col-md-12">
        <div class="input-box">
            <label class="input-label" for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="google-input @error('name') is-invalid @enderror" value="{{ isset($test) ? $test->name : old('name') }}"  required />
            @error('name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>