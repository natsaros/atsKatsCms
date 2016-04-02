$(document).ready(function () {

    var body = $('body');
    $('footer .toTop').attr('href', '#' + body.attr('id'));

    // Add smooth scrolling to all links in navbar + footer link
    $(document).on('click', 'footer a.toTop', function (event) {
        // Prevent default anchor click behavior
        event.preventDefault();

        // Store hash
        var hash = this.hash;
        var navHeight = $('.navbar').height();


        // Using jQuery's animate() method to add smooth page scroll
        // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
        $('html, body').animate({
            scrollTop: ($(hash).offset().top - navHeight)
        }, 600, function () {

            // Add hash (#) to URL when done scrolling (default click behavior)
            //window.location.hash = hash;
        });
    });
    if (body.attr('id') == 'contact') {
        mapInit();
    }

});

function initialize(myCenter) {
    var mapProp = {
        center: myCenter,
        zoom: 16,
        scrollwheel: false,
        draggable: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

    var marker = new google.maps.Marker({
        position: myCenter,
    });

    marker.setMap(map);
}

function mapInit() {
    var myCenter = new google.maps.LatLng(37.884851, 23.746829);
    google.maps.event.addDomListener(window, 'load', initialize(myCenter));
}

function postContact(submit) {
    $submit = $(submit);
    $form = $submit.closest('form');
    $('<input>').attr({
        type: 'hidden',
        name: 'submit',
        value: 'true'
    }).appendTo($form);

    $form.submit();
}
$(window).scroll(function () {
    $(".slideanim").each(function () {
        var pos = $(this).offset().top;
        var winTop = $(window).scrollTop();
        if (pos < winTop + 1000) {
            $(this).addClass("slide");
        }
    });
});