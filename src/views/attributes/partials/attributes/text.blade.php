<!-- Default Value For The Text Attribute -->
<div class="control-group">
    <label class="control-label" for="inputTitle">Default Value</label>
    <div class="controls">
        {{ Form::text('default_value', Input::old('default_value' , $attribute->default_value ) , [ 'placeholder'=>'Default Attribute Value' ] ) }}
    </div>
</div>