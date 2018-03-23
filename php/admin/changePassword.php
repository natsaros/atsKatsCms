<?php
$loggedInUser = getFullUserFromSession();
$error = '';

$id = $_POST[UserHandler::ID];
$password = $_POST[UserHandler::PASSWORD];
$passwordConfirmation = $_POST[UserHandler::PASSWORD_CONFIRMATION];
if(isNotEmpty($_POST['submit'])) {
    if(isEmpty($password) || isEmpty($passwordConfirmation) || $password !== $passwordConfirmation) {
        $error = "Invalid Password";
    }

    if(is_null($error) || $error === '') {
        $passwordChanged = UserHandler::changePassword($id, $password);
        $loggedInUser->setForceChangePassword(0);
        setUserToSession($loggedInUser);
        if($passwordChanged !== 1) {
            $error = ErrorMessages::GENERIC_ERROR;
        } else {
            Redirect(getAdminRequestUri());
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
                    <h3 class="panel-title">Change Password</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="<?php echo getAdminRequestUri() . 'changePassword' ?>" method="post">
                        <input type="hidden" name="<?php echo UserHandler::ID ?>"  value="<?php echo $loggedInUser->getID() ?>"/>
                        <fieldset>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" placeholder="Password" name="<?php echo UserHandler::PASSWORD ?>" type="password">
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input class="form-control" placeholder="Confirm Password" name="<?php echo UserHandler::PASSWORD_CONFIRMATION ?>" type="password">
                            </div>
                            <input type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="Change">
                            <div class="form-group" style="margin-top: 15px;margin-bottom: 5px;text-align: center;color: #ff0000;">
                                <?php echo $error; ?>
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