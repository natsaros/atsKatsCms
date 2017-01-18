<?php require("pageHeader.php"); ?>

<?php $currentUser = UserFetcher::getUserById($_GET["id"]); ?>

<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                User Info
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form">
                            <div class="form-group">
                                <label class="control-label" for="username_input">User Name</label>
                                <input class="form-control" placeholder="User Name" id="username_input"
                                       value="<?php echo $currentUser->getUserName() ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="firstname_input">First Name</label>
                                <input class="form-control" placeholder="First Name" id="firstname_input"
                                       value="<?php echo $currentUser->getFirstName() ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="lastname_input">Last Name</label>
                                <input class="form-control" placeholder="Last Name" id="lastname_input"
                                       value="<?php echo $currentUser->getLastName() ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="mail_input">E-mail</label>
                                <input class="form-control" type="email" placeholder="E-mail" id="mail_input"
                                       value="<?php echo $currentUser->getEmail() ?>">
                            </div>
                            <div class="text-right form-group">
                                <button type="button" class="btn btn-default">Back</button>
                                <button type="button" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
