<?php
  class ColFuncaoDoSistema2 implements IColFuncaoDoSistema2
  {
    private $arrayFuncao;
    public function ColFuncaoDoSistema2()
    {
    }
    public function incluirRegistro($funcaoDoSistema)
    { $this->arrayFuncao[$funcaoDoSistema->getCodigo()] = $funcaoDoSistema;
    }
    public function alterarRegistro($funcaoDoSistema)
    { $this->arrayFuncao[$funcaoDoSistema->getCodigo()] = $funcaoDoSistema;
    }
    public function excluirRegistro($funcaoDoSistema)
    { $this->arrayFuncao[$funcaoDoSistema->getCodigo()] = null;
    }
	public function LerRegistro($codigo)
	{ $resultado = null;
	  $funcaoDoSistema = $this->iniciaBusca1();
	  while ($funcaoDoSistema != null)
	  { if ($funcaoDoSistema->getCodigo() == $codigo)
	    { $resultado = $funcaoDoSistema;
	      break;
	    }
	    $funcaoDoSistema = $this->getProximo1();
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
