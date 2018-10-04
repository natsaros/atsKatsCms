<?php
$config = parse_ini_file(getcwd() . DS . 'conf/config.ini');
if($config) {
    // ** MySQL settings - You can get this info from your web host ** //
    /** The name of the database for WordPress */
    defined('DB_NAME') or define('DB_NAME', $config['dbname']);

    /** MySQL database username */
    defined('DB_USER') or define('DB_USER', $config['username']);

    /** MySQL database password */
    defined('DB_PASSWORD') or define('DB_PASSWORD', $config['password']);

    /** MySQL hostname */
    defined('DB_HOST') or define('DB_HOST', $config['host']);

    /** MySQL hostname */
    defined('DB_PORT') or define('DB_PORT', $config['port']);

    /** Database Charset to use in creating database tables. */
    defined('DB_CHARSET') or define('DB_CHARSET', 'utf8');

    /** The Database Collate type. Don't change this if in doubt. */
    defined('DB_COLLATE') or define('DB_COLLATE', '');

    defined('TABLE_PREFIX') or define('TABLE_PREFIX', $config['table_prefix']);

    defined('ALLOWED_TYPES') or define('ALLOWED_TYPES', $config['allowed_types']);
    defined('MAX_IMAGE_WIDTH') or define('MAX_IMAGE_WIDTH', $config['max_image_width']);
    defined('MAX_IMAGE_HEIGHT') or define('MAX_IMAGE_HEIGHT', $config['max_image_height']);

    $log_file = $config['log_file'];
    if(isEmpty($log_file)) {
        $log_file = 'error_log';
    }
    defined('CONF_LOG_FILE') or define('CONF_LOG_FILE', $log_file . '.txt');
    defined('DEV_MODE') or define('DEV_MODE', $config['dev_mode'] === 'true');

    defined('SITE_TITLE') or define('SITE_TITLE', $config['site_title']);
    defined('SITE_DOMAIN_NAME') or define('SITE_DOMAIN_NAME', $config['site_domain_name']);
    defined('DEFAULT_TIME_ZONE') or define('DEFAULT_TIME_ZONE', $config['default_timezone']);

    defined('GM_KEY') or define('GM_KEY', $config['google_maps_api_key']);
    defined('GA_ID') or define('GA_ID', $config['google_analytics_id']);
    defined('GA_REFRESH_TOKEN_URL') or define('GA_REFRESH_TOKEN_URL', $config['google_analytics_refresh_token_url']);
    defined('GA_REFRESH_TOKEN_ID') or define('GA_REFRESH_TOKEN_ID', $config['google_analytics_refresh_token_id']);
    defined('GA_API_PROJECT_CLIENT_ID') or define('GA_API_PROJECT_CLIENT_ID', $config['google_analytics_api_project_client_id']);
    defined('GA_API_PROJECT_CLIENT_SECRET') or define('GA_API_PROJECT_CLIENT_SECRET', $config['google_analytics_api_project_client_secret']);
    defined('GA_API_TOKEN_INFO_URL') or define('GA_API_TOKEN_INFO_URL', $config['google_analytics_api_token_info_url']);
} else {
    $die = sprintf(
            "There doesn't seem to be a %s file. I need this before we can get started.",
            '<code>config.ini</code>'
        ) . '</p>';

    echo $die;
    die();
}