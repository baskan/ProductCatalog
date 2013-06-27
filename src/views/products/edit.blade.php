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

        <!-- Used To Validate Against -->
        {{ Form::hidden('id', $product->id) }}

        <!-- Tab Navigation Elements -->
        <ul class="nav nav-tabs">
          <li class="active"><a href="#basics" data-toggle="tab">Basic Information</a></li>
          <li><a href="#pricing" data-toggle="tab">Pricing</a></li>
          <li><a href="#media" data-toggle="tab">Media</a></li>
          <li><a href="#categories" data-toggle="tab">Categories</a></li>
        </ul>

        <!-- Start Our Tabs -->
        <div class="tab-content">

            <!-- Basic Information -->
            <fieldset class="tab-pane active" id="basics">
                @include('ProductCatalog::products.partials.basics')
            </fieldset>

            <!-- Pricing Information -->
            <fieldset class="tab-pane" id="pricing">
                 @include('ProductCatalog::products.partials.pricing')
            </fieldset>

            <!-- Media / Uploads -->
            <fieldset class="tab-pane" id="media">
                @include('ProductCatalog::products.partials.existing-media')
            </fieldset>

            <!-- Category Assignment -->
            <fieldset class="tab-pane" id="categories">
                @include('ProductCatalog::products.partials.categories')
            </fieldset>
        </div>

        <fieldset>
            <button type="submit" class="btn btn-primary pull-right"><span class="icon-plus icon-white"></span> Save Product</button>
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