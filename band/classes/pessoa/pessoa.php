<?php
  class Pessoa
  { //propriedades privadas
    private $id_militar;
	private $funcao;
	private $nome;
	private $nome_guerra;
	private $dataNasc;
	private $nome_pai;
	private $nome_mae;
	private $cpf;
	private $pis_pasep;
	private $data_atualiz;
	private $sexo;
	private $perm_pub_bi;
	private $omVinc;
	private $subun;


	//construtor
    public function Pessoa($funcao, $dataNasc, $omVinc, $subun)
    { $this->funcao = $funcao;
      $this->dataNasc = $dataNasc;
      $this->omVinc = $omVinc;
      $this->subun = $subun;
    }
    //funcoes de acesso-get
	public function getIdMilitar(){
    	return $this->id_militar;
    }
	public function getFuncao(){
    	return $this->funcao;
	}
	public function getNome(){	
		return $this->nome;
  	}
  	public function getNomeGuerra(){	
		return $this->nome_guerra;
  	}
  	public function getDataNasc(){
		return $this->dataNasc;
	}	
	public function getNomePai(){
		return $this->nome_pai;
	}	
	public function getNomeMae(){
		return $this->nome_mae;
	}
	public function getCPF(){
		return $this->cpf;
	}
	public function getPisPasep(){
		return $this->pis_pasep;
	}
	public function getDataAtualiz(){
		return $this->data_atualiz;
	}	
	public function getSexo(){
		return $this->sexo;
	}
    public function getPermPubBI(){
		return $this->perm_pub_bi;
	} 
    public function getOmVinc(){
		return $this->omVinc;
	} 
    public function getSubun(){
		return $this->subun;
	}
    //funcoes de set
    public function setIdMilitar($valor){
     	$this->id_militar = $valor;
    }
	public function setFuncao($valor){
    	$this->funcao = $valor;
	}
	public function setNome($valor){	
		$this->nome = $valor;
  	}
  	public function setNomeGuerra($valor){	
		$this->nome_guerra = $valor;
  	}
  	public function setDataNasc($valor){
		$this->dataNasc = $valor;
	}	
	public function setNomePai($valor){
		$this->nome_pai = $valor;
	}	
	public function setNomeMae($valor){
		$this->nome_mae = $valor;
	}
	public function setPisPasep($valor){
		$this->pis_pasep = $valor;
	}
	public function setCPF($valor){
		$this->cpf = $valor;
	}
	public function setDataAtualiz($valor){
		$this->data_atualiz = $valor;
	}	
	public function setSexo($valor){
		$this->sexo = $valor;
	}
	public function setPermPubBI($valor){
		$this->perm_pub_bi = $valor;
	} 
	public function setOmVinc($valor){
		$this->omVinc = $valor;
	} 
	public function setSubun($valor){
		$this->subun = $valor;
	}
    public function exibeDados()
    { print_r(get_object_vars($this));
    }
  }
?>
