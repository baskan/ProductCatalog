@extends('ProductCatalog::layouts.interface-double')

@section('title')
    Manage Categories
@stop

@section('content')
    <h1>Category Management</h1>

    <!-- Our Messaging Partial -->
    @include('ProductCatalog::partials.messaging')

    <a class="add-new-object-button btn btn-primary pull-right" href="{{ url('manage/categories/new') }}"><span class="icon-plus icon-white"></span> New Category</a>

    <!-- If we have data then lets create a table and loop through that data to build it -->
    @if( !$categories->isEmpty() )
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Products</th>
                    <th>Active</th>
                </tr>
            </thead>
            <tbody>
                <!-- Start That Loopin' -->
                @foreach($categories as $category)
                    <tr>
                        <td>
                            <a href="{{ url('manage/categories/edit/'.$category->id) }}">{{ $category->name }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/categories/edit/'.$category->id) }}">{{ $category->url }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/categories/edit/'.$category->id) }}">{{ $category->products()->count() }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/categories/edit/'.$category->id) }}">{{ $category->enabled }}</a>
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