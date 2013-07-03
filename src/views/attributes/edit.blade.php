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

        <!-- Tab Navigation Elements -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#basics" data-toggle="tab">Basic Information</a></li>
            <li><a href="#attributes" data-toggle="tab">Attribute Values</a></li>
        </ul>

        <!-- Start Our Tabs -->
        <div class="tab-content">

            <!-- Basic Information -->
            <fieldset class="tab-pane active" id="basics">
                @include('ProductCatalog::attributes.partials.basics')
            </fieldset>

            <!-- Attribute Values -->
            <fieldset class="tab-pane active" id="attributes">
                {{ $attributeValuesView }}
            </fieldset>

        </div>

        <fieldset>
            <!-- Submit -->
            <button type="submit" class="btn btn-primary pull-right"><span class="icon-plus icon-white"></span> Save Attribute</button>
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