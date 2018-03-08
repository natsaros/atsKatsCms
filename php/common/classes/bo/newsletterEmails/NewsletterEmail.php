<?php

class NewsletterEmail {
    private $ID;
    private $email;
    private $date;
    private $unsubscription_token;

    /**
     * NewsletterEmail constructor.
     */
    public function __construct() {
        //default constructor
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     * @return NewsletterEmail
     */
    public function setID($ID)
    {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return NewsletterEmail
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return NewsletterEmail
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnsubscriptionToken()
    {
        return $this->unsubscription_token;
    }

    /**
     * @param mixed $unsubscription_token
     * @return NewsletterEmail
     */
    public function setUnsubscriptionToken($unsubscription_token)
    {
        $this->unsubscription_token = $unsubscription_token;
        return $this;
    }

    /**
     * @return $this
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    public static function createNewsletterEmail($ID, $email, $date) {
        return self::create()
            ->setID($ID)
            ->setEmail($email)
            ->setDate(date(ADMIN_DATE_FORMAT, strtotime($date)));
    }
}
