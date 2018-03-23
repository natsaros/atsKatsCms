<?php
$token = $_GET['token'];

if (isNotEmpty($token)){
    NewsletterHandler::unsubscribeFromNewsletter($token);
}

Redirect(getRootUri() . "unsubscription");