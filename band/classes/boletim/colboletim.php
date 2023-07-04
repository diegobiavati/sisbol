<?php
  class ColBoletim implements IColboletim
  { private $db;
    public function ColBoletim($db)
    { $this->db = $db;
    }
    public function incluirRegistro($boletim)
    { $q = "insert into boletim (assinado, aprovado, numero_bi,assina_confere_bi, ";
	  $q = $q . " data_pub, tipo_bol_cod, bi_ref) values ('" ;
      $q = $q . $boletim->getAssinado() . "','";
      $q = $q . $boletim->getAprovado() . "'," . $boletim->getNumeroBi() . "," . $boletim->getAssinaConfereBi()->getCodigo() . ",'";
	  $q = $q . $boletim->getDataPub()->GetcDataYYYYHMMHDD() . "',";
	  $q = $q . $boletim->getTipoBol()->getCodigo() . ",'".$boletim->getBiRef()."')";
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLboletim->Registro não Incluido');
	  }
    }
    public function lerPorBiTipo($codTipoBol,$codBiAtual)
    { $q = "select data_pub from";
	  $q = $q . " boletim ";
	  $q = $q . " where  tipo_bol_cod = " . $codTipoBol;
	  $q = $q . " and cod = ".$codBiAtual;
	  if ($result = mysqli_query($this->db, $q)) {
      while ($row = mysqli_fetch_row($result)) {
	  
      	$databi = ($row[0]);
		$_SESSION['databi'] = $databi;
		//echo $data_bi;
    }
	
	
	

    return $result;
}
}
    public function alterarRegistro($boletim)
    { $q = "update boletim set";
	  $q = $q . " pag_inicial = " . $boletim->getPagInicial() . ",";
	  $q = $q . " pag_final = " . $boletim->getPagFinal() . ",";
	  $q = $q . " assinado = '" . $boletim->getAssinado() . "'," ;
	  $q = $q . " aprovado = '" . $boletim->getAprovado() . "'," ;
	  $q = $q . " numero_bi = " . $boletim->getNumeroBi() . "," ;
	  $q = $q . " assina_confere_bi = " . $boletim->getAssinaConfereBi()->getCodigo() . ",";
	  $q = $q . " data_pub = '" . $boletim->getDataPub()->GetcDataYYYYHMMHDD() . "',";
	  $q = $q . " data_atualiz = now()," ;
	  $q = $q . " tipo_bol_cod = " . $boletim->getTipoBol()->getCodigo().",";
	  $q = $q . " bi_ref = '" . $boletim->getBiRef()."'";
	  $q = $q . " where  cod = " .$boletim->getCodigo();
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLBOLETIM->Registro não alterado');
	  }
    }
    public function excluirRegistro($boletim)
    { $q = "delete from boletim ";
	  $q = $q . " where  cod = " .$boletim->getCodigo();
	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLBOLETIM->Registro não excluído');
	  }
    }
    public function lerPorCodigo($cod)
    { $q = "select cod, pag_inicial, pag_final, assinado, aprovado, numero_bi, assina_confere_bi, data_pub, ";
	  $q = $q . "tipo_bol_cod, bi_ref from ";
	  $q = $q . "boletim ";
	  $q = $q . " where  cod = " . $cod;
      //echo $q;
	  $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  {

        $row = mysqli_fetch_array($result);
        $assinaConfereBi = new AssinaConfereBi(null, null);
        $dataPub = new MinhaData($row['data_pub']);
	    $boletim = new Boletim($dataPub, new TipoBol(), $assinaConfereBi, null);

        $boletim->setCodigo($row['cod']);
        $boletim->setPagInicial($row['pag_inicial']);
        $boletim->setPagFinal($row['pag_final']);
        $boletim->setAssinado($row['assinado']);
        $boletim->setAprovado($row['aprovado']);
        $boletim->setNumeroBi($row['numero_bi']);
        $boletim->setBiRef($row['bi_ref']);
        $boletim->getAssinaConfereBi()->setCodigo($row['assina_confere_bi']);
        $boletim->getTipoBol()->setCodigo($row['tipo_bol_cod']);
        //print_r($boletim);
        return $boletim;
	  }
    }
    public function lerPorNumeroBi($codTipoBol, $numeroBi, $anoBi)
    { $q = "select cod, pag_inicial, pag_final, assinado, aprovado, numero_bi, assina_confere_bi, data_pub, ";
	  $q = $q . " tipo_bol_cod, bi_ref from boletim ";
//	  $q = $q . " where numero_bi =  " . $numeroBi . " and tipo_bol_cod = " . $codTipoBol;
	  $q = $q . " where numero_bi =  " . $numeroBi . " and tipo_bol_cod = " . $codTipoBol;
	  $q = $q . " and extract(year from data_pub)=".$anoBi;
//	  echo $q;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  {

        $row = mysqli_fetch_array($result);
        $assinaConfereBi = new AssinaConfereBi(null, null);
        $dataPub = new MinhaData($row['data_pub']);
	    $boletim = new Boletim($dataPub, new TipoBol(), $assinaConfereBi, null);
		$boletim->setCodigo($row['cod']);
        $boletim->setPagInicial($row['pag_inicial']);
        $boletim->setPagFinal($row['pag_final']);
        $boletim->setAssinado($row['assinado']);
        $boletim->setAprovado($row['aprovado']);
        $boletim->setNumeroBi($row['numero_bi']);
        $boletim->setBiRef($row['bi_ref']);
        $boletim->getAssinaConfereBi()->setCodigo($row['assina_confere_bi']);
        $boletim->getTipoBol()->setCodigo($row['tipo_bol_cod']);
        return $boletim;
	  }
    }

	//lê o ultimo bi assinado do tipo recebido no parametro
    public function lerUltBi($codTipoBol)
    { $q = "select cod, pag_inicial, pag_final, assinado, aprovado, numero_bi, assina_confere_bi, data_pub, ";
	  $q = $q . " tipo_bol_cod, bi_ref from boletim ";
	  $q = $q . " where tipo_bol_cod = " . $codTipoBol;
	  $q = $q . " and data_pub=(select max(data_pub) from boletim";
	  $q = $q . " where tipo_bol_cod = " . $codTipoBol . ")";
//	  echo $q;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  {
        $row = mysqli_fetch_array($result);
        $assinaConfereBi = new AssinaConfereBi(null, null);
        $dataPub = new MinhaData($row['data_pub']);
	    $boletim = new Boletim($dataPub, new TipoBol(), $assinaConfereBi, null);
		$boletim->setCodigo($row['cod']);
        $boletim->setPagInicial($row['pag_inicial']);
        $boletim->setPagFinal($row['pag_final']);
        $boletim->setAssinado($row['assinado']);
        $boletim->setAprovado($row['aprovado']);
        $boletim->setNumeroBi($row['numero_bi']);
        $boletim->setBiRef($row['bi_ref']);
        $boletim->getAssinaConfereBi()->setCodigo($row['assina_confere_bi']);
        $boletim->getTipoBol()->setCodigo($row['tipo_bol_cod']);
        return $boletim;
	  }
    }

    public function lerColecao($aprovado,$assinado,$codTipoBol,$ordem,$ano=null)
    { $q = "select b.cod, b.pag_inicial, b.pag_final, b.assinado, b.aprovado, b.numero_bi, ";
      $q .= " b.assina_confere_bi, b.data_pub, t.descricao, ";
	  $q .= " tipo_bol_cod, bi_ref from boletim b, tipo_bol t ";
	  $q .= "  where b.tipo_bol_cod = t.cod ";
	  if (($codTipoBol != null) and ($codTipoBol != 'Todos')) {
		  $q .= " and tipo_bol_cod = ". $codTipoBol;
	  }
	  //verifica se o nivel de aprovacao do Boletim esta ativado
	  if ($aprovado == 'SN')
	  { $q = $q . " and (aprovado = 'S' or aprovado='N')";
	  }
	  if (($aprovado == 'S') || ($aprovado == 'N'))
	  { $q = $q . " and aprovado = '" . $aprovado . "'";
	  }
	  if (($assinado == 'S') || ($assinado == 'N'))
	  { $q = $q . " and assinado = '" . $assinado . "'";
	  }

	  if ($ano != null){
	  	$q = $q . " and EXTRACT(year from data_pub) = " . $ano;
	  }
	  $q = $q . " order by data_pub " . $ordem;
	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colBoletim2 = new ColBoletim2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $dataPub = new MinhaData($row['data_pub']);
        $assinaConfereBi = new AssinaConfereBi(null, null);
	    $boletim = new Boletim($dataPub, new TipoBol(), $assinaConfereBi, null);
		$boletim->setCodigo($row['cod']);
        $boletim->setPagInicial($row['pag_inicial']);
        $boletim->setPagFinal($row['pag_final']);
        $boletim->setAssinado($row['assinado']);
        $boletim->setAprovado($row['aprovado']);
        $boletim->setNumeroBi($row['numero_bi']);
        $boletim->setBiRef($row['bi_ref']);
        $boletim->getAssinaConfereBi()->setCodigo($row['assina_confere_bi']);
        $boletim->getTipoBol()->setCodigo($row['tipo_bol_cod']);
        $boletim->getTipoBol()->setDescricao($row['descricao']);
        $colBoletim2->incluirRegistro($boletim);
	  }
	  return $colBoletim2;
    }

	public function lerColecaoSemPrimeiro($aprovado,$assinado,$codTipoBol,$ordem,$ano=null)
    { $q = "select b.cod, b.pag_inicial, b.pag_final, b.assinado, b.aprovado, b.numero_bi, ";
      $q .= " b.assina_confere_bi, b.data_pub, t.descricao, ";
	  $q .= " tipo_bol_cod, bi_ref from boletim b, tipo_bol t ";
	  $q .= "  where b.tipo_bol_cod = t.cod ";
	  if (($codTipoBol != null) and ($codTipoBol != 'Todos')) {
		  $q .= " and tipo_bol_cod = ". $codTipoBol;
	  }
	  if (($aprovado == 'S') || ($aprovado == 'N'))
	  { $q = $q . " and aprovado = '" . $aprovado . "'";
	  }
	  if (($assinado == 'S') || ($assinado == 'N'))
	  { $q = $q . " and assinado = '" . $assinado . "'";
	  }

	  if ($ano != null){
	  	$q = $q . " and EXTRACT(year from data_pub) = " . $ano;
	  }
	  $q = $q." and b.cod <> (select min(cod) from boletim where tipo_bol_cod = ". $codTipoBol;
	  $q = $q." and aprovado = 'S' and assinado = 'S') ";

	  $q = $q . " order by data_pub " . $ordem;
	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colBoletim2 = new ColBoletim2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $dataPub = new MinhaData($row['data_pub']);
        $assinaConfereBi = new AssinaConfereBi(null, null);
	    $boletim = new Boletim($dataPub, new TipoBol(), $assinaConfereBi, null);
		$boletim->setCodigo($row['cod']);
        $boletim->setPagInicial($row['pag_inicial']);
        $boletim->setPagFinal($row['pag_final']);
        $boletim->setAssinado($row['assinado']);
        $boletim->setAprovado($row['aprovado']);
        $boletim->setNumeroBi($row['numero_bi']);
        $boletim->setBiRef($row['bi_ref']);
        $boletim->getAssinaConfereBi()->setCodigo($row['assina_confere_bi']);
        $boletim->getTipoBol()->setCodigo($row['tipo_bol_cod']);
        $boletim->getTipoBol()->setDescricao($row['descricao']);
        $colBoletim2->incluirRegistro($boletim);
	  }
	  return $colBoletim2;
    }


    public function getQTD($codTipoBol)
    { $q = "select count(*) qtd from boletim where tipo_bol_cod = " . $codTipoBol . " and EXTRACT(year from data_pub) = 2009";
//	  echo $q;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return 0;
	  }
	  else
	  { $row = mysqli_fetch_array($result);
        $qtd = $row['qtd'];
        return $qtd;
	  }
    }
    // Retorna os anos de boletins publicados
    public function getAnosBI()
    { $q = "select distinct EXTRACT(year from data_pub) as anos ";
	  $q = $q . " from boletim ";
	  //echo $q;
      $result = mysqli_query($this->db, $q);

	  $num_rows = mysqli_num_rows($result);
      $colBoletim2 = new ColBoletim2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $dataPub = new MinhaData(trim($row['anos'].'-01-01'));
        $assinaConfereBi = new AssinaConfereBi(null, null);
	    $boletim = new Boletim($dataPub, new TipoBol(), null, null);
        $boletim->setCodigo($i);
		$colBoletim2->incluirRegistro($boletim);
	  }
	  return $colBoletim2;

    }
 // Valida Encerrar ano - PARREIRA 10-06-2013
    public function valEncerraAno()
    {
    $val = "SELECT count(*) AS assin FROM boletim WHERE EXTRACT(YEAR FROM data_pub) = EXTRACT(YEAR FROM CURDATE()) and assinado = 'N'";
    //echo $val;                    
    $result = mysqli_query($this->db, $val);
                        $row = mysqli_fetch_array($result);
                        $assi = $row['assin'];
                        if ($assi > 0) {
                            throw new Exception('<script type="text/javascript"> 
					window.alert("Existe BI em aberto!!!")
                                    </script>'); 
                            
                        }
                        else {
                            echo ('<script type="text/javascript"> 
					window.alert("Ano encerrado com sucesso!!!")
					window.location.href="menuboletim.php"
                                    </script>');
                        }
    
    
  }
    
    
  }
?>
