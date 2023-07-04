<?php
  class Militar extends Pessoa
  { //propriedades privadas
	private $idt_militar; // Esta é efetivamente a identidade do militar v 1.0 rv 05
	private $qm;
	private $pGrad;
	private $cp;
	private $precCP;
	private $data_atualiz;
	private $cutis;
	private $olhos;
	private $cabelos;
	private $barba;
	private $altura;
	private $sinais_particulares;
	private $tipoSanguineo;
	private $fatorRH;
	private $comportamento;
	private $antiguidade;
	private $naturalidade;
	private $estadoCivil;
	private $dataIdt;
	private $bigode;
	private $outros;
	private $assinatura;
	//construtor
    public function Militar($pGrad, $qm, $funcao, $dataNasc, $omVinc, $subun)
    { Pessoa::Pessoa($funcao, $dataNasc, $omVinc, $subun);
	  $this->pGrad = $pGrad;
      $this->qm = $qm;
    }
    //funcoes de acesso-get
	public function getIdtMilitar(){
    	return $this->idt_militar;
	}
    public function getQM(){
    	return $this->qm;
	}
	public function getPGrad(){
		return $this->pGrad;
  	}
  	public function getCP(){
		return $this->cp;
	}
	public function getPrecCP(){
		return $this->precCP;
	}
	public function getCutis(){
		return $this->cutis;
	}
	public function getOlhos(){
		return $this->olhos;
	}
	public function getCabelos(){
		return $this->cabelos;
	}
	public function getBarba(){
		return $this->barba;
	}
	public function getAltura(){
		return $this->altura;
	}
	public function getSinaisParticulares(){
		return $this->sinais_particulares;
	}
	public function getTipoSang(){
		return $this->tipoSanguineo;
	}
	public function getFatorRH(){
		return $this->fatorRH;
	}
	public function getComportamento(){
		return $this->comportamento;
	}
	public function getAntiguidade(){
		return $this->antiguidade;
	}
	public function getNaturalidade(){
		return $this->naturalidade;
	}
	public function getEstadoCivil(){
		return $this->estadoCivil;
	}
	public function getDataIdt(){
		return $this->dataIdt;
	}
	public function getBigode(){
		return $this->bigode;
	}
	public function getOutros(){
		return $this->outros;
	}
	public function getAssinatura(){
		return $this->assinatura;
	}


    //funcoes de set
    public function setIdtMilitar($valor){
    	return $this->idt_militar = $valor;
	}
	public function setQM($valor){
    	return $this->qm = $valor;
	}
	public function setPGrad($valor){
		return $this->pGrad = $valor;
  	}
  	public function setCP($valor){
		return $this->cp = $valor;
	}
	public function setPrecCP($valor){
		return $this->precCP = $valor;
	}
	public function setCutis($valor){
		return $this->cutis = $valor;
	}
	public function setOlhos($valor){
		return $this->olhos = $valor;
	}
	public function setCabelos($valor){
		return $this->cabelos = $valor;
	}
	public function setBarba($valor){
		return $this->barba = $valor;
	}
	public function setAltura($valor){
		return $this->altura = $valor;
	}
	public function setSinaisParticulares($valor){
		return $this->sinais_particulares = $valor;
	}
	public function setTipoSang($valor){
		return $this->tipoSanguineo = $valor;
	}
	public function setFatorRH($valor){
		return $this->fatorRH = $valor;
	}
	public function setComportamento($valor){
		$this->comportamento = $valor;
	}
	public function setAntiguidade($valor){
		$this->antiguidade = $valor;;
	}
	public function setNaturalidade($valor){
		$this->naturalidade = $valor;
	}
	public function setEstadoCivil($valor){
		$this->estadoCivil = $valor;
	}
	public function setDataIdt($valor){
		return $this->dataIdt = $valor;
	}
	public function setBigode($valor){
		return $this->bigode = $valor;
	}
	public function setOutros($valor){
		return $this->outros = $valor;
	}
	public function setAssinatura($valor){
		return $this->assinatura = $valor;
	}
    public function exibeDados()
    { print_r($this);
    }
  }
?>
