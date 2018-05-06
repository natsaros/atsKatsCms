<?php
$title = $_POST[NewsletterHandler::TITLE];
$message = $_POST[NewsletterHandler::MESSAGE];
$link = $_POST[NewsletterHandler::LINK];
$button_text = $_POST[NewsletterHandler::BUTTON_TEXT];
$loggedInUser = getFullUserFromSession();

$systemEmailAdrs = SettingsHandler::getSettingValueByKey(Setting::EMAILS);
$basicAdr = explode(';', $systemEmailAdrs)[0];

if (isEmpty($title) || isEmpty($message)){
    addErrorMessage("Please fill in required info");
}

if (isNotEmpty($link) && isEmpty($button_text)){
    addErrorMessage("Please fill in Button Text field");
} else if (isNotEmpty($button_text) && isEmpty($link)){
    addErrorMessage("Please fill in Link field");
}

if(hasErrors()) {
    FormHandler::setSessionForm('sendNewsletterForm');
    Redirect(getAdminRequestUri() . PageSections::NEWSLETTER . DS . "newsletter" . addParamsToUrl(array('activeTab'), array('newsletterEmailForm')));
}

try {

    $headers = "MIME-Version: 1.1\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: $basicAdr\r\n";
    $headers .= "Reply-To: $basicAdr\r\n";
    $headers .= "Return-Path: $basicAdr\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "Date: " . date(DEFAULT_DATE_FORMAT);

    if (isNotEmpty($link)){
        $file_contents = file_get_contents("./assets/emailTemplates/client/sellinofos_newsletter_message_with_link.htm");
        $file_contents = str_replace("%EMAIL_LINK%", $link, $file_contents);
        $file_contents = str_replace("%EMAIL_BUTTON%", $button_text, $file_contents);
    } else {
        $file_contents = file_get_contents("./assets/emailTemplates/client/sellinofos_newsletter_message.htm");
    }

    $file_contents = str_replace("%EMAIL_BODY%", $message, $file_contents);

    $newsletterEmails = NewsletterHandler::getAllNewsletterEmails();

    foreach ($newsletterEmails as $key => $newsletterEmail) {
        $file_contents = str_replace("%UNSUBSCRIPTION_TOKEN%", $newsletterEmail->getUnsubscriptionToken(), $file_contents);
        $email = Email::createFull($basicAdr, $newsletterEmail->getEmail(), $title, $file_contents, $headers);
        EmailHandler::sendEmail($email);
    }

    $newsLetterCampaign = NewsletterCampaign::create();

    $newsLetterCampaign->
    setTitle($title)->
    setMessage($file_contents)->
    setButtonText($button_text)->
    setLink($link)->
    setUserId($loggedInUser->getID());

    NewsletterHandler::insertNewsletterCampaign($newsLetterCampaign);
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR_GR);
}

Redirect(getAdminRequestUri() . PageSections::NEWSLETTER . DS . "newsletter" . addParamsToUrl(array('activeTab'), array('newsletterCampaigns')));
//    https://drive.google.com/uc?export=view&id=1tOGEB8k_4faK3s8Oocb7WHRa0y_LZpOn
