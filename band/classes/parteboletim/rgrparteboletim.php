<?php
  class RgrParteBoletim 
  { private $colParteBoletim;
    private function consisteDados($parteBoletim, $oper)
    { 
	  if (!is_numeric($parteBoletim->getNumeroParte()))
      { 
	    throw new Exception('RGRPARTEBOLETIM->Número da Parte inválido');
      }
      if ($parteBoletim->getDescricao() == '')
      { throw new Exception('RGRPARTEBOLETIM->Descrição da Parte inválida');
      }
      if ($parteBoletim->getDescrReduz() == '')
      { throw new Exception('RGRPARTEBOLETIM->Descrição reduzida da Parte inválida');
      }
    }
    public function RgrParteBoletim($colParteBoletim)
    { $this->colParteBoletim = $colParteBoletim;
    }
    public function incluirRegistro($parteBoletim)
    { $this->consisteDados($parteBoletim, 'I');
      $this->colParteBoletim->incluirRegistro($parteBoletim);
    }
    public function alterarRegistro($parteBoletim)
    { $this->consisteDados($parteBoletim, 'A');
      $this->colParteBoletim->alterarRegistro($parteBoletim);
    }
    public function excluirRegistro($parteBoletim)
    { $this->colParteBoletim->excluirRegistro($parteBoletim);
    }
    public function lerRegistro($numeroParte)
    { return $this->colParteBoletim->lerRegistro($numeroParte);
    }
    public function lerColecao($ordem)
    { return $this->colParteBoletim->lerColecao($ordem);
	}   
    public function lerParteQuePertenceAssuntoEspec($codAssuntoGeral,$codAssuntoEspec)
    { return $this->colParteBoletim->lerParteQuePertenceAssuntoEspec($codAssuntoGeral,$codAssuntoEspec);
    }
  }
?>
