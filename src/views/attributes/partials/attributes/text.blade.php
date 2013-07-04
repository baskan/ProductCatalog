<!-- Default Value For The Text Attribute -->
<div class="control-group">
    <label class="control-label">Default Value</label>
    <div class="controls">
        {{ Form::text('default', Input::old('default' , $attribute->default ) , [ 'placeholder'=>'Default Attribute Value' ] ) }}
    </div>
</div>