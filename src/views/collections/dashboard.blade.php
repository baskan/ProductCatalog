@extends('ProductCatalog::layouts.interface-single')

@section('title')
    Manage Collections
@stop

@section('content')
    <h1>Collection Management</h1>
    <p>You can assign a product to a collection in order to group them together as such.</p>

    <!-- Our Messaging Partial -->
    @include('ProductCatalog::partials.messaging')

    <a class="add-new-object-button btn btn-primary pull-right" href="{{ url('manage/collections/new') }}"><span class="icon-plus icon-white"></span> New Collection</a>

    <!-- If we have data then lets create a table and loop through that data to build it -->
    @if( !$collections->isEmpty() )
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>URL</th>
                    <th>Products</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collections as $collection)
                    <tr>
                        <td>
                            <a href="{{ url('manage/collections/edit/'.$collection->id) }}">{{ $collection->id }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/collections/edit/'.$collection->id) }}">{{ $collection->name }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/collections/edit/'.$collection->id) }}">{{ $collection->url }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/collections/edit/'.$collection->id) }}">{{ $collection->products()->count() }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@stop