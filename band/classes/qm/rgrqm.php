<?php
  class RgrQM 
  {  private $colQM;
     private function consisteDados($pQM, $oper)
    { 
	if ($pQM->getCod()=="")
      { 
	    throw new Exception('RGRQM->Código do documento inválido');
      }
    if ($pQM->getDescricao() == "")
      { throw new Exception('RGRQM->Descrição da qualificação militar inválida');
      }
     if ($pQM->getAbreviacao() == "") //bedin
      { throw new Exception('RGRQM->Inválida');
      }
    }
    public function RgrQM($colQM)
    { $this->colQM = $colQM;
    }
    public function incluirRegistro($pQM)
    { $this->consisteDados($pQM, 'I');
      $this->colQM->incluirRegistro($pQM);
    }
    public function alterarRegistro($pQM)
    { $this->consisteDados($pQM, 'A');
      $this->colQM->alterarRegistro($pQM);
    }
    public function excluirRegistro($pQM)
    { $this->colQM->excluirRegistro($pQM);
    }
    public function lerRegistro($codQM)
    { return $this->colQM->lerRegistro($codQM);
    }
     public function lerColecao($ordem)
    { return $this->colQM->lerColecao($ordem);
	}   
  }
?>
