@extends('ProductCatalog::layouts.interface-single')

@section('title')
    Create New Collection
@stop

@section('content')

    <!-- Breadcrumbs...yum -->
    <ul class="breadcrumb">
      <li><a href="{{ url('manage/collections') }}">Collections</a> <span class="divider">/</span></li>
      <li class="active">New Collection</li>
    </ul>

    <h1>Create New Collection</h1>

    <!-- Messaging System (Displays Errors, Success etc) -->
    @include('ProductCatalog::partials.messaging')

    {{ Form::open( [ 'url' => 'manage/collections/new' , 'class' => 'form-horizontal' ] ) }}
        <fieldset>
            <legend>Basic Information</legend>

            <!-- Title -->
            <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                    {{ Form::text('name', Input::old('name'), [ 'placeholder'=>'Collection Name' ] ) }}
                </div>
            </div>

            <!-- URL -->
            <div class="control-group">
                <label class="control-label">URL</label>
                <div class="controls">
                    {{ Form::text('url', Input::old('url'), [ 'placeholder'=>'Collection URL' ] ) }}
                </div>
            </div>

            <!-- Submit -->
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary"><span class="icon-plus icon-white"></span> Add New Collection</button>
                </div>
            </div>

        </fieldset>
    {{ Form::close() }}

@stop