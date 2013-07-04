@extends('ProductCatalog::layouts.interface-single')

@section('title')
    Edit {{ $editing_user->getFullName() }}
@stop

@section('content')

    <!-- Breadcrumbs...yum -->
    <ul class="breadcrumb">
      <li><a href="{{ url('manage/users') }}">Users</a> <span class="divider">/</span></li>
      <li class="active">Editing {{ $editing_user->getFullName() }}</li>
    </ul>

    <h1>{{ $editing_user->getFullName() }}</h1>

    <!-- Messaging System (Displays Errors, Success etc) -->
    @include('ProductCatalog::partials.messaging')

    <!-- Open Our Form Pointing To The Appropriate Place -->
    {{ Form::open( [ 'url' => 'manage/users/edit/'.$editing_user->id , 'class' => 'form-horizontal' ] ) }}

        <!-- Hidden Field To Pass The ID Through -->
        {{ Form::hidden('id', $editing_user->id) }}

        <fieldset>
            <legend>Basic Information</legend>

            <!-- First Name -->
            <div class="control-group">
                <label class="control-label">First Name</label>
                <div class="controls">
                    {{ Form::text('first_name', Input::old('first_name' , $editing_user->first_name ), [ 'placeholder'=>'First Name' ] ) }}
                </div>
            </div>

            <!-- Last Name -->
            <div class="control-group">
                <label class="control-label">Last Name</label>
                <div class="controls">
                    {{ Form::text('last_name', Input::old('last_name' , $editing_user->last_name ), [ 'placeholder'=>'Last Name' ] ) }}
                </div>
            </div>

            <!-- Email Address -->
            <div class="control-group">
                <label class="control-label">Email Address</label>
                <div class="controls">
                    {{ Form::text('email', Input::old('email' , $editing_user->email ), [ 'placeholder'=>'Email Address' ] ) }}
                </div>
            </div>

        </fieldset>
        <fieldset>
            <legend>Authentication</legend>

            <!-- New Password -->
            <div class="control-group">
                <label class="control-label">Set New Password</label>
                <div class="controls">
                    {{ Form::password('password', '' , [ 'placeholder'=>'Enter New Password...' ] ) }}
                </div>
            </div>

            <!-- New Password Confirm -->
            <div class="control-group">
                <label class="control-label">Confirm New Password</label>
                <div class="controls">
                    {{ Form::password('password_confirmation', '' , [ 'placeholder'=>'Confirm New Password...' ] ) }}
                </div>
            </div>

        </fieldset>
        <!-- Submit -->
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-primary"><span class="icon-plus icon-white"></span> Save User</button>
            </div>
        </div>
    {{ Form::close() }}

@stop