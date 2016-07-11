

<div>

    <p>
        Sehr geehrter Kunde  <span style="color:#178fe5"  >{{ $customer }}</span>, <br><br>

        hiermit erhalten Sie eine Übersicht Ihrer Bestellung vom <span style="color:#178fe5"  >{{ $orderDate }}</span>

    </p>


    <table>
        <thead><tr style="color:#178fe5"><td>ARTIKEL</td><td>PREIS</td><td>STÜCK</td><td>SUBTOTAL</td></tr></thead>

    @foreach ($orderedArticles as $article)

        <tr><td>{{$article->name}}</td><td>{{$article->price}}</td><td>{{$article->units}}</td><td>{{$article->units * $article->price }}</td></tr>


     {{--Berechnung des GesamtPreises der Bestellung  kleiner workaround damit $total nicht angezeigt wird bei der Berechnung ! --}}

            {{--*/   @$total += $article->units * $article->price     /*--}}


    @endforeach

        <tr style="color:#178fe5"><td></td><td></td><td>TOTAL</td><td>{{$total}}</td></tr>

    </table>

    <p>
        Vielen Dank für Ihre Bestellung !<br><br>

        Alle Preise sind in Euro.<br><br>

        Mit freundlichen Grüßen<br><br>

        Ihr KIOSK-TEAM



    </p>


</div>

