@extends('ProductCatalog::layouts.interface-single')

@section('title')
    Edit {{ $category->name }}
@stop

@section('content')

    <!-- Breadcrumbs...yum -->
    <ul class="breadcrumb">
      <li><a href="{{ url('manage/categories') }}">Categories</a> <span class="divider">/</span></li>
      <li class="active">Editing {{ $category->name }}</li>
    </ul>

    <h1>{{ $category->name }} <small>( {{ $category->slug }} )</small></h1>

    <!-- Messaging System (Displays Errors, Success etc) -->
    @include('ProductCatalog::partials.messaging')

    <!-- Open Our Form Pointing To The Appropriate Place -->
    {{ Form::open( [ 'url' => 'manage/categories/edit/'.$category->id , 'class' => 'form-horizontal' ] ) }}

        <!-- Hidden Field To Pass The ID Through -->
        {{ Form::hidden('id', $category->id) }}

        <fieldset>
            <legend>Basic Information</legend>

            <!-- Title -->
            <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                    {{ Form::text('name', Input::old('name' , $category->name ), [ 'placeholder'=>'Category Name' ] ) }}
                </div>
            </div>

            <!-- Title -->
            <div class="control-group">
                <label class="control-label">URL</label>
                <div class="controls">
                    {{ Form::text('url', Input::old('url' , $category->url ), [ 'placeholder'=>'Category URL' ] ) }}
                </div>
            </div>

            <!-- Parent Category -->
            <div class="control-group">
            <label class="control-label">Parent Category</label>
                <div class="controls">
                    {{ Form::select('parent_id', $top_level_categories, Input::old('parent_id' , $category->parent_id ) , $parentCatAttributes ) }}
                    <span class="help-block"><strong>Note:</strong> You cannot change this if your category has sub-categories. First move those sub-categories to a new one.</span>
                </div>
            </div>

            <!-- Enabled -->
            <div class="control-group">
                <div class="controls">
                    <label class="checkbox">
                        {{ Form::checkbox('enabled', '1', Input::old('enabled' , $category->enabled)  ); }}
                        Enabled
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary"><span class="icon-plus icon-white"></span> Save Category</button>
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