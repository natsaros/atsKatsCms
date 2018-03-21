<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'mail' . DS . 'Email.php');

class EmailHandler {

    /**
     * @param $name
     * @param $email
     * @param $text
     * @param $phone
     * @throws SystemException
     */
    static function sendEmailToSellinofos($name, $email, $text, $phone) {
        $systemEmailAdrs = SettingsHandler::getSettingValueByKey(Setting::EMAILS);
        $basicAdr = explode(';', $systemEmailAdrs)[0];

        $email_subject = "Sellinofos Contact from: " . $name;
        $email_body = "Name:\n" . $name . "\n\n";
        $email_body .= "Email:\n" . $email . "\n\n";
        $email_body .= "Phone:\n" . $phone . "\n\n";
        $email_body .= "Text:\n" . $text . "\n\n";
        $headers = "MIME-Version: 1.1\r\n";
        $headers .= "Content-type: text/plain; charset=utf-8\r\n";
        $headers .= "From:" . $basicAdr . "\r\n";
        $headers .= "Reply-To:" . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Date: " . date(DEFAULT_DATE_FORMAT);

        $email = Email::createFull($basicAdr, $basicAdr, $email_subject, $email_body, $headers);
        self::sendEmail($email);
    }

    /**
     * @param $email
     * @param $password
     * @throws SystemException
     */
    static function sendResetPasswordToAdmin($email, $password) {
        $email_subject = "Sellinofos - Password Reset";
        $email_body = "Your password has been reset.\n\n";
        $email_body .= "You should use the following password in order to sign in to Sellinofos Admin console:\n\n";
        $email_body .= "<b>" . $password . "</b>\n\n";
        $headers = "MIME-Version: 1.1\r\n";
        $headers .= "Content-type: text/plain; charset=utf-8\r\n";
        $headers .= "From:admin@sellinofos.gr\r\n";
        $headers .= "Reply-To:noreply@sellinofos.gr\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Date: " . date(DEFAULT_DATE_FORMAT);

        $email = Email::createFull("admin@sellinofos.gr", $email, $email_subject, $email_body, $headers);
        self::sendEmail($email);
    }

    /**
     * @param $from
     * @param $to
     * @param $subject
     * @param $body
     * @param $headers
     */
    static function send($from, $to, $subject, $body, $headers) {
        $email = Email::createFull($from, $to, $subject, $body, $headers);
        self::sendEmail($email);
    }

    /**
     * @param Email $email
     */
    static function sendEmail($email) {
        mail($email->getTo(), '=?utf-8?B?' . base64_encode($email->getSubject()) . '?=', wordwrap($email->getBody(), 70), $email->getHeaders());
    }

}