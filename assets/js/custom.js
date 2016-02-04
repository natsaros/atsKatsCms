$(document).ready(function () {
    var includes = $('.include');
    $.each(includes, function () {
        var file = $(this).data('include') + '.html';
        $(this).load(file);
    });

    // Add smooth scrolling to all links in navbar + footer link
    $(document).on('click', 'footer a.toTop', function (event) {
        // Prevent default anchor click behavior
        event.preventDefault();

        // Store hash
        var hash = this.hash;

        // Using jQuery's animate() method to add smooth page scroll
        // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
        $('html, body').animate({
            scrollTop: $(hash).offset().top
        }, 900, function () {

            // Add hash (#) to URL when done scrolling (default click behavior)
            //window.location.hash = hash;
        });
    });
    if ($('body').attr('id') == 'contact') {
        mapInit();
    }

});

$(window).load(function () {

    $('footer .toTop').attr('href', '#' + $('body').attr('id'));
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

$(window).scroll(function () {
    $(".slideanim").each(function () {
        var pos = $(this).offset().top;
        var winTop = $(window).scrollTop();
        if (pos < winTop + 1000) {
            $(this).addClass("slide");
        }
    });
});