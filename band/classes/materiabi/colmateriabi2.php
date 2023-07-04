<?php
  class ColMateriaBi2 implements IColMateriaBi2
  {
    private $arrayMateriaBi2;
    public function ColMateriaBi2()
    {
    }
    public function incluirRegistro($materiaBi)
    { $this->arrayMateriaBi[$materiaBi->getCodigo()] = $materiaBi;
    }
    public function alterarRegistro($materiaBi)
    { $this->arrayMateriaBi[$materiaBi->getCodigo()] = $materiaBi;
    }
    public function excluirRegistro($materiaBi)
    { $this->arrayMateriaBi[$materiaBi->getCodigo()] = null;
    }
	// Chamar função para inserir comentário nas NBI - Sgt Bedin
	public function alterarComentario($codMateriaBI, $textoComentario)
    { $this->arrayCodMateriaBI[$codMateriaBI->getCodigo()] = null;
    }
	public function LerRegistro($codMateriaBi)
	{ /*$resultado = NULL;
	  foreach ($this->arrayMateriaBi as $key=>$value)
	  { if ($value->getCodigo() == $codMateriaBi)
	    { $resultado = $value;
	    }
	  }
	  return $resultado;*/
	  $resultado = null;
	  $materiaBi = $this->iniciaBusca1();
	  while ($materiaBi != null)
	  { if ($materiaBi->getCodigo() == $codMateriaBi)
	    { $resultado = $materiaBi;
	      break;
	    }
	    $materiaBi = $this->getProximo1();
	  }
	  return $resultado;
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayMateriaBi) > 0)
      { return reset($this->arrayMateriaBi);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayMateriaBi);
    }
    public function getQTD()
    { return count($this->arrayMateriaBi);
	}    
  }
?>
