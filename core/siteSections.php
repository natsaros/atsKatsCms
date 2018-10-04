<?php


/**
 * This files reads site sections of the cms
 */
try {
    $pageSections = new PageSections();
    $siteSections = parse_ini_file(getcwd() . DS . 'conf/siteSections.ini', true);
    if ($siteSections) {
        $sectionsIni = $siteSections['sections'];
        if ($sectionsIni) {
            $activeSectionsInConf = $sectionsIni['activeSections'];
            if ($activeSectionsInConf) {
                $activeSections = array();
                foreach ($activeSectionsInConf as $section) {
                    $key = array_search($section, PageSections::getPageSections());
                    $index = array_search($section, array_values(PageSections::getPageSections()));
                    if ($key && $index) {
                        $pageSections->addActiveSections(array_keys(PageSections::getPageSections())[$index], PageSections::getPageSections()[$key]);
                    }
                }
            } else {
                $pageSections->setActiveSiteSections(PageSections::getPageSections());
            }
        } else {
            $pageSections->setActiveSiteSections(PageSections::getPageSections());
        }
    } else {
        $pageSections->setActiveSiteSections(PageSections::getPageSections());
    }

    $allActiveAccessRights = AccessRightsHandler::fetchAccessRightsStr(AccessRightsHandler::fetchAllActiveAccessRights());
    $activeAccessRights = $pageSections->getActiveAccessRights();
    asort($allActiveAccessRights);
    asort($activeAccessRights);
    $areEqual = array_values($allActiveAccessRights) == array_values($activeAccessRights);
    if (!$areEqual) {
        $accessRightsStr = AccessRightsHandler::fetchAccessRightsStr(AccessRightsHandler::fetchAllAccessRights());
        AccessRightsHandler::resetDbAccessRights($accessRightsStr, $activeAccessRights);
    }
} catch (SystemException $e) {
    logError($e);
    $statusCode = 500;
    $status_string = $statusCode . ' ' . 'Internal Server Error';
    header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $statusCode);
    require(ADMIN_ROOT_PATH . '404.php');
}