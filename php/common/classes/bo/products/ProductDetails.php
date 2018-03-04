<?php

class ProductDetails {
    private $ID;
    private $product_id;
    private $sequence;
    private $description;
    private $product_category_id;
    private $secondary_product_category_id;
    private $price;
    private $offer_price;
    private $image_path;
    private $image;
    private $promoted;
    private $promoted_from;
    private $promoted_to;
    private $promotion_text;
    private $promotion_activation;

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
    public function getSequence() {
        return $this->sequence;
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
     * @return mixed
     */
    public function getPromoted() {
        return $this->promoted;
    }

    /**
     * @return mixed
     */
    public function getPromotedFrom() {
        return $this->promoted_from;
    }

    /**
     * @return mixed
     */
    public function getPromotedTo() {
        return $this->promoted_to;
    }

    /**
     * @return mixed
     */
    public function getPromotionText() {
        return $this->promotion_text;
    }

    /**
     * @return mixed
     */
    public function getPromotionActivation() {
        return $this->promotion_activation;
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
     * @param mixed $sequence
     * @return ProductDetails
     */
    public function setSequence($sequence) {
        $this->sequence = $sequence;
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
     * @param mixed $promoted
     * @return ProductDetails
     */
    public function setPromoted($promoted) {
        $this->promoted = $promoted;
        return $this;
    }

    /**
     * @param mixed $promoted_from
     * @return ProductDetails
     */
    public function setPromotedFrom($promoted_from) {
        $this->promoted_from = $promoted_from;
        return $this;
    }

    /**
     * @param mixed $promoted_to
     * @return ProductDetails
     */
    public function setPromotedTo($promoted_to) {
        $this->promoted_to = $promoted_to;
        return $this;
    }

    /**
     * @param mixed $promotion_text
     * @return ProductDetails
     */
    public function setPromotionText($promotion_text) {
        $this->promotion_text = $promotion_text;
        return $this;
    }

    /**
     * @param mixed $promotion_activation
     * @return ProductDetails
     */
    public function setPromotionActivation($promotion_activation) {
        $this->promotion_activation = $promotion_activation;
        return $this;
    }

    /**
     * @return $this
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    public static function createProductDetails($ID, $product_id, $sequence, $description, $product_category_id, $secondary_product_category_id, $price, $offer_price, $image_path, $image, $promoted, $promoted_from, $promoted_to, $promotion_text, $promotion_activation) {
        return self::create()
            ->setID($ID)
            ->setProductId($product_id)
            ->setSequence($sequence)
            ->setDescription($description)
            ->setProductCategoryId($product_category_id)
            ->setSecondaryProductCategoryId($secondary_product_category_id)
            ->setPrice($price)
            ->setOfferPrice($offer_price)
            ->setImagePath($image_path)
            ->setImage($image)
            ->setPromoted($promoted)
            ->setPromotedFrom($promoted_from != null ? date(ADMIN_DATE_FORMAT, strtotime($promoted_from)) : null)
            ->setPromotedTo($promoted_to != null ? date(ADMIN_DATE_FORMAT, strtotime($promoted_to)) : null)
            ->setPromotionText($promotion_text)
            ->setPromotionActivation($promotion_activation);
    }
}

?>