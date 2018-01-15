<?php 
define('DEBUG', true);
require "../vendor/autoload.php";
use PHPRouter\RouteCollection;
use PHPRouter\Router;
use PHPRouter\Route;
use PHPRouter\Config;

if (!file_exists('../config/settings.json') && $_SERVER['REQUEST_URI']!='/install') {
    $_SERVER['REQUEST_URI']='/install';
    header('location:/install');
}
if ($_SERVER['REQUEST_URI']=='/install') {
    include('../install/index.php');
} else {
    $config=json_decode(file_get_contents('../config/settings.json'));
    date_default_timezone_set($config->company->timezone);
    if (!session_id()) {
        @session_start();
    }
    define("LOCALE", $config->company->locale);
    require('../App/Locales/'.LOCALE.'.php');
    define('TEXT', $txt);
    define("PROJECTPATH", dirname(__DIR__));
    define("APPPATH", PROJECTPATH . '/App');
    define("DOMAIN", $config->company->domain.':'.$config->company->port);
    define("VERIFICATION_PATH", DOMAIN."/employees/verify/");
    define("REGISTRATION_PATH", DOMAIN."/employees/register/");
    define("COMPANY_NAME", $config->company->name);
    define("COMPANY_ID", '18600913');
    $config = Config::loadFromFile(PROJECTPATH.'/config/routes.yaml');
    $router = Router::parseConfig($config);

    ActiveRecord\Config::initialize(function ($cfg) {
        $config=json_decode(file_get_contents('../config/settings.json'));
        $cfg->set_connections(array(
    'development' => 'mysql://'.$config->database->user.':'.$config->database->password.'@'.$config->database->host.'/'.$config->database->preffix.'biometric;charset=utf8'));
    });
    if (DEBUG==false) {
        try {
            $router->matchCurrentRequest();
        } catch (Exception $e) {
            echo 'Se ha producido un error en la aplicación';
        }
    } else {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
        $router->matchCurrentRequest();
    }
}
