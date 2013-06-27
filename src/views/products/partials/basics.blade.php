<!-- Title -->
<div class="control-group">
    <label class="control-label" for="inputTitle">Title</label>
    <div class="controls">
        {{ Form::text('title', ( Input::old('title') ? Input::old('title') : $product->title) , [ 'placeholder'=>'Product Title' ] ) }}
    </div>
</div>

<!-- SKU -->
<div class="control-group">
    <label class="control-label" for="inputSKU">SKU</label>
    <div class="controls">
        {{ Form::text('sku', ( Input::old('sku') ? Input::old('sku') : $product->sku) , [ 'placeholder'=>'Product SKU' ] ) }}
        <span class="help-block"><strong>Note:</strong> This must be unique.</span>
    </div>
</div>

<!-- URL -->
<div class="control-group">
    <label class="control-label" for="inputURL">URL</label>
    <div class="controls">
        {{ Form::text('url', ( Input::old('url') ? Input::old('url') : $product->url) , [ 'placeholder'=>'Product URL' ] ) }}
        <span class="help-block"><strong>Note:</strong> This must be unique, will be used as a product URL.</span>
    </div>
</div>


<div class="control-group">
    <div class="controls">
        <label class="checkbox">
            {{ Form::checkbox('enabled', '1', ( Input::old('enabled') ? Input::old('enabled') : $product->enabled ) ); }}
            Enabled
        </label>
    </div>
</div>