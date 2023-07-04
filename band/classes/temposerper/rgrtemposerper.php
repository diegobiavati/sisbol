<?php
  class RgrTempoSerPer { 
  	private $colTempoSerPer;
  	private function consisteDados($TempoSerPer, $oper)
    { 
		if ($TempoSerPer->getTemComEfeSer()->validaDados() != ""){
			throw new Exception('RGRTempoSerPer->'.$TempoSerPer->getTemComEfeSer()->validaDados().
				' do tempo de efetivo serviço');
    	}
    	if ($TempoSerPer->getTemNCom()->validaDados() != ""){
			throw new Exception('RGRTempoSerPer->'.$TempoSerPer->getTemNCom()->validaDados().
				' do tempo não computado');
    	}
    	if ($TempoSerPer->getTemMedMil()->validaDados() != ""){
			throw new Exception('RGRTempoSerPer->'.$TempoSerPer->getTemMedMil()->validaDados().
				' do tempo de serviço para medalha militar');
    	}
    	if ($TempoSerPer->getSerRel()->validaDados() != ""){
			throw new Exception('RGRTempoSerPer->'.$TempoSerPer->getSerRel()->validaDados().
				' do tempo de efetivo serviço relevante');
    	}
    	if ($TempoSerPer->getTotEfeSer()->validaDados() != ""){
			throw new Exception('RGRTempoSerPer->'.$TempoSerPer->getTotEfeSer()->validaDados().
				' do tempo de total de efetivo serviço');
    	}
    	if ($TempoSerPer->getArr()->validaDados() != ""){
			throw new Exception('RGRTempoSerPer->'.$TempoSerPer->getArr()->validaDados().
				' do tempo arregimentado');
    	}
    	if ($TempoSerPer->getNArr()->validaDados() != ""){
			throw new Exception('RGRTempoSerPer->'.$TempoSerPer->getNArr()->validaDados().
				' do tempo Não arregimentado');
    	}
    	if (($TempoSerPer->getAssinado() != 'S') and ($TempoSerPer->getAssinado() != 'N'))
    	{ throw new Exception('RGRTempoSerPer-> Campo assinado inválido');
    	}
    	
		/*
    	if (!is_numeric($TempoSerPer->getCodigo())){ 
		throw new Exception('RGRTempoSerPer->Código do documento inválido.');
    	}
    	if ($TempoSerPer->getCodOM() == ''){ 
			throw new Exception('RGRTempoSerPer->Código da OM inválida.');
    	}
		if ($TempoSerPer->getNome() == ''){ 
			throw new Exception('RGRTempoSerPer->Nome da OM inválida.');
    	}
		if ($TempoSerPer->getSigla() == ''){ 
			throw new Exception('RGRTempoSerPer->Sigla da OM inválida.');
    	}
		
		if ($TempoSerPer->getLoc() == ''){ 
			throw new Exception('RGRTempoSerPer->Localização da OM inválida.');
    	}
		
		if ($TempoSerPer->getGu() == ''){ 
			throw new Exception('RGRTempoSerPer->GU da OM inválida.');
    	}
    	*/
    }
    public function  RgrTempoSerPer($colTempoSerPer)
    { $this->colTempoSerPer = $colTempoSerPer;
    }
    public function incluirRegistro($TempoSerPer)
    { $this->consisteDados($TempoSerPer, 'I');
      $this->colTempoSerPer->incluirRegistro($TempoSerPer);
    }
    public function alterarRegistro($TempoSerPer)
    { $this->consisteDados($TempoSerPer, 'A');
      $this->colTempoSerPer->alterarRegistro($TempoSerPer);
    }
    public function excluirRegistro($TempoSerPer)
    { $this->colTempoSerPer->excluirRegistro($TempoSerPer);
    }
    public function lerRegistro($dataIn, $dataFim, $idMilitar)
    { return $this->colTempoSerPer->lerRegistro($dataIn, $dataFim, $idMilitar);
    }
    public function lerColecao($filtro,$ordem)
    { return $this->colTempoSerPer->lerColecao($filtro,$ordem);
	}   
  }
?>
