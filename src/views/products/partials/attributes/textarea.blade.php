<!-- Product Specific Attribute Values etc -->
<div class="control-group">
    <label class="control-label">{{ $attribute->name }}</label>
    <div class="controls">
        {{ Form::textarea('attributes['.$attribute->id.']', $value , [ 'class'=>'quick-editor' , 'placeholder'=>$attribute->name ] ) }}
    </div>
</div>