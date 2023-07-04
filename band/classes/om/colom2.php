<?php
  class ColOM2 implements IColOM2
  {
    private $arrayOM;
    public function ColOM2()
    {
    }
    public function incluirRegistro($OM)
    { $this->arrayOM[$OM->getCodigo()] = $OM;
    }
    public function alterarRegistro($OM)
    { $this->arrayOM[$OM->getCodigo()] = $OM;
    }
    public function excluirRegistro($OM)
    { $this->arrayOM[$OM->getCodigo()] = null;
    }
	public function LerRegistro($codOM)
	{ /*$resultado = NULL;
	  foreach ($this->arrayOM as $key=>$value)
	  { if ($value->getCodigo() == $codOM)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $om = $this->iniciaBusca1();
	  while ($om != null)
	  { if ($om->getCodigo() == $codOM)
	    { $resultado = $om;
	      break;
	    }
	    $om = $this->getProximo1();
	  }
	  return $resultado;
	  
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayOM) > 0)
      { return reset($this->arrayOM);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayOM);
    }
    public function getQTD()
    { return count($this->arrayOM);
	}    
  }
?>
