<?php
  class ColIndice2 implements IColIndice2
  {
    private $arrayIndice;
    public function ColIndice2()
    {
    }
    public function incluirRegistro($indice)
    { $this->arrayIndice[$indice->getCodigo()] = $indice;
    }
    public function alterarRegistro($indice)
    { $this->arrayIndice[$indice->getCodigo()] = $indice;
    }
    public function excluirRegistro($indice)
    { $this->arrayIndice[$indice->getCodigo()] = null;
    }
	public function LerRegistro($codigo)
	{ /*$resultado = NULL;
	  foreach ($this->arrayAssuntoEspec as $key=>$value)
	  { if ($value->getCodigo() == $codAssuntoEspec)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $indice = $this->iniciaBusca1();
	  while ($indice != null)
	  { if ($indice->getCodigo() == $codigo)
	    { $resultado = $indice;
	      break;
	    }
	    $indice = $this->getProximo1();
	  }
	  return $resultado;
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayIndice) > 0)
      { return reset($this->arrayIndice);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayIndice);
    }
    public function getQTD()
    { return count($this->arrayIndice);
	}    
  }
?>
