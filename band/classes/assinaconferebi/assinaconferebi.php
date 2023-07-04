<?php
  class AssinaConfereBi
  { //propriedades privadas
    private $codigo;
    private $militarAssina;
    private $militarConfere;
    public function AssinaConfereBi($militarAssina, $militarConfere)
    { $this->militarAssina = $militarAssina;
      $this->militarConfere = $militarConfere;
    }
    //funcoes de acesso-get
    public function getCodigo()
    { return $this->codigo;
    }
    public function getMilitarAssina()
    { return $this->militarAssina;
    }
    public function getMilitarConfere()
    { return $this->militarConfere;
    }
    //funcoes de acesso set
    public function setMilitarAssina($valor)
    { $this->militarAssina = $valor;
    }
    public function setMilitarConfere($valor)
    { $this->militarConfere = $valor;
    }
    public function setCodigo($valor)
    { $this->codigo = $valor;
    }
    public function exibeDados()
    { echo " militar que assina ". $this->militarAssina->getIdMilitar() . " militar que confere ". $this->militarConfere->getIdMilitar();
    }
    
  }
?>
