<?php
$systemEmailAdrs = SettingsHandler::getSettingValueByKey(Setting::EMAILS);
$basicAdr = explode(';', $systemEmailAdrs)[0];
FormHandler::unsetSessionForm('sendEmailForm');
?>
    <div class="container-fluid belowHeader text-center">
        <div class="row row-no-padding">
            <div class="col-sm-12">
                <div class="heroHeader contactHero">
                    <div class="headerTitle">
                        <p>ΒΑΛΤΕ ΤΗ ΓΥΜΝΑΣΤΙΚΗ ΣΤΗ ΖΩΗ ΣΑΣ!</p>
                        <div class="titlesBorder"></div>
                    </div>
                    <div class="heroSubTitle">Μιλήστε μας για τους στόχους σας...</div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php $action = getClientActionRequestUri() . "sendEmail"; ?>
        <form name="sendEmailForm" method="post" accept-charset="utf-8" action="<?php echo $action; ?>" data-toggle="validator">
            <div class="formContainer">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="headerTitle">
                            <p>Επικοινωνήστε μαζί μας</p>
                            <div class="titlesBorder"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group">
                        <input class="form-control" id="name" name="name" placeholder="Ονοματεπώνυμο *" type="text"
                               required
                               value="<?php echo FormHandler::getFormData('name'); ?>"
                        >
                    </div>
                    <div class="col-sm-4 form-group">
                        <input class="form-control" id="email" name="email" placeholder="Email *" type="email" required
                               value="<?php echo FormHandler::getFormData('email'); ?>"
                        >
                    </div>
                    <div class="col-sm-4 form-group">
                        <input class="form-control" id="phone" name="phone" placeholder="Τηλέφωνο" type="text"
                               value="<?php echo FormHandler::getFormData('phone'); ?>"
                        >
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 form-group">
                <textarea class="form-control" id="comments" name="goal"
                          placeholder="Τί θέλετε να επιτύχετε; Ποιος είναι ο στόχος;"
                          rows="5"><?php echo FormHandler::getFormData('goal'); ?></textarea>
                    </div>
                    <div class="col-sm-4 form-group">
                <textarea class="form-control" id="interest" name="interested"
                          placeholder="Για ποιές υπηρεσίες μας ενδιαφέρεστε; *"
                          rows="5"><?php echo FormHandler::getFormData('interested'); ?></textarea>
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

    <div class="container-fluid text-center">
        <div class="row row-no-padding brown_background">
            <div class="col-sm-6">
                <div class="generalTextContainer">
                    <div class="textHolder">
                        <div class="textHolderInside">
                            <div class="headerTitle">
                                <p>Βρείτε το studio μας</p>
                                <div class="titlesBorder"></div>
                            </div>

                            <div class="contactInfo">
                                <p>
                                    Ξεκινήστε να γυμνάζεστε σωστά, με άτομα πιστοποιημένα στο είδος τους! Αγαπάτε το
                                    σώμα
                                    σας
                                    και μάθετε γιατί πρέπει να γυμνάζεστε!<br><br>

                                    Χαριλάου Τρικούπη 17, 16675 Γλυφάδα, Ελλάδα<br>
                                    Τηλ: 6976582735<br>
                                    Email: <?php echo $basicAdr ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div id="googleMap" class="mapContainer"></div>
            </div>
        </div>
    </div>