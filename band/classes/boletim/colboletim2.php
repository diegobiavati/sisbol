<?php
  class ColBoletim2 implements IColBoletim2
  {
    private $arrayBoletim;
    public function ColBoletim2()
    {
    }
    public function incluirRegistro($boletim)
    { $this->arrayBoletim[$boletim->getCodigo()] = $boletim;
    }
    public function alterarRegistro($boletim)
    { $this->arrayBoletim[$boletim->getCodigo()] = $boletim;
    }
    public function excluirRegistro($boletim)
    { $this->arrayBoletim[$boletim->getCodigo()] = null;
    }
	public function lerPorCodigo($codigo)
	{ /*$resultado = NULL;
	  foreach ($this->arrayBoletim as $key=>$value)
	  { if ($value->getCodigo() == $codigo)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $boletim = $this->iniciaBusca1();
	  while ($boletim != null)
	  { if ($boletim->getCodigo() == $codigo)
	    { $resultado = $codigo;
	      break;
	    }
	    $boletim = $this->getProximo1();
	  }
	  return $resultado;
	  
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayBoletim) > 0)
      { return reset($this->arrayBoletim);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayBoletim);
    }
    public function getQTD()
    { return count($this->arrayBoletim);
	}    
  }
?>
