<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'promotion' . DS . 'Promotion.php');

class PromotionHandler {

    const ID = 'ID';
    const PROMOTED_INSTANCE_TYPE = 'PROMOTED_INSTANCE_TYPE';
    const PROMOTED_INSTANCE_ID = 'PROMOTED_INSTANCE_ID';
    const PROMOTION_TEXT = 'PROMOTION_TEXT';
    const PROMOTED_FROM = 'PROMOTED_FROM';
    const PROMOTED_TO = 'PROMOTED_TO';
    const PROMOTION_ACTIVATION = 'PROMOTION_ACTIVATION';

    /**
     * @return Promotion
     * @throws SystemException
     */
    static function getPromotedInstance() {
        $query = "SELECT * FROM " . getDb()->promotion . " WHERE " . self::PROMOTED_FROM . " <= now() AND " . self::PROMOTED_TO . " >= now() ORDER BY " . self::PROMOTION_ACTIVATION . " DESC LIMIT 1";
        $row = getDb()->selectStmtNoParams($query);
        return self::populatePromotionInstance($row);
    }

    /**
     * @param $promotion Promotion
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function insertPromotedInstance($promotion) {
        if(isNotEmpty($promotion)) {
            $query = "INSERT INTO " . getDb()->promotion . " (" . self::PROMOTED_INSTANCE_TYPE . "," . self::PROMOTED_INSTANCE_ID . "," . self::PROMOTED_FROM . "," . self::PROMOTED_TO . "," . self::PROMOTION_TEXT . "," . self::PROMOTION_ACTIVATION . ") VALUES (?, ?, ?, ?, ?, ?)";
            $createdPromotion = getDb()->createStmt($query, array('s', 's', 's', 's', 's', 's'), array($promotion->getPromotedInstanceType(), $promotion->getPromotedInstanceId(), $promotion->getPromotedFrom(), $promotion->getPromotedTo(), $promotion->getPromotionText(), date(DEFAULT_DATE_FORMAT)));
            return $createdPromotion;
        }
        return null;
    }

    /**
     * @param $row
     * @return null|Promotion
     * @throws SystemException
     */
    private static function populatePromotionInstance($row) {
        if($row === false || null === $row) {
            return null;
        }
        $promotion = Promotion::createPromotion($row[self::ID], $row[self::PROMOTED_INSTANCE_TYPE], $row[self::PROMOTED_INSTANCE_ID], $row[self::PROMOTED_FROM], $row[self::PROMOTED_TO], $row[self::PROMOTION_TEXT], $row[self::PROMOTION_ACTIVATION]);
        return $promotion;
    }
}
