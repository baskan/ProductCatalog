@extends('ProductCatalog::layouts.interface-double')

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
    {{ Form::open( [ 'url' => 'manage/categories/edit/'.$category->id , 'class' => 'form-horizontal' , 'id'=>'category-edit-form' ] ) }}

        <!-- Hidden Field To Pass The ID Through -->
        {{ Form::hidden('id', $category->id) }}

        <!-- Tab Navigation Elements -->
        <ul class="nav nav-tabs">
          <li class="active"><a href="#basics" data-toggle="tab">Basic Information</a></li>
          <li><a href="#media" data-toggle="tab">Media</a></li>
        </ul>

        <!-- Start Our Tabs -->
        <div class="tab-content">
            <!-- Basic Information -->
            <fieldset class="tab-pane active" id="basics">
                @include('ProductCatalog::categories.partials.basics')
            </fieldset>

            <!-- Media / Uploads -->
            <fieldset class="tab-pane" id="media">
                @include('ProductCatalog::categories.partials.existing-media')
            </fieldset>
        </div>
        <fieldset>

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
        <h4>Upload Category Images</h4>
        <p>Drag and drop images into the box below or simply click it to select files to upload</p>
        <p><strong>Note: </strong>This will also save and refresh this category page.</p>
        {{ Form::open( [ 'url' => 'manage/categories/upload/'.$category->id , 'class' => 'dropzone square' , 'id'=>'imageUploads' , 'files'=>true ] ) }}
            <div class="fallback">
                <input name="file" type="file" multiple />
            </div>
        {{ Form::close() }}

        <h4>Delete Category</h4>
        @if($hasSubCategories)
            <p>Deleting this category is not possible until you have removed all sub-categories associated with it.</p>
        @else
            <p>Deleting this category will remove any category assocations with products (your products won't be deleted).</p>
            <a href="{{ url('manage/categories/delete/'.$category->id) }}" class="btn btn-danger"><span class="icon-remove icon-white"></span> Delete Category</a>
        @endif
    </div>

@stop

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('packages/davzie/ProductCatalog/js/dropzone/css/dropzone.css') }}">
@stop

@section('scripts')
    @parent
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="{{ asset('packages/davzie/ProductCatalog/js/dropzone/dropzone.min.js') }}"></script>
    <script>
        $(document).ready(function(){

            // Setup some options for our Dropzone
            Dropzone.options.imageUploads = {
                maxFilesize: 3,
                init: function(){

                    // When a file has completed uploading, check to see if others are queueing, if not then submit the form
                    // which saves all changes and then gets us back to the edit page
                    this.on("complete", function(file){

                        if( this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0 ){
                            // Submit dat form
                            $('#category-edit-form').submit();
                        }

                    });
                    this.on('sending',function(){
                        $('div.dz-default.dz-message').remove();
                    });

                }
            };

        });
    </script>
@stop