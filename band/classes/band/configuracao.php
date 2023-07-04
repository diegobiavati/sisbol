<?php
class Configuracao{
	private $banco;
	private $bandIniFile;
	private $link;
	private $user;
	private $host;
	private $senha;
	private $database;

	public function Configuracao(){
    	$iniFile = new IniFile('../../sisbol.ini');
      	$this->bandIniFile 	= new BandIniFile($iniFile);
      	$this->user 		= $this->bandIniFile->getUsuario('user');
      	$this->host 		= $this->bandIniFile->getHost('host');
      	$this->senha 		= $this->bandIniFile->getPassword('password');
      	$this->database 	= $this->bandIniFile->getDatabase('database');
    }

	public function verificaConexao(){
		$this->link = @mysqli_connect($this->host, $this->user, $this->senha);
		return $this->link;
    }
	public function getConexaoCTA(){
		$this->link = @mysqli_connect($this->host, $this->user, $this->senha,$this->database);
		return $this->link;
    }

    public function getConexao(){
    	return $this->link;
    }
	public function getNomeBanco(){
		return $this->database;
	}
}
?>
