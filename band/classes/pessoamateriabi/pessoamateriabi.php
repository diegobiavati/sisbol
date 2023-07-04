<?php
  class PessoaMateriaBi
  { //propriedades privadas
    private $pessoa;
    private $textoIndiv;
    
    public function PessoaMateriaBi($pessoa)
    { $this->pessoa = $pessoa;
    }
    //funcoes de acesso-get
    public function getPessoa()
    { return $this->pessoa;
    }
    public function getTextoIndiv()
    { return $this->textoIndiv;
    }
    //funcoes de acesso set
    public function setPessoa($valor)
    { $this->pessoa = $valor;
    }
    public function setTextoIndiv($valor)
    { $this->textoIndiv = $valor;
    }
  }
?>
