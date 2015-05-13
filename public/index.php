<?php

//Define the WEBROOT
defined('WEBROOT') || define('WEBROOT', 'http://'.$_SERVER['HTTP_HOST'].'/');
defined('APPLICATION_PUBLIC_PATH') || define('APPLICATION_PUBLIC_PATH', realpath(dirname(__FILE__)));
//defined('APPLICATION_PUBLIC_PATH') || define('APPLICATION_PUBLIC_PATH', realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));
defined('APPLICATION_UPLOADS_DIR')
    || define('APPLICATION_UPLOADS_DIR', realpath(dirname(__FILE__) . '/../public/image/uploads'));

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

//Define path to images folder
defined('IMG_PATH')
    || define('IMG_PATH', WEBROOT.'image/');

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();