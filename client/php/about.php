<div class="container-fluid belowHeader text-center">
    <div class="row row-no-padding">
        <div class="col-sm-12">
            <div class="heroHeader aboutHero">
                <div class="headerTitle">
                    <p>&nbsp;</p>
                    <div class="titlesBorder invisible"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row row-no-padding">
        <div class="col-sm-6 text-center">
            <div class="aboutIntroduceMyselfImageContainer">
                <img src="<?php echo CLIENT_ASSETS_URI ?>img/recent/ALM_8594.jpg" alt="Peny Kasfiki" class="img-responsive">
            </div>
        </div><!--
    -->
        <div class="col-sm-6 text-center">
            <div class="aboutIntroduceMyselfInfo">
                <div>
                    <div class="headerTitle">
                        <p>Πένυ Κασφίκη</p>
                        <div class="titlesBorder"></div>
                    </div>
                    <p>
                        Απόφοιτος ΤΕΦΑΑ Αθηνών με ειδικότητα "Άσκηση,ευρωστία και υγεία"<br/><br/>
                        Πτυχιακή εργασία στην καρδιοαναπνευστική αποκατάσταση καρδιοπαθών και εξειδίκευση στην
                        αποκατάσταση μυοσκελετικών δυσλειτουργιών και χρόνιων παθήσεων<br/><br/>
                        Απόφοιτος ιδιωτικής σχολής εκπαιδευτών <strong>Pilates</strong> με επίσημη διεθνή πιστοποίηση
                        στη διδασκαλία όλων των επιπέδων <strong>Pilates Mat</strong> και <strong>Pilates
                            Equipment</strong>
                        και ειδική κατάρτιση στη διδασκαλία σε άτομα με χρόνιες παθήσεις, μυοσκελετικούς τραυματισμούς
                        και εγκύους
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid gallery-container">
    <div class="row row-no-padding">
        <div class="col-sm-12 text-center">
            <div id="container">
                <div class="item-sizer"></div>
            </div>
            <div id="images">
                <div class="item">
                    <img src="<?php echo CLIENT_ASSETS_URI ?>img/recent/ALM_8477.jpg">
                </div>
                <div class="item">
                    <img src="<?php echo CLIENT_ASSETS_URI ?>img/recent/ALM_8520.jpg">
                </div>
                <div class="item">
                    <img src="<?php echo CLIENT_ASSETS_URI ?>img/recent/magazine.jpeg">
                </div>
                <div class="item">
                    <img src="<?php echo CLIENT_ASSETS_URI ?>img/recent/salon.jpeg">
                </div>
                <div class="item">
                    <img src="<?php echo CLIENT_ASSETS_URI ?>img/recent/towels.jpeg">
                </div>
                <div class="item">
                    <img src="<?php echo CLIENT_ASSETS_URI ?>img/recent/welcomeDoor.jpeg">
                </div>
                <div class="item">
                    <img src="<?php echo CLIENT_ASSETS_URI ?>img/recent/pen_cad1.jpeg">
                </div>
                <div class="item">
                    <img src="<?php echo CLIENT_ASSETS_URI ?>img/recent/pen_cad2.jpeg">
                </div>
                <div class="item">
                    <img src="<?php echo CLIENT_ASSETS_URI ?>img/recent/pen_cad3.jpeg">
                </div>
                <div class="item">
                    <img src="<?php echo CLIENT_ASSETS_URI ?>img/recent/pen_cad4.jpeg">
                </div>
                <div class="item">
                    <img src="<?php echo CLIENT_ASSETS_URI ?>img/recent/pen_ref.jpeg">
                </div>
            </div>
        </div>
    </div>
</div>

<!--<script src="//masonry.desandro.com/masonry.pkgd.min.js"></script>-->
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.0.4/jquery.imagesloaded.js"></script>-->
<script type="text/javascript">
    $(function () {
        var $containerElem = $('#container');
        var $container = $containerElem.masonry({
            itemSelector: '.item',
            columnWidth: '.item-sizer',
            percentPosition: true
        });

        // reveal initial images
        $container.masonryImagesReveal($('#images').find('.item'));

        $(window).resize(function () {
            $containerElem.masonry('bindResize')
        });
    });

    $.fn.masonryImagesReveal = function ($items) {
        var msnry = this.data('masonry');
        var itemSelector = msnry.options.itemSelector;
        // hide by default
        $items.hide();
        // append to container
        this.append($items);
        $items.imagesLoaded().progress(function (imgLoad, image) {
            // get item
            // image is imagesLoaded class, not <img>, <img> is image.img
            var $item = $(image.img).parents(itemSelector);
            // un-hide item
            $item.show();
            // masonry does its thing
            msnry.appended($item);
        });

        return this;
    };
</script>