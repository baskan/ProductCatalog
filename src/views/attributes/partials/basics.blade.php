<!-- Type -->
<div class="control-group">
<label class="control-label">Attribute Type</label>
    <div class="controls">
        {{ Form::select('attribute_type_id', $attribute_types, $attribute->attribute_type_id , [ 'disabled'=>'disabled' ] ) }}
        <span class="help-block"><strong>Note:</strong> You cannot change the key once it has been set, this is to stop potential conflicts.</span>
    </div>
</div>

<!-- Key -->
<div class="control-group">
    <label class="control-label">Key</label>
    <div class="controls">
        {{ Form::text('key', $attribute->key, [ 'disabled'=>'disabled' ] ) }}
        <span class="help-block"><strong>Note:</strong> You cannot change the key once it has been set, this is to stop potential conflicts.</span>
    </div>
</div>

<!-- Name -->
<div class="control-group">
    <label class="control-label">Name</label>
    <div class="controls">
        {{ Form::text('name', Input::old('name' , $attribute->name ), [ 'placeholder'=>'Attribute Name' ] ) }}
    </div>
</div>