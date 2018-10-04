<?php

class ProductDetails {
    private $ID;
    private $code;
    private $product_id;
    private $description;
    private $description_en;
    private $product_category_id;
    private $secondary_product_category_id;
    private $price;
    private $offer_price;
    private $image_path;
    private $image;

    /**
     * ProductDetails constructor.
     */
    public function __construct() {
        //default constructor
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
    public function getProductId() {
        return $this->product_id;
    }

    /**
     * @return mixed
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getDescriptionEn() {
        return $this->description_en;
    }

    /**
     * @return mixed
     */
    public function getProductCategoryId() {
        return $this->product_category_id;
    }

    /**
     * @return mixed
     */
    public function getSecondaryProductCategoryId() {
        return $this->secondary_product_category_id;
    }

    /**
     * @return mixed
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getOfferPrice() {
        return $this->offer_price;
    }

    /**
     * @return mixed
     */
    public function getImagePath() {
        return $this->image_path;
    }

    /**
     * @return mixed
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @param mixed $ID
     * @return ProductDetails
     */
    public function setID($ID) {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @param mixed $product_id
     * @return ProductDetails
     */
    public function setProductId($product_id) {
        $this->product_id = $product_id;
        return $this;
    }

    /**
     * @param mixed $code
     * @return ProductDetails
     */
    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    /**
     * @param mixed $description
     * @return ProductDetails
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @param mixed $description_en
     * @return ProductDetails
     */
    public function setDescriptionEn($description_en) {
        $this->description_en = $description_en;
        return $this;
    }

    /**
     * @param $product_category_id
     * @return ProductDetails
     */
    public function setProductCategoryId($product_category_id) {
        $this->product_category_id = $product_category_id;
        return $this;
    }

    /**
     * @param $secondary_product_category_id
     * @return ProductDetails
     */
    public function setSecondaryProductCategoryId($secondary_product_category_id) {
        $this->secondary_product_category_id = $secondary_product_category_id;
        return $this;
    }

    /**
     * @param $price
     * @return ProductDetails
     */
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    /**
     * @param $offer_price
     * @return ProductDetails
     */
    public function setOfferPrice($offer_price) {
        $this->offer_price = $offer_price;
        return $this;
    }

    /**
     * @param mixed $image_path
     * @return ProductDetails
     */
    public function setImagePath($image_path) {
        $this->image_path = $image_path;
        return $this;
    }

    /**
     * @param mixed $image
     * @return ProductDetails
     */
    public function setImage($image) {
        $this->image = $image;
        return $this;
    }

    /**
     * @return $this
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    public static function createProductDetails($ID, $product_id, $code, $description, $description_en, $product_category_id, $secondary_product_category_id, $price, $offer_price, $image_path, $image) {
        return self::create()
            ->setID($ID)
            ->setProductId($product_id)
            ->setCode($code)
            ->setDescription($description)
            ->setDescriptionEn($description_en)
            ->setProductCategoryId($product_category_id)
            ->setSecondaryProductCategoryId($secondary_product_category_id)
            ->setPrice($price)
            ->setOfferPrice($offer_price)
            ->setImagePath($image_path)
            ->setImage($image);
    }
}
