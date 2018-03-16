<?php
$title = $_POST[NewsletterHandler::TITLE];
$message = $_POST[NewsletterHandler::MESSAGE];
$link = $_POST[NewsletterHandler::LINK];
$button_text = $_POST[NewsletterHandler::BUTTON_TEXT];
$loggedInUser = getFullUserFromSession();

try {

    $headers = "MIME-Version: 1.1\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: info@sellinofos.gr\r\n";
	$headers .= "Reply-To: info@sellinofos.gr\r\n";
	$headers .= "Return-Path: info@sellinofos.gr\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "Date: " . date(DEFAULT_DATE_FORMAT);

//    https://drive.google.com/uc?export=view&id=1tOGEB8k_4faK3s8Oocb7WHRa0y_LZpOn


    if (isNotEmpty($link)){
        $file_contents = file_get_contents("./assets/emailTemplates/sellinofos_newsletter_message_with_link.htm");
        $file_contents = str_replace("%EMAIL_LINK%", $link, $file_contents);
        $file_contents = str_replace("%EMAIL_BUTTON%", $button_text, $file_contents);
    } else {
        $file_contents = file_get_contents("./assets/emailTemplates/sellinofos_newsletter_message.htm");
    }

    $file_contents = str_replace("%EMAIL_BODY%", $message, $file_contents);

    $email = Email::createFull('info@sellinofos.gr', 'n__katsia@hotmail.com', $title, $file_contents, $headers);

//    EmailHandler::sendEmail($email);

    $newsLetterCampaign = NewsletterCampaign::create();
    $newsLetterCampaign->setTitle($title)->setMessage($file_contents)->setButtonText($button_text)->setLink($link)->setUserId($loggedInUser->getID());
    NewsletterHandler::insertNewsletterCampaign($newsLetterCampaign);

} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR_GR);
}

Redirect(getAdminRequestUri() . "newsletter" . addParamsToUrl(array('activeTab'), array('newsletterCampaigns')));
