<div class="row mb-2">
    <div class="col-md-12">
        <div class="input-box">
            <label class="input-label" for="aaa">{{ __('Aaa') }}</label>
            <input type="text" name="aaa" id="aaa" class="google-input @error('aaa') is-invalid @enderror" value="{{ isset($category) ? $category->aaa : old('aaa') }}"  required />
            @error('aaa')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>