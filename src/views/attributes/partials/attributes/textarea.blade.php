<!-- Default Value For The Text Attribute -->
<div class="control-group">
    <label class="control-label" for="inputTitle">Default Value</label>
    <div class="controls">
        {{ Form::textarea('default', Input::old('default' , $attribute->default ) , [ 'id'=>'attribute-default-value' , 'placeholder'=>'Default Attribute Value' ] ) }}
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