@extends('ProductCatalog::layouts.interface-double')

@section('title')
    Manage Categories
@stop

@section('content')
    <h1>Category Management</h1>
    
    @if( !$categories->isEmpty() )
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Slug</th>
                    <th>Title</th>
                    <th>Products</th>
                    <th>Active</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>
                            <a href="{{ url('manage/categories/edit/'.$category->slug) }}">{{ $category->slug }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/categories/edit/'.$category->slug) }}">{{ $category->name }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/categories/edit/'.$category->slug) }}">0</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/categories/edit/'.$category->slug) }}">{{ $category->enabled }}</a>
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