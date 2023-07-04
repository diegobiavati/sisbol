<?php
  class ConIncOuAltBoletim
  { //propriedades privadas
    private $rgrTipoBol;
    private $rgrBoletim;
    private $rgrFuncao;
    private $rgrMilitar;
    private $rgrAssinaConfereBi;

    //construtor
    public function ConIncOuAltBoletim($rgrTipoBol, $rgrBoletim, $rgrFuncao, $rgrMilitar, $rgrAssinaConfereBi)
    {  $this->rgrTipoBol = $rgrTipoBol;
       $this->rgrBoletim = $rgrBoletim;
       $this->rgrFuncao = $rgrFuncao;
       $this->rgrMilitar = $rgrMilitar;
       $this->rgrAssinaConfereBi = $rgrAssinaConfereBi;
    }
    private function consisteBiAnt($boletim, $oper)
    {
      //obtem o nro do bi anterior
//      echo $boletim->getNumeroBi();
//      die();
      $numeroBiAnt = $boletim->getNumeroBi() - 1;
      //se nao e o primeiro bi do ano
      if ($numeroBiAnt != 0)
      { //le o bi anterior
	    $BoletimAnt = $this->rgrBoletim->lerPorNumeroBi($boletim->getTipoBol()->getCodigo(),$numeroBiAnt, $boletim->getDataPub()->getIAno());
	    //se existe anterior
        if ($BoletimAnt != null)
        { if ($BoletimAnt->getAssinado() != 'S')
          { throw new Exception('RGRBOLETIM->boletim anterior não assinado');
          }
          if ($BoletimAnt->getDataPub()->MaiorQue($boletim->getDataPub()))
          { throw new Exception('RGRBOLETIM->Data do boletim inválida');
          }
        }
      }
    }
    private function getMilitarQueAssina()
    { $lFuncaoQueAssinaBi = $this->rgrFuncao->lerFuncaoQueAssinaBi();

      if ($lFuncaoQueAssinaBi == null)
      { throw new Exception('Função que assina não está cadastrada');
      }
      $lMilitar = $this->rgrMilitar->lerMilitarQueExerceFuncao($lFuncaoQueAssinaBi->getCod());
      if ($lMilitar == null)
      { throw new Exception('Militar que assina o boletim não está cadastrado');
      }
      return $lMilitar;
    }
    private function getMilitarQueConfere()
    { $lFuncaoQueConfere = $this->rgrFuncao->lerFuncaoQueConfere();
      if ($lFuncaoQueConfere == null)
      { throw new Exception('Função que confere não está cadastrada');
      }
      $lMilitar = $this->rgrMilitar->lerMilitarQueExerceFuncao($lFuncaoQueConfere->getCod());
      if ($lMilitar == null)
      { throw new Exception('Militar que confere o boletim não está cadastrado');
      }
      return $lMilitar;
    }
    public function getAssinaConfereBi()
    { $militarAssina = $this->getMilitarQueAssina();
      $militarConfere = $this->getMilitarQueConfere();

      $assinaConfereBi = $this->rgrAssinaConfereBi->lerRegistro($militarAssina->getIdMilitar(),
        $militarAssina->getPGrad()->getCodigo(),
	    $militarAssina->getFuncao()->getCod(),$militarConfere->getIdMilitar(), $militarConfere->getPGrad()->getCodigo(),
	    $militarConfere->getFuncao()->getCod());
	  if ($assinaConfereBi == null)
	  {
	    $assinaConfereBi = new AssinaConfereBi($militarAssina, $militarConfere);
        $assinaConfereBi->setCodigo($this->rgrAssinaConfereBi->getProximoCodigo());
        $this->rgrAssinaConfereBi->incluirRegistro($assinaConfereBi);
	  }
      return $assinaConfereBi;
    }
    public function incluirBoletim($boletim)
    {
      //ler o tipo de boletim
      $tipoBol = $this->rgrTipoBol->lerRegistro($boletim->getTipoBol()->getCodigo());
      if ($tipoBol == null)
        throw new Exception('Tipo de Boletim não existe');

      //incrementa o numero do boletim
      $tipoBol->incNrUltBi();
      //atualiza o tipo de boletim
      $this->rgrTipoBol->alterarRegistro($tipoBol);
      //ajusta o numero do boletim
      $boletim->setNumeroBi($tipoBol->getNrUltBi());
      $boletim->setAssinaConfereBi($this->getAssinaConfereBi());
//	  $boletim->getAssinaConfereBi()->exibeDados();
      //ajusta o tipo de boletim
      $boletim->setTipoBol($tipoBol);
      $this->consisteBiAnt($boletim, 'I',$boletim->getDataPub()->getIAno());
      //echo 'Ano do BI: '. $boletim->getDataPub()->getIAno();
      //inclui o boletim
      $this->rgrBoletim->incluirRegistro($boletim);
    }
    public function alterarBoletim($boletim)
    {
      //ler o tipo de boletim
      $boletim->setAssinaConfereBi($this->getAssinaConfereBi());

      //ajusta o tipo de boletim
      $this->consisteBiAnt($boletim, 'A');
      //inclui o boletim
      $this->rgrBoletim->alterarRegistro($boletim);
    }

  }
?>
