<?php

if(!isLoggedIn()) {
    Redirect(getAdminRequestUri() . "login");
} else {
    $path = ADMIN_MODAL_NAV_PATH . ADMIN_PAGE_ID . PHP_POSTFIX;
    @require_safe($path);
}