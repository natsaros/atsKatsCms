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
        <div class="iframe-container">
            <iframe src="https://renkont.com?sessionId=<?php session_id()?>"
                    allowfullscreen="allowfullscreen"
                    frameBorder="0"></iframe>
        </div>
    </div>