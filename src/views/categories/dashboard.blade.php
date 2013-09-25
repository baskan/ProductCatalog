@extends('ProductCatalog::layouts.interface-single')

@section('title')
    Manage Categories
@stop

@section('content')
    <h1>Category Management</h1>

    <!-- Our Messaging Partial -->
    @include('ProductCatalog::partials.messaging')

    <a class="add-new-object-button btn btn-primary pull-right" href="{{ url('manage/categories/new') }}"><span class="icon-plus icon-white"></span> New Category</a>

    <!-- If we have data then lets create a table and loop through that data to build it -->
    @if( !$orderedCategories->isEmpty() )
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Thumbnail</th>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Products</th>
                    <th>Active</th>
                </tr>
            </thead>
            <tbody>
                <!-- Start That Loopin' -->
                {{ $orderedCategoriesHTML }}                
            </tbody>
        </table>
    @endif
@stop