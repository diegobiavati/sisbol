<?php
  class RgrPGrad 
  { private $colPGrad;
  	private function consisteDados($pGrad, $oper)
    { 
	  if (!is_numeric($pGrad->getCodigo()))
      { 
	    throw new Exception('RGRPOSTOGRAD->Código do documento inválido');
      }
      if ($pGrad->getDescricao() == '')
      { throw new Exception('RGRPOSTOGRAD->Descrição do documento inválida');
      }
     
    }
    public function RgrPGrad($colPGrad)
    { $this->colPGrad = $colPGrad;
    }
    public function incluirRegistro($pGrad)
    { $this->consisteDados($pGrad, 'I');
      $this->colPGrad->incluirRegistro($pGrad);
    }
    public function alterarRegistro($pGrad)
    { $this->consisteDados($pGrad, 'A');
      $this->colPGrad->alterarRegistro($pGrad);
    }
    public function excluirRegistro($pGrad)
    { $this->colPGrad->excluirRegistro($pGrad);
    }
    public function lerRegistro($codPGrad)
    { return $this->colPGrad->lerRegistro($codPGrad);
    }
    public function lerColecao($ordem)
    { return $this->colPGrad->lerColecao($ordem);
	}   
  }
?>
