<?php
$error = '';
$email = $_POST['email'];
if(isNotEmpty($_POST['submit'])) {
    if(isEmpty($email) || !isValidMail($email)) {
        $result = "Email is invalid";
    }

    if(is_null($result) || $result === '') {
        $passwordReset = UserHandler::resetPassword($email);
        if($passwordReset !== 1) {
            $result = ErrorMessages::GENERIC_ERROR;
        } else {
            $result = "Your password has been reset and sent to email address you typed. Click <a href=\"" . getAdminRequestUri() . 'login' . "\">here</a> to log in.";
        }
    }
} ?>
<?php require("adminHeader.php"); ?>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Reset Password</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="<?php echo getAdminRequestUri() . 'remindPassword' ?>" method="post">
                        <fieldset>
                            <div class="form-group">
                                Type your email address to receive the new password
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Email" name="email" type="email" autofocus>
                            </div>
                            <input type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="Reset" placeholder="Reset">
                            <div class="form-group" style="margin-top: 15px;margin-bottom: 5px;">
                                <?php echo $result ?>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require("adminJS.php"); ?>
</body>