/**
 * Created by tombar on 31.03.2016.
 */

/**
 *
 * Moment framework Configurierung für pikaday-Plugin
 *
 */

            // Das Moment objekt wird erzeugt wichtig um auf die methoden zugreifen zu können
            moment().format();

            moment.lang('de', {
                months : 'Januar_Februar_März_April_Mai_Juni_Juli_August_September_Oktober_November_Dezember'.split('_'),
                monthsShort : 'Jan._Febr._Mrz._Apr._Mai_Jun._Jul._Aug._Sept._Okt._Nov._Dez.'.split('_'),
                monthsParseExact : true,
                weekdays : 'Sonntag_Montag_Dienstag_Mittwoch_Donnerstag_Freitag_Samstag'.split('_'),
                weekdaysShort : 'So._Mo._Di._Mi._Do._Fr._Sa.'.split('_'),
                weekdaysMin : 'So_Mo_Di_Mi_Do_Fr_Sa'.split('_'),
                weekdaysParseExact : true,
                longDateFormat : {
                    LT: 'HH:mm',
                    LTS: 'HH:mm:ss',
                    L : 'DD.MM.YYYY',
                    LL : 'D. MMMM YYYY',
                    LLL : 'D. MMMM YYYY HH:mm',
                    //  LLLL : 'dddd, D. MMMM YYYY HH:mm'
                    LLLL : 'dddd, D. MMMM YYYY' // Eigenes Format ohne Zeit
                },
                calendar : {
                    sameDay: '[heute um] LT [Uhr]',
                    sameElse: 'L',
                    nextDay: '[morgen um] LT [Uhr]',
                    nextWeek: 'dddd [um] LT [Uhr]',
                    lastDay: '[gestern um] LT [Uhr]',
                    lastWeek: '[letzten] dddd [um] LT [Uhr]'
                },
                relativeTime : {
                    future : 'in %s',
                    past : 'vor %s',
                    s : 'ein paar Sekunden',
                    m : 'eine Minute',
                    mm : '%d Minuten',
                    h : 'eine Stunde',
                    hh : '%d Stunden',
                    d : 'ein Tag',
                    dd : '%d Tage',
                    M : 'einen Monat',
                    MM : '%d Monate',
                    y : 'ein Jahr',
                    yy : '%d Jahre'
                },
                ordinalParse: /\d{1,2}\./,
                ordinal : '%d.',
                week : {
                    dow : 1, // Monday is the first day of the week.
                    doy : 4  // The week that contains Jan 4th is the first week of the year.
                }
            });

            moment.lang('de');

            // picker Order-Date Kunden
            var picker = new Pikaday(
                {
                    field: document.getElementById('datepicker'),
                    firstDay: 1,
                    format: 'LLLL', //Das moment.js format
                    minDate: new Date(2000, 0, 1),
                    maxDate: new Date(2020, 12, 31),
                    yearRange: [2000,2020]


                });


               // datepicker  Admin: 'Artikel eines Tages
                var picker3 = new Pikaday(
                    {
                        field: document.getElementById('datepickerAdmin2'),
                        firstDay: 1,
                        format: 'LLLL', //Das moment.js format
                        minDate: new Date(2000, 0, 1),
                        maxDate: new Date(2020, 12, 31),
                        yearRange: [2000,2020],
                        onSelect: function(date) {
                            //alert(date);
                        }

                    });

                // datepicker Admin : Orders eines Tages
                var picker2 = new Pikaday(
                    {
                        field: document.getElementById('datepickerAdmin1'),
                        firstDay: 1,
                        format: 'LLLL', //Das moment.js format
                        minDate: new Date(2000, 0, 1),
                        maxDate: new Date(2020, 12, 31),
                        yearRange: [2000,2020],
                        onSelect: function(date) {
                            //alert(date);
                        }

                    });





 // ############### Ende Moment und pikaday Configurierung


// Für das laracast FlashMessagePLugin notwendig
$(function () {
    $('#flash-overlay-modal').modal();

});

// Wegen Post
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

    }
});






$('#getRequest').on('click',function () {

    $.ajax({

        type:'GET',
        url: 'getRequest',
        success: function (data) {

            $('#fromServer').append('<h1>' + data +'</h1>');
        }

    });

});


$('#postRequest').on('click',function () {

    //alert($('#postRequest').val());

    var orderID = $('#postRequest').val();

    var order = { orderId : 3,
        orderStatus : 'New'

    };

    $.ajax({

        type:'POST',
        url: 'orderDetails',
        data: {orderNumber : orderID},
        success: function (data) {

            $('#fromServer').append( data );
        }

    });

});




// Nur Zahlen von 0-9 sind erlaubt für Units in der Kunden-Orderpage
    $(document).on("input", ".numeric", function() {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });



    (function () {

        // function zum setzen der active navMenus, da die Seite neu geladen wird
        // muss die activeClass aus der aktuellen location heraus gesetzt werden
        // da das javascript file jedes mal neu geladen wird bei bestätigung eines Links !
        // Dazu werden die Links ohne active Class in Html eingefügt.

        //$('a[href="' + this.location.pathname + '"]').parents('li,ul').addClass('active');

        $('a[href="' + this.location.pathname + '"]').parents('li').addClass('active');


    }());


    AttachAdminOrderDetails();



/**
 *
 * Hier wird
 *
 * @constructor
 */
function AttachAdminOrderDetails() {

    //alert("Start1");


    // suche nach jeder (each) dataRow mit der class ".tblContent" (Das ist der Content der MasterTabelle)
    // zu der die DetailTabelle angezeigt werden soll
    $("#adminTableOrders").find(".tblContent").each(function () {

        // gefundenes Objekt speichern
        var dataRow = $(this);

        // die id des div (tableRow : wrapper für die Datenfelder )ermitteln die von php gesetzt
        var idRow = dataRow.attr("id"); // id_T

        // Die  "orderId" für die Detailtabelle, die als parameter für die Datenbankabfrage im PHP script
        // benötigt  wird ermitteln

        // Split schneidet idRow in 2 Teile und schreibt sie in ein array tmp[0] tmp[1] das _T wird dabei abgeschnitten
        var tmp = idRow.split("_T");
        var orderId = tmp[0];

        //TextSelection verhindern
        //  $("#" + idRow).disableSelection();


        // Bei Mausclick auf das Datenfeld [orderId_Cl] der Ordertabelle : Cl = click
        // wird die Detailtabelle im Div Container mit der 'orderId'  sichtbar.
        // Der Div container wurde vorher zu jeder Order generiert und auf Display:none gesetzt

        $("#" + orderId + "_T").find("#" + orderId + "_Cl").click(
            function () {
                $("#" + orderId).toggle('fast', function () {


                    // Wegen Post
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                        }
                    });

                    $.ajax({

                        type: 'POST',
                        url: '../orderDetails',
                        data: {orderNumber: orderId},
                        success: function (data) {

                            //  alert(data);

                            $("#" + orderId).html(data);

                        },
                        error: function (data) {
                            console.log('Error:', data);

                            alert('Error');
                        }

                    });

                });
            });


    });


}

