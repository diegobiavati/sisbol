<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_assunto.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_pgrad.php');
	require_once('./filelist_qm.php');
	require_once('./filelist_funcao.php');
	require_once('./filelist_om.php');
	require_once('./filelist_tipodoc.php');
	$fachadaSist2 = new FachadaSist2();
        $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);

	if(!empty($_GET["opcao"])){
		// Montar o combobox para as Seções do Boletim, conforme a Parte enviadas
		if ($_GET["opcao"] == "secaoBI"){
			$numeroParteAtual = $_GET["numeroParteAtual"];

			$colSecaoParteBi = $fachadaSist2->lerColecaoSecaoParteBi($numeroParteAtual);
			if (isset($_GET['numeroSecao'])){
				$numeroSecaoParteBiAtual = $_GET['numeroSecao'];
			}else {
				$obj = $colSecaoParteBi->iniciaBusca1();

				if (!is_null($obj)){
					$numeroSecaoParteBiAtual = $obj->getNumeroSecao();
				} else {
					$numeroSecaoParteBiAtual = 0;
				}
			}
			//echo 'Se&ccedil;&atilde;o:&nbsp';
			$apresentacao->montaCombo('seleSecaoParteBi',$colSecaoParteBi,'getNumeroSecao',
											'getDescricao',$numeroSecaoParteBiAtual,'onchangeSecao()');
		}
		// Montar um buscador para o Assunto Geral, conforme a Seção escolhida
		if ($_GET["opcao"] == "assuntoGeral"){
			$numeroParteAtual 	= $_GET["numeroParteAtual"];
			$numeroSecaoAtual 	= $_GET["numeroSecaoAtual"];
			$codTipoBol		 	= $_GET["codTipoBol"];
			$like				= $_GET["like"];

			$colAssuntoGeralLike = $fachadaSist2->lerColecaoAssuntoGeralLike($numeroParteAtual,$numeroSecaoAtual,$codTipoBol,$like);
			$numeroAssuntoGeralAtual = 0;

			$AssuntoGeral = $colAssuntoGeralLike->iniciaBusca1();
			$ord = 0;
  			//echo '<table width="680" border="1" cellpadding="0" cellspacing="0" bgcolor="white">';
  			echo '<table width="680" border="1" cellspacing="0" cellppading="0">
					<tr bgcolor="#006633">';
			echo '<td width="8%"><div align="center"><strong><font size="2"><font color="#FCD703">C&oacute;d</font></font></strong></div></td>
					<td width="92%"><div align="center"><strong><font size="2"><font color="#FCD703">Assunto Geral</font></strong></div></td></font></tr>';
			echo '<script>';
			echo '	function overLinha(linha){
							document.getElementById(linha).style.background = "#DDEDFF";
						}
						function outLinha(linha){
							document.getElementById(linha).style.background = "#F5F5F5";
						}
						function selecionaAssuntoGeral(cod,descricao){
							parent.setaAssuntoGeral(cod,descricao);
							parent.escondeFly();
							//window.alert(codAssunto);
						}

						</script>';
			while ($AssuntoGeral != null){
				$ord++;


				echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')"
						onClick="selecionaAssuntoGeral('.$AssuntoGeral->getCodigo().',\''.$AssuntoGeral->getDescricao().'\')" bgcolor="white">';
				echo '<td align="center"><font size="1">'.$AssuntoGeral->getCodigo().'</font></td>
				<td><font size="1">'.$AssuntoGeral->getDescricao().'</font></td></tr>';
				$AssuntoGeral = $colAssuntoGeralLike->getProximo1();
			}
			echo '</table>';
		}
		// Busca um assunto Geral, conforme o código inserido no cadastro de matéria
		if ($_GET["opcao"] == "umAssuntoGeral"){
			$numeroParteAtual 	= $_GET["numeroParteAtual"];
			$numeroSecaoAtual 	= $_GET["numeroSecaoAtual"];
			$codAssuntoGeral	= $_GET["codAssuntoGeral"];

			$AssuntoGeral = $fachadaSist2->lerAssuntoGeral($codAssuntoGeral);

			if ($AssuntoGeral != null){
				if (($AssuntoGeral->getParteBoletim()->getNumeroParte() == $numeroParteAtual) and ($AssuntoGeral->getSecaoParteBi()->getNumeroSecao() == $numeroSecaoAtual)){
					echo utf8_encode($AssuntoGeral->getDescricao());
				} else {
					echo utf8_encode('not_found');
				}
			} else {
				echo utf8_encode('not_found');
			}
		}

		// Busca um assunto Específico, conforme o código inserido no cadastro de matéria
		if ($_GET["opcao"] == "umAssuntoEspecifico"){
			$codAssuntoGeral	= $_GET["codAssuntoGeral"];
			$codAssuntoEspec	= $_GET["codAssuntoEspec"];

			$AssuntoEspec = $fachadaSist2->lerAssuntoEspec($codAssuntoGeral,$codAssuntoEspec);

			if ($AssuntoEspec != null){
				echo utf8_encode($AssuntoEspec->getDescricao());
			} else {
				echo utf8_encode('not_found');
			}
		}

		// Buscar assunto específico
		if ($_GET["opcao"] == "assuntoEspecifico"){
			$assuntoGeral 	= $_GET["assuntoGeral"];
			$acao = $_GET["acao"];

			// Monta o combobox para selecionar o assunto específico
			if($acao == "montaCombo"){
				$like			= $_GET["like"];
				$colAssuntoEspec = $fachadaSist2->lerColecaoAssuntoEspecLike($assuntoGeral,$like);
				$numeroAssuntoGeralAtual = 0;
				$AssuntoEspecifico = $colAssuntoEspec->iniciaBusca1();
				$ord = 0;
  				//echo '<table width="680" border="1" cellpadding="0" cellspacing="0" bgcolor="white">';
  				echo '<table width="680" border="1" cellspacing="0" cellppading="0">
					<tr bgcolor="#006633">';
				echo '<td width="8%"><div align="center"><strong><font size="2"><font color="#FCD703">C&oacute;d</font></font></strong></div></td>
					<td width="92%"><div align="center"><strong><font size="2"><font color="#FCD703">Assunto Espec&iacute;fico</font></strong></div></td></font></tr>';

				while ($AssuntoEspecifico != null){
					$ord++;
					echo '<script>';
					echo '	function overLinha(linha){
							document.getElementById(linha).style.background = "#DDEDFF";
						}
						function outLinha(linha){
							document.getElementById(linha).style.background = "#F5F5F5";
						}
						function selecionaAssuntoGeral(cod,descricao){

							parent.setaAssuntoEspecifico(cod,descricao);
							parent.escondeFly();
							//window.alert(codAssunto);
						}

						</script>';
					echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')"
						onClick="selecionaAssuntoGeral('.$AssuntoEspecifico->getCodigo().',\''.$AssuntoEspecifico->getDescricao().'\')" bgcolor="white">';
					echo '<td align="center"><font size="1">'.$AssuntoEspecifico->getCodigo().'</font></td>
						<td><font size="1">'.$AssuntoEspecifico->getDescricao().'</font></td></tr>';
						$AssuntoEspecifico = $colAssuntoEspec->getProximo1();
				}
			echo '</table>';
			}

			// Busca texto de abertura e fechamento do assunto específico -Atualizado para FCKEditor
			if($acao == "buscaTextoAbertura"){
				$codAssuntoEspec =  $_GET["codAssuntoEspec"];
				$assuntoEspec 	 = $fachadaSist2->lerAssuntoEspec($assuntoGeral,$codAssuntoEspec);
				echo $assuntoEspec->getVaiAlteracao().'S';
				echo utf8_encode($assuntoEspec->getTextoPadAbert()).'$wxxw$';
				echo utf8_encode($assuntoEspec->getTextoPadFech());
			}

			if($acao == "listaPessoaMateria"){
				$codMateriaBI = $_GET['codMateria'];
				$colPessoaMateriaBi2 = $fachadaSist2->lerColecaoPessoaMateriaBI($codMateriaBI);
				$PessoaMateriaBI = $colPessoaMateriaBi2->iniciaBusca1();
				echo '<table width="830" border="0" >';
				echo '<td align="left"><div id="divPessoa"></div></td>';
				echo '<TD align="right" valign="center">Legenda:&nbsp;&nbsp;';
		        echo '<img src="./imagens/alterar.png" title="Alterar/Adiciona texto indiv." border=0>&nbsp;Alterar/Adiciona texto indiv.&nbsp;';
        		echo '<img src="./imagens/excluir.png" title="Excluir" border=0>&nbsp;Exclui da mat&eacute;ria&nbsp;';
			    echo '</TD>';
			    echo '</TR>';
		    	echo '</TABLE>';
				echo '<table width="830" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>';
				echo '<table width="100%" border="0" cellspacing="1" cellpadding="0">';
				echo '<tr class="cabec">';
				echo '<td width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>';
				echo '<td width="10%" align="center"><strong><font size="2">';
				echo 'P/Grad</font></strong></td>';
				echo '<td width="70%"%" align="center"><strong><font size="2">Nome</font></strong></td>';
				echo '<td width="10%" align="center"><strong><font size="2">A&ccedil;&atilde;o</font></strong></td>';
  				$ord = 0;
  				//print_r($PessoaMateriaBI);
				while ($PessoaMateriaBI != null){
					$ord++;
					$idMilitar = $PessoaMateriaBI->getPessoa()->getIdMilitar();
					$Militar = $fachadaSist2->lerMilitar($idMilitar);

					$pQM = $fachadaSist2->lerQM($Militar->getQM()->getCod());
					$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
					echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')"
							onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
							<td align="center" valign="top">'.$ord.'</TD>';
					echo '<TD align="center" valign="top">'.$pGrad->getDescricao().'</TD>';
					//echo '<br>'.$Militar->exibeDados().'<br>';
					echo '<TD valign="top">'
//					  .utf8_encode($apresentacao->setaNomeGuerra($Militar->getNome(),$Militar->getNomeGuerra()));
					  .$Militar->getNome().' ('.$Militar->getNomeGuerra().')';
					if (trim($PessoaMateriaBI->getTextoIndiv()) !== ''){
						echo '<br>'.utf8_encode($PessoaMateriaBI->getTextoIndiv());
					}
					echo '</td><td align="center" valign="top">';
					//(codMateria,codPessoa)
					echo '<a href="javascript:carregaTextoIndividual('.$codMateriaBI.',\''.$idMilitar.'\')">';
					echo '<img src="./imagens/alterar.png" title="Altera/Adiciona texto individual." border=0></a>&nbsp;&nbsp;|&nbsp;&nbsp;';
					echo '<a href="javascript:excluiPessoaMateria('.$codMateriaBI.',\''.$idMilitar.'\')">';
					echo '<img src="./imagens/excluir.png" title="Excluir" border=0></a></td></tr>';
					echo '</TR>';
					$PessoaMateriaBI = $colPessoaMateriaBi2->getProximo1();
				}
				echo '</td></tr></table>';
  				echo '</td></tr></table>';
			}

			// Monta a lista para a busca dos militares envolvidos
			if($acao == "listaMilitar"){
				$codMateriaBI = $_GET['codMateria'];
				$codpgrad     = $_GET["pgrad"];
				$nome         = $_GET["nome"];
				$codom 		  = $_GET['codom'];
				$codSubun	  = $_GET['codSubun'];
				$todasOmVinc  = $_GET['x'];
				$todasSubun	  = $_GET['y'];
				$colMilitar2  = $fachadaSist2->lerColMilNaoIncMatBI($codpgrad, $nome, $codMateriaBI, $codom, $codSubun, $todasOmVinc, $todasSubun);

				$Militar = $colMilitar2->iniciaBusca1();
  				echo '<br><table width="90%" border="1" cellspacing="0" cellppading="0" class="lista"><tr class="cabec">';
  				echo '<td colspan="7" align="center">Adicione o(s) Militar(es)</td></tr>';
  				$ord = 0;
				while ($Militar != null){
					// Capturando a descrição da QM
					$ord++;
					$pQM   = $fachadaSist2->lerQM($Militar->getQM()->getCod());
					$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
					$omVinc = $fachadaSist2->lerOMVinc($Militar->getOmVinc()->getCodOM());
					$subun = $fachadaSist2->lerSubun($Militar->getOmVinc()->getCodOM(),$Militar->getSubun()->getCod());
					echo '<tr id='.($ord + 2000).' onMouseOut="outLinha('.($ord + 2000).')"
							onMouseOver="overLinha('.($ord + 2000).')" bgcolor="#F5F5F5">
							<td align="center">'.$ord.'</TD>';
					echo '<TD>'.$omVinc->getSigla().'</TD>';
					echo '<TD>'.$subun->getSigla().'</TD>';
					echo '<TD>'.$pGrad->getDescricao().'</TD>';
					echo '<TD>'.$Militar->getNome().' ('.$Militar->getNomeGuerra().')</TD>';
					echo '<TD align="center"><input type="checkbox" name="CheckIdMilitar[]"
							value ="'.$Militar->getIdMilitar().'"></TD>';
					echo '<TD align="center"><a href="javascript:adicionaPessoaIndividual('.$codMateriaBI.',\''.$Militar->getIdMilitar().'\')">
					<img src="./imagens/add.png" border="0" title="Adiciona pessoa individualmente."></a></TD>';
					//echo '<TD align="center"><input type="checkbox" name="milSelected[]" value="'.$Militar->getIdMilitar().'"></TD>';
					echo '</TR>';
	  				$Militar = $colMilitar2->getProximo1();
  				}
				echo '</table>';
  				if ($ord > 0){
				  echo '<table width="81%" border="0" cellspacing="0" cellppading="0"><TR bgcolor="#F5F5F5">
    				<TD colspan="3" align="right">
					<INPUT TYPE="button" NAME="Executar" VALUE="Adicionar" onclick="adicionaPessoaMateria('.$codMateriaBI.')">
	 				&nbsp;&nbsp;&nbsp;
					<a href="javascript:marcaTudo(document.cadMateriaBI,true)">Marca Tudo</a>&nbsp;/&nbsp;
					<a href="javascript:marcaTudo(document.cadMateriaBI,false)">Desmarca Tudo</a>
					</td>
					<td align="center">
					<img src="./imagens/seta.png" border="0">
					</td>';
  				  echo '</table>';
  				}
	  		}
		}

		// Adicionar excluir e alterar pessoaMateriaBI
	  	if ($_GET["opcao"]   == "pessoaMateria"){
			$codMateriaBI 	 = $_GET['codMateria'];
			$codPessoa 		 = $_GET['codPessoa'];
			$materiaBi 		 = $fachadaSist2->lerRegistroMateriaBI($codMateriaBI);
			$pessoa 		 = new Pessoa(null, null, null);
        	$pessoaMateriaBi = new PessoaMateriaBi($pessoa);
			$pessoaMateriaBi->getPessoa()->setIdMilitar($codPessoa);
			if($acao == "adicionaPessoaMateria"){
				$fachadaSist2->incluirPessoaMateriaBI($materiaBi, $pessoaMateriaBi);
			}
			if($acao == "excluiPessoaMateria"){
				$fachadaSist2->excluirPessoaMateriaBI($materiaBi, $pessoaMateriaBi);
			}
		}

		if ($_GET["opcao"] == "formAlteraTextoIndividual"){
			$codMateriaBI 	 = $_GET['codMateria'];
			$codPessoa 		 = $_GET['codPessoa'];
			$Militar = $fachadaSist2->lerMilitar($codPessoa);
			$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
			$pessoaMateriaBI = $fachadaSist2->lerPessoaMateriaBI($codMateriaBI, $codPessoa);
			echo utf8_encode($pessoaMateriaBI->getTextoIndiv());
/*			echo '<TABLE width="85%" bgcolor="#0000FF" CELLPADDING="0"><TR><TD>
					<TABLE class="formulario" width="100%" border="0" BORDERCOLOR="#C0C0C0" BORDERCOLORLIGHT="#C0C0C0"
						CELLSPACING="0" CELLPADDING="0" name="tabela">
					<TR CLASS="cabec"><TD><font size="2"><div id="tituloForm">Texto Individual:';
			echo ' '.$pGrad->getDescricao().'-'.$Militar->getNome();

			echo '</div></font></TD></TR><TD BGCOLOR="#C0C0C0">
						<script>
				    		oFCKIndiv.ToolbarSet = "CadMatBI" ;
				    		oFCKIndiv.Height = 150 ;
				    		oFCKIndiv.Value = "";
							oFCKIndiv.Create();
						</script>
					<textarea name="texto_individual" cols="96" rows="3">'.$pessoaMateriaBI->getTextoIndiv().'</textarea>
					</TD></TR><TR>
					<TD BGCOLOR="#C0C0C0" align="center">
					<input name="acao" type="button" value="Salvar"
						onclick="salvarTextoIndividual('.$codMateriaBI.',\''.$codPessoa.'\')">
					<input name="cancela" type="button" value="Cancelar" onclick="cancelar()"><TD>
					</TR></table>
				</TD></TR></TABLE>';
			echo '<script>window.location.href="#bottom";</script>';*/
		}

		if ($_GET["opcao"] == "alteraTextoIndividual"){

		}

		if ($_GET["opcao"] == "novoAssuntoGeral"){
			$numeroParteAtual 	= $_GET["numeroParteAtual"];
			$numeroSecaoAtual 	= $_GET["numeroSecaoAtual"];
			$codTipoBol 	= $_GET["codTipoBol"];
			echo '<script>';
			echo 'function incluirAssuntoGeral(descricao){';
			$url = "ajax_materia_bi.php?opcao=incluirAssuntoGeral&numeroParteAtual=".
					$numeroParteAtual . "&numeroSecaoAtual=".$numeroSecaoAtual."&codTipoBol=".$codTipoBol."&descricao=";
			//echo 'alert("'.$url.'" + descricao);';
			echo 'ajaxExecuta("'.$url.'" + descricao,null)';

			echo  "}";
			echo 'function ajaxExecuta(url,obj){
					objLocal = obj;
					req = null;
					// Procura por um objeto nativo (Mozilla/Safari)
					if (window.XMLHttpRequest) {
						req = new XMLHttpRequest();
						req.onreadystatechange = processReqChangeExecuta;
						req.open("GET",url,true);
						req.send(null);
						// Procura por uma versão ActiveX (IE)
					} else if (window.ActiveXObject) {
						req = new ActiveXObject("Microsoft.XMLHTTP");
						if (req) {
							req.onreadystatechange = processReqChangeExecuta;
							req.open("GET",url,true);
							req.send();
						}
					}
				}';
			echo 'function processReqChangeExecuta(){
					if (req.readyState == 4) {
						if (req.status ==200) {
							//alert((req.responseText).lastIndexOf("RGRASSUNTOGERAL"))
							if((req.responseText).lastIndexOf("RGRASSUNTOGERAL") == -1){
								var arrayAssuntoGeral = (req.responseText).split("$@$");
								buscaUltimoAssuntoGeral(arrayAssuntoGeral[0],arrayAssuntoGeral[1]);

							} else {
								window.alert("Falha na inclusão do Assunto Geral.\nO Assunto Geral não pode ser nulo.");
								document.formCadAssuntoGeral.descricao.focus();
							}
						} else {
							window.alert("Erro de AJAX. \nHouve um problema ao obter os dados do servidor: " + req.statusText);
						}
					}
				}';
			echo 'function buscaUltimoAssuntoGeral(cod,descricao){
							//alert(cod + " " + descricao);
							//parent.document.cadMateriaBI.inputAssuntoGeral.value = descricao;
							parent.setaAssuntoGeral(cod,descricao);
							parent.escondeFly();

							//parent.buscaAssuntoEspecifico(\'\');
						}';
			echo 'function isEnterKey(evt) {
				var key_code = evt.keyCode  ? evt.keyCode  :
       	     	evt.charCode ? evt.charCode :
                evt.which    ? evt.which    : void 0;
				if (key_code == 13){
       				return true;
    			}
			}';
			echo 'function isEscKey(evt) {
				var key_code = evt.keyCode  ? evt.keyCode  :
       	     	evt.charCode ? evt.charCode :
                evt.which    ? evt.which    : void 0;
				if (key_code == 27){
       				return true;
    			}
			}';
			echo 'function carrega(evento){
					if(isEnterKey(evento)){
						incluirAssuntoGeral(document.formCadAssuntoGeral.descricao.value);
					}
					if(isEscKey(evento)){
						parent.escondeFly();
					}
				}';
			echo '</script>';
			//echo $numeroSecaoAtual;
			//echo $numeroParteAtual;
			echo '<form name="formCadAssuntoGeral"><TABLE bgcolor="#006633" CELLPADDING="1" ><TR><TD>
				<TABLE border="2" BORDERCOLOR="#C0C0C0" BORDERCOLORLIGHT="#C0C0C0" CELLSPACING="0" CELLPADDING="0" name="tabela">
                                    <TR CLASS="cabec"><TD><font size="2" color="yellow"><b>Inclui Assunto Geral<b></font></TR></TD>
                                    <TD BGCOLOR="#C0C0C0" align="right">Descrição: <input name="descricao" type="text" size="100" maxlength="100" onkeydown="carrega(event)"><br>
                                    <input name="acao" type="button" value="Incluir" onclick="incluirAssuntoGeral(document.formCadAssuntoGeral.descricao.value)"><br></TD>
                                </table></TABLE></form><script>document.formCadAssuntoGeral.descricao.focus();</script>';
		}
		if ($_GET["opcao"] == "incluirAssuntoGeral"){
			$numeroParteAtual 	= $_GET["numeroParteAtual"];
			$numeroSecaoAtual 	= $_GET["numeroSecaoAtual"];
			$codTipoBol 	= $_GET["codTipoBol"];
			$parteBoletim 		= new ParteBoletim(null);
		    $parteBoletim->setNumeroParte($numeroParteAtual);
		    $secaoParteBi 		= new SecaoParteBi();
		    $secaoParteBi->setNumeroSecao($numeroSecaoAtual);
		    $tipoBol = new TipoBol();
		    $tipoBol->setCodigo($codTipoBol);
  			$assuntoGeral 		= new AssuntoGeral($parteBoletim,$secaoParteBi,$tipoBol,null);
  			$assuntoGeral->setDescricao($_GET['descricao']);
  			$assuntoGeral->setOrdAssuntoGeral(0);
			$fachadaSist2->incluirAssuntoGeral($assuntoGeral);
			$UltimoAssuntoGeral = $fachadaSist2->lerUltimoAssuntoGeral();
			echo $UltimoAssuntoGeral->getCodigo()."$@$".$UltimoAssuntoGeral->getDescricao();
		}
		if ($_GET["opcao"] == "novoAssuntoEspecifico"){
			$numeroParteAtual 	= $_GET["numeroParteAtual"];
			$numeroSecaoAtual 	= $_GET["numeroSecaoAtual"];
			$numeroAssuntoGeral = $_GET["numeroAssuntoGeral"];
			echo '<script src="scripts/overlib.js"></script>' .
				 '<script src="scripts/msg_hints.js"></script>';
			echo '<script>function incluirAssuntoEspecifico(descricao){';
			echo 'var vai_altr, vai_indice;';
			echo 'vai_altr = (document.formCadAssuntoEspecifico.vai_altr.checked==true?\'S\':\'N\');';
			echo 'vai_indice = (document.formCadAssuntoEspecifico.vai_indice.checked==true?\'S\':\'N\');';
			$url = "ajax_materia_bi.php?opcao=incluirAssuntoEspecifico&numeroParteAtual=".$numeroParteAtual .
					"&codAssuntoGeral=".$numeroAssuntoGeral .
					"&numeroSecaoAtual=".$numeroSecaoAtual."&descricao=";
			//echo 'alert("'.$url.'" + descricao + \'&vai_altr=\' + vai_altr);';
			echo 'ajaxExecuta("'.$url.'" + descricao + \'&vai_altr=\' + vai_altr+ \'&vai_indice=\' + vai_indice,null)';
			echo  "}";
			echo 'function ajaxExecuta(url,obj){
					objLocal = obj;
					req = null;
					// Procura por um objeto nativo (Mozilla/Safari)
					if (window.XMLHttpRequest) {
						req = new XMLHttpRequest();
						req.onreadystatechange = processReqChangeExecuta;
						req.open("GET",url,true);
						req.send(null);
						// Procura por uma versão ActiveX (IE)
					} else if (window.ActiveXObject) {
						req = new ActiveXObject("Microsoft.XMLHTTP");
						if (req) {
							req.onreadystatechange = processReqChangeExecuta;
							req.open("GET",url,true);
							req.send();
						}
					}
				}';
			echo 'function processReqChangeExecuta(){
					if (req.readyState == 4) {
						if (req.status ==200) {
								//alert(req.responseText);
								if((req.responseText).lastIndexOf("RGRASSUNTOESPECIFICO") == -1){
								  var arrayAssuntoEspecifico = (req.responseText).split("$@$");
								  buscaUltimoAssuntoEspecifico(arrayAssuntoEspecifico[0],arrayAssuntoEspecifico[1]);
							} else {
								window.alert("Falha na inclusão do Assunto Geral.\nO Assunto Específico não pode ser nulo.");
								document.formCadAssuntoEspecifico.descricao.focus();
							}
						} else {
							window.alert("Erro de AJAX. \nHouve um problema ao obter os dados do servidor: " + req.statusText);
						}
					}
				}';
			echo 'function isEnterKey(evt) {
				var key_code = evt.keyCode  ? evt.keyCode  :
       	     	evt.charCode ? evt.charCode :
                evt.which    ? evt.which    : void 0;
				if (key_code == 13){
       				return true;
    			}
			}';
			echo 'function isEscKey(evt) {
				var key_code = evt.keyCode  ? evt.keyCode  :
       	     	evt.charCode ? evt.charCode :
                evt.which    ? evt.which    : void 0;
				if (key_code == 27){
       				return true;
    			}
			}';
			echo 'function carrega(evento){
					if(isEnterKey(evento)){
						incluirAssuntoEspecifico(document.formCadAssuntoEspecifico.descricao.value);
					}
					if(isEscKey(evento)){
						parent.escondeFly();
					}
				}';
			echo 'function buscaUltimoAssuntoEspecifico(cod,descricao){
							parent.setaAssuntoEspecifico(cod,descricao);
							parent.escondeFly();
							//window.alert(codAssunto);
						}
			</script>';
			//echo $numeroSecaoAtual;
			//echo $numeroParteAtual;
			//RV05
			echo '<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
				 <form name="formCadAssuntoEspecifico"><TABLE bgcolor="#006633" CELLPADDING="1" width="100%"><TR><TD>
				<TABLE width="100%" border=0 BORDERCOLOR="#C0C0C0" BORDERCOLORLIGHT="#C0C0C0" CELLSPACING="0" CELLPADDING="0" name="tabela">
				<TR CLASS="cabec"><TD><font size="3" color="yellow"><b>Inclui Assunto Específico<b></font></TD></TR>
				<TR><TD BGCOLOR="#C0C0C0"><p align="right"><br>Descrição:<input name="descricao" type="text" size="100" maxlength="100" onkeydown="carrega(event)"   onmouseover="return overlib(getMsg(2), CAPTION,\'Como omitir este título no BI ?\');" onmouseout="return nd();"/>
				<input type="hidden" id="teste" name="testebusca" size="0" maxlenght="0" style="width:0px; height:"0px"">&nbsp;&nbsp;</p>
				<TR><TD BGCOLOR="#C0C0C0" align="right"><br>Vai para alterações: <input name="vai_altr" type="checkbox" checked>Vai para Índice: <input name="vai_indice" type="checkbox" checked>
				&nbsp;&nbsp;<br><br></TD></TR><TR><TD BGCOLOR="#C0C0C0" align="right">
				<input name="acao" type="button" value="Incluir" onclick="incluirAssuntoEspecifico(document.formCadAssuntoEspecifico.descricao.value)"><TD>
				</TR></table>
				</TD></TR></TABLE></form>
				<script>document.formCadAssuntoEspecifico.descricao.focus();</script>';
		}

		if ($_GET["opcao"] == "incluirAssuntoEspecifico"){
			$numeroParteAtual 	= $_GET["numeroParteAtual"];
			$numeroSecaoAtual 	= $_GET["numeroSecaoAtual"];
			$codAssuntoGeral 	= $_GET["codAssuntoGeral"];
			$vai_altr			= $_GET["vai_altr"];
			$vai_indice			= $_GET["vai_indice"];

			$assuntoGeral=$fachadaSist2->lerAssuntoGeralComp($codAssuntoGeral);
  			$assuntoEspec = new AssuntoEspec();
  			$assuntoEspec->setCodigo(0);
  			$assuntoEspec->setDescricao($_GET['descricao']);
			$assuntoEspec->setVaiAlteracao($vai_altr);
			$assuntoEspec->setVaiIndice($vai_indice);
			$fachadaSist2->incluirAssuntoEspec($assuntoGeral,$assuntoEspec);
			$UltimoAssuntoEspecifico = $fachadaSist2->lerUltimoAssuntoEspecifico();
			//echo print_r($UltimoAssuntoEspecifico);
			echo $UltimoAssuntoEspecifico->getCodigo()."$@$".$UltimoAssuntoEspecifico->getDescricao()."$@$".utf8_encode($UltimoAssuntoEspecifico->getVaiAlteracao());
		}
		
	}
?>
