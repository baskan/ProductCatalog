@extends('ProductCatalog::layouts.interface-double')

@section('title')
    Edit {{ $category->name }}
@stop

@section('content')

    <ul class="breadcrumb">
      <li><a href="{{ url('manage/categories') }}">Categories</a> <span class="divider">/</span></li>
      <li class="active">Editing {{ $category->name }}</li>
    </ul>

    <h1>{{ $category->name }} <small>( {{ $category->slug }} )</small></h1>
    
@stop

@section('sidebar')

    <div class="well well-small">
        <h4>More Information</h4>
        <p><strong>Slug: </strong>Slugs are used as a unique identifier to the category. Usually they are hypenated as such: 'my-category-name'.</p>
    </div>

@stop