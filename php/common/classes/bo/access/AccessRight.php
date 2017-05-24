<?php

/**
 * Signifies access rights of users and groups of the application
 */
class AccessRight {
    private $ID;
    private $name;

    /**
     * @var AccessRightMeta[]
     */
    private $accessMeta;


    /**
     * AccessRight constructor.
     */
    public function __construct() {
        $this->setAccessMeta(AccessRightMeta::create());
    }


    /**
     * @return AccessRight
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    /**
     * @param $ID
     * @param $name
     * @return $this
     */
    public static function createAccessRight($ID, $name) {
        return self::create()->setID($ID)->setName($name);
    }

    /**
     * @param mixed $accessMeta
     * @return AccessRight
     */
    public function setAccessMeta($accessMeta) {
        $this->accessMeta = $accessMeta;
        return $this;
    }

    /**
     * @param mixed $name
     * @return AccessRight
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $ID
     * @return AccessRight
     */
    public function setID($ID) {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getID() {
        return $this->ID;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return AccessRightMeta[]
     */
    public function getAccessMeta() {
        return $this->accessMeta;
    }

}