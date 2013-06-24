@extends('ProductCatalog::layouts.interface-single')

@section('title')
    Dashboard
@stop

@section('content')
  <div class="hero-unit">
    <h1>You have {{ $product_count }} active products</h1>
    <p>This is a count of all active products that are currently in the system.</p>
    <p><a href="{{ url('manage/products') }}" class="btn btn-primary btn-large">Manage Products &raquo;</a></p>
  </div>
@stop