<?php
  class ColParteBoletim2 implements IColParteBoletim2
  {
    private $arrayParteBoletim;
    public function ColParteBoletim2()
    {
    }
    public function incluirRegistro($ParteBoletim)
    { $this->arrayParteBoletim[$ParteBoletim->getNumeroParte()] = $ParteBoletim;
    }
    public function alterarRegistro($ParteBoletim)
    { $this->arrayParteBoletim[$ParteBoletim->getNumeroParte()] = $ParteBoletim;
    }
    public function excluirRegistro($ParteBoletim)
    { $this->arrayParteBoletim[$ParteBoletim->getNumeroParte()] = null;
    }
	public function lerRegistro($codParteBoletim)
	{ /*$resultado = NULL;
	  foreach ($this->arrayParteBoletim as $key=>$value)
	  { if ($value->getNumeroParte() == $codParteBoletim)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $parteBoletim = $this->iniciaBusca1();
	  while ($parteBoletim != null)
	  { if ($parteBoletim->getNumeroParte() == $codParteBoletim)
	    { $resultado = $parteBoletim;
	      break;
	    }
	    $parteBoletim = $this->getProximo1();
	  }
	  return $resultado;
	}
	
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayParteBoletim) > 0)
      { return reset($this->arrayParteBoletim);
	  }
      else
      { return null;
      }
    }
    
    public function getProximo1()
    { return next($this->arrayParteBoletim);
    }
    
    public function getQTD()
    { return count($this->arrayParteBoletim);
	}    
  }
?>
