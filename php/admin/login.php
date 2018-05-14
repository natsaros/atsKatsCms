<?php
$error = '';

if(isNotEmpty($_POST['submit'])) {
    if(isEmpty($_POST[UserHandler::USERNAME]) || isEmpty($_POST[UserHandler::PASSWORD])) {
        $error = "Invalid user";
    }

    if(is_null($error) || $error === '') {
        $username = $_POST[UserHandler::USERNAME];
        $password = $_POST[UserHandler::PASSWORD];
        $user = UserHandler::adminLogin($username, $password);
        if($user === null || $user === false) {
            $error = "Invalid user";
        } else {
            setUserToSession($user);
            if (forceUserChangePassword()){
                Redirect(getAdminRequestUri() . "changePassword");
            } else {
                Redirect(getAdminRequestUri());
            }
        }
    }
} ?>
<?php require("adminHeader.php"); ?>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-page-logo" style=""></div>
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Sign In</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="<?php echo getAdminRequestUri() . 'login' ?>" method="post">
                        <fieldset>
                            <div class="form-group">
                                <label>Username</label>
                                <input class="form-control" placeholder="Username" name="<?php echo UserHandler::USERNAME ?>" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" placeholder="Password" name="<?php echo UserHandler::PASSWORD ?>" type="password" value="">
                            </div>
                            <input type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="Login" placeholder="Login">
                            <div class="form-group remind-password-link-container">
                                <a href="<?php echo getAdminRequestUri() . "remindPassword";?>"> Forgot Password </a>
                            </div>
                            <div class="form-group login-message-container">
                                <?php echo $error ?>
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