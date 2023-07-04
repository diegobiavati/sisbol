<?php
  class RgrSecaoParteBi
  { private $colSecaoParteBi;
    public function RgrSecaoParteBi($colSecaoParteBi)
    { $this->colSecaoParteBi = $colSecaoParteBi;
    }
    private function consisteDados($parteBoletim, $secaoParteBi, $oper)
    { 
	  if (!is_numeric($secaoParteBi->getNumeroSecao()))
      { throw new Exception('Número da seção inválido');
      }
      if ($secaoParteBi->getDescricao() == '')
      { throw new Exception('Descrição da seção inválida');
      }
    }
    public function incluirRegistro($parteBoletim, $secaoParteBi)
    { $this->consisteDados($parteBoletim, $secaoParteBi, 'I');
	  $this->colSecaoParteBi->incluirRegistro($parteBoletim, $secaoParteBi);
    }
    public function alterarRegistro($parteBoletim, $secaoParteBi)
    { $this->consisteDados($parteBoletim, $secaoParteBi, 'A');
	  $this->colSecaoParteBi->alterarRegistro($parteBoletim, $secaoParteBi);
    }
    public function excluirRegistro($parteBoletim, $secaoParteBi)
    { $this->colSecaoParteBi->excluirRegistro($parteBoletim, $secaoParteBi);
    }
    public function lerRegistro($numeroParte, $numeroSecao)
    { $this->colSecaoParteBi->lerRegistro($numeroParte, $numeroSecao);
    }
    public function incluirColecao($parteBoletim)
    { $secaoParteBi = $parteBoletim->getColSecaoParteBi2()->iniciaBusca1();
      while ($secaoParteBi != null)
	  { $this->incluirRegistro($parteBoletim, $secaoParteBi);
	    $secaoParteBi = $parteBoletim->getColSecaoParteBi2()->getProximo1(); 
	  }
    }
    public function alterarColecao($parteBoletim)
    { //obtem a colecao anterior
	  $colSecaoParteBiAnt = $this->colSecaoParteBi->lerColecao($parteBoletim->getNumeroParte());
	  //comeca a varrer a nova colecao
	  $secaoParteBi = $parteBoletim->getColSecaoParteBi2()->iniciaBusca1();
      while ($secaoParteBi != null)
	  { //verifica se existia na colecao anterior
	    $lSecaoParteBi = $colSecaoParteBiAnt->lerRegistro($secaoParteBi->getNumeroSecao());
	    if ($lSecaoParteBi == null)
	    { //se nao existia inclui
		  $this->incluirRegistro($parteBoletim, $secaoParteBi);
		}
	    else
	    { // se existia, altera
		  $this->alterarRegistro($parteBoletim, $secaoParteBi);
	    }
	    //obtem o proximo da nova colecao
	    $secaoParteBi = $parteBoletim->getColSecaoParteBi2()->getProximo1(); 
	  }
	  //comeca a varrer a colecao antiga
	  $secaoParteBi = $colSecaoParteBiAnt->iniciaBusca1();
      while ($secaoParteBi != null)
	  { //
	    $lSecaoParteBi = $parteBoletim->getColSecaoParteBi2()->lerRegistro($secaoParteBi->getNumeroSecao());
	    if ($lSecaoParteBi == null)
	    { $this->excluirRegistro($parteBoletim, $secaoParteBi);
		}
	    $secaoParteBi = $colSecaoParteBiAnt->getProximo1(); 
	  }
    }
//
    public function excluirColecao($parteBoletim)
    { //obtem a colecao anterior
	  $colSecaoParteBiAnt = $this->colSecaoParteBi->lerColecao($parteBoletim->getNumeroParte());
	  //comeca a varrer a colecao antiga
	  $secaoParteBi = $colSecaoParteBiAnt->iniciaBusca1();
      while ($secaoParteBi != null)
	  { //
	    $this->excluirRegistro($parteBoletim, $secaoParteBi);
	    $secaoParteBi = $colSecaoParteBiAnt->getProximo1(); 
	  }
    }
    public function lerColecao($numeroParte)
    {  return $this->colSecaoParteBi->lerColecao($numeroParte);
	}    
//
  }
?>
