<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'visitors' . DS . 'Visitor.php');

class VisitorHandler {

    const ID = 'ID';
    const FB_ID = 'FB_ID';
    const FIRST_NAME = 'FIRST_NAME';
    const LAST_NAME = 'LAST_NAME';
    const EMAIL = 'EMAIL';
    const USER_STATUS = 'USER_STATUS';
    const INSERTION_DATE = 'INSERTION_DATE';
    const LAST_LOGIN_DATE = 'LAST_LOGIN_DATE';

    /**
     * @param $fbId string
     * @return Visitor
     * @throws SystemException
     */
    static function getVisitorByFbId($fbId) {
        if (isNotEmpty($fbId)) {
            $query = "SELECT * FROM " . getDb()->visitors . " WHERE " . self::FB_ID . " = ?";
            $row = getDb()->selectStmtSingle($query, array('s'), array($fbId));
            if ($row) {
                $visitor = self::populateVisitor($row);
                return $visitor;
            }
            return null;
        }
        return null;
    }

    /**
     * @param $visitor Visitor
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function updateVisitor($visitor) {
        if (isNotEmpty($visitor)) {
            $query = "UPDATE " . getDb()->visitors . " SET " . self::FIRST_NAME . " = ?, " . self::LAST_NAME . " = ?, " . self::EMAIL . " = ?, " . self::LAST_LOGIN_DATE . " = ?  WHERE " . self::FB_ID . " = ?";
            return getDb()->updateStmt($query,
                array('s', 's', 's', 's', 's'),
                array($visitor->getFirstName(),
                    $visitor->getLastName(),
                    $visitor->getEmail(),
                    date(DEFAULT_DATE_FORMAT),
                    $visitor->getFBID()
                ));
        }
        return null;
    }

    /**
     * @param $visitor Visitor
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function createVisitor($visitor) {
        if (isNotEmpty($visitor)) {
            $query = "INSERT INTO " . getDb()->visitors .
                " (" . self::FB_ID .
                "," . self::USER_STATUS .
                "," . self::FIRST_NAME .
                "," . self::LAST_NAME .
                "," . self::EMAIL .
                "," . self::INSERTION_DATE .
                "," . self::LAST_LOGIN_DATE .
                ") VALUES (?
                , ?
                , ?
                , ?
                , ?
                , ?
                , ?)";

            return getDb()->createStmt($query,
                array('s', 'i', 's', 's', 's', 's', 's'),
                array($visitor->getFBID(),
                    $visitor->getUserStatus(),
                    $visitor->getFirstName(),
                    $visitor->getLastName(),
                    $visitor->getEmail(),
                    date(DEFAULT_DATE_FORMAT),
                    date(DEFAULT_DATE_FORMAT)
                ));
        }
        return null;
    }

    /**
     * @param $row
     * @return null|Visitor
     * @throws SystemException
     */
    private static function populateVisitor($row) {
        if($row === false || null === $row) {
            return null;
        }
        $visitor = Visitor::createVisitor($row[self::ID], $row[self::FB_ID], $row[self::FIRST_NAME], $row[self::LAST_NAME], $row[self::EMAIL], $row[self::USER_STATUS], $row[self::INSERTION_DATE], $row[self::LAST_LOGIN_DATE]);
        return $visitor;
    }
}