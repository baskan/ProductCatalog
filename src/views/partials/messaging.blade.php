@if( $errors->all() )
    <div class="alert alert-error">
    @foreach ($errors->all('<p>:message</p>') as $msg)
        {{ $msg }}
    @endforeach
    </div>
@endif
@if( $success )
    <div class="alert alert-success">
        {{ $success }}
    </div>
@endif