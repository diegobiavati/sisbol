<?php
  class Configuracoes
  { //propriedades privadas
    private $aprovNota1;
	private $aprovNota2;
	private $aprovBoletim;
	private $imprimeNomesLinha;
	private $imprimeAssinatura;
	//Bedin
	private $imprimeQMS;
	private $dataAtualiz;

	//construtor
    public function Configuracoes()
    {
    }
    //funcoes de acesso-get
    public function getAprovNota1(){
    	return $this->aprovNota1;
    }
    public function getAprovNota2(){
    	return $this->aprovNota2;
    }
	public function getAprovBoletim(){
		return $this->aprovBoletim;
	}
	public function getImprimeNomesLinha(){
		return $this->imprimeNomesLinha;
	}
	public function getImprimeAssinatura(){
		return $this->imprimeAssinatura;
	}
	//Bedin
	public function getImprimeQMS(){
		return $this->imprimeQMS;
	}
	public function getDataAtualiz(){
		return $this->dataAtualiz;
	}
    //funcoes de acesso-get
    public function setAprovNota1($valor){
    	return $this->aprovNota1 = $valor;
    }
    public function setAprovNota2($valor){
    	return $this->aprovNota2 = $valor;
    }
	public function setAprovBoletim($valor){
		return $this->aprovBoletim = $valor;
	}
	public function setImprimeNomesLinha($valor){
		return $this->imprimeNomesLinha = $valor;
	}
	public function setImprimeAssinatura($valor){
		return $this->imprimeAssinatura = $valor;
	}
	//Bedin
	public function setImprimeQMS($valor){
		return $this->imprimeQMS = $valor;
	}
	public function setDataAtualiz($valor){
		return $this->dataAtualiz = $valor;
	}
	
    public function exibeDados()
    { echo 'Aprova Nota N�vel 1= ' . $this->aprovNota1 . 
    		'<br>Aprova Nota N�vel 1 ' . $this->aprovNota2.
			'<br>Aprova Boletim ' . $this->aprovBoletim.
			'<br>Imprime Nomes em Linha ' . $this->imprimeNomesLinha.
			//Bedin
			'<br>Imprime QMS ' . $this->imprimeQMS.
			'<br>Data ' . $this->dataAtualiz;
    }
  }
?>
