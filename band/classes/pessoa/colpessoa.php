<?php
  class ColPessoa implements IColPessoa
  { private $db;
    public function ColPessoa($db)
    { $this->db = $db;
    }
    public function incluirRegistro($Pessoa)
    { $q = "insert into pessoa (id_militar,funcao_cod,nome,data_nasc,nome_pai,
			nome_mae,cpf,pis_pasep,data_atualiz,sexo,perm_pub_bi,nome_guerra, codom, cod_subun)
			values ('".$Pessoa->getIdMilitar() . "', ". $Pessoa->getFuncao()->getCod() .",
					'". $Pessoa->getNome() ."','". $Pessoa->getDataNasc() ."',
					'".$Pessoa->getNomePai(). "','". $Pessoa->getNomeMae() ."',
					'".$Pessoa->getCPF()."','". $Pessoa->getPisPasep() ."',
					now(),'". $Pessoa->getSexo() ."','".$Pessoa->getPermPubBI()."','".
					$Pessoa->getNomeGuerra()."','" . $Pessoa->getOmVinc()->getCodOM() . 
                                        "'," . $Pessoa->getSubun()->getCod() . ")";

	  //echo $q;
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      {
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('ColPessoa->Registro não Incluido');
	  }
    }
    public function alterarRegistro($Pessoa)
    { $q = "update pessoa set ";
      $q = $q . "funcao_cod = ".$Pessoa->getFuncao()->getCod() .",";
      $q = $q . "nome = '".$Pessoa->getNome() ."',";
      $q = $q . "nome_guerra = '".$Pessoa->getNomeGuerra() ."',";
	  $q = $q . "data_nasc = '". $Pessoa->getDataNasc() ."',";
      $q = $q . "nome_pai = '".$Pessoa->getNomePai() . "',";
	  $q = $q . "nome_mae = '".$Pessoa->getNomeMae() ."',";
 	  $q = $q . "cpf = '".$Pessoa->getCPF()."',";
	  $q = $q . "pis_pasep = '".$Pessoa->getPisPasep() ."',";
	  $q = $q . "sexo = '".$Pessoa->getSexo() . "', ";
	  $q = $q . "perm_pub_bi = '".$Pessoa->getPermPubBI() . "', ";
	  $q = $q . "codom = '".$Pessoa->getOmVinc()->getCodOM() . "', ";
	  $q = $q . "cod_subun = ".$Pessoa->getSubun()->getCod() . ", ";
	  $q = $q . "data_atualiz = now() ";
	  $q = $q . " where  id_militar = '".$Pessoa->getIdMilitar()."'";
      //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('ColPessoa->Registro não alterado');
	  }
    }
    public function ativaPessoa($idMilitar)
    { $q = "update pessoa set ";
	  $q = $q . "perm_pub_bi = 'S', ";
	  $q = $q . "data_atualiz = now() ";
	  $q = $q . " where  id_militar = '".$idMilitar."'";
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Não foi possível mudar o campo de ativação do militar.")
                                    </script>');
          //throw new Exception('ColPessoa->Não foi possível mudar o campo de ativação do militar.');
	  }
    }
    public function desativaPessoa($idMilitar)
    { $q = "update pessoa set ";
	  $q = $q . "perm_pub_bi = 'N', ";
	  $q = $q . "data_atualiz = now() ";
	  $q = $q . " where  id_militar =  '".$idMilitar."'";;
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Não foi possível mudar o campo de ativação do militar.")
                                    </script>');
          //throw new Exception('ColPessoa->Não foi possível mudar o campo de ativação do militar.');
	  }
    }

    public function excluirRegistro($Pessoa)
    { $q = "delete from pessoa ";
	  $q = $q . " where  id_militar = '" . $Pessoa->getIdMilitar()."'";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('Não é possível excluir o militar');
          //throw new Exception('ColPessoa->Registro não excluído");
	  }
    }
    public function lerRegistro($idMilitar)
    { $q = "select id_militar,funcao_cod,nome,nome_guerra,data_nasc,nome_pai,
				nome_mae,cpf,pis_pasep,data_atualiz,sexo,perm_pub_bi, codom, cod_subun
			from pessoa";
	  $q = $q . "  where  id_militar = '" .$idMilitar."'";
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $row = mysqli_fetch_array($result);
	  	$pessoa = new pessoa(new Funcao(), new MinhaData($row['data_nasc']), new OmVinc(), new Subunidade());
                $pessoa->setIdMilitar($row['id_militar']);
		$pessoa->getFuncao()->setCod($row['funcao_cod']);
		$pessoa->setNome($row['nome']);
		$pessoa->setNomeGuerra($row['nome_guerra']);
		$pessoa->setNomePai($row['nome_pai']);
		$pessoa->setNomeMae($row['nome_mae']);
		$pessoa->setPisPasep($row['pis_pasep']);
		$pessoa->setCPF($row['cpf']);
		$pessoa->setDataAtualiz($row['data_atualiz']);
		$pessoa->setPermPubBI($row['perm_pub_bi']);
		$pessoa->setSexo($row['sexo']);
		$pessoa->getOmVinc()->setCodOM($row['codom']);
		$pessoa->getSubun()->setCod($row['cod_subun']);
        return $pessoa;
	  }
    }


  }
?>
