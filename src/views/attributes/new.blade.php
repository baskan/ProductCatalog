@extends('ProductCatalog::layouts.interface-single')

@section('title')
    Create New Attribute
@stop

@section('content')

    <!-- Breadcrumbs...yum -->
    <ul class="breadcrumb">
      <li><a href="{{ url('manage/attributes') }}">Attributes</a> <span class="divider">/</span></li>
      <li class="active">New Attribute</li>
    </ul>

    <h1>Create New Attribute</h1>

    <!-- Messaging System (Displays Errors, Success etc) -->
    @include('ProductCatalog::partials.messaging')

    {{ Form::open( [ 'url' => 'manage/attributes/new' , 'class' => 'form-horizontal' ] ) }}
        <fieldset>
            <legend>Basic Information</legend>

            <!-- Type -->
            <div class="control-group">
            <label class="control-label">Attribute Type</label>
                <div class="controls">
                    {{ Form::select('attribute_type_id', $attribute_types, Input::old('attribute_type_id') ) }}
                </div>
            </div>

            <!-- Key -->
            <div class="control-group">
                <label class="control-label">Key</label>
                <div class="controls">
                    {{ Form::text('key', Input::old('key'), [ 'placeholder'=>'Attribute Key ("sofa-color")' ] ) }}
                </div>
            </div>

            <!-- Name -->
            <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                    {{ Form::text('name', Input::old('name'), [ 'placeholder'=>'Attribute Name' ] ) }}
                </div>
            </div>

            <!-- Submit -->
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary"><span class="icon-plus icon-white"></span> Add New Attribute</button>
                </div>
            </div>

        </fieldset>
    {{ Form::close() }}

@stop