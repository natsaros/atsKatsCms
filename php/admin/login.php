<?php
require_once(CLASSES_ROOT_PATH . 'Globals.php');
require_once(CLASSES_ROOT_PATH . 'UserFetcher.php');

if(isNotEmpty($_POST['submit'])) {
    $error = '';
    if(isEmpty($_POST['username']) || isEmpty($_POST['password'])) {
        $error = "Username or Password is invalid";
    }

    if(is_null($error) || $error === '') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = UserFetcher::adminLogin($username, $password);
        if($user === false) {
            $error = "Not valid user";
        } else {
            setUserToSession($user->getUserName());
            Redirect(getAdminRequestUri());
        }
    }
} ?>

<!DOCTYPE html>
<html lang="en">

<?php require("adminHeader.php"); ?>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="<?php echo getAdminRequestUri() . 'login' ?>" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="text"
                                       autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password"
                                       value="">
                            </div>
                            <div class="checkbox">
                                <label> <input name="remember" type="checkbox" value="Remember Me">Remember Me </label>
                            </div>
                            <input type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="Login"
                                   placeholder="Login">
                            <div class="form-group">
                                <span><?php echo $error ?></span>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require("adminJs.php"); ?>
</body>
</html>
