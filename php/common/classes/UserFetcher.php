<?php
require_once(CLASSES_ROOT_PATH . 'DB.php');
require_once(CLASSES_ROOT_PATH . 'User.php');

class UserFetcher {

    private static function populateUsers($rows) {
        if($rows === false) {
            return false;
        }

        $users = [];

        foreach($rows as $row) {
            $users[] = new User($row['ID'], $row['name'], $row['password'], $row['first_name'], $row['last_name'], $row['email'], $row['activation_date'], $row['modification_date'], $row['user_status'], $row['is_admin'], $row['gender'], $row['link'], $row['phone'], $row['picture']);
        }
        return $users;
    }

    /**
     * @return User
     * @param $username string
     * @param $password string
     */
    static function adminLogin($username, $password) {
        $query = "SELECT * FROM %s WHERE name='%s' AND %s=1 AND %s=1";
        $query = sprintf($query, getDb()->users, $username, 'is_admin', 'user_status');
        $rows = getDb()->select($query);
        $users = self::populateUsers($rows);

        if(!$users || count($users) > 1) {
            return null;
        }

        /* @var $user User */
        foreach($users as $user) {
            if(password_verify($password, $user->getPassword())) {
                $user->setPassword(null);
                return $user;
            }
        }
        return null;
    }

    /**
     * @return array|bool
     */
    static function fetchAllUsers() {
        $query = "SELECT * FROM %s";
        $query = sprintf($query, getDb()->users);
        $rows = getDb()->select($query);
        return self::populateUsers($rows);
    }

    /**
     * @return array|bool
     */
    static function fetchActiveUsers() {
        $query = "SELECT * FROM %s WHERE %s=1";
        $query = sprintf($query, getDb()->users, 'user_status');
        $rows = getDb()->select($query);
        return self::populateUsers($rows);
    }

    /**
     * @return User[]
     * @param $id string
     */
    static function getUserById($id) {
        if(isset($id) && $id != null && $id != "") {
            $query = "SELECT * FROM %s WHERE %s = %s";
            $query = sprintf($query, getDb()->users, 'ID', $id);
            $rows = getDb()->select($query);
            return self::populateUsers($rows);
        }
        return null;

    }

    /**
     * @param $id
     * @param $userStatus
     * @return bool|mysqli_result|null
     */
    static function updateUserStatus($id, $userStatus) {
        if(isset($id) && $id != null && $id != "") {
            $query = "UPDATE %s SET %s = %s WHERE %s = %s";
            $query = sprintf($query, getDb()->users, 'user_status', $userStatus, 'ID', $id);
            return getDb()->update($query);
        }
        return null;
    }
}