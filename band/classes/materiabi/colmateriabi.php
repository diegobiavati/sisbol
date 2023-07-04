<?php
  class ColMateriaBi implements ICOLMateriaBi
  { private $db;
    public function ColMateriaBi($db)
    { $this->db = $db;
    }
    public function incluirRegistro($materiaBi, $boletim)
    { $q = "insert into materia_bi (cod_materia_bi,data_materia_bi,id_militar_ass,cod_tipo_doc, cod_assunto_esp, cod_assunto_ger, cod_boletim, ";
      $q = $q . "texto_abert, texto_fech, nr_documento, vai_altr, aprovada,";
	  $q = $q . "  descr_ass_esp, descr_ass_ger, data_doc, usuario, codom, cod_subun, tipo_bol_cod, mostra_ref, texto_fech_vai_altr) values (" ;
	  $q = $q . $materiaBi->getCodigo() . ",'";
	  $q = $q . $materiaBi->getData()->GetcDataYYYYHMMHDD()."','";
	  $q = $q . $materiaBi->getMilitarAss()->getIdMilitar()."',";
	  $q = $q . $materiaBi->getTipoDoc()->getCodigo() . ",";
	  $q = $q . $materiaBi->getAssuntoEspec()->getCodigo() . ",";
	  $q = $q . $materiaBi->getAssuntoGeral()->getCodigo() . ",";
	  if (($boletim == null) or ($boletim->getCodigo() == 0))
	  { $q = $q . "null,";
	  }
	  else
	  { $q = $q . $boletim->getCodigo() . ",";
	  }

	  $q = $q . " '".	addSlashes($materiaBi->getTextoAbert()) . "','" . addSlashes($materiaBi->getTextoFech()) . "','" ;
	  $q = $q . $materiaBi->getNrDocumento() . "','";
	  $q = $q . $materiaBi->getVaiAltr() . "','" . $materiaBi->getAprovada() . "','" . $materiaBi->getDescrAssEsp();
	  $q = $q . "', '" .$materiaBi->getDescrAssGer() . "', '" . $materiaBi->getDataDoc()->getcDataYYYYHMMHDD() . "','";
	  $q = $q . $materiaBi->getUsuario() . "','";
	  $q = $q . $materiaBi->getCodom() . "',";
	  $q = $q . $materiaBi->getCodSubun() . ",";
	  $q = $q . $materiaBi->getTipoBol()->getCodigo() . ",'";
	  $q = $q . $materiaBi->getMostraRef() . "','";
	  $q = $q . $materiaBi->getTextoFechVaiAltr() . "')";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLMATERIABI->Registro não Incluido');
	  }
    }

	//alterado a função setaOrdem para o funcionamento do novo ordenaMateria - set/12 - Ten Watanabe e Ten S.Lopes
    public function setaOrdem($codMateria, $ordemMateria)
    {
      $q = "update materia_bi set ord_mat = " . $ordemMateria . " where  cod_materia_bi = " . $codMateria;
      //echo $q."\n".$codMateria;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não alterado CodMateria=".$codMateria." Ordem: ".$ordemMateria")
                                    </script>');
          //throw new Exception('COLMATERIABI->Registro não alterado CodMateria='.$codMateria.' Ordem: '.$ordemMateria );
	  }
    }

    public function alterarRegistro($materiaBi, $boletim)
    {
    	$q = "update materia_bi set
	  		data_materia_bi = '" . $materiaBi->getData()->GetcDataYYYYHMMHDD() . "',
	  		id_militar_ass = '" . $materiaBi->getMilitarAss()->getIdMilitar() . "',
	  		cod_tipo_doc = " . $materiaBi->getTipoDoc()->getCodigo() . ",
	  		cod_assunto_esp =  " .$materiaBi->getAssuntoEspec()->getCodigo() . ",
	  		cod_assunto_ger =  " .$materiaBi->getAssuntoGeral()->getCodigo() . "," ;
      if (($boletim == null) or ($boletim->getCodigo() == 0))
	  { $q = $q . "cod_boletim = null,";
	  }
	  else
	  { $q = $q . "cod_boletim = " . $boletim->getCodigo() . ",";
	  }

	  $q = $q .	" texto_abert =   '" . addSlashes($materiaBi->getTextoAbert());
	  $q = $q .	"', texto_fech =   '" . addSlashes($materiaBi->getTextoFech());
	  $q = $q .	"', nr_documento =   '" . $materiaBi->getNrDocumento();
	  $q = $q .	"', vai_altr =   '" . $materiaBi->getVaiAltr();
	  $q = $q .	"', aprovada =   '" . $materiaBi->getAprovada();
	  $q = $q .	"', descr_ass_esp =   '" . $materiaBi->getDescrAssEsp();
	  $q = $q .	"', descr_ass_ger =   '" . $materiaBi->getDescrAssGer();
	  $q = $q .	"', data_doc =   '" . $materiaBi->getDataDoc()->getcDataYYYYHMMHDD();
	  $q = $q .	"', mostra_ref =   '" . $materiaBi->getMostraRef();
	  $q = $q .	"', texto_fech_vai_altr =   '" . $materiaBi->getTextoFechVaiAltr();
	  $q = $q .	"', tipo_bol_cod =   '" . $materiaBi->getTipoBol()->getCodigo();
	  $q = $q .	"', pagina =   '" . $materiaBi->getPagina();
	  $q = $q . "', data_atualiz = now()" ;
	  $q = $q . " , usuario = '" . $materiaBi->getUsuario() . "'";
	  if ($materiaBi->getUsuario() != 'supervisor'){
              $q = $q . ", codom = '" . $materiaBi->getCodom();
              $q = $q . "', cod_subun = " . $materiaBi->getCodSubun();
          }
	  $q = $q . " where  cod_materia_bi = " . $materiaBi->getCodigo();
      //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLMATERIABI->Registro não alterado');
	  }
    }
	// Inserir comentário nas NBI - Sgt Bedin
	public function alterarComentario($codMateriaBI, $textoComentario)
    {
    	$q = "update materia_bi set
	  		texto_comentario = '" . $textoComentario. "'";
	  	$q = $q . " where  cod_materia_bi = " . $codMateriaBI ;
      //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLMATERIABI->Registro não alterado');
	  }
    }
	//
    public function excluirRegistro($materiaBi)
    { $q = "delete from materia_bi ";
	  $q = $q . " where  cod_materia_bi = " .$materiaBi->getCodigo();
	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      {           
	// PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLMATERIABI->Registro não excluído');
	  }
    }
    public function getProximoCodigo()
    { $q = "select ifnull(max(cod_materia_bi),0) as ultimo from materia_bi";
      $result = mysqli_query($this->db, $q);
	  $row = mysqli_fetch_array($result);
      $proximo = $row['ultimo'] + 1;
//      echo 'proximo ' . $proximo;
      return $proximo;
    }
    public function lerRegistro($codMateriaBi)
    { $q = "select cod_materia_bi, data_materia_bi, id_militar_ass, cod_assunto_esp, cod_assunto_ger, cod_tipo_doc, cod_boletim, texto_abert, texto_fech,";
	  $q = $q . " nr_documento, vai_altr, aprovada, descr_ass_esp, descr_ass_ger, data_doc, tipo_bol_cod, pagina, usuario, codom, cod_subun, mostra_ref, texto_fech_vai_altr, texto_comentario ";
	  $q = $q . " from materia_bi";
	  $q = $q . " where cod_materia_bi = " . $codMateriaBi;
//      echo '<br>'.$q.'<br>';
	  $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { 
	  	$militarAss = new Militar(null, null, null, null, null,null);
	    $assuntoEspec = new AssuntoEspec();
        $assuntoGeral = new AssuntoGeral(null, null, null, null);
        $boletim = new Boletim(null, null, null, null);
        $tipoDoc = new TipoDoc();
        $tipoBol = new TipoBol();
        $colPessoaMateriaBi2 = new ColPessoaMateriaBi2();

        $row = mysqli_fetch_array($result);
        $materiaBi = new MateriaBi(new MinhaData($row['data_materia_bi']), $assuntoEspec, $assuntoGeral, $tipoDoc, new MinhaData($row['data_doc']), $colPessoaMateriaBi2, $tipoBol, $militarAss);
        $materiaBi->setCodigo($row['cod_materia_bi']);
		$materiaBi->getMilitarAss()->setIdMilitar($row['id_militar_ass']);
        $materiaBi->getAssuntoGeral()->setCodigo($row['cod_assunto_ger']);
        $materiaBi->getAssuntoEspec()->setCodigo($row['cod_assunto_esp']);
        $materiaBi->getTipoDoc()->setCodigo($row['cod_tipo_doc']);
        $materiaBi->setTextoAbert(stripslashes($row['texto_abert']));
        $materiaBi->setTextoFech(stripslashes($row['texto_fech']));
        $materiaBi->setTextoFechVaiAltr($row['texto_fech_vai_altr']);
        $materiaBi->setNrDocumento($row['nr_documento']);
        $materiaBi->setMostraRef($row['mostra_ref']);
        $materiaBi->setVaiAltr($row['vai_altr']);
        $materiaBi->setAprovada($row['aprovada']);
        $materiaBi->setDescrAssEsp($row['descr_ass_esp']);
        $materiaBi->setDescrAssGer($row['descr_ass_ger']);
        $materiaBi->setPagina($row['pagina']);
        $materiaBi->setUsuario($row['usuario']);
        $materiaBi->setCodom($row['codom']);
        $materiaBi->setCodSubun($row['cod_subun']);
        $materiaBi->getTipoBol()->setCodigo($row['tipo_bol_cod']);
		$materiaBi->setTextoComentario($row['texto_comentario']);
		$materiaBi->setCodMateriaBI($row['cod_materia_bi']);
        return $materiaBi;
	  }
    }
    public function lerColecao($codBi, $numeroParte, $numeroSecao)
    { $q = "select cod_materia_bi, data_materia_bi, id_militar_ass, cod_assunto_esp, cod_assunto_ger, assunto_geral.ord_assunto_geral, cod_tipo_doc, cod_boletim, texto_abert,";
	  $q = $q . " texto_fech, pagina, ord_mat,";
	  $q = $q . " nr_documento, vai_altr, aprovada, descr_ass_esp, descr_ass_ger, data_doc, tipo_bol_cod, usuario, codom, cod_subun, mostra_ref, texto_fech_vai_altr ";
	  $q = $q . " from materia_bi, ";
	  $q = $q . " assunto_geral";
	  $q = $q . " where cod_boletim = " . $codBi . " and ";
	  $q = $q . " materia_bi.cod_assunto_ger = assunto_geral.cod_assunto ";
      $q = $q . " and numero_secao = " . $numeroSecao . " and numero_parte = ";
	  $q = $q . $numeroParte;
	  $q = $q . ' order by assunto_geral.ord_assunto_geral, materia_bi.cod_assunto_ger, materia_bi.ord_mat';// Watanabe 03Nov2008 - adicionado cod_assunto_ger

	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colMateriaBi2 = new ColMateriaBi2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);

		$militarAss = new Militar(null, null, null, null, null, null);
        $assuntoEspec = new AssuntoEspec();
        $assuntoGeral = new AssuntoGeral(null, null, null, null);
        $boletim = new Boletim(null, null, null, null);
        $tipoDoc = new TipoDoc();
        $colPessoaMateriaBi2 = new ColPessoaMateriaBi2();
        $tipoBol = new TipoBol();

        $materiaBi = new MateriaBi(new MinhaData($row['data_materia_bi']), $assuntoEspec, $assuntoGeral, $tipoDoc, new MinhaData($row['data_doc']),
		  $colPessoaMateriaBi2, $tipoBol, $militarAss);

        $materiaBi->setCodigo($row['cod_materia_bi']);
		$materiaBi->getMilitarAss()->setIdMilitar($row['id_militar_ass']);
        $materiaBi->getAssuntoGeral()->setCodigo($row['cod_assunto_ger']);
        $materiaBi->getAssuntoEspec()->setCodigo($row['cod_assunto_esp']);
        $materiaBi->getTipoDoc()->setCodigo($row['cod_tipo_doc']);
        $materiaBi->setTextoAbert(stripslashes($row['texto_abert']));
        $materiaBi->setTextoFech(stripslashes($row['texto_fech']));
        $materiaBi->setTextoFechVaiAltr($row['texto_fech_vai_altr']);
        $materiaBi->setNrDocumento($row['nr_documento']);
        $materiaBi->setMostraRef($row['mostra_ref']);
        $materiaBi->setVaiAltr($row['vai_altr']);
        $materiaBi->setAprovada($row['aprovada']);
        $materiaBi->setDescrAssEsp($row['descr_ass_esp']);
        $materiaBi->setDescrAssGer($row['descr_ass_ger']);
        $materiaBi->setPagina($row['pagina']);
        $materiaBi->setUsuario($row['usuario']);
        $materiaBi->setCodom($row['codom']);
        $materiaBi->setCodSubun($row['cod_subun']);
        $materiaBi->setOrd_mat($row['ord_mat']);
//        $materiaBi->setTextoAbert($row['texto_abert']);
        $materiaBi->getTipoBol()->setCodigo($row['tipo_bol_cod']);
        $colMateriaBi2->incluirRegistro($materiaBi);
      }
      return $colMateriaBi2;
    }
    public function lerColecao2($codTipoBol, $aprovada, $order, $incluidaEmBI, $codom, $codSubun, $todasOmVinc, $todasSubun)
    { $q = "select cod_materia_bi, data_materia_bi, id_militar_ass, cod_assunto_esp, cod_assunto_ger, cod_tipo_doc, cod_boletim, texto_abert,";
	  $q = $q . " texto_fech, pagina, ";
	  $q = $q . " nr_documento, vai_altr, aprovada, descr_ass_esp, descr_ass_ger, data_doc, tipo_bol_cod, usuario, codom, cod_subun, mostra_ref, texto_fech_vai_altr ";
	  $q = $q . " from materia_bi ";
	  $q = $q . " where tipo_bol_cod = " . $codTipoBol;
	  //aqui é o filtro do perfil - se o usuario pode ver todas as materias da OM Vinc e/ou da subunidade
          if ($todasOmVinc != "X"){ //não é o supervisor
            if ($todasOmVinc == "N"){
               $q = $q . " and codom = '" . $codom . "'";
            }
            if ($todasSubun == "N"){
        	$q = $q . " and cod_subun = " . $codSubun;
            }
          }
//	  if (($aprovada == "S") or ($aprovada == "N")){
//	  	$q = $q . " and aprovada = '" .$aprovada . "'";
//	  }
	  if ($incluidaEmBI == "N"){
	  	$q = $q . " and cod_boletim is null ";
	  } else {
	  	$q = $q . " and cod_boletim is not null ";
	  }
          //rv7
          $status = explode(",",$aprovada);
          if ($status != 0){
              $q = $q . " and (aprovada = '" .$status[0]. "'";
              if (count($status) > 1)
                  for ( $i=1 ; $i < count($status) ; $i++ ){
        	  	$q = $q . " or aprovada = '" .$status[$i]. "'";
                  }
              $q = $q . ")";
          }

	  $q = $q . " order by " . $order;
      //echo $q;
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colMateriaBi2 = new ColMateriaBi2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);

		$militarAss = new Militar(null, null, null, null, null,null);
        $assuntoEspec = new AssuntoEspec();
        $assuntoGeral = new AssuntoGeral(null, null, null, null);
        $boletim = new Boletim(null, null, null, null);
        $tipoDoc = new TipoDoc();
        $colPessoaMateriaBi2 = new ColPessoaMateriaBi2();
        $tipoBol = new TipoBol();

        $materiaBi = new MateriaBi(new MinhaData($row['data_materia_bi']), $assuntoEspec, $assuntoGeral, $tipoDoc, new MinhaData($row['data_doc']),
		  $colPessoaMateriaBi2, $tipoBol, $militarAss);

        $materiaBi->setCodigo($row['cod_materia_bi']);
		$materiaBi->getMilitarAss()->setIdMilitar($row['id_militar_ass']);
        $materiaBi->getAssuntoGeral()->setCodigo($row['cod_assunto_ger']);
        $materiaBi->getAssuntoEspec()->setCodigo($row['cod_assunto_esp']);
        $materiaBi->getTipoDoc()->setCodigo($row['cod_tipo_doc']);
        $materiaBi->setTextoAbert(stripslashes($row['texto_abert']));
        $materiaBi->setTextoFech(stripslashes($row['texto_fech']));
        $materiaBi->setTextoFechVaiAltr($row['texto_fech_vai_altr']);
        $materiaBi->setNrDocumento($row['nr_documento']);
        $materiaBi->setMostraRef($row['mostra_ref']);
        $materiaBi->setVaiAltr($row['vai_altr']);
        $materiaBi->setAprovada($row['aprovada']);
        $materiaBi->setDescrAssEsp($row['descr_ass_esp']);
        $materiaBi->setDescrAssGer($row['descr_ass_ger']);
        $materiaBi->setPagina($row['pagina']);
        $materiaBi->setUsuario($row['usuario']);
        $materiaBi->setCodom($row['codom']);
        $materiaBi->setCodSubun($row['cod_subun']);
//        $materiaBi->setTextoAbert($row['texto_abert']);
        $materiaBi->getTipoBol()->setCodigo($row['tipo_bol_cod']);
        $colMateriaBi2->incluirRegistro($materiaBi);
      }
      return $colMateriaBi2;
    }

    public function lerColecao3($codBoletim, $order)
    { $q = "select cod_materia_bi, data_materia_bi, id_militar_ass, cod_assunto_esp, cod_assunto_ger, cod_tipo_doc, cod_boletim, texto_abert,";
	  $q = $q . " texto_fech, pagina, ";
	  $q = $q . " nr_documento, vai_altr, aprovada, descr_ass_esp, descr_ass_ger, data_doc, tipo_bol_cod, usuario, codom, cod_subun, mostra_ref, texto_fech_vai_altr ";
	  $q = $q . " from materia_bi ";
	  $q = $q . " where cod_boletim = " . $codBoletim;

	  $q = $q . " order by " . $order;
      //echo $q;
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colMateriaBi2 = new ColMateriaBi2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);

		$militarAss = new Militar(null, null, null, null, null, null);
        $assuntoEspec = new AssuntoEspec();
        $assuntoGeral = new AssuntoGeral(null, null, null, null);
        $boletim = new Boletim(null, null, null, null);
        $tipoDoc = new TipoDoc();
        $colPessoaMateriaBi2 = new ColPessoaMateriaBi2();
        $tipoBol = new TipoBol();

        $materiaBi = new MateriaBi(new MinhaData($row['data_materia_bi']), $assuntoEspec, $assuntoGeral, $tipoDoc, new MinhaData($row['data_doc']),
		  $colPessoaMateriaBi2, $tipoBol, $militarAss);

        $materiaBi->setCodigo($row['cod_materia_bi']);
		$materiaBi->getMilitarAss()->setIdMilitar($row['id_militar_ass']);
        $materiaBi->getAssuntoGeral()->setCodigo($row['cod_assunto_ger']);
        $materiaBi->getAssuntoEspec()->setCodigo($row['cod_assunto_esp']);
        $materiaBi->getTipoDoc()->setCodigo($row['cod_tipo_doc']);
        $materiaBi->setTextoAbert(stripslashes($row['texto_abert']));
        $materiaBi->setTextoFech(stripslashes($row['texto_fech']));
        $materiaBi->setTextoFechVaiAltr($row['texto_fech_vai_altr']);
        $materiaBi->setNrDocumento($row['nr_documento']);
        $materiaBi->setMostraRef($row['mostra_ref']);
        $materiaBi->setVaiAltr($row['vai_altr']);
        $materiaBi->setAprovada($row['aprovada']);
        $materiaBi->setDescrAssEsp($row['descr_ass_esp']);
        $materiaBi->setDescrAssGer($row['descr_ass_ger']);
//        $materiaBi->setTextoAbert(stripslashes($row['texto_abert']));
        $materiaBi->getTipoBol()->setCodigo($row['tipo_bol_cod']);
        $materiaBi->setPagina($row['pagina']);
        $materiaBi->setUsuario($row['usuario']);
        $materiaBi->setCodom($row['codom']);
        $materiaBi->setCodSubun($row['cod_subun']);
        $colMateriaBi2->incluirRegistro($materiaBi);
      }
      return $colMateriaBi2;
    }
    public function lerBoletimQuePublicou($codMateriaBi)
    { $q = "select cod_materia_bi, data_materia_bi, cod_assunto_esp, cod_assunto_ger, cod_tipo_doc, cod_boletim, texto_abert, texto_fech";
      $q = $q . " from materia_bi ";
	  $q = $q . "where cod_materia_bi = " . $codMateriaBi;
	  //echo $q;
	  $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $row = mysqli_fetch_array($result);
	  	//echo 'codigo do boletim: '.$row['cod_boletim'];
	  	if ($row['cod_boletim'] != null)
	    { $boletim = new Boletim(null, null, null, null);
          $boletim->setCodigo($row['cod_boletim']);
          return $boletim;}
        else
        { return null;}
	  }
	}

	//busca a qte de assuntos gerais filtrados por seção - rev 06
    public function lerQteAssGerPorSec($codBi, $numeroParte, $numeroSecao)
    { //$q = "select cod_materia_bi, cod_assunto_esp, cod_assunto_ger, assunto_geral.ord_assunto_geral, cod_tipo_doc, cod_boletim, texto_abert,";
	  $q = "select distinct cod_materia_bi, cod_assunto_esp, cod_assunto_ger, assunto_geral.ord_assunto_geral, cod_tipo_doc, cod_boletim, texto_abert,";	  $q = $q . " texto_fech, pagina, ord_mat,";
	  $q = $q . " nr_documento, vai_altr, aprovada, descr_ass_esp, descr_ass_ger, data_doc, tipo_bol_cod, usuario ";
	  $q = $q . " from materia_bi, ";
	  $q = $q . " assunto_geral";
	  $q = $q . " where cod_boletim = " . $codBi . " and ";
	  $q = $q . " materia_bi.cod_assunto_ger = assunto_geral.cod_assunto ";
      $q = $q . " and numero_secao = " . $numeroSecao . " and numero_parte = ";
	  $q = $q . $numeroParte;
	  $q = $q . " group by materia_bi.cod_assunto_ger";
	  $q = $q . ' order by assunto_geral.ord_assunto_geral, materia_bi.ord_mat';

//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
	  $qte = 0;
      for ($i = 0 ; $i < $num_rows; $i++)
      { 
	  	$qte++;
      }
//      print_r($colMateriaBiPorAssGer);
      return $qte;
    }	

	//busca a qte de assuntos especificos por assunto geral - rev 06
    public function lerQteAssEspPorAssGer($codBi, $numeroParte, $numeroSecao, $codAssGer)
    { //$q = "select cod_materia_bi, cod_assunto_esp, cod_assunto_ger, assunto_geral.ord_assunto_geral, cod_tipo_doc, cod_boletim, texto_abert,";
	  $q = "select distinct cod_materia_bi, cod_assunto_esp, cod_assunto_ger, assunto_geral.ord_assunto_geral, cod_tipo_doc, cod_boletim, texto_abert,";	  $q = $q . " texto_fech, pagina, ord_mat,";
	  $q = $q . " nr_documento, vai_altr, aprovada, descr_ass_esp, descr_ass_ger, data_doc, tipo_bol_cod, usuario ";
	  $q = $q . " from materia_bi, ";
	  $q = $q . " assunto_geral";
	  $q = $q . " where cod_boletim = " . $codBi . " and ";
	  $q = $q . " materia_bi.cod_assunto_ger = assunto_geral.cod_assunto ";
	  $q = $q . " and materia_bi.cod_assunto_ger = " . $codAssGer;
      $q = $q . " and numero_secao = " . $numeroSecao . " and numero_parte = ";
	  $q = $q . $numeroParte;
	  $q = $q . " group by materia_bi.cod_assunto_esp";
	  $q = $q . ' order by assunto_geral.ord_assunto_geral, materia_bi.ord_mat';

	 // echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
	  $qte = 0;
      for ($i = 0 ; $i < $num_rows; $i++)
      { 
	  	$qte++;
      }
//      print_r($colMateriaBiPorAssGer);
      return $qte;
    }	

	//busca a qte de materias por assuntos especificos - rev 06
    public function lerQteMatPorAssEsp($codBi, $codAssGer, $codAssEsp)
    { $q = "select cod_materia_bi, cod_assunto_esp, cod_assunto_ger, assunto_geral.ord_assunto_geral, cod_tipo_doc, cod_boletim, texto_abert,";
	  //$q = "select distinct cod_materia_bi, cod_assunto_esp, cod_assunto_ger, assunto_geral.ord_assunto_geral, cod_tipo_doc, cod_boletim, texto_abert,";	  $q = $q . " texto_fech, pagina, ord_mat,";
	  $q = $q . " nr_documento, vai_altr, aprovada, descr_ass_esp, descr_ass_ger, data_doc, tipo_bol_cod, usuario ";
	  $q = $q . " from materia_bi, ";
	  $q = $q . " assunto_geral";
	  $q = $q . " where cod_boletim = " . $codBi . " and ";
	  $q = $q . " materia_bi.cod_assunto_ger = assunto_geral.cod_assunto ";
	  $q = $q . " and materia_bi.cod_assunto_ger = " . $codAssGer;
      $q = $q . " and cod_assunto_esp = " . $codAssEsp;
	  $q = $q . ' order by assunto_geral.ord_assunto_geral, materia_bi.ord_mat';

//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
	  $qte = 0;
      for ($i = 0 ; $i < $num_rows; $i++)
      { 
	  	$qte++;
      }
//      print_r($colMateriaBiPorAssGer);
      return $qte;
    }	

	//colecao de materias filtradas pelo assunto geral - rev 06
    public function lerColecaoPorAssGer($codBi, $numeroParte, $numeroSecao, $codAssGer)
    { $q = "select cod_materia_bi, data_materia_bi, id_militar_ass, cod_assunto_esp, cod_assunto_ger, assunto_geral.ord_assunto_geral, cod_tipo_doc, cod_boletim, texto_abert,";
	  $q = $q . " texto_fech, pagina, ord_mat,";
	  $q = $q . " nr_documento, vai_altr, aprovada, descr_ass_esp, descr_ass_ger, data_doc, tipo_bol_cod, usuario, codom, cod_subun, mostra_ref, texto_fech_vai_altr ";
	  $q = $q . " from materia_bi, ";
	  $q = $q . " assunto_geral";
	  $q = $q . " where cod_boletim = " . $codBi . " and ";
	  $q = $q . " materia_bi.cod_assunto_ger = assunto_geral.cod_assunto ";
	  $q = $q . " and materia_bi.cod_assunto_ger = " . $codAssGer;
      $q = $q . " and numero_secao = " . $numeroSecao . " and numero_parte = ";
	  $q = $q . $numeroParte;
	  $q = $q . ' order by assunto_geral.ord_assunto_geral, materia_bi.ord_mat';

	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colMateriaBiPorAssGer = new ColMateriaBi2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);

		$militarAss = new Militar(null, null, null, null, null, null);
        $assuntoEspec = new AssuntoEspec();
        $assuntoGeral = new AssuntoGeral(null, null, null, null);
        $boletim = new Boletim(null, null, null, null);
        $tipoDoc = new TipoDoc();
        $colPessoaMateriaBi2 = new ColPessoaMateriaBi2();
        $tipoBol = new TipoBol();

        $materiaBi = new MateriaBi(new MinhaData($row['data_materia_bi']), $assuntoEspec, $assuntoGeral, $tipoDoc, new MinhaData($row['data_doc']),
		  $colPessoaMateriaBi2, $tipoBol,$militarAss);

        $materiaBi->setCodigo($row['cod_materia_bi']);
		$materiaBi->getMilitarAss()->setIdMilitar($row['id_militar_ass']);
        $materiaBi->getAssuntoGeral()->setCodigo($row['cod_assunto_ger']);
        $materiaBi->getAssuntoEspec()->setCodigo($row['cod_assunto_esp']);
        $materiaBi->getTipoDoc()->setCodigo($row['cod_tipo_doc']);
        $materiaBi->setTextoAbert(stripslashes($row['texto_abert']));
        $materiaBi->setTextoFech(stripslashes($row['texto_fech']));
        $materiaBi->setTextoFechVaiAltr($row['texto_fech_vai_altr']);
        $materiaBi->setNrDocumento($row['nr_documento']);
        $materiaBi->setMostraRef($row['mostra_ref']);
        $materiaBi->setVaiAltr($row['vai_altr']);
        $materiaBi->setAprovada($row['aprovada']);
        $materiaBi->setDescrAssEsp($row['descr_ass_esp']);
        $materiaBi->setDescrAssGer($row['descr_ass_ger']);
        $materiaBi->setPagina($row['pagina']);
        $materiaBi->setUsuario($row['usuario']);
        $materiaBi->setCodom($row['codom']);
        $materiaBi->setCodSubun($row['cod_subun']);
        $materiaBi->setOrd_mat($row['ord_mat']);
//        $materiaBi->setTextoAbert($row['texto_abert']);
        $materiaBi->getTipoBol()->setCodigo($row['tipo_bol_cod']);
        $colMateriaBiPorAssGer->incluirRegistro($materiaBi);
      }
//      print_r($colMateriaBiPorAssGer);
      return $colMateriaBiPorAssGer;
    }

  }
?>
