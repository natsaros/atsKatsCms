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

    if(typeof tinymce !== 'undefined' && tinymce !== null){
        tinymce.init({
            selector: '.editor',
            height: 500,
            menubar: false,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            // image_advtab: true,
            content_css: ['//fonts.googleapis.com/css?family=Lato:300,300i,400,400i','//www.tinymce.com/css/codepen.min.css']
        });
    }
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