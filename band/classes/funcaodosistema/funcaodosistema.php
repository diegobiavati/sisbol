<?php
  class FuncaoDoSistema
  { //propriedades privadas
    private $codigo;
    private $descricao;
    private $assocTipoBol;
    //funcoes de acesso-get
    public function getCodigo()
    { return $this->codigo;
    }
    public function getDescricao()
    { return $this->descricao;
    }
    public function getAssocTipoBol()
    { return $this->assocTipoBol;
    }
    //funcoes de acesso set
    public function setCodigo($valor)
    { $this->codigo = $valor;
    }
    public function setDescricao($valor)
    { $this->descricao = $valor;
    }
    public function setAssocTipoBol($valor)
    { $this->assocTipoBol = $valor;
    }
  }
?>
