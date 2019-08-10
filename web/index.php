<?php

function require_auth() {
	$AUTH_USER = getenv('AUTH_USER');
	$AUTH_PASS = getenv('AUTH_PASS');
	header('Cache-Control: no-cache, must-revalidate, max-age=0');
	$has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
	$is_not_authenticated = (
		!$has_supplied_credentials ||
		$_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
		$_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
	);
	if ($is_not_authenticated) {
		header('HTTP/1.1 401 Authorization Required');
		header('WWW-Authenticate: Basic realm="Access denied"');
		exit;
	}
}

if(getenv('ENV') == 'Production') {
	if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
		$location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . $location);
		exit;
	}
  require_auth();
  defined('YII_DEBUG') or define('YII_DEBUG', true);
} else {
  defined('YII_DEBUG') or define('YII_DEBUG', true);
  defined('YII_ENV') or define('YII_ENV', 'dev');
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';


$application = new yii\web\Application($config);
$application->on(yii\web\Application::EVENT_BEFORE_REQUEST, function(yii\base\Event $event){
    $event->sender->response->on(yii\web\Response::EVENT_BEFORE_SEND, function($e){
        ob_start("ob_gzhandler");
    });
    $event->sender->response->on(yii\web\Response::EVENT_AFTER_SEND, function($e){
        ob_end_flush();
    });
});
$application->run();
