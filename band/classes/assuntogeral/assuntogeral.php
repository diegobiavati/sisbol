<?php
  class AssuntoGeral
    { //propriedades privadas
    private $codigo;
    private $descricao;
    private $parteBoletim;
    private $secaoParteBi;
    private $colAssuntoEspec2;
    private $ordAssuntoGeral;
    private $tipoBol;

    //construtor
    public function AssuntoGeral($parteBoletim, $secaoParteBi, $tipoBol, $colAssuntoEspec2)
    { $this->parteBoletim = $parteBoletim;
      $this->secaoParteBi = $secaoParteBi;
      $this->tipoBol = $tipoBol;
      $this->colAssuntoEspec2 = $colAssuntoEspec2;
    }
    //funcoes de acesso-get
    public function getCodigo()
    { return $this->codigo;
    }
    public function getDescricao()
    { return $this->descricao;
    }
    public function getParteBoletim()
    { return $this->parteBoletim;
    }
    public function getSecaoParteBi()
    { return $this->secaoParteBi;
    }
    public function getColAssuntoEspec2()
    { return $this->colAssuntoEspec2;
    }
    public function getOrdAssuntoGeral()
    { return $this->ordAssuntoGeral;
    }
    public function getTipoBol()
    { return $this->tipoBol;
    }

    //funcoes de acesso set
    public function setCodigo($valor)
    { $this->codigo = $valor;
    }
    public function setDescricao($valor)
    { $this->descricao = $valor;
    }
    public function setParteBoletim($valor)
    { $this->parteBoletim = $valor;
    }
    public function setSecaoParteBi($valor)
    { $this->secaoParteBi = $valor;
    }
    public function setColAssuntoEspec2($valor)
    { $this->colAssuntoEspec2 = $valor;
    }
    public function setOrdAssuntoGeral($valor)
    { $this->ordAssuntoGeral = $valor;
    }
    public function setTipoBol($valor)
    { $this->tipoBol = $valor;
    }

    public function exibeDados()
    { echo 'codigo= ' . $this->codigo . ' Descricao= ' . $this->descricao;
    }
  }
?>
