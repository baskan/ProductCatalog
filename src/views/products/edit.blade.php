@extends('ProductCatalog::layouts.interface-double')

@section('title')
    Edit {{ $product->title }}
@stop

@section('content')

    <ul class="breadcrumb">
      <li><a href="{{ url('manage/products') }}">Products</a> <span class="divider">/</span></li>
      <li class="active">Editing {{ $product->sku }}</li>
    </ul>

    <h1>{{ $product->title }} <small>( {{ $product->sku }} )</small></h1>
    @include('ProductCatalog::partials.messaging')
    {{ Form::open( [ 'url' => 'manage/products/edit/'.$product->id , 'class' => 'form-horizontal' ] ) }}
        <fieldset>
            <legend>Basic Information</legend>

            <div class="control-group">
                <label class="control-label" for="inputTitle">Title</label>
                <div class="controls">
                    <input type="text" id="inputTitle" name="title" placeholder="Product Title" value="{{ Input::old('title') ? Input::old('title') : $product->title }}" >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputSKU">SKU</label>
                <div class="controls">
                    <input type="text" id="inputSKU" name="sku" placeholder="Product SKU" value="{{ Input::old('sku') ? Input::old('sku') : $product->sku }}" >
                    <span class="help-block"><strong>Note:</strong> This must be unique.</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputURL">URL</label>
                <div class="controls">
                    <input type="text" id="inputURL" name="url" placeholder="Product URL" value="{{ Input::old('url') ? Input::old('url') : $product->url }}" >
                    <span class="help-block"><strong>Note:</strong> This must be unique.</span>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Pricing</legend>
            <div class="control-group">
                <label class="control-label" for="inputPrice">Price (exc VAT)</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on">&pound;</span>
                        <input type="text" id="inputPrice" name="price" placeholder="Price" value="{{ Input::old('price') ? Input::old('price') : $product->price }}" >
                    </div>
                </div>
            </div>

        </fieldset>
        <fieldset>
            <legend>Media</legend>
            <ul class="thumbnails">
                <li class="span3">
                    <div class="thumbnail">
                        <div class="image-container">
                            <img src="http://placekitten.com/300/200" alt="">
                        </div>
                        <div class="gallery-options">
                            <label class="radio">
                                <input type="radio" name="mainImage" value="1" checked>
                                Main Image
                            </label>
                            <label class="radio">
                                <input type="radio" name="thumbnailImage" value="1" checked>
                                Thumbnail Image
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" value="1">
                                Show In Gallery
                            </label>
                        </div>
                    </div>
                </li>
                <li class="span3">
                    <div class="thumbnail">
                        <div class="image-container">
                            <img src="http://placekitten.com/300/400" alt="">
                        </div>
                        <div class="gallery-options">
                            <label class="radio">
                                <input type="radio" name="mainImage" value="2">
                                Main Image
                            </label>
                            <label class="radio">
                                <input type="radio" name="thumbnailImage" value="2">
                                Thumbnail Image
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" value="2">
                                Show In Gallery
                            </label>
                        </div>
                    </div>
                </li>
                <li class="span3">
                    <div class="thumbnail">
                        <div class="image-container">
                            <img src="http://placekitten.com/300/600" alt="">
                        </div>
                        <div class="gallery-options">
                            <label class="radio">
                                <input type="radio" name="mainImage" value="3">
                                Main Image
                            </label>
                            <label class="radio">
                                <input type="radio" name="thumbnailImage" value="3">
                                Thumbnail Image
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" value="3">
                                Show In Gallery
                            </label>
                        </div>
                    </div>
                </li>        
            </ul>
            <div class="well well-small">
                <h3>Upload files here</h3>

            </div>
            
        </fieldset>
        <fieldset>
            <legend>Categories</legend>
            <p>cats</p>
        </fieldset>
        <fieldset>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary"><span class="icon-plus icon-white"></span> Save Product</button>
                </div>
            </div>
        </fieldset>
    {{ Form::close() }}
@stop

@section('sidebar')

    <div class="well well-small">
        <h4>More Information</h4>
        <p><strong>SKU: </strong>SKU's must be unique to the product catalog.</p>
        <p><strong>Price: </strong>Prices should be specified without VAT or delivery costs (this will be added where required).</p>
    </div>

@stop