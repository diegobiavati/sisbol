<?php
  class Subunidade
  { //propriedades privadas
    private $cod;
    private $descricao;
    private $sigla;
    //funcoes de acesso-get
    public function getCod()
    { return $this->cod;
    }
    public function getDescricao()
    { return $this->descricao;
    }
    public function getSigla()
    { return $this->sigla;
    }
    //funcoes de acesso set
    public function setCod($valor)
    { $this->cod = $valor;
    }
    public function setDescricao($valor)
    { $this->descricao = $valor;
    }
    public function setSigla($valor)
    { $this->sigla = $valor;
    }
    public function exibeDados()
    { echo 'CODSUBUN= ' . $this->cod . ' Descricao= ' . $this->descricao . ' Sigla= ' . $this->sigla;
    }
  }
?>
