

<div>

    <p>
        Sehr geehrter Kunde  <span style="color:#178fe5"  >{{ $customer }}</span>, <br><br>

        hiermit erhalten Sie eine Übersicht Ihrer Bestellung vom <span style="color:#178fe5"  >{{ $orderDate }}</span>

    </p>


    <table>
        <thead><tr style="color:#178fe5"><td>ARTIKEL</td><td>PREIS</td><td>STÜCK</td><td>SUBTOTAL</td></tr></thead>

    @foreach ($cartItems as $item)

        <tr><td>{{$item->name}}</td><td>{{$item->price}}</td><td>{{$item->qty}}</td><td>{{$item->qty * $item->price }}</td></tr>


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

