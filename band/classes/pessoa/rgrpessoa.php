<?php
  class RgrPessoa { 
  	private $colOM;
  	private function consisteDados($Pessoa, $oper)
    {  	if (trim($Pessoa->getIdMilitar()) == ''){ 
			throw new Exception('RGRPESSOA->Identidade inv�lida');
    	}
		if (!is_numeric($Pessoa->getFuncao()->getCod())){ 
			throw new Exception('RGRPESSOA->C�digo da fun��o inv�lida.');
    	}
		if (trim($Pessoa->getNome()) == ''){ 
			throw new Exception('RGRPESSOA->Nome da pessoa= ' . $Pessoa->getNome() . ' inv�lida.');
    	}    	
    	if ($Pessoa->getDataNasc() == ''){ 
			throw new Exception('RGRPESSOA->Data de nascimento inv�lida.');
    	}
    	
    }
    public function RgrPessoa($colPessoa)
    { $this->colPessoa = $colPessoa;
    }
    public function incluirRegistro($Pessoa)
    { $this->consisteDados($Pessoa, 'I');
      $this->colPessoa->incluirRegistro($Pessoa);
    }
    public function alterarRegistro($Pessoa)
    { $this->consisteDados($Pessoa, 'A');
      $this->colPessoa->alterarRegistro($Pessoa);
    }
    public function excluirRegistro($Pessoa)
    { $this->colPessoa->excluirRegistro($Pessoa);
    }
    public function lerRegistro($idMilitar)
    { return $this->colPessoa->lerRegistro($idMilitar);
    }
	public function ativaPessoa($idMilitar)
    { $this->colPessoa->ativaPessoa($idMilitar);
    }    
    public function desativaPessoa($idMilitar)
    { $this->colPessoa->desativaPessoa($idMilitar);
    }
  }
?>
