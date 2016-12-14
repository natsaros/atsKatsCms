<?php

class Db {
    // The database connection
    protected static $connection;

    private static $instance;

    private $initialized;

    var $global_tables = array('settings', 'users', 'user_meta', 'pages', 'page_meta');

    var $blog_tables = array('posts', 'post_meta', 'comments', 'comment_meta');

    var $prefix;

    public $settings;
    public $users;
    public $user_meta;
    public $pages;
    public $page_meta;
    public $posts;
    public $post_meta;
    public $comments;
    public $comment_meta;

    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function connect() {

        // Try and connect to the database, if a connection has not been established yet
        if(!isset(self::$connection)) {
            self::$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
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

    public function query($query) {
        // Connect to the database
        $connection = $this->connect();
        if($connection == mysqli_connect_error()) {
            return $this->db_error();
        }
        // Query the database
        return $connection->query($query);
    }

    function select($query) {
        $rows = array();
        $result = $this->query($query);
        // If query failed, return `false`
        if($result === false) {
            return false;
        }

        // If query was successful, retrieve all the rows into an array
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    function db_quote($value) {
        $connection = $this->connect();
        return "'" . $connection->real_escape_string($value) . "'";
    }

    function db_error() {
        $connection = $this->connect();
        return $connection->error;
    }

    function setPrefix($prefix, $set_table_names = true) {
        if(preg_match('|[^a-z0-9_]|i', $prefix))
//            return new AK_Error('invalid_db_prefix', 'Invalid database prefix');
            return;

        $this->prefix = $prefix;

        if($set_table_names) {
            foreach($this->tables('all') as $table => $prefixed_table) {
                $this->$prefixed_table = $prefix . $prefixed_table;
            }
        }
    }

    function tables($scope = 'all') {
        switch($scope) {
            case 'all':
                $tables = array_merge($this->global_tables, $this->blog_tables);
                break;
            case 'global':
                $tables = $this->global_tables;
                break;
            case 'blog':
                $tables = $this->blog_tables;
                break;
            default :
                return array();
        }
        return $tables;
    }

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

    public function isInitialized() {
        if($this->initialized == null || !$this->initialized) {
            $this->setPrefix(TABLE_PREFIX);

            $rows = $this->select("SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = '" . DB_NAME . "'");
            if($rows === false) {
                return false;
            }

            $tableNames = null;
            foreach($rows as $row) {
                $tableNames[] = $row['TABLE_NAME'];
            }
            $this->initialized = in_array($this->settings, $tableNames);
        }
        return $this->initialized;
    }
}

?>