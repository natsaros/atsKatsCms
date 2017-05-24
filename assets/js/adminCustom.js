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

    if (typeof tinymce !== 'undefined' && tinymce !== null) {
        tinymce.init({
            selector: '.editor',
            height: 350,
            menubar: false,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
            // add this to the end of previous line if you want image uploading in the html editor : image
            // image_advtab: true,
            content_css: ['//fonts.googleapis.com/css?family=Lato:300,300i,400,400i', '//www.tinymce.com/css/codepen.min.css']
        });
    }

    $(':file').on('fileselect', function (event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });

    $(".ak_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("href"));
    });
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

function previewImage(fileInput) {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(fileInput.files[0]);
    var $img = $(fileInput).closest('.form-group').next().find('img');
    oFReader.onload = function (oFREvent) {
        $img[0].src = oFREvent.target.result;
    };
}

$(document).on('change', 'input[type=checkbox]', function () {
    if ($(this).is(':checked')) {
        $(this).val('true');
    } else {
        $(this).val('false');
    }
});

$(document).on('change', ':file', function () {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
    previewImage(this);
});
