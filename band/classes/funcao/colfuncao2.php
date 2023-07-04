<?php
  class ColFuncao2 implements IColFuncao2
  {
    private $arrayFuncao;
    public function ColFuncao2()
    {
    }
    public function incluirRegistro($Funcao)
    { $this->arrayFuncao[$Funcao->getCod()] = $Funcao;
    }
    public function alterarRegistro($Funcao)
    { $this->arrayFuncao[$Funcao->getCod()] = $Funcao;
    }
    public function excluirRegistro($Funcao)
    { $this->arrayFuncao[$Funcao->getCod()] = null;
    }
	public function lerRegistro($codFuncao)
	{ /*$resultado = NULL;
	  foreach ($this->arrayFuncao as $key=>$value)
	  { if ($value->getCod() == $codFuncao)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $funcao = $this->iniciaBusca1();
	  while ($funcao != null)
	  { if ($funcao->getCod() == $codFuncao)
	    { $resultado = $funcao;
	      break;
	    }
	    $funcao = $this->getProximo1();
	  }
	  return $resultado;
	}
	
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayFuncao) > 0)
      { return reset($this->arrayFuncao);
	  }
      else
      { return null;
      }
    }
    
    public function getProximo1()
    { return next($this->arrayFuncao);
    }
    
    public function getQTD()
    { return count($this->arrayFuncao);
	}    
  }
?>
