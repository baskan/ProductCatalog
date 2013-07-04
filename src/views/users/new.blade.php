@extends('ProductCatalog::layouts.interface-single')

@section('title')
    Create New User
@stop

@section('content')

    <!-- Breadcrumbs...yum -->
    <ul class="breadcrumb">
      <li><a href="{{ url('manage/users') }}">Users</a> <span class="divider">/</span></li>
      <li class="active">New User</li>
    </ul>

    <h1>Create New User</h1>

    <!-- Messaging System (Displays Errors, Success etc) -->
    @include('ProductCatalog::partials.messaging')

    {{ Form::open( [ 'url' => 'manage/users/new' , 'class' => 'form-horizontal' ] ) }}
        <fieldset>
            <legend>Basic Information</legend>

            <!-- First Name -->
            <div class="control-group">
                <label class="control-label">First Name</label>
                <div class="controls">
                    {{ Form::text('first_name', Input::old('first_name'), [ 'placeholder'=>'First Name' ] ) }}
                </div>
            </div>

            <!-- Last Name -->
            <div class="control-group">
                <label class="control-label">Last Name</label>
                <div class="controls">
                    {{ Form::text('last_name', Input::old('last_name'), [ 'placeholder'=>'Last Name' ] ) }}
                </div>
            </div>

            <!-- Email Address -->
            <div class="control-group">
                <label class="control-label">Email Address</label>
                <div class="controls">
                    {{ Form::text('email', Input::old('email'), [ 'placeholder'=>'Email Address' ] ) }}
                </div>
            </div>

        </fieldset>
        <fieldset>
            <legend>Authentication</legend>

            <!-- New Password -->
            <div class="control-group">
                <label class="control-label">Password</label>
                <div class="controls">
                    {{ Form::password('password', '' , [ 'placeholder'=>'Enter New Password...' ] ) }}
                </div>
            </div>

            <!-- New Password Confirm -->
            <div class="control-group">
                <label class="control-label">Confirm Password</label>
                <div class="controls">
                    {{ Form::password('password_confirmation', '' , [ 'placeholder'=>'Confirm New Password...' ] ) }}
                </div>
            </div>

        </fieldset>
        <!-- Submit -->
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-primary"><span class="icon-plus icon-white"></span> Create User</button>
            </div>
        </div>
    {{ Form::close() }}

@stop