<?php
$loggedInUser = getFullUserFromSession();
$currentUser = $loggedInUser;

$afterFormSubmission = false;

if (isset($_SESSION['updateMyProfileForm']) && !empty($_SESSION['updateMyProfileForm'])) {
    $afterFormSubmission = true;
    $form_data = $_SESSION['updateMyProfileForm'];
    unset($_SESSION['updateMyProfileForm']);
}
?>

<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<form name="updateMyProfileForm" role="form" action="<?php echo getAdminActionRequestUri() . "user" . DS . "update"; ?>" data-toggle="validator" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <input type="hidden" name="updateFromMyProfile" value="true">
                        <input type="hidden" name="<?php echo UserHandler::ID ?>"
                               value="<?php echo $currentUser->getID() ?>">
                        <input type="hidden" name="<?php echo UserHandler::USERNAME ?>"
                               value="<?php echo $currentUser->getUserName() ?>">
                        <input type="hidden" name="<?php echo UserHandler::GENDER ?>"
                               value="<?php echo $currentUser->getGender() ?>">
                        <input type="hidden" name="<?php echo UserHandler::USER_STATUS ?>"
                               value="<?php echo $currentUser->getUserStatus() ?>">
                        <input type="hidden" name="<?php echo UserHandler::LINK ?>"
                               value="<?php echo $currentUser->getLink() ?>">

                        <div class="form-group text-center">
                            <div class="imgCont">
                                <img data-preview="true" class="img-thumbnail img-responsive"
                                     src="<?php echo ImageUtil::renderUserImage($currentUser) ?>"
                                     alt="<?php echo $currentUser->getUserName() ?>">
                                <span class="btn btn-outline btn-primary btn-file">Edit Picture
                                        <input type="file" id="uploadImage" name="<?php echo UserHandler::PICTURE ?>"
                                               multiple">
                                        <input type="hidden" value="<?php echo $currentUser->getPicturePath(); ?>"
                                               name="<?php echo UserHandler::PICTURE_PATH ?>" class="hiddenLabel">
                                    </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="username_input">User Name</label>
                            <input class="form-control" id="username_input" value="<?php echo $currentUser->getUserName() ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password_input">Password *</label>
                            <input class="form-control" type="password" placeholder="Password"
                                   name="<?php echo UserHandler::PASSWORD ?>"
                                   id="password_input" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password_input">Confirm Password *</label>
                            <input class="form-control" type="password" placeholder="Confirm Password"
                                   name="<?php echo UserHandler::PASSWORD_CONFIRMATION ?>"
                                   id="password_input" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="firstname_input">First Name</label>
                            <input class="form-control" placeholder="First Name"
                                   name="<?php echo UserHandler::FIRST_NAME ?>"
                                   id="firstname_input"
                                   value="<?php if($afterFormSubmission) {?><?=$form_data[UserHandler::FIRST_NAME]?><?php } else { echo $currentUser->getFirstName(); } ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="lastname_input">Last Name</label>
                            <input class="form-control" placeholder="Last Name"
                                   name="<?php echo UserHandler::LAST_NAME ?>" id="lastname_input"
                                   value="<?php if($afterFormSubmission) {?><?=$form_data[UserHandler::LAST_NAME]?><?php } else { echo $currentUser->getLastName(); } ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="mail_input">E-mail *</label>
                            <input class="form-control" type="email" placeholder="E-mail"
                                   name="<?php echo UserHandler::EMAIL ?>"
                                   id="mail_input"
                                   value="<?php if($afterFormSubmission) {?><?=$form_data[UserHandler::EMAIL]?><?php } else { echo $currentUser->getEmail(); } ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="phone_input">Phone</label>
                            <input class="form-control numeric" type="tel" placeholder="Phone"
                                   name="<?php echo UserHandler::PHONE ?>" id="phone_input"
                                   value="<?php if($afterFormSubmission) {?><?=$form_data[UserHandler::PHONE]?><?php } else { echo $currentUser->getPhone(); } ?>">
                        </div>

                        <div class="text-right form-group">
                            <a type="button" href="<?php echo getAdminRequestUri() ?>"
                               class="btn btn-default">Back</a>
                            <input type="submit" name="submit" class="btn btn-primary" value="Save"
                                   placeholder="Save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
