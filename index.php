<?php 

session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \MarcollaHC\Pages;
use \MarcollaHC\PagesAdmin;
use \MarcollaHC\Model\Users;

$app = new Slim();
$app->config("debug", true);

$app->get("/", function() {
	$page = new Pages();
	$page->setTemplate("index");
});

$app->get("/admin", function() {
	Users::verify();
	$page = new PagesAdmin();
	$page->setTemplate("index");
});

$app->get("/admin/login", function () {
	$page = new PagesAdmin([
		"header" => false,
		"footer" => false
	]);
	$page->setTemplate("login");
});

$app->post("/admin/login", function () {
	Users::login($_POST["login"], $_POST["password"]);
	header("location: http://localhost/Exercises/Udemy/curso-completo-de-php-7/secao-24/projeto/admin");
	exit;
});

$app->get("/admin/logout", function () {
	Users::logout();
	header("location: http://localhost/Exercises/Udemy/curso-completo-de-php-7/secao-24/projeto/admin");
	exit;
});

$app->run();

?>