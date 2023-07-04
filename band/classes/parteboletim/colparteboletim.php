<?php
  class ColParteBoletim implements ICOLParteBoletim
  { private $db;
    public function ColParteBoletim($db)
    { $this->db = $db;
    }
    public function incluirRegistro($parteBoletim)
    { $q = "insert into parte_boletim (numero_parte, descricao, descr_reduz) values (" . $parteBoletim->getNumeroParte();
      $q = $q . ", '". $parteBoletim->getDescricao() . "','" . $parteBoletim->getDescrReduz() . "')";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLPARTEBOLETIM->Registro não Incluido');
	  }
    }
    public function alterarRegistro($parteBoletim)
    { $q = "update parte_boletim set ";
      $q = $q . "descricao = '" . $parteBoletim->getDescricao() . "', descr_reduz = '" . $parteBoletim->getDescrReduz() . "',";
	  $q = $q . "data_atualiz = now()" ;
	  $q = $q . " where  numero_parte = " . $parteBoletim->getNumeroParte();
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLPARTEBOLETIM->Registro não alterado');
	  }
    }
    public function excluirRegistro($parteBoletim)
    { $q = "delete from parte_boletim ";
	  $q = $q . " where  numero_parte = " . $parteBoletim->getNumeroParte();
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLPARTEBOLETIM->Registro não excluído');
	  }
    }
    public function lerRegistro($numeroParte)
    { $q = "select numero_parte, descricao, descr_reduz from parte_boletim ";
	  $q = $q . " where  numero_parte = " . $numeroParte;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $colSecaoParteBi2 = new ColSecaoParteBi2();
	    $parteBoletim = new ParteBoletim($colSecaoParteBi2);
      
        $row = mysqli_fetch_array($result);
        $parteBoletim->setNumeroParte($row['numero_parte']);
        $parteBoletim->setDescricao($row['descricao']);
        $parteBoletim->SetDescrReduz($row['descr_reduz']);
        return $parteBoletim;
	  
	  }
    }
    public function lerColecao($ordem)
    { $q = "select numero_parte, descricao, descr_reduz, data_atualiz from parte_boletim ";
	  $q = $q . "  order by  " . $ordem;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colParteBoletim2 = new ColParteBoletim2();
      $colSecaoParteBi2 = new ColSecaoParteBi2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $parteBoletim = new ParteBoletim($colSecaoParteBi2);
        $parteBoletim->setNumeroParte($row['numero_parte']);
        $parteBoletim->setDescricao($row['descricao']);
        $parteBoletim->setDescrReduz($row['descr_reduz']);
        $colParteBoletim2->incluirRegistro($parteBoletim);
      }
      return $colParteBoletim2;
    }
    public function lerParteQuePertenceAssuntoEspec($codAssuntoGeral,$codAssuntoEspec)
    { $q = "select parte_boletim.numero_parte, parte_boletim.descricao as descricaoparte, parte_boletim.descr_reduz, secao_parte_bi.numero_secao, ";
      $q = $q . " secao_parte_bi.descricao as descricaosecao,";
      $q = $q . " secao_parte_bi. descricao as descricaosecao from parte_boletim, secao_parte_bi, assunto_geral, assunto_espec ";
	  $q = $q . " where  parte_boletim.numero_parte = secao_parte_bi.numero_parte and ";
	  $q = $q . " secao_parte_bi.numero_parte = assunto_geral.numero_parte and ";
	  $q = $q . " secao_parte_bi.numero_secao = assunto_geral.numero_secao and "; 
	  $q = $q . " assunto_geral.cod_assunto = assunto_espec.cod_assunto_ger";
	  $q = $q . " and assunto_espec.cod = ".$codAssuntoEspec;
	  $q = $q . " and assunto_espec.cod_assunto_ger = ".$codAssuntoGeral;
      $result = mysqli_query($this->db, $q);
	  //echo '<br><b>'.$q.'</b><br>';
      if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $colSecaoParteBi2 = new ColSecaoParteBi2();
	    $parteBoletim = new ParteBoletim($colSecaoParteBi2);
      
        $row = mysqli_fetch_array($result);
        $secaoParteBi = new SecaoParteBi();
        $secaoParteBi->setNumeroSecao($row['numero_secao']);
        $secaoParteBi->setDescricao($row['descricaosecao']);
        
        $parteBoletim->setNumeroParte($row['numero_parte']);
        $parteBoletim->setDescricao($row['descricaoparte']);
        $parteBoletim->SetDescrReduz($row['descr_reduz']);
        return $parteBoletim;
	  
	  }
	}    
/*    public function lerParteQuePertenceAssuntoEspec($codAssuntoGeral,$codAssuntoEspec)
    { $q = "select parte_boletim.numero_parte, parte_boletim.descricao as descricaoparte, parte_boletim.descr_reduz, secao_parte_bi.numero_secao, ";
      $q = $q . " secao_parte_bi.descricao as descricaosecao,";
      $q = $q . " secao_parte_bi. descricao as descricaosecao from parte_boletim, secao_parte_bi, assunto_geral, assunto_espec ";
	  $q = $q . " where  parte_boletim.numero_parte = secao_parte_bi.numero_parte and ";
	  $q = $q . " secao_parte_bi.numero_parte = assunto_geral.numero_parte and ";
	  $q = $q . " secao_parte_bi.numero_secao = assunto_geral.numero_secao and "; 
	  $q = $q . " assunto_geral.cod_assunto = assunto_espec.cod_assunto_ger";
	  $q = $q . " and assunto_espec.cod = ".$codAssuntoEspec;
	  $q = $q . " and assunto_espec.cod_assunto_ger = ".$codAssuntoGeral;
      $result = mysqli_query($this->db, $q);
	  //echo '<br><b>'.$q.'</b><br>';
      if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $colSecaoParteBi2 = new ColSecaoParteBi2();
	    $parteBoletim = new ParteBoletim($colSecaoParteBi2);
      
        $row = mysqli_fetch_array($result);
        $secaoParteBi = new SecaoParteBi();
        $secaoParteBi->setNumeroSecao($row['numero_secao']);
        $secaoParteBi->setDescricao($row['descricaosecao']);
        
        $parteBoletim->setNumeroParte($row['numero_parte']);
        $parteBoletim->setDescricao($row['descricaoparte']);
        $parteBoletim->SetDescrReduz($row['descr_reduz']);
        return $parteBoletim;
	  
	  }
	}    */
  }
?>
