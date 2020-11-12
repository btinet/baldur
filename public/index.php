<?php

use Btinet\Baldur\Bootstrap;

require_once (dirname(__DIR__).'/vendor/autoload.php');

ob_start();

define('project_root', dirname(__DIR__));
define('host', $_SERVER['HTTP_HOST']);

$app = new Bootstrap();
$app->setController('App\Controller\BaseController');
$app->init();

ob_flush();