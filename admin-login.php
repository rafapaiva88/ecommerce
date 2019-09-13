<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app->get('/admin', function() {
    
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->get('/admin/login', function() {  //rota para carregar pagina de login
    
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function(){ //metodo para enviar o formulario preenchido na pagina login

	User::login($_POST["login"], $_POST["password"]); 

	header("Location: /admin");
	exit;

});

$app->get('/admin/logout', function(){ //rota com metodos para efetuar logout

	User::logout();

	header("Location: /admin/login");
	exit;
});

 ?>