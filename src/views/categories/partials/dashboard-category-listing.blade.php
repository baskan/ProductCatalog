<tr class='{{ $category->level() == 0 ? 'highlighted' : '' }}'>
    <td>
        {{ $category->getLevelIndicator( '<i class="icon-minus" style="margin-right:-4px;"></i>' , '<i class="icon-chevron-right" style="margin-left:-6px;"></i>' ) }}
        @if( $category->getThumbnailImage() )
            <a href="{{ url('manage/categories/edit/'.$category->id) }}">
                <img src="{{ $category->getThumbnailImage()->sizeImg( 100 , 60 , false ) }}" />
            </a>
        @endif
    </td>
    <td>
        <a href="{{ url('manage/categories/edit/'.$category->id) }}">{{ $category->name }}</a>
    </td>
    <td>
        <a href="{{ url('manage/categories/edit/'.$category->id) }}">{{ $category->url }}</a>
    </td>
    <td>
        <a href="{{ url('manage/categories/edit/'.$category->id) }}">{{ count( $category->getAllProductsIncludingChildren() ) }}</a>
    </td>
    <td>
        <a href="{{ url('manage/categories/edit/'.$category->id) }}">{{ $category->enabled }}</a>
    </td>
</tr>