@if($product->media()->count() > 0)
<ul class="thumbnails">
    @foreach($product->media()->get() as $upload)
        <li class="span3">
            <div class="thumbnail">
                <div class="image-container">
                    <img src="{{ $upload->sizeImg( 245 , 150 ) }}" alt="">
                </div>
                <div class="gallery-options">
                    <label class="radio">
                        <input type="radio" name="mainImage" value="{{ $upload->id }}" checked>
                        Main Image
                    </label>
                    <label class="radio">
                        <input type="radio" name="thumbnailImage" value="{{ $upload->id }}" checked>
                        Thumbnail Image
                    </label>
                    <label class="checkbox">
                        <input type="checkbox" value="{{ $upload->id }}">
                        Show In Gallery
                    </label>
                </div>
            </div>
        </li>
    @endforeach
</ul>
@endif