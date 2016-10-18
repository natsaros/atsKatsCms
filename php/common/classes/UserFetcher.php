<?php
require_once(CLASSES_ROOT_PATH . 'DB.php');
require_once(CLASSES_ROOT_PATH . 'User.php');

class UserFetcher {
    public static function login($username, $password) {
        $query = "SELECT * FROM %s WHERE name='%s'";
        $query = sprintf($query, getDb()->users, $username);
        $db = Globals::get('DB');
        $rows = $db->select($query);

        if($rows === false || count($rows) > 1) {
            return false;
        }

        foreach($rows as $row) {
            $user = new User($row['ID'], $row['name'], $row['password'], $row['first_name'], $row['last_name'], $row['email'], $row['activation_date'], $row['modification_date'], $row['user_status'], $row['gender'], $row['link'], $row['phone'], $row['picture']);
            if(password_verify($password, $user->getPassword())) {
                $user->setPassword(null);
                return $user;
            }
        }
        return false;
    }
}