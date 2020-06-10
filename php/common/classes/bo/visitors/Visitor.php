<?php

class Visitor {
    private $ID;
    private $FB_ID;
    private $first_name;
    private $last_name;
    private $email;
    private $image_path;
    private $user_status;
    private $insertion_date;
    private $last_login_date;

    /**
     * Visitor constructor.
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
     * @return Visitor
     */
    public function setID($ID)
    {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFBID()
    {
        return $this->FB_ID;
    }

    /**
     * @param mixed $FB_ID
     * @return Visitor
     */
    public function setFBID($FB_ID)
    {
        $this->FB_ID = $FB_ID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     * @return Visitor
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     * @return Visitor
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
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
     * @return Visitor
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImagePath()
    {
        return $this->image_path;
    }

    /**
     * @param mixed $image_path
     * @return Visitor
     */
    public function setImagePath($image_path)
    {
        $this->image_path = $image_path;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserStatus()
    {
        return $this->user_status;
    }

    /**
     * @param mixed $user_status
     * @return Visitor
     */
    public function setUserStatus($user_status)
    {
        $this->user_status = $user_status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInsertionDate()
    {
        return $this->insertion_date;
    }

    /**
     * @param mixed $insertion_date
     * @return Visitor
     */
    public function setInsertionDate($insertion_date)
    {
        $this->insertion_date = $insertion_date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastLoginDate()
    {
        return $this->last_login_date;
    }

    /**
     * @param mixed $last_login_date
     * @return Visitor
     */
    public function setLastLoginDate($last_login_date)
    {
        $this->last_login_date = $last_login_date;
        return $this;
    }

    /**
     * @return $this
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    public static function createVisitor($ID, $FBID, $first_name, $last_name, $email, $imagePath, $user_status, $insertion_date, $last_login_date) {
        return self::create()
            ->setID($ID)
            ->setFBID($FBID)
            ->setFirstName($first_name)
            ->setLastName($last_name)
            ->setEmail($email)
            ->setImagePath($imagePath)
            ->setUserStatus($user_status)
            ->setInsertionDate($insertion_date)
            ->setLastLoginDate($last_login_date);
    }
}

?>