<!-- Default Value For The Text Attribute -->
<div class="control-group">
    <label class="control-label" for="inputTitle">Default Value</label>
    <div class="controls">
        {{ Form::textarea('default_value', Input::old('default_value' , $attribute->default_value ) , [ 'id'=>'attribute-default-value' , 'placeholder'=>'Default Attribute Value' ] ) }}
    </div>
</div>

@section('scripts')
    @parent
    <script>
        $(document).ready(function(){
            $('#attribute-default-value').redactor();
        });
    </script>
@stop