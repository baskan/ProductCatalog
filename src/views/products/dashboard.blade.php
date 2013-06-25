@extends('ProductCatalog::layouts.interface-double')

@section('title')
    Manage Products
@stop

@section('content')
    <h1>Product Management</h1>
    
    <a class="add-new-object-button btn btn-primary pull-right" href="{{ url('manage/products/new') }}"><span class="icon-plus icon-white"></span> New Product</a>
    
    @if( !$products->isEmpty() )
        <table class="table table-condensed">
            <thead>
                <tr>
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
                            <a href="{{ url('manage/products/edit/'.$product->sku) }}">{{ $product->sku }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/products/edit/'.$product->sku) }}">{{ $product->title }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/products/edit/'.$product->sku) }}">&pound;{{ $product->price }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/products/edit/'.$product->sku) }}">categories</a>
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