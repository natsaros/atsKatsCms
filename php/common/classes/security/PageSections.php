<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'access' . DS . 'AccessRight.php');

class PageSections {

    const DASHBOARD = 'dashboard';
    const PAGES = 'pages';
    const POSTS = 'posts';
    const USER = 'users';
    const SETTINGS = 'settings';
    const PROGRAM = 'program';

    /**
     * @param array $accessRights
     * @return mixed|string[]
     */
    static function getPagesByAccessRights($accessRights) {
        $pages = array();
        foreach($accessRights as $accessRight) {
            $pageByAccessRight = self::getPageByAccessRight($accessRight);
            if(!in_array($pageByAccessRight, $pages)) {
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
        if($accessRight === AccessRight::ALL) {
            return self::DASHBOARD;
        } else {
            return self::getPageSections()[$accessRight];
        }
    }

    /**
     * @return array
     */
    static function getPageSections() {
        $sections = array(
            AccessRight::SETTINGS_SECTION => self::SETTINGS,
            AccessRight::PAGES_SECTION => self::PAGES,
            AccessRight::POSTS_SECTION => self::POSTS,
            AccessRight::USER_SECTION => self::USER,
            AccessRight::PROGRAM_SECTION => self::PROGRAM,
        );
        return $sections;
    }
}