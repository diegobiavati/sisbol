<?php
  class ColConfiguracoes implements IColConfiguracoes
  { private $db;
    public function ColConfiguracoes($db)
    { $this->db = $db;
    }
    public function alterarRegistro($Configuracoes)
    { $q = "update configuracoes set ";
      $q = $q . "aprov_nota1 = '".$Configuracoes->getAprovNota1() ."',";
      $q = $q . "aprov_nota2 = '".$Configuracoes->getAprovNota2() ."',";
	  $q = $q . "aprov_boletim = '". $Configuracoes->getAprovBoletim() ."',";
      $q = $q . "imprime_nomes_linha = '".$Configuracoes->getImprimeNomesLinha() . "',";
      $q = $q . "imprime_assinatura = '".$Configuracoes->getImprimeAssinatura() . "',";
	  $q = $q . "imprime_qms = '".$Configuracoes->getImprimeQMS() . "',";
	  $q = $q . "data_atualiz = now()";
	  //echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLConfiguracoes->Registro não alterado');
	  }
    }
    public function lerRegistro()
    { $q = "select aprov_nota1,aprov_nota2,aprov_boletim,imprime_nomes_linha,imprime_assinatura,imprime_qms,
    			data_atualiz from configuracoes";
//	  echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $configuracoes = new Configuracoes();
        $row = mysqli_fetch_array($result);
        $configuracoes->setAprovNota1($row['aprov_nota1']);
        $configuracoes->setAprovNota2($row['aprov_nota2']);
		$configuracoes->setAprovBoletim($row['aprov_boletim']);
		$configuracoes->setImprimeNomesLinha($row['imprime_nomes_linha']);
		$configuracoes->setImprimeAssinatura($row['imprime_assinatura']);
		$configuracoes->setImprimeQMS($row['imprime_qms']);
		$configuracoes->setDataAtualiz($row['data_atualiz']);
        return $configuracoes;
	  }
    }
  }
?>
