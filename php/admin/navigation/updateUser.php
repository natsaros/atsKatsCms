<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<?php

$userId = $_GET["id"];
$isCreate = isEmpty($userId);
//TODO server side validation
/*include('validateUser.php');*/ ?>


<?php
if($isCreate) {
    $currentUser = User::create();
} else {
    $currentUser = UserHandler::getUserById($userId);
}

?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                User Info
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $action = $isCreate ? getAdminActionRequestUri() . "user" . DS . "create" : getAdminActionRequestUri() . "user" . DS . "update";
                        $requiredClass = $isCreate ? 'required' : '';
                        ?>
                        <!--<form name="updateUserForm" role="form" action="<? /*= htmlspecialchars(getRequestUriNoDelim()); */ ?>" data-toggle="validator"> method="post">-->
                        <form name="updateUserForm" role="form" action="<?php echo $action; ?>" data-toggle="validator"
                              method="post">
                            <input type="hidden" name="<?php echo UserHandler::ID ?>"
                                   value="<?php echo $currentUser->getID() ?>">
                            <input type="hidden" name="<?php echo UserHandler::GENDER ?>"
                                   value="<?php echo $currentUser->getGender() ?>">
                            <input type="hidden" name="<?php echo UserHandler::USER_STATUS ?>"
                                   value="<?php echo $currentUser->getUserStatus() ?>">
                            <input type="hidden" name="<?php echo UserHandler::LINK ?>"
                                   value="<?php echo $currentUser->getLink() ?>">
                            <input type="hidden" name="<?php echo UserHandler::PICTURE ?>"
                                   value="<?php echo $currentUser->getPicture() ?>">

                            <div class="form-group text-center">
                                <div class="imgCont">
                                    <img class="img-thumbnail img-responsive"
                                         src="<?php echo renderImage($currentUser->getPicture()) ?>"
                                         alt="<?php echo $currentUser->getUserName() ?>">

                                    <!--TODO : add here custom 'file' input -->
                                    <button type="button" class="btn btn-outline btn-primary">Edit Picture</button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="username_input">User Name</label>
                                <input class="form-control" placeholder="User Name"
                                       name="<?php echo UserHandler::USERNAME ?>" id="username_input"
                                       value="<?php echo $currentUser->getUserName() ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password_input">Password</label>
                                <input class="form-control" type="password" placeholder="Password"
                                       name="<?php echo UserHandler::PASSWORD ?>"
                                       id="password_input" <?php echo $requiredClass ?>>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="firstname_input">First Name</label>
                                <input class="form-control" placeholder="First Name"
                                       name="<?php echo UserHandler::FIRST_NAME ?>"
                                       id="firstname_input"
                                       value="<?php echo $currentUser->getFirstName() ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="lastname_input">Last Name</label>
                                <input class="form-control" placeholder="Last Name"
                                       name="<?php echo UserHandler::LAST_NAME ?>" id="lastname_input"
                                       value="<?php echo $currentUser->getLastName() ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="mail_input">E-mail</label>
                                <input class="form-control" type="email" placeholder="E-mail"
                                       name="<?php echo UserHandler::EMAIL ?>"
                                       id="mail_input"
                                       value="<?php echo $currentUser->getEmail() ?>" required>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="mail_input">Phone</label>
                                <input class="form-control" type="tel" placeholder="Phone"
                                       name="<?php echo UserHandler::PHONE ?>" id="phone_input"
                                       value="<?php echo $currentUser->getPhone() ?>">
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <?php $isChecked = $currentUser->isAdmin() ? 'checked' : ''; ?>
                                        <input name="<?php echo UserHandler::IS_ADMIN ?>"
                                               type="checkbox" <?php echo $isChecked ?>>
                                        Is admin
                                    </label>
                                </div>
                            </div>

                            <div class="text-right form-group">
                                <a type="button" href="<?php echo getAdminRequestUri() . 'users' ?>"
                                   class="btn btn-default">Back</a>
                                <input type="submit" name="submit" class="btn btn-primary" value="Save"
                                       placeholder="Save"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
