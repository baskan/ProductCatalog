@extends('ProductCatalog::layouts.interface-double')

@section('title')
    Edit {{ $collection->name }}
@stop

@section('content')

    <!-- Breadcrumbs...yum -->
    <ul class="breadcrumb">
      <li><a href="{{ url('manage/collections') }}">Collections</a> <span class="divider">/</span></li>
      <li class="active">Editing {{ $collection->name }}</li>
    </ul>

    <h1>{{ $collection->name }} <small>( {{ $collection->slug }} )</small></h1>

    <!-- Messaging System (Displays Errors, Success etc) -->
    @include('ProductCatalog::partials.messaging')

    <!-- Open Our Form Pointing To The Appropriate Place -->
    {{ Form::open( [ 'url' => 'manage/collections/edit/'.$collection->id , 'class' => 'form-horizontal' , 'id'=>'collection-edit-form' ] ) }}

        <!-- Hidden Field To Pass The ID Through -->
        {{ Form::hidden('id', $collection->id) }}

        <!-- Tab Navigation Elements -->
        <ul class="nav nav-tabs">
          <li class="active"><a href="#basics" data-toggle="tab">Basic Information</a></li>
        </ul>

        <!-- Start Our Tabs -->
        <div class="tab-content">
            <!-- Basic Information -->
            <fieldset class="tab-pane active" id="basics">
                @include('ProductCatalog::collections.partials.basics')
            </fieldset>

        </div>
        <fieldset>

            <!-- Submit -->
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary"><span class="icon-plus icon-white"></span> Save Collection</button>
                </div>
            </div>

        </fieldset>
    {{ Form::close() }}

@stop

@section('sidebar')

    <div class="well well-small">
        <h4>Delete Collection</h4>
        <p>Deleting this collection will remove any collection assocations with products (your products won't be deleted).</p>
        <a href="{{ url('manage/collections/delete/'.$collection->id) }}" class="btn btn-danger"><span class="icon-remove icon-white"></span> Delete Collection</a>
    </div>

@stop