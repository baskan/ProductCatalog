@if($category->media)
<ul class="thumbnails" id="category-media">
    @foreach($category->media as $upload)
        <li class="span3 thumbfix" upload-id="{{ $upload->id }}">
            <div class="thumbnail">
                <div class="image-container">
                    <img src="{{ $upload->sizeImg( 200 , 150 , false ) }}" alt="">
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
                        <?php $checkedArray = Input::old('hideFromGallery', ( $upload->gallery != 1 ? [ $upload->id => $upload->id ] : []  ) ) ?>
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

@section('scripts')
    @parent
    <script>
        $(document).ready(function(){
            $( "#category-media" ).sortable({
                stop: function(){
                    var items = new Array();
                    // Get all of the items in the array and add the key and element to the items thing
                    $('#category-media li').each(function( key , elem ){
                        items[key] = $(elem).attr('upload-id');
                    });

                    // Post the new ordering off to the order-images functionality
                    $.post("{{ url('manage/categories/order-images') }}", { data:items });

                }
            });
            $( "#category-media" ).disableSelection();
        });
    </script>
@stop