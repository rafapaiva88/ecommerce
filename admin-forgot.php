<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app->get("/admin/forgot", function(){ // carrega pagina de reset

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot");

});

$app->post("/admin/forgot", function(){ //envia o email com os dados preenchidos

	$user = User::getForgot($_POST["email"]);

	header("Location: /admin/forgot/sent");
	exit;	

});

$app->get("/admin/forgot/sent", function(){ //carrega a pagina informando que o email enviado

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-sent");

});

$app->get("/admin/forgot/reset", function(){ //carrega pagina que foi enviada pelo email, com as instruções de reset

	$user = User::ValidForgotDecrypt($_GET["code"]);

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-reset", array(
		"name"=>$user["desperson"],
		"code"=>$_GET["code"]
	));

});

$app->post("/admin/forgot/reset", function(){ //envia o o que foi preenchido, converte a nova senha em hash e salva no banco.

	$forgot = User::ValidForgotDecrypt($_POST["code"]);

	User::setForgotUsed($forgot["idrecovery"]);

	$user = new User();

	$user->get((int)$forgot["iduser"]);

	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [
		"cost"=>12
	]);

	$user->setPassword($password);

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-reset-success");

});

 ?>