<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=1100px">
    @section('css')
        <link rel="stylesheet" href="{{ asset('packages/Davzie/ProductCatalog/css/bootstrap.min.css') }}">
        <link rel="stylesheet/less" type="text/css" href="{{ asset( 'packages/Davzie/ProductCatalog/css/styles.less' ) }}">
    @show
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{ asset('packages/Davzie/ProductCatalog/favicon.ico') }}">
    <title>@yield('title')</title>
</head>
<body class="login-form">
    <section id="sign-in">
        <h1>Sign In</h1>
        {{ Form::open( [ 'url'=>'manage/login', 'class'=>'form-inline' ] ) }}
            {{ Form::token() }}
            @include('ProductCatalog::partials.messaging')
            <div class="control-group">
                <div class="controls">
                    <input type="text" class="input-xlarge" id="email" name="email" value="{{ Input::old('email') }}" placeholder="Email Address">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <input type="password" class="input-xlarge" id="password" name="password" placeholder="Password...">
                </div>
            </div>
            <input type="submit" class="btn btn-primary" value="Login To Dashboard" />
        {{ Form::close() }}
    </section>

    @section('scripts')
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{ asset('packages/Davzie/ProductCatalog/js/jquery.js') }}"><\/script>')</script>
        <script src="{{ asset('packages/Davzie/ProductCatalog/js/less.js') }}"></script>
    @show
</body>
</html>