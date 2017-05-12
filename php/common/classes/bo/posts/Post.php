<?php

class Post {
    private $ID;
    private $title;
    private $activation_date;
    private $modification_date;
    private $state;
    private $user_id;
    private $postDetails;

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
     * @return PostDetails
     */
    public function getPostDetails() {
        return $this->postDetails;
    }

    /**
     * @return mixed
     */
    public function getText() {
        return isNotEmpty($this->getPostDetails()) ? $this->getPostDetails()->getText() : null;
    }

    /**
     * @return mixed
     */
    public function getImage() {
        return isNotEmpty($this->getPostDetails()) ? $this->getPostDetails()->getImage() : null;
    }

    /**
     * @return mixed
     */
    public function getImagePath() {
        return isNotEmpty($this->getPostDetails()) ? $this->getPostDetails()->getImagePath() : null;
    }

    /**
     * @return mixed
     */
    public function getSequence() {
        return isNotEmpty($this->getPostDetails()) ? $this->getPostDetails()->getSequence() : null;
    }

    /**
     * @param mixed $ID
     * @return Post
     */
    public function setID($ID) {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @param mixed $title
     * @return Post
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @param mixed $activation_date
     * @return Post
     */
    public function setActivationDate($activation_date) {
        $this->activation_date = $activation_date;
        return $this;
    }

    /**
     * @param mixed $modification_date
     * @return Post
     */
    public function setModificationDate($modification_date) {
        $this->modification_date = $modification_date;
        return $this;
    }

    /**
     * @param mixed $state
     * @return Post
     */
    public function setState($state) {
        $this->state = $state;
        return $this;
    }

    /**
     * @param mixed $user_id
     * @return Post
     */
    public function setUserId($user_id) {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @param PostDetails $postDetails
     * @return Post
     */
    public function setPostDetails($postDetails) {
        $this->postDetails = $postDetails;
        return $this;
    }

    public function setText($text) {
        if(isNotEmpty($this->getPostDetails())) {
            $this->getPostDetails()->setText($text);
        }
    }

    /**
     * @return $this
     */
    public static function create() {
        $instance = new self();
        $instance->setPostDetails(PostDetails::create());
        return $instance;
    }

    public static function createPost($ID, $title, $activation_date, $modification_date, $state, $user_id) {
        return self::create()
            ->setID($ID)
            ->setTitle($title)
            ->setActivationDate($activation_date)
            ->setModificationDate($modification_date)
            ->setState($state)
            ->setUserId($user_id);
    }

    public static function createSimplePost($ID, $title, $state, $user_id) {
        return self::create()
            ->setID($ID)
            ->setTitle($title)
            ->setState($state)
            ->setUserId($user_id)
            ->setPostDetails(PostDetails::create());
    }
}

?>