<!DOCTYPE html>
<html lang="en">
<head>
    <title>WebKioskLaravel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">




    {{--Style aus dem public folder--}}
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">


</head>
<body >
<nav class="navbar navbar-default navbar-fixed-top ">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="min-height: inherit; " href="#"><img class="img-responsive" src="{{ asset('images/logo2.png')}}" alt="webKioskHaselhorst" > </a>

            {{--width="217" height="61"--}}
            {{--<a class="navbar-brand" href="#">Logo </a>--}}
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav" >

                {{--Achtung ohne class activ in li. wird über jQuery in app.js gesetzt.--}}

                <li ><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/projects">Projects</a></li>
                <li><a href="/contact">Contact</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/auth/login2"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
        </div>




    </div>
</nav>

<div class="container-fluid text-center content-main" >
    <div class="row content">




        {{--<div class="col-sm-2 sidenav">--}}
            {{--<p><a href="#">Link</a></p>--}}
            {{--<p><a href="#">Link</a></p>--}}
            {{--<p><a href="#">Link</a></p>--}}
        {{--</div>--}}





        <div class="col-sx-8 col-md-10 text-left">
            {{--<div class="col-sm-10 text-left">--}}

            @yield('content')

        </div>




        <div class="col-sx-4 col-md-2 sidenav">


            @yield('contentService')

            {{--<div class="well">--}}
                {{--<p>ADS</p>--}}
            {{--</div>--}}



        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p>Footer Text</p>
</footer>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{ asset('jScripts/app.js')}}"></script>


</body>
</html>
