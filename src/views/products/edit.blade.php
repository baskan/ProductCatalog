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
    
@stop

@section('sidebar')

    <div class="well well-small">
        <h4>More Information</h4>
        <p><strong>SKU: </strong>SKU's must be unique to the product catalog.</p>
        <p><strong>Price: </strong>Prices should be specified without VAT or delivery costs (this will be added where required).</p>
    </div>

@stop