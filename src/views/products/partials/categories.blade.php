            <div class="control-group">
                <label class="control-label">Product Category</label>
                <div class="controls">
                    <div class="well well-small">

                        <!-- Loop The Categories And Tick Em' If Appropriate -->
                        @foreach( $categories as $category )
                            <label class="checkbox">
                                <?php $checkedArray = Input::old('categories', array( ($product->categories()->where('categories.id','=',$category->id)->count() ? $category->id : null) ) ); ?>
                                {{ Form::checkbox('categories['.$category->id.']',  $category->id , in_array( $category->id, $checkedArray ) ); }}
                                {{ $category->name }}
                            </label>
                            @if ( $category->children()->count() > 0 )
                                @foreach( $category->children()->get() as $child )
                                    <label class="checkbox checkbox-indented">
                                        <?php $checkedArray = Input::old('categories', array( ($product->categories()->where('categories.id','=',$child->id)->count() ? $child->id : null) ) ); ?>
                                        {{ Form::checkbox('categories['.$child->id.']',  $child->id , in_array( $child->id, $checkedArray ) ); }}
                                        {{ $child->name }}
                                    </label>
                                @endforeach
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>