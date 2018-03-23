<?php
$error = '';
$successResult = '';
$email = $_POST[UserHandler::EMAIL];
if(isNotEmpty($_POST['submit'])) {
    if(isEmpty($email) || !isValidMail($email)) {
        $error = "Invalid email address";
    }

    if(is_null($error) || $error === '') {
        $passwordReset = UserHandler::resetPassword($email);
        if($passwordReset !== 1) {
            $error = "Invalid email address";
        } else {
            $successResult = "Your password has been reset and sent to email address you typed. Click <a href=\"" . getAdminRequestUri() . 'login' . "\">here</a> to log in.";
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
                            <div class="form-group" style="text-align: center;">
                                Type your email address to receive the new password
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" placeholder="Email" name="<?php echo UserHandler::EMAIL ?>" type="email" autofocus>
                            </div>
                            <input type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="Reset">
                            <div class="form-group back-to-login-link-container">
                                <a href="<?php echo getAdminRequestUri() . "login";?>">Back to Sign In Page</a>
                            </div>
                            <div class="form-group remind-password-message-container"<?php if(!is_null($error) && $error !== '') { ?> style="color: #ff0000;"<?php } ?>>
                                <?php if(is_null($error) || $error === '') { echo $successResult; } else { echo $error; } ?>
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