<?php

/*
 * Removed image store to db due to performance reasons.
 * Maybe will be added in the future but zipped
 */

class Product {
    private $ID;
    private $title;
    private $title_en;
    private $friendly_title;
    private $activation_date;
    private $modification_date;
    private $state;
    private $user_id;
    private $productDetails;

    /**
     * Product constructor.
     */
    public function __construct() {
        //default constructor
        $this->setProductDetails(ProductDetails::create());
    }

    /**
     * @return mixed
     */
    public function getID() {
        return $this->ID;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getTitleEn() {
        return $this->title_en;
    }

    /**
     * @return mixed
     */
    public function getLocalizedTitle() {
        return (!isset($_SESSION['locale']) || $_SESSION['locale'] === 'el_GR') ? (isNotEmpty($this->title) ? $this->title : $this->getCode()) : (isNotEmpty($this->title_en) ? $this->title_en : $this->getCode());
    }

    /**
     * @return mixed
     */
    public function getFriendlyTitle() {
        return $this->friendly_title;
    }

    /**
     * @return mixed
     */
    public function getActivationDate() {
        return $this->activation_date;
    }

    /**
     * @return mixed
     */
    public function getModificationDate() {
        return $this->modification_date;
    }

    /**
     * @return mixed
     */
    public function getState() {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * @return ProductDetails
     */
    public function getProductDetails() {
        return $this->productDetails;
    }

    /**
     * @return mixed
     */
    public function getCode() {
        return isNotEmpty($this->getProductDetails()) ? $this->getProductDetails()->getCode() : null;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return isNotEmpty($this->getProductDetails()) ? $this->getProductDetails()->getDescription() : null;
    }

    /**
     * @return mixed
     */
    public function getLocalizedDescription() {
        return isNotEmpty($this->getProductDetails()) ? ((!isset($_SESSION['locale']) || $_SESSION['locale'] === 'el_GR') ? $this->getProductDetails()->getDescription() :  $this->getProductDetails()->getDescriptionEn()) : null;
    }

    /**
     * @return mixed
     */
    public function getDescriptionEn() {
        return isNotEmpty($this->getProductDetails()) ? $this->getProductDetails()->getDescriptionEn() : null;
    }

    /**
     * @return mixed
     */
    public function getProductCategoryId() {
        return isNotEmpty($this->getProductDetails()) ? $this->getProductDetails()->getProductCategoryId() : 0;
    }

    /**
     * @return mixed
     */
    public function getSecondaryProductCategoryId() {
        return isNotEmpty($this->getProductDetails()) ? $this->getProductDetails()->getSecondaryProductCategoryId() : 0;
    }

    /**
     * @return mixed
     */
    public function getPrice() {
        return isNotEmpty($this->getProductDetails()) ? $this->getProductDetails()->getPrice() : 0;
    }

    /**
     * @return mixed
     */
    public function getOfferPrice() {
        return isNotEmpty($this->getProductDetails()) ? $this->getProductDetails()->getOfferPrice() : 0;
    }

    /**
     * @return mixed
     */
    public function getImage() {
        return isNotEmpty($this->getProductDetails()) ? $this->getProductDetails()->getImage() : null;
    }

    /**
     * @return mixed
     */
    public function getImagePath() {
        return isNotEmpty($this->getProductDetails()) ? $this->getProductDetails()->getImagePath() : null;
    }

    /**
     * @param mixed $ID
     * @return Product
     */
    public function setID($ID) {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @param mixed $title
     * @return Product
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @param mixed $title_en
     * @return Product
     */
    public function setTitleEn($title_en) {
        $this->title_en = $title_en;
        return $this;
    }

    /**
     * @param $friendly_title
     * @return Product
     */
    public function setFriendlyTitle($friendly_title) {
        $this->friendly_title = $friendly_title;
        return $this;
    }

    /**
     * @param mixed $activation_date
     * @return Product
     */
    public function setActivationDate($activation_date) {
        $this->activation_date = $activation_date;
        return $this;
    }

    /**
     * @param mixed $modification_date
     * @return Product
     */
    public function setModificationDate($modification_date) {
        $this->modification_date = $modification_date;
        return $this;
    }

    /**
     * @param mixed $state
     * @return Product
     */
    public function setState($state) {
        $this->state = $state;
        return $this;
    }

    /**
     * @param mixed $user_id
     * @return Product
     */
    public function setUserId($user_id) {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @param ProductDetails $productDetails
     * @return Product
     */
    public function setProductDetails($productDetails) {
        $this->productDetails = $productDetails;
        return $this;
    }

    /**
     * @param $text
     * @return $this
     */
    public function setCode($text) {
        if (isNotEmpty($this->getProductDetails())) {
            $this->getProductDetails()->setCode($text);
        }
        return $this;
    }

    /**
     * @param $text
     * @return $this
     */
    public function setDescription($text) {
        if (isNotEmpty($this->getProductDetails())) {
            $this->getProductDetails()->setDescription($text);
        }
        return $this;
    }

    /**
     * @param $text
     * @return $this
     */
    public function setDescriptionEn($text) {
        if (isNotEmpty($this->getProductDetails())) {
            $this->getProductDetails()->setDescriptionEn($text);
        }
        return $this;
    }

    /**
     * @param $product_category_id
     * @return $this
     */
    public function setProductCategoryId($product_category_id) {
        if (isNotEmpty($this->getProductDetails())) {
            $this->getProductDetails()->setProductCategoryId($product_category_id);
        }
        return $this;
    }

    /**
     * @param $secondary_product_category_id
     * @return $this
     */
    public function setSecondaryProductCategoryId($secondary_product_category_id) {
        if (isNotEmpty($this->getProductDetails())) {
            $this->getProductDetails()->setSecondaryProductCategoryId($secondary_product_category_id);
        }
        return $this;
    }

    /**
     * @param $price
     * @return $this
     */
    public function setPrice($price) {
        if (isNotEmpty($this->getProductDetails())) {
            $this->getProductDetails()->setPrice($price);
        }
        return $this;
    }

    /**
     * @param $offer_price
     * @return $this
     */
    public function setOfferPrice($offer_price) {
        if (isNotEmpty($this->getProductDetails())) {
            $this->getProductDetails()->setOfferPrice($offer_price);
        }
        return $this;
    }

    /**
     * @param $path
     * @return $this
     */
    public function setImagePath($path) {
        if (isNotEmpty($this->getProductDetails())) {
            $this->getProductDetails()->setImagePath($path);
        }
        return $this;
    }

    /**
     * @param $image
     * @return $this
     */
    public function setImage($image) {
        if (isNotEmpty($this->getProductDetails())) {
            $this->getProductDetails()->setImage($image);
        }
        return $this;
    }

    /**
     * @return $this
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    public static function createProduct($ID, $title, $title_en, $friendly_title, $activation_date, $modification_date, $state, $user_id) {
        return self::create()
            ->setID($ID)
            ->setTitle($title)
            ->setTitleEn($title_en)
            ->setFriendlyTitle($friendly_title)
            ->setActivationDate($activation_date)
            ->setModificationDate($modification_date)
            ->setState($state)
            ->setUserId($user_id);
    }
}

?>