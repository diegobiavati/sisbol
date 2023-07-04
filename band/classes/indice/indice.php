<?php
  class Indice
  { //propriedades privadas
    private $codigo;
    private $boletim;
    private $materiaBi;
    public function Indice($boletim, $materiaBi)
    { $this->boletim = $boletim;
      $this->materiaBi = $materiaBi;
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
  }
?>
