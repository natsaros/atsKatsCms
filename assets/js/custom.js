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

    $('.sub-category-menu').mouseleave(function (e) {
        if (!isMobileVersion()){
            var target = e.toElement;
            if (!$(target).parents().is('li.sub-category-menu-trigger')) {
                $('ul.sub-category-menu').fadeOut(150);
                $('div[class*="sub-menu-"]').hide();
            }
        }
    });

    $('li.sub-category-menu-trigger').mouseleave(function (e) {
        if (!isMobileVersion()) {
            var target = e.toElement;
            if (!$(target).is('ul.sub-category-menu') && !$(target).is('ul.sub-category-menu li')) {
                $('ul.sub-category-menu').fadeOut(150);
                $('div[class*="sub-menu-"]').hide();
            }
        }
    });

    $('li[submenu^="sub-menu-trigger"]').on('mouseenter', function () {
        if (!isMobileVersion()) {
            var subMenuCategory = $(this).attr('submenu').split('sub-menu-trigger')[1];
            $('div[submenuid="sub-menu' + subMenuCategory + '"]').fadeIn(150);
        }
    });

    $('.sub-menu').mouseleave(function (e) {
        if (!isMobileVersion()){
            var subMenuId = $(this).attr('submenuid').split('sub-menu')[1];
            var target = e.toElement;
            if (!$(target).is('li[submenu="sub-menu-trigger' + subMenuId + '"]')) {
                $('div[submenuid="sub-menu' + subMenuId +'"]').fadeOut(150);
            }
        }
    });

    $('li[submenu^="sub-menu-trigger"]').mouseleave(function (e) {
        if (!isMobileVersion()) {
            var subMenu = $(this).attr('submenu').split('sub-menu-trigger')[1];
            var target = e.toElement;
            $('div[submenuid="sub-menu' + subMenu +'"]').fadeOut(150);
        }
    });

    $('#languageSelector').on('click', function () {
        var arrow = $('#languageSelector i');
        if (arrow.hasClass('fa-caret-up')){
            arrow.removeClass('fa-caret-up');
            arrow.addClass('fa-caret-down');
        } else {
            arrow.removeClass('fa-caret-down');
            arrow.addClass('fa-caret-up');
        }
        $('#languagesContainer').toggle();
    });

    $('#languagesContainer li').on('click', function () {
        var language = $(this).attr('id');
        $('#currentURL').val(window.location.href);
        $('#language').val(language);
        $('#changeLanguageForm').submit();
    });

    $('.filter-header').on('click', function(){
        var fc = $(this).parents().closest('.filter-container');
        var fb = $(this).next('.filter-body');
        var fv = $(this).find('.filter-selected-values');
        if (fc.hasClass('open-filter')){
            fc.removeClass('open-filter');
            fb.hide();
            fv.show();
        } else {
            $('.filter-container.open-filter').each(function(){
                $(this).removeClass('open-filter');
                $(this).find('.filter-body').hide();
                $(this).find('.filter-selected-values').show();
            });
            fc.addClass('open-filter');
            fb.show();
            fv.hide();
        }
    });

    $('.filter-select').on('change', function(){
        $(this).parents().closest('.filter-container').find('.filter-selected-values').html($(this).find(":selected").text());
        $('#selectedCategory').val($(this).val());
        $('#searchProducts').submit();
    });

    $(document).on('click', '#cookieConsent', function(){
        $.ajax({
            type: 'POST',
            url: getContextPath() + '/ajaxAction/updateCookie/',
            data: ({cookieName:"SellinofosCookiesConsent", cookieValue:"true"}),
            success: function() {
                $('.cookies-message').slideToggle();
            },
            error: function(data){
            }
        });
    });

    $('.newsletter-btn').on('click', function(){
        var emailToSubscribe = $('#newsletterEmail').val();
        if (!isValidEmail(emailToSubscribe)){
            $('.newsletter-subscription-result').addClass('newsletter-error').html('Μη έγκυρη διεύθυνση email').css({'visibility':'visible'});
            return false;
        }
        $.ajax({
            type: 'POST',
            url: getContextPath() + '/ajaxAction/subscribeToNewsletter/',
            data: ({emailToSubscribe:emailToSubscribe}),
            success: function() {
                $('#newsletterEmail').val('');
                $('.newsletter-subscription-result').addClass('newsletter-success').html('Έχετε εγγραφεί επιτυχώς στο Newsletter μας').css({'visibility':'visible'});
            },
            error: function(){
            }
        });
    });

    $('#newsletterEmail').on('focus', function () {
        $('.newsletter-subscription-result').css('visibility', 'hidden').removeClass('newsletter-success').removeClass('newsletter-error');
    });

    $(document).click(function(e) {
        if (!isMobileVersion()) {
            var target = e.target;
            if (!$(target).parents().is('div.filter-container.open-filter')) {
                $('.filter-container').removeClass('open-filter');
                $('.filter-body').hide();
                $('.filter-selected-values').show();
            }
        }
    });
});

function openFilters() {
    $('#filtersSideNav').css('left', '0');
}

function closeFilters(){
    $('#filtersSideNav').removeAttr('style');
}

function showPromotedProduct(){
    var x = document.getElementById("promotedProduct");
    var productId = document.getElementById("promotedProductId").value;
    x.className = "show";
}

function updatePromotedProductCookie(productId, url) {
    $.ajax({
        type: 'POST',
        url: getContextPath() + '/ajaxAction/updateCookie/',
        data: ({cookieName: "SellinofosPromotedProduct", cookieValue: productId}),
        success: function (data) {
            if (url != null && url != ''){
                window.location.href=url;
            } else {
                var element = document.getElementById("promotedProduct");
                element.className = element.className.replace("show", "");
            }
        },
        error: function (data) {
        }
    });
}

function getContextPath() {
    return window.location.pathname.substring(0, window.location.pathname.indexOf("/",2));
}

function isValidEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
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