<?php

class Promotion {
    private $ID;
    private $promoted_instance_type;
    private $promoted_instance_id;
    private $promoted_from;
    private $promoted_to;
    private $promotion_text;
    private $promotion_activation;

    /**
     * Promotion constructor.
     */
    public function __construct() {
        //default constructor
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     * @return Promotion
     */
    public function setID($ID)
    {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPromotedInstanceType()
    {
        return $this->promoted_instance_type;
    }

    /**
     * @param mixed $promoted_instance_type
     * @return Promotion
     */
    public function setPromotedInstanceType($promoted_instance_type)
    {
        $this->promoted_instance_type = $promoted_instance_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPromotedInstanceId()
    {
        return $this->promoted_instance_id;
    }

    /**
     * @param mixed $promoted_instance_id
     * @return Promotion
     */
    public function setPromotedInstanceId($promoted_instance_id)
    {
        $this->promoted_instance_id = $promoted_instance_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPromotedFrom()
    {
        return $this->promoted_from;
    }

    /**
     * @param mixed $promoted_from
     * @return Promotion
     */
    public function setPromotedFrom($promoted_from)
    {
        $this->promoted_from = $promoted_from;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPromotedTo()
    {
        return $this->promoted_to;
    }

    /**
     * @param mixed $promoted_to
     * @return Promotion
     */
    public function setPromotedTo($promoted_to)
    {
        $this->promoted_to = $promoted_to;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPromotionText()
    {
        return $this->promotion_text;
    }

    /**
     * @param mixed $promotion_text
     * @return Promotion
     */
    public function setPromotionText($promotion_text)
    {
        $this->promotion_text = $promotion_text;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPromotionActivation()
    {
        return $this->promotion_activation;
    }

    /**
     * @param mixed $promotion_activation
     * @return Promotion
     */
    public function setPromotionActivation($promotion_activation)
    {
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

    public static function createPromotion($ID, $instance_type, $instance_id, $promoted_from, $promoted_to, $promotion_text, $promotion_activation) {
        return self::create()
            ->setID($ID)
            ->setPromotedInstanceType($instance_type)
            ->setPromotedInstanceId($instance_id)
            ->setPromotedFrom($promoted_from != null ? date(ADMIN_DATE_FORMAT, strtotime($promoted_from)) : null)
            ->setPromotedTo($promoted_to != null ? date(ADMIN_DATE_FORMAT, strtotime($promoted_to)) : null)
            ->setPromotiontext($promotion_text)
            ->setPromotionActivation($promotion_activation);
    }
}
