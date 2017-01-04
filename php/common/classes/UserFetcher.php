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

    static function adminLogin($username, $password) {
        $query = "SELECT * FROM %s WHERE name='%s' AND is_admin=1 AND user_status=1";
        $query = sprintf($query, getDb()->users, $username);
        $db = Globals::get('DB');
        $rows = $db->select($query);

        $users = self::populateUsers($rows);

        if(count($users) > 1) {
            return false;
        }

        /* @var $user User */
        foreach($users as $user) {
            if(password_verify($password, $user->getPassword())) {
                $user->setPassword(null);
                return $user;
            }
        }
        return false;
    }

    static function fetchUsers() {
        $query = "SELECT * FROM %s";
        $query = sprintf($query, getDb()->users);
        $rows = getDb()->select($query);
        return self::populateUsers($rows);
    }

    static function getUserById($id) {
        if(isset($id) && $id != null && $id != "") {
            $query = "SELECT * FROM %s WHERE %s = %s";
            $query = sprintf($query, getDb()->users, getDb()->users->ID, $id);
            $rows = getDb()->select($query);
            return self::populateUsers($rows);
        }
        return null;

    }
}