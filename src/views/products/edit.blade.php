@extends('ProductCatalog::layouts.interface-double')

@section('title')
    Edit {{ $product->title }}
@stop

@section('content')

    <ul class="breadcrumb">
      <li><a href="{{ url('manage/products') }}">Products</a> <span class="divider">/</span></li>
      <li class="active">Editing {{ $product->sku }}</li>
    </ul>

    @include('ProductCatalog::partials.messaging')

    <!-- The Product Title And Accompanying Image -->
    <div class="clearfix">

        <!-- Dynamically Resize The Image And Cache It -->
        @if( $product->getMainImage() )
            <img class="pull-right product-edit-main-image" src="{{ $product->getMainImage()->sizeImg( 250 , 150 , false ) }}" />
        @endif

        <h1>{{ $product->title }}<br /><small>( {{ $product->sku }} )</small></h1>
    </div>

    <!-- This does not need to be multi-part as our uploads are handled by Dropzone -->
    {{ Form::open( [ 'url' => 'manage/products/edit/'.$product->id , 'class' => 'form-horizontal' , 'id'=>'productEditForm' ] ) }}

        <!-- Used To Validate Against -->
        {{ Form::hidden('id', $product->id) }}

        <!-- Tab Navigation Elements -->
        <ul class="nav nav-tabs">
          <li class="active"><a href="#basics" data-toggle="tab">Basic Information</a></li>
          <li><a href="#pricing" data-toggle="tab">Pricing</a></li>
          <li><a href="#media" data-toggle="tab">Media</a></li>
          <li><a href="#categories" data-toggle="tab">Categories</a></li>
          @if( $product->attribute_set_id )
              <li id="attributesNavTab"><a href="#attributes" data-toggle="tab">Attributes</a></li>
          @endif
        </ul>

        <!-- Start Our Tabs -->
        <div class="tab-content">

            <!-- Basic Information -->
            <fieldset class="tab-pane active" id="basics">
                @include('ProductCatalog::products.partials.basics')
            </fieldset>

            <!-- Pricing Information -->
            <fieldset class="tab-pane" id="pricing">
                 @include('ProductCatalog::products.partials.pricing')
            </fieldset>

            <!-- Media / Uploads -->
            <fieldset class="tab-pane" id="media">
                @include('ProductCatalog::products.partials.existing-media')
            </fieldset>

            <!-- Category Assignment -->
            <fieldset class="tab-pane" id="categories">
                @include('ProductCatalog::products.partials.categories')
            </fieldset>

            <!-- Attribute Sets / Values -->
            <fieldset class="tab-pane" id="attributes">
                @include('ProductCatalog::products.partials.attributes')
            </fieldset>
        </div>

        <!-- Submit Dat Form -->
        <fieldset>
            <button type="submit" class="btn btn-primary pull-right"><span class="icon-plus icon-white"></span> Save Product</button>
        </fieldset>

    {{ Form::close() }}
@stop

@section('sidebar')

    <!-- Sidebar Container -->
    <div class="well well-small">
        <h4>Upload Product Images</h4>
        <p>Drag and drop images into the box below or simply click it to select files to upload</p>
        <p><strong>Note: </strong>This will also save and refresh this product page.</p>
        {{ Form::open( [ 'url' => 'manage/products/upload/'.$product->id , 'class' => 'dropzone square' , 'id'=>'imageUploads' , 'files'=>true ] ) }}
            <div class="fallback">
                <input name="file" type="file" multiple />
            </div>
        {{ Form::close() }}

        <!-- Product Deletion -->
        <h4>Delete Product</h4>
        <p>Deleting this product cannot be undone, please be absolutely sure you want to do this before proceeding.</p>
        <a href="{{ url('manage/products/delete/'.$product->id) }}" class="btn btn-danger"><span class="icon-remove icon-white"></span> Delete Product</a>

    </div>

@stop

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('packages/Davzie/ProductCatalog/js/dropzone/css/dropzone.css') }}">
@stop

@section('scripts')
    @parent
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="{{ asset('packages/Davzie/ProductCatalog/js/dropzone/dropzone.min.js') }}"></script>
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
                            $('#productEditForm').submit();
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