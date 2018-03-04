<?php
$systemEmailAdrs = SettingsHandler::getSettingValueByKey(Setting::EMAILS);
$basicAdr = explode(';', $systemEmailAdrs)[0];
?>

    <div class="container">
        <?php $action = getClientActionRequestUri() . "sendEmail"; ?>
        <form method="post" accept-charset="utf-8" action="<?php echo $action; ?>" data-toggle="validator">
            <div class="formContainer">
                <div class="row row-no-margin row-no-padding">
                    <div class="col-sm-12 text-center">
                        <div class="headerTitle">
                            <p>Επικοινωνήστε μαζί μας</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group">
                        <input class="form-control" id="name" name="name" placeholder="Ονοματεπώνυμο *" type="text"
                               required
                               value="<?php echo formValueFromSession('name') ?>"
                        >
                    </div>
                    <div class="col-sm-4 form-group">
                        <input class="form-control" id="email" name="email" placeholder="Email *" type="email" required
                               value="<?php echo formValueFromSession('email') ?>">
                    </div>
                    <div class="col-sm-4 form-group">
                        <input class="form-control" id="phone" name="phone" placeholder="Τηλέφωνο" type="text"
                               value="<?php echo formValueFromSession('phone') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group">
                <textarea class="form-control" id="comments" name="goal"
                          placeholder="Τί θέλετε να μάθετε; *"
                          rows="5"><?php echo formValueFromSession('text') ?></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <button class="btn btn-block btn-default" type="submit">Αποστολή</button>
                    </div>
                </div>

                <div class="row">
                    <?php require("messageSection.php"); ?>
                </div>
            </div>
        </form>
    </div>

<?php
consumeFormData();
?>