<footer class="container-fluid text-center">
    <a href="<?php echo $pageId ?>" title="To Top" class="toTop"></a>
    <div class="row">
        <div class="col-sm-12 newsletter-text">
            <?php echo getLocalizedText("newsletter_info_text");?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 newsletter-email-input-container">
            <input type="text" name="email" value="" id="newsletterEmail" class="newsletter-email-input" placeholder="<?php echo getLocalizedText("newsletter_email_placeholder");?>">
            <div class="newsletter-btn">
                <?php echo getLocalizedText("newsletter_button_text");?>
            </div>
            <div class="newsletter-subscription-result"></div>
        </div>
    </div>

    <div class="row footer-columns-row">
        <div class="col-sm-4 footer-column">
            <div class="footer-column-link footer-column-header desktop"><a href="<?php echo REQUEST_URI ?>home" class="footer-column-header">Sellinofos</a></div>
            <div class="footer-column-link"><a href="<?php echo REQUEST_URI ?>home"><?php if($_SESSION['locale'] == 'el_GR') { ?>Αρχική<?php } else { ?>Home<?php } ?></a></div>
            <div class="footer-column-link"><a href="<?php echo REQUEST_URI ?>collections">Collections</a></div>
            <div class="footer-column-link"><a href="<?php echo REQUEST_URI ?>sales"><?php if($_SESSION['locale'] == 'el_GR') { ?>Εκπτώσεις<?php } else { ?>Sales<?php } ?></a></div>
            <div class="footer-column-link"><a href="<?php echo REQUEST_URI ?>contact"><?php if($_SESSION['locale'] == 'el_GR') { ?>Επικοινωνία<?php } else { ?>Contact<?php } ?></a></div>
        </div>
        <div class="col-sm-4 desktop footer-column">
            <?php
            $productCategories = ProductCategoryHandler::fetchAllActiveParentProductCategories();
            if (!is_null($productCategories) && count($productCategories) > 0){
            ?>
            <div class="footer-column-link footer-column-header"><a href="<?php echo REQUEST_URI ?>collections" class="footer-column-header">Collections</a></div>
            <?php
                foreach($productCategories as $key => $pc) {
                    ?>
                    <div class="footer-column-link"><a href="<?php echo getProductCategoriesUri() . $pc->getFriendlyTitle();?>"><?php echo $pc->getTitle();?></a></div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="col-sm-4 footer-column">
            <div class="footer-column-social-media footer-column-header desktop">
                <a href="javascript:void(0);"><?php echo getLocalizedText("social_media_header");?></a>
            </div>
            <div class="footer-column-social-media-message desktop">
                <?php echo getLocalizedText("social_media_info_text");?>
            </div>
            <div class="footer-column-social-media-links">
                <a href="https://www.facebook.com/Sellinofos/" target="_blank" title="Sellinofos @ Facebook"><i class="fa fa-facebook"></i></a>
                <a href="https://www.instagram.com/sellinofos/" target="_blank" title="Sellinofos @ Instagram"><i class="fa fa-instagram"></i></a>
            </div>
        </div>
    </div>
    <div class="extraInfo"><?php echo getLocalizedText("copyright_sign");?><?php echo date("Y"); ?><?php echo getLocalizedText("copyright_text");?></div>
    <?php if ($cookies_consent == "false") { ?>
    <div class="row row-no-margin cookies-message">
        <div class="col-xs-9 cookies-message-text-container">
            <div class="cookies-message-text">
                <?php echo getLocalizedText("cookies_consent_text");?>
            </div>
        </div>
        <div class="col-xs-3 cookies-message-button-container">
            <span id="cookieConsent" class="cookies-message-button">
                <?php echo getLocalizedText("cookies_consent_button");?>
            </span>
        </div>
    </div>
    <?php } ?>
</footer>
