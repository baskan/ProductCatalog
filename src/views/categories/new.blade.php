@extends('ProductCatalog::layouts.interface-double')

@section('title')
    Create New Category
@stop

@section('content')

    <!-- Breadcrumbs...yum -->
    <ul class="breadcrumb">
      <li><a href="{{ url('manage/categories') }}">Categories</a> <span class="divider">/</span></li>
      <li class="active">New Category</li>
    </ul>

    <h1>Create New Category</h1>

    <!-- Messaging System (Displays Errors, Success etc) -->
    @include('ProductCatalog::partials.messaging')

    {{ Form::open( [ 'url' => 'manage/categories/new' , 'class' => 'form-horizontal' ] ) }}
        <fieldset>
            <legend>Basic Information</legend>

            <!-- Title -->
            <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                    {{ Form::text('name', Input::old('name'), [ 'placeholder'=>'Category Name' ] ) }}
                </div>
            </div>

            <!-- URL -->
            <div class="control-group">
                <label class="control-label">URL</label>
                <div class="controls">
                    {{ Form::text('url', Input::old('url'), [ 'placeholder'=>'Category URL' ] ) }}
                </div>
            </div>

            <!-- Submit -->
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary"><span class="icon-plus icon-white"></span> Add New Category</button>
                </div>
            </div>

        </fieldset>
    {{ Form::close() }}

@stop

@section('sidebar')

    <div class="well well-small">
        <h4>More Information</h4>
    </div>

@stop