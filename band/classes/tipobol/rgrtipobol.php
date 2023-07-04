<?php
  class RgrTipoBol 
  { private $colTipoBol;
  	private function consisteDados($tipoBol, $oper)
    { 
	  if (!is_numeric($tipoBol->getCodigo()))
      { 
	    throw new Exception('RGRTIPOBOL->Código do documento inválido');
      }
	  if (!is_numeric($tipoBol->getNrUltPag()) and ($tipoBol->getNrUltPag()!=null)) //2ª condicao adic rev 06
      { 
	    throw new Exception('RGRTIPOBOL->Número da Ult Pag inválida');
      }
	  if (!is_numeric($tipoBol->getNrUltBi()))
      { 
	    throw new Exception('RGRTIPOBOL->Número da Ult Bi inválido');
      }
      if ($tipoBol->getDescricao() == '')
      { throw new Exception('RGRTIPOBOL->Descrição do tipo de boletim não tem valor definido!');
      }
      if ($tipoBol->getAbreviatura() == '')
      { throw new Exception('RGRTIPOBOL->Abreviatura do tipo de boletim não tem valor definido!');
      }
     
    }
    public function RgrTipoBol($colTipoBol)
    { $this->colTipoBol = $colTipoBol;
    }
    public function incluirRegistro($tipoBol)
    { $this->consisteDados($tipoBol, 'I');
      $this->colTipoBol->incluirRegistro($tipoBol);
    }
    public function alterarRegistro($tipoBol)
    { $this->consisteDados($tipoBol, 'A');
      $this->colTipoBol->alterarRegistro($tipoBol);
    }
    public function excluirRegistro($tipoBol)
    { $this->colTipoBol->excluirRegistro($tipoBol);
    }
    public function lerRegistro($codTipoBol)
    { return $this->colTipoBol->lerRegistro($codTipoBol);
    }
    public function lerColecao($ordem)
    { return $this->colTipoBol->lerColecao($ordem);
	}
	public function encerrarAno()
	{ $colTipoBol2 = $this->colTipoBol->lerColecao('cod');
	  $tipoBol = $colTipoBol2->iniciaBusca1();
	  while ($tipoBol != null)
	  { $tipoBol->setNrUltPag(0);
        $tipoBol->setNrUltBi(0);
        $this->alterarRegistro($tipoBol);
	    $tipoBol = $colTipoBol2->getProximo1();
	  }
	}   
  }
?>
