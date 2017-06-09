<?php
require_once(CLASSES_ROOT_PATH . 'bo' . DS . 'comments' . DS . 'Comment.php');

class CommentHandler {

    const ID = 'ID';
    const COMMENT = 'COMMENT';
    const DATE = 'DATE';
    const USER_ID = 'USER_ID';
    const POST_ID = 'POST_ID';

    /**
     * @param $postId
     * @return Comment
     * @throws SystemException
     */
    static function getCommentByPostId($postId) {
        $query = "SELECT * FROM " . getDb()->comments . " WHERE " . self::POST_ID . " = ?";
        $rows = getDb()->selectStmt($query, array('i'), array($postId));
        return self::populateComments($rows);
    }

    /**
     * @param $comment Comment
     * @return bool|mysqli_result|null
     * @throws SystemException
     */
    static function createComment($comment) {
        if (isNotEmpty($comment)) {
            $query = "INSERT INTO " . getDb()->comments .
                " (" . self::ID .
                "," . self::DATE .
                "," . self::COMMENT .
                "," . self::USER_ID .
                "," . self::POST_ID .
                ") VALUES (?
                , ?
                , ?
                , ?
                , ?)";

            return getDb()->createStmt($query,
                array('i', 's', 's', 'i', 'i'),
                array($comment->getID(),
                    date(DEFAULT_DATE_FORMAT),
                    $comment->getComment(),
                    $comment->getUserId(),
                    $comment->getPostId()
                ));
        }
        return null;
    }

    /**
     * @param $row
     * @return null|Comment
     * @throws SystemException
     */
    private static function populateComment($row) {
        if($row === false || null === $row) {
            return null;
        }
        $comment = Comment::createComment($row[self::ID], $row[self::COMMENT], $row[self::USER_ID], $row[self::POST_ID], $row[self::DATE]);
        return $comment;
    }

    /**
     * @param $rows
     * @return Comment[]
     * @throws SystemException
     */
    private static function populateComments($rows) {
        if($rows === false) {
            return false;
        }

        $comments = [];

        foreach($rows as $row) {
            $comments[] = self::populateComment($row);
        }

        return $comments;
    }
}