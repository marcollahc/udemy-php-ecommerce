<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;
use \MarcollaHC\Pages;

$app = new Slim();
$app->config("debug", true);
$app->get("/", function() {
	$page = new Pages();
	$page->setTemplate("index");
});
$app->run();

 ?>