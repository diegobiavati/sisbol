<?php
  class Usuario
  { //propriedades privadas
    private $login;
    private $senha;
    private $codom;
    private $codSubun;
    private $todasOmVinc;
    private $todasSubun;
    private $todasOmVinc2;
    private $todasSubun2;
    private $modificaModelo;
    private $dtExpira;
    public function Usuario($dtExpira)
    { $this->dtExpira = $dtExpira;
    }
    //funcoes de acesso-get
    public function getLogin()
    { return $this->login;
    }
    public function getSenha()
    { return $this->senha;
    }
    public function getCodom()
    { return $this->codom;
    }
    public function getCodSubun()
    { return $this->codSubun;
    }
    public function getTodasOmVinc()
    { return $this->todasOmVinc;
    }
    public function getTodasSubun()
    { return $this->todasSubun;
    }
    public function getTodasOmVinc2()
    { return $this->todasOmVinc2;
    }
    public function getTodasSubun2()
    { return $this->todasSubun2;
    }
    public function getModificaModelo()
    { return $this->modificaModelo;
    }
    public function getDtExpira()
    { return $this->dtExpira;
    }
    //funcoes de acesso set
    public function setLogin($valor)
    { $this->login = $valor;
    }
    public function setSenha($valor)
    { $this->senha = $valor;
    }
    public function setCodom($valor)
    { $this->codom = $valor;
    }
    public function setCodSubun($valor)
    { $this->codSubun = $valor;
    }
    public function setTodasOmVinc($valor)
    { $this->todasOmVinc = $valor;
    }
    public function setTodasSubun($valor)
    { $this->todasSubun = $valor;
    }
    public function setTodasOmVinc2($valor)
    { $this->todasOmVinc2 = $valor;
    }
    public function setTodasSubun2($valor)
    { $this->todasSubun2 = $valor;
    }
    public function setModificaModelo($valor)
    { $this->modificaModelo = $valor;
    }
    public function setDtExpira($valor)
    { $this->dtExpira = $valor;
    }
  }
?>
