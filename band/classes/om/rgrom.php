<?php
  class RgrOM { 
  	private $colOM;
  	private function consisteDados($OM, $oper)
    { 
		if (!is_numeric($OM->getCodigo())){ 
		throw new Exception('RGROM->Código do documento inválido.');
    	}
    	if ($OM->getCodOM() == ''){ 
			throw new Exception('RGROM->Código da OM inválida.');
    	}
		if ($OM->getNome() == ''){ 
			throw new Exception('RGROM->Nome da OM inválida.');
    	}
		if ($OM->getSigla() == ''){ 
			throw new Exception('RGROM->Sigla da OM inválida.');
    	}
		
		if ($OM->getLoc() == ''){ 
			throw new Exception('RGROM->Localização da OM inválida.');
    	}
		
		if ($OM->getGu() == ''){ 
			throw new Exception('RGROM->GU da OM inválida.');
    	}
    }
    public function RgrOM($colOM)
    { $this->colOM = $colOM;
    }
    public function incluirRegistro($OM)
    { $this->consisteDados($OM, 'I');
      $this->colOM->incluirRegistro($OM);
    }
    public function alterarRegistro($OM)
    { $this->consisteDados($OM, 'A');
      $this->colOM->alterarRegistro($OM);
    }
    public function excluirRegistro($OM)
    { $this->colOM->excluirRegistro($OM);
    }
    public function lerRegistro()
    { return $this->colOM->lerRegistro();
    }
    public function lerColecao($ordem)
    { return $this->colOM->lerColecao($ordem);
	}   
  }
?>
