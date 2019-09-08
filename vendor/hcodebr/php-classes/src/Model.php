<?php 

namespace Hcode;

class Model {

	private $values = [];

	public function __call($name, $args) //o call chama uma função q n existe, $name vai ser o nome da função chamada, e $args o argumento dessa função.
	{

		$method = substr($name, 0, 3); //verifica os 3 primeiras lestras do que foi atribuido ao $name
		$fieldName = substr($name, 3, strlen($name)); //verifica as ultimas letras baseado no tamanho da string

		switch ($method) 
		{
			case "get":
				return (isset($this->values[$fieldName])) ? $this->values[$fieldName] : NULL;
			break;
			
			case "set":
				return $this->values[$fieldName] = $args[0];
			break;
		}

	}

	public function setData ($data = array()) //função que percorre o array chamado no banco
	{

		foreach ($data as $key => $value) {
			
			$this->{"set".$key}($value); // concatena set com o valor contido na chave e o valor dessa chave vai para o $args do call
		}

	}

	public function getValues()
	{
		return $this->values; //retona os valores armazenados no array $values
	}

}


 ?>