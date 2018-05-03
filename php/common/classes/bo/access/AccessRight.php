<?php

/**
 * Signifies access rights of users and groups of the application
 */
class AccessRight {

    const DESCRIPTION = 'description';

//    TODO : make access rights dynamic according to DB access rights
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

    /**
     * @return string|null
     */
    public function getDescription() {
        foreach(self::getAccessMeta() as $meta) {
            if($meta->getMetaKey() === self::DESCRIPTION) {
                return $meta->getMetaValue();
            }
        }
        return null;
    }

}