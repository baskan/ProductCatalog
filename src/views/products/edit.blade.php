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
    {{ Form::open( [ 'url' => 'manage/products/edit/'.$product->id , 'class' => 'form-horizontal' , 'files'=>true ] ) }}
        {{ Form::hidden('id', $product->id) }}
        <fieldset>
            <legend>Basic Information</legend>

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

        </fieldset>
        <fieldset>
            <legend>Pricing</legend>

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

        </fieldset>
        <fieldset>
            <legend>Media</legend>
            @include('ProductCatalog::products.partials.existing-media')
            <div class="well well-small">
                <h3>Upload files here</h3>
            </div>
            
        </fieldset>
        <fieldset>
            <legend>Categories</legend>
            
            <div class="control-group">
                <label class="control-label">Product Category</label>
                <div class="controls">
                    <div class="well well-small">

                        <!-- Loop The Categories And Tick Em' If Appropriate -->
                        @foreach( $categories as $category )
                            <label class="checkbox">
                                <?php $checkedArray = Input::old('categories', array( ($product->categories()->where('categories.id','=',$category->id)->count() ? $category->id : null) ) ); ?>
                                {{ Form::checkbox('categories['.$category->id.']',  $category->id , in_array( $category->id, $checkedArray ) ); }}
                                {{ $category->name }}
                            </label>
                            @if ( $category->children()->count() > 0 )
                                @foreach( $category->children()->get() as $child )
                                    <label class="checkbox checkbox-indented">
                                        <?php $checkedArray = Input::old('categories', array( ($product->categories()->where('categories.id','=',$child->id)->count() ? $child->id : null) ) ); ?>
                                        {{ Form::checkbox('categories['.$child->id.']',  $child->id , in_array( $child->id, $checkedArray ) ); }}
                                        {{ $child->name }}
                                    </label>
                                @endforeach
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>


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