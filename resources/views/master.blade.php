<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Good Gateway Football')</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    @yield('meta')

    <!-- stylesheets -->
    {!! HTML::style('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/css/bootstrap.min.css') !!}
    {!! HTML::style('//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css') !!}

    {!! HTML::script('//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js') !!}
</head>
<body>

<div class="container">

    <div id="content">
        @yield('content')
    </div><!-- ./ #content -->
</div>

<!-- scripts -->
{!! HTML::script('//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js') !!}
{!! HTML::script('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js') !!}

</body>
</html>