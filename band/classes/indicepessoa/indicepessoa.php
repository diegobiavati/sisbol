<?php
  class IndicePessoa
  { //propriedades privadas
    private $codigo;
    private $boletim;
    private $materiaBi;
    private $pessoaMateriaBi;
    public function IndicePessoa($boletim, $materiaBi, $pessoaMateriaBi)
    { $this->boletim = $boletim;
      $this->materiaBi = $materiaBi;
      $this->pessoaMateriaBi = $pessoaMateriaBi;
    }
    //funcoes de acesso-get
    public function getCodigo()
    { return $this->codigo;
    }
    public function getBoletim()
    { return $this->boletim;
    }
    public function getMateriaBi()
    { return $this->materiaBi;
    }
    public function getPessoaMateriaBi()
    { return $this->pessoaMateriaBi;
    }
    //funcoes de acesso set
    public function setCodigo($valor)
    { $this->codigo = $valor;
    }
    public function setBoletim($valor)
    { $this->boletim = $valor;
    }
    public function setMateriaBi($valor)
    { $this->materiaBi = $valor;
    }
    public function setPessoaMateriaBi($valor)
    { $this->pessoaMateriaBi = $valor;
    }
  }
?>
