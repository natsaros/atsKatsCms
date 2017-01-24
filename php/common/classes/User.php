<?php

class User {
    private $ID;
    private $name;
    private $password;
    private $first_name;
    private $last_name;
    private $email;
    private $activation_Date;
    private $modification_date;
    private $user_status;
    private $is_admin;
    private $gender;
    private $link;
    private $phone;
    private $picture;

    /**
     * User constructor.
     */
    public function __construct() {
        //default constructor
        $this->setUserStatus(true);
        $this->setIsAdmin(false);
    }

    /**
     * @return User
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    /**
     * @param $ID
     * @param $name
     * @param $password
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param $activation_Date
     * @param $modification_date
     * @param $user_status
     * @param $is_admin boolean
     * @param $gender
     * @param $link
     * @param $phone
     * @param $picture
     * @return User
     */
    public static function createFullUser($ID, $name, $password, $first_name, $last_name, $email, $activation_Date,
                                          $modification_date, $user_status, $is_admin, $gender, $link, $phone, $picture) {
        return self::create()
            ->setID($ID)
            ->setUserName($name)
            ->setPassword($password)
            ->setFirstName($first_name)
            ->setLastName($last_name)
            ->setEmail($email)
            ->setActivationDate($activation_Date)
            ->setModificationDate($modification_date)
            ->setUserStatus($user_status)
            ->setIsAdmin($is_admin)
            ->setGender($gender)
            ->setLink($link)
            ->setPhone($phone)
            ->setPicture($picture);
    }


//    GETTERS-SETTERS

    /**
     * @return mixed
     */
    public function getID() {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     * @return $this
     */
    public function setID($ID) {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return $this
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setUserName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName() {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     * @return $this
     */
    public function setFirstName($first_name) {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName() {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     * @return $this
     */
    public function setLastName($last_name) {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActivationDate() {
        return $this->activation_Date;
    }

    /**
     * @param mixed $activation_Date
     * @return $this
     */
    public function setActivationDate($activation_Date) {
        $this->activation_Date = $activation_Date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return $this
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     * @return $this
     */
    public function setGender($gender) {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * @param mixed $link
     * @return $this
     */
    public function setLink($link) {
        $this->link = $link;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModificationDate() {
        return $this->modification_date;
    }

    /**
     * @param mixed $modification_date
     * @return $this
     */
    public function setModificationDate($modification_date) {
        $this->modification_date = $modification_date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return $this
     */
    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPicture() {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     * @return $this
     */
    public function setPicture($picture) {
        $this->picture = $picture;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getUserStatus() {
        return $this->user_status == 1;
    }

    /**
     * @param boolean $user_status
     * @return $this
     */
    public function setUserStatus($user_status) {
        $this->user_status = $user_status ? 1 : 0;
        return $this;
    }

    /**
     * @return int
     */
    public function getIsAdmin() {
        return $this->is_admin;
    }

    /**
     * @return boolean
     */
    public function isAdmin() {
        return $this->getIsAdmin() == 1;
    }

    /**
     * @param boolean $is_admin
     * @return $this
     */
    public function setIsAdmin($is_admin) {
        $this->is_admin = $is_admin ? 1 : 0;
        return $this;
    }

}

?>