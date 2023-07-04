<?php
  class RgrMilitar 
  { 
  	private $colMilitar;
  	private function consisteDados($Militar, $oper)
    { 
		if ($Militar->getQM() == ''){ 
		throw new Exception('RGRMILITAR->Código da QM inválida.');
    	}
    	if (!is_numeric($Militar->getPGrad()->getCodigo())){ 
			throw new Exception('RGRMILITAR->Código do Posto/Graduação inválido.');
    	}
				
		//if ($Militar->getPrecCP() == ''){ 
		//	throw new Exception('RGRMILITAR->Prec-CP do documento inválido.');
    	//}
		
		if (!is_numeric($Militar->getComportamento())){ 
			throw new Exception('RGRMILITAR->Comportamento do militar inválido.');
    	}
    }
    public function RGRMILITAR($colMilitar)
    { $this->colMilitar = $colMilitar;
    }
    public function incluirRegistro($Militar)
    { $this->consisteDados($Militar, 'I');
      $this->colMilitar->incluirRegistro($Militar);
    }
    public function alterarRegistro($Militar)
    { $this->consisteDados($Militar, 'A');
      $this->colMilitar->alterarRegistro($Militar);
    }
    public function excluirRegistro($Militar)
    { $this->colMilitar->excluirRegistro($Militar);
    }
    public function lerRegistro($idMilitar)
    { return $this->colMilitar->lerRegistro($idMilitar);
    }               
    public function lerMilitarQueExerceFuncao($codFuncao)
    { return $this->colMilitar->lerMilitarQueExerceFuncao($codFuncao);
    }
    public function lerColMilAssAlteracoes($filtro){
		return $this->colMilitar->lerColMilAssAlteracoes($filtro);
	}
    public function lerColecao($ordem,$filtro)
    { return $this->colMilitar->lerColecao($ordem,$filtro);
	}   
    public function lerColMilNaoIncMatBI($codpgrad, $nome, $codMateriaBI, $codom, $codSubun, $todasOmVinc, $todasSubun)
    { return $this->colMilitar->lerColMilNaoIncMatBI($codpgrad, $nome, $codMateriaBI, $codom, $codSubun, $todasOmVinc, $todasSubun);
    }
    public function lerColMilAssNota($filtro){
		return $this->colMilitar->lerColMilAssNota($filtro);
	}
  }
?>
