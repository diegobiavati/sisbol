<?php
  class AssuntoEspec
  { //propriedades privadas
    private $codigo;
    private $descricao;
    private $vaiIndice;
    private $textoPadAbert;
    private $textoPadFech;
    private $vaiAlteracao;
    
    //funcoes de acesso-get
    public function getCodigo()
    { return $this->codigo;
    }
    public function getDescricao()
    { return $this->descricao;
    }
    public function getVaiIndice()
    { return $this->vaiIndice;
    }
    public function getTextoPadAbert()
    { return $this->textoPadAbert;
    }
    public function getTextoPadFech()
    { return $this->textoPadFech;
    }
    public function getVaiAlteracao()
    { return $this->vaiAlteracao;
    }
    //funcoes de acesso set
    public function setCodigo($valor)
    { $this->codigo = $valor;
    }
    public function setDescricao($valor)
    { $this->descricao = $valor;
    }
    public function setVaiIndice($valor)
    { return $this->vaiIndice = $valor;
    }
    public function setTextoPadAbert($valor)
    { $this->textoPadAbert = $valor;
    }
    public function setTextoPadFech($valor)
    { $this->textoPadFech = $valor;
    }
    public function setVaiAlteracao($valor)
    { $this->vaiAlteracao = $valor;
    }
    public function exibeDados()
    { echo 'Codigo= ' . $this->codigo . ' Descricao= ' . $this->descricao . ' textoPadAbert ' . $this->textoPadAbert .
	  ' textoPadFech ' . $this->textoPadFech;
    }
  }
?>
