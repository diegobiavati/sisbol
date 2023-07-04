<?php
  class ColSubunidade2 implements IColSubunidade2
  {
    private $arraySubunidade;
    public function ColSubunidade2()
    {
//      $arraySecaoParteBi = array();
    }
    public function incluirRegistro($subunidade)
    { $this->arraySubunidade[$subunidade->getCod()] = $subunidade;
    }
    public function alterarRegistro($subunidade)
    { $this->arraySubunidade[$subunidade->getCod()] = $subunidade;
    }
    public function excluirRegistro($subunidade)
    { $this->arraySubunidade[$subunidade->getCod()] = null;
    }
	public function lerRegistro($codSubun)
	{ /*$resultado = NULL;
	  foreach ($this->arraySecaoParteBi as $key=>$value)
	  { if ($value->getNumeroSecao() == $numeroSecao)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $subunidade = $this->iniciaBusca1();
	  while ($subunidade != null)
	  { if ($subunidade->getCod() == $codSubun)
	    { $resultado = $subunidade;
	      break;
	    }
	    $subunidade = $this->getProximo1();
	  }
	  return $resultado;
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arraySubunidade) > 0)
      { return reset($this->arraySubunidade);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arraySubunidade);
    }
    public function getQTD()
    { return count($this->arraySubunidade);
	}    
  }
?>
