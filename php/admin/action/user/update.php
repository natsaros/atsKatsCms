<?php
$user2Update = new User($_POST[UserFetcher::ID], $_POST[UserFetcher::USERNAME], null, $_POST[UserFetcher::FIRST_NAME], $_POST[UserFetcher::LAST_NAME], $_POST[UserFetcher::EMAIL], null, null, $_POST[UserFetcher::USER_STATUS], $_POST[UserFetcher::IS_ADMIN], $_POST[UserFetcher::GENDER], $_POST[UserFetcher::LINK], $_POST[UserFetcher::PHONE], $_POST[UserFetcher::PICTURE]);
UserFetcher::updateUser($user2Update);
Redirect(sprintf(getAdminRequestUri() . "updateUser?id=%s", $user2Update->getID()));