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

$app->get("/admin/users", function () {
	Users::verify();
	$users = Users::listAll();
	$page = new PagesAdmin();
	$page->setTemplate("users", array("users" => $users));
});

$app->get("/admin/users/create", function () {
	Users::verify();
	$page = new PagesAdmin();
	$page->setTemplate("users-create");
});

$app->post("/admin/users/create", function () {
	Users::verify();
	$user = new Users();
	$_POST["inadmin"] = $_POST["inadmin"] ?? 0;
	$user->setData($_POST);
	$user->save();
	header("location: http://localhost/Exercises/Udemy/curso-completo-de-php-7/secao-24/projeto/admin/users");
	exit;
});

$app->get("/admin/users/:iduser/delete", function ($iduser) {
	Users::verify();
	$user = new Users();
	$user->get((int)$iduser);
	$user->delete();
	header("location: http://localhost/Exercises/Udemy/curso-completo-de-php-7/secao-24/projeto/admin/users");
	exit;
});

$app->get("/admin/users/:iduser", function ($iduser) {
	Users::verify();
	$user = new Users();
	$user->get((int)$iduser);
	$page = new PagesAdmin();
	$page->setTemplate("users-update", array("user" => $user->getValues()));
});

$app->post("/admin/users/:iduser", function ($iduser) {
	Users::verify();
	$user = new Users();
	$user->get((int)$iduser);
	$_POST["inadmin"] = $_POST["inadmin"] ?? 0;
	$user->setData($_POST);
	$user->update();
	header("location: http://localhost/Exercises/Udemy/curso-completo-de-php-7/secao-24/projeto/admin/users");
	exit;
});

$app->run();

?>