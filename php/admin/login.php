<?php
$error = '';

if(isNotEmpty($_POST['submit'])) {
    if(isEmpty($_POST['username']) || isEmpty($_POST['password'])) {
        $error = "Username or Password is invalid";
    }

    if(is_null($error) || $error === '') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = UserHandler::adminLogin($username, $password);
        if($user === null || $user === false) {
            $error = "Not valid user";
        } else {
            setUserToSession($user);
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
                    <h3 class="panel-title">Sign In</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="<?php echo getAdminRequestUri() . 'login' ?>" method="post">
                        <fieldset>
                            <div class="form-group">
                                <label>Username</label>
                                <input class="form-control" placeholder="Username" name="username" type="text"
                                       autofocus>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" placeholder="Password" name="password" type="password"
                                       value="">
                            </div>
                            <div class="form-group">
                                <a href="<?php echo getAdminRequestUri() . "remindPassword";?>" style="color:#333;text-decoration: none;"> Forgot Password </a>
                            </div>
                            <input type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="Login"
                                   placeholder="Login">
                            <div class="form-group" style="margin-top: 15px;margin-bottom: 5px;">
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