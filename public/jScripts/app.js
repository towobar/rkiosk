/**
 * Created by tombar on 31.03.2016.
 */


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

