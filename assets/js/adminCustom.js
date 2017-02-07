$(document).ready(function () {
    $('.ak-dataTable').DataTable({
        responsive: true
    });

    $('input[type=checkbox]').each(function () {
        if ($(this).is(':checked')) {
            $(this).val('true');
        } else {
            $(this).val('false');
        }
    });


    $('.imgCont').hover(handlerImageIn, handlerImageOut);
});

function handlerImageIn() {
    var height = $(this).height();
    var btn = $(this).find('.btn');
    btn.css('visibility', 'visible').css('top', '-' + height / 3 + 'px');
}

function handlerImageOut() {
    var btn = $(this).find('.btn');
    btn.css('visibility', 'hidden').css('top', '0');
}

$(document).on('change', 'input[type=checkbox]', function () {
    if ($(this).is(':checked')) {
        $(this).val('true');
    } else {
        $(this).val('false');
    }
});