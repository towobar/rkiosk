@extends('layouts.webSite');

@section('content')

    <div class="well service  text-center">

        <h3> HERZLICH WILLKOMMEN</h3>

    </div>

    <div class="well service text-justify">

       <p>
            Liebe Haselhorster !!, <br><br>

            hier findet Ihr ein Überblick unseres Angebotes.
            Um unseren Service zu optimieren, habt Ihr hier die Möglichkeit Artikel vorzubestellen,
            z.B. die Brötchen fürs Wochende. Oder Ihr könnt euch
            über besondere Angebote informieren, die unter NEWS
            veröffentlich werden.
            Dazu braucht Ihr euch  nur bei uns im Kiosk ein <span style='color:#eb7108;'>LOGIN</span> anlegen lassen.<br><br>
            Wir sehen uns bestimmt bald ...<br><br>

           <img class="img-responsive" src="{{ asset('images/Melanie.png')}}" alt="Melanie" ><br><br>
       </p>



    </div>

    <div class="well service ">

        <img class="img-responsive" style="margin: 0 auto;padding-top:30px;" src="{{ asset('images/Kiosk2.jpg')}}" alt="Kiosk" ><br><br>

    </div>





@endsection


@section('contentService')


    <div class="well service">

        <h4> <span class="label label-warning serviceHead">Service</span></h4>

        <p>
            Fon :<br>030/922 15705<br>
            Fax :<br>030/922 15706<br>
            E-Mail :<br>kiosk@xamu.org
        </p>

    </div>

    <div class="well service">

        <h4> <span class=" label label-warning  serviceHead">Open</span></h4>

          <p>
             Montag - Freitag :<br>6:00 - 18 Uhr<br>
             Samstag :<br>7:00 - 13 Uhr<br>
             Sonntag :<br>7:00 - 12 Uhr
          </p>


    </div>

    <div class="well service">

        <h4> <span class=" label label-warning  serviceHead">Adresse</span></h4>

        <p>
            13599 Berlin - Haselhorst <br>
            Haselhorster Damm 57
        </p>


    </div>

@endsection