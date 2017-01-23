<?php
$user2Update = new User($_POST['ID'], $_POST['username'], null, $_POST['firstName'], $_POST['lastName'], $_POST['email'], null, null, $_POST['userStatus'], $_POST['isAdmin'], $_POST['gender'], $_POST['link'], $_POST['phone'], $_POST['picture']);
UserFetcher::updateUser($user2Update);
Redirect(getAdminRequestUriNoDelim());