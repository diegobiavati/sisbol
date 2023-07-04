<?php
  class ColTempoSerPer2 implements IColTempoSerPer2
  {
    private $arrayTempoSerPer;
    public function ColTempoSerPer2()
    {
    }
    public function incluirRegistro($TempoSerPer)
    { $this->arrayTempoSerPer[$TempoSerPer->getdataIn()->GetcDataYYYYHMMHDD()] = $TempoSerPer;
    }
    public function alterarRegistro($TempoSerPer)
    { $this->arrayTempoSerPer[$TempoSerPer->getdataIn()->GetcDataYYYYHMMHDD()] = $TempoSerPer;
    }
    public function excluirRegistro($TempoSerPer)
    { $this->arrayTempoSerPer[$TempoSerPer->getdataIn()->GetcDataYYYYHMMHDD()] = null;
    }
	public function lerRegistro($codTempoSerPer)
	{ $resultado = NULL;
	  foreach ($this->arrayTempoSerPer as $key=>$value)
	  { if ($value->getdataIn()->GetcDataYYYYHMMHDD() == $codTempoSerPer)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;
	}
	
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayTempoSerPer) > 0)
      { return reset($this->arrayTempoSerPer);
	  }
      else
      { return null;
      }
    }
    
    public function getProximo1()
    { return next($this->arrayTempoSerPer);
    }
    
    public function getQTD()
    { return count($this->arrayTempoSerPer);
	}    
  }
?>
