<?php
  class ColOMVinc2 implements IColOMVinc2
  {
    private $arrayOMVinc;
    public function ColOMVinc2()
    {
    }
    public function incluirRegistro($OMVinc)
    { $this->arrayOMVinc[$OMVinc->getCodom()] = $OMVinc;
    }
    public function alterarRegistro($OMVinc)
    { $this->arrayOMVinc[$OMVinc->getCodom()] = $OMVinc;
    }
    public function excluirRegistro($OMVinc)
    { $this->arrayOMVinc[$OMVinc->getCodom()] = null;
    }
	public function LerRegistro($codOM)
	{ $resultado = null;
	  $omVinc = $this->iniciaBusca1();
	  while ($omVinc != null)
	  { if ($omVinc->getCodom() == $codOM)
	    { $resultado = $omVinc;
	      break;
	    }
	    $omVinc = $this->getProximo1();
	  }
	  return $resultado;
	  
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayOMVinc) > 0)
      { return reset($this->arrayOMVinc);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayOMVinc);
    }
    public function getQTD()
    { return count($this->arrayOMVinc);
	}    
  }
?>
