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