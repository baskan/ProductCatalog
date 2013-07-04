@extends('ProductCatalog::layouts.interface-double')

@section('title')
    Edit {{ $set->name }}
@stop

@section('content')

    <!-- Breadcrumbs...yum -->
    <ul class="breadcrumb">
      <li><a href="{{ url('manage/attribute-sets') }}">Attribute Sets</a> <span class="divider">/</span></li>
      <li class="active">Editing {{ $set->name }}</li>
    </ul>

    <h1>{{ $set->name }}</h1>

    <!-- Messaging System (Displays Errors, Success etc) -->
    @include('ProductCatalog::partials.messaging')

    <!-- Open Our Form Pointing To The Appropriate Place -->
    {{ Form::open( [ 'url' => 'manage/attribute-sets/edit/'.$set->id , 'class' => 'form-horizontal' ] ) }}

        <!-- Hidden Field To Pass The ID Through -->
        {{ Form::hidden('id', $set->id) }}

        <fieldset>
            <legend>Basic Information</legend>

            <!-- Title -->
            <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                    {{ Form::text('name', Input::old('name' , $set->name ), [ 'placeholder'=>'Attribute Set Name' ] ) }}
                </div>
            </div>

        </fieldset>
        @if( !$attributes->isEmpty() )
            <fieldset>
                <legend>Assigned Attributes</legend>

                <div class="control-group">
                    <label class="control-label">Assigned Attributes</label>
                    <div class="controls">
                        <div class="well well-small">

                            <!-- Loop The Categories And Tick Em' If Appropriate -->
                            @foreach( $attributes as $attr )
                                <label class="checkbox">
                                    {{ Form::checkbox('assigned_attributes['.$attr->id.']',  $attr->id ) }}
                                    {{ $attr->name }} <small>( {{ $attr->type()->getName() }} :: {{ $attr->key }} )</small>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

            </fieldset>
        @endif
        <fieldset>
            <!-- Submit -->
            <button type="submit" class="btn btn-primary pull-right"><span class="icon-plus icon-white"></span> Save Attribute Set</button>

        </fieldset>
    {{ Form::close() }}

@stop

@section('sidebar')

    <div class="well well-small">
        <h4>Delete Attribute Set</h4>
        <p>Deleting this attribute set will remove any assocations with products (your products won't be deleted).</p>
        <a href="{{ url('manage/attribute-sets/delete/'.$set->id) }}" class="btn btn-danger"><span class="icon-remove icon-white"></span> Delete Attribute Set</a>
    </div>

@stop