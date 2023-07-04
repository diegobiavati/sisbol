<?php
  class ColMilitar implements IColMilitar
  { private $db;
    public function ColMilitar($db)
    { $this->db = $db;
    }
    public function incluirRegistro($Militar) {
    	$idt_militar = $Militar->getIdMilitar();
    	$q = "insert into militar (id_militar,idt_militar, qm_cod,pgrad_cod,cp,prec_cp,
				cutis,olhos,cabelos,barba,altura,sinais_part,tipo_sang,fator_rh,antiguidade,
				naturalidade,estado_civil,dt_identificacao,bigode,outros,assinatura,data_atualiz,comportamento)
			values ('".$idt_militar. "','".$idt_militar."', '". $Militar->getQM()->getCod()."',
					'". $Militar->getPGrad()->getCodigo() ."','". $Militar->getCP()."',
					'".$Militar->getPrecCP()."','".$Militar->getCutis(). "',
					'". $Militar->getOlhos()."','".$Militar->getCabelos()."',
					'". $Militar->getBarba()."','".$Militar->getAltura()."',
					'". $Militar->getSinaisParticulares()."','".$Militar->getTipoSang()."',
					'". $Militar->getFatorRH()."',".$Militar->getAntiguidade().",'".$Militar->getNaturalidade()."',
					'".$Militar->getEstadoCivil()."','".$Militar->getDataIdt()."','".$Militar->getBigode()."',
					'".$Militar->getOutros()."','".$Militar->getAssinatura()."',now(),
					'". $Militar->getComportamento()."')";
        //echo $q;
      /*$result = mysql_query($q,$this->db);
      $num_rows = mysql_affected_rows();*/
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      //if ($Militar->getIdMilitar() == '1182608230'){
      //	echo $q;
      //}
	  if ($num_rows <= 0)
      { //echo $q;
	  	
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('ColMilitar->Registro não Incluido');
	  }
    }
    public function alterarRegistro($Militar)
    {
//    	print_r($Militar);
		$q = "update militar set ";
		$q = $q . "idt_militar		= '".$Militar->getIdtMilitar()."',"; // rv 05
		$q = $q . "qm_cod 			= '".$Militar->getQM()->getCod()."',";
		$q = $q . "pgrad_cod 		= '".$Militar->getPGrad()->getCodigo()."',";
		$q = $q . "cp 				= '".$Militar->getCP()."',";
		$q = $q . "prec_cp 			= '".$Militar->getPrecCP()."',";
		$q = $q . "data_atualiz 	= 	now(),";
		$q = $q . "cutis 			= '".$Militar->getCutis()."',";
		$q = $q . "olhos 			= '".$Militar->getOlhos()."',";
		$q = $q . "cabelos 			= '".$Militar->getCabelos()."',";
		$q = $q . "barba 			= '".$Militar->getBarba()."',";
		$q = $q . "altura 			= '".$Militar->getAltura()."',";
		$q = $q . "sinais_part 		= '".$Militar->getSinaisParticulares()."',";
		$q = $q . "tipo_sang 		= '".$Militar->getTipoSang()."',";
		$q = $q . "fator_rh 		= '".$Militar->getFatorRH()."',";
		$q = $q . "comportamento 	= '".$Militar->getComportamento()."',";
		$q = $q . "antiguidade 		= ".$Militar->getAntiguidade().",";
		$q = $q . "naturalidade 	= '".$Militar->getNaturalidade()."',";
		$q = $q . "estado_civil 	= '".$Militar->getEstadoCivil()."',";
		$q = $q . "dt_identificacao = '".$Militar->getDataIdt()."',";
		$q = $q . "bigode 			= '".$Militar->getBigode()."',";
		$q = $q . "outros 			= '".$Militar->getOutros()."'";
		if ($Militar->getAssinatura()!=null)
			$q = $q . ",assinatura		= '".$Militar->getAssinatura()."'";
		$q = $q . "  where  id_militar = '" . $Militar->getIdMilitar()."'";
	  //echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('ColMilitar->Registro naão alterado');
	  }
    }
    public function excluirRegistro($Militar)
    { $q = "delete from militar ";
	  $q = $q . " where  id_militar = '" . $Militar->getIdMilitar()."'";
	  //echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('ColMilitar->Registro não excluído');
	  }
    }
    public function lerRegistro($idMilitar)
    { $q = "select p.id_militar, p.funcao_cod, p. nome,data_nasc, p.nome_pai, p.nome_mae,
    				p.cpf, p.pis_pasep, p.data_atualiz, p.sexo, p.codom, p.cod_subun, m.idt_militar, m.qm_cod,
    				m.pgrad_cod, m.cp, m.prec_cp, m.data_atualiz, m.cutis, m.olhos,
    				m.cabelos, m.barba, m.altura, m.sinais_part, m.tipo_sang, m.fator_rh,
    				m.comportamento, m.antiguidade,p.nome_guerra, p.perm_pub_bi,m.naturalidade,
    				m.estado_civil,m.dt_identificacao,m.bigode,m.outros,m.assinatura
			from pessoa p, militar m
			where p.id_militar = m.id_militar";
	  $q = $q . "  and  m.id_militar = '" .$idMilitar."'";
//	  echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
	  $row = mysqli_fetch_array($result);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $dataNasc = new MinhaData($row['data_nasc']);
	  	$dt_identificacao = trim($row['dt_identificacao']);
	  	if ($dt_identificacao != '') {
	        $dt_identificacao = explode("-",$dt_identificacao);
    	    $dt_identificacao = $dt_identificacao[2]."/".$dt_identificacao[1]."/".$dt_identificacao[0];
    	}
	  	$Militar = new Militar(new PGrad(), new QM(), new Funcao(), $dataNasc, new OmVinc(null), new Subunidade(null));
        $Militar->setIdMilitar($row['id_militar']);
		$Militar->setIdtMilitar($row['idt_militar']); // rv 05
		$Militar->getFuncao()->setCod($row['funcao_cod']);
		$Militar->setNome($row['nome']);
		$Militar->setDataNasc($row['data_nasc']);
		$Militar->setNomePai($row['nome_pai']);
		$Militar->setNomeMae($row['nome_mae']);
		$Militar->setNomeGuerra($row['nome_guerra']);
		$Militar->setPisPasep($row['pis_pasep']);
		$Militar->setCPF($row['cpf']);
		$Militar->setDataAtualiz($row['data_atualiz']);
		$Militar->setSexo($row['sexo']);

		$Militar->getQM()->setCod($row['qm_cod']);
		$Militar->getPGrad()->setCodigo($row['pgrad_cod']);
		$Militar->setCP($row['cp']);
		$Militar->setPrecCP($row['prec_cp']);
		$Militar->setCutis($row['cutis']);
		$Militar->setOlhos($row['olhos']);
		$Militar->setCabelos($row['cabelos']);
		$Militar->setBarba($row['barba']);
		$Militar->setAltura($row['altura']);
		$Militar->setSinaisParticulares($row['sinais_part']);
		$Militar->setTipoSang($row['tipo_sang']);
		$Militar->setFatorRH($row['fator_rh']);
		$Militar->setNaturalidade($row['naturalidade']);
		$Militar->setEstadoCivil($row['estado_civil']);
		$Militar->setDataIdt($dt_identificacao);
		$Militar->setBigode($row['bigode']);
		$Militar->setOutros($row['outros']);
		$Militar->setAssinatura($row['assinatura']);
		$Militar->setComportamento($row['comportamento']);
		$Militar->setAntiguidade($row['antiguidade']);
		$Militar->setPermPubBI($row['perm_pub_bi']);
		$Militar->getOmVinc()->setCodom($row['codom']);
		$Militar->getSubun()->setCod($row['cod_subun']);
		return $Militar;
	  }
    }

    public function lerMilitarQueExerceFuncao($codFuncao)
    { $q = "select  p.id_militar, m.idt_militar, p.funcao_cod, p. nome,data_nasc, p.nome_pai, p.nome_mae,
    				p.cpf, p.pis_pasep, p.data_atualiz, p.sexo,m.id_militar, m.qm_cod,
    				m.pgrad_cod, m.cp, m.prec_cp, m.data_atualiz, m.cutis, m.olhos,
    				m.cabelos, m.barba, m.altura, m.sinais_part, m.tipo_sang, m.fator_rh,
    				m.comportamento, m.antiguidade,p.nome_guerra, p.perm_pub_bi, p.codom, p.cod_subun, m.assinatura
			from pessoa p, militar m
				where p.id_militar = m.id_militar and p.funcao_cod = ".  $codFuncao;
//	  echo $q;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $row = mysqli_fetch_array($result);
	  	$dataNasc = new MinhaData($row['data_nasc']);
	  	$Militar = new Militar(new PGrad(), new QM(), new Funcao(), $dataNasc, new OmVinc(null), new Subunidade(null));
        $Militar->setIdMilitar($row['id_militar']);
		$Militar->setIdtMilitar($row['idt_militar']); // rv 05
		$Militar->getFuncao()->setCod($row['funcao_cod']);
		$Militar->setNome($row['nome']);
		$Militar->setDataNasc($row['data_nasc']);
		$Militar->setNomePai($row['nome_pai']);
		$Militar->setNomeMae($row['nome_mae']);
		$Militar->setNomeGuerra($row['nome_guerra']);
		$Militar->setPisPasep($row['pis_pasep']);
		$Militar->setCPF($row['cpf']);
		$Militar->setDataAtualiz($row['data_atualiz']);
		$Militar->setSexo($row['sexo']);

		$Militar->getQM()->setCod($row['qm_cod']);
		$Militar->getPGrad()->setCodigo($row['pgrad_cod']);
		$Militar->setCP($row['cp']);
		$Militar->setPrecCP($row['prec_cp']);
		$Militar->setCutis($row['cutis']);
		$Militar->setOlhos($row['olhos']);
		$Militar->setCabelos($row['cabelos']);
		$Militar->setBarba($row['barba']);
		$Militar->setAltura($row['altura']);
		$Militar->setSinaisParticulares($row['sinais_part']);
		$Militar->setTipoSang($row['tipo_sang']);
		$Militar->setFatorRH($row['fator_rh']);
		$Militar->setNaturalidade($row['naturalidade']);
		$Militar->setEstadoCivil($row['estado_civil']);
		$Militar->setDataIdt($row['dt_identificacao']);
		$Militar->setBigode($row['bigode']);
		$Militar->setOutros($row['outros']);
		$Militar->setAssinatura($row['assinatura']);
		$Militar->setComportamento($row['comportamento']);
		$Militar->setAntiguidade($row['antiguidade']);
		$Militar->setPermPubBI($row['perm_pub_bi']);
		$Militar->getOmVinc()->setCodom($row['codom']);
		$Militar->getSubun()->setCod($row['cod_subun']);
		return $Militar;
	  }
    }

    public function lerColecao($ordem,$filtro)
    { $q = "select p.id_militar, m.idt_militar, m.pgrad_cod, p.funcao_cod, p.nome,data_nasc, p.nome_pai, p.nome_mae,
    				p.cpf, p.pis_pasep, p.data_atualiz, p.sexo, m.id_militar, m.qm_cod,
    				m.cp, m.prec_cp, m.data_atualiz, m.cutis, m.olhos,
    				m.cabelos, m.barba, m.altura, m.sinais_part, m.tipo_sang, m.fator_rh,
    				m.comportamento, m.antiguidade,p.nome_guerra, p.perm_pub_bi, p.codom, p.cod_subun, m.naturalidade,
    				m.estado_civil,m.dt_identificacao,m.bigode,m.outros, m.assinatura, o.sigla, s.sigla as sigla2
			from pessoa p, militar m, om_vinc o, subunidade s, pgrad pg
			where p.id_militar = m.id_militar and m.pgrad_cod=pg.cod and p.codom = s.codom and p.cod_subun=s.cod
                                and s.codom=o.codom ".$filtro;
	  $q = $q . " order by  " . $ordem;
    //echo "<br><b>".$q."</b><br>";
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colMilitar2 = new ColMilitar2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $dataNasc = new MinhaData($row['data_nasc']);
        $dt_identificacao = trim($row['dt_identificacao']);
        if ($dt_identificacao != '') {
			$dt_identificacao = explode("-",$dt_identificacao);
        	$dt_identificacao = $dt_identificacao[2]."/".$dt_identificacao[1]."/".$dt_identificacao[0];
        }

      	$Militar = new Militar(new PGrad(), new QM(), new Funcao(), $dataNasc, new OmVinc(null), new Subunidade(null));
        $Militar->setIdMilitar($row['id_militar']);
		$Militar->setIdtMilitar($row['idt_militar']); // rv 05
		$Militar->getFuncao()->setCod($row['funcao_cod']);
		$Militar->setNome($row['nome']);
		$Militar->setNomeGuerra($row['nome_guerra']);
		//$Militar->setDataNasc($row['data_nasc']);
		$Militar->setNomePai($row['nome_pai']);
		$Militar->setNomeMae($row['nome_mae']);
		$Militar->setPisPasep($row['pis_pasep']);
		$Militar->setCPF($row['cpf']);
		$Militar->setDataAtualiz($row['data_atualiz']);
		$Militar->setSexo($row['sexo']);

		$Militar->getQM()->setCod($row['qm_cod']);
		$Militar->getPGrad()->setCodigo($row['pgrad_cod']);
		$Militar->setCP($row['cp']);
		$Militar->setPrecCP($row['prec_cp']);
		$Militar->setCutis($row['cutis']);
		$Militar->setOlhos($row['olhos']);
		$Militar->setCabelos($row['cabelos']);
		$Militar->setBarba($row['barba']);
		$Militar->setAltura($row['altura']);
		$Militar->setSinaisParticulares($row['sinais_part']);
		$Militar->setTipoSang($row['tipo_sang']);
		$Militar->setFatorRH($row['fator_rh']);
		$Militar->setNaturalidade($row['naturalidade']);
		$Militar->setEstadoCivil($row['estado_civil']);
		$Militar->setDataIdt($dt_identificacao);
		$Militar->setBigode($row['bigode']);
		$Militar->setOutros($row['outros']);
		$Militar->setAssinatura($row['assinatura']);
		$Militar->setComportamento($row['comportamento']);
		$Militar->setAntiguidade($row['antiguidade']);
		$Militar->setPermPubBI($row['perm_pub_bi']);
		$Militar->getOmVinc()->setCodom($row['codom']);
		$Militar->getOmVinc()->setSigla($row['sigla']);
		$Militar->getSubun()->setCod($row['cod_subun']);
		$Militar->getSubun()->setSigla($row['sigla2']);
                $colMilitar2->incluirRegistro($Militar);
      }
      return $colMilitar2;
      //print_r($colMilitar2);
    }

    public function lerColMilAssAlteracoes($filtro)
    { $q = "select  p.id_militar, p.funcao_cod, p. nome,data_nasc, p.nome_pai, p.nome_mae,
    				p.cpf, p.pis_pasep, p.data_atualiz, p.sexo,m.id_militar, m.qm_cod,
    				m.pgrad_cod, m.cp, m.prec_cp, m.data_atualiz, m.cutis, m.olhos,
    				m.cabelos, m.barba, m.altura, m.sinais_part, m.tipo_sang, m.fator_rh,
    				m.comportamento, m.antiguidade,p.nome_guerra, p.perm_pub_bi, p.codom, p.cod_subun, m.assinatura
			from pessoa p, militar m, funcao f
			where p.id_militar = m.id_militar and
				  p.funcao_cod = f.cod	and p.perm_pub_bi <> 'N' and f.assina_alt = 'S' ".$filtro;
      //echo "<br><b>".$q."</b><br>";
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colMilitar2 = new ColMilitar2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $dataNasc = new MinhaData($row['data_nasc']);
      	$Militar = new Militar(new PGrad(), new QM(), new Funcao(), $dataNasc, new OmVinc(null), new Subunidade(null));
        $Militar->setIdMilitar($row['id_militar']);
		$Militar->setIdtMilitar($row['idt_militar']); // rv 05
		$Militar->getFuncao()->setCod($row['funcao_cod']);
		$Militar->setNome($row['nome']);
		$Militar->setNomeGuerra($row['nome_guerra']);
		//$Militar->setDataNasc($row['data_nasc']);
		$Militar->setNomePai($row['nome_pai']);
		$Militar->setNomeMae($row['nome_mae']);
		$Militar->setPisPasep($row['pis_pasep']);
		$Militar->setCPF($row['cpf']);
		$Militar->setDataAtualiz($row['data_atualiz']);
		$Militar->setSexo($row['sexo']);

		$Militar->getQM()->setCod($row['qm_cod']);
		$Militar->getPGrad()->setCodigo($row['pgrad_cod']);
		$Militar->setCP($row['cp']);
		$Militar->setPrecCP($row['prec_cp']);
		$Militar->setCutis($row['cutis']);
		$Militar->setOlhos($row['olhos']);
		$Militar->setCabelos($row['cabelos']);
		$Militar->setBarba($row['barba']);
		$Militar->setAltura($row['altura']);
		$Militar->setSinaisParticulares($row['sinais_part']);
		$Militar->setTipoSang($row['tipo_sang']);
		$Militar->setFatorRH($row['fator_rh']);
		$Militar->setNaturalidade($row['naturalidade']);
		$Militar->setEstadoCivil($row['estado_civil']);
		$Militar->setDataIdt($row['dt_identificacao']);
		$Militar->setBigode($row['bigode']);
		$Militar->setOutros($row['outros']);
		$Militar->setAssinatura($row['assinatura']);
		$Militar->setComportamento($row['comportamento']);
		$Militar->setAntiguidade($row['antiguidade']);
		$Militar->setPermPubBI($row['perm_pub_bi']);
		$Militar->getOmVinc()->setCodom($row['codom']);
		$Militar->getSubun()->setCod($row['cod_subun']);

		$colMilitar2->incluirRegistro($Militar);
      }
	  //print_r($Militar);
      return $colMilitar2;
    }
    public function lerColMilNaoIncMatBI($codpgrad, $nome, $codMateriaBI, $codom, $codSubun, $todasOmVinc, $todasSubun)
    { $q = "select p.id_militar, p.funcao_cod, p. nome,data_nasc, p.nome_pai, p.nome_mae,
    				p.cpf, p.pis_pasep, p.data_atualiz, p.sexo,m.id_militar, m.qm_cod,
    				m.pgrad_cod, m.cp, m.prec_cp, m.data_atualiz, m.cutis, m.olhos,
    				m.cabelos, m.barba, m.altura, m.sinais_part, m.tipo_sang, m.fator_rh,
    				m.comportamento, m.antiguidade,p.nome_guerra, p.perm_pub_bi, p.codom, p.cod_subun, m.assinatura
			from pessoa p, militar m
			where p.id_militar = m.id_militar and p.perm_pub_bi = 'S'";

      //filtro do perfil - se o usuario pode ver a lista de todos os militares da OM Vinc e/ou da subunidade
      if ($todasOmVinc != "X"){ //não é o supervisor
         if ($todasOmVinc == "N"){
            $q = $q . " and p.codom = '" . $codom . "'";
         }
         if ($todasSubun == "N"){
	      	$q = $q . " and p.cod_subun = " . $codSubun;
         }
      }

      if ($codpgrad != 'Todos'){
	      	$q = $q . " and m.pgrad_cod = '".$codpgrad."'";
      }

      $q = $q . " and p.nome like '%".$nome."%'
						 and m.id_militar not in (select id_militar from pessoa_materia_bi where
						 cod_materia_bi = ".$codMateriaBI .")";

	  $q = $q . " order by m.pgrad_cod, m.antiguidade, p.nome";
      //echo "<br><b>".$q."</b><br>";
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colMilitar2 = new ColMilitar2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $dataNasc = new MinhaData($row['data_nasc']);
      	$Militar = new Militar(new PGrad(), new QM(), new Funcao(), $dataNasc, new OmVinc(null), new Subunidade(null));
        $Militar->setIdMilitar($row['id_militar']);
		$Militar->setIdtMilitar($row['idt_militar']); //rv 05
		$Militar->getFuncao()->setCod($row['funcao_cod']);
		$Militar->setNome($row['nome']);
		$Militar->setNomeGuerra($row['nome_guerra']);
		//$Militar->setDataNasc($row['data_nasc']);
		$Militar->setNomePai($row['nome_pai']);
		$Militar->setNomeMae($row['nome_mae']);
		$Militar->setPisPasep($row['pis_pasep']);
		$Militar->setCPF($row['cpf']);
		$Militar->setDataAtualiz($row['data_atualiz']);
		$Militar->setSexo($row['sexo']);

		$Militar->getQM()->setCod($row['qm_cod']);
		$Militar->getPGrad()->setCodigo($row['pgrad_cod']);
		$Militar->setCP($row['cp']);
		$Militar->setPrecCP($row['prec_cp']);
		$Militar->setCutis($row['cutis']);
		$Militar->setOlhos($row['olhos']);
		$Militar->setCabelos($row['cabelos']);
		$Militar->setBarba($row['barba']);
		$Militar->setAltura($row['altura']);
		$Militar->setSinaisParticulares($row['sinais_part']);
		$Militar->setTipoSang($row['tipo_sang']);
		$Militar->setFatorRH($row['fator_rh']);
		$Militar->setNaturalidade($row['naturalidade']);
		$Militar->setEstadoCivil($row['estado_civil']);
		$Militar->setDataIdt($row['dt_identificacao']);
		$Militar->setBigode($row['bigode']);
		$Militar->setOutros($row['outros']);
		$Militar->setAssinatura($row['assinatura']);
		$Militar->setComportamento($row['comportamento']);
		$Militar->setAntiguidade($row['antiguidade']);
		$Militar->setPermPubBI($row['perm_pub_bi']);
		$Militar->getOmVinc()->setCodom($row['codom']);
		$Militar->getSubun()->setCod($row['cod_subun']);

		$colMilitar2->incluirRegistro($Militar);
      }
	  //print_r($Militar);
      return $colMilitar2;
	}
	//rev07
    public function lerColMilAssNota($filtro)
    { $q = "select  p.id_militar, p.funcao_cod, f.descricao, p. nome,data_nasc, p.nome_pai, p.nome_mae,
    				p.cpf, p.pis_pasep, p.data_atualiz, p.sexo,m.id_militar, m.idt_militar, m.qm_cod,
    				m.pgrad_cod, m.cp, m.prec_cp, m.data_atualiz, m.cutis, m.olhos,
    				m.cabelos, m.barba, m.altura, m.sinais_part, m.tipo_sang, m.fator_rh,
    				m.comportamento, m.antiguidade,p.nome_guerra, p.perm_pub_bi, p.codom, p.cod_subun, m.assinatura
			from pessoa p, militar m, funcao f
			where p.id_militar = m.id_militar and
				  p.funcao_cod = f.cod	and p.perm_pub_bi <> 'N' and f.assina_nota = 'S' ".$filtro;
      //echo "<br><b>".$q."</b><br>";
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colMilitar2 = new ColMilitar2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $dataNasc = new MinhaData($row['data_nasc']);
      	$Militar = new Militar(new PGrad(), new QM(), new Funcao(), $dataNasc, new OmVinc(null), new Subunidade(null));
        $Militar->setIdMilitar($row['id_militar']);
		$Militar->setIdtMilitar($row['idt_militar']); // rv 05
		$Militar->getFuncao()->setCod($row['funcao_cod']);
		$Militar->getFuncao()->setDescricao($row['descricao']);
		$Militar->setNome($row['nome']);
		$Militar->setNomeGuerra($row['nome_guerra']);
		//$Militar->setDataNasc($row['data_nasc']);
		$Militar->setNomePai($row['nome_pai']);
		$Militar->setNomeMae($row['nome_mae']);
		$Militar->setPisPasep($row['pis_pasep']);
		$Militar->setCPF($row['cpf']);
		$Militar->setDataAtualiz($row['data_atualiz']);
		$Militar->setSexo($row['sexo']);

		$Militar->getQM()->setCod($row['qm_cod']);
		$Militar->getPGrad()->setCodigo($row['pgrad_cod']);
		$Militar->setCP($row['cp']);
		$Militar->setPrecCP($row['prec_cp']);
		$Militar->setCutis($row['cutis']);
		$Militar->setOlhos($row['olhos']);
		$Militar->setCabelos($row['cabelos']);
		$Militar->setBarba($row['barba']);
		$Militar->setAltura($row['altura']);
		$Militar->setSinaisParticulares($row['sinais_part']);
		$Militar->setTipoSang($row['tipo_sang']);
		$Militar->setFatorRH($row['fator_rh']);
		$Militar->setNaturalidade($row['naturalidade']);
		$Militar->setEstadoCivil($row['estado_civil']);
		$Militar->setDataIdt($row['dt_identificacao']);
		$Militar->setBigode($row['bigode']);
		$Militar->setOutros($row['outros']);
		$Militar->setAssinatura($row['assinatura']);
		$Militar->setComportamento($row['comportamento']);
		$Militar->setAntiguidade($row['antiguidade']);
		$Militar->setPermPubBI($row['perm_pub_bi']);
		$Militar->getOmVinc()->setCodom($row['codom']);
		$Militar->getSubun()->setCod($row['cod_subun']);

		$colMilitar2->incluirRegistro($Militar);
      }
	  //print_r($Militar);
      return $colMilitar2;
    }
  }
?>
