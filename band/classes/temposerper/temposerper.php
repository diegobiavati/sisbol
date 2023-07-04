<?php
  class TempoSerPer
  { //propriedades privadas
    private $idComport;
	private $dataIn;
    private $dataFim;
    private $militarAlt;
    private $militarAss;
	private $temComEfeSer;
    private $temNCom;   
    private $temMedMil;  
	private $temSerRel;    
	private $temTotEfeSer; 
	private $temArr;       
	private $temNArr; 
	private $assinado;     
	public function TempoSerPer($idComport, $dataIn, $dataFim, $militarAlt, $militarAss, $temComEfeSer, $temNCom, $temMedMil, 
				$temSerRel, $temTotEfeSer, $temArr, $temNArr){ 
		$this->idComport	= $idComport;
		$this->dataIn		= $dataIn;
		$this->dataFim		= $dataFim;
		$this->militarAlt	= $militarAlt;
		$this->militarAss	= $militarAss;
		$this->temComEfeSer = $temComEfeSer;
		$this->temNCom		= $temNCom;
		$this->temMedMil 	= $temMedMil;
		$this->temSerRel 	= $temSerRel;
		$this->temTotEfeSer = $temTotEfeSer;
		$this->temArr 		= $temArr;
		$this->temNArr 		= $temNArr;
		$this->assinado     = 'N';
	}
    //funcoes de acesso-get
	// vzo versao 2.0
	public function getidComport(){ 
		return $this->idComport;
	}
    public function getdataIn(){ 
		return $this->dataIn;
	}
	public function getdataFim(){ 
		return $this->dataFim;
	}
	public function getmilitarAlt(){ 
		return $this->militarAlt;
	}
	public function getmilitarAss(){
		return $this->militarAss;
	}
	public function getTemComEfeSer(){ 
		return $this->temComEfeSer;
	}
	public function getTemNCom(){ 
		return $this->temNCom;
	}
	public function getTemMedMil(){ 
		return $this->temMedMil;
	}
	public function getSerRel(){ 
		return $this->temSerRel;
	}
	public function getTotEfeSer(){ 
		return $this->temTotEfeSer;
	}
	public function getArr(){ 
		return $this->temArr;
	}
	public function getNArr(){ 
		return $this->temNArr;
    }
    public function getAssinado(){ 
		return $this->assinado;
    }
    
	//funcoes de acesso set
	// vzo versao 2.0
	public function setidComport($valor){ 
		 $this->idComport = $valor;
	}
    public function setdataIn($valor){ 
		 $this->dataIn = $valor;
	}
	public function setdataFim($valor){ 
		 $this->dataFim = $valor;
	}
	public function setmilitarAlt($valor){ 
		 $this->militarAlt = $valor;
	}
	public function setmilitarAss($valor){
		 $this->militarAss = $valor;
	}
	public function setTemComEfeSer($valor){ 
		$this->temComEfeSer = $valor;
	}
	public function setTemNCom($valor){ 
		$this->temNCom = $valor;
	}
	public function setTemMedMil($valor){ 
		$this->temMedMil = $valor;
	}
	public function setSerRel($valor){ 
		$this->temSerRel = $valor;
	}
	public function setTotEfeSer($valor){ 
		$this->temTotEfeSer = $valor;
	}
	public function setArr($valor){ 
		$this->temArr = $valor;
	}
	public function setNArr($valor){ 
		$this->temNArr = $valor;
    }
    public function setAssinado($valor){ 
		$this->assinado = $valor;
    }
  }
?>
