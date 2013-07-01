@extends('ProductCatalog::layouts.interface-double')

@section('title')
    Manage Products
@stop

@section('content')
    <h1>Product Management</h1>
    @include('ProductCatalog::partials.messaging')
    <a class="add-new-object-button btn btn-primary pull-right" href="{{ url('manage/products/new') }}"><span class="icon-plus icon-white"></span> New Product</a>
    
    @if( !$products->isEmpty() )
        <table class="table table-condensed item-listing-table">
            <thead>
                <tr>
                    <th>Thumb</th>
                    <th>SKU</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Categories</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            @if( $product->getThumbnailImage() )
                                <a href="{{ url('manage/products/edit/'.$product->id) }}">
                                    <img src="{{ $product->getThumbnailImage()->sizeImg( 100 , 60 ) }}" />
                                </a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('manage/products/edit/'.$product->id) }}">{{ $product->sku }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/products/edit/'.$product->id) }}">{{ $product->title }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/products/edit/'.$product->id) }}">&pound;{{ $product->price }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/products/edit/'.$product->id) }}">categories</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@stop

@section('sidebar')
    
    <div class="well well-small">
        <h4>More Information</h4>
    </div>

@stop