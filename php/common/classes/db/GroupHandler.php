<?php

require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'groups' . DS . 'Group.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'groups' . DS . 'GroupMeta.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'groups' . DS . 'GroupStatus.php');

/**
 * Handles user groups
 */
class GroupHandler {

    const ID = 'ID';
    const GROUP_NAME = 'NAME';
    const STATUS = 'STATUS';
    const GROUP_ID = 'GROUP_ID';
    const META_KEY = 'META_KEY';
    const META_VALUE = 'META_VALUE';

    /**
     * @return Group[]|bool
     * @throws SystemException
     */
    static function fetchAllGroups() {
        $query = "SELECT * FROM " . getDb()->user_groups;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateGroups($rows);
    }

    /**
     * @return Group[]|bool
     * @throws SystemException
     */
    static function fetchAllActiveGroups() {
        $query = "SELECT * FROM " . getDb()->user_groups . " WHERE " . self::STATUS . " = " . GroupStatus::ACTIVE;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateGroups($rows);
    }

    /**
     * @param $ID
     * @return Group|bool
     * @throws SystemException
     */
    static function getGroupById($ID) {
        $query = "SELECT * FROM " . getDb()->user_groups . " WHERE " . self::ID . " = ?";
        $row = getDb()->selectStmtSingle($query, array('i'), array($ID));
        return self::populateGroup($row);
    }

    /**
     * @param $id
     * @param $groupStatus
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function updateGroupStatus($id, $groupStatus) {
        if(isNotEmpty($id)) {
            $query = "UPDATE " . getDb()->user_groups . " SET " . self::STATUS . " = ? WHERE " . self::ID . " = ?";
            return getDb()->updateStmt($query, array('i', 'i'), array($groupStatus, $id));
        }
        return null;
    }

    /**
     * @param Group $group
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function create($group) {
        if(isNotEmpty($group)) {
            $query = "INSERT INTO " . getDb()->user_groups . " (" . self::GROUP_NAME . "," . self::STATUS . ") VALUES (?, ?)";
            $created = getDb()->createStmt($query, array('s', 's'), array($group->getName(), GroupStatus::ACTIVE));
            if($created) {
                $groupMetas = $group->getGroupMeta();
                if(isNotEmpty($groupMetas) && count($groupMetas) > 0) {
                    /** @var GroupMeta $meta */
                    foreach($group->getGroupMeta() as $meta) {
                        $query = "INSERT INTO " . getDb()->user_groups_meta .
                            " (" . self::META_KEY .
                            "," . self::META_VALUE .
                            "," . self::GROUP_ID .
                            ") VALUES (?, ?, ?)";
                        $createdMeta = getDb()->createStmt($query,
                            array('s', 's', 'i'),
                            array($meta->getMetaKey(), $meta->getMetaValue(), $created));
                    }
                }
            }
            return $created;
        }
        return null;
    }

    /**
     * @param Group $group
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function update($group) {
        if(isNotEmpty($group)) {
            $query = "UPDATE " . getDb()->user_groups . " SET " . self::GROUP_NAME . " = ?, " . self::STATUS . " = ? ," . self::ID . " = LAST_INSERT_ID(" . $group->getID() . ") WHERE " . self::ID . " = ?;";
            $updatedRes = getDb()->updateStmt($query,
                array('s', 'i', 'i'),
                array($group->getName(), $group->getStatus(), $group->getID()));
            if($updatedRes) {
                $updatedId = getDb()->selectStmtSingleNoParams("SELECT LAST_INSERT_ID() AS " . self::ID . "");
                $updatedId = $updatedId["" . self::ID . ""];

                $groupMetas = $group->getGroupMeta();
                if(isNotEmpty($groupMetas) && count($groupMetas) > 0) {
                    /** @var GroupMeta $meta */
                    foreach($group->getGroupMeta() as $meta) {
                        $query = "UPDATE " . getDb()->user_groups_meta . " SET " . self::META_KEY . " = ?, " . self::META_VALUE . " = ? WHERE " . self::GROUP_ID . " = ?";
                        $updatedRes = getDb()->updateStmt($query,
                            array('s', 's', 'i'),
                            array($meta->getMetaKey(), $meta->getMetaValue(), $updatedId));
                    }
                }

            }
            return $updatedRes;
        }
        return null;
    }

    /*Populate Functions*/

    /**
     * @param $rows
     * @return Group[]|bool
     * @throws SystemException
     */
    private static function populateGroups($rows) {
        if($rows === false) {
            return false;
        }

        $groups = [];

        foreach($rows as $row) {
            $groups[] = self::populateGroup($row);
        }
        return $groups;
    }

    /**
     * @param $row
     * @return Group|bool
     * @throws SystemException
     */
    private static function populateGroup($row) {
        if($row === false) {
            return false;
        }
        return Group::createGroup($row[self::ID], $row[self::GROUP_NAME], $row[self::STATUS]);
    }
}