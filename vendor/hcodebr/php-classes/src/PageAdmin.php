<?php 

namespace Hcode;

Class PageAdmin extends Page {

	public function __construct($opts = array(), $tpl_dir = "/views/admin/"){

		parent::__construct($opts, $tpl_dir); // chama o metodo construtor da classe page passando os parametros dessa classe
	}	
}



 ?>