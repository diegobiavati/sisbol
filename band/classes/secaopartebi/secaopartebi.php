<?php
  class SecaoParteBi
  { //propriedades privadas
    private $numeroSecao;
    private $descricao;
    //funcoes de acesso-get
    public function getNumeroSecao()
    { return $this->numeroSecao;
    }
    public function getDescricao()
    { return $this->descricao;
    }
    //funcoes de acesso set
    public function setNumeroSecao($valor)
    { $this->numeroSecao = $valor;
    }
    public function setDescricao($valor)
    { $this->descricao = $valor;
    }
    public function exibeDados()
    { echo 'Numero Secao= ' . $this->numeroSecao . ' Descricao= ' . $this->descricao;
    }
  }
?>
