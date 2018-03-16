<?php

class NewsletterCampaign
{
    private $ID;
    private $title;
    private $message;
    private $sending_date;
    private $link;
    private $button_text;
    private $user_id;

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     * @return NewsletterCampaign
     */
    public function setID($ID)
    {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return NewsletterCampaign
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return NewsletterCampaign
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSendingDate()
    {
        return $this->sending_date;
    }

    /**
     * @param mixed $sending_date
     * @return NewsletterCampaign
     */
    public function setSendingDate($sending_date)
    {
        $this->sending_date = $sending_date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     * @return NewsletterCampaign
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getButtonText()
    {
        return $this->button_text;
    }

    /**
     * @param mixed $button_text
     * @return NewsletterCampaign
     */
    public function setButtonText($button_text)
    {
        $this->button_text = $button_text;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     * @return NewsletterCampaign
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return $this
     */
    public static function create()
    {
        $instance = new self();
        return $instance;
    }

    public static function createNewsletterCampaign($ID, $title, $message, $link, $button_text, $sending_date)
    {
        return self::create()
            ->setID($ID)
            ->setTitle($title)
            ->setMessage($message)
            ->setLink($link)
            ->setButtonText($button_text)
            ->setSendingDate(date(ADMIN_DATE_FORMAT, strtotime($sending_date)));
    }
}