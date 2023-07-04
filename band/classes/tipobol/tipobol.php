<?php
  class TipoBol
  { //propriedades privadas
    private $cod;
    private $descricao;
    private $abreviatura;
    private $nrultpag;
    private $nrultbi;
    private $ini_num_pag;
    private $e_aditamento;
    private $imp_bordas;
    private $titulo2;

    //construtor
    public function TipoBol()
    {
    }
    //funcoes de acesso-get
    public function getCodigo()
    { return $this->cod;
    }
    public function getDescricao()
    { return $this->descricao;
    }
    public function getAbreviatura()
    { return $this->abreviatura;
    }
    public function getNrUltPag()
    { return $this->nrultpag;
    }
    public function getNrUltBi()
    { return $this->nrultbi;
    }
    public function getIni_num_pag()
    { return $this->ini_num_pag;
    }
    public function getE_Aditamento()
    { return $this->e_aditamento;
    }
	public function getImp_bordas()
    { return $this->imp_bordas;
    }
    public function getTitulo2()
    { return $this->titulo2;
    }

    //funcoes de acesso set
    public function setCodigo($valor)
    { $this->cod = $valor;
    }
    public function setDescricao($valor)
    { $this->descricao = $valor;
    }
    public function setAbreviatura($valor)
    { $this->abreviatura = $valor;
    }
    public function setNrUltPag($valor)
    { $this->nrultpag = $valor;
    }
    public function setNrUltBi($valor)
    { $this->nrultbi = $valor;
    }
	public function setIni_num_pag($valor)
    { $this->ini_num_pag = $valor;
    }
    public function setE_Aditamento($valor)
    { $this->e_aditamento = $valor;
    }
    public function setImp_bordas($valor)
    { $this->imp_bordas = $valor;
    }
    public function setTitulo2($valor)
    { $this->titulo2 = $valor;
    }

    public function incNrUltBi()
	{ $this->nrultbi = $this->nrultbi + 1;
	}

    public function decNrUltBi()
	{ $this->nrultbi = $this->nrultbi - 1;
	}
	//rev 06
	public function atualizNrUltPagBi($nrUltPagBi)
	{ $this->nrultpag = $nrUltPagBi;
	}

    public function exibeDados()
    { echo 'Codigo TipoBol= ' . $this->cod . ' Descricao= ' . $this->descricao.'<br>';
       echo 'Nr ult pag= ' . $this->nrultpag . ' Nr ult BI= ' . $this->nrultbi;
    }
  }
?>
