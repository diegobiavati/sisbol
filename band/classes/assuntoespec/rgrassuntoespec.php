<?php
  class RgrAssuntoEspec
  { private $colAssuntoEspec;
    public function RgrAssuntoEspec($colAssuntoEspec)
    { $this->colAssuntoEspec = $colAssuntoEspec;
    }
    private function consisteDados($assuntoGeral, $assuntoEspec, $oper)
    {
      if ($assuntoEspec->getDescricao() == '')
      { throw new Exception('RGRASSUNTOESPECIFICO->Descrição do assunto inválida!');
      }
      /*if ($assuntoEspec->getTextoPadAbert() == '')
      { throw new Exception('Texto de abertura inválido!');
      }*/
    }
    public function incluirRegistro($assuntoGeral, $assuntoEspec)
    { $this->consisteDados($assuntoGeral, $assuntoEspec, 'I');
	  $this->colAssuntoEspec->incluirRegistro($assuntoGeral, $assuntoEspec);
    }
    public function alterarRegistro($assuntoGeral, $assuntoEspec)
    { $this->consisteDados($assuntoGeral, $assuntoEspec, 'A');
	  $this->colAssuntoEspec->alterarRegistro($assuntoGeral, $assuntoEspec);
    }
    public function excluirRegistro($assuntoGeral, $assuntoEspec)
    { $this->colAssuntoEspec->excluirRegistro($assuntoGeral, $assuntoEspec);
    }
    public function lerRegistro($codAssuntoGeral, $codAssuntoEspec)
    { return $this->colAssuntoEspec->lerRegistro($codAssuntoGeral, $codAssuntoEspec);
    }
    public function lerUltimoRegistro(){
      return $this->colAssuntoEspec->lerUltimoRegistro();
    }
    public function incluirColecao($assuntoGeral)
    { $assuntoEspec = $assuntoGeral->getColAssuntoEspec2()->iniciaBusca1();
      while ($assuntoEspec != null)
	  { $this->incluirRegistro($assuntoGeral, $assuntoEspec);
	    $assuntoEspec = $assuntoGeral->getColAssuntoEspec2()->getProximo1();
	  }
    }
    public function alterarColecao($assuntoGeral)
    { //obtem a colecao anterior
	  $colAssuntoEspecAnt = $this->colAssuntoEspec->lerColecao($assuntoGeral->getCodigo());
	  //comeca a varrer a nova colecao
	  $assuntoEspec = $assuntoGeral->getColAssuntoEspec2()->iniciaBusca1();
      while ($assuntoEspec != null)
	  { //verifica se existia na colecao anterior
	    $lAssuntoEspec = $colAssuntoEspecAnt->lerRegistro($assuntoEspec->getCodigo());
	    if ($lAssuntoEspec == null)
	    { //se nao existia inclui
		  $this->incluirRegistro($assuntoGeral, $assuntoEspec);
		}
	    else
	    { // se existia, altera
		  $this->alterarRegistro($assuntoGeral, $assuntoEspec);
	    }
	    //obtem o proximo da nova colecao
	    $assuntoEspec = $assuntoGeral->getColAssuntoEspec2()->getProximo1();
	  }
	  //comeca a varrer a colecao antiga
	  $assuntoEspec = $colAssuntoEspecAnt->iniciaBusca1();
      while ($assuntoEspec != null)
	  { //
	    $lAssuntoEspec = $assuntoGeral->getColAssuntoEspec2()->lerRegistro($assuntoEspec->getCodigo());
	    if ($lAssuntoEspec == null)
	    { $this->excluirRegistro($assuntoGeral, $assuntoEspec);
		}
	    $assuntoEspec = $colAssuntoEspecAnt->getProximo1();
	  }
    }
//
    public function excluirColecao($assuntoGeral)
    { //obtem a colecao anterior
	  $colAssuntoEspecAnt = $this->colAssuntoEspec->lerColecao($assuntoGeral->getCodigo());
	  //comeca a varrer a colecao antiga
	  $assuntoEspec = $colAssuntoEspecAnt->iniciaBusca1();
      while ($assuntoEspec != null)
	  { //
	    $this->excluirRegistro($assuntoGeral, $assuntoEspec);
	    $assuntoEspec = $colAssuntoEspecAnt->getProximo1();
	  }
    }
    public function lerColecao($codAssuntoGeral)
    {  return $this->colAssuntoEspec->lerColecao($codAssuntoGeral);
    }
    public function buscaLetras($codAssuntoGeral)
    {  return $this->colAssuntoEspec->buscaLetras($codAssuntoGeral);
    }

    public function lerColecaoLike($codAssuntoGeral,$like)
    {  return $this->colAssuntoEspec->lerColecaoLike($codAssuntoGeral,$like);
    }

//
  }
?>
