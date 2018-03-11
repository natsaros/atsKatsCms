<?php
try {
    $headers = "MIME-Version: 1.1\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: info@sellinofos.gr\r\n";
	$headers .= "Reply-To: info@sellinofos.gr\r\n";
	$headers .= "Return-Path: info@sellinofos.gr\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "Date: " . date(DEFAULT_DATE_FORMAT);
    $file_contents = file_get_contents("./assets/emailTemplates/sellinofos_newsletter.htm");
    $file_contents = str_replace("%EMAIL_BODY%", "Οι προσφορές ξεκίνησαν στο Σelliνόφως!<br/>Προλάβετε!", $file_contents);
    $email = Email::createFull('info@sellinofos.gr', 'nkatsiaounis@gmail.com', 'TEST', $file_contents, $headers);
    EmailHandler::sendEmail($email);
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR_GR);
}

Redirect(getAdminRequestUri() . "newsletterEmails");
