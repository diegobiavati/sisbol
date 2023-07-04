<?php
  class RgrOMVinc { 
  	private $colOMVinc;
  	private function consisteDados($OMVinc, $oper)
    { 
    	if ($OMVinc->getCodOM() == ''){ 
			throw new Exception('RGROMVinc->Código da OM inválida.');
    	}
		if ($OMVinc->getNome() == ''){ 
			throw new Exception('RGROMVinc->Nome da OM inválida.');
    	}
		if ($OMVinc->getGu() == ''){ 
			throw new Exception('RGROMVinc->GU da OM inválida.');
    	}
    }
    public function RgrOMVinc($colOMVinc)
    { $this->colOMVinc = $colOMVinc;
    }
    public function incluirRegistro($OMVinc)
    { $this->consisteDados($OMVinc, 'I');
      $this->colOMVinc->incluirRegistro($OMVinc);
    }
    public function alterarRegistro($OMVinc)
    { $this->consisteDados($OMVinc, 'A');
      $this->colOMVinc->alterarRegistro($OMVinc);
    }
    public function excluirRegistro($OMVinc)
    { $this->colOMVinc->excluirRegistro($OMVinc);
    }
    public function lerRegistro($codOM)
    { return $this->colOMVinc->lerRegistro($codOM);
    }
    public function lerColecao($ordem)
    { return $this->colOMVinc->lerColecao($ordem);
	}   
  }
?>
