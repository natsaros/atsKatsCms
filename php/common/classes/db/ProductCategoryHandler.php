<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'productCategories' . DS . 'ProductCategory.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'productCategories' . DS . 'ProductCategoryStatus.php');

class ProductCategoryHandler {
    const ID = 'ID';
    const TITLE = 'TITLE';
    const TITLE_EN = 'TITLE_EN';
    const FRIENDLY_TITLE = 'FRIENDLY_TITLE';
    const DESCRIPTION = 'DESCRIPTION';
    const DESCRIPTION_EN = 'DESCRIPTION_EN';
    const ACTIVATION_DATE = 'ACTIVATION_DATE';
    const MODIFICATION_DATE = 'MODIFICATION_DATE';
    const STATE = 'STATE';
    const USER_ID = 'USER_ID';
    const USER_STATUS = 'USER_STATUS';
    const SEQUENCE = 'SEQUENCE';
    const IMAGE_PATH = 'IMAGE_PATH';
    const IMAGE = 'IMAGE';
    const PARENT_CATEGORY = 'PARENT_CATEGORY';
    const PARENT_CATEGORY_ID = 'PARENT_CATEGORY_ID';

    /**
     * @return ProductCategory[]|bool
     * @throws SystemException
     */
    static function fetchAllProductCategories() {
        $query = "SELECT * FROM " . getDb()->product_categories;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateProductCategories($rows);
    }

    /**
     * @return ProductCategory[]|bool
     * @throws SystemException
     */
    static function fetchAllActiveProductCategories() {
        $query = "SELECT * FROM " . getDb()->product_categories . " WHERE " . self::STATE . " = " . ProductCategoryStatus::ACTIVE;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateProductCategories($rows);
    }

    /**
     * @return ProductCategory[]|bool
     * @throws SystemException
     */
    static function fetchAllProductCategoriesForAdmin() {
        $query = "SELECT * FROM " . getDb()->product_categories;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateProductCategories($rows);
    }

    /**
     * @param $parent_category_id
     * @return ProductCategory[]|bool
     * @throws SystemException
     */
    static function fetchAllActiveChildrenProductCategories($parent_category_id) {
        $query = "SELECT * FROM " . getDb()->product_categories . " WHERE " . self::STATE . " = " . ProductCategoryStatus::ACTIVE . " AND " . self::PARENT_CATEGORY_ID . " = ?";
        $rows = getDb()->selectStmt($query, array('i'), array($parent_category_id));
        return self::populateProductCategories($rows);
    }

    /**
     * @return ProductCategory[]|bool
     * @throws SystemException
     */
    static function fetchAllActiveParentProductCategories() {
        $query = "SELECT * FROM " . getDb()->product_categories . " WHERE " . self::STATE . " = " . ProductCategoryStatus::ACTIVE . " AND " . self::PARENT_CATEGORY . " = 1";
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateProductCategories($rows);
    }

    /**
     * @return ProductCategory[]|bool
     * @throws SystemException
     */
    static function fetchAllActiveParentProductCategoriesForMenu() {
        $query = "SELECT * FROM " . getDb()->product_categories . " WHERE " . self::STATE . " = " . ProductCategoryStatus::ACTIVE . " AND " . self::PARENT_CATEGORY . " = 1 LIMIT 6"; //up to 6 collections to be displayed
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateProductCategories($rows);
    }

    /**
     * @return ProductCategory[]|bool
     * @throws SystemException
     */
    static function fetchAllParentProductCategories() {
        $query = "SELECT * FROM " . getDb()->product_categories . " WHERE " . self::PARENT_CATEGORY . " = 1";
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateProductCategories($rows);
    }

    /**
     * @param $id
     * @return ProductCategory
     * @throws SystemException
     */
    static function getProductCategoryByID($id) {
        $query = "SELECT * FROM " . getDb()->product_categories . " WHERE " . self::ID . " = ?";
        $row = getDb()->selectStmtSingle($query, array('i'), array($id));
        return self::populateProductCategory($row);
    }

    /**
     * @param $friendly_title
     * @return ProductCategory
     * @throws SystemException
     */
    static function getProductCategoryByFriendlyTitle($friendly_title) {
        $query = "SELECT * FROM " . getDb()->product_categories . " WHERE " . self::FRIENDLY_TITLE . " = ?";
        $row = getDb()->selectStmtSingle($query, array('s'), array($friendly_title));
        return self::populateProductCategory($row);
    }

    /**
     * @param $productCategory ProductCategory
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function createProductCategory($productCategory) {
        if(isNotEmpty($productCategory)) {
            $query = "INSERT INTO " . getDb()->product_categories . " (" . self::TITLE . "," . self::TITLE_EN . "," . self::FRIENDLY_TITLE . "," . self::DESCRIPTION . "," . self::DESCRIPTION_EN . "," . self::IMAGE. "," . self::IMAGE_PATH . "," . self::PARENT_CATEGORY . "," . self::PARENT_CATEGORY_ID . "," . self::STATE . "," . self::USER_ID . "," . self::ACTIVATION_DATE . ") VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $createdProductCategory = getDb()->createStmt($query, array('s', 's', 's', 's', 's', 's', 's', 'i', 'i', 'i', 's', 's'), array($productCategory->getTitle(), $productCategory->getTitleEn(), $productCategory->getFriendlyTitle(), $productCategory->getDescription(), $productCategory->getDescriptionEn(), '', $productCategory->getImagePath(), $productCategory->getParentCategory(), $productCategory->getParentCategoryId(), ProductCategoryStatus::ACTIVE, $productCategory->getUserId(), date(DEFAULT_DATE_FORMAT)));
            return $createdProductCategory;
        }
        return null;
    }

    /**
     * @param $productCategory ProductCategory
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function update($productCategory) {
        $query = "UPDATE " . getDb()->product_categories . " SET " . self::TITLE . " = ?, " . self::TITLE_EN . " = ?, " . self::FRIENDLY_TITLE . " = ?, " . self::DESCRIPTION . " = ?, " . self::DESCRIPTION_EN . " = ?, " . self::IMAGE . " = ?, " . self::IMAGE_PATH . " = ?, " . self::PARENT_CATEGORY . " = ?, " . self::PARENT_CATEGORY_ID . " = ?, " . self::STATE . " = ?, " . self::USER_ID . " = ?, " . self::ID . " = LAST_INSERT_ID(" . $productCategory->getID() . ") WHERE " . self::ID . " = ?;";
        $updatedRes = getDb()->updateStmt($query,
            array('s', 's', 's', 's', 's', 's', 's', 's', 'i', 'i', 'i', 'i'),
            array($productCategory->getTitle(), $productCategory->getTitleEn(), $productCategory->getFriendlyTitle(), $productCategory->getDescription(), $productCategory->getDescriptionEn(), $productCategory->getImage(), $productCategory->getImagePath(), $productCategory->getParentCategory(), $productCategory->getParentCategoryId(), $productCategory->getState(), $productCategory->getUserId(), $productCategory->getID()));
        return $updatedRes;
    }

    /**
     * @param $id
     * @param $status
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function updateProductCategoryStatus($id, $status) {
        if(isNotEmpty($id)) {
            $query = "UPDATE " . getDb()->product_categories . " SET " . self::STATE . " = ? WHERE " . self::ID . " = ?";
            return getDb()->updateStmt($query, array('i', 'i'), array($status, $id));
        }
        return null;
    }

    /**
     * @param $id
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function deleteProductCategory($id) {
        if(isNotEmpty($id)) {
            $query = "DELETE FROM " . getDb()->product_categories . " WHERE " . self::ID . " = ?";
            $res = getDb()->deleteStmt($query, array('i'), array($id));
            return $res;
        }
        return null;
    }


    /*Populate Functions*/

    /**
     * @param $rows
     * @return ProductCategory[]|bool
     * @throws SystemException
     */
    private static function populateProductCategories($rows) {
        if($rows === false) {
            return false;
        }

        $productCategories = [];

        foreach($rows as $row) {
            $productCategories[] = self::populateProductCategory($row);
        }

        return $productCategories;
    }

    /**
     * @param $row
     * @return null|ProductCategory
     * @throws SystemException
     */
    private static function populateProductCategory($row) {
        if($row === false || null === $row) {
            return null;
        }
        $productCategory = ProductCategory::createProductCategory($row[self::ID], $row[self::TITLE], $row[self::TITLE_EN], $row[self::FRIENDLY_TITLE], $row[self::DESCRIPTION], $row[self::DESCRIPTION_EN], $row[self::IMAGE_PATH], $row[self::IMAGE], $row[self::PARENT_CATEGORY], $row[self::PARENT_CATEGORY_ID], $row[self::ACTIVATION_DATE], $row[self::MODIFICATION_DATE], $row[self::STATE], $row[self::USER_ID]);
        if ($productCategory->getParentCategory() == 1){
            $childrenProductCategories = self::fetchAllActiveChildrenProductCategories($productCategory->getID());
            $productCategory->setChildrenCategories($childrenProductCategories);
        }
        return $productCategory;
    }
}

?>