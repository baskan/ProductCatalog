@extends('ProductCatalog::layouts.interface-double')

@section('title')
    Edit {{ $attribute->name }}
@stop

@section('content')

    <!-- Breadcrumbs...yum -->
    <ul class="breadcrumb">
      <li><a href="{{ url('manage/attributes') }}">Attributes</a> <span class="divider">/</span></li>
      <li class="active">Editing {{ $attribute->name }}</li>
    </ul>

    <h1>{{ $attribute->name }}</h1>

    <!-- Messaging System (Displays Errors, Success etc) -->
    @include('ProductCatalog::partials.messaging')

    <!-- Open Our Form Pointing To The Appropriate Place -->
    {{ Form::open( [ 'url' => 'manage/attributes/edit/'.$attribute->id , 'class' => 'form-horizontal' ] ) }}

        <!-- Hidden Field To Pass The ID Through -->
        {{ Form::hidden('id', $attribute->id) }}

        <fieldset>
            <legend>Basic Information</legend>

            <!-- Type -->
            <div class="control-group">
            <label class="control-label">Attribute Type</label>
                <div class="controls">
                    {{ Form::select('attribute_type_id', $attribute_types, $attribute->attribute_type_id , [ 'disabled'=>'disabled' ] ) }}
                    <span class="help-block"><strong>Note:</strong> You cannot change the key once it has been set, this is to stop potential conflicts.</span>
                </div>
            </div>

            <!-- Key -->
            <div class="control-group">
                <label class="control-label">Key</label>
                <div class="controls">
                    {{ Form::text('key', $attribute->key, [ 'disabled'=>'disabled' ] ) }}
                    <span class="help-block"><strong>Note:</strong> You cannot change the key once it has been set, this is to stop potential conflicts.</span>
                </div>
            </div>

            <!-- Name -->
            <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                    {{ Form::text('name', Input::old('name' , $attribute->name ), [ 'placeholder'=>'Attribute Name' ] ) }}
                </div>
            </div>

            <!-- Submit -->
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary"><span class="icon-plus icon-white"></span> Save Attribute</button>
                </div>
            </div>

        </fieldset>
    {{ Form::close() }}

@stop

@section('sidebar')

    <div class="well well-small">
        <h4>Delete Attribute</h4>
        <p>Deleting this attribute will remove any assocations with attribute sets and product data (your products won't be deleted, just the associated attribute data).</p>
        <a href="{{ url('manage/attributes/delete/'.$attribute->id) }}" class="btn btn-danger"><span class="icon-remove icon-white"></span> Delete Attribute</a>
    </div>

@stop