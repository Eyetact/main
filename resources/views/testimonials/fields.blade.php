<style>
    .alert-primary {
        color: #004085 !important;
        background-color: #cce5ff !important;
        border-color: #b8daff !important;
    }
</style>
<div class="column col-sm-6">
    <!-- Category Name Field -->
    <div class="form-group">
        {!! Form::label('store_view', __('models/testimonials.fields.store_view'), ['class' => 'required']) !!}
        {!! Form::select(
            'store_view',
            ['DRAFT' => 'DRAFT', 'PUBLISHED' => 'PUBLISHED', 'INACTIVE' => 'INACTIVE'],
            null,
            ['class' => 'form-control google-input custom-select'],
        ) !!}
    </div>

    <!-- Category Name Field -->
    <div class="form-group">
        {!! Form::label('name', __('models/testimonials.fields.name'), ['class' => 'required']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Category Name Field -->
    <div class="form-group">
        {!! Form::label('description', __('models/testimonials.fields.description'), ['class' => 'required']) !!}
        {!! Form::text('description', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Image Field -->
    <div class="form-group">
        {!! Form::hidden('old_image', $pageType == 'Edit' ? $category->image : null, [
            'class' => 'form-control',
        ]) !!}
        {!! Form::label('image', __('models/testimonials.fields.image'), [
            'class' => $pageType == 'Edit' ? '' : 'required',
        ]) !!}
        <div class="input-group">
            <div class="custom-file">
                {!! Form::file('image', ['class' => 'custom-file-input', 'id' => 'image']) !!}
                {!! Form::label('image', 'Choose file', ['class' => 'custom-file-label']) !!}
            </div>
        </div>
        <div class="alert alert-primary mt-2">
            <b>NOTE : </b> Add info for recommended size for Icon - 30*30.
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="" id="image-error">
    </div>
    @if ($pageType == 'Edit' && $category->image)
        <br />
        <p>
            <img src={{ env('AWS_URL') . $category->image }} height="150" width="200">
        </p>
    @endif
</div>
