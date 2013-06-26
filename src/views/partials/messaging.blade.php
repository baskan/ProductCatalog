@if( $errors->all() )
    <div class="alert alert-error">
        <p><strong>Whoops! There was a problem.</strong></p>
        @foreach ($errors->all('<p>:message</p>') as $msg)
            {{ $msg }}
        @endforeach
    </div>
@endif
@if( $success )
    <div class="alert alert-success">
        <p><strong>Success!</strong></p>
        {{ $success }}
    </div>
@endif