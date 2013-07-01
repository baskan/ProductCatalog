@if($product->media()->count() > 0)
<ul class="thumbnails" id="product-media">
    @foreach($product->media()->orderBy('order','asc')->get() as $upload)
        <li class="span3 thumbfix" upload-id="{{ $upload->id }}">
            <div class="thumbnail">
                <div class="image-container">
                    <img src="{{ $upload->sizeImg( 200 , 150 ) }}" alt="">
                </div>
                <div class="gallery-options">
                    <label class="radio">
                        {{ Form::radio('mainImage', $upload->id, ( $mainImageId == $upload->id ? true : false ) ); }}
                        Main Image
                    </label>
                    <label class="radio">
                        {{ Form::radio('thumbnailImage', $upload->id, ( $thumbnailImageId == $upload->id ? true : false ) ); }}
                        Thumbnail Image
                    </label>
                    <label class="checkbox">
                        <?php $checkedArray = Input::old('hideFromGallery['.$upload->id.']', ( $upload->gallery === 1 ? [] : [ $upload->id ]  ) ); ?>
                        {{ Form::checkbox('hideFromGallery['.$upload->id.']', $upload->id, in_array( $upload->id, $checkedArray ) ) }}
                        Hide From Gallery
                    </label>
                    <label class="checkbox">
                        <?php $checkedArray = Input::old('deleteImage', [] ); ?>
                        {{ Form::checkbox('deleteImage['.$upload->id.']', $upload->id, in_array( $upload->id, $checkedArray ) ) }}
                        Delete Image
                    </label>
                </div>
            </div>
        </li>
    @endforeach
</ul>
@endif