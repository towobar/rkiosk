/**
 * Created by tombar on 31.03.2016.
 */

function InitApplication()
{

  // alert('StartInitApp');

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

                // datepicker Admin : New Message
                var picker4 = new Pikaday(
                    {
                        field: document.getElementById('datepickerNewMessage'),
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


    // Init htmlEditor-Plugin : markItUp : in der AdminNews Page
    $('#newsAdminContent').markItUp(mySettings);




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





//  Nur Sample gehört nicht zum Shop !
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


    $.ajax({

        type:'POST',
        url: '../admin/orderDetails',
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



} // End InitApplication


/**
 *
 * Bei click auf die OrderId in der Admin-Orders Tabelle
 * werden über Ajax, die bestellten Artikel ein/aus geblendet
 * @param divId
 * @constructor
 */
function AdminOrdersShowDetails(divId)
{


    var tmp = divId.split("_Cl"); // divId=13_Cl Cl=click
    var orderId = tmp[0];

  //  alert(orderId);

    $("#" + orderId).toggle('fast', function () {


        // Wegen Post
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            }
        });

        $.ajax({

            type: 'POST',
            url: '../admin/orderDetails',
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



}


/**
 * Bei Click auf Bild in der AdminArtikeleliste wird das entsprechende Bild angezeigt
 * @param divId
 * @constructor
 */
function AdminArticleShowImage(divId)
{

    var input;
    var valueString;
    var values;

    // divId der Container indem sich das input befindet
    input = $('#'+ divId).find("input");

    // Der valueString des Inputfeldes enthält : imageName.jpg_articleName
    valueString  = input.attr("value");

    // imageName und articleName werden getrennt und liegen im Array. Image : values[0] + Article : values[1]
    values = valueString.split('_');

  var articleImg = "http://rkiosk.xamu.org/images/article/";
  //  var articleImg = "http://webkiosklaravel.de/images/article/";
    articleImg  += values[0];

    $('#adminHeadArticle').html('Artikel Name : ' + values[1] );

    $('#adminHeadImgFile').html('File Name : ' + values[0]);

    $('#adminImgArticle').attr('src',articleImg);

   // alert(artikelName);


}

// Globale Variable für das EingabeFeld (Input)der AdminArtikelDescription
var actInputObject = null;

function  ArticleDescripInputPrompt(divId)
{
    //  alert(divId);

    // 1. Ermitteln des ArticleNamen mit der ArtikelID über ArtikelBild ( Trick !)

        values1 = divId.split('_'); //'descrip_'. $article->id

        // Ermitteln des inputs mit der id=artikelId
        input = $('#'+ values1[1]).find("input");

        // Der valueString des Inputfeldes enthält : imageName.jpg_articleName
        valueString  = input.attr("value");

        // imageName und articleName werden getrennt und liegen im Array. Image : values[0] + Article : values[1]
        values = valueString.split('_');

        articleName = values[1];



  //  alert(divId);

    // 2. Ermitteln der Description aus dem Input value

    input = $('#'+ divId).find("input");

    articleDescription = input.attr("value");

   // Globale Variable für das EingabeFeld (Input)der AdminArtikelDescription wird benötigt für OK-Button AdminArticleDescripOk()
    actInputObject = input;


    // MarkUp für den EingabePrompt Dialog
    var htmlMarkUp  =

        "<div id='pDialog' class='promptDialog' >" +
        "<table>" +
        "<tr><td style='text-align:center;padding:5px'>Beschreibung : " + articleName + "</td></tr>" +
        "<tr><td ><textarea id='txtDescrip' style=' width:400px;height:200px;font-size:small;border:solid 2px #1c94c4;border-radius: 4px; margin:10px;overflow: auto;' > </textarea></td></tr>" +

        "<tr><td><button  onclick='AdminArticleDescripOk();' style='width: 80px; color:#1c94c4;margin-left:10px;'>OK</button><button onclick='AdminArticleDescripCancel();' style='float:right;width: 80px ;color:#1c94c4;margin-right:10px;'>Cancel</button></td></tr>" +
        "</table>"  +

        "</div>" ;

    // Den Dialog anzeigen
     $('body').append(htmlMarkUp);

    // Die Textarea des Dialoges mit den aktuellen Wert : (Beschreibung) aus der AdminArtikelTabelle initialisieren

    $('#txtDescrip').html(articleDescription);

  //  $('#txtDescrip').markItUp(mySettings);

}//

function AdminArticleDescripCancel()
{

    $('#pDialog').remove();
}


function AdminArticleDescripOk()
{


    // Die Beschreibung in die AdminArticleTabelle schreiben
    actInputObject.attr('value',$('#txtDescrip').val());

    $('#pDialog').remove();

}

/*
 Öffnet/schließt den jeweilgen Content einer Customer News
 bei click auf 'open' .
 */
function CustomerNewsOpenContent(id)
{

   // alert('openApp.js_'+ id);
    // open/close content der news
    $('#' + id + '_C').toggle('slow',function () {

        if( $('#' + id).text() == 'OPEN')
        {
            $('#' + id).text('CLOSE');
        }
        else
        {
            $('#' + id).text('OPEN');

        }
    });

}

/**
 * Zeigt die aktuell über ID ausgewählter News im Edit Bereich
 * der AdminNewsPage an
 * @param id
 * @constructor
 */
function AdminNewsShowDetails(id)
{

    $('#newsAdminHead').val($('#' + id + '_head').text());
    $('#newsAdminContent').val($('#' + id + '_content').text());
    $('#datepickerNews').val($('#' + id + '_date').text());



}
