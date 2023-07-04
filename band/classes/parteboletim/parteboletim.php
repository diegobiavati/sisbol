<?php
  class ParteBoletim
  { //propriedades privadas
    private $numeroParte;
    private $descricao;
    private $descrReduz;
    private $colSecaoParteBi2;
    //construtor
    public function ParteBoletim($colSecaoParteBi2)
    { $this->colSecaoParteBi2 = $colSecaoParteBi2;
    }
    //funcoes de acesso-get
    public function getNumeroParte()
    { return $this->numeroParte;
    }
    public function getDescricao()
    { return $this->descricao;
    }
    public function getDescrReduz()
    { return $this->descrReduz;
    }
    public function getColSecaoParteBi2()
    { return $this->colSecaoParteBi2;
    }
    //funcoes de acesso set
    public function setNumeroParte($valor)
    { $this->numeroParte = $valor;
    }
    public function setDescricao($valor)
    { $this->descricao = $valor;
    }
    public function setDescrReduz($valor)
    { $this->descrReduz = $valor;
    }
    public function setColSecaoParteBi2($valor)
    { $this->colSecaoParteBi2 = $valor;
    }
    public function exibeDados()
    { echo 'Numero Parte= ' . $this->numeroParte . ' Descricao= ' . $this->descricao . ' Descr Reduz= ' . $this->descrReduz;
    }
  }
?>
