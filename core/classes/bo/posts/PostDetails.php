<?php

class PostDetails {
    private $ID;
    private $post_id;
    private $sequence;
    private $text;
    private $image_path;
    private $image;

    /**
     * PostDetails constructor.
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
    public function getPostId() {
        return $this->post_id;
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
    public function getText() {
        return $this->text;
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
     * @return PostDetails
     */
    public function setID($ID) {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @param mixed $post_id
     * @return PostDetails
     */
    public function setPostId($post_id) {
        $this->post_id = $post_id;
        return $this;
    }

    /**
     * @param mixed $sequence
     * @return PostDetails
     */
    public function setSequence($sequence) {
        $this->sequence = $sequence;
        return $this;
    }

    /**
     * @param mixed $text
     * @return PostDetails
     */
    public function setText($text) {
        $this->text = $text;
        return $this;
    }

    /**
     * @param mixed $image_path
     * @return PostDetails
     */
    public function setImagePath($image_path) {
        $this->image_path = $image_path;
        return $this;
    }

    /**
     * @param mixed $image
     * @return PostDetails
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

    public static function createPostDetails($ID, $post_id, $sequence, $text, $image_path, $image) {
        return self::create()
            ->setID($ID)
            ->setPostId($post_id)
            ->setSequence($sequence)
            ->setText($text)
            ->setImagePath($image_path)
            ->setImage($image);
    }
}

?>