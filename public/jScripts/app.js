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


            var picker = new Pikaday(
                {
                    field: document.getElementById('datepicker'),
                    firstDay: 1,
                    format: 'LLLL', //Das moment.js format
                    minDate: new Date(2000, 0, 1),
                    maxDate: new Date(2020, 12, 31),
                    yearRange: [2000,2020]


                });


 // ############### Ende Moment und pikaday Configurierung



(function () {

    // function zum setzen der active navMenus, da die Seite neu geladen wird
    // muss die activeClass aus der aktuellen location heraus gesetzt werden
    // da das javascript file jedes mal neu geladen wird bei bestätigung eines Links !
    // Dazu werden die Links ohne active Class in Html eingefügt.

    //$('a[href="' + this.location.pathname + '"]').parents('li,ul').addClass('active');

    $('a[href="' + this.location.pathname + '"]').parents('li').addClass('active');



    //$.each($('#myNavbar').find('li'), function() {
    //    $(this).toggleClass('active',
    //        $(this).find('a').attr('href') == window.location.pathname);
    //});

    //$('ul.nav > li').click(function (e) {
    //
    //    $('ul.nav > li').removeClass('active');
    //
    //    $(this).addClass('active');
    //
    //   // e.preventDefault();
    //
    //});



    //$(".nav li").on("click", function(){
    //
    //   alert('Hallo');
    //
    //
    //    $(".nav").find(".active").removeClass("active");
    //    $(this).addClass("active");
    //});

}());

var url = "/LARAVEL/webKioskLaravel/public/order";

function MobilOrder(e)
{

    alert('order'); return;


    // Array für die OrderObjekte global!

    var menge = 'empty';

    $('#articleList').find("li").each(function () {

        var liItem = $(this);

        var select = liItem.find('input[type="checkbox"]').prop('checked');

        // Ist der Artikel ausgewählt ?
        if(select == true )
        {
            var artikelMenge = liItem.find('input[type="number"]').val();

            // Menge eingegeben ?
            if( artikelMenge >= 1 && artikelMenge <= 99)
            {
                menge = 'Ok';
            }
            else
            {
                menge = 'empty';
                return false; // Loop abbrechen

            }


            var orderUnit =  {

                // Die articleID-Class display:none, dient als container für die ArtikelId
                articleID : liItem.find('.articleID').text(),
                //Anzahl der Artikel
                units : artikelMenge

            };

            // Objekt in das ObjektArray anhängen
            currentOrders.push(orderUnit);

        }

    });


    if(currentOrders.length != 0 && menge != 'empty')
    {

        // Artikel und Menge korekt eingegeben -> weiterleiten zur orderConfirmPage
        $( "body" ).pagecontainer( "change", "#orderConfirm", { transition: 'slide' });


    }
    else
    {

        // FehlerMeldung

        var dialogText = 'Bitte Artikel auswählen <br> und Artikel-Menge (1-99) eingeben.';

        ShowPopupDialogBox('INFORMATION','ORDER : FEHLER !',dialogText,null);

        //ShowPopupDialogBox('CONFIRMATION','ORDER : FEHLER !',dialogText,test);

    }




}


//create new task / update existing task
$("#try").click(function (e) {

    // Wegen Post
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

        }
    });

    e.preventDefault();

alert('order1');

   // token = $(input[name=token]).val();

    var url = $(this).attr("data-link");


    $.post(url, {title: 'title'}).done(function(data) {
        alert('success');

    });


  return;


    $.ajax({

        type:'POST',
        url: url,
        data: {_token:'token'  ,order:'Done'},
        //dataType: 'json',
        success: function (data) {

              alert('success');
        },
        error: function (data) {
            console.log('Error:', data);

            alert('Error');
        }
    });


});