<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'newsletter' . DS . 'NewsletterEmail.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'newsletter' . DS . 'NewsletterCampaign.php');

class NewsletterHandler {

    const ID = 'ID';
    const EMAIL = 'EMAIL';
    const DATE = 'DATE';
    const UNSUBSCRIPTION_TOKEN = 'UNSUBSCRIPTION_TOKEN';
    const CURRENT_TAB = 'CURRENT_TAB';
    const TITLE = 'TITLE';
    const MESSAGE = 'MESSAGE';
    const LINK = 'LINK';
    const BUTTON_TEXT = 'BUTTON_TEXT';
    const SENDING_DATE = 'SENDING_DATE';
    const USER_ID = 'USER_ID';

    /**
     * @return int
     * @throws SystemException
     */
    static function getLatestNewsletterSubscriptions() {
        $query = "SELECT COUNT(*) AS NUM_OF_EMAILS FROM " . getDb()->newsletter_emails . " WHERE DATE > DATE_ADD(CURDATE(), INTERVAL -3 DAY)";
        $row = getDb()->selectStmtSingleNoParams($query);
        return $row['NUM_OF_EMAILS'];
    }

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
     * @return NewsletterCampaign[]
     * @throws SystemException
     */
    static function getAllNewsletterCampaigns() {
        $query = "SELECT * FROM " . getDb()->newsletter_campaigns;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateNewsletterCampaigns($rows);
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
     * @param $campaignId
     * @return NewsletterCampaign
     * @throws SystemException
     */
    static function getNewsletterCampaign($campaignId) {
        $query = "SELECT * FROM " . getDb()->newsletter_campaigns . " WHERE " . self::ID . " = ?";
        $row = getDb()->selectStmtSingle($query, array('i'), array($campaignId));
        return self::populateNewsletterCampaign($row);
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
     * @param NewsletterCampaign $newsletterCampaign
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function insertNewsletterCampaign($newsletterCampaign) {
        if (isNotEmpty($newsletterCampaign)) {
            $query = "INSERT INTO " . getDb()->newsletter_campaigns .
                " (". self::MESSAGE .
                "," . self::TITLE .
                "," . self::BUTTON_TEXT .
                "," . self::LINK .
                "," . self::USER_ID .
                "," . self::SENDING_DATE .
                ") VALUES (?, ?, ?, ?, ?, ?)";

            return getDb()->createStmt($query,
                array('s', 's', 's', 's', 's', 's'),
                array($newsletterCampaign->getMessage(),
                    $newsletterCampaign->getTitle(),
                    $newsletterCampaign->getButtonText(),
                    $newsletterCampaign->getLink(),
                    $newsletterCampaign->getUserId(),
                    date(DEFAULT_DATE_FORMAT)
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
     * @param $row
     * @return null|NewsletterCampaign
     * @throws SystemException
     */
    private static function populateNewsletterCampaign($row) {
        if($row === false || null === $row) {
            return null;
        }
        $newsletterCampaign = NewsletterCampaign::createNewsletterCampaign($row[self::ID], $row[self::TITLE], $row[self::MESSAGE], $row[self::LINK], $row[self::BUTTON_TEXT], $row[self::SENDING_DATE]);
        return $newsletterCampaign;
    }

    /**
     * @param $rows
     * @return NewsletterEmail[]|bool
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

    /**
     * @param $rows
     * @return NewsletterCampaign[]|bool
     * @throws SystemException
     */
    private static function populateNewsletterCampaigns($rows) {
        if($rows === false) {
            return false;
        }

        $newsletterCampaigns = [];

        foreach($rows as $row) {
            $newsletterCampaigns[] = self::populateNewsletterCampaign($row);
        }

        return $newsletterCampaigns;
    }
}