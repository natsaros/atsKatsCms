<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'users' . DS . 'User.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'users' . DS . 'UserMeta.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'users' . DS . 'UserStatus.php');

class UserHandler {

    const ID = 'ID';
    const USERNAME = 'NAME';
    const PASSWORD = 'PASSWORD';
    const PASSWORD_CONFIRMATION = 'PASSWORD_CONFIRMATION';
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
    const PICTURE_PATH = 'PICTURE_PATH';
    const FORCE_CHANGE_PASSWORD = 'FORCE_CHANGE_PASSWORD';
    const USER_ID = 'USER_ID';
    const GROUP_ID = 'GROUP_ID';

    /**
     * @param $username string
     * @param $password string
     * @return User
     * @throws SystemException
     */
    static function adminLogin($username, $password) {
        $query = "SELECT * FROM " . getDb()->users . " WHERE " . self::USERNAME . " = ? AND " . self::USER_STATUS . " = " . UserStatus::ACTIVE;
        $row = getDb()->selectStmtSingle($query, array('s'), array($username));
        $user = self::populateUser($row);
        if (password_verify($password, $user->getPassword())) {
            $user->setPassword(null);
            $user->setAccessRights(AccessRightsHandler::getAccessRightByUserId($user->getID()));
//            $user->setGroups(GroupHandler::fetchGroupsByUser($user->getID()));
            return $user;
        }
        return null;
    }

    /**
     * @param $email string
     * @return int
     * @throws SystemException
     */
    static function resetPassword($email) {
        $generated_password = bin2hex(openssl_random_pseudo_bytes(3));
        $password = password_hash($generated_password, PASSWORD_DEFAULT);
        $query = "UPDATE " . getDb()->users . " SET " . self::PASSWORD . " = ?, " . self::FORCE_CHANGE_PASSWORD . " = 1 WHERE " . self::EMAIL . " = ?";
        $result = getDb()->updateStmt($query, array('s', 's'), array($password, $email));
        if ($result === 1){
            EmailHandler::sendResetPasswordToAdminUser($email, $generated_password);
        }
        return $result;
    }

    /**
     * @param $id
     * @param $newPassword
     * @return int
     * @throws SystemException
     */
    static function changePassword($id, $newPassword) {
        $password = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE " . getDb()->users . " SET " . self::PASSWORD . " = ?, " . self::FORCE_CHANGE_PASSWORD . " = 0 WHERE " . self::ID . " = ?";
        $result = getDb()->updateStmt($query, array('s', 'i'), array($password, $id));
        return $result;
    }

    /**
     * @return User[]|bool
     * @throws SystemException
     */
    static function fetchAllUsers() {
        $query = "SELECT * FROM " . getDb()->users;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateUsers($rows);
    }

    /**
     * @return User[]|bool
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
        if (isNotEmpty($id)) {
            $query = "SELECT * FROM " . getDb()->users . " WHERE " . self::ID . " = ?";
            $row = getDb()->selectStmtSingle($query, array('i'), array($id));
            if ($row) {
                $user = self::populateUser($row);
                return $user;
            }
            return null;
        }
        return null;

    }

    /**
     * @param $email string
     * @param $id string
     * @return bool
     * @throws SystemException
     */
    static function userEmailExists($email, $id) {
        if (isNotEmpty($email)) {
            $query = "SELECT * FROM " . getDb()->users . " WHERE " . self::EMAIL . " = ?";
            $row = getDb()->selectStmtSingle($query, array('s'), array($email));
            if ($row && (isEmpty($id) || (isNotEmpty($id) && $row[self::ID] != $id))) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @param $id
     * @param $userStatus
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function updateUserStatus($id, $userStatus) {
        if (isNotEmpty($id)) {
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
        //TODO add user meta query here
        if (isNotEmpty($user)) {
            $query = "UPDATE " . getDb()->users . " SET " . self::USER_STATUS . " = ?, " . self::USERNAME . " = ?, " . self::FIRST_NAME . " = ?, " . self::LAST_NAME . " = ?, " . self::EMAIL . " = ?, " . self::LINK . " = ?, " . self::GENDER . " = ?, " . self::PHONE . " = ?, " . self::PICTURE . " = ?, " . self::PICTURE_PATH . " = ?, " . self::FORCE_CHANGE_PASSWORD . " = ? WHERE " . self::ID . " = ?";
            $result = getDb()->updateStmt($query,
                array('i', 's', 's', 's', 's', 's', 's', 's', 's', 's', 'i', 'i'),
                array($user->getUserStatus(),
                    $user->getUserName(),
                    $user->getFirstName(),
                    $user->getLastName(),
                    $user->getEmail(),
                    $user->getLink(),
                    $user->getGender(),
                    $user->getPhone(),
                    $user->getPicture(),
                    $user->getPicturePath(),
                    $user->getForceChangePassword(),
                    $user->getID()
                ));

            if (isNotEmpty($user->getPassword())){
                $query = "UPDATE " . getDb()->users . " SET " . self::PASSWORD . " = ? WHERE " . self::ID . " = ?";
                $result = getDb()->updateStmt($query,
                    array('s', 'i'),
                    array($user->getPassword(), $user->getID()));
            }
            return $result;
        }
        return null;
    }

    /**
     * @param $user User
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function createUser($user) {
        //TODO add user meta query here
        if (isNotEmpty($user)) {
            $generated_password = bin2hex(openssl_random_pseudo_bytes(3));
            $password = password_hash($generated_password, PASSWORD_DEFAULT);

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
                "," . self::PICTURE .
                "," . self::PICTURE_PATH .
                "," . self::FORCE_CHANGE_PASSWORD .
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
                , ? 
                , ?)";

            $result = getDb()->createStmt($query,
                array('i', 's', 's', 's', 's', 's', 's', 's', 's', 's', 's', 'i', 's'),
                array($user->getUserStatus(),
                    $user->getUserName(),
                    $password,
                    $user->getFirstName(),
                    $user->getLastName(),
                    $user->getEmail(),
                    $user->getLink(),
                    $user->getGender(),
                    $user->getPhone(),
                    $user->getPicture(),
                    $user->getPicturePath(),
                    $user->getForceChangePassword(),
                    date(DEFAULT_DATE_FORMAT)
                ));

            EmailHandler::sendPasswordToCreatedAdminUser($user->getEmail(), $user->getUserName(), $generated_password);
            return $result;
        }
        return null;
    }

    /**
     * @param $ID
     * @param $groupIDs
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function updateUserGroups($ID, $groupIDs) {
        if (isNotEmpty($ID)) {
            $groupsFetched = GroupHandler::fetchGroupsByUser($ID);
            $res = true;
            if (isNotEmpty($groupsFetched)) {
                $query = "DELETE FROM " . getDb()->ugr_assoc . " WHERE " . self::USER_ID . " = ?";
                $res = getDb()->deleteStmt($query, array('i'), array($ID));
            }

            if ($res && isNotEmpty($groupIDs)) {
                foreach ($groupIDs as $groupID) {
                    $query = "INSERT INTO " . getDb()->ugr_assoc . " (" . self::GROUP_ID . "," . self::USER_ID . ") VALUES (?,?)";
                    $res = getDb()->createStmt($query, array('i', 'i'), array($groupID, $ID));
                }
            } else {
                return null;
            }
            return $res;
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
        if ($rows === false) {
            return false;
        }

        $users = [];

        foreach ($rows as $row) {
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
        if ($row === false) {
            return false;
        }
        return User::createFullUser($row[self::ID], $row[self::USERNAME], $row[self::PASSWORD], $row[self::FIRST_NAME], $row[self::LAST_NAME], $row[self::EMAIL], $row[self::ACTIVATION_DATE], $row[self::MODIFICATION_DATE], $row[self::USER_STATUS], $row[self::GENDER], $row[self::LINK], $row[self::PHONE], $row[self::PICTURE], $row[self::PICTURE_PATH], $row[self::FORCE_CHANGE_PASSWORD]);
    }
}