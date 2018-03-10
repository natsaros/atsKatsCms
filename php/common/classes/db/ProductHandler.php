<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'products' . DS . 'Product.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'products' . DS . 'ProductDetails.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'products' . DS . 'ProductStatus.php');

class ProductHandler {
    const ID = 'ID';
    const PRODUCT_ID = 'PRODUCT_ID';
    const TITLE = 'TITLE';
    const TITLE_EN = 'TITLE_EN';
    const CODE = 'CODE';
    const FRIENDLY_TITLE = 'FRIENDLY_TITLE';
    const ACTIVATION_DATE = 'ACTIVATION_DATE';
    const MODIFICATION_DATE = 'MODIFICATION_DATE';
    const STATE = 'STATE';
    const USER_ID = 'USER_ID';
    const USER_STATUS = 'USER_STATUS';
    const DESCRIPTION = 'DESCRIPTION';
    const DESCRIPTION_EN = 'DESCRIPTION_EN';
    const PRICE = 'PRICE';
    const OFFER_PRICE = 'OFFER_PRICE';
    const IMAGE_PATH = 'IMAGE_PATH';
    const IMAGE = 'IMAGE';
    const PRODUCT_CATEGORY_ID = 'PRODUCT_CATEGORY_ID';
    const SECONDARY_PRODUCT_CATEGORY_ID = 'SECONDARY_PRODUCT_CATEGORY_ID';

    /**
     * @return Product[]|bool
     * @throws SystemException
     */
    static function fetchAllProducts() {
        $query = "SELECT * FROM " . getDb()->products;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateProducts($rows, false);
    }

    /**
     * @return Product[]|bool
     * @throws SystemException
     */
    static function fetchAllProductsWithDetails() {
        $query = "SELECT * FROM " . getDb()->products;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populateProducts($rows, true);
    }

    /**
     * @param $productCategoryId
     * @param $minSelectedPrice
     * @param $maxSelectedPrice
     * @return Product[]|bool
     * @throws SystemException
     */
    static function fetchAllActiveProductsByCriteriaWithDetails($productCategoryId, $minSelectedPrice, $maxSelectedPrice) {
        $query = "SELECT p.*, IF(pd." . self::OFFER_PRICE . " IS NOT NULL AND pd." . self::OFFER_PRICE . " > 0 , pd." . self::OFFER_PRICE . ", pd." . self::PRICE . ") AS PRODUCT_PRICE FROM " . getDb()->products . " p, " . getDB()->product_details . " pd WHERE p." . self::STATE . " = " . ProductStatus::ACTIVE . " AND (pd." . self::PRODUCT_CATEGORY_ID . " = ? OR pd." . self::SECONDARY_PRODUCT_CATEGORY_ID . " = ? OR pd." . self::PRODUCT_CATEGORY_ID . " IN (SELECT ID FROM " . getDb()->product_categories . " WHERE STATE = 1 AND PARENT_CATEGORY_ID = ?)) AND p."  . self::ID . " = pd." . self::PRODUCT_ID. " AND ((pd."  . self::OFFER_PRICE . " IS NOT NULL AND pd."  . self::OFFER_PRICE . " > 0 AND pd." . self::OFFER_PRICE . " >= ? AND pd." .self::OFFER_PRICE . " <= ?) OR ((pd." . self::OFFER_PRICE. " IS NULL OR pd." . self::OFFER_PRICE . " = 0) AND pd." . self::PRICE . " >= ? AND pd." .self::PRICE . " <= ?))";
        $rows = getDb()->selectStmt($query, array('i', 'i', 'i', 'i', 'i', 'i', 'i'), array($productCategoryId, $productCategoryId, $productCategoryId, $minSelectedPrice, $maxSelectedPrice, $minSelectedPrice, $maxSelectedPrice));
        return self::populateProducts($rows, true);
    }

    /**
     * @param $productCategoryId
     * @return bool
     * @throws SystemException
     */
    static function isProductCategoryAssignedToProducts($productCategoryId) {
        $query = "SELECT * FROM " . getDb()->product_details . " WHERE " . self::PRODUCT_CATEGORY_ID . " = ? OR " . self::SECONDARY_PRODUCT_CATEGORY_ID . " = ?";
        $rows = getDb()->selectStmt($query, array('i', 'i'), array($productCategoryId, $productCategoryId));
        return !is_null($rows) && count($rows) > 0;
    }

    /**
     * @param $id
     * @param $title
     * @return bool
     * @throws SystemException
     */
    static function existProductWithTitle($id, $title) {
        if (isNotEmpty($id)){
            $query = "SELECT * FROM " . getDb()->products . " WHERE " . self::TITLE . " = ? AND " . self::ID . " != ?";
            $rows = getDb()->selectStmt($query, array('s', 'i'), array($title, $id));
        } else {
            $query = "SELECT * FROM " . getDb()->products . " WHERE " . self::TITLE . " = ?";
            $rows = getDb()->selectStmt($query, array('s'), array($title));
        }
        return !is_null($rows) && count($rows) > 0;
    }

    /**
     * @param $productCategoryId
     * @return double|bool
     * @throws SystemException
     */
    static function fetchMaxProductPrice($productCategoryId) {
        $query = "SELECT MAX(pp.PRODUCT_PRICE) AS MAX_PRICE FROM (SELECT IF(pd." . self::OFFER_PRICE . " IS NOT NULL AND pd." . self::OFFER_PRICE . " > 0 , pd." . self::OFFER_PRICE . ", pd." . self::PRICE . ") PRODUCT_PRICE FROM " . getDb()->products . " p, " . getDB()->product_details . " pd WHERE p." . self::STATE . " = " . ProductStatus::ACTIVE . " AND (pd." . self::PRODUCT_CATEGORY_ID . " = ? OR pd." . self::SECONDARY_PRODUCT_CATEGORY_ID . " = ? OR pd." . self::PRODUCT_CATEGORY_ID . " IN (SELECT ID FROM " . getDb()->product_categories . " WHERE STATE = 1 AND PARENT_CATEGORY_ID = ?)) AND p."  . self::ID . " = pd." . self::PRODUCT_ID . ") pp";
        $row = getDb()->queryStmt($query, array('i', 'i', 'i'), array($productCategoryId, $productCategoryId, $productCategoryId));
        $row = mysqli_fetch_assoc($row);
        $maxProductPrice = $row['MAX_PRICE'];
        if (false !== strpos($maxProductPrice, '.'))
            $maxProductPrice = rtrim(rtrim($maxProductPrice, '0'), '.');
        return $maxProductPrice;
    }

    /**
     * @param $id
     * @return Product
     * @throws SystemException
     */
    static function getProductByIDWithDetails($id) {
        $product = self::getProductByID($id);
        if (!is_null($product)){
            $product->setProductDetails(self::getProductDetailsById($id));
        }
        return $product;
    }

    /**
     * @param $friendly_title
     * @return Product
     * @throws SystemException
     */
    static function getProductByFriendlyTitleWithDetails($friendly_title) {
        $product = self::getProductByFriendlyTitle($friendly_title);
        if (!is_null($product)){
            $product->setProductDetails(self::getProductDetailsById($product->getID()));
        }
        return $product;
    }

    /**
     * @param $id
     * @return Product
     * @throws SystemException
     */
    static function getProductByID($id) {
        $query = "SELECT * FROM " . getDb()->products . " WHERE " . self::ID . " = ?";
        $row = getDb()->selectStmtSingle($query, array('i'), array($id));
        return self::populateProduct($row);
    }

    /**
     * @param $friendly_title
     * @return Product
     * @throws SystemException
     */
    static function getProductByFriendlyTitle($friendly_title) {
        $query = "SELECT * FROM " . getDb()->products . " WHERE " . self::STATE . " = " . ProductStatus::ACTIVE . " AND ". self::FRIENDLY_TITLE . " = ?";
        $row = getDb()->selectStmtSingle($query, array('s'), array($friendly_title));
        return self::populateProduct($row);
    }

    /**
     * @param $id
     * @return ProductDetails
     * @throws SystemException
     */
    static function getProductDetailsById($id) {
        $detailQuery = "SELECT * FROM " . getDb()->product_details . " WHERE " . self::PRODUCT_ID . " = ?";
        $productDetailsRow = getDb()->selectStmtSingle($detailQuery, array('i'), array($id));
        return self::populateProductDetails($productDetailsRow);
    }

    /**
     * @param $product Product
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function createProduct($product) {
        if(isNotEmpty($product)) {
            $query = "INSERT INTO " . getDb()->products . " (" . self::TITLE . "," . self::TITLE_EN . "," . self::FRIENDLY_TITLE . "," . self::STATE . "," . self::USER_ID . "," . self::ACTIVATION_DATE . ") VALUES (?, ?, ?, ?, ?, ?)";
            $createdProduct = getDb()->createStmt($query, array('s', 's', 's', 'i', 's', 's'), array($product->getTitle(), $product->getTitleEn(), $product->getFriendlyTitle(), ProductStatus::ACTIVE, $product->getUserId(), date(DEFAULT_DATE_FORMAT)));
            if($createdProduct) {
                $query = "INSERT INTO " . getDb()->product_details .
                    " (" . self::CODE .
                    "," . self::DESCRIPTION .
                    "," . self::DESCRIPTION_EN .
                    "," . self::PRODUCT_CATEGORY_ID .
                    "," . self::SECONDARY_PRODUCT_CATEGORY_ID .
                    "," . self::PRICE .
                    "," . self::OFFER_PRICE .
                    "," . self::IMAGE .
                    "," . self::IMAGE_PATH .
                    "," . self::PRODUCT_ID .
                    ") VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $createdProductDetails = getDb()->createStmt($query,
                    array('s', 's', 's', 'i', 'i', 'd', 'd', 's', 's', 'i'),
                    array($product->getCode(), $product->getDescription(), $product->getDescriptionEn(), $product->getProductCategoryId(), $product->getSecondaryProductCategoryId(), $product->getPrice(), $product->getOfferPrice(), '', $product->getImagePath(), $createdProduct));
            }
            return $createdProduct;
        }
        return null;
    }

    /**
     * @param $product Product
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function update($product) {
        $query = "UPDATE " . getDb()->products . " SET " . self::TITLE . " = ?, " . self::TITLE_EN . " = ?, " . self::FRIENDLY_TITLE . " = ?, " . self::STATE . " = ?, " . self::USER_ID . " = ?, " . self::ID . " = LAST_INSERT_ID(" . $product->getID() . ") WHERE " . self::ID . " = ?;";
        $updatedRes = getDb()->updateStmt($query,
            array('s', 's', 's', 's', 'i', 'i'),
            array($product->getTitle(), $product->getTitleEn(), $product->getFriendlyTitle(), $product->getState(), $product->getUserId(), $product->getID()));
        if($updatedRes) {
            $updatedId = getDb()->selectStmtSingleNoParams("SELECT LAST_INSERT_ID() AS " . self::ID . "");
            $updatedId = $updatedId["" . self::ID . ""];
            $query = "UPDATE " . getDb()->product_details . " SET " . self::CODE . " = ?, " . self::DESCRIPTION . " = ?, " . self::DESCRIPTION_EN . " = ?, " .self::PRODUCT_CATEGORY_ID . " = ?, " .self::SECONDARY_PRODUCT_CATEGORY_ID . " = ?, " . self::PRICE . " = ?, " .self::OFFER_PRICE . " = ?, " . self::IMAGE_PATH . " = ?, " . self::IMAGE . " = ? WHERE " . self::PRODUCT_ID . " = ?";
            $updatedRes = getDb()->updateStmt($query,
                array('s', 's', 's', 'i', 'i', 'd', 'd', 's', 's', 'i'),
                array($product->getCode(), $product->getDescription(), $product->getDescriptionEn(), $product->getProductCategoryId(), $product->getSecondaryProductCategoryId(), $product->getPrice(), $product->getOfferPrice(), $product->getImagePath(), '', $updatedId));
        }
        return $updatedRes;
    }

    /**
     * @param $id
     * @param $status
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function updateProductStatus($id, $status) {
        if(isNotEmpty($id)) {
            $query = "UPDATE " . getDb()->products . " SET " . self::STATE . " = ? WHERE " . self::ID . " = ?";
            return getDb()->updateStmt($query, array('i', 'i'), array($status, $id));
        }
        return null;
    }

    /**
     * @param $id
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function deleteProduct($id) {
        if(isNotEmpty($id)) {
            $query = "DELETE FROM " . getDb()->product_details . " WHERE " . self::PRODUCT_ID . " = ?";
            $res = getDb()->deleteStmt($query, array('i'), array($id));
            if($res) {
                $query = "DELETE FROM " . getDb()->products . " WHERE " . self::ID . " = ?";
                $res = getDb()->deleteStmt($query, array('i'), array($id));
            }
            return $res;
        }
        return null;
    }

    /*Populate Functions*/

    /**
     * @param $rows
     * @param $withDetails
     * @return Product[]|bool
     * @throws SystemException
     */
    private static function populateProducts($rows, $withDetails) {
        if($rows === false) {
            return false;
        }

        $products = [];

        foreach($rows as $row) {
            if($withDetails) {
                $ID = $row[self::ID];
                $productDetails = self::getProductDetailsById($ID);
                $products[] = self::populateProductWithDetails($row, $productDetails);
            } else {
                $products[] = self::populateProduct($row);
            }
        }

        return $products;
    }

    /**
     * @param $row
     * @param ProductDetails $productDetails
     * @return null|Product
     * @throws SystemException
     */
    private static function populateProductWithDetails($row, $productDetails) {
        if($row === false || null === $row) {
            return null;
        }
        $product = self::populateProduct($row);
        if($product !== null) {
            $product->setProductDetails($productDetails);
        }
        return $product;
    }

    /**
     * @param $row
     * @return null|Product
     * @throws SystemException
     */
    private static function populateProduct($row) {
        if($row === false || null === $row) {
            return null;
        }
        $product = Product::createProduct($row[self::ID], $row[self::TITLE], $row[self::TITLE_EN], $row[self::FRIENDLY_TITLE], $row[self::ACTIVATION_DATE], $row[self::MODIFICATION_DATE], $row[self::STATE], $row[self::USER_ID]);
        return $product;
    }

    /**
     * @param $row
     * @return null|ProductDetails
     * @throws SystemException
     */
    private static function populateProductDetails($row) {
        if($row === false || null === $row) {
            return null;
        }
        $productDetails = ProductDetails::createProductDetails($row[self::ID], $row[self::PRODUCT_ID], $row[self::CODE], $row[self::DESCRIPTION], $row[self::DESCRIPTION_EN], $row[self::PRODUCT_CATEGORY_ID], $row[self::SECONDARY_PRODUCT_CATEGORY_ID], $row[self::PRICE], $row[self::OFFER_PRICE], $row[self::IMAGE_PATH], $row[self::IMAGE]);
        return $productDetails;
    }
}