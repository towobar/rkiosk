<!DOCTYPE html>
<html lang="en">
<head>
    <title>WebKioskLaravel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>


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

                @if ( isset(Auth::user()->name) && Auth::user()->name == "ADMIN")
                  <li><a href="/projects">Projects</a></li>
                @endif
                <li><a href="/contact">Contact</a></li>

            </ul>


            {{--<ul class="nav navbar-nav navbar-right">--}}
                {{--<li><a href="/auth/login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>--}}
                {{--@if (Auth::guest())--}}
                    {{--<li><a href="/auth/register"><i class="glyphicon glyphicon-user"></i> Register</a></li>--}}
                    {{--<li><a href="/auth/login"><i class="glyphicon glyphicon-log-in"></i> Login</a></li>--}}
                {{--@else--}}
                    {{--<li class="navbar-text"><i class="glyphicon glyphicon-user"></i>{{ Auth::user()->name }}</li>--}}
                    {{--<li><a href="/auth/logout"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>--}}
                {{--@endif--}}

            {{--</ul>--}}




            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <li><a href="{{ url('/register') }}"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                        </ul>
                    </li>
                @endif
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
