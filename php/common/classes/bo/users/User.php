<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'access' . DS . 'AccessRight.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'users' . DS . 'UserStatus.php');

class User {
    private $ID;
    private $name;
    private $password;
    private $first_name;
    private $last_name;
    private $email;
    private $activation_date;
    private $modification_date;
    private $user_status;
    private $gender;
    private $link;
    private $phone;
    private $picture;
    private $picturePath;
    private $force_change_password;

    /**
     * @var UserMeta[]
     */
    private $userMeta;

    /**
     * @var AccessRight[]
     */
    private $accessRights;

    /**
     * @var Group[]
     */
    private $groups;

    /**
     * User constructor.
     */
    public function __construct() {
        //default constructor
        $this->setUserStatus(UserStatus::ACTIVE);
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
     * @param $activation_date
     * @param $modification_date
     * @param $user_status
     * @param $gender
     * @param $link
     * @param $phone
     * @param $picture
     * @param $picturePath
     * @param $force_change_password
     * @return User
     * @internal param bool $is_admin
     */
    public static function createFullUser($ID, $name, $password, $first_name, $last_name, $email, $activation_date,
                                          $modification_date, $user_status, $gender, $link, $phone, $picture, $picturePath, $force_change_password) {
        return self::create()
            ->setID($ID)
            ->setUserName($name)
            ->setPassword($password)
            ->setFirstName($first_name)
            ->setLastName($last_name)
            ->setEmail($email)
            ->setActivationDate($activation_date)
            ->setModificationDate($modification_date)
            ->setUserStatus($user_status)
            ->setGender($gender)
            ->setLink($link)
            ->setPhone($phone)
            ->setPicture($picture)
            ->setPicturePath($picturePath)
            ->setForceChangePassword($force_change_password);
    }


//    GETTERS

    /**
     * @return mixed
     */
    public
    function getID() {
        return $this->ID;
    }

    /**
     * @return mixed
     */
    public
    function getPassword() {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public
    function getUserName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public
    function getFirstName() {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public
    function getLastName() {
        return $this->last_name;
    }

    /**
     * @return mixed
     */
    public
    function getActivationDate() {
        return $this->activation_date;
    }

    /**
     * @return mixed
     */
    public
    function getEmail() {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public
    function getGender() {
        return $this->gender;
    }

    /**
     * @return mixed
     */
    public
    function getLink() {
        return $this->link;
    }

    /**
     * @return mixed
     */
    public
    function getModificationDate() {
        return $this->modification_date;
    }

    /**
     * @return mixed
     */
    public
    function getPhone() {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public
    function getPicture() {
        return $this->picture;
    }

    /**
     * @return boolean
     */
    public
    function getUserStatus() {
        return $this->user_status === 1;
    }

    /**
     * @return UserMeta[]
     */
    public
    function getUserMeta() {
        return $this->userMeta;
    }

    /**
     * @return AccessRight[]
     */
    public
    function getAccessRights() {
        return $this->accessRights;
    }

    /**
     * @return string[]
     */
    public
    function getAccessRightsStr() {
        $accessRightsStr = array();
        if(isNotEmpty($this->getAccessRights())) {
            //add dashboard by default
            $accessRightsStr[] = AccessRight::DASHBOARD_SECTION;
            /** @var AccessRight $right */
            foreach($this->getAccessRights() as $right) {
                if(!in_array($right, $accessRightsStr)) {
                    $accessRightsStr[] = $right->getName();
                }
            }
        }
        return $accessRightsStr;
    }

    /**
     * @return mixed
     */
    public
    function getPicturePath() {
        return $this->picturePath;
    }

    /**
     * @return Group[]
     */
    public function getGroups() {
        return $this->groups;
    }

    /**
     * @return mixed
     */
    public function getForceChangePassword() {
        return $this->force_change_password;
    }

//    SETTERS

    /**
     * @param mixed $ID
     * @return User
     */
    public
    function setID($ID) {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @param mixed $password
     * @return $this
     */
    public
    function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public
    function setUserName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $first_name
     * @return $this
     */
    public
    function setFirstName($first_name) {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @param mixed $last_name
     * @return $this
     */
    public
    function setLastName($last_name) {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @param mixed $activation_date
     * @return $this
     */
    public
    function setActivationDate($activation_date) {
        $this->activation_date = $activation_date;
        return $this;
    }

    /**
     * @param mixed $email
     * @return $this
     */
    public
    function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @param mixed $gender
     * @return $this
     */
    public
    function setGender($gender) {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @param mixed $link
     * @return $this
     */
    public
    function setLink($link) {
        $this->link = $link;
        return $this;
    }

    /**
     * @param mixed $modification_date
     * @return $this
     */
    public
    function setModificationDate($modification_date) {
        $this->modification_date = $modification_date;
        return $this;
    }

    /**
     * @param mixed $phone
     * @return $this
     */
    public
    function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param mixed $picture
     * @return $this
     */
    public
    function setPicture($picture) {
        $this->picture = $picture;
        return $this;
    }

    /**
     * @param boolean $user_status
     * @return $this
     */
    public
    function setUserStatus($user_status) {
        $this->user_status = $user_status ? UserStatus::ACTIVE : UserStatus::INACTIVE;
        return $this;
    }

    /**
     * @param mixed $userMeta
     * @return $this
     */
    public
    function setUserMeta($userMeta) {
        $this->userMeta = $userMeta;
        return $this;
    }

    /**
     * @param AccessRight[] $accessRights
     * @return User
     */
    public
    function setAccessRights($accessRights) {
        $this->accessRights = $accessRights;
        return $this;
    }

    /**
     * @param mixed $picturePath
     * @return User
     */
    public
    function setPicturePath($picturePath) {
        $this->picturePath = $picturePath;
        return $this;
    }

    /**
     * @param Group[] $groups
     * @return User
     */
    public function setGroups($groups) {
        $this->groups = $groups;
        return $this;
    }

    /**
     * @param mixed $force_change_password
     * @return User
     */
    public function setForceChangePassword($force_change_password) {
        $this->force_change_password = $force_change_password;
        return $this;
    }
}