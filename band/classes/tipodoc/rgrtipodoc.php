<?php
  class RgrTipoDoc 
  {  private $colTipoDoc;
  	private function consisteDados($tipoDoc, $oper)
    { 
      if ($tipoDoc->getDescricao() == '')
      { throw new Exception('RGRTIPODOC->Descrição do documento inválida');
      }
     
    }
    
    public function RgrTipoDoc($colTipoDoc)
    { $this->colTipoDoc = $colTipoDoc;
    }
    
    public function incluirRegistro($tipoDoc)
    { $this->consisteDados($tipoDoc, 'I');
      $this->colTipoDoc->incluirRegistro($tipoDoc);
    }
    
    public function alterarRegistro($tipoDoc)
    { $this->consisteDados($tipoDoc, 'A');
      $this->colTipoDoc->alterarRegistro($tipoDoc);
    }
    
    public function excluirRegistro($tipoDoc)
    { $this->colTipoDoc->excluirRegistro($tipoDoc);
    }
    
    public function lerRegistro($codDoc)
    { return $this->colTipoDoc->lerRegistro($codDoc);
    }
    
    public function lerColecao($ordem)
    { return $this->colTipoDoc->lerColecao($ordem);
	} 
    
  }
?>
