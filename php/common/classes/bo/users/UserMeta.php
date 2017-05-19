<?php

/**
 * Holds meta data of user
 */
class UserMeta {

    private $ID;
    private $user_id;
    private $meta_key;
    private $meta_value;

    /**
     * UserMeta constructor.
     */
    public function __construct() {

    }

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
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     * @return $this
     */
    public function setUserId($user_id) {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetaKey() {
        return $this->meta_key;
    }

    /**
     * @param mixed $meta_key
     * @return $this
     */
    public function setMetaKey($meta_key) {
        $this->meta_key = $meta_key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetaValue() {
        return $this->meta_value;
    }

    /**
     * @param mixed $meta_value
     * @return $this
     */
    public function setMetaValue($meta_value) {
        $this->meta_value = $meta_value;
        return $this;
    }

}