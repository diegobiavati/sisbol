<?php
  class Boletim
  { //propriedades privadas
    private $codigo;
    
    private $pagInicial;
    private $pagFinal;
    private $assinado;
    private $aprovado;
    private $numeroBi;
    private $assinaConfereBi;
    private $dataPub;
    private $tipoBol;
    private $biRef;
    private $colMateriaBi2;
    
    //construtor
    public function Boletim($dataPub, $tipoBol, $assinaConfereBi, $colMateriaBi2)
    {  $this->dataPub = $dataPub;
       $this->tipoBol = $tipoBol;
       $this->assinaConfereBi = $assinaConfereBi;
       $this->aprovado = 'N';
       $this->assinado = 'N';
       $this->colMateriaBi2 = $colMateriaBi2;
    }
    //funcoes de acesso-get
    public function getCodigo()
    { return $this->codigo;
    }
    public function getPagInicial()
    { return $this->pagInicial;
    }
    public function getPagFinal()
    { return $this->pagFinal;
    }
    public function getAssinado()
    { return $this->assinado;
    }
    public function getAprovado()
    { return $this->aprovado;
    }
    public function getNumeroBi()
    { return $this->numeroBi;
    }
    public function getAssinaConfereBi()
    { return $this->assinaConfereBi;
    }
    public function getDataPub()
    { return $this->dataPub;
    }
    public function getTipoBol()
    { return $this->tipoBol;
    }
    public function getBiRef()
    { return $this->biRef;
    }
    public function getColMateriaBi2()
    { return $this->colMateriaBi2;
    }
    //funcoes de acesso set
    public function setCodigo($valor)
    { $this->codigo = $valor;
    }
    public function setPagInicial($valor)
    { $this->pagInicial = $valor;
    }
    public function setPagFinal($valor)
    { $this->pagFinal = $valor;
    }
    public function setAssinado($valor)
    { $this->assinado = $valor;
    }
    public function setAprovado($valor)
    { $this->aprovado = $valor;
    }
    public function setNumeroBi($valor)
    { $this->numeroBi = $valor;
    }
    public function setAssinaConfereBi($valor)
    { $this->assinaConfereBi = $valor;
    }
    public function setDataPub($valor)
    { $this->dataPub = $valor;
    }
    public function setTipoBol($valor)
    { $this->tipoBol = $valor;
    }
    public function setBiRef($valor)
    { $this->biRef = $valor;
    }
    public function setColMateriaBi2($valor)
    { $this->colMateriaBi2 = $valor;
    }
    public function exibeDados()
	{ echo 'Código = ' . $this->codigo . ' numero bi = ' . $this->numeroBi . ' pag inicial = ' . $this->pagInicial;
	}    
  }
?>
