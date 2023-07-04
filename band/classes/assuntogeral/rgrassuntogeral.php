<?php
  class RgrAssuntoGeral
  { private $colAssuntoGeral;
    private function consisteDados($assuntoGeral, $oper)
    {
      if ($assuntoGeral->getDescricao() == '')
      { throw new Exception('RGRASSUNTOGERAL->Descrição do assunto inválido');
      }
    }
    public function RgrAssuntoGeral($colAssuntoGeral)
    { $this->colAssuntoGeral = $colAssuntoGeral;
    }
    public function incluirRegistro($assuntoGeral)
    { $this->consisteDados($assuntoGeral, 'I');
      $this->colAssuntoGeral->incluirRegistro($assuntoGeral);
    }
    public function alterarRegistro($assuntoGeral)
    { $this->consisteDados($assuntoGeral, 'A');
      $this->colAssuntoGeral->alterarRegistro($assuntoGeral);
    }
    public function excluirRegistro($assuntoGeral)
    { $this->colAssuntoGeral->excluirRegistro($assuntoGeral);
    }
    public function lerRegistro($codigo)
    { return $this->colAssuntoGeral->lerRegistro($codigo);
    }
    public function lerUltimoRegistro()
    { return $this->colAssuntoGeral->lerUltimoRegistro();
    }
    public function lerColecao($numeroParte,$numeroSecao,$codTipoBol)
    {  return $this->colAssuntoGeral->lerColecao($numeroParte,$numeroSecao,$codTipoBol);
	}
    public function lerColecaoLike($numeroParte,$numeroSecao,$codTipoBol,$like)
    {  return $this->colAssuntoGeral->lerColecaoLike($numeroParte,$numeroSecao,$codTipoBol,$like);
	}
	 public function setaOrdem($codAssuntoGer, $ordemAssuntoGer)
	 {
	 	return $this->colAssuntoGeral->setaOrdem($codAssuntoGer, $ordemAssuntoGer);
	 }
  }
?>
