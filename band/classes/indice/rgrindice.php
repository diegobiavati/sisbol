<?php
  class RgrIndice
  { private $colIndice;
    public function RgrIndice($colIndice)
    { $this->colIndice = $colIndice;
    }
    public function lerColecao($codTipoBol, $dtInicio, $dtTermino)
    {  return $this->colIndice->lerColecao($codTipoBol, $dtInicio, $dtTermino);
    }
    public function gerarIndice($codTipoBol, $dtInicio, $dtTermino)
    { $colIndice2 = $this->colIndice->lerColecao($codTipoBol, $dtInicio, $dtTermino);
      $indice = $colIndice2->iniciaBusca1();
      //percorre toda a colecao
	  while ($indice != null) 
	  { $letra = substr($indice->getMateriaBi()->getAssuntoGeral()->getDescricao(),0,1);
	    $letraAnt = $letra;
	    echo $letra;
	    echo '<br>';
	    //percorre pela mesma letra
  	    while (($indice != null) and ($letra == $letraAnt))
	    { $descricaoAssuntoGeral = $indice->getMateriaBi()->getAssuntoGeral()->getDescricao();
	      echo $descricaoAssuntoGeral;
          echo '<br>';
          //percorre pelo assunto geral
          while (($indice != null) and ($letra == $letraAnt) 
		  and ($descricaoAssuntoGeral == $indice->getMateriaBi()->getAssuntoGeral()->getDescricao()))
	      { $descricaoAssuntoEspec = $indice->getMateriaBi()->getAssuntoEspec()->getDescricao();
	        echo $descricaoAssuntoEspec;
     	    echo '<br>';
     	    //percorre pelo assunto especifico
            while (($indice != null) and ($letra == $letraAnt) 
            and ($descricaoAssuntoGeral == $indice->getMateriaBi()->getAssuntoGeral()->getDescricao())
			and ($descricaoAssuntoEspec == $indice->getMateriaBi()->getAssuntoEspec()->getDescricao()))
	        { echo $indice->getBoletim()->getTipoBol()->getAbreviatura() . ' Nº ' . 
			    $indice->getBoletim()->getNumeroBi() . ' de '. 
				$indice->getBoletim()->getDataPub()->GetcDataDDBMMBYYYY() . ' pag. '. 
				$indice->getMateriaBi()->getPagina();
         	  echo '<br>';
     		  $indice = $colIndice2->getProximo1();
     		  if ($indice != null)
     		  { $letra = substr($indice->getMateriaBi()->getAssuntoGeral()->getDescricao(),0,1);
     		  }
     		}
     	  }
	    }
	  }
    }
//
  }
?>
