<?php
FormHandler::unsetSessionForm('sendEmailForm');
?>
    <div class="container-fluid belowHeader text-center">
        <div class="row row-no-padding">
            <div class="col-sm-12">
                <div class="heroHeader onlineHero">
                    <div class="headerTitle">
                        <p>Γυμνάσου απο το σπίτι τωρα!</p>
                        <div class="titlesBorder"></div>
                    </div>
                    <div class="heroSubTitle">Μιλήστε μας για τους στόχους σας...</div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <iframe src="https://renkont.com?sessionId=<?php session_id()?>"
                width="100%" height="1200"
                style="margin-top: 20px"
                allowfullscreen="allowfullscreen"
                frameBorder="0"
                scrolling="no"></iframe>
    </div>