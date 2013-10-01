<?php
namespace Easy\User;

class User
{
	public function __construct($pdo)
	{
		$this->pdo = $pdo;
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
		$sql = 'SELECT `id`, `pw` FROM `user` WHERE `mail` == "?"';
		$res = $this->pdo->query($sql, array($mail));
		if(count($res)!=1)
		{
			return False;
		}
		if($res["pw"]==md5($pw))
		{
			return True;
		}
		return False;
	}
}
?>