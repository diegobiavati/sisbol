<?php
  class ColIndicePessoa2 implements IColIndicePessoa2
  {
    private $arrayIndicePessoa;
    public function ColIndicePessoa2()
    {
    }
    public function incluirRegistro($indicePessoa)
    { $this->arrayIndicePessoa[$indicePessoa->getCodigo()] = $indicePessoa;
    }
    public function alterarRegistro($indicePessoa)
    { $this->arrayIndicePessoa[$indicePessoa->getCodigo()] = $indicePessoa;
    }
    public function excluirRegistro($indicePessoa)
    { $this->arrayIndicePessoa[$indicePessoa->getCodigo()] = null;
    }
	public function LerRegistro($codigo)
	{ /*$resultado = NULL;
	  foreach ($this->arrayAssuntoEspec as $key=>$value)
	  { if ($value->getCodigo() == $codAssuntoEspec)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $indicePessoa = $this->iniciaBusca1();
	  while ($indicePessoa != null)
	  { if ($indicePessoa->getCodigo() == $codigo)
	    { $resultado = $indicePessoa;
	      break;
	    }
	    $indicePessoa = $this->getProximo1();
	  }
	  return $resultado;
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayIndicePessoa) > 0)
      { return reset($this->arrayIndicePessoa);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayIndicePessoa);
    }
    public function getQTD()
    { return count($this->arrayIndicePessoa);
	}    
  }
?>
