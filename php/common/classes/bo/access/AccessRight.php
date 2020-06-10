<?php

/**
 * Signifies access rights of users and groups of the application
 */
class AccessRight
{

    const DESCRIPTION = 'description';

    const ALL = 'ALL';
    const DASHBOARD_SECTION = 'DASHBOARD_SECTION';
    const PAGES_SECTION = 'PAGES_SECTION';
    const POSTS_SECTION = 'POSTS_SECTION';
    const PRODUCTS_SECTION = 'PRODUCTS_SECTION';
    const PROMOTIONS_SECTION = 'PROMOTIONS_SECTION';
    const PRODUCT_CATEGORIES_SECTION = 'PRODUCT_CATEGORIES_SECTION';
    const USER_SECTION = 'USER_SECTION';
    const SETTINGS_SECTION = 'SETTINGS_SECTION';
    const PROGRAM_SECTION = 'PROGRAM_SECTION';
    const NEWSLETTER_SECTION = 'NEWSLETTER_SECTION';

    private $ID;
    private $name;
    private $status;

    /**
     * @var AccessRightMeta[]
     */
    private $accessMeta;

    /**
     * AccessRight constructor.
     */
    public function __construct() {
        $this->setStatus(AccessRightStatus::ACTIVE);
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
     * @param $status
     * @return $this
     */
    public static function createAccessRight($ID, $name, $status) {
        return self::create()->setID($ID)->setName($name)->setStatus($status);
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
     * @param mixed $status
     * @return AccessRight
     */
    public function setStatus($status) {
        $this->status = $status;
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

    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }


    /**
     * @return string|null
     */
    public function getDescription() {
        foreach (self::getAccessMeta() as $meta) {
            if ($meta->getMetaKey() === self::DESCRIPTION) {
                return $meta->getMetaValue();
            }
        }
        return null;
    }

    static function getAccessRights() {
        return array(
            self::ALL => self::ALL,
            self::DASHBOARD_SECTION => self::DASHBOARD_SECTION,
            self::PAGES_SECTION => self::PAGES_SECTION,
            self::USER_SECTION => self::USER_SECTION,
            self::POSTS_SECTION => self::POSTS_SECTION,
            self::PRODUCTS_SECTION => self::PRODUCTS_SECTION,
            self::PRODUCT_CATEGORIES_SECTION => self::PRODUCT_CATEGORIES_SECTION,
            self::PROMOTIONS_SECTION => self::PROMOTIONS_SECTION,
            self::NEWSLETTER_SECTION => self::NEWSLETTER_SECTION,
            self::PROGRAM_SECTION => self::PROGRAM_SECTION,
            self::SETTINGS_SECTION => self::SETTINGS_SECTION
        );
    }

}