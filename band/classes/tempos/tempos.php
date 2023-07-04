<?php
  class Tempos
  { //propriedades privadas
    private $dia;
    private $mes;
    private $ano;
    private $texto;
    public function Tempos()
    { $this->dia = 0;
      $this->mes = 0;
      $this->ano = 0;
      $this->texto = '';
    }
    //funcoes de acesso-get
    public function getDia()
    { return $this->dia;
    }
    public function getMes()
    { return $this->mes;
    }
    public function getAno()
    { return $this->ano;
    }
    public function getTexto()
    { return $this->texto;
    }
    //funcoes de acesso set
    public function setDia($valor)
    { $this->dia = $valor;
    }
    public function setMes($valor)
    { $this->mes = $valor;
    }
    public function setAno($valor)
    { $this->ano = $valor;
    }
    public function setTexto($valor)
    { $this->texto = $valor;
    }
    public function validaDados(){
    	return "";
		/*
		if(($this->dia < 0) or ($this->dia >= 30)){
    		return "Nr de dias inválido";
    	};
    	if($this->mes < 0 or $this->mes >= 12){
    		return "Nr de meses inválido";
    	};
    	if($this->ano < 0){
    		return "Nr de anos inválido";
    	}
    	*/
    }

    public function Soma($tempo)
    { $this->dia = $this->dia + $tempo->getDia();
      if ($this->dia >= 30)
      { $this->mes = $this->mes + 1;
        $this->dia = $this->dia - 30;
      }
      $this->mes = $this->mes + $tempo->getMes();
      if ($this->mes >= 12)
      { $this->ano = $this->ano + 1;
        $this->mes = $this->mes - 12;
      }
      $this->ano = $this->ano + $tempo->getAno();
    }
  }
?>
