<?php
  class ColAssuntoGeral2 implements IColAssuntoGeral2
  {
    private $arrayAssuntoGeral;
    public function ColAssuntoGeral2()
    {
    }
    public function incluirRegistro($assuntoGeral)
    { $this->arrayAssuntoGeral[$assuntoGeral->getCodigo()] = $assuntoGeral;
    }
    public function alterarRegistro($secaoParteBi)
    { $this->arrayAssuntoGeral[$assuntoGeral->getCodigo()] = $secaoParteBi;
    }
    public function excluirRegistro($secaoParteBi)
    { $this->arrayAssuntoGeral[$assuntoGeral->getCodigo()] = null;
    }
	public function LerRegistro($codAssuntoGeral)
	{ $resultado = NULL;
	  foreach ($this->arrayAssuntoGeral as $key=>$value)
	  { if ($value->getCodigo() == $codAssuntoGeral)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayAssuntoGeral) > 0)
      { return reset($this->arrayAssuntoGeral);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayAssuntoGeral);
    }
    public function getQTD()
    { return count($this->arrayAssuntoGeral);
	}    
  }
?>
