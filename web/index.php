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

if(getenv('PRODUCTION') == 'true') {
  require_auth();
} else {
  defined('YII_DEBUG') or define('YII_DEBUG', true);
  defined('YII_ENV') or define('YII_ENV', 'dev');
  $_ENV['DB_DSN'] = 'mysql:host=localhost;dbname=backlog';
  $_ENV['DB_USER'] = 'root';
  $_ENV['DB_PASS'] = '';
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
