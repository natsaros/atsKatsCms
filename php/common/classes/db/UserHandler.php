<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'users' . DS . 'User.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'users' . DS . 'UserStatus.php');

class UserHandler {

    const ID = 'ID';
    const USERNAME = 'NAME';
    const PASSWORD = 'PASSWORD';
    const FIRST_NAME = 'FIRST_NAME';
    const LAST_NAME = 'LAST_NAME';
    const EMAIL = 'EMAIL';
    const ACTIVATION_DATE = 'ACTIVATION_DATE';
    const MODIFICATION_DATE = 'MODIFICATION_DATE';
    const USER_STATUS = 'USER_STATUS';
    const IS_ADMIN = 'IS_ADMIN';
    const GENDER = 'GENDER';
    const LINK = 'LINK';
    const PHONE = 'PHONE';
    const PICTURE = 'PICTURE';

    /**
     * @param $username string
     * @param $password string
     * @return User
     * @throws SystemException
     */
    static function adminLogin($username, $password) {
        $query = "SELECT * FROM " . getDb()->users . " WHERE " . self::USERNAME . " = ? AND " . self::IS_ADMIN . "=1 AND " . self::USER_STATUS . " = " . UserStatus::ACTIVE;
        $row = getDb()->selectStmtSingle($query, array('s'), array($username));
        $user = self::populateUser($row);
        if(password_verify($password, $user->getPassword())) {
            $user->setPassword(null);
            return $user;
        }
        return null;
    }

    /**
     * @return array|bool
     * @throws SystemException
     */
    static function fetchAllUsers() {
        $query = "SELECT * FROM " . getDb()->users;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateUsers($rows);
    }

    /**
     * @return array|bool
     * @throws SystemException
     */
    static function fetchActiveUsers() {
        $query = "SELECT * FROM " . getDb()->users . " WHERE " . self::USER_STATUS . " = " . UserStatus::ACTIVE;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateUsers($rows);
    }

    /**
     * @param $id string
     * @return User
     * @throws SystemException
     */
    static function getUserById($id) {
        if(isNotEmpty($id)) {
            $query = "SELECT * FROM " . getDb()->users . " WHERE " . self::ID . " = ?";
            $row = getDb()->selectStmtSingle($query, array('i'), array($id));
            $user = self::populateUser($row);
            return $user;
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
            $query = "UPDATE " . getDb()->users . " SET " . self::USER_STATUS . " = ? WHERE " . self::ID . " = ?";
            return getDb()->updateStmt($query, array('i', 'i'), array($userStatus, $id));
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
            $query = "UPDATE " . getDb()->users . " SET " . self::USER_STATUS . " = ?, " . self::USERNAME . " = ?, " . self::FIRST_NAME . " = ?, " . self::LAST_NAME . " = ?, " . self::EMAIL . " = ?, " . self::LINK . " = ?, " . self::GENDER . " = ?, " . self::PHONE . " = ?, " . self::IS_ADMIN . " = ?, " . self::PICTURE . " = ? WHERE " . self::ID . " = ?";
            return getDb()->updateStmt($query,
                array('i', 's', 's', 's', 's', 's', 's', 's', 'i', 'b', 'i'),
                array($user->getUserStatus(),
                    $user->getUserName(),
                    $user->getFirstName(),
                    $user->getLastName(),
                    $user->getEmail(),
                    $user->getLink(),
                    $user->getGender(),
                    $user->getPhone(),
                    $user->getIsAdmin(),
                    $user->getPicture(),
                    $user->getID()
                ));
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
                "," . self::ACTIVATION_DATE .
                ") VALUES (?
                , ?
                , ?
                , ?
                , ? 
                , ? 
                , ? 
                , ? 
                , ? 
                , ? 
                , ? 
                , ?)";

            return getDb()->createStmt($query,
                array('i', 's', 's', 's', 's', 's', 's', 's', 's', 'i', 'b', 's'),
                array($user->getUserStatus(),
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
                    date('Y-m-d H:i:s')
                ));
        }
        return null;
    }


    /*Populate Functions*/

    /**
     * @param $rows
     * @return User[]|bool
     * @throws SystemException
     */
    private static function populateUsers($rows) {
        if($rows === false) {
            return false;
        }

        $users = [];

        foreach($rows as $row) {
            $users[] = self::populateUser($row);
        }
        return $users;
    }

    /**
     * @param $row
     * @return User|bool
     * @throws SystemException
     */
    private static function populateUser($row) {
        if($row === false) {
            return false;
        }
        return User::createFullUser($row[self::ID], $row[self::USERNAME], $row[self::PASSWORD], $row[self::FIRST_NAME], $row[self::LAST_NAME], $row[self::EMAIL], $row[self::ACTIVATION_DATE], $row[self::MODIFICATION_DATE], $row[self::USER_STATUS], $row[self::IS_ADMIN] == 1, $row[self::GENDER], $row[self::LINK], $row[self::PHONE], $row[self::PICTURE]);
    }
}