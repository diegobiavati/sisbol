<?php
  class ColTipoDoc2 implements IColTipoDoc2
  { //propriedade privada (array de objetos)
    private $arrayTipoDoc;
    
    //método construtor
	public function ColTipoDoc2()
    {
    }
    
    public function incluirRegistro($TipoDoc)
    { $this->arrayTipoDoc[$TipoDoc->getCodigo()] = $TipoDoc;
    }
    
    public function alterarRegistro($TipoDoc)
    { $this->arrayTipoDoc[$TipoDoc->getCodigo()] = $TipoDoc;
    }
    
    public function excluirRegistro($TipoDoc)
    { $this->arrayTipoDoc[$TipoDoc->getCodigo()] = null;
    }
    
	public function LerRegistro($codTipoDoc)
	{ /*$resultado = NULL;
	  foreach ($this->arrayTipoDoc as $key=>$value)
	  { if ($value->getCodigo() == $codTipoDoc)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $tipoDoc = $this->iniciaBusca1();
	  while ($tipoDoc != null)
	  { if ($tipoDoc->getCodigo() == $codTipoDoc)
	    { $resultado = $tipoDoc;
	      break;
	    }
	    $tipoDoc = $this->getProximo1();
	  }
	  return $resultado;
	}
	
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayTipoDoc) > 0)
      { return reset($this->arrayTipoDoc);
	  }
      else
      { return null;
      }
    }
    
    public function getProximo1()
    { return next($this->arrayTipoDoc);
    }
    
    public function getQTD()
    { return count($this->arrayTipoDoc);
	}
	 
  }
?>
