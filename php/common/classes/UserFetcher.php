<?php
require_once(CLASSES_ROOT_PATH . 'DB.php');
require_once(CLASSES_ROOT_PATH . 'User.php');

class UserFetcher {

    const ID = 'ID';
    const USERNAME = 'name';
    const PASSWORD = 'password';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const EMAIL = 'email';
    const ACTIVATION_DATE = 'activation_date';
    const MODIFICATION_DATE = 'modification_date';
    const USER_STATUS = 'user_status';
    const IS_ADMIN = 'is_admin';
    const GENDER = 'gender';
    const LINK = 'link';
    const PHONE = 'phone';
    const PICTURE = 'picture';

    /**
     * @param $rows
     * @return User[]|bool
     */
    private static function populateUsers($rows) {
        if($rows === false) {
            return false;
        }

        $users = [];

        foreach($rows as $row) {
            $users[] = User::createFullUser($row[self::ID], $row[self::USERNAME], $row[self::PASSWORD], $row[self::FIRST_NAME], $row[self::LAST_NAME], $row[self::EMAIL], $row[self::ACTIVATION_DATE], $row[self::MODIFICATION_DATE], $row[self::USER_STATUS], $row[self::IS_ADMIN] == 1, $row[self::GENDER], $row[self::LINK], $row[self::PHONE], $row[self::PICTURE]);
        }
        return $users;
    }

    /**
     * @param $username string
     * @param $password string
     * @return User
     * @throws SystemException
     */
    static function adminLogin($username, $password) {
        $query = "SELECT * FROM " . getDb()->users . " WHERE " . self::USERNAME . " = '%s' AND " . self::IS_ADMIN . "=1 AND " . self::USER_STATUS . "=1";
        $query = sprintf($query, $username);
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
     * @throws SystemException
     */
    static function fetchAllUsers() {
        $query = "SELECT * FROM " . getDb()->users;
        $rows = getDb()->select($query);
        return self::populateUsers($rows);
    }

    /**
     * @return array|bool
     * @throws SystemException
     */
    static function fetchActiveUsers() {
        $query = "SELECT * FROM " . getDb()->users . " WHERE " . self::USER_STATUS . " = 1";
        $rows = getDb()->select($query);
        return self::populateUsers($rows);
    }

    /**
     * @param $id string
     * @return User
     * @throws SystemException
     */
    static function getUserById($id) {
        if(isNotEmpty($id)) {
            $query = "SELECT * FROM " . getDb()->users . " WHERE " . self::ID . " = '%s'";
            $query = sprintf($query, $id);
            $rows = getDb()->select($query);
            $users = self::populateUsers($rows);

            if($users != null || !$users) {
                return $users[0];
            } else {
                return null;
            }
        }
        return null;

    }

    /**
     * @param $id
     * @param $userStatus
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function updateUserStatus($id, $userStatus) {
        if(isNotEmpty($id)) {
            $query = "UPDATE " . getDb()->users . " SET " . self::USER_STATUS . " = %s WHERE " . self::ID . " = %s";
            $query = sprintf($query, $userStatus, $id);
            return getDb()->update($query);
        }
        return null;
    }

    /**
     * @param $user User
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function updateUser($user) {
        if(isNotEmpty($user)) {
            $query = "UPDATE " . getDb()->users . " SET " . self::USER_STATUS . " = '%s', " . self::USERNAME . " = '%s', " . self::FIRST_NAME . " = '%s', " . self::LAST_NAME . " = '%s', " . self::EMAIL . " = '%s', " . self::LINK . " = '%s', " . self::GENDER . " = '%s', " . self::PHONE . " = '%s', " . self::IS_ADMIN . " = '%s', " . self::PICTURE . " = '%s', " . self::MODIFICATION_DATE . " = '%s' WHERE " . self::ID . " = '%s'";

            $query = sprintf($query,
                $user->getUserStatus(),
                $user->getUserName(),
                $user->getFirstName(),
                $user->getLastName(),
                $user->getEmail(),
                $user->getLink(),
                $user->getGender(),
                $user->getPhone(),
                $user->getIsAdmin(),
                $user->getPicture(),
                date('Y-m-d H:i:s'),
                $user->getID());
            return getDb()->update($query);
        }
        return null;
    }

    /**
     * @param $user User
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function createUser($user) {
        if(isNotEmpty($user)) {
            $query = "INSERT INTO " . getDb()->users .
                " (" . self::USER_STATUS .
                "," . self::USERNAME .
                "," . self::PASSWORD .
                "," . self::FIRST_NAME .
                "," . self::LAST_NAME .
                "," . self::EMAIL .
                "," . self::LINK .
                "," . self::GENDER .
                "," . self::PHONE .
                "," . self::IS_ADMIN .
                "," . self::PICTURE .
                "," . self::MODIFICATION_DATE .
                ") VALUES ('%s' 
                , '%s' 
                , '%s'
                , '%s'
                , '%s' 
                , '%s' 
                , '%s' 
                , '%s' 
                , '%s' 
                , '%s' 
                , '%s' 
                , '%s')";

            $query = sprintf($query,
                $user->getUserStatus(),
                $user->getUserName(),
                $user->getPassword(),
                $user->getFirstName(),
                $user->getLastName(),
                $user->getEmail(),
                $user->getLink(),
                $user->getGender(),
                $user->getPhone(),
                $user->getIsAdmin(),
                $user->getPicture(),
                date('Y-m-d H:i:s'));
            return getDb()->update($query);
        }
        return null;
    }
}