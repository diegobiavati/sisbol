<?php
  class ColAssuntoEspec2 implements IColAssuntoEspec2
  {
    private $arrayAssuntoEspec;
    public function ColAssuntoEspec2()
    {
    }
    public function incluirRegistro($assuntoEspec)
    { $this->arrayAssuntoEspec[$assuntoEspec->getCodigo()] = $assuntoEspec;
    }
    public function alterarRegistro($assuntoEspec)
    { $this->arrayAssuntoEspec[$assuntoEspec->getCodigo()] = $assuntoEspec;
    }
    public function excluirRegistro($assuntoEspec)
    { $this->arrayAssuntoEspec[$assuntoEspec->getCodigo()] = null;
    }
	public function LerRegistro($codAssuntoEspec)
	{ /*$resultado = NULL;
	  foreach ($this->arrayAssuntoEspec as $key=>$value)
	  { if ($value->getCodigo() == $codAssuntoEspec)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $assuntoEspec = $this->iniciaBusca1();
	  while ($assuntoEspec != null)
	  { if ($assuntoEspec->getCodigo() == $codAssuntoEspec)
	    { $resultado = $assuntoEspec;
	      break;
	    }
	    $assuntoEspec = $this->getProximo1();
	  }
	  return $resultado;
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayAssuntoEspec) > 0)
      { return reset($this->arrayAssuntoEspec);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayAssuntoEspec);
    }
    public function getQTD()
    { return count($this->arrayAssuntoEspec);
	}    
  }
?>
