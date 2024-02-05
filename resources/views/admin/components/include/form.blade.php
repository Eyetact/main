<div class="row mb-2">
    <div class="col-md-12">
        <div class="input-box">
            <label class="input-label" for="component-id">{{ __('Component Id') }}</label>
            <input type="text" name="component_id" id="component-id" class="google-input @error('component_id') is-invalid @enderror" value="{{ isset($component) ? $component->component_id : old('component_id') }}"  required />
            @error('component_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-box">
            <label class="input-label" for="component-name">{{ __('Component Name') }}</label>
            <input type="text" name="component_name" id="component-name" class="google-input @error('component_name') is-invalid @enderror" value="{{ isset($component) ? $component->component_name : old('component_name') }}"  required />
            @error('component_name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>