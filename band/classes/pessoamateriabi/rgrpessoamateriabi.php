<?php
  class RgrPessoaMateriaBi
  { private $colPessoaMateriaBi;
    public function RgrPessoaMateriaBi($colPessoaMateriaBi)
    { $this->colPessoaMateriaBi = $colPessoaMateriaBi;
    }
    private function consisteDados($materiaBi, $pessoaMateriaBi, $oper)
    { 
    }
    public function incluirRegistro($materiaBi, $pessoaMateriaBi)
    { $this->consisteDados($materiaBi, $pessoaMateriaBi, 'I');
	  $this->colPessoaMateriaBi->incluirRegistro($materiaBi, $pessoaMateriaBi);
    }
    public function alterarRegistro($materiaBi, $pessoaMateriaBi)
    { $this->consisteDados($materiaBi, $pessoaMateriaBi, 'A');
	  $this->colPessoaMateriaBi->alterarRegistro($materiaBi, $pessoaMateriaBi);
    }
    public function excluirRegistro($materiaBi, $pessoaMateriaBi)
    { $this->colPessoaMateriaBi->excluirRegistro($materiaBi, $pessoaMateriaBi);
    }
    public function lerRegistro($codMateriaBi, $idtMilitar)
    { return $this->colPessoaMateriaBi->lerRegistro($codMateriaBi, $idtMilitar);
    }
    public function incluirColecao($materiaBi)
    { $pessoaMateriaBi = $materiaBi->getColPessoaMateriaBi2()->iniciaBusca1();
      while ($pessoaMateriaBi != null)
	  { $this->incluirRegistro($materiaBi, $pessoaMateriaBi);
	    $pessoaMateriaBi = $materiaBi->getColPessoaMateriaBi2()->getProximo1(); 
	  }
    }
    public function alterarColecao($materiaBi)
    { //obtem a colecao anterior
	  $colPessoaMateriaBiAnt = $this->colPessoaMateriaBi->lerColecao($materiaBi->getCodigo());
	  //comeca a varrer a nova colecao
	  $pessoaMateriaBi = $materiaBi->getColPessoaMateriaBi2()->iniciaBusca1();
      while ($pessoaMateriaBi != null)
	  { //verifica se existia na colecao anterior
	    $lPessoaMateriaBi = $colPessoaMateriaBiAnt->lerRegistro($pessoaMateriaBi->getPessoa()->getIdtMilitar());
	    if ($lPessoaMateriaBi == null)
	    { //se nao existia inclui
		  $this->incluirRegistro($materiaBi, $pessoaMateriaBi);
		}
	    else
	    { // se existia, altera
		  $this->alterarRegistro($materiaBi, $pessoaMateriaBi);
	    }
	    //obtem o proximo da nova colecao
	    $pessoaMateriaBi = $materiaBi->getColPessoaMateriaBi2()->getProximo1(); 
	  }
	  //comeca a varrer a colecao antiga
	  $pessoaMateriaBi = $colPessoaMateriaBiAnt->iniciaBusca1();
      while ($pessoaMateriaBi != null)
	  { //
	    $lPessoaMateriaBi = $materiaBi->getColPessoaMateriaBi2()->lerRegistro($pessoaMateriaBi->getPessoa()->getIdtMilitar->getCodigo());
	    if ($lPessoaMateriaBi == null)
	    { $this->excluirRegistro($materiaBi, $pessoaMateriaBi);
		}
	    $pessoaMateriaBi = $colPessoaMateriaBiAnt->getProximo1(); 
	  }
    }
//
    public function excluirColecao($materiaBi)
    { //obtem a colecao anterior
	  $colPessoaMateriaBiAnt = $this->colPessoaMateriaBi->lerColecao($materiaBi->getCodigo());
	  //comeca a varrer a colecao antiga
	  $pessoaMateriaBi = $colPessoaMateriaBiAnt->iniciaBusca1();
      while ($pessoaMateriaBi != null)
	  { //
	    $this->excluirRegistro($materiaBi, $pessoaMateriaBi);
	    $pessoaMateriaBi = $colPessoaMateriaBiAnt->getProximo1(); 
	  }
    }
    public function lerColecao($codMateriaBi)
    { return $this->colPessoaMateriaBi->lerColecao($codMateriaBi);
    }
    public function lerAlteracoes($idMilitar, $dtInicio, $dtTermino)
    { return $this->colPessoaMateriaBi->lerAlteracoes($idMilitar, $dtInicio, $dtTermino);
    }
//
  }
?>
