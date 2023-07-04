<?php
  class ColSecaoParteBi2 implements IColSecaoParteBi2
  {
    private $arraySecaoParteBi;
    public function ColSecaoParteBi2()
    {
//      $arraySecaoParteBi = array();
    }
    public function incluirRegistro($secaoParteBi)
    { $this->arraySecaoParteBi[$secaoParteBi->getNumeroSecao()] = $secaoParteBi;
    }
    public function alterarRegistro($secaoParteBi)
    { $this->arraySecaoParteBi[$secaoParteBi->getNumeroSecao()] = $secaoParteBi;
    }
    public function excluirRegistro($secaoParteBi)
    { $this->arraySecaoParteBi[$secaoParteBi->getNumeroSecao()] = null;
    }
	public function lerRegistro($numeroSecao)
	{ /*$resultado = NULL;
	  foreach ($this->arraySecaoParteBi as $key=>$value)
	  { if ($value->getNumeroSecao() == $numeroSecao)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $secao = $this->iniciaBusca1();
	  while ($secao != null)
	  { if ($secao->getCodigo() == $numeroSecao)
	    { $resultado = $secao;
	      break;
	    }
	    $secao = $this->getProximo1();
	  }
	  return $resultado;
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arraySecaoParteBi) > 0)
      { return reset($this->arraySecaoParteBi);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arraySecaoParteBi);
    }
    public function getQTD()
    { return count($this->arraySecaoParteBi);
	}    
  }
?>
