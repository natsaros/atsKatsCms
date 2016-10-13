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
    private $gender;
    private $link;
    private $phone;
    private $picture;

    /**
     * User constructor.
     * @param $ID
     * @param $name
     * @param $password
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param $activation_Date
     * @param $modification_date
     * @param $user_status
     * @param $gender
     * @param $link
     * @param $phone
     * @param $picture
     */
    public function __construct($ID, $name, $password, $first_name, $last_name, $email, $activation_Date, $modification_date, $user_status, $gender, $link, $phone, $picture) {
        $this->ID = $ID;
        $this->name = $name;
        $this->password = $password;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->activation_Date = $activation_Date;
        $this->modification_date = $modification_date;
        $this->user_status = $user_status;
        $this->gender = $gender;
        $this->link = $link;
        $this->phone = $phone;
        $this->picture = $picture;
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
     */
    public function setID($ID) {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getActivationDate() {
        return $this->activation_Date;
    }

    /**
     * @param mixed $activation_Date
     */
    public function setActivationDate($activation_Date) {
        $this->activation_Date = $activation_Date;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstName() {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender) {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getLastName() {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link) {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getModificationDate() {
        return $this->modification_date;
    }

    /**
     * @param mixed $modification_date
     */
    public function setModificationDate($modification_date) {
        $this->modification_date = $modification_date;
    }

    /**
     * @return mixed
     */
    public function getUserName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setUserName($name) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone) {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPicture() {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture) {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getUserStatus() {
        return $this->user_status;
    }

    /**
     * @param mixed $user_status
     */
    public function setUserStatus($user_status) {
        $this->user_status = $user_status;
    }

}

?>