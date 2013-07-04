<!-- Title -->
<div class="control-group">
    <label class="control-label" for="inputTitle">Title</label>
    <div class="controls">
        {{ Form::text('title', Input::old('title' , $product->title) , [ 'placeholder'=>'Product Title' ] ) }}
    </div>
</div>

<!-- SKU -->
<div class="control-group">
    <label class="control-label" for="inputSKU">SKU</label>
    <div class="controls">
        {{ Form::text('sku', Input::old('sku', $product->sku) , [ 'placeholder'=>'Product SKU' ] ) }}
        <span class="help-block"><strong>Note:</strong> This must be unique.</span>
    </div>
</div>

<!-- URL -->
<div class="control-group">
    <label class="control-label" for="inputURL">URL</label>
    <div class="controls">
        {{ Form::text('url', Input::old( 'url' , $product->url ) , [ 'placeholder'=>'Product URL' ] ) }}
        <span class="help-block"><strong>Note:</strong> This must be unique, will be used as a product URL.</span>
    </div>
</div>

<!-- Attribute Set -->
<div class="control-group">
    <label class="control-label">Attribute Set</label>
    <div class="controls">
        {{ Form::select('attribute_set_id', $attribute_sets, Input::old('attribute_set_id' , $product->attribute_set_id ) , [ 'id'=>'attributeSetDropdown' ] ) }}
        <span class="help-block hidden alert alert-warning" id="attributeSetHelpLabel"><strong>Note:</strong> You need to save the product in order to see the new attribute set changes.</span>
    </div>
</div>

<!-- Enabled Product -->
<div class="control-group">
    <div class="controls">
        <label class="checkbox">
            {{ Form::checkbox('enabled', '1', Input::old( 'enabled' , $product->enabled ) ); }}
            Enabled
        </label>
    </div>
</div>

<!-- Product Description -->
<div class="control-group">
    <label class="control-label" for="inputURL">Product Description</label>
    <div class="controls">
        {{ Form::textarea('description', Input::old( 'description' , $product->description ) , [ 'id'=>'product-description' , 'class'=>'interface-textarea' , 'placeholder'=>'Product Description' ] ) }}
    </div>
</div>

@section('scripts')
    @parent
    <script>
        $(document).ready(function(){
            $('#attributeSetDropdown').on('change',function(){
                $('#attributeSetHelpLabel').removeClass('hidden');
                $('#attributesNavTab').addClass('hidden');
                $('#attributes').remove();
            });

            $('#product-description').redactor();

        });
    </script>
@stop