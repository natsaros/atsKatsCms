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
    const PROGRAM = 'program';

    //by default active sections
    private $activeSiteSections = array(
        AccessRight::DASHBOARD_SECTION => self::DASHBOARD,
        AccessRight::SETTINGS_SECTION => self::SETTINGS
    );

    /**
     **
     * @param string $pageRequested
     * @param array $accessRights
     * @return mixed|boolean
     */
    function hasAccessToPageSection($pageRequested, $accessRights) {
        $hasAccess = false;
        if (in_array($pageRequested, self::getExcludedPages())) {
            $hasAccess = true;
        } else {
            $pagesAllowed = self::getPagesByAccessRights($accessRights);
            foreach ($pagesAllowed as $page) {
                if (preg_match('/^' . $page . '/', $pageRequested)) {
                    $hasAccess = true;
                    break;
                }
            }
        }

        return $hasAccess;
    }

    /**
     * @param array $accessRights
     * @return mixed|string[]
     */
    private function getPagesByAccessRights($accessRights) {
        if (sizeof($accessRights) === 1 && $accessRights[0] === AccessRight::ALL) {
            return array_values(self::getActiveSections());
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
    private function getPageByAccessRight($accessRight) {
        return self::getActiveSections()[$accessRight];

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
            AccessRight::PROGRAM_SECTION => self::PROGRAM,
            AccessRight::SETTINGS_SECTION => self::SETTINGS
        );
        return $sections;
    }

    static function getExcludedPages() {
        return array('updateMyProfile');
    }


    /**
     * @return mixed
     */
    public function getActiveSections() {
        return $this->activeSiteSections;
    }

    /**
     * @param $key
     * @param $activeSiteSection
     */
    public function addActiveSections($key, $activeSiteSection) {
        $this->activeSiteSections[$key] = $activeSiteSection;
    }
}