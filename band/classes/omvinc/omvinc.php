<?php
  class OMVinc
  { //propriedades privadas
	private $nome;
	private $gu;
	private $codOM;
	private $sigla;
        private $colSubunidade2;

	//construtor
    public function OMVinc($colSubunidade2)
    {
        $this->colSubunidade2 = $colSubunidade2;
    }
    //funcoes de acesso-get
    public function getCodOM(){
    	return $this->codOM;
    }
	public function getNome(){
		return $this->nome;
	}
	public function getGu(){
		return $this->gu;
	}
	public function getSigla(){
		return $this->sigla;
	}
    public function getColSubunidade2()
    { return $this->colSubunidade2;
    }
    //funcoes de acesso-get
    public function setCodOM($valor){
    	$this->codOM = $valor;
    }
	public function setNome($valor){
		$this->nome = $valor;
	}
	public function setGu($valor){
		$this->gu = $valor;
	}
	public function setSigla($valor){
		$this->sigla = $valor;
	}
    public function setColSubunidade2($valor)
    { $this->colSubunidade2 = $valor;
    }
	
  }
?>
