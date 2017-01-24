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
});

$(document).on('change', 'input[type=checkbox]', function () {
    if ($(this).is(':checked')) {
        $(this).val('true');
    } else {
        $(this).val('false');
    }
});