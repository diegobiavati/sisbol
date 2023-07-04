<?php
  class ColPessoaMateriaBi2 implements IColPessoaMateriaBi2
  {  
	private $arrayPessoaMateriaBi;
    public function ColPessoaMateriaBi2()
    {
    }
    public function incluirRegistro($pessoaMateriaBi)
    { $this->arrayPessoaMateriaBi[$pessoaMateriaBi->getPessoa()->getIdMilitar()] = $pessoaMateriaBi;
    }
    public function alterarRegistro($pessoaMateriaBi)
    { $this->arrayPessoaMateriaBi[$pessoaMateriaBi->getPessoa()->getIdMilitar()] = $pessoaMateriaBi;
    }
    public function excluirRegistro($pessoaMateriaBi)
    { $this->arrayPessoaMateriaBi[$pessoaMateriaBi->getPessoa()->getCodigo()] = null;
    }
	public function LerRegistro($idtMilitar)
	{ $resultado = null;
	  $pessoaMateriaBi = $this->iniciaBusca1();
	  while ($pessoaMateriaBi != null)
	  { if ($pessoaMateriaBi->getIdMilitar() == $idtMilitar)
	    { $resultado = $pessoaMateriaBi;
	      break;
	    }
	    $pessoaMateriaBi = $this->getProximo1();
	  }
	  return $resultado;
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayPessoaMateriaBi) > 0)
      { return reset($this->arrayPessoaMateriaBi);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayPessoaMateriaBi);
    }
    public function getQTD()
    { return count($this->arrayPessoaMateriaBi);
	}    
  }
?>
