<?php
  class RgrMateriaBi
  { private $colMateriaBi;
    public function RgrMateriaBi($colMateriaBi)
    { $this->colMateriaBi = $colMateriaBi;
    }
    private function consisteDados($materiaBi, $oper)
    {

//      if ($materiaBi->getNrDocumento() == '')
//      { throw new Exception('RGRMATERIABI->Número do documento inválido');
//      }
      if (($materiaBi->getVaiAltr() != 'S') and ($materiaBi->getVaiAltr() != 'N'))
      { throw new Exception('RGRMATERIABI->Campo vai p/ alterações inválido');
      }
      if (($materiaBi->getAprovada() != 'K') and ($materiaBi->getAprovada() != 'S') and ($materiaBi->getAprovada() != 'N') and ($materiaBi->getAprovada() != 'E')
                    and ($materiaBi->getAprovada() != 'C') and ($materiaBi->getAprovada() != 'X') and ($materiaBi->getAprovada() != 'A'))
      { 
	  throw new Exception('RGRMATERIABI->Campo aprovada inválido');
      }
      
	  if ($materiaBi->getAprovada() == 'S')
      { 
	  
	  throw new Exception('RGRMATERIABI->Matéria aprovada não pode ser alterada');
      }
    }
    public function incluirRegistro($materiaBi, $boletim)
    { $this->consisteDados($materiaBi, 'I');
	  $this->colMateriaBi->incluirRegistro($materiaBi, $boletim);
    }
    public function alterarRegistro($materiaBi, $boletim)
    { $this->consisteDados($materiaBi, 'A');
	  $this->colMateriaBi->alterarRegistro($materiaBi, $boletim);
    }
	// Função para inserir comentário nas NBI - Sgt Bedin
	public function alterarComentario($codMateriaBI, $textoComentario)
    { //$this->consisteDados($materiaBi, 'A');
	  $this->colMateriaBi->alterarComentario($codMateriaBI, $textoComentario);
    }
	//
    public function alterarRegistroSemRestricao($materiaBi, $boletim)
    { $this->colMateriaBi->alterarRegistro($materiaBi, $boletim);
    }
    public function excluirRegistro($materiaBi)
    { if ($materiaBi->getAprovada() == 'S')
      { throw new Exception('RGRMATERIABI->matéria aprovada não pode ser excluída');
      }

      $this->colMateriaBi->excluirRegistro($materiaBi);
    }
    public function lerRegistro($codMateriaBi)
    { return $this->colMateriaBi->lerRegistro($codMateriaBi);
    }
    public function getProximoCodigo()
    { $proximo = $this->colMateriaBi->getProximoCodigo();
      //echo 'proximo 2' . $proximo;
      return $proximo;
    }
    public function lerColecao($codBi, $numeroParte, $numeroSecao)
    {  return $this->colMateriaBi->lerColecao($codBi, $numeroParte, $numeroSecao);
    }
    public function lerColecao2($codTipoBol, $aprovada, $order, $incluidaEmBI, $codom, $codSubun, $todasOmVinc, $todasSubun)
    {  return $this->colMateriaBi->lerColecao2($codTipoBol, $aprovada, $order, $incluidaEmBI, $codom, $codSubun, $todasOmVinc, $todasSubun);
    }
    public function lerColecao3($codBoletim, $order)
    { return $this->colMateriaBi->lerColecao3($codBoletim, $order);
    }
    public function lerBoletimQuePublicou($codMateriaBi)
    {  return $this->colMateriaBi->lerBoletimQuePublicou($codMateriaBi);
    }
    public function aprovarMateriaBi($materiaBi)
    { $materiaBi = $this->colMateriaBi->LerRegistro($materiaBi->getCodigo());
      if ($materiaBi == null)
        throw new Exception('Matéria não existe');
      //nao pode ser aprovada duas vezes
      if ($materiaBi->getAprovada() == 'A')
        throw new Exception('Matéria já foi aprovada');
	  // Com a opção X o nível SU poderá aprovar a nota novamente, mesmo sem corrigir
      if (($materiaBi->getAprovada() != 'C') && ($materiaBi->getAprovada() != 'K') && ($materiaBi->getAprovada() != 'X'))
        throw new Exception('Matéria deve estar no status "Concluída" ou "Corrigida"!');
      $materiaBi->setAprovada('A');
      $this->colMateriaBi->alterarRegistro($materiaBi, null);
    }
    public function publicarMateriaBi($materiaBi)
    { $materiaBi = $this->colMateriaBi->LerRegistro($materiaBi->getCodigo());
      if ($materiaBi == null)
        throw new Exception('Matéria não existe');
      //nao pode ser aprovada duas vezes
      if ($materiaBi->getAprovada() == 'S')
        throw new Exception('Matéria já encontra-se na situação "publicada"');
      $materiaBi->setAprovada('S');
      $this->colMateriaBi->alterarRegistro($materiaBi, null);
    }

    public function concluirMateriaBi($materiaBi)//rv7
    {
        $materiaBi = $this->colMateriaBi->LerRegistro($materiaBi->getCodigo());
        if ($materiaBi == null)
            throw new Exception('Matéria não existe');
            //nao pode ser aprovada duas vezes
        if ($materiaBi->getAprovada() == 'C')
            throw new Exception('Matéria já concluída');
        if ($materiaBi->getAprovada() == 'N')
            $materiaBi->setAprovada('C');
        if ($materiaBi->getAprovada() == 'E')
            $materiaBi->setAprovada('K');
			// inserido sgt vincenzo - v2.3
			// para 1 nivel de aprovacao
        if ($materiaBi->getAprovada() == 'X')
            $materiaBi->setAprovada('A');

        $this->colMateriaBi->alterarRegistro($materiaBi, null);
    }

    public function cancelarAprovarMateriaBi($materiaBi)//ainda nao foi testada
    { $materiaBi = $this->colMateriaBi->LerRegistro($materiaBi->getCodigo());
      if ($materiaBi == null)
        throw new Exception('Matéria não existe');
//      if ($materiaBi->getAprovada() != 'X')
//        throw new Exception('Matéria não foi aprovada!');
      //verifica se ja esta em boletim
      $boletim = $this->colMateriaBi->lerBoletimQuePublicou($materiaBi->getCodigo());
      if ($boletim != null)
        throw new Exception('Matéria incluída em boletim, deve ser primeiro excluída do boletim');
      //ajusta o campo
      $materiaBi->setAprovada('E');
      $this->alterarRegistro($materiaBi, null);
    }

    public function cancelarPublicarMateriaBi($materiaBi)
    { $materiaBi = $this->colMateriaBi->LerRegistro($materiaBi->getCodigo());
      if ($materiaBi == null)
        throw new Exception('Matéria não existe');
//      if ($materiaBi->getAprovada() != 'A' && $materiaBi->getAprovada() != 'C')
//        throw new Exception('Matéria não foi aprovada!');
      //verifica se ja esta em boletim
      $boletim = $this->colMateriaBi->lerBoletimQuePublicou($materiaBi->getCodigo());
      if ($boletim != null)
        throw new Exception('Matéria incluída em boletim, deve ser primeiro excluida do boletim');
      //ajusta o campo
      $materiaBi->setAprovada('E');
      $this->alterarRegistro($materiaBi, null);
    }


    public function incluirMateriaEmBi($materiaBi, $boletim)//ainda não foi testada
	{
		$this->colMateriaBi->alterarRegistro($materiaBi, $boletim);
	}
	public function excluirMateriaDoBi($materiaBi, $boletim) //ainda nao foi testada
    { $this->colMateriaBi->alterarRegistro($materiaBi, null);
	}
	public function setaOrdemMateriaBI($codMateria, $ordemMateria){
		$this->colMateriaBi->setaOrdem($codMateria, $ordemMateria);
	}
	//rev 06
	public function lerColecaoPorAssGer($codBi, $numeroParte, $numeroSecao, $codAssGer){
		return $this->colMateriaBi->lerColecaoPorAssGer($codBi, $numeroParte, $numeroSecao, $codAssGer);
	}
	public function lerQteAssEspPorAssGer($codBi, $numeroParte, $numeroSecao, $codAssGer){
		return $this->colMateriaBi->lerQteAssEspPorAssGer($codBi, $numeroParte, $numeroSecao, $codAssGer);
	}
	public function lerQteAssGerPorSec($codBi, $numeroParte, $numeroSecao){
		return $this->colMateriaBi->lerQteAssGerPorSec($codBi, $numeroParte, $numeroSecao);
	}
    public function lerQteMatPorAssEsp($codBi, $codAssGer, $codAssEsp){
		return $this->colMateriaBi->lerQteMatPorAssEsp($codBi, $codAssGer, $codAssEsp);
	}
  }
?>
