<?php
$userId = $_GET["id"];
$isCreate = isEmpty($userId);
$loggedInUser = getFullUserFromSession();


FormHandler::unsetSessionForm('updateUserForm');

$activeTab = $_GET['activeTab'];
$activeTabClass = 'class="active"';

$allGroups = GroupHandler::fetchAllActiveGroups();

if ($isCreate) {
    $currentUser = User::create();
} else {
    $currentUser = UserHandler::getUserById($userId);
    $currentUser->setGroups(GroupHandler::fetchGroupsByUser($userId));
}
$pageTitle = $isCreate ? "Create User" : "Update User";
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $pageTitle; ?>
        </h1>
    </div>
</div>

<?php require(ADMIN_NAV_PATH . "messageSection.php"); ?>

<ul class="nav nav-tabs">
    <li <?php if (isEmpty($activeTab) || $activeTab === 'general') {
        echo $activeTabClass ?><?php } ?>><a href="#general" data-toggle="tab">General</a></li>
    <li <?php if (isNotEmpty($activeTab) && $activeTab === 'groups') {
        echo $activeTabClass ?><?php } ?>><a href="#groups" data-toggle="tab">Groups</a></li>
</ul>
<?php
$action = $isCreate ? getAdminActionRequestUri() . "user" . DS . "create" : getAdminActionRequestUri() . "user" . DS . "update"; ?>
<form name="updateUserForm" role="form" action="<?php echo $action; ?>" data-toggle="validator" method="post"
      enctype="multipart/form-data">
    <div class="tab-content">
        <div class="tab-pane fade <?php if (isEmpty($activeTab) || $activeTab === 'general') { ?> in active<?php } ?>"
             id="general">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php $requiredClass = $isCreate ? 'required' : ''; ?>
                                <input type="hidden" name="updateLoggedInUser" value="false">
                                <input type="hidden" name="<?php echo UserHandler::ID ?>"
                                       value="<?php echo $currentUser->getID() ?>">
                                <input type="hidden" name="<?php echo UserHandler::GENDER ?>"
                                       value="<?php echo $currentUser->getGender() ?>">
                                <input type="hidden" name="<?php echo UserHandler::USER_STATUS ?>"
                                       value="<?php echo $currentUser->getUserStatus() ?>">
                                <input type="hidden" name="<?php echo UserHandler::LINK ?>"
                                       value="<?php echo $currentUser->getLink() ?>">

                                <div class="form-group text-center">
                                    <div class="imgCont">
                                        <?php
                                        if (FormHandler::isTempPictureSaved()) {
                                            $draftPicturePath = FormHandler::getFormPictureDraftPath(UserHandler::PICTURE);
                                            $pictureVal = ImageUtil::renderGalleryImage($draftPicturePath);
                                        } else {
                                            $pictureVal = ImageUtil::renderUserImage($currentUser);
                                        }
                                        ?>
                                        <img data-preview="true" class="img-thumbnail img-responsive"
                                             src="<?php echo $pictureVal; ?>"
                                             alt="<?php echo $currentUser->getUserName() ?>">
                                        <?php
                                        if (!FormHandler::isTempPictureSaved()) { ?>
                                        <span class="btn btn-outline btn-primary btn-file">Edit Picture
                                        <input type="file" id="uploadImage"
                                               name="<?php echo UserHandler::PICTURE; ?>" multiple">
                                        <input type="hidden"
                                               value="<?php echo $currentUser->getPicturePath(); ?>"
                                               name="<?php echo UserHandler::PICTURE_PATH; ?>" class="hiddenLabel">
                                            <?php } else { ?>
                                                <input type="hidden"
                                                       value="<?php echo FormHandler::getTempPictureToken(); ?>"
                                                       name="<?php echo FormHandler::TEMP_IMAGE_SAVED_TOKEN ?>"
                                                       class="hiddenLabel">
                                            <?php } ?>

                                    </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="username_input">User Name *</label>
                                    <input class="form-control" placeholder="User Name"
                                           name="<?php echo UserHandler::USERNAME ?>" id="username_input"
                                           value="<?php echo FormHandler::getEditFormData(UserHandler::USERNAME, $currentUser->getUserName()); ?>"
                                    >
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="firstname_input">First Name</label>
                                    <input class="form-control" placeholder="First Name"
                                           name="<?php echo UserHandler::FIRST_NAME ?>"
                                           id="firstname_input"
                                           value="<?php echo FormHandler::getEditFormData(UserHandler::FIRST_NAME, $currentUser->getFirstName()); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="lastname_input">Last Name</label>
                                    <input class="form-control" placeholder="Last Name"
                                           name="<?php echo UserHandler::LAST_NAME ?>" id="lastname_input"
                                           value="<?php echo FormHandler::getEditFormData(UserHandler::LAST_NAME, $currentUser->getLastName()); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="mail_input">E-mail *</label>
                                    <input class="form-control" type="email" placeholder="E-mail"
                                           name="<?php echo UserHandler::EMAIL ?>"
                                           id="mail_input"
                                           value="<?php echo FormHandler::getEditFormData(UserHandler::EMAIL, $currentUser->getEmail()); ?>"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="phone_input">Phone</label>
                                    <input class="form-control numeric" type="tel" placeholder="Phone"
                                           name="<?php echo UserHandler::PHONE ?>" id="phone_input"
                                           value="<?php echo FormHandler::getEditFormData(UserHandler::PHONE, $currentUser->getPhone()); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade <?php if (isNotEmpty($activeTab) || $activeTab === 'groups') { ?> in active<?php } ?>"
             id="groups">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body text-center">
                        <?php
                        /* @var $group Group */
                        foreach ($allGroups as $key => $group) {
                            ?>
                            <div class="form-group">
                                <label class="control-label"
                                       for="group_input_<?php echo $group->getID(); ?>"><?php echo $group->getDescription(); ?></label>
                                <div class="checkbox">
                                    <label>
                                        <?php $isChecked = isNotEmpty($currentUser->getGroups()) ? in_array($group, $currentUser->getGroups()) ? 'checked' : '' : '' ?>
                                        <input name="<?php echo GroupHandler::GROUP_ID; ?>[]"
                                               type="checkbox" <?php echo $isChecked ?>
                                               value="<?php echo $group->getID(); ?>"
                                               data-toggle="toggle"
                                               id="group_input_<?php echo $group->getID(); ?>"
                                               data-custom-on-val="<?php echo $group->getID(); ?>"
                                               data-custom-off-val="">
                                    </label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="text-right form-group">
            <a type="button" href="<?php echo getAdminRequestUri() . DS . PageSections::USERS . DS . 'users' ?>"
               class="btn btn-default">Back</a>
            <input type="submit" name="submit" class="btn btn-primary" value="Save"
                   placeholder="Save"/>
        </div>
    </div>
</form>
