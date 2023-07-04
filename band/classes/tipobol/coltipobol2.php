<?php
  class ColTipoBol2 implements IColTipoBol2
  {
    private $arrayTipoBol;
    public function ColTipoBol2()
    {
    }
    public function incluirRegistro($tipoBol)
    { $this->arrayTipoBol[$tipoBol->getCodigo()] = $tipoBol;
    }
    public function alterarRegistro($tipoBol)
    { $this->arrayTipoBol[$tipoBol->getCodigo()] = $tipoBol;
    }
    public function excluirRegistro($tipoBol)
    { $this->arrayTipoBol[$tipoBol->getCodigo()] = null;
    }
	public function lerRegistro($codTipoBol)
	{ /*$resultado = NULL;
	  foreach ($this->arrayTipoBol as $key=>$value)
	  { if ($value->getCodigo() == $codTipoBol)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $tipoBol = $this->iniciaBusca1();
	  while ($tipoBol != null)
	  { if ($tipoBol->getCodigo() == $codTipoBol)
	    { $resultado = $tipoBol;
	      break;
	    }
	    $tipoBol = $this->getProximo1();
	  }
	  return $resultado;
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayTipoBol) > 0)
      { return reset($this->arrayTipoBol);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayTipoBol);
    }
    public function getQTD()
    { return count($this->arrayTipoBol);
	}    
  }
?>
