<?php
$config = parse_ini_file(getcwd() . DS . 'conf/config.ini');
if($config) {
    // ** MySQL settings - You can get this info from your web host ** //
    /** The name of the database for WordPress */
    define('DB_NAME', $config['dbname']);

    /** MySQL database username */
    define('DB_USER', $config['username']);

    /** MySQL database password */
    define('DB_PASSWORD', $config['password']);

    /** MySQL hostname */
    define('DB_HOST', $config['host']);

    /** Database Charset to use in creating database tables. */
    define('DB_CHARSET', 'utf8');

    /** The Database Collate type. Don't change this if in doubt. */
    define('DB_COLLATE', '');

    define('TABLE_PREFIX', $config['table_prefix']);

    define('ALLOWED_TYPES', $config['allowed_types']);

    $log_file = $config['log_file'];
    if(isEmpty($log_file)) {
        $log_file = 'error_log';
    }
    define('CONF_LOG_FILE', $log_file . '.txt');

} else {
    $die = sprintf(
            "There doesn't seem to be a %s file. I need this before we can get started.",
            '<code>config.ini</code>'
        ) . '</p>';

    echo $die;
    die();
}

?>