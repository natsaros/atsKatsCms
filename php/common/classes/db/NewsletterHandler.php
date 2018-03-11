<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'newsletterEmails' . DS . 'NewsletterEmail.php');

class NewsletterHandler {

    const ID = 'ID';
    const EMAIL = 'EMAIL';
    const DATE = 'DATE';
    const UNSUBSCRIPTION_TOKEN = 'UNSUBSCRIPTION_TOKEN';
    const CURRENT_TAB = 'CURRENT_TAB';
    const MESSAGE = 'MESSAGE';
    const LINK = 'LINK';
    const BUTTON_TEXT = 'BUTTON_TEXT';

    /**
     * @return NewsletterEmail[]
     * @throws SystemException
     */
    static function getAllNewsletterEmails() {
        $query = "SELECT * FROM " . getDb()->newsletter_emails;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateNewsletterEmails($rows);
    }

    /**
     * @param $email
     * @return NewsletterEmail
     * @throws SystemException
     */
    static function getNewsletterEmail($email) {
        $query = "SELECT * FROM " . getDb()->newsletter_emails . " WHERE " . self::EMAIL . " = ?";
        $row = getDb()->selectStmtSingle($query, array('s'), array($email));
        return $row;
    }

    /**
     * @param $token
     * @throws SystemException
     */
    static function unsubscribeFromNewsletter($token) {
        $query = "DELETE FROM " . getDb()->newsletter_emails . " WHERE " . self::UNSUBSCRIPTION_TOKEN . " = ?";
        getDb()->selectStmtSingle($query, array('s'), array(mysqli_real_escape_string($token)));
    }

    /**
     * @param $email
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function insertNewsletterEmail($email) {
        if (isNotEmpty($email)) {
            $newsletterEmail = NewsletterEmail::create();
            $newsletterEmail->setEmail($email)->setUnsubscriptionToken(bin2hex(openssl_random_pseudo_bytes(16)));
            $query = "INSERT INTO " . getDb()->newsletter_emails .
                " (". self::DATE .
                "," . self::EMAIL .
                "," . self::UNSUBSCRIPTION_TOKEN .
                ") VALUES (?, ?, ?)";

            return getDb()->createStmt($query,
                array('s', 's', 's'),
                array(date(DEFAULT_DATE_FORMAT),
                    $newsletterEmail->getEmail(),
                    $newsletterEmail->getUnsubscriptionToken(),
                ));
        }
        return null;
    }

    /**
     * @param $row
     * @return null|NewsletterEmail
     * @throws SystemException
     */
    private static function populateNewsletterEmail($row) {
        if($row === false || null === $row) {
            return null;
        }
        $newsletterEmail = NewsletterEmail::createNewsletterEmail($row[self::ID], $row[self::EMAIL], $row[self::DATE]);
        return $newsletterEmail;
    }

    /**
     * @param $rows
     * @return NewsletterEmail[]
     * @throws SystemException
     */
    private static function populateNewsletterEmails($rows) {
        if($rows === false) {
            return false;
        }

        $newsletterEmails = [];

        foreach($rows as $row) {
            $newsletterEmails[] = self::populateNewsletterEmail($row);
        }

        return $newsletterEmails;
    }
}