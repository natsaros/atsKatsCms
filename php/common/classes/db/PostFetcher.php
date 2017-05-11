<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'Post.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'PostDetails.php');

class PostFetcher {
    const ID = 'ID';
    const POST_ID = 'POST_ID';
    const TITLE = 'TITLE';
    const ACTIVATION_DATE = 'ACTIVATION_DATE';
    const MODIFICATION_DATE = 'MODIFICATION_DATE';
    const STATE = 'STATE';
    const USER_ID = 'USER_ID';
    const USER_STATUS = 'USER_STATUS';
    const SEQUENCE = 'SEQUENCE';
    const TEXT = 'TEXT';
    const IMAGE_PATH = 'IMAGE_PATH';
    const IMAGE = 'IMAGE';

    /**
     * @return array|bool
     * @throws SystemException
     */
    static function fetchAllPosts() {
        $query = "SELECT * FROM " . getDb()->posts;
        $rows = getDb()->select($query);
        return self::populatePosts($rows, false);
    }

    /**
     * @return array|bool
     * @throws SystemException
     */
    static function fetchAllPostsWithDetails() {
        $query = "SELECT * FROM " . getDb()->posts;
        $rows = getDb()->select($query);
        return self::populatePosts($rows, true);
    }

    /**
     * @param $id
     * @return Post
     * @throws SystemException
     */
    static function getPostByID($id) {
        $query = "SELECT * FROM " . getDb()->posts . " WHERE " . self::ID . " = '%s'";
        $query = sprintf($query, $id);
        $row = getDb()->select($query);
        return self::populatePost($row);
    }

    /**
     * @param $id
     * @return Post
     * @throws SystemException
     */
    static function getPostByIDWithDetails($id) {
        $post = self::getPostByID($id);
        $post->setPostDetails(self::getPostDetailsById($id));
        return $post;
    }

    /**
     * @param $id
     * @return PostDetails
     * @throws SystemException
     */
    static function getPostDetailsById($id) {
        $detailQuery = "SELECT * FROM " . getDb()->post_meta . " WHERE " . self::ID . " = '%d'";
        $detailQuery = sprintf($detailQuery, $id);
        $postDetailsRow = getDb()->select($detailQuery);
        return self::populatePostDetails($postDetailsRow);
    }

    /**
     * @param $rows
     * @param $withDetails
     * @return Post[]|bool
     * @throws SystemException
     */
    private static function populatePosts($rows, $withDetails) {
        if($rows === false) {
            return false;
        }

        $posts = [];

        foreach($rows as $row) {
            if($withDetails) {
                $ID = $row[self::ID];
                $postDetails = self::getPostDetailsById($ID);
                $posts[] = self::populatePostWithDetails($row, $postDetails);
            } else {
                $posts[] = self::populatePost($row);
            }
        }

        return $posts;
    }

    /**
     * @param $row
     * @param PostDetails $postDetails
     * @return bool|Post
     * @throws SystemException
     */
    private static function populatePostWithDetails($row, $postDetails) {
        if($row === false) {
            return false;
        }
        $post = self::populatePost($row);
        $post->setPostDetails($postDetails);
        return $post;
    }

    /**
     * @param $row
     * @return bool|Post
     * @throws SystemException
     */
    private static function populatePost($row) {
        if($row === false) {
            return false;
        }
        $post = Post::createPost($row[self::ID], $row[self::TITLE], $row[self::ACTIVATION_DATE], $row[self::MODIFICATION_DATE], $row[self::STATE], $row[self::USER_ID]);
        return $post;
    }

    /**
     * @param $row
     * @return bool|PostDetails
     * @throws SystemException
     */
    private static function populatePostDetails($row) {
        if($row === false) {
            return false;
        }
        $postDetails = PostDetails::createPostDetails($row[self::ID], $row[self::POST_ID], $row[self::SEQUENCE], $row[self::TEXT], $row[self::IMAGE_PATH], $row[self::IMAGE]);
        return $postDetails;
    }

}

?>