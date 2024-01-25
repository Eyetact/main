<div class="row mb-2">
    <div class="col-md-12">
        <div class="input-box">
            <label class="input-label" for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="google-input @error('name') is-invalid @enderror" value="{{ isset($category) ? $category->name : old('name') }}"  required />
            @error('name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
 	<div class="col-md-12">
        <label for="slider" class="form-label">{{ __('Slider') }}</label>
        <div class="row">
            <div class="col-md-11">
                <div class="input-box">
                    <input onmousemove="slider1.value=value" type="range" name="slider" class="range @error('slider') is-invalid @enderror" min="1" max="100" step="5" id="slider"  required>
                    @error('slider')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-1">  <output id="slider1"></output></div>
        </div>
	</div>

</div>