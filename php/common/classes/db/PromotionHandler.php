<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'promotion' . DS . 'Promotion.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'promotion' . DS . 'PromotionInstanceType.php');

class PromotionHandler {

    const ID = 'ID';
    const PROMOTED_INSTANCE_TYPE = 'PROMOTED_INSTANCE_TYPE';
    const PROMOTED_INSTANCE_ID = 'PROMOTED_INSTANCE_ID';
    const PROMOTION_TEXT = 'PROMOTION_TEXT';
    const PROMOTION_TEXT_EN = 'PROMOTION_TEXT_EN';
    const PROMOTION_LINK = 'PROMOTION_LINK';
    const PROMOTED_FROM = 'PROMOTED_FROM';
    const PROMOTED_TO = 'PROMOTED_TO';
    const PROMOTION_ACTIVATION = 'PROMOTION_ACTIVATION';
    const TIMES_SEEN = 'TIMES_SEEN';
    const USER_ID = 'USER_ID';

    /**
     * @return Promotion[]|bool
     * @throws SystemException
     */
    static function getAllPromotions() {
        $query = "SELECT * FROM " . getDb()->promotions;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populatePromotions($rows);
    }

    /**
     * @param $id
     * @return Promotion
     * @throws SystemException
     */
    static function getPromotion($id) {
        $query = "SELECT * FROM " . getDb()->promotions . " WHERE " . self::ID . " = ?";
        $row = getDb()->selectStmtSingle($query, array('i'), array($id));
        return self::populatePromotion($row);
    }

    /**
     * @return Promotion
     * @throws SystemException
     */
    static function getPromotedInstance() {
        $query = "SELECT * FROM " . getDb()->promotions . " WHERE " . self::PROMOTED_FROM . " <= now() AND " . self::PROMOTED_TO . " >= now() ORDER BY " . self::PROMOTION_ACTIVATION . " DESC LIMIT 1";
        $row = getDb()->selectStmtSingleNoParams($query);
        return self::populatePromotion($row);
    }

    /**
     * @param $promotion Promotion
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function insertPromotion($promotion) {
        if(isNotEmpty($promotion)) {
            $query = "INSERT INTO " . getDb()->promotions . " (" . self::PROMOTED_INSTANCE_TYPE . "," . self::PROMOTED_INSTANCE_ID . "," . self::PROMOTED_FROM . "," . self::PROMOTED_TO . "," . self::PROMOTION_TEXT . "," . self::PROMOTION_TEXT_EN . "," . self::PROMOTION_ACTIVATION .  "," . self::USER_ID . "," . self::PROMOTION_LINK . ") VALUES (?, ?, ?, ?,  ?, ?, ?, ?, ?)";
            $createdPromotion = getDb()->createStmt($query, array('i', 'i', 's', 's', 's', 's', 's', 's'), array($promotion->getPromotedInstanceType(), $promotion->getPromotedInstanceId(), $promotion->getPromotedFrom(), $promotion->getPromotedTo(), $promotion->getPromotionText(), $promotion->getPromotionTextEn(), date(DEFAULT_DATE_FORMAT)), $promotion->getUserId(), $promotion->getPromotionLink());
            return $createdPromotion;
        }
        return null;
    }

    /**
     * @param $promotion Promotion
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function update($promotion) {
        $query = "UPDATE " . getDb()->promotions . " SET " . self::PROMOTED_FROM . " = ?, " . self::PROMOTED_TO . " = ?, " . self::PROMOTION_TEXT . " = ?, " . self::PROMOTION_TEXT_EN . " = ?, " . self::PROMOTED_INSTANCE_TYPE . " = ?, " . self::PROMOTED_INSTANCE_ID . " = ?, " . self::PROMOTION_ACTIVATION . " = ?, " . self::PROMOTION_LINK . " = ?, " . self::USER_ID . " = ? WHERE " . self::ID . " = ?";
        $updatedRes = getDb()->updateStmt($query,
            array('s', 's', 's', 's', 'i', 'i', 's', 's', 's', 'i'),
            array($promotion->getPromotedFrom(), $promotion->getPromotedTo(), $promotion->getPromotionText(), $promotion->getPromotionTextEn(), $promotion->getPromotedInstanceType(), $promotion->getPromotedInstanceId(), date(DEFAULT_DATE_FORMAT), $promotion->getPromotionLink(), $promotion->getUserId(), $promotion->getID()));
        return $updatedRes;
    }

    /**
     * @param $id
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function deletePromotion($id) {
        if(isNotEmpty($id)) {
            $query = "DELETE FROM " . getDb()->promotions . " WHERE " . self::ID . " = ?";
            $res = getDb()->deleteStmt($query, array('i'), array($id));
            return $res;
        }
        return null;
    }

    /**
     * @param $row
     * @return null|Promotion
     * @throws SystemException
     */
    private static function populatePromotion($row) {
        if($row === false || null === $row) {
            return null;
        }
        $promotion = Promotion::createPromotion($row[self::ID], $row[self::PROMOTED_INSTANCE_TYPE], $row[self::PROMOTED_INSTANCE_ID], $row[self::PROMOTED_FROM], $row[self::PROMOTED_TO], $row[self::PROMOTION_TEXT], $row[self::PROMOTION_TEXT_EN], $row[self::PROMOTION_ACTIVATION], $row[self::TIMES_SEEN], $row[self::PROMOTION_LINK]);
        if ($promotion->getPromotedInstanceType() == PromotionInstanceType::PRODUCT){
            $promotionInstance = ProductHandler::getProductByIDWithDetails($promotion->getPromotedInstanceId());
        } else if ($promotion->getPromotedInstanceType() == PromotionInstanceType::PRODUCT_CATEGORY){
            $promotionInstance = ProductCategoryHandler::getProductCategoryByID($promotion->getPromotedInstanceId());
        }
        $promotion->setPromotedInstance($promotionInstance);
        return $promotion;
    }

    /**
     * @param $rows
     * @return Promotion[]
     * @throws SystemException
     */
    private static function populatePromotions($rows) {
        if($rows === false) {
            return false;
        }

        $promotions = [];

        foreach($rows as $row) {
            $promotions[] = self::populatePromotion($row);
        }

        return $promotions;
    }

    /**
     * @param $id
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function updateTimesSeen($id) {
        $query = "UPDATE " . getDb()->promotions . " SET " . self::TIMES_SEEN . " = (" . self::TIMES_SEEN . " + 1) WHERE " . self::ID . " = ?";
        $updatedRes = getDb()->updateStmt($query, array('i'), array($id));
        return $updatedRes;
    }
}
