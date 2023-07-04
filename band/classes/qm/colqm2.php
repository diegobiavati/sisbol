<?php
  class ColQM2 implements IColQM2
  {
    private $arrayQM;
    public function ColQM2()
    {
    }
    public function incluirRegistro($pQM)
    { $this->arrayQM[$pQM->getCod()] = $pQM;
    }
    public function alterarRegistro($pQM)
    { $this->arrayQM[$pQM->getCod()] = $pQM;
    }
    public function excluirRegistro($pQM)
    { $this->arrayQM[$pQM->getCod()] = null;
    }
	public function LerRegistro($codQM)
	{ /*$resultado = NULL;
	  foreach ($this->arrayQM as $key=>$value)
	  { if ($value->getCod() == $codQM)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $qm = $this->iniciaBusca1();
	  while ($qm != null)
	  { if ($qm->getCod() == $codQM)
	    { $resultado = $qm;
	      break;
	    }
	    $qm = $this->getProximo1();
	  }
	  return $resultado;
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayQM) > 0)
      { return reset($this->arrayQM);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayQM);
    }
    public function getQTD()
    { return count($this->arrayQM);
	}    
  }
?>
