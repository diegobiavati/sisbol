<?php
  class ColTempoSerPer implements ICOLTempoSerPer
  { private $db;
    public function ColTempoSerPer($db)
    { $this->db = $db;
    }
    public function incluirRegistro($TempoSerPer)
    { 	$q = "insert into tp_sv_per (data_in, data_fim, id_militar_alt, id_militar_assina,";
      	$q = $q ." tp_com_efe_sv_aa,tp_com_efe_sv_mm, tp_com_efe_sv_dd, tp_nao_com_aa, tp_nao_com_mm,";
      	$q = $q ." tp_nao_com_dd,tp_nao_com_texto,tp_med_mil_aa, tp_med_mil_mm, tp_med_mil_dd, tp_med_mil_texto, tp_ser_rel_aa, tp_ser_rel_mm,";
      	$q = $q ." tp_ser_rel_dd, tp_ser_rel_texto, tp_tot_efe_ser_aa, tp_tot_efe_ser_mm, tp_tot_efe_ser_dd, tp_tot_efe_ser_texto, tp_arr_aa,";
      	$q = $q ." tp_arr_mm, tp_arr_dd, tp_arr_texto, tp_n_arr_aa, tp_n_arr_mm,tp_n_arr_dd, tp_n_arr_texto, data_atualiz, assinado)";
	  	$q = $q ." values ('" ;

	  	$q = $q .$TempoSerPer->getdataIn()->GetcDataYYYYHMMHDD()."','";
		$q = $q .$TempoSerPer->getdataFim()->GetcDataYYYYHMMHDD()."','";
		$q = $q .$TempoSerPer->getmilitarAlt()->getIdMilitar()."','";
		$q = $q .$TempoSerPer->getmilitarAss()->getIdMilitar()."',";
		$q = $q .$TempoSerPer->getTemComEfeSer()->getAno().",";
		$q = $q .$TempoSerPer->getTemComEfeSer()->getMes().",";
		$q = $q .$TempoSerPer->getTemComEfeSer()->getDia().",";
		$q = $q .$TempoSerPer->getTemNCom()->getAno().",";
		$q = $q .$TempoSerPer->getTemNCom()->getMes().",";
		$q = $q .$TempoSerPer->getTemNCom()->getDia().",'";
		$q = $q .$TempoSerPer->getTemNCom()->getTexto()."',";
		$q = $q .$TempoSerPer->getTemMedMil()->getAno().",";
		$q = $q .$TempoSerPer->getTemMedMil()->getMes().",";
		$q = $q .$TempoSerPer->getTemMedMil()->getDia().",'";
		$q = $q .$TempoSerPer->getTemMedMil()->getTexto()."',";
		$q = $q .$TempoSerPer->getSerRel()->getAno().",";
		$q = $q .$TempoSerPer->getSerRel()->getMes().",";
		$q = $q .$TempoSerPer->getSerRel()->getDia().",'";
		$q = $q .$TempoSerPer->getSerRel()->getTexto()."',";
		$q = $q .$TempoSerPer->getTotEfeSer()->getAno().",";
		$q = $q .$TempoSerPer->getTotEfeSer()->getMes().",";
		$q = $q .$TempoSerPer->getTotEfeSer()->getDia().",'";
		$q = $q .$TempoSerPer->getTotEfeSer()->getTexto()."',";
		$q = $q .$TempoSerPer->getArr()->getAno().",";
		$q = $q .$TempoSerPer->getArr()->getMes().",";
		$q = $q .$TempoSerPer->getArr()->getDia().",'";
		$q = $q .$TempoSerPer->getArr()->getTexto()."',";
		$q = $q .$TempoSerPer->getNArr()->getAno().",";
		$q = $q .$TempoSerPer->getNArr()->getMes().",";
		$q = $q .$TempoSerPer->getNArr()->getDia().",'";
		$q = $q .$TempoSerPer->getNArr()->getTexto()."',";
		$q = $q ."now(),'";
		$q = $q .$TempoSerPer->getAssinado() . "')";
		//echo $q.'<br><br>';
      	$result = mysqli_query($this->db, $q);
      	$num_rows = mysqli_affected_rows($this->db);

		// vzo versao 2.0
		$r = "update militar set";
		$r .= " comportamento	 	= '".$TempoSerPer->getidComport()."'";
	  	$r .= " where id_militar 	= '".$TempoSerPer->getmilitarAlt()->getIdMilitar()."'";
		$result = mysqli_query($this->db, $r);


		if ($num_rows <= 0){
      		// PARREIRA - 19-06-13
                throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          	//throw new Exception('COLTempoSerPer->Registro não Incluido');
		}
    }
    public function alterarRegistro($TempoSerPer)
    { 	$q = "update tp_sv_per set";
		$q = $q . " data_in 			= '".$TempoSerPer->getdataIn()->GetcDataYYYYHMMHDD()."',";
		$q = $q . " data_fim 			= '".$TempoSerPer->getdataFim()->GetcDataYYYYHMMHDD()."',";
		$q = $q . " id_militar_alt 		= '".$TempoSerPer->getmilitarAlt()->getIdMilitar()."',";
		$q = $q . " id_militar_assina 	= '".$TempoSerPer->getmilitarAss()->getIdMilitar()."',";
		$q = $q . " tp_com_efe_sv_aa 	= ".$TempoSerPer->getTemComEfeSer()->getAno().",";
		$q = $q . " tp_com_efe_sv_mm 	= ".$TempoSerPer->getTemComEfeSer()->getMes().",";
		$q = $q . " tp_com_efe_sv_dd 	= ".$TempoSerPer->getTemComEfeSer()->getDia().",";
		$q = $q . " tp_nao_com_aa 		= ".$TempoSerPer->getTemNCom()->getAno().",";
		$q = $q . " tp_nao_com_mm 		= ".$TempoSerPer->getTemNCom()->getMes().",";
		$q = $q . " tp_nao_com_dd 		= ".$TempoSerPer->getTemNCom()->getDia().",";
		$q = $q . " tp_nao_com_texto 	= '".$TempoSerPer->getTemNCom()->getTexto()."',";
		$q = $q . " tp_med_mil_aa 		= ".$TempoSerPer->getTemMedMil()->getAno().",";
		$q = $q . " tp_med_mil_mm 		= ".$TempoSerPer->getTemMedMil()->getMes().",";
		$q = $q . " tp_med_mil_dd 		= ".$TempoSerPer->getTemMedMil()->getDia().",";
		$q = $q . " tp_med_mil_texto 	= '".$TempoSerPer->getTemMedMil()->getTexto()."',";
		$q = $q . " tp_ser_rel_aa 		= ".$TempoSerPer->getSerRel()->getAno().",";
		$q = $q . " tp_ser_rel_mm 		= ".$TempoSerPer->getSerRel()->getMes().",";
		$q = $q . " tp_ser_rel_dd 		= ".$TempoSerPer->getSerRel()->getDia().",";
		$q = $q . " tp_ser_rel_texto 	= '".$TempoSerPer->getSerRel()->getTexto()."',";
		$q = $q . " tp_tot_efe_ser_aa 	= ".$TempoSerPer->getTotEfeSer()->getAno().",";
		$q = $q . " tp_tot_efe_ser_mm 	= ".$TempoSerPer->getTotEfeSer()->getMes().",";
		$q = $q . " tp_tot_efe_ser_dd 	= ".$TempoSerPer->getTotEfeSer()->getDia().",";
		$q = $q . " tp_tot_efe_ser_texto	= '".$TempoSerPer->getTotEfeSer()->getTexto()."',";
		$q = $q . " tp_arr_aa 			= ".$TempoSerPer->getArr()->getAno().",";
		$q = $q . " tp_arr_mm 			= ".$TempoSerPer->getArr()->getMes().",";
		$q = $q . " tp_arr_dd 			= ".$TempoSerPer->getArr()->getDia().",";
		$q = $q . " tp_arr_texto		= '".$TempoSerPer->getArr()->getTexto()."',";
		$q = $q . " tp_n_arr_aa 		= ".$TempoSerPer->getNArr()->getAno().",";
		$q = $q . " tp_n_arr_mm 		= ".$TempoSerPer->getNArr()->getMes().",";
		$q = $q . " tp_n_arr_dd 		= ".$TempoSerPer->getNArr()->getDia().",";
		$q = $q . " tp_n_arr_texto 		= '".$TempoSerPer->getNArr()->getTexto()."',";
		$q = $q . " data_atualiz 		= now(),";
		$q = $q . " assinado     		= '". $TempoSerPer->getAssinado() . "'";
	  	$q = $q . " where  data_in = '".$TempoSerPer->getdataIn()->GetcDataYYYYHMMHDD()."' and ";
	  	$q = $q . " id_militar_alt = '".$TempoSerPer->getmilitarAlt()->getIdMilitar()."'";
	  //echo $q;
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);

		// vzo versao 2.0 - Esta dando problema no assinar / cancelar
		$r = "update militar set";
		$r .= " comportamento	 	= '".$TempoSerPer->getidComport()."'";
	  	$r .= " where id_militar 	= '".$TempoSerPer->getmilitarAlt()->getIdMilitar()."'";
		$result = mysqli_query($this->db, $r);

	if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLTempoSerPer->Registro não alterado');
	  }
    }
    public function excluirRegistro($TempoSerPer)
    { 	$q = "delete from tp_sv_per ";
	  	$q = $q . " where  data_in = '".$TempoSerPer->getdataIn()->GetcDataYYYYHMMHDD()."' and ";
	  	$q = $q . " id_militar_alt = '".$TempoSerPer->getmilitarAlt()->getIdMilitar()."'";
	  echo $q;
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
    public function lerRegistro($dataIn, $dataFim, $idMilitar)
    {  	$q = "select data_in, data_fim, id_militar_alt, id_militar_assina,";
      	$q = $q . " tp_com_efe_sv_aa,tp_com_efe_sv_mm, tp_com_efe_sv_dd, tp_nao_com_aa, tp_nao_com_mm,";
      	$q = $q . " tp_nao_com_dd, tp_nao_com_texto, tp_med_mil_aa, tp_med_mil_mm, tp_med_mil_dd, tp_med_mil_texto, tp_ser_rel_aa, tp_ser_rel_mm,";
      	$q = $q . " tp_ser_rel_dd, tp_ser_rel_texto, tp_tot_efe_ser_aa, tp_tot_efe_ser_mm, tp_tot_efe_ser_dd, tp_tot_efe_ser_texto, tp_arr_aa,";
      	$q = $q . " tp_arr_mm, tp_arr_dd, tp_arr_texto, tp_n_arr_aa, tp_n_arr_mm, tp_n_arr_dd, tp_n_arr_texto, data_atualiz, assinado ";
	  	$q = $q . " from  tp_sv_per ";
      	$q = $q . " where  data_in >= '". $dataIn->GetcDataYYYYHMMHDD()."'";
      	if ($dataFim !=null)
      	{ $q = $q . " and data_fim <= '" . $dataFim->GetcDataYYYYHMMHDD() . "'";
      	}
	  	$q = $q . " and id_militar_alt = '".$idMilitar."'";
		//echo $q;

		// vzo versao 2.0 - Esta dando problema no assinar / cancelar
		$r = "select comportamento";
	  	$r = $r . " from  militar ";
		$r .= " where id_militar = '".$idMilitar."'";
		$result2 = mysqli_query($this->db, $r);
		$row2 = mysqli_fetch_array($result2);
		$idComport = $row2['comportamento'];

      	$result = mysqli_query($this->db, $q);
	  	if (mysqli_num_rows($result) <= 0){
	  		return null;
	  	} else {

        $row = mysqli_fetch_array($result);

        $dataIn  = new MinhaData($row['data_in']);
        $dataFim = new MinhaData($row['data_fim']);
        $militarAlt = new Militar(null, null, null, null, null, null);
        $militarAss = new Militar(null, null, null, null, null, null);


        $temComEfeSer = new Tempos();
        $temComEfeSer->setAno($row['tp_com_efe_sv_aa']);
        $temComEfeSer->setMes($row['tp_com_efe_sv_mm']);
        $temComEfeSer->setDia($row['tp_com_efe_sv_dd']);

        $temNCom = new Tempos();
        $temNCom->setAno($row['tp_nao_com_aa']);
        $temNCom->setMes($row['tp_nao_com_mm']);
        $temNCom->setDia($row['tp_nao_com_dd']);
        $temNCom->setTexto($row['tp_nao_com_texto']);

        $temMedMil = new Tempos();
        $temMedMil->setAno($row['tp_med_mil_aa']);
        $temMedMil->setMes($row['tp_med_mil_mm']);
        $temMedMil->setDia($row['tp_med_mil_dd']);
        $temMedMil->setTexto($row['tp_med_mil_texto']);

        $temSerRel = new Tempos();
        $temSerRel->setAno($row['tp_ser_rel_aa']);
        $temSerRel->setMes($row['tp_ser_rel_mm']);
        $temSerRel->setDia($row['tp_ser_rel_dd']);
        $temSerRel->setTexto($row['tp_ser_rel_texto']);

        $temTotEfeSer = new Tempos();
        $temTotEfeSer->setAno($row['tp_tot_efe_ser_aa']);
        $temTotEfeSer->setMes($row['tp_tot_efe_ser_mm']);
        $temTotEfeSer->setDia($row['tp_tot_efe_ser_dd']);
        $temTotEfeSer->setTexto($row['tp_tot_efe_ser_texto']);

        $temArr = new Tempos();
        $temArr->setAno($row['tp_arr_aa']);
        $temArr->setMes($row['tp_arr_mm']);
        $temArr->setDia($row['tp_arr_dd']);
        $temArr->setTexto($row['tp_arr_texto']);

        $temNArr = new Tempos();
        $temNArr->setAno($row['tp_n_arr_aa']);
        $temNArr->setMes($row['tp_n_arr_mm']);
        $temNArr->setDia($row['tp_n_arr_dd']);
        $temNArr->setTexto($row['tp_n_arr_texto']);

//        $temNArr->getAssinado($row['assinado']);

	    $TempoSerPer = new TempoSerPer($idComport, $dataIn, $dataFim, $militarAlt, $militarAss, $temComEfeSer, $temNCom, $temMedMil, $temSerRel, $temTotEfeSer, $temArr, $temNArr);

        $TempoSerPer->getmilitarAlt()->setIdMilitar($row['id_militar_alt']);
		$TempoSerPer->getmilitarAss()->setIdMilitar($row['id_militar_assina']);
        $TempoSerPer->setAssinado($row['assinado']);
        return $TempoSerPer;
	  }
    }



    public function lerColecao($filtro,$ordem)
    { 	$q = "select data_in, data_fim, id_militar_alt, id_militar_assina,";
      	$q = $q ." tp_com_efe_sv_aa,tp_com_efe_sv_mm, tp_com_efe_sv_dd, tp_nao_com_aa, tp_nao_com_mm,";
      	$q = $q ." tp_nao_com_dd,tp_nao_com_texto,tp_med_mil_aa, tp_med_mil_mm, tp_med_mil_dd, tp_med_mil_texto, tp_ser_rel_aa, tp_ser_rel_mm,";
      	$q = $q ." tp_ser_rel_dd, tp_ser_rel_texto, tp_tot_efe_ser_aa, tp_tot_efe_ser_mm, tp_tot_efe_ser_dd, tp_tot_efe_ser_texto, tp_arr_aa, tp_arr_texto,";
      	$q = $q ." tp_arr_mm, tp_arr_dd, tp_n_arr_aa, tp_n_arr_mm,tp_n_arr_dd,tp_n_arr_texto,  data_atualiz, assinado ";
	  	$q = $q . " from  tp_sv_per ";
	  	if (isset($filtro)){
	  		$q = $q . " where ".$filtro;
	  	}
	  	if (isset($ordem)){
	  		$q = $q . " order by ".$ordem;
	  	}
      	//echo $q;
	  	$result = mysqli_query($this->db, $q);
      	$num_rows = mysqli_num_rows($result);
      	$colTempoSerPer2 = new ColTempoSerPer2();
      	for ($i = 0 ; $i < $num_rows; $i++){
      		$row = mysqli_fetch_array($result);

      		$dataIn  = new MinhaData($row['data_in']);
	        $dataFim = new MinhaData($row['data_fim']);
	        $militarAlt = new Militar(null, null, null, null, null, null);
	        $militarAss = new Militar(null, null, null, null, null, null);

	        $temComEfeSer = new Tempos();
	        $temComEfeSer->setAno($row['tp_com_efe_sv_aa']);
	        $temComEfeSer->setMes($row['tp_com_efe_sv_mm']);
	        $temComEfeSer->setDia($row['tp_com_efe_sv_dd']);

	        $temNCom = new Tempos();
	        $temNCom->setAno($row['tp_nao_com_aa']);
	        $temNCom->setMes($row['tp_nao_com_mm']);
	        $temNCom->setDia($row['tp_nao_com_dd']);
	        $temNCom->setTexto($row['tp_nao_com_texto']);

	        $temMedMil = new Tempos();
	        $temMedMil->setAno($row['tp_med_mil_aa']);
	        $temMedMil->setMes($row['tp_med_mil_mm']);
	        $temMedMil->setDia($row['tp_med_mil_dd']);
	        $temMedMil->setTexto($row['tp_med_mil_texto']);

	        $temSerRel = new Tempos();
	        $temSerRel->setAno($row['tp_ser_rel_aa']);
	        $temSerRel->setMes($row['tp_ser_rel_mm']);
	        $temSerRel->setDia($row['tp_ser_rel_dd']);
	        $temSerRel->setTexto($row['tp_ser_rel_texto']);

	        $temTotEfeSer = new Tempos();
	        $temTotEfeSer->setAno($row['tp_tot_efe_ser_aa']);
	        $temTotEfeSer->setMes($row['tp_tot_efe_ser_mm']);
	        $temTotEfeSer->setDia($row['tp_tot_efe_ser_dd']);
	        $temTotEfeSer->setTexto($row['tp_tot_efe_ser_texto']);

	        $temArr = new Tempos();
	        $temArr->setAno($row['tp_arr_aa']);
	        $temArr->setMes($row['tp_arr_mm']);
	        $temArr->setDia($row['tp_arr_dd']);
	        $temArr->setTexto($row['tp_arr_texto']);

	        $temNArr = new Tempos();
	        $temNArr->setAno($row['tp_n_arr_aa']);
	        $temNArr->setMes($row['tp_n_arr_mm']);
	        $temNArr->setDia($row['tp_n_arr_dd']);
	        $temNArr->setTexto($row['tp_n_arr_texto']);

		    $TempoSerPer = new TempoSerPer($idComport, $dataIn, $dataFim, $militarAlt, $militarAss, $temComEfeSer, $temNCom, $temMedMil,
					$temSerRel, $temTotEfeSer, $temArr, $temNArr);

	        $TempoSerPer->getmilitarAlt()->setIdMilitar($row['id_militar_alt']);
			$TempoSerPer->getmilitarAss()->setIdMilitar($row['id_militar_assina']);
	        $TempoSerPer->setAssinado($row['assinado']);
			$colTempoSerPer2->incluirRegistro($TempoSerPer);
			//print_r($TempoSerPer);
	  }
	  return $colTempoSerPer2;
    }
    public function getQTD()
    { $q = "select count(*) qtd from tp_sv_per ";
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
  }
?>
