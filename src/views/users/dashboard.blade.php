@extends('ProductCatalog::layouts.interface-single')

@section('title')
    Manage Users
@stop

@section('content')
    <h1>User Management</h1>

    <!-- Our Messaging Partial -->
    @include('ProductCatalog::partials.messaging')

    <a class="add-new-object-button btn btn-primary pull-right" href="{{ url('manage/users/new') }}"><span class="icon-plus icon-white"></span> New User</a>

    <!-- If we have data then lets create a table and loop through that data to build it -->
    @if( !$users->isEmpty() )
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email Address</th>
                </tr>
            </thead>
            <tbody>
                <!-- Start That Loopin' -->
                @foreach($users as $user)
                    <tr>
                        <td>
                            <a href="{{ url('manage/users/edit/'.$user->id) }}">{{ $user->id }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/users/edit/'.$user->id) }}">{{ $user->getFullName() }}</a>
                        </td>
                        <td>
                            <a href="{{ url('manage/users/edit/'.$user->id) }}">{{ $user->email }}</a>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    @endif
@stop