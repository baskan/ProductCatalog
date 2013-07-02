@extends('ProductCatalog::layouts.interface-single')

@section('title')
    Manage Attribute Sets
@stop

@section('content')
    <h1>Attribute Set Management</h1>

    <!-- Our Messaging Partial -->
    @include('ProductCatalog::partials.messaging')

    <a class="add-new-object-button btn btn-primary pull-right" href="{{ url('manage/attribute-sets/new') }}"><span class="icon-plus icon-white"></span> New Attribute Set</a>

    <!-- If we have data then lets create a table and loop through that data to build it -->
    @if( !$sets->isEmpty() )

        <!-- Table Head -->
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Number Of Products</th>
                </tr>
            </thead>
            <tbody>
                <!-- Start That Loopin' -->
                @foreach($sets as $set)
                    <tr>
                        <td>
                            <a href="{{ url('manage/attribute-sets/edit/'.$set->id) }}">{{ $set->id }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/attribute-sets/edit/'.$set->id) }}">{{ $set->name }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/attribute-sets/edit/'.$set->id) }}">{{ $set->products()->count() }}</a>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    @endif
@stop