<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'mail' . DS . 'Email.php');

class EmailHandler {

    static function sendFitnessHouse($name, $email, $interested, $goal) {
        $systemEmailAdrs = SettingsHandler::getSettingValueByKey(Setting::EMAILS);
        $basicAdr = explode(';', $systemEmailAdrs)[0];

        $email_subject = "Fitness House Contact from: " . $name;

        $email_body = "\n";
        $email_body .= "Name:" . $name . "\n";
        $email_body .= "Email:" . $email . "\n\n";
        if (!empty($goal)) {
            $email_body .= "\tGoals: \n \t " . $goal . "\n\n";
        }
        $email_body .= "\tInterested in : \n \t" . $interested . "\n";

        $headers = "MIME-Version: 1.1";
        $headers .= "Content-type: text/plain; charset=utf-8";
        $headers .= "From:" . $basicAdr . "\n";
        $headers .= "Reply-To:" . $email . "\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        $email = Email::createFull($basicAdr, $basicAdr, $email_subject, $email_body, $headers);
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
        mail($email->getTo(), '=?utf-8?B?' . base64_encode($email->getSubject()) . '?=', wordwrap($email->getBody(), 70), $email->getBody());
    }

}