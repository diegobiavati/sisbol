<?php
  class RgrAssinaConfereBi
  { private $colAssinaConfereBi;
    public function RgrAssinaConfereBi($colAssinaConfereBi)
    { $this->colAssinaConfereBi = $colAssinaConfereBi;
    }
    private function consisteDados($assinaConfereBi, $oper)
    { 
      if ($assinaConfereBi->getMilitarAssina()->getIdMilitar() === $assinaConfereBi->getMilitarConfere()->getIdMilitar())
      { throw new Exception('RGRASSINACONFEREBI->Militar que assina='.  $assinaConfereBi->getMilitarAssina()->getIdMilitar() .
	     ' não pode ser o mesmo que confere=' . $assinaConfereBi->getMilitarConfere()->getIdMilitar());
      }
      if ($assinaConfereBi->getMilitarAssina()->getFuncao()->getCod() == $assinaConfereBi->getMilitarConfere()->getFuncao()->getCod())
      { throw new Exception('RGRASSINACONFEREBI->Função do Militar que assina não pode ser a mesmo do militar que confere!');
      }
    }
    public function incluirRegistro($assinaConfereBi)
    { $this->consisteDados($assinaConfereBi, 'I');
	  $this->colAssinaConfereBi->incluirRegistro($assinaConfereBi);
    }
    public function lerRegistro($codMilitarAssina, $codPGradMilitarAssina, $codFuncaoMilitarAssina, $codMilitarConfere, 
	  $codPGradMilitarConfere, $codFuncaoMilitarConfere)//alterado
	{ return $this->colAssinaConfereBi->lerRegistro($codMilitarAssina, $codPGradMilitarAssina, $codFuncaoMilitarAssina, $codMilitarConfere, 
	  $codPGradMilitarConfere, $codFuncaoMilitarConfere);
	}
    public function lerPorCodigo($codigo)
	{ return $this->colAssinaConfereBi->lerPorCodigo($codigo);
	} 
    public function getProximoCodigo()
    { return $this->colAssinaConfereBi->getProximoCodigo();
	}    
  }
?>
