<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\Category;
use \Hcode\Model\User;

$app->get("/admin/categories", function(){ //lista as categorias

	User::verifyLogin();

	$categories = Category::listAll();

	$page = new PageAdmin();

	$page->setTpl("categories", [
		"categories"=>$categories
	]);

});

$app->get("/admin/categories/create", function(){ //carrega pagina de criação de categorias

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("categories-create");

});

$app->post("/admin/categories/create", function(){ // envia as categorias preenchidas e salva no banco

	User::verifyLogin();

	$category = new Category();

	$category->setData($_POST);

	$category->save();

	header("Location: /admin/categories");
	exit;

});

$app->get("/admin/categories/:idcategory/delete", function($idcategory){ // deleta caretagoria carregando pelo id

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header("Location: /admin/categories");
	exit;

});

$app->get("/admin/categories/:idcategory", function($idcategory){  //carega pagina de edição de categoria pelo id

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl("categories-update", array(
		"category"=>$category->getValues()

	));	

});

$app->post("/admin/categories/:idcategory", function($idcategory){  // envia edição da categoria e salva

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header("Location: /admin/categories");
	exit;	

});	




 ?>