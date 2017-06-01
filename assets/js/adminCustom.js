function initializeCheckBoxes() {
    $('input[type=checkbox]:not(.ak_modal input[type=checkbox]):not(input[type=checkbox][data-toggle])').each(function () {
        if ($(this).is(':checked')) {
            $(this).val('true');
        } else {
            $(this).val('false');
        }
    });
}

function initBootstrapToggle() {
    var $input = $('input[type="checkbox"]');
    $input.bootstrapToggle();
}

$(document).ready(function () {
    var dTables = $('.ak-dataTable').DataTable({responsive: true});

    initializeCheckBoxes();
    initBootstrapToggle();

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
        var input = $(this).parents('.form-group').find('.hiddenLabel'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });

    var akModals = $(".ak_modal");
    akModals.on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget);
        var modal = $(this);
        if (!modal.data('modal-href')) {
            modal.data('modal-href', link.attr("href"));
        }
        if (modal.data('refresh')) {
            modal.removeData('refresh');
        }
        modal.find(".modal-content").load(modal.data('modal-href'), function (response, status, xhr) {
            if (status === "error") {
                var msg = "Sorry but there was an error: ";
                console.log(msg + xhr.status + " " + xhr.statusText);
            } else {
                // add initializations after load ajax
                initializeCheckBoxes();
                initBootstrapToggle();
            }
        });
    });

    akModals.on('hidden.bs.modal', function (e) {
        var modal = $(this);
        if (modal.data('refresh')) {
            var target = $(e.target);
            target.removeData('bs.modal')
                .find(".modal-content").html('');
            $(this).modal('show');
        }
    });


    $(document).on('submit', '.ak_modal form', function (e) {
        e.preventDefault();
        var modal = $(this).closest('.ak_modal');
        var data = $(this).serializeArray();
        data.push({name: 'isAjax', value: true});
        $.ajax({
            url: $(this).attr('action'),
            data: data,
            method: 'POST'
        }).success(function (data) {
            // Do stuff after success
        }).fail(function (xhr, textStatus, error) {
            var msg = "Sorry but there was an error: ";
            console.log(msg + xhr.status + " " + xhr.statusText + " " + error);
        }).complete(function (data) {
            modal.data('refresh', true);
            modal.modal('toggle');
        });
    });

    $(document).on('change', 'input[type=checkbox][data-toggle="toggle"]', function () {
        var checkbox = $(this);
        if (this.checked) {
            if (checkbox.data('custom-on-val')) {
                this.value = checkbox.data('custom-on-val');
            }
        } else {
            if (checkbox.data('custom-off-val')) {
                this.value = checkbox.data('custom-off-val');
            }
        }
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
    var $img = $(fileInput).closest('form').find('img[data-preview]');
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
