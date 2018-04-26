<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'access' . DS . 'AccessRight.php');

class PageSections {

    const DASHBOARD = 'dashboard';
    const PAGES = 'pages';
    const POSTS = 'posts';
    const PRODUCTS = 'products';
    const PRODUCT_CATEGORIES = 'productCategories';
    const PROMOTIONS = 'promotions';
    const NEWSLETTER = 'newsletter';
    const USERS = 'users';
    const SETTINGS = 'settings';

    /**
     **
     * @param string $pageRequested
     * @param array $accessRights
     * @return mixed|boolean
     */
    static function hasAccessToPageSection($pageRequested, $accessRights) {
        $hasAccess = false;
        $pagesAllowed = PageSections::getPagesByAccessRights($accessRights);
        foreach ($pagesAllowed as $page) {
            if (preg_match('/^' . $page . '/', $pageRequested)) {
                $hasAccess = true;
                break;
            }
        }
        return $hasAccess;
    }

    /**
     * @param array $accessRights
     * @return mixed|string[]
     */
    static function getPagesByAccessRights($accessRights) {
        if (sizeof($accessRights) === 1 && $accessRights[0] === AccessRight::ALL) {
            return array_values(self::getPageSections());
        } else {
            $pages = array();
            foreach ($accessRights as $accessRight) {
                $pageByAccessRight = self::getPageByAccessRight($accessRight);
                if (!in_array($pageByAccessRight, $pages)) {
                    $pages[] = $pageByAccessRight;
                }
            }
            return $pages;
        }
    }

    /**
     * @param $accessRight
     * @return mixed|string
     */
    static function getPageByAccessRight($accessRight) {
        return self::getPageSections()[$accessRight];

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
            AccessRight::USER_SECTION => self::USERS,
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