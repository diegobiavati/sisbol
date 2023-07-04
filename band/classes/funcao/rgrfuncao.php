<?php
  class RgrFuncao 
  { private $colFuncao;
  	private function consisteDados($Funcao, $oper)
    { 
      if ($Funcao->getDescricao() == '')
      { throw new Exception('RGRFUNCAO->Descri��o da fun��o inv�lida');
      }
      if (($Funcao->getAssinaBI() != 'S') and ($Funcao->getAssinaBI() != 'N'))
      { throw new Exception('RGRFUNCAO->Autoriza��o para assinar o BI inv�lida');
      }
      if (($Funcao->getAssinaConfere() != 'S') and ($Funcao->getAssinaConfere() != 'N'))
      { throw new Exception('RGRFUNCAO->Autoriza��o para conferir o BI inv�lida');
      }
      if (($Funcao->getAssinaConfere() == 'S') and ($Funcao->getAssinaBi() == 'S'))
      { throw new Exception('RGRFUNCAO->Autoriza��o para assinar o BI inv�lida');
      }
      if (($Funcao->getAssinaAlt() != 'S') and ($Funcao->getAssinaAlt() != 'N'))
      { throw new Exception('RGRFUNCAO->Autoriza��o para assinar altera��es inv�lida');
      }
      if (($Funcao->getAssinaNota() != 'S') and ($Funcao->getAssinaNota() != 'N'))
      { throw new Exception('RGRFUNCAO->Autoriza��o para assinar Nota pata BI inv�lida');
      }
     
    }
    public function RgrFuncao($colFuncao)
    { $this->colFuncao = $colFuncao;
    }                
    private function atualizaCampoAssinaBi()
    { $lFuncao = $this->colFuncao->lerFuncaoQueAssinaBi(); 
      if ($lFuncao != null)
      { $lFuncao->setAssinaBI('N');
        $this->colFuncao->alterarRegistro($lFuncao);
      }
    }
    private function atualizaCampoConfere()
    { $lFuncao = $this->colFuncao->lerFuncaoQueConfere(); 
      if ($lFuncao != null)
      { $lFuncao->setAssinaConfere('N');
        $this->colFuncao->alterarRegistro($lFuncao);
      }
    }
    private function atualizaCampoAssinaPubliquese()
    { $lFuncao = $this->colFuncao->lerFuncaoQueAssinaPubliquese(); 
      if ($lFuncao != null)
      { $lFuncao->setAssinaPubliquese('N');
        $this->colFuncao->alterarRegistro($lFuncao);
      }
    }
    public function incluirRegistro($Funcao)
    { $this->consisteDados($Funcao, 'I');
      if ($Funcao->getAssinaBI() == 'S')
      {  $this->atualizaCampoAssinaBi();
      }
      if ($Funcao->getAssinaConfere() == 'S')
      {  $this->atualizaCampoConfere();
      }
      if ($Funcao->getAssinaPubliquese() == 'S')
      {  $this->atualizaCampoAssinaPubliquese();
      }
      $this->colFuncao->incluirRegistro($Funcao);
    }
    
    public function alterarRegistro($Funcao)
    { $this->consisteDados($Funcao, 'A');
      if ($Funcao->getAssinaBI() == 'S')
      {  $this->atualizaCampoAssinaBi();
      }
      if ($Funcao->getAssinaConfere() == 'S')
      {  $this->atualizaCampoConfere();
      }
      if ($Funcao->getAssinaPubliquese() == 'S')
      {  $this->atualizaCampoAssinaPubliquese();
      }
      $this->colFuncao->alterarRegistro($Funcao);
    }
    
    public function excluirRegistro($Funcao)
    { $this->colFuncao->excluirRegistro($Funcao);
    }
    public function lerRegistro($codFuncao)
    { return $this->colFuncao->lerRegistro($codFuncao);
    }
    public function lerColecao($ordem)
    { return $this->colFuncao->lerColecao($ordem);
	}   
    public function lerFuncaoQueAssinaBi()
    { return $this->colFuncao->lerFuncaoQueAssinaBi();
    }
    public function lerFuncaoQueAssinaPubliquese()
    { return $this->colFuncao->lerFuncaoQueAssinaPubliquese();
    }
    public function lerFuncaoQueConfere()
    { return $this->colFuncao->lerFuncaoQueConfere();
    }
  }
?>
