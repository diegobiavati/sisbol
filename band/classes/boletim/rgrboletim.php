<?php
  class RgrBoletim
  { private $colBoletim;
    public function RgrBoletim($colBoletim)
    { $this->colBoletim = $colBoletim;
    }
    private function consisteDados($boletim, $oper)
    {
	  if (!is_numeric($boletim->getNumeroBi()))
      { throw new Exception('RGRBOLETIM->n�mero BI= ' . $boletim->getNumeroBi() .  ' inv�lido');
      }
      if ($boletim->getPagInicial() < 0)
      { throw new Exception('RGRBOLETIM->p�gina inicial inv�lida');
      }
      if ($boletim->getPagFinal() < 0)
      { throw new Exception('RGRBOLETIM->p�gina final inv�lida');
      }
      if ($boletim->getPagFinal() < $boletim->getPagInicial())
      { throw new Exception('RGRBOLETIM->n�meros de p�gina inv�lidos, pag. Inicial = '. $boletim->getPagInicial() .
	      ' Pag Final ' . $boletim->getPagFinal());
      }
      if (($boletim->getAssinado() != 'S') and ($boletim->getAssinado() != 'N'))
      { throw new Exception('RGRBOLETIM->campo assinado inv�lido');
      }
      if (($boletim->getAprovado() != 'S') and ($boletim->getAprovado() != 'N'))
      { throw new Exception('RGRBOLETIM->Campo assinado inv�lido');
      }
      if (($boletim->getAssinado() == 'S') and ($boletim->getAprovado() == 'N') and ($_SESSION['APROVBOLETIM']=='S'))
      { throw new Exception('RGRBOLETIM->boletim foi assinado sem ter sido aprovado');
      }
//    $this->consisteBiAnt($boletim, $oper);
    }
    public function incluirRegistro($boletim)
    { $this->consisteDados($boletim, 'I');
	  //alterado para n�o incluir um BI que j� exista - rv 06
	  $lBoletim = $this->colBoletim->lerPorNumeroBi($boletim->getTipoBol()->getCodigo(), $boletim->getNumeroBi(), $boletim->getDataPub()->getIAno());
      if ($lBoletim != null)
      { throw new Exception('RGRBOLETIM->Boletim j� existente!');
      }
	  $this->colBoletim->incluirRegistro($boletim);
    }
    public function alterarRegistro($boletim)
    { $this->consisteDados($boletim, 'A');
	  $this->colBoletim->alterarRegistro($boletim);
    }
    public function excluirRegistro($boletim)
//    { $lBoletim = $this->colBoletim->lerPorNumeroBi($boletim->getTipoBol()->getCodigo(), $boletim->getNumeroBi()+1, $boletim->getDataPub()->GetcDataYYYYHMMHDD());
    { $lBoletim = $this->colBoletim->lerPorNumeroBi($boletim->getTipoBol()->getCodigo(), $boletim->getNumeroBi()+1, $boletim->getDataPub()->getIAno());
      if ($lBoletim != null)
      { throw new Exception('RGRBOLETIM->boletim n�o pode ser exclu�do porque j� existe um subsequente');
      }
	  if (($boletim->getAssinado() == 'S') or ($boletim->getAprovado() == 'S'))
      { throw new Exception('RGRBOLETIM->boletim foi assinado ou aprovado n�o pode ser exclu�do');
      }

	  $this->colBoletim->excluirRegistro($boletim);
    }
    public function aprovarBoletim($boletim)
    {
	  $boletim = $this->lerPorCodigo($boletim->getCodigo());
      if ($boletim == null)
      { throw new Exception('Boletim n�o Existe');
      }
      if ($boletim->getAssinado() == 'S')
      { throw new Exception('Boletim j� foi assinado');
      }
      if ($boletim->getAprovado() == 'S')
      { throw new Exception('Boletim j� foi aprovado');
      }
      $boletim->setAprovado('S');
      $this->alterarRegistro($boletim);
    }
    public function cancelarAprovarBoletim($boletim)
    {
	  $boletim = $this->lerPorCodigo($boletim->getCodigo());
      if ($boletim == null)
      { throw new Exception('Boletim n�o Existe');
      }
      if ($boletim->getAssinado() == 'S')
      { throw new Exception('Boletim j� foi assinado');
      }
      if ($boletim->getAprovado() != 'S')
      { throw new Exception('Boletim n�o foi aprovado');
      }
      $boletim->setAprovado('N');
      $this->alterarRegistro($boletim);
    }
    public function assinarBoletim($boletim)
    {
	  $boletim = $this->lerPorCodigo($boletim->getCodigo());
      if ($boletim == null)
      { throw new Exception('Boletim n�o Existe');
      }
      if ($boletim->getAssinado() == 'S')
      { throw new Exception('Boletim j� foi assinado');
      }
      if (($boletim->getAprovado() != 'S') and ($_SESSION['APROVBOLETIM']=='S'))
      { throw new Exception('Boletim n�o foi aprovado');
      }
      $boletim->setAssinado('S');
      $this->alterarRegistro($boletim);
    }
    public function cancelarAssinarBoletim($boletim)
    {
	  $boletim = $this->lerPorCodigo($boletim->getCodigo());
      if ($boletim == null)
      { throw new Exception('Boletim n�o Existe');
      }
      if ($boletim->getAssinado() != 'S')
      { throw new Exception('Boletim n�o foi assinado');
      }
      $boletim->setAssinado('N');
      $this->alterarRegistro($boletim);
    }
    public function lerPorCodigo($cod)
    { return $this->colBoletim->lerPorCodigo($cod);
    }
    public function lerPorNumeroBi($codTipoBol, $numeroBi, $anoBi)
//    { return $this->colBoletim->lerPorNumeroBi($codTipoBol, $numeroBi);
    { return $this->colBoletim->lerPorNumeroBi($codTipoBol, $numeroBi, $anoBi);
    }
    public function lerPorBiTipo($codTipoBol,$codBiAtual)
//    { return $this->colBoletim->lerPorNumeroBi($codTipoBol, $numeroBi);
    { return $this->colBoletim->lerPorBiTipo($codTipoBol,$codBiAtual);
    }
    public function lerColecao($aprovado, $assinado,$codTipoBol,$ordem,$ano)
    { return $this->colBoletim->lerColecao($aprovado, $assinado,$codTipoBol,$ordem,$ano);
	}
	public function lerColecaoSemPrimeiro($aprovado, $assinado,$codTipoBol,$ordem,$ano)
    { return $this->colBoletim->lerColecaoSemPrimeiro($aprovado, $assinado,$codTipoBol,$ordem,$ano);
	}
    public function getQTD($codTipoBol)
    { return $this->colBoletim->getQTD($codTipoBol);
    }
    public function getAnosBI(){
    	 return $this->colBoletim->getAnosBI();
    }
    public function lerUltBi($codTipoBol)
    {
    	return $this->colBoletim->lerUltBi($codTipoBol);
    }
    //PARREIRA 07-06-2013 - Valida encerrar ano
    public function valEncerraAno()
    {
        return $this->colBoletim->valEncerraAno();
    	
    }
//
  }
?>
