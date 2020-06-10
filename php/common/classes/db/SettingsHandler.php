<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'settings' . DS . 'Setting.php');

class SettingsHandler {
    const ID = 'ID';
    const SKEY = 'SKEY';
    const SVALUE = 'SVALUE';

    /**
     * @return Setting[]|bool
     * @throws SystemException
     */
    static function fetchAllSettings() {
        $query = "SELECT * FROM " . getDb()->settings;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateSettings($rows);
    }

    /**
     * @param $key
     * @return Setting
     * @throws SystemException
     */
    static function getSettingByKey($key) {
        $query = "SELECT * FROM " . getDb()->settings . " WHERE " . self::SKEY . " = ?";
        $row = getDb()->selectStmtSingle($query, array('s'), array($key));
        return self::populateSetting($row);
    }

    /**
     * @param $id
     * @return Setting
     * @throws SystemException
     */
    static function getSettingByID($id) {
        $query = "SELECT * FROM " . getDb()->settings . " WHERE " . self::ID . " = ?";
        $row = getDb()->selectStmtSingle($query, array('i'), array($id));
        return self::populateSetting($row);
    }

    /**
     * @param $key
     * @return mixed|null
     * @throws SystemException
     */
    static function getSettingValueByKey($key) {
        $setting = self::getSettingByKey($key);
        return isNotEmpty($setting) ? $setting->getValue() : null;
    }

    /**
     * @param Setting $setting
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function create($setting) {
        if(isNotEmpty($setting)) {
            $query = "INSERT INTO " . getDb()->settings . " (" . self::SKEY . "," . self::SVALUE . ") VALUES (?, ?)";
            $created = getDb()->createStmt($query, array('s', 's'), array($setting->getKey(), $setting->getValue()));
            return $created;
        }
        return null;
    }

    /**
     * @param Setting $setting
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function update($setting) {
        if(isNotEmpty($setting)) {
            $query = "UPDATE " . getDb()->settings . " SET " . self::SKEY . " = ?, " . self::SVALUE . " = ? ," . self::ID . " = LAST_INSERT_ID(" . $setting->getID() . ") WHERE " . self::ID . " = ?;";
            $updatedRes = getDb()->updateStmt($query,
                array('s', 's', 'i'),
                array($setting->getKey(), $setting->getValue(), $setting->getID()));
            return $updatedRes;
        }
        return null;
    }

    /**
     * @param $id
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function delete($id) {
        if(isNotEmpty($id)) {
            $query = "DELETE FROM " . getDb()->settings . " WHERE " . self::ID . " = ?";
            $res = getDb()->deleteStmt($query, array('i'), array($id));
            return $res;
        }
        return null;
    }

    /*Populate Functions*/

    /**
     * @param $rows
     * @return Setting[]|bool
     * @throws SystemException
     */
    private static function populateSettings($rows) {
        if($rows === false) {
            return false;
        }

        $settings = [];

        foreach($rows as $row) {
            $settings[] = self::populateSetting($row);
        }

        return $settings;

    }

    /**
     * @param $row
     * @return null|Setting
     * @throws SystemException
     */
    private static function populateSetting($row) {
        if($row === false || null === $row) {
            return null;
        }
        return Setting::createFull($row[self::ID], $row[self::SKEY], $row[self::SVALUE]);
    }

}