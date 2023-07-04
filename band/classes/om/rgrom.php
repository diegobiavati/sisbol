<?php
  class RgrOM { 
  	private $colOM;
  	private function consisteDados($OM, $oper)
    { 
		if (!is_numeric($OM->getCodigo())){ 
		throw new Exception('RGROM->C�digo do documento inv�lido.');
    	}
    	if ($OM->getCodOM() == ''){ 
			throw new Exception('RGROM->C�digo da OM inv�lida.');
    	}
		if ($OM->getNome() == ''){ 
			throw new Exception('RGROM->Nome da OM inv�lida.');
    	}
		if ($OM->getSigla() == ''){ 
			throw new Exception('RGROM->Sigla da OM inv�lida.');
    	}
		
		if ($OM->getLoc() == ''){ 
			throw new Exception('RGROM->Localiza��o da OM inv�lida.');
    	}
		
		if ($OM->getGu() == ''){ 
			throw new Exception('RGROM->GU da OM inv�lida.');
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
