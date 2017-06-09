<?php
$infoMessages = consumeInfoMessages();
$errorMessages = consumeErrorMessages();

if (isNotEmpty($errorMessages)) {
    /* @var $msg string */
    foreach ($errorMessages as $key => $msg) {
        ?>
        <div class="alert text-center alert-danger alert-dismissable fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $msg ?>
        </div>
        <?php
    }
}

if (isNotEmpty($infoMessages)) {
    /* @var $msg string */
    foreach ($infoMessages as $key => $msg) {
        ?>
        <div class="alert text-center alert-info alert-dismissable fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $msg ?>
        </div>
    <?php }
} ?>

