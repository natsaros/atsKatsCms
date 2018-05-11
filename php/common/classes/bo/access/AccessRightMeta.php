<?php

/**
 * Holds meta data of access right
 */
class AccessRightMeta
{
    const ALL = 'Access to all features of system';
    const DASHBOARD_SECTION = 'Access to dashboard section';
    const PAGES_SECTION = 'Access to pages section';
    const POSTS_SECTION = 'Access to posts section';
    const PRODUCTS_SECTION = 'Access to products section';
    const PROMOTIONS_SECTION = 'Access to promotions section';
    const PRODUCT_CATEGORIES_SECTION = 'Access to product categories section';
    const USER_SECTION = 'Access to user section';
    const SETTINGS_SECTION = 'Access to settings section';
    const PROGRAM_SECTION = 'Access to program section';
    const NEWSLETTER_SECTION = 'Access to newsletter section';


    private $ID;
    private $acc_id;
    private $meta_key;
    private $meta_value;

    /**
     * AccessRightMeta constructor.
     */
    public function __construct() {
    }

    /**
     * @return AccessRightMeta
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }


    /**
     * @param $ID
     * @param $acc_id
     * @param $key
     * @param $value
     * @return $this
     */
    public static function createMeta($ID, $acc_id, $key, $value) {
        return self::create()->setID($ID)->setAccId($acc_id)->setMetaKey($key)->setMetaValue($value);
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
    public function getAccId() {
        return $this->acc_id;
    }

    /**
     * @param mixed $acc_id
     * @return $this
     */
    public function setAccId($acc_id) {
        $this->acc_id = $acc_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetaKey() {
        return $this->meta_key;
    }

    /**
     * @return mixed
     */
    public function getMetaValue() {
        return $this->meta_value;
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
     * @param mixed $meta_key
     * @return $this
     */
    public function setMetaKey($meta_key) {
        $this->meta_key = $meta_key;
        return $this;
    }

    /**
     * @param mixed $meta_value
     * @return $this
     */
    public function setMetaValue($meta_value) {
        $this->meta_value = $meta_value;
        return $this;
    }

    static function getAccessRightsDescriptions() {
        return array(
            AccessRight::DASHBOARD_SECTION => self::DASHBOARD_SECTION,
            AccessRight::PAGES_SECTION => self::PAGES_SECTION,
            AccessRight::USER_SECTION => self::USER_SECTION,
            AccessRight::POSTS_SECTION => self::POSTS_SECTION,
            AccessRight::PRODUCTS_SECTION => self::PRODUCTS_SECTION,
            AccessRight::PRODUCT_CATEGORIES_SECTION => self::PRODUCT_CATEGORIES_SECTION,
            AccessRight::PROMOTIONS_SECTION => self::PROMOTIONS_SECTION,
            AccessRight::NEWSLETTER_SECTION => self::NEWSLETTER_SECTION,
            AccessRight::PROGRAM_SECTION => self::PROGRAM_SECTION,
            AccessRight::SETTINGS_SECTION => self::SETTINGS_SECTION
        );
    }

}