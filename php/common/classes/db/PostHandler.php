<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'posts' . DS . 'Post.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'posts' . DS . 'PostDetails.php');
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'posts' . DS . 'PostStatus.php');

class PostHandler {
    const ID = 'ID';
    const POST_ID = 'POST_ID';
    const TITLE = 'TITLE';
    const FRIENDLY_TITLE = 'FRIENDLY_TITLE';
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
     * @return Post[]|bool
     * @throws SystemException
     */
    static function fetchAllPosts() {
        $query = "SELECT * FROM " . getDb()->posts;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populatePosts($rows, false);
    }

    /**
     * @return Post[]|bool
     * @throws SystemException
     */
    static function fetchAllPostsWithDetails() {
        $query = "SELECT * FROM " . getDb()->posts;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populatePosts($rows, true);
    }

    /**
     * @return Post[]|bool
     * @throws SystemException
     */
    static function fetchAllActivePostsWithDetails() {
        $query = "SELECT * FROM " . getDb()->posts . " WHERE " . self::STATE . " = " . PostStatus::PUBLISHED;
        $rows = getDb()->selectStmtNoParams($query);
        return self::populatePosts($rows, true);
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
     * @param $friendly_title
     * @return Post
     * @throws SystemException
     */
    static function getPostByFriendlyTitleWithDetails($friendly_title) {
        $post = self::getPostByFriendlyTitle($friendly_title);
        $post->setPostDetails(self::getPostDetailsById($post->getID()));
        return $post;
    }

    /**
     * @param $id
     * @return Post
     * @throws SystemException
     */
    static function getPostByID($id) {
        $query = "SELECT * FROM " . getDb()->posts . " WHERE " . self::ID . " = ?";
        $row = getDb()->selectStmtSingle($query, array('i'), array($id));
        return self::populatePost($row);
    }

    /**
     * @param $friendly_title
     * @return Post
     * @throws SystemException
     */
    static function getPostByFriendlyTitle($friendly_title) {
        $query = "SELECT * FROM " . getDb()->posts . " WHERE " . self::FRIENDLY_TITLE . " = ?";
        $row = getDb()->selectStmtSingle($query, array('s'), array($friendly_title));
        return self::populatePost($row);
    }

    /**
     * @param $id
     * @return PostDetails
     * @throws SystemException
     */
    static function getPostDetailsById($id) {
        $detailQuery = "SELECT * FROM " . getDb()->post_meta . " WHERE " . self::POST_ID . " = ?";
        $postDetailsRow = getDb()->selectStmtSingle($detailQuery, array('i'), array($id));
        return self::populatePostDetails($postDetailsRow);
    }

    /**
     * @param $post Post
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function createPost($post) {
        if(isNotEmpty($post)) {
            $query = "INSERT INTO " . getDb()->posts . " (" . self::TITLE . "," . self::FRIENDLY_TITLE . "," . self::STATE . "," . self::USER_ID . "," . self::ACTIVATION_DATE . ") VALUES (?, ?, ?, ?, ?)";
            $created = getDb()->createStmt($query, array('s', 's', 'i', 's', 's'), array($post->getTitle(), $post->getFriendlyTitle(), PostStatus::PUBLISHED, $post->getUserId(), date(DEFAULT_DATE_FORMAT)));
            if($created) {
                $query = "INSERT INTO " . getDb()->post_meta .
                    " (" . self::TEXT .
                    "," . self::SEQUENCE .
                    "," . self::IMAGE .
                    "," . self::IMAGE_PATH .
                    "," . self::POST_ID .
                    ") VALUES (?, ?, ?, ?, ?)";

                $created = getDb()->createStmt($query,
                    array('s', 's', 's', 's', 'i'),
                    array($post->getText(), $post->getSequence(), $post->getImagePath(), $post->getImagePath(), $created));
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
        $query = "UPDATE " . getDb()->posts . " SET " . self::TITLE . " = ?, " . self::FRIENDLY_TITLE . " = ?, " . self::STATE . " = ?, " . self::USER_ID . " = ?, " . self::ID . " = LAST_INSERT_ID(" . $post->getID() . ") WHERE " . self::ID . " = ?;";
        $updatedRes = getDb()->updateStmt($query,
            array('s', 's', 's', 'i', 'i'),
            array($post->getTitle(), $post->getFriendlyTitle(), $post->getState(), $post->getUserId(), $post->getID()));
        if($updatedRes) {
            $updatedId = getDb()->selectStmtSingleNoParams("SELECT LAST_INSERT_ID() AS " . self::ID . "");
            $updatedId = $updatedId["" . self::ID . ""];
            $query = "UPDATE " . getDb()->post_meta . " SET " . self::TEXT . " = ?, " . self::SEQUENCE . " = ?, " . self::IMAGE_PATH . " = ?, " . self::IMAGE . " = ? WHERE " . self::POST_ID . " = ?";
            $updatedRes = getDb()->updateStmt($query,
                array('s', 's', 's', 's', 'i'),
                array($post->getText(), $post->getSequence(), $post->getImagePath(), $post->getImage(), $updatedId));
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
        if(isNotEmpty($id)) {
            $query = "UPDATE " . getDb()->posts . " SET " . self::STATE . " = ? WHERE " . self::ID . " = ?";
            return getDb()->updateStmt($query, array('i', 'i'), array($status, $id));
        }
        return null;
    }

    /**
     * @param $id
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    public static function deletePost($id) {
        if(isNotEmpty($id)) {
            $query = "DELETE FROM " . getDb()->post_meta . " WHERE " . self::POST_ID . " = ?";
            $res = getDb()->deleteStmt($query, array('i'), array($id));
            if($res) {
                $query = "DELETE FROM " . getDb()->posts . " WHERE " . self::ID . " = ?";
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
     * @return null|Post
     * @throws SystemException
     */
    private static function populatePostWithDetails($row, $postDetails) {
        if($row === false || null === $row) {
            return null;
        }
        $post = self::populatePost($row);
        if($post !== null) {
            $post->setPostDetails($postDetails);
        }
        return $post;
    }

    /**
     * @param $row
     * @return null|Post
     * @throws SystemException
     */
    private static function populatePost($row) {
        if($row === false || null === $row) {
            return null;
        }
        $post = Post::createPost($row[self::ID], $row[self::TITLE], $row[self::FRIENDLY_TITLE], $row[self::ACTIVATION_DATE], $row[self::MODIFICATION_DATE], $row[self::STATE], $row[self::USER_ID]);
        return $post;
    }

    /**
     * @param $row
     * @return null|PostDetails
     * @throws SystemException
     */
    private static function populatePostDetails($row) {
        if($row === false || null === $row) {
            return null;
        }
        $postDetails = PostDetails::createPostDetails($row[self::ID], $row[self::POST_ID], $row[self::SEQUENCE], $row[self::TEXT], $row[self::IMAGE_PATH], $row[self::IMAGE]);
        return $postDetails;
    }
}

?>