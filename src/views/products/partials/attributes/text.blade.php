<!-- Product Specific Text Arribute Value -->
<div class="control-group">
    <label class="control-label">{{ $attribute->name }}</label>
    <div class="controls">
        {{ Form::text('attributes['.$attribute->id.']', $value , [ 'placeholder'=>$attribute->name ] ) }}
    </div>
</div>