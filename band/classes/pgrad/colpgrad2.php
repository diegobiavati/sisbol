<?php
  class ColPGrad2 implements IColPgrad2
  {
    private $arrayPGrad;
    public function ColPGrad2()
    {
    }
    public function incluirRegistro($pGrad)
    { $this->arrayPGrad[$pGrad->getCodigo()] = $pGrad;
    }
    public function alterarRegistro($pGrad)
    { $this->arrayPGrad[$pGrad->getCodigo()] = $pGrad;
    }
    public function excluirRegistro($pGrad)
    { $this->arrayPGrad[$pGrad->getCodigo()] = null;
    }
	public function LerRegistro($codPGrad)
	{ /*$resultado = NULL;
	  foreach ($this->arrayPGrad as $key=>$value)
	  { if ($value->getCodigo() == $codPGrad)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $pGrad = $this->iniciaBusca1();
	  while ($pGrad != null)
	  { if ($pGrad->getCodigo() == $codPGrad)
	    { $resultado = $pGrad;
	      break;
	    }
	    $pGrad = $this->getProximo1();
	  }
	  return $resultado;
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayPGrad) > 0)
      { return reset($this->arrayPGrad);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayPGrad);
    }
    public function getQTD()
    { return count($this->arrayPGrad);
	}    
  }
?>
