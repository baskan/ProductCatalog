@extends('ProductCatalog::layouts.interface-single')

@section('title')
    Manage Attributes
@stop

@section('content')
    <h1>Attribute Management</h1>

    <!-- Our Messaging Partial -->
    @include('ProductCatalog::partials.messaging')

    <!-- Create A New Attribute... Yeah -->
    <a class="add-new-object-button btn btn-primary pull-right" href="{{ url('manage/attributes/new') }}">
        <span class="icon-plus icon-white"></span> New Attribute
    </a>

    <!-- If we have data then lets create a table and loop through that data to build it -->
    @if( !$attributes->isEmpty() )

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
                @foreach($attributes as $attr)
                    <tr>
                        <td>
                            <a href="{{ url('manage/attribute-sets/edit/'.$attr->id) }}">{{ $attr->id }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/attribute-sets/edit/'.$attr->id) }}">{{ $attr->name }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/attribute-sets/edit/'.$attr->id) }}">{{ $attr->products()->count() }}</a>
                        </td>
                    </tr>
                @endforeach
                <!-- End Loopin' -->

            </tbody>
        </table>
    @endif
@stop