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

    $('nav').mouseenter(function () {
            var $class = $(this).attr('class');
            if ($class.indexOf('scrolling') > -1
                && $class.indexOf('opacity70') > -1) {
                $(this).removeClass('opacity70');
            }
        })
        .mouseleave(function () {
            var $class = $(this).attr('class');
            if ($class.indexOf('scrolling') > -1
                && $class.indexOf('opacity70') <= 0) {
                $(this).addClass('opacity70');
            }
        });

    $('.partner').on('click', function(){
        if ($(this).hasClass('partnerImageFade')){
            $(this).removeClass('partnerImageFade');
            $('.partnerCV .collapse').removeClass('in');
        }
        if ($('.partnerCV .collapse.in').length > 0){
            $('.partner.partnerImageFade').removeClass('partnerImageFade');
        } else {
            $('.partner').not(this).addClass('partnerImageFade');
        }
    });

    $('.blogPostsViewType').on('click', function(){
        if (!$(this).hasClass('active')){
            $('.blogPostsViewType').removeClass('active');
            $('div[id^="postsViewType"]').hide();
            $('#' + $(this).data('viewtype')).fadeIn();
            $(this).addClass('active');
        }
    });

    var isMobileVersion  = function() {
        return $(window).width() <= 768;
    }

    $('li.sub-category-menu-trigger').on('mouseenter', function () {
        if (!isMobileVersion()) {
            $('.sub-category-menu').fadeIn(150);
        }
    });

});

function initialize(myCenter) {
    var mapProp = {
        center: myCenter,
        zoom: 16,
        scrollwheel: false,
        draggable: !("ontouchend" in document),
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
    $('.navbar-brand').each(function () {
        var winTop = $(window).scrollTop();
        var belowHeaderTop = $('.belowHeader').offset().top;
        var nav = $(this).closest('nav');
        var isHover = $(this).closest('nav:hover').length != 0;

        if (winTop > belowHeaderTop + 10 && !isHover) {
            nav.addClass("opacity70");
            nav.addClass("scrolling");
        } else {
            nav.removeClass("opacity70");
            nav.removeClass("scrolling");
        }
    });

    $(".slideanim").each(function () {
        var pos = $(this).offset().top;
        var winTop = $(window).scrollTop();
        if (pos < winTop + 1000) {
            $(this).addClass("slide");
        }
    });

});