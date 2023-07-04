<?php
  class MeuLinkDB
  {
    private $mysql_host;
	private $mysql_user;
    private $mysql_password;
    private $my_database;
	private $db;
    public function MeuLinkDB($mysql_host, $mysql_user, $mysql_password, $my_database)
    { $this->mysql_host = $mysql_host;
	  $this->mysql_user = $mysql_user;
      $this->mysql_password = $mysql_password;
      $this->my_database = $my_database;

	}
	public function GerarConexao()
    {
      $this->db = @mysqli_connect($this->mysql_host, $this->mysql_user, $this->mysql_password, $this->my_database);
	  if (!$this->db) {
	  		$texto = 'Falhou a tentativa de conexão com o Banco de dados MysQL.\n';
	  		$texto .= 'Causas possíveis:\n';
	  		$texto .= ' 1. O banco ainda não foi criado;\n';
	  		$texto .= ' 2. Existe algum erro de configuração de usuário ou senha;\n';
	  		$texto .= ' 3. O MySQL não está ativado;\n\n';
	  		$texto .= '  - Consulte o manual de instalação...';
    		echo "<script>alert('".$texto."');
					//window.location.href = 'configuracao.php';
					</script>";
    		exit();
	  }
	  $this->updateBanco();
	  $this->terminarTransacao();
      return $this->db;
    }
    public function iniciarTransacao()
    {
      mysqli_autocommit($this->db, false);
    }

    public function terminarTransacao()
    {
      mysqli_commit($this->db);
    }

    public function cancelarTransacao()
    {
      mysqli_rollback($this->db);
    }

	public function verificaVersao($versao){
		$sql[0] = "select * from om";
		$sql[1] = "select versao from om where versao = '".$versao."'";
		for($i = 0; $i <= (count($sql) - 1); $i++){
			try{
				$result = mysqli_query($this->db, $sql[$i]);
	      		$num_rows = mysqli_affected_rows($this->db);
				if ($num_rows <= 0){
					return $i;
				};
			} catch (Exception $e) {
					return false;
			}
		}
		return 2; // Não há atualização a ser realizada
	}

    public function updateBanco(){
    	//echo '<br>sql'.$this->verificaVersao('1.0 rv 06');
		//echo "<script>window.location.href='erro_versao.php'</script>";
    	if ($this->verificaVersao('2.5') == 2) return;	//banco de dados atualizado
        
        if ($this->verificaVersao('2.4') == 2) {	
         			echo "<script>window.alert('O Sistema atualizará o BANCO DE DADOS da versão 2.4 para a versão 2.5!')</script>";
				$aComandos[0] = "ALTER TABLE `materia_bi` ADD `texto_comentario` longblob;";
				$aComandos[1] = "ALTER TABLE `usuariofuncaotipobol` MODIFY `login` VARCHAR ( 15 );";
				$aComandos[2] = "ALTER TABLE `funcoesdosistema` MODIFY `descricao` VARCHAR ( 100 )";
				$aComandos[3] = "INSERT INTO `funcoesdosistema` (`codigofuncao`, `descricao`, `assoc_tipobol`, `data_atualiz`, `ativado`) VALUES (3033,'Publicar Boletim sem Assinatura do Cmt/Ch/Dir','S','2013-06-10 12:00:00','S')";
				$aComandos[4] = "update om set versao =  '2.5'";
				
				
                                
    	} else {
			echo "<script>window.location.href='erro_versao.php'</script>";
        }

    	for($i = 0; $i <= (count($aComandos) - 1); $i++){
                if($aComandos[$i] == ''){
    			continue;
    		}
			try{
				//echo 'Comando: '.$aComandos[$i];
				$stmt = mysqli_prepare($this->db,$aComandos[$i]);
				if (!mysqli_stmt_execute($stmt)){
					echo '<br>Erro na Execução do comando: '.$aComandos[$i];
				};

				/* close statement */
				mysqli_stmt_close($stmt);

			} catch (Exception $e) {
				echo 'erro: '.$e;
			}
    	}
	}
  }
?>
