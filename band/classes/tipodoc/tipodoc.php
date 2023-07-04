<?php
  class TipoDoc
  { //propriedades privadas
    private $codigo;
    private $descricao;
    
    //construtor
    public function TipoDoc()
    {
    }
    
    //funcoes de acesso-get
    public function getCodigo()
    { return $this->codigo;
    }
    
    public function getDescricao()
    { return $this->descricao;
    }
    
    //funcoes de acesso set
    public function setCodigo($valor)
    { $this->codigo = $valor;
    }
    
    public function setDescricao($valor)
    { $this->descricao = $valor;
    }
    
    public function exibeDados()
    { echo 'Codigo tipo_doc= ' . $this->codigo . ' Descricao= ' . $this->descricao;
    }
    
  }
?>
