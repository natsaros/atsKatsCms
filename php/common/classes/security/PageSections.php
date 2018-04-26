<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'access' . DS . 'AccessRight.php');

class PageSections {

    const DASHBOARD = 'dashboard';
    const PAGES = 'pages';
    const POSTS = 'posts';
    const PRODUCTS = 'products';
    const PRODUCT_CATEGORIES = 'product_categories';
    const PROMOTIONS = 'promotions';
    const NEWSLETTER = 'newsletter';
    const USER = 'users';
    const SETTINGS = 'settings';

    /**
     * @param array $accessRights
     * @return mixed|string[]
     */
    static function getPagesByAccessRights($accessRights) {
        $pages = array();
        foreach ($accessRights as $accessRight) {
            $pageByAccessRight = self::getPageByAccessRight($accessRight);
            if (!in_array($pageByAccessRight, $pages)) {
                $pages[] = $pageByAccessRight;
            }
        }
        return $pages;
    }

    /**
     * @param $accessRight
     * @return mixed|string
     */
    static function getPageByAccessRight($accessRight) {
        if ($accessRight === AccessRight::ALL) {
            return self::DASHBOARD;
        } else {
            return self::getPageSections()[$accessRight];
        }
    }

    /**
     * correlation between access rights and pages
     *
     * @return array
     */
    static function getPageSections() {
        $sections = array(
            AccessRight::DASHBOARD_SECTION => self::DASHBOARD,
            AccessRight::PAGES_SECTION => self::PAGES,
            AccessRight::USER_SECTION => self::USER,
            AccessRight::POSTS_SECTION => self::POSTS,
            AccessRight::PRODUCTS_SECTION => self::PRODUCTS,
            AccessRight::PRODUCT_CATEGORIES_SECTION => self::PRODUCT_CATEGORIES,
            AccessRight::PROMOTIONS_SECTION => self::PROMOTIONS,
            AccessRight::NEWSLETTER_SECTION => self::NEWSLETTER,
            AccessRight::SETTINGS_SECTION => self::SETTINGS,
        );
        return $sections;
    }
}