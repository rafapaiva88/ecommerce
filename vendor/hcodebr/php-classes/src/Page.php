<?php 

namespace Hcode;

use Rain\Tpl;

class Page {

	private $tpl;
	private $options = [];
	private $defaults = [
		"data"=>[]
	];

	public function __construct($opts = array(), $tpl_dir = "/views/") {

		$this->options = array_merge($this->defaults, $opts); // mescla os dois array, dando prioridade ao adicionado depois.

		$config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]. $tpl_dir, // caminho da pasta root do servidor
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/"
    	);

    	Tpl::configure($config);

    	$this->tpl = new Tpl;

    	$this->setData($this->options["data"]);

    	$this->tpl->draw("header"); //cria o inicio da pagina baseada nos codigos html contidos no arquivo header

    	}

	private function setData($data = array()){

		foreach ($data as $key => $value) { //atribui chave e valor de cada intem no option a classe assign do tpl
		$this->tpl->assign($key, $value);

		}
	}

	public function setTpl($name, $data = array(), $returnHTML = false){ //precisa informar o nome do arquivo que contem o conteudo da pagina html

		$this->setData($data); 

		return $this->tpl->draw($name, $returnHTML); //realiza o marge

	}

	public function __destruct() {

		$this->tpl->draw("footer"); // finaliza a pagina com a parte final do codigo html contido no arquivo footer

	}

}

 ?>