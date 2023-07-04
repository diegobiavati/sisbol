<?php
  class RgrSubunidade
  { private $colSubunidade;
    public function RgrSubunidade($colSubunidade)
    { $this->colSubunidade = $colSubunidade;
    }
    private function consisteDados($omVinc, $subun, $oper)
    { 
	  if (!is_numeric($subun->getCod()))
      { throw new Exception('Código de subunidade inválido - digite apenas números!');
      }
      if ($subun->getDescricao() == '')
      { throw new Exception('Descrição da subunidade inválida');
      }
    }
    public function incluirRegistro($omVinc, $subun)
    { $this->consisteDados($omVinc, $subun, 'I');
	  $this->colSubunidade->incluirRegistro($omVinc, $subun);
    }
    public function alterarRegistro($omVinc, $subun)
    { $this->consisteDados($omVinc, $subun, 'A');
	  $this->colSubunidade->alterarRegistro($omVinc, $subun);
    }
    public function excluirRegistro($omVinc, $subun)
    { $this->colSubunidade->excluirRegistro($omVinc, $subun);
    }
    public function lerRegistro($codom, $codSubun)
    { return $this->colSubunidade->lerRegistro($codom, $codSubun);
    }
    public function incluirColecao($omVinc)
    { $subunidade = $omVinc->getColSubunidade2()->iniciaBusca1();
      while ($subunidade != null)
	  { $this->incluirRegistro($omVinc, $subunidade);
	    $subunidade = $omVinc->getColSubunidade2()->getProximo1();
	  }
    }
    public function alterarColecao($omVinc)
    { //obtem a colecao anterior
	  $colSubunidadeAnt = $this->colSubunidade->lerColecao($omVinc->getCodOM());
	  //comeca a varrer a nova colecao
	  $subunidade = $omVinc->getColSubunidade2()->iniciaBusca1();
      while ($subunidade != null)
	  { //verifica se existia na colecao anterior
	    $lSubunidade = $colSubunidadeAnt->lerRegistro($subunidade->getCod());
	    if ($lSubunidade == null)
	    { //se nao existia inclui
		  $this->incluirRegistro($omVinc, $subunidade);
		}
	    else
	    { // se existia, altera
		  $this->alterarRegistro($omVinc, $subunidade);
	    }
	    //obtem o proximo da nova colecao
	    $subunidade = $omVinc->getColSubunidade2()->getProximo1();
	  }
	  //comeca a varrer a colecao antiga
	  $subunidade = $colSubunidadeAnt->iniciaBusca1();
      while ($subunidade != null)
	  { //
	    $lSubunidade = $omVinc->getColSubunidade2()->lerRegistro($subunidade->getCod());
	    if ($lSubunidade == null)
	    { $this->excluirRegistro($omVinc, $subunidade);
		}
	    $subunidade = $colSubunidadeAnt->getProximo1();
	  }
    }
//
    public function excluirColecao($omVinc)
    { //obtem a colecao anterior
	  $colSubunidadeAnt = $this->colSubunidade->lerColecao($omVinc->getCodOM());
	  //comeca a varrer a colecao antiga
	  $subunidade = $colSubunidadeAnt->iniciaBusca1();
      while ($subunidade != null)
	  { //
	    $this->excluirRegistro($omVinc, $subunidade);
	    $subunidade = $colSubunidadeAnt->getProximo1();
	  }
    }
    public function lerColecao($codom)
    {  return $this->colSubunidade->lerColecao($codom);
	}    
//
  }
?>
