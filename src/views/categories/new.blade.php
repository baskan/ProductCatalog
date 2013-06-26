@extends('ProductCatalog::layouts.interface-double')

@section('title')
    Create New Category
@stop

@section('content')

    <ul class="breadcrumb">
      <li><a href="{{ url('manage/categories') }}">Categories</a> <span class="divider">/</span></li>
      <li class="active">New Category</li>
    </ul>

    <h1>Create New Category</h1>
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

            <!-- Title -->
            <div class="control-group">
                <label class="control-label">URL</label>
                <div class="controls">
                    {{ Form::text('url', Input::old('url'), [ 'placeholder'=>'Category URL' ] ) }}
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary"><span class="icon-plus icon-white"></span> Add New Category</button>
                </div>
            </div>

        </fieldset>
    {{ Form::close() }}

@stop

@section('sidebar')

<!--     <div class="well well-small">
        <h4>More Information</h4>
        <p><strong>SKU: </strong>SKU's must be unique to the product catalog.</p>
        <p><strong>Price: </strong>Prices should be specified without VAT or delivery costs (this will be added where required).</p>
    </div> -->

@stop