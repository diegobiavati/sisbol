<?php
  class OM
  { //propriedades privadas
    private $cod;
	private $nome;
	private $sigla;
	private $desig_hist;
	private $loc;
	private $subd1;
	private $subd2;
	private $subd3;
        private $subd4;
        private $gu;
	private $data_atualiz;
	private $codOM;
	private $anoCorrente;

	//construtor
    public function OM()
    {
    }
    //funcoes de acesso-get
    public function getCodigo(){
    	return $this->cod;
    }
    public function getCodOM(){
    	return $this->codOM;
    }
	public function getNome(){
		return $this->nome;
	}
	public function getSigla(){
		return $this->sigla;
	}
	public function  getDesigHist(){
		return $this->desig_hist;
	}
	public function getLoc(){
		return $this->loc;
	}
	public function getSubd1(){
		return $this->subd1;
	}
	public function getSubd2(){
		return $this->subd2;
	}
	public function getSubd3(){
		return $this->subd3;
	}
        public function getSubd4(){
		return $this->subd4;
	}
        public function getGu(){
		return $this->gu;
	}
	public function getDataAtualiz(){
		return $this->data_atualiz;
	}
	public function getAnoCorrente(){
		return $this->anoCorrente;
	}     
    //funcoes de acesso-get
    public function setCodigo($valor){
    	return $this->cod = $valor;
    }
    public function setCodOM($valor){
    	return $this->codOM = $valor;
    }
	public function setNome($valor){
		return $this->nome = $valor;
	}
	public function setSigla($valor){
		return $this->sigla = $valor;
	}
	public function setDesigHist($valor){
		return $this->desig_hist = $valor;
	}
	public function setLoc($valor){
		return $this->loc = $valor;
	}
	public function setSubd1($valor){
		return $this->subd1 = $valor;
	}
	public function setSubd2($valor){
		return $this->subd2 = $valor;
	}
	public function setSubd3($valor){
		return $this->subd3 = $valor;
	}
        public function setSubd4($valor){
		return $this->subd4 = $valor;
	}
        public function setGu($valor){
		return $this->gu = $valor;
	}
	public function setAnoCorrente($valor){
		return $this->anoCorrente = $valor;
	}
	
    public function exibeDados()
    { echo 'OM cod= ' . $this->cod . 
    		'<br>Nome ' . $this->nome.
			'<br>Sigla ' . $this->sigla.
			'<br>Desig Historica ' . $this->desig_hist.
			'<br>Localizacao ' . $this->loc.
			'<br>Subord 1 ' . $this->subd1.
			'<br>Subord 2' . $this->subd2.
			'<br>Subord 3' . $this->subd3.
                        '<br>Subord 4' . $this->subd4.
			'<br>Ano Corrente' . $this->anoCorrente.
			'<br>GU ' . $this->gu;
    }
  }
?>
