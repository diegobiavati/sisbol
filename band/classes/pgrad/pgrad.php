<?php
  class PGrad
  { //propriedades privadas
    private $cod;
    private $descricao;
    
    //construtor
    public function PGrad()
    {
    }
    //funcoes de acesso-get
    public function getCodigo()
    { return $this->cod;
    }
    public function getDescricao()
    { return $this->descricao;
    }
    
    //funcoes de acesso set
    public function setCodigo($valor)
    { $this->cod = $valor;
    }
    public function setDescricao($valor)
    { $this->descricao = $valor;
    }
    
    public function exibeDados()
    { echo 'Codigo posto_grad= ' . $this->codigo . ' Descricao= ' . $this->descricao;
    }
  }
?>
