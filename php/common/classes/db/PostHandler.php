<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'posts' . DS . 'Post.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'posts' . DS . 'PostDetails.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'posts' . DS . 'PostStatus.php');

class PostHandler {
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
        $rows = getDb()->selectMultiple($query);
        return self::populatePosts($rows, false);
    }

    /**
     * @return array|bool
     * @throws SystemException
     */
    static function fetchAllPostsWithDetails() {
        $query = "SELECT * FROM " . getDb()->posts;
        $rows = getDb()->selectMultiple($query);
        return self::populatePosts($rows, true);
    }

    /**
     * @return array|bool
     * @throws SystemException
     */
    static function fetchAllActivePostsWithDetails() {
        $query = "SELECT * FROM " . getDb()->posts . " WHERE " . self::STATE . " = " . PostStatus::PUBLISHED;
        $rows = getDb()->selectMultiple($query);
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
        $detailQuery = "SELECT * FROM " . getDb()->post_meta . " WHERE " . self::POST_ID . " = '%d'";
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
        if ($rows === false) {
            return false;
        }

        $posts = [];

        foreach ($rows as $row) {
            if ($withDetails) {
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
        if ($row === false) {
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
        if ($row === false) {
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
        if ($row === false) {
            return false;
        }
        $postDetails = PostDetails::createPostDetails($row[self::ID], $row[self::POST_ID], $row[self::SEQUENCE], $row[self::TEXT], $row[self::IMAGE_PATH], $row[self::IMAGE]);
        return $postDetails;
    }

    /**
     * @param $post Post
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function createPost($post) {
        if (isNotEmpty($post)) {
            $query = "INSERT INTO " . getDb()->posts .
                " (" . self::TITLE .
                "," . self::STATE .
                "," . self::USER_ID .
                "," . self::ACTIVATION_DATE .
                ") VALUES ('%s' , '%s' , '%s','%s')";
            $query = sprintf($query,
                $post->getTitle(),
                PostStatus::PUBLISHED,
                $post->getUserId(),
                date('Y-m-d H:i:s'));
            $created = getDb()->create($query);
            if ($created) {
                $query = "INSERT INTO " . getDb()->post_meta .
                    " (" . self::TEXT .
                    "," . self::SEQUENCE .
                    "," . self::IMAGE .
                    "," . self::IMAGE_PATH .
                    "," . self::POST_ID .
                    ") VALUES ('%s' , '%s' , '%s' , '%s', '%s')";
                $query = sprintf($query,
                    $post->getText(),
                    $post->getSequence(),
                    $post->getImage(),
                    $post->getImage(),
                    $created);
                $created = getDb()->create($query);
            }
            return $created;
        }
        return null;
    }

    /**
     * @param $post Post
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function update($post) {
        $query = "UPDATE " . getDb()->posts . " SET " . self::TITLE . " = '%s', " . self::STATE . " = '%s', " . self::USER_ID . " = '%s', " . self::ID . " = LAST_INSERT_ID(" . $post->getID() . ") WHERE " . self::ID . " = '%s';";
        $query = sprintf($query,
            $post->getTitle(),
            $post->getState(),
            $post->getUserId(),
            $post->getID());
        $updatedRes = getDb()->update($query);
        if ($updatedRes) {
            $updatedId = getDb()->select("SELECT LAST_INSERT_ID() AS " . self::ID . "");
            $updatedId = $updatedId["" . self::ID . ""];
            $query = "UPDATE " . getDb()->post_meta . " SET " . self::TEXT . " = '%s', " . self::SEQUENCE . " = '%s', " . self::IMAGE_PATH . " = '%s', " . self::IMAGE . " = '%s' WHERE " . self::POST_ID . " = '%s'";
            $query = sprintf($query,
                $post->getText(),
                $post->getSequence(),
                $post->getImagePath(),
                $post->getImage(),
                $updatedId);
            $updatedRes = getDb()->update($query);
        }
        return $updatedRes;
    }

    /**
     * @param $id
     * @param $status
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function updatePostStatus($id, $status) {
        if (isNotEmpty($id)) {
            $query = "UPDATE " . getDb()->posts . " SET " . self::STATE . " = %s WHERE " . self::ID . " = %s";
            $query = sprintf($query, $status, $id);
            return getDb()->update($query);
        }
        return null;
    }

    /**
     * @param $id
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function deletePost($id) {
        if (isNotEmpty($id)) {
            $query = "DELETE FROM " . getDb()->post_meta . " WHERE " . self::POST_ID . " = '%s'";
            $query = sprintf($query, $id);
            $res = getDb()->update($query);
            if ($res) {
                $query = "DELETE FROM " . getDb()->posts . " WHERE " . self::ID . " = '%s'";
                $query = sprintf($query, $id);
                $res = getDb()->update($query);
            }
            return $res;
        }
        return null;
    }
}

?>