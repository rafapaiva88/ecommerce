<?php 

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model {

		const SESSION = "User";

	public static function login ($login, $password){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
			":LOGIN"=>$login //select no banco e verifica se encontra o login
		));

		if (count($results) === 0) // se não encontrar o login estoura um erro
		{
			throw new \Exception("Usuário inexistente ou senha inválida");
			
		}

		$data = $results[0]; // a linha encontrada atribui a data

		if (password_verify($password, $data["despassword"]) === true) //faz verificação do password digitado com o hash encontrado na chave despassword no banco, se for igual cai dentro do if
		{
			$user = new User(); // criar um objeto com os dados do usuario

			$user->setData($data);

			$_SESSION[User::SESSION] = $user->getValues();

			return $user; // retorna o usuarios localizado no banco

		} else {

			throw new \Exception("Usuário inexistente ou senha inválida");

		}

	}

	public static function verifyLogin($inadmin = true)
	{

		if (
			!isset($_SESSION[User::SESSION]) //verifica se a sessão foi definida, não sendo cai no header
			||
			!$_SESSION[User::SESSION] // não contem dados
			||
			!(int)$_SESSION[User::SESSION]["iduser"] > 0 //se o id não foi maior que zero
			||
			(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin //se o usuario do banco não tem permisão no campo inadmin, caso n tenha o inadmin retorna false
		) {

			header("Location: /admin/login");
			exit;
		}

	}

	public static function logout()
	{

		$_SESSION[User::SESSION] = NULL;
		
	}

	public static function listAll()
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson");

	}

	public function save()
	{
		$sql = new Sql();

		$results = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
			":desperson"=>$this->getdesperson(),
			":deslogin"=>$this->getdeslogin(),
			":despassword"=>$this->getdespassword(),
			":desemail"=>$this->getdesemail(),
			":nrphone"=>$this->getnrphone(),
			":inadmin"=>$this->getinadmin()
		));

		$this->setData($results[0]);
	}

	public function get($iduser)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = :iduser", array(
			":iduser"=>$iduser
		));

		$this->setData($results[0]);
	}

	public function update()
	{
		$sql = new Sql();

		$results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
			":iduser"=>$this->getiduser(),
			":desperson"=>$this->getdesperson(),
			":deslogin"=>$this->getdeslogin(),
			":despassword"=>$this->getdespassword(),
			":desemail"=>$this->getdesemail(),
			":nrphone"=>$this->getnrphone(),
			":inadmin"=>$this->getinadmin()
		));

		$this->setData($results[0]);
	}

	public function delete()
	{
		$sql = new Sql();

		$sql->query("CALL sp_users_delete(:iduser)", array(
			":iduser"=>$this->getiduser()
		));
	}
}


 ?>