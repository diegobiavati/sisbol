<?php
  class ColMilitar2 implements IColMilitar2
  {
    private $arrayMilitar;
    public function ColMilitar2()
    {
    }
    public function incluirRegistro($Militar)
    { $this->arrayMilitar[$Militar->getIdMilitar()] = $Militar;
    }
    public function alterarRegistro($Militar)
    { $this->arrayMilitar[$Militar->getIdMilitar()] = $Militar;
    }
    public function excluirRegistro($Militar)
    { $this->arrayMilitar[$Militar->getIdMilitar()] = null;
    }
	public function lerRegistro($idMilitar)
	{ /*$resultado = NULL;
	  foreach ($this->arrayMilitar as $key=>$value)
	  { if ($value->getIdMilitar() == $Militar)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $militar = $this->iniciaBusca1();
	  while ($militar != null)
	  { if ($militar->getIdMilitar() == $idMilitar)
	    { $resultado = $militar;
	      break;
	    }
	    $militar = $this->getProximo1();
	  }
	  return $resultado;	  
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayMilitar) > 0)
      { return reset($this->arrayMilitar);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayMilitar);
    }
    public function getQTD()
    { return count($this->arrayMilitar);
	}    
  }
?>
