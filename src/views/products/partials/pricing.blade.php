<!-- Price Excluding VAT -->
<div class="control-group">
    <label class="control-label" for="inputPrice">Price (exc VAT)</label>
    <div class="controls">
        <div class="input-prepend">
            <span class="add-on">&pound;</span>
            {{ Form::text('price', ( Input::old('price') ? Input::old('price') : $product->price) , [ 'placeholder'=>'Product Price' ] ) }}
        </div>
    </div>
</div>