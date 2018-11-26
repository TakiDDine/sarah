<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use PHPtricks\Orm\Database;
use Noodlehaus\Config;
use Illuminate\Database\Capsule\Manager as Capsule;

session_start();
date_default_timezone_set('Europe/Warsaw');

define('INC_ROOT',dirname(__DIR__));
define('BASEPATH',dirname(__DIR__));

require INC_ROOT.'/vendor/autoload.php';

$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];








$app = new \Slim\App($config);
require INC_ROOT .'/app/container.php';
require INC_ROOT .'/app/functions.php';


require INC_ROOT.'/app/routes/website.php';
require INC_ROOT.'/app/routes/admin.php';
require INC_ROOT.'/app/routes/api.php';
