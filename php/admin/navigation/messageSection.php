<div class="row">
    <div class="col-lg-12">
        <?php
        $successMessages = consumeSuccessMessages();
        $errorMessages = consumeErrorMessages();
        $infoMessages = consumeInfoMessages();

        if(isNotEmpty($successMessages)) {
            /* @var $msg string */
            foreach($successMessages as $key => $msg) {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $msg ?>
                </div>
                <?php
            }
        }

        if(isNotEmpty($errorMessages)) {
            /* @var $msg string */
            foreach($errorMessages as $key => $msg) {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $msg ?>
                </div>
                <?php
            }
        }

        if(isNotEmpty($infoMessages)) {
            /* @var $msg string */
            foreach($infoMessages as $key => $msg) {
                ?>
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $msg ?>
                </div>
            <?php }
        } ?>
    </div>
</div>