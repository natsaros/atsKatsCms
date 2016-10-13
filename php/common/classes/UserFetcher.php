<?php
require_once(CLASSES_ROOT_PATH . 'DB.php');
require_once(CLASSES_ROOT_PATH . 'User.php');

class UserFetcher {
    protected static $db;

    public static function login($username, $password) {
        $query = "SELECT * FROM %d WHERE name = %s  and password = %s";
        $query = sprintf($query, getDb()->users, $username, $password);
        $rows = self::getDb()->select($query);

        if($rows === false) {
            return false;
        }

        return new User($rows['ID'], $rows['name'], $rows['password'], $rows['first_name'], $rows['last_name'], $rows['email'], $rows['activation_date'], $rows['modification_date'], $rows['user_status'], $rows['gender'], $rows['link'], $rows['phone'], $rows['picture']);
    }

    function getDb() {
        if(!isset(self::$db)) {
            self::$db = DB::getInstance();
        }
        return self::$db;
    }

}