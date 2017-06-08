<?php

class Setting {

    const BLOG_ENABLED = 'blog.enabled';
    const DEFAULT_LANG = 'default.language';

    private $ID;
    private $key;
    private $value;

    /**
     * Setting constructor.
     */
    public function __construct() {

    }

    /**
     * @return Setting
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    /**
     * @param $ID
     * @param $key
     * @param $name
     * @return Setting
     */
    public static function createFull($ID, $key, $name) {
        return self::create()->setID($ID)->setKey($key)->setValue($name);
    }

    /**
     * @param mixed $ID
     * @return Setting
     */
    public function setID($ID) {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @param mixed $key
     * @return Setting
     */
    public function setKey($key) {
        $this->key = $key;
        return $this;
    }

    /**
     * @param mixed $value
     * @return Setting
     */
    public function setValue($value) {
        $this->value = $value;
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
    public function getKey() {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

}