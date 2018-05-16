<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'access' . DS . 'AccessRight.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'access' . DS . 'AccessRightMeta.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'access' . DS . 'AccessRightStatus.php');

/**
 * Handles access rights
 */
class AccessRightsHandler {
    const ID = 'ID';
    const NAME = 'NAME';
    const STATUS = 'STATUS';

    const ACCESS_ID = 'ACCESS_ID';
    const META_ID = 'ID';
    const META_KEY = 'META_KEY';
    const META_VALUE = 'META_VALUE';
    const USER_ID = 'USER_ID';
    const GROUP_ID = 'GROUP_ID';
    const ACC_ID = 'ACC_ID';

    /**
     * @param $id
     * @param $accessRights array
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function updateUserAccessRights($id, $accessRights) {
        if (isNotEmpty($id)) {
            $accessRightsFetched = self::getAccessRightByUserId($id);
            $res = false;
            if (isNotEmpty($accessRightsFetched)) {
                $res = self::deleteAccessRightsForUser($id);
            } else {
                $res = true;
            }
            if ($res && isNotEmpty($accessRights)) {
                foreach ($accessRights as $right) {
                    $query = "INSERT INTO " . getDb()->acr_assoc . " (" . self::ACC_ID . "," . self::USER_ID . ") VALUES (?,?)";
                    $res = getDb()->createStmt($query, array('i', 'i'), array($right, $id));
                }
            } else {
                return null;
            }
            return $res;
        }
        return null;
    }

    /**
     * @param $userID
     * @return mixed|null
     * @throws SystemException
     */
    public static function deleteAccessRightsForUser($userID) {
        $query = "DELETE FROM " . getDb()->acr_assoc . " WHERE " . self::USER_ID . " = ?";
        $res = getDb()->deleteStmt($query, array('i'), array($userID));
        if (!$res) {
            throw new SystemException("Access rights for user with id :{$userID} failed to be deleted");
        }
        return $res;
    }

    /**
     * @param $id
     * @param $accessRights array
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function updateGroupAccessRights($id, $accessRights) {
        if (isNotEmpty($id)) {
            $accessRightsFetched = self::getAccessRightByGroupId($id);
            $res = false;
            if (isNotEmpty($accessRightsFetched)) {
                $query = "DELETE FROM " . getDb()->acr_assoc . " WHERE " . self::GROUP_ID . " = ?";
                $res = getDb()->deleteStmt($query, array('i'), array($id));
            } else {
                $res = true;
            }
            if ($res && isNotEmpty($accessRights)) {
                foreach ($accessRights as $right) {
                    $query = "INSERT INTO " . getDb()->acr_assoc . " (" . self::ACC_ID . "," . self::GROUP_ID . ") VALUES (?,?)";
                    $res = getDb()->createStmt($query, array('i', 'i'), array($right, $id));
                }
            } else {
                return null;
            }
            return $res;
        }
        return null;
    }


    /**
     * @return AccessRight[]|bool
     * @throws SystemException
     */
    static function fetchAllActiveAccessRights() {
        $query = "SELECT * FROM " . getDb()->access_rights . " WHERE " . self::STATUS . "= ?";
        $rows = getDb()->selectStmt($query, array('i'), array(AccessRightStatus::ACTIVE));
        return self::populateAccessRights($rows);
    }

    /**
     * @return AccessRight[]|bool
     * @throws SystemException
     */
    static function fetchAllAccessRights() {
        $query = "SELECT * FROM " . getDb()->access_rights;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateAccessRights($rows);
    }

    /**
     * @param AccessRight[]
     * @return String[]|bool
     */
    static function fetchAccessRightsStr($accessRights) {
        $ret = array();
        if (isNotEmpty($accessRights)) {
            /** @var AccessRight $right */
            foreach ($accessRights as $right) {
                $ret[] = $right->getName();
            }
        }
        return $ret;
    }

    /**
     * @param $id
     * @return AccessRight[]|bool
     * @throws SystemException
     */
    static function getAccessRightByUserId($id) {
        if (isNotEmpty($id)) {
            $query = "SELECT a.* FROM " . getDb()->access_rights . " a 
                      LEFT JOIN " . getDb()->acr_assoc . " acr ON a." . self::ID . " = acr." . self::ACC_ID . " 
                      LEFT JOIN  " . getDb()->users . " u ON u." . self::ID . " = acr." . self::USER_ID . " 
                      LEFT JOIN " . getDb()->user_groups . " g ON g." . self::ID . " = acr." . self::GROUP_ID . " 
                      WHERE acr." . self::USER_ID . " = ? 
                      OR acr." . self::GROUP_ID . " = (SELECT " . self::GROUP_ID . " FROM " . getDb()->ugr_assoc . " WHERE " . self::USER_ID . " = ?)";
            $rows = getDb()->selectStmt($query, array('i', 'i'), array($id, $id));
            if ($rows) {
                $accessRights = self::populateAccessRights($rows);
                return $accessRights;
            }
        }
        return false;
    }

    /**
     * @param $id
     * @return AccessRight[]|bool
     * @throws SystemException
     */
    static function getAccessRightByGroupId($id) {
        if (isNotEmpty($id)) {
            $query = "SELECT a.* FROM " . getDb()->access_rights . " a 
                      JOIN " . getDb()->acr_assoc . " acr ON a." . self::ID . " = acr." . self::ACC_ID . " 
                      LEFT JOIN  " . getDb()->users . " u ON u." . self::ID . " = acr." . self::USER_ID . " 
                      LEFT JOIN " . getDb()->user_groups . " g ON g." . self::ID . " = acr." . self::GROUP_ID . " 
                      WHERE acr." . self::GROUP_ID . " = ?";
            $rows = getDb()->selectStmt($query, array('i'), array($id));
            if ($rows) {
                $accessRights = self::populateAccessRights($rows);
                return $accessRights;
            }
        }
        return false;
    }

    /**
     * @param $id
     * @return AccessRight|bool
     * @throws SystemException
     */
    static function getAccessRightById($id) {
        if (isNotEmpty($id)) {
            $query = "SELECT * FROM " . getDb()->access_rights . " WHERE " . self::ID . " = ?";
            $row = getDb()->selectStmtSingle($query, array('i'), array($id));
            if ($row) {
                $accessRight = self::populateAccess($row);
                $accessRight->setAccessMeta(self::getAccessRightMetasById($accessRight->getID()));
                return $accessRight;
            }
        }
        return false;
    }

    /**
     * @param $name
     * @return AccessRight|bool
     * @throws SystemException
     */
    static function getAccessRightByName($name) {
        if (isNotEmpty($name)) {
            $query = "SELECT * FROM " . getDb()->access_rights . " WHERE " . self::NAME . " = ?";
            $row = getDb()->selectStmtSingle($query, array('s'), array($name));
            if ($row) {
                $accessRight = self::populateAccess($row);
                $accessRight->setAccessMeta(self::getAccessRightMetasById($accessRight->getID()));
                return $accessRight;
            }
        }
        return false;
    }

    /**
     * @param $id
     * @return AccessRightMeta[]|bool
     * @throws SystemException
     */
    static function getAccessRightMetasById($id) {
        if (isNotEmpty($id)) {
            $query = "SELECT * FROM " . getDb()->access_rights_meta . " WHERE " . self::ACCESS_ID . " = ?";
            $rows = getDb()->selectStmt($query, array('i'), array($id));
            if ($rows) {
                return self::populateMetas($rows);
            }
        }
        return false;
    }

    /**
     * @param $rows
     * @return AccessRight[]|bool
     * @throws SystemException
     */
    private static function populateAccessRights($rows) {
        if ($rows === false) {
            return false;
        }
        $accessRights = [];
        foreach ($rows as $row) {
            $accessRight = self::populateAccess($row);
            $accessRight->setAccessMeta(self::getAccessRightMetasById($accessRight->getID()));
            $accessRights[] = $accessRight;
        }
        return $accessRights;
    }

    /**
     * @param $row
     * @return AccessRight|null
     * @throws SystemException
     */
    private static function populateAccess($row) {
        if ($row === false || null === $row) {
            return null;
        }
        $accessRight = AccessRight::createAccessRight($row[self::ID], $row[self::NAME], $row[self::STATUS]);
        return $accessRight;
    }

    /**
     * @param $rows
     * @return AccessRightMeta[]|bool
     * @throws SystemException
     */
    private static function populateMetas($rows) {
        if ($rows === false) {
            return false;
        }

        $metas = [];

        foreach ($rows as $row) {
            $metas[] = self::populateMeta($row);
        }

        return $metas;
    }

    /**
     * @param $row
     * @return AccessRightMeta|bool
     * @throws SystemException
     */
    private static function populateMeta($row) {
        if ($row === false) {
            return false;
        }
        return AccessRightMeta::createMeta($row[self::ID], $row[self::ACCESS_ID], $row[self::META_KEY], $row[self::META_VALUE]);
    }


    /**
     * @throws SystemException
     */
    static function deleteAllAccessRights() {
        $accessRights = self::fetchAllAccessRights();
        foreach ($accessRights as $accessRight) {
            self::deleteAccessRight($accessRight->getName());
        }
    }

    /**
     * @param $accessRight
     * @return bool|mixed|null
     * @throws SystemException
     */
    public static function deleteAccessRight($accessRight) {
        if (isNotEmpty($accessRight)) {
            $dbAccessRight = self::getAccessRightByName($accessRight);
            if ($dbAccessRight && isNotEmpty($dbAccessRight)) {
                $accessRightMetas = $dbAccessRight->getAccessMeta();
                if (isNotEmpty($accessRightMetas)) {
                    /** @var AccessRight $meta */
                    foreach ($accessRightMetas as $meta) {
                        $query = "DELETE FROM " . getDb()->access_rights_meta . " WHERE " . self::META_ID . " = ?";
                        $res = getDb()->deleteStmt($query, array('i'), array($meta->getID()));
                        if (!$res) {
                            throw new SystemException('Something went wrong with access rights meta deletion');
                        }
                    }
                }

                $query = "DELETE FROM " . getDb()->access_rights . " WHERE " . self::ID . " = ?";
                $res = getDb()->deleteStmt($query, array('i'), array($dbAccessRight->getID()));
                if (!$res) {
                    throw new SystemException("Something went wrong with access rights deletion with name {$accessRight}");
                }
            } else {
                throw new SystemException("Access right with name {$accessRight} does not exist");
            }
            return $res;
        } else {
            throw new SystemException("Access right with name {$accessRight} does not exist");
        }
    }

    /**
     * @param $right
     * @throws SystemException
     */
    public static function createAccessRight($right) {
        if (isNotEmpty($right) && in_array($right, AccessRight::getAccessRights())) {
            $query = "INSERT INTO " . getDb()->access_rights . " (" . self::NAME . ") VALUES (?)";
            $res = getDb()->createStmt($query, array('s'), array($right));
            if ($res) {
                $query = "INSERT INTO " . getDb()->access_rights_meta . " (" . self::META_KEY . ", " . self::META_VALUE . ", " . self::ACCESS_ID . ") VALUES (?,?,?)";
                $res = getDb()->createStmt($query, array('s', 's', 'i'), array(
                    AccessRight::DESCRIPTION,
                    AccessRightMeta::getAccessRightsDescriptions()[$right],
                    $res));
                if (!$res) {
                    throw new SystemException("Something went wrong with access rights creation with name {$right}");
                }
            } else {
                throw new SystemException("Something went wrong with access rights creation with name {$right}");
            }
        } else {
            throw new SystemException("Attempt to create invalid access right");
        }
    }


    /**
     * @param $right
     * @return mixed|null
     * @throws SystemException
     */
    static function deactivateAccessRight($right) {
        if (isNotEmpty($right) && in_array($right, AccessRight::getAccessRights())) {
            $query = "UPDATE " . getDb()->access_rights . " SET " . self::STATUS . " = ? WHERE " . self::NAME . " = ?";
            $res = getDb()->updateStmt($query, array('i', 's'), array(AccessRightStatus::INACTIVE, $right));
            return $res;
        } else {
            throw new SystemException("Attempt to deactivate invalid access right");
        }
    }

    /**
     * @param $right
     * @return mixed|null
     * @throws SystemException
     */
    static function activateAccessRight($right) {
        if (isNotEmpty($right) && in_array($right, AccessRight::getAccessRights())) {
            $query = "UPDATE " . getDb()->access_rights . " SET " . self::STATUS . " = ? WHERE " . self::NAME . " = ?";
            $res = getDb()->updateStmt($query, array('i', 's'), array(AccessRightStatus::ACTIVE, $right));
            return $res;
        } else {
            throw new SystemException("Attempt to activate invalid access right");
        }
    }

    /**
     * @param $allAccessRights array
     * @param $activeAccessRights array
     * @throws SystemException
     */
    static function resetDbAccessRights($allAccessRights, $activeAccessRights) {
        if (isNotEmpty($activeAccessRights) && isNotEmpty($allAccessRights)) {
            foreach ($allAccessRights as $right) {
                if (AccessRight::ALL !== $right) {
                    if (!in_array($right, $activeAccessRights)) {
                        self::deactivateAccessRight($right);
                    } else {
                        self::activateAccessRight($right);
                    }
                }
            }
        }
    }


}