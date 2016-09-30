<!DOCTYPE html>
<html lang="en">
<head>
    <title>WebKioskLaravel</title>
    {{--<meta charset="utf-8">--}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>


    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    {{--Style aus dem public folder--}}

    {{--Kalendar Plugin--}}
    <link rel="stylesheet" href="{{ asset('css/pikaday.css')}}">


    <link rel="stylesheet" href="{{ asset('css/app.css')}}">

    <meta name="_token" content="{{ csrf_token() }}" />


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

                <li ><a href="/">HOME</a></li>
                <li><a href="/news">NEWS</a></li>

                <li><a href="/order">ORDER</a></li>


                @if ( isset(Auth::user()->name) && Auth::user()->name == "ADMIN")
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            ADMIN TOOLS <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/admin/customers">Kunden</a></li>
                            <li><a href="/admin/articles/{{0.0}}/{{'filename'}}">Artikel</a></li>
                            <li><a href="/admin/instock">InStock</a></li>
                            <li><a href="/admin/sortiment">Sortiment</a></li>
                            <li><a href="/admin/instock">InStock</a></li>
                            <li><a href="/admin/orders">Orders</a></li>
                            <li><a href="/admin/news">News</a></li>

                        </ul>
                    </li>
                @endif


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
                    {{--<li class="dropdown">--}}
                        {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
                            {{--<span class="glyphicon glyphicon-user"></span>  {{ Auth::user()->name }} <span class="caret"></span>--}}
                        {{--</a>--}}

                        {{--<ul class="dropdown-menu" role="menu">--}}
                            {{--<li><a href="{{ url('/logout') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}


                    <li><a href="{{ url('/logout') }}">{{ Auth::user()->name }}&nbsp;&nbsp;<span class="glyphicon glyphicon-log-out"></span> Logout</a></li>





                @endif
            </ul>

        </div>




    </div>
</nav>

<div class="container  content-main" >
    <div class="row content">


            @yield("content")


    </div>
</div>

<footer class="container-fluid text-center">
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-3">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#">About us</a></li>


                </ul>
            </div>
            <div class="col-sm-3">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#">Contact us</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#">Imprint</a></li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <ul class="nav nav-pills nav-justified" >
                <li  ><a href="/" class="copyRight" >© 2016 WebKioskHaselhorst.</a></li>
            </ul>
        </div>
    </div>

</footer>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>--}}

<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


{{--Moment-Framework : Zur Datum und Zeit Formatierung wird im KalenderPlugin zur Formatierung und Lokalisierung benutzt--}}
<script src="{{ asset('jScripts/moment-with-locales.min.js')}}"></script>

{{--Kalendar PLugin--}}

<script src="{{ asset('jScripts/pikaday.js')}}"></script>


<script src="{{ asset('jScripts/app.js')}}"></script>


<script>







</script>






</body>
</html>
