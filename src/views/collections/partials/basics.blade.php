    <!-- Title -->
    <div class="control-group">
        <label class="control-label">Name</label>
        <div class="controls">
            {{ Form::text('name', Input::old('name' , $collection->name ), [ 'placeholder'=>'Collection Name' ] ) }}
        </div>
    </div>

    <!-- Title -->
    <div class="control-group">
        <label class="control-label">URL</label>
        <div class="controls">
            {{ Form::text('url', Input::old('url' , $collection->url ), [ 'placeholder'=>'Collection URL' ] ) }}
        </div>
    </div>