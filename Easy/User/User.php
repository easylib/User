<?php
namespace Easy\User;

class User
{
	private $login = false;
	private $userID = NULL;
	public function __construct($pdo, $session)
	{
		$this->pdo = $pdo;
		$this->session = $session;
		if($this->session->get("login"))
		{
			$this->login = true;
			$this->userID = $this->session->get("userID");
		}
	}
	public function register($mail, $pw, $hash = false)
	{
		$sql = "INSERT INTO `user`(`id`, `mail`, `pw`) VALUES (NULL, ?, ?)";
		$this->pdo->insert($sql, array($mail, md5($pw)));
	}
	public function checkHash($mail, $hash)
	{

	}
	public function login($mail, $pw)
	{
		$sql = 'SELECT `id`, `pw` FROM `user` WHERE `mail` = ?';
		$res = $this->pdo->query($sql, array($mail));
		if(count($res)!=1)
		{
			return False;
		}
		$res = $res[0];
		if($res["pw"]==md5($pw))
		{
			
			$this->session->set("login", true);
			$this->session->set("userID", $res["id"]);
			$this->login = true;
			$this->userUD = $res["id"];
			return True;
		}
		return False;
	}
	public function getID()
	{
		return $this->userID;
	}
	public function getMail()
	{
		$sql = 'SELECT `mail` FROM `user` WHERE `id` = ?';
		$res = $this->pdow->query($sql, array($this->userID));
		return $res[0][0];
	}
}
?>