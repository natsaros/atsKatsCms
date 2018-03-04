<?php

/*
 * Removed image store to db due to performance reasons.
 * Maybe will be added in the future but zipped
 */

class ProductCategory {
    private $ID;
    private $title;
    private $friendly_title;
    private $description;
    private $image_path;
    private $image;
    private $parent_category;
    private $parent_category_id;
    private $children_categories;
    private $activation_date;
    private $modification_date;
    private $state;
    private $user_id;

    /**
     * ProductCategory constructor.
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
    public function getTitle() {
        return $this->title;
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
    public function getDescription() {
        return $this->description;
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
    public function getParentCategory() {
        return $this->parent_category;
    }

    /**
     * @return mixed
     */
    public function getParentCategoryId() {
        return $this->parent_category_id;
    }

    /**
     * @return mixed
     */
    public function getChildrenCategories() {
        return $this->children_categories;
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
     * @param mixed $ID
     * @return ProductCategory
     */
    public function setID($ID) {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @param mixed $title
     * @return ProductCategory
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @param $friendly_title
     * @return ProductCategory
     */
    public function setFriendlyTitle($friendly_title) {
        $this->friendly_title = $friendly_title;
        return $this;
    }

    /**
     * @param mixed $description
     * @return ProductCategory
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @param mixed $image_path
     * @return ProductCategory
     */
    public function setImagePath($image_path) {
        $this->image_path = $image_path;
        return $this;
    }

    /**
     * @param mixed $image
     * @return ProductCategory
     */
    public function setImage($image) {
        $this->image = $image;
        return $this;
    }

    /**
     * @param mixed $parent_category
     * @return ProductCategory
     */
    public function setParentCategory($parent_category) {
        $this->parent_category = $parent_category;
        return $this;
    }

    /**
     * @param mixed $parent_category_id
     * @return ProductCategory
     */
    public function setParentCategoryId($parent_category_id) {
        $this->parent_category_id = $parent_category_id;
        return $this;
    }

    /**
     * @param mixed $children_categories
     * @return ProductCategory
     */
    public function setChildrenCategories($children_categories) {
        $this->children_categories = $children_categories;
        return $this;
    }

    /**
     * @param mixed $activation_date
     * @return ProductCategory
     */
    public function setActivationDate($activation_date) {
        $this->activation_date = $activation_date;
        return $this;
    }

    /**
     * @param mixed $modification_date
     * @return ProductCategory
     */
    public function setModificationDate($modification_date) {
        $this->modification_date = $modification_date;
        return $this;
    }

    /**
     * @param mixed $state
     * @return ProductCategory
     */
    public function setState($state) {
        $this->state = $state;
        return $this;
    }

    /**
     * @param mixed $user_id
     * @return ProductCategory
     */
    public function setUserId($user_id) {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return $this
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    public static function createProductCategory($ID, $title, $friendly_title, $description, $image_path, $image, $parent_category, $parent_category_id, $activation_date, $modification_date, $state, $user_id) {
        return self::create()
            ->setID($ID)
            ->setTitle($title)
            ->setFriendlyTitle($friendly_title)
            ->setDescription($description)
            ->setImagePath($image_path)
            ->setImage($image)
            ->setParentCategory($parent_category)
            ->setParentCategoryId($parent_category_id)
            ->setActivationDate($activation_date)
            ->setModificationDate($modification_date)
            ->setState($state)
            ->setUserId($user_id);
    }
}

?>