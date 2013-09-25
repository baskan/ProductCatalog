    <!-- Title -->
    <div class="control-group">
        <label class="control-label">Name</label>
        <div class="controls">
            {{ Form::text('name', Input::old('name' , $category->name ), [ 'placeholder'=>'Category Name' ] ) }}
        </div>
    </div>

    <!-- Title -->
    <div class="control-group">
        <label class="control-label">URL</label>
        <div class="controls">
            {{ Form::text('url', Input::old('url' , $category->url ), [ 'placeholder'=>'Category URL' ] ) }}
        </div>
    </div>

    <!-- Parent Category -->
    <div class="control-group">
    <label class="control-label">Parent Category</label>
        <div class="controls">
            {{ Form::select('parent_id', $categoryDropdown, Input::old('parent_id' , $category->parent_id ) ) }}
        </div>
    </div>

    <!-- Enabled -->
    <div class="control-group">
        <div class="controls">
            <label class="checkbox">
                {{ Form::checkbox('enabled', '1', Input::old('enabled' , $category->enabled)  ); }}
                Enabled
            </label>
        </div>
    </div>

    <!-- Filterable -->
    <div class="control-group">
        <div class="controls">
            <label class="checkbox">
                {{ Form::checkbox('filterable', '1', Input::old('filterable' , $category->isFilterable() )  ); }}
                Filterable
            </label>
        </div>
    </div>

    <!-- Product Description -->
    <div class="control-group">
        <label class="control-label" for="inputURL">Category Description</label>
        <div class="controls">
            {{ Form::textarea('description', Input::old( 'description' , $category->description ) , [ 'id'=>'category-description' , 'class'=>'interface-textarea' , 'placeholder'=>'Category Description' ] ) }}
        </div>
    </div>

@section('scripts')
    @parent
    <script>
        $(document).ready(function(){
            $('#category-description').redactor();
        });
    </script>
@stop