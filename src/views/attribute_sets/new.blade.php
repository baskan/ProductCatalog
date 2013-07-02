@extends('ProductCatalog::layouts.interface-single')

@section('title')
    Create New Attribute Set
@stop

@section('content')

    <!-- Breadcrumbs...yum -->
    <ul class="breadcrumb">
      <li><a href="{{ url('manage/attribute-sets') }}">Attribute Sets</a> <span class="divider">/</span></li>
      <li class="active">New Attribute Set</li>
    </ul>

    <h1>Create New Attribute Set</h1>

    <!-- Messaging System (Displays Errors, Success etc) -->
    @include('ProductCatalog::partials.messaging')

    {{ Form::open( [ 'url' => 'manage/attribute-sets/new' , 'class' => 'form-horizontal' ] ) }}
        <fieldset>
            <legend>Basic Information</legend>

            <!-- Title -->
            <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                    {{ Form::text('name', Input::old('name'), [ 'placeholder'=>'Attribute Set Name' ] ) }}
                </div>
            </div>

            <!-- Submit -->
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary"><span class="icon-plus icon-white"></span> Add New Attribute Set</button>
                </div>
            </div>

        </fieldset>
    {{ Form::close() }}

@stop