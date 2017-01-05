<?php

class Db {

    const SETTINGS = 'settings';
    const USERS = 'users';
    const USER_META = 'user_meta';
    const PAGES = 'pages';
    const PAGE_META = 'page_meta';
    const POSTS = 'posts';
    const POST_META = 'post_meta';
    const COMMENTS = 'comments';
    const COMMENT_META = 'comment_meta';

    const DB_ALL = 'all';
    const DB_GLOBAL = 'global';
    const DB_BLOG = 'blog';

    // The database connection
    protected static $connection;

    private static $instance;

    private $initialized;

    private static $global_tables = array(self::SETTINGS, self::USERS, self::USER_META, self::PAGES, self::PAGE_META);

    private static $blog_tables = array(self::POSTS, self::POST_META, self::COMMENTS, self::COMMENT_META);

    private $prefix;

    public $settings;
    public $users;
    public $user_meta;
    public $pages;
    public $page_meta;
    public $posts;
    public $post_meta;
    public $comments;
    public $comment_meta;

    /**
     * @return Db
     */
    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return bool|mysqli|string
     */
    private static function connect() {

        // Try and connect to the database, if a connection has not been established yet
        if(!isset(self::$connection)) {
            try {
                self::$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            } catch(SystemException $ex) {
                self::$connection = false;
            }
        }

        // If connection was not successful, handle the error
        if(self::$connection === false) {
            /*$die = sprintf(
                    "There doesn't seem to be a connection to %s database. I need this before we can get started.",
                    DB_NAME
                ) . '</p>';
            echo $die;
            die();*/
            return mysqli_connect_error();
        }
        return self::$connection;
    }

    /**
     * @param $query
     * @return bool|mysqli_result
     * @throws SystemException
     */
    public static function query($query) {
        // Connect to the database
        $connection = self::connect();
        if($connection == mysqli_connect_error()) {
            throw new SystemException(self::db_error());
        }
        // Query the database
        $mysqli_result = $connection->query($query);
        if(!$mysqli_result) {
            throw new SystemException($connection->error);
        }
        return $mysqli_result;
    }

    /**
     * @param $query
     * @return bool|mysqli_result
     * @throws SystemException
     */
    public function update($query) {
        return self::query($query);
    }

    /**
     * @param $query
     * @return array|bool
     * @throws SystemException
     */
    static function select($query) {
        $rows = array();
        $result = self::query($query);
        // If query failed, return `false`
        if($result === false) {
            throw new SystemException(self::db_error());
        }

        // If query was successful, retrieve all the rows into an array
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * @param $value
     * @return string
     */
    static function db_quote($value) {
        $connection = self::connect();
        return "'" . $connection->real_escape_string($value) . "'";
    }

    /**
     * @return string
     */
    static function db_error() {
        $connection = self::connect();
        return $connection->error;
    }

    /**
     * @param $prefix
     */
    public function setPrefix($prefix) {
        $this->prefix = $prefix;
    }

    /**
     * @param $prefix
     * @param bool $set_table_names
     */
    public function setCustomPrefix($prefix, $set_table_names = true) {
        if(preg_match('|[^a-z0-9_]|i', $prefix))
//            return new AK_Error('invalid_db_prefix', 'Invalid database prefix');
            return;

        $this->setPrefix($prefix);

        if($set_table_names) {
            $ALL_TABLES = self::tables(self::DB_ALL);
            foreach($ALL_TABLES as $table => $table2prefix) {
                $updatedTable = $prefix . $table2prefix;
                switch($table2prefix) {
                    case self::SETTINGS:
                        $this->setSettings($updatedTable);
                        break;
                    case self::USERS:
                        $this->setUsers($updatedTable);
                        break;
                    case self::USER_META:
                        $this->setUserMeta($updatedTable);
                        break;
                    case self::PAGES:
                        $this->setPages($updatedTable);
                        break;
                    case self::PAGE_META:
                        $this->setPageMeta($updatedTable);
                        break;
                    case self::POSTS:
                        $this->setPosts($updatedTable);
                        break;
                    case self::POST_META:
                        $this->setPostMeta($updatedTable);
                        break;
                    case self::COMMENTS:
                        $this->setComments($updatedTable);
                        break;
                    case self::COMMENT_META:
                        $this->setCommentMeta($updatedTable);
                        break;
                }
            }
        }
    }

    /**
     * @param string $scope
     * @return array
     */
    static function tables($scope = self::DB_ALL) {
        switch($scope) {
            case self::DB_ALL:
                $tables = array_merge(self::$global_tables, self::$blog_tables);
                break;
            case self::DB_GLOBAL:
                $tables = self::$global_tables;
                break;
            case self::DB_BLOG:
                $tables = self::$global_tables;
                break;
            default :
                return array();
        }
        return $tables;
    }

    /**
     * @return string
     */
    public function db_schema() {

        $auto_increment = 'auto_increment';
        $charset_collate = 'DEFAULT CHARACTER SET ' . DB_CHARSET;
        if(DB_COLLATE != null && DB_COLLATE != '') {
            $charset_collate .= ' COLLATE ' . DB_COLLATE;
        }

        $settings_table_query = "CREATE TABLE $this->settings(
ID bigint(20) unsigned NOT NULL $auto_increment,
skey VARCHAR(250) not null default '',
sValue longtext,
PRIMARY KEY  (ID)
)$charset_collate;";

        $users_table_query = "CREATE TABLE $this->users(
 ID bigint(20) unsigned NOT NULL $auto_increment,
 name VARCHAR(250) not null default '', 
 first_name VARCHAR(250) not null default '',
 last_name VARCHAR(250) not null default '',
 email VARCHAR(100) default '',
 phone VARCHAR(30) default '',
 link VARCHAR(250) default '',
 gender VARCHAR(50) default '',
 picture VARCHAR(250) default '',
 user_status int(11) NOT NULL default '0',
 is_admin int(11) NOT NULL default '0',
 activation_date DATETIME NOT NULL default '0000-00-00 00:00:00',
 modification_date DATETIME,
 PRIMARY KEY (ID)
  )$charset_collate;";

        $user_meta_table_query = "CREATE TABLE $this->user_meta (
  ID bigint(20) unsigned NOT NULL auto_increment,
  user_id bigint(20) unsigned NOT NULL default '0',
  meta_key varchar(255) default NULL,
  meta_value longtext,
  PRIMARY KEY  (ID),
  INDEX user_ind (user_id),
  FOREIGN KEY (user_id)
        REFERENCES $this->users(id)
        ON DELETE CASCADE
) $charset_collate;";

        $global_tables_query = $settings_table_query . $users_table_query . $user_meta_table_query;
        $queries = $global_tables_query;
        return $queries;
    }

    /**
     * @param DB
     * @return bool
     * @throws SystemException
     */
    public static function isInitialized($db) {
        if($db->getInitialized() == null || !$db->getInitialized()) {
            $db->setCustomPrefix(TABLE_PREFIX);

            $rows = self::select("SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = '" . DB_NAME . "'");
            if($rows === false) {
                return false;
            }

            $tableNames = null;
            foreach($rows as $row) {
                $tableNames[] = $row['TABLE_NAME'];
            }
            $db->setInitialized(in_array($db->settings, $tableNames));
        }
        return $db->getInitialized();
    }

    /**
     * @return mixed
     */
    public function getInitialized() {
        return $this->initialized;
    }

    /**
     * @param mixed $initialized
     */
    public function setInitialized($initialized) {
        $this->initialized = $initialized;
    }

    /**
     * @param mixed $settings
     */
    public function setSettings($settings) {
        $this->settings = $settings;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users) {
        $this->users = $users;
    }

    /**
     * @param mixed $comment_meta
     */
    public function setCommentMeta($comment_meta) {
        $this->comment_meta = $comment_meta;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments) {
        $this->comments = $comments;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts) {
        $this->posts = $posts;
    }

    /**
     * @param mixed $post_meta
     */
    public function setPostMeta($post_meta) {
        $this->post_meta = $post_meta;
    }

    /**
     * @param mixed $pages
     */
    public function setPages($pages) {
        $this->pages = $pages;
    }

    /**
     * @param mixed $page_meta
     */
    public function setPageMeta($page_meta) {
        $this->page_meta = $page_meta;
    }

    /**
     * @param mixed $user_meta
     */
    public function setUserMeta($user_meta) {
        $this->user_meta = $user_meta;
    }
}

?>