<?php
  class ColAssuntoEspec implements ICOLAssuntoEspec
  { private $db;
    public function ColAssuntoEspec($db)
    { $this->db = $db;
    }
    public function incluirRegistro($assuntoGeral, $assuntoEspec)//alterado
    { $q = "insert into assunto_espec (cod_assunto_ger, descricao, vai_indice, vai_altr, texto_pad_abert, texto_pad_fech) values (" .
	    $assuntoGeral->getCodigo() . ",'" . $assuntoEspec->getDescricao() . "','". $assuntoEspec->getVaiIndice() .
		"','". $assuntoEspec->getVaiAlteracao() . "','" .$assuntoEspec->getTextoPadAbert() . "','" . $assuntoEspec->getTextoPadFech() . "')";
	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLASSUNTOESPC->Registro não Incluido');
	  }
    }
    public function alterarRegistro($assuntoGeral, $assuntoEspec)//alterado
    { $q = "update assunto_espec set
	  			descricao = '" . $assuntoEspec->getDescricao() . "'," .
			  	" vai_indice = '" . $assuntoEspec->getVaiIndice() . "'," .
			  	" vai_altr = '" . $assuntoEspec->getVaiAlteracao() . "'," .
			  	" texto_pad_abert =  '" .$assuntoEspec->getTextoPadAbert() . "'," .
			  	" texto_pad_fech =   '" .$assuntoEspec->getTextoPadFech() . "',";
	  $q = $q . "data_atualiz = now()" ;
	  $q = $q . " where  cod_assunto_ger = " . $assuntoGeral->getCodigo() . " and cod = " . $assuntoEspec->getCodigo();
      //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLASSUNTOESPC->Registro não alterado');
	  }
    }
    public function excluirRegistro($assuntoGeral, $assuntoEspec)
    { $q = "delete from assunto_espec ";
	  $q = $q . " where  cod = " .$assuntoEspec->getCodigo() . ' and ' . ' cod_assunto_ger = ' . $assuntoGeral->getCodigo();
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLASSUNTOESPC->Registro não excluído');
	  }
    }
    public function lerUltimoRegistro()
    { $q  = "select cod, cod_assunto_ger from assunto_espec ";
      $q .= "where  cod = (select max(cod) from assunto_espec)";
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  {
	  	$row = mysqli_fetch_array($result);
        return $this->lerRegistro($row['cod_assunto_ger'],$row['cod']);
	  }
    }

    public function lerRegistro($codAssuntoGeral, $codAssuntoEspec)//alterado
    { $q = "select cod, cod_assunto_ger, descricao, vai_indice, vai_altr, texto_pad_abert, texto_pad_fech from assunto_espec ";
	  $q = $q . " where  cod = " . $codAssuntoEspec . " and cod_assunto_ger = " . $codAssuntoGeral . " order by descricao";
	  //echo $q;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $assuntoEspec = new AssuntoEspec();

        $row = mysqli_fetch_array($result);
        $assuntoEspec->setCodigo($row['cod']);
        $assuntoEspec->setDescricao($row['descricao']);
        $assuntoEspec->setVaiIndice($row['vai_indice']);
        $assuntoEspec->setVaiAlteracao($row['vai_altr']);
        $assuntoEspec->setTextoPadAbert($row['texto_pad_abert']);
        $assuntoEspec->setTextoPadFech($row['texto_pad_fech']);
        return $assuntoEspec;
	  }
    }
    public function lerColecao($codAssuntoGeral)//alterado
    { $q = "select  cod, cod_assunto_ger, descricao, vai_indice, vai_altr, texto_pad_abert, texto_pad_fech from assunto_espec ";
	  $q = $q . " where  cod_assunto_ger = " . $codAssuntoGeral . " order by ltrim(descricao)";
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colAssuntoEspec2 = new ColAssuntoEspec2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $assuntoEspec = new AssuntoEspec();
        $assuntoEspec->setCodigo($row['cod']);
        $assuntoEspec->SetDescricao($row['descricao']);
        $assuntoEspec->SetVaiIndice($row['vai_indice']);
        $assuntoEspec->SetVaiAlteracao($row['vai_altr']);
        $assuntoEspec->SetTextoPadAbert($row['texto_pad_abert']);
        $assuntoEspec->SetTextoPadFech($row['texto_pad_fech']);
        $colAssuntoEspec2->incluirRegistro($assuntoEspec);
      }
      return $colAssuntoEspec2;
    }
    public function buscaLetras($codAssuntoGeral)//alterado
    { $q = "select distinct(substring(ltrim(`descricao`),1,1)) as letras FROM `assunto_espec` ";
      $q = $q . " where  cod_assunto_ger = " . $codAssuntoGeral;
      $q = $q . " order by substring(ltrim(`descricao`),1,1)";
	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colAssuntoEspec2 = new ColAssuntoEspec2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $assuntoEspec = new AssuntoEspec();
        $assuntoEspec->setCodigo($i);
        $assuntoEspec->SetDescricao($row['letras']);
        $colAssuntoEspec2->incluirRegistro($assuntoEspec);
      }
      return $colAssuntoEspec2;
    }


    public function lerColecaoLike($codAssuntoGeral,$like)
    { $q = "select  cod, cod_assunto_ger, descricao, texto_pad_abert, texto_pad_fech from assunto_espec ";
	  $q = $q . " where  cod_assunto_ger = " . $codAssuntoGeral;
	   if ($like != ''){
	  	 $q = $q ." and descricao like '%".$like."%'";
	   }
	  $q = $q . " order by descricao";
	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colAssuntoEspec2 = new ColAssuntoEspec2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $assuntoEspec = new AssuntoEspec();
        $assuntoEspec->setCodigo($row['cod']);
        $assuntoEspec->SetDescricao($row['descricao']);
        $assuntoEspec->SetTextoPadAbert($row['texto_pad_abert']);
        $assuntoEspec->SetTextoPadFech($row['texto_pad_fech']);
        $colAssuntoEspec2->incluirRegistro($assuntoEspec);
      }
      return $colAssuntoEspec2;
    }

  }
?>
