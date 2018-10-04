<?php
$emailToSubscribe = $_POST["emailToSubscribe"];

$emailInDB = NewsletterHandler::getNewsletterEmail($emailToSubscribe);

if (is_null($emailInDB)){
    NewsletterHandler::insertNewsletterEmail($emailToSubscribe);
}
