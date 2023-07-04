<?php
  class Apresentacao {
    private $funcoesPermitidas;
	private $versao = "2.3";
	private $dataVersao = "julho 2012";
	private $nome_OM;
	private $om;



	private $aMes = array( 1=> 'Janeiro', 'Fevereiro','Março','Abril','Maio','Junho',
            	          'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
	//barra de menu principal
  	private $aMenu = array(1 =>	"Cadastros","Acessa os cadastros do Sistema.",
								"Nota para Boletim","Confecção de Boletins.",
  								"Boletins","Confecção de Boletins.",
								"Alterações","Gera Alterações dos Militares.",
								"Especiais","Acessa as opções especiais do Sistema.",
								"Ajuda","Disponibiliza os arquivos de ajuda.",
								"Sair","Sair do Sistema.");

  	private $aArq = array(1 =>	"menuboletim.php","0",
								"menuboletim.php","0",
								"menuboletim.php","0",
								"menuboletim.php","0",
								"menuboletim.php","1",
								"menuboletim.php","1",
								"logout.php","1"
								);
  	/* Monta os submenus*/
	private $aSubMenu = array(1 =>	1,"Posto/Graduação",
									1,"Funções",
									1,"Qualificação Militar",
									1,"OM de Vinculação",
									1,"Subunidade/Divisão/Seção",
									1,"Militares",
									1,"Tipo de Boletim",
									1,"Organização Militar",
									1,"Tipos de Documentos",
									1,"Partes do Boletim",
									1,"Seções do Boletim",
									1,"Assunto Geral",
									1,"Assunto Específico",

									3,"Em elaboração",
									3,"Aprovação da SU/Div/Sec",
									3,"Aprovação do Cmt/Ch/Dir",
									3,"Adicionar Nota em Boletim",
									3,"Retirar Nota do Boletim",


									5,"Em elaboração",
									5,"Aprovação",
									5,"Assinar",
									5,"Cancelar assinatura",
									5,"Ordernar matérias",  //rv 06
									5,"Baixar Boletim Gerado",
									5,"Regerar Boletim",
									5,"Gerar Índice",

									7,"Tempos de Serviço",
									7,"Aprovar Alterações",
									7,"Gerar Alterações",
									7,"Baixar Alterações Geradas",
									7,"Gerar Ficha de Identificação",

									9,"Gerar Backup",
									9,"Restaurar/Apagar Backup",
									9,"Encerrar Ano",
									9,"Usuários",

									9,"Perfil do Usuário - Tipo Boletim",
									/*9,"Perfil por Tipo de Boletim",  rv 06*/
									9,"Alterar Senha",
									9,"Reinicializar a Senha do Supervisor",
									9,"Importa dados do Módulo E1",
									9,"Configurações",


									11,"Ajuda",
									11,"Conteúdo on-line",
									11,"Sobre");

    //lista de arquivos chamados
  	private $aSubArq = array(1 =>	"cadpgrad.php","1004",
									"cadfuncoes.php","1014",
									"cadqm.php","1024",
									"cad_om_vinc.php","1044",
									"cad_subun.php","1049",
									"cadmilitar.php","1034",
									"cadtipoboletim.php","1054",
									"cadom.php","1064",
									"cadtipodoc.php","1074",
									"cadparteboletim.php","1084",
									"cadsecaopartebi.php","1094",
									"cadassuntogeral.php","1104",
									"cadassuntoespec.php","1114",

									"elabomatbi.php","2004",
									"aprovamatbi.php","2011",
									"publiquesematbi.php","2013",
									"inc_mat_bol.php","2021",
									"exc_mat_bol.php","2022",

									"cadboletim.php","3004",
									"aprovarboletim.php","3011",
									"assinarboletim.php","3021",
									"cancelarassinarbi.php","3022",
									"ord_mat_bol.php", "3023", 		//rv 06
									"baixar_boletim.php","3030",	//rv 05
									"gerarboletim.php","3031",
									"gerarindice.php","3032",

									"cadtemposv.php","1124",
									"aprova_alteracoes.php","1131",
									"geraralteracao.php","1133",
									"baixar_alteracao.php","1135",
									"gerarficha.php","1134",

									"backup.php","1141",
									"tablerecovery.php","1142",
									"encerrarano.php","1143",
									"usuarios.php","1154",

									"perfil_usuario.php","1164",
									/*"usuario_assoc_bi.php","1184", rv 06*/
									"alterar_senha.php","1",
									"alterar_senha_sup.php","2",
									"importme1.php","1194",
									"configuracoes.php","1195",


									"javascript:viewHelp()","3",
									"javascript:online()","4",
									"sobre.php","5");

	public $dtIniSem,$dtFimSem,$Sem;


  	public function Apresentacao($funcoesPermitidas){
	  	if($funcoesPermitidas == null) return true;
		$this->funcoesPermitidas = $funcoesPermitidas;

		if ($this->tipoUsuario() == -1){
			echo '<script type="text/javascript">window.alert("Você tem de estar logado ao sistema para acessar este módulo");
					window.location.href="sisbol.php";
                              </script>';
  	  }
  	}

	function chamaHelp(){
		return '<script type="text/javascript">
			var janelaHelp, janelaOnline;
			function viewHelp(){
				if ((janelaHelp == undefined)){
					janelaHelp = window.open("help_sisbol/!SSL!/WebHelp/help_sisbol.htm","","height=500,width=900,resizable,toolbar,menubar");
				}else if (janelaHelp.closed){
					janelaHelp = window.open("help_sisbol/!SSL!/WebHelp/help_sisbol.htm","","height=500,width=900,resizable,toolbar,menubar");
				}
				if (janelaHelp != null){
					janelaHelp.focus();
				}
			}
			function online(){
				if ((janelaOnline == undefined)){
					janelaOnline = window.open("http://www.3cta.eb.mil.br/Sisbol_site/index.html","","height=500,width=900,resizable,toolbar,scrollbars,location");
				}else if (janelaOnline.closed){
					janelaOnline = window.open("http://www.3cta.eb.mil.br/Sisbol_site/index.html","","height=500,width=900,resizable,toolbar,scrollbars,location");
				}
				if (janelaOnline != null){
					janelaOnline.focus();
				}
			}
		</script>';
	}

	function tipoUsuario()
	{
		if(isset($_SESSION['TIPOUSER'])){
			return $_SESSION['TIPOUSER'];
		} else {
			return -1;
		}
	}

  	public function montaMenu(){
//		print_r($this->aSubArq);
 		echo $this->chamaHelp();
		echo '<div id="divAjuda"></div>';
		echo ' <table width="895" border="0"><tr><td align="center"><div class="horizontalcssmenu">';
		echo '<ul id="cssmenu1">';
		//varre o vetor da barra de menu principal
  		for ($i=1; $i <= count($this->aMenu);$i=$i+2){
			echo '<li><a href="'.$this->aArq[$i].'" title="'.$this->aMenu[($i + 1)].'">'.$this->aMenu[($i)].'</a>';
			echo '<ul>'.chr(13);
			//varre o submenu de cada opcao da barra de menus
			//echo '<div class="topo-dir">';
			for ($j=1; $j <= count($this->aSubMenu);$j=$j+2){
				if ($i == $this->aSubMenu[$j])
				{ //cria uma lista de links
					//echo $_SESSION['APROVNOTA1'];
					if ($_SESSION['NOMEUSUARIO'] == 'supervisor')
					{ if ($this->aSubArq[$j] != 'alterar_senha.php')
					  { 
						//verifica se o nivel de aprovacao SU/Div/Sec está habilitado ou nao
					  	if (($this->aSubArq[$j] == 'aprovamatbi.php')||($this->aSubArq[$j] == 'publiquesematbi.php')||($this->aSubArq[$j] == 'aprovarboletim.php')){
							if (($this->aSubArq[$j] == 'aprovamatbi.php')&&($_SESSION['APROVNOTA1']) == 'S'){
							  echo '<li id="m'.$this->aSubArq[$j+1].'"><a href="'.$this->aSubArq[$j].'">'.$this->aSubMenu[($j + 1)].'</a>
    							  </li>'.chr(13);
    						}
							if (($this->aSubArq[$j] == 'publiquesematbi.php')&&($_SESSION['APROVNOTA2'] == 'S')){
							  echo '<li id="m'.$this->aSubArq[$j+1].'"><a href="'.$this->aSubArq[$j].'">'.$this->aSubMenu[($j + 1)].'</a>
    							  </li>'.chr(13);
    						}
							if (($this->aSubArq[$j] == 'aprovarboletim.php')&&($_SESSION['APROVBOLETIM'] == 'S')){
							  echo '<li id="m'.$this->aSubArq[$j+1].'"><a href="'.$this->aSubArq[$j].'">'.$this->aSubMenu[($j + 1)].'</a>
    							  </li>'.chr(13);
    						}
						}else{	  
						  echo '<li id="m'.$this->aSubArq[$j+1].'"><a href="'.$this->aSubArq[$j].'">'.$this->aSubMenu[($j + 1)].'</a>
	   						  </li>'.chr(13);
	   					}
						//verifica se o nivel de aprovacao Cmt/Ch/Dir está habilitado ou nao
/*					  	if ($this->aSubArq[$j] == 'publiquesematbi.php'){
							if ($_SESSION['APROVNOTA2'] == 'S'){
							  echo '<li id="'.$this->aSubArq[$j+1].'"><a href="'.$this->aSubArq[$j].'">'.$this->aSubMenu[($j + 1)].'</a>
    							  </li>'.chr(13);
    						}
						}else{	  
						  echo '<li id="'.$this->aSubArq[$j+1].'"><a href="'.$this->aSubArq[$j].'">'.$this->aSubMenu[($j + 1)].'</a>
	   						  </li>'.chr(13);
	   					}*/
    				  }
					}
					else
					{ $funcao = $this->funcoesPermitidas->lerRegistro($this->aSubArq[$j+1]);
					  if (($funcao != null) or (($this->aSubArq[$j+1] >= 5)and ($this->aSubArq[$j] != 'alterar_senha_sup.php') and ($this->aSubArq[$j] != 'importme1.php')))
					  //if (($funcao != null) or ($this->aSubArq[$j+1] == 1))
					  { 
					  	echo '<li><a href="'.$this->aSubArq[$j].'">'.$this->aSubMenu[($j + 1)].'</a></li>'.chr(13);
					  }
					}
				}
			}
			echo '</ul>';
			echo '</li>';
  		}
		echo '</ul>'.chr(13);
		/*echo '</div>';*/

		if ($_SESSION['APROVNOTA1'] == 'N')
			/*echo '<script>$(".horizontalcssmenu a").css("color", "#0000FF");</script>';*/
			echo '<script type="application/javascript">$("#2011").css("color", "#0000FF");</script>';
		else
			/*echo '<script type="application/javascript">$(".horizontalcssmenu ul li a").css("color", "#0000FF");</script>';*/
			echo '<script type="application/javascript">$("#2011").css("color", "#000000");</script>';

		echo '<br style="clear: left;" />';
		echo '</div>';
                echo '</td></tr></table>';
  	}

  	public function chamaEstilo(){
		echo '<link REL="SHORTCUT ICON" HREF="favicon.ico" type = "x-icon">'.chr(13);
		echo '<link href="band.css" rel="stylesheet" type="text/css">'.chr(13);
		echo '<link href="custom-theme/jquery-ui-1.7.3.custom.css" rel="stylesheet" type="text/css">'.chr(13);
		
		//echo '<link type="text/css" rel="Stylesheet" href="ui.all.css">'.chr(13); --> slopes
		echo '<script type="text/javascript" src="scripts/jquery-1.7.2.js"></script>'.chr(13);
		echo '<script type="text/javascript" src="scripts/ajuda.js"></script>'.chr(13);
		/*echo '<script type="text/javascript" src="scripts/jquery-ui-personalized-1.5.3.js">  </script>'.chr(13);--> slopes */
 	}

  	public function chamaCabec(){
            $user = (isset($_SESSION['NOMEUSUARIO']))?$_SESSION['NOMEUSUARIO']:'Visitante';
            $omVinc = (isset($_SESSION['SIGLA_OM_VINC']))?$_SESSION['SIGLA_OM_VINC']:'Não definida';
            $subun = (isset($_SESSION['SIGLA_SUBUN']))?$_SESSION['SIGLA_SUBUN']:'Não definida';
            // Buscar os dados da OM
            //$this->nome_OM = (isset($_SESSION['OM']))?($_SESSION['OM']):'OM';
            //$nome_OM = 'om';
            echo '<div class="style1" id="topo">';
            echo '<table width="980" border="0" align="center" cellspacing="2"><tr>';
            echo '	<td width="30%"><div align="left"><img src="imagens/titulo.png" alt=""></div>
    			<div align="center" class="style1"></div></td>
      			<td width="5%">&nbsp;</td>
      			<td width="30%" valign="bottom" align="right">
			<table border="0" width="500" cellspacing="0" >
			<tr><td align="right" class="cabec1">OM:</td>';
        			echo (strlen($_SESSION['ORGANIZACAO'])>45)?'<td colspan="3" class="cabec3">':'<td colspan="3" class="cabec2">';
		echo (!empty($_SESSION['ORGANIZACAO']))?($_SESSION['ORGANIZACAO']):'N&atilde;o Cadastrada';
		echo '</td><td align="right" class="cabec1">Vers&atilde;o:</td><td class="cabec2">'.$this->versao.'</td></tr>
				<tr class="cabec1"><td align="right" class="cabec1">OM Vinc:</td>
					<td class="cabec2">'.$omVinc.'</td><td  align="right" class="cabec1">SU/Div:</td>
					<td class="cabec2">'.$subun.'</td><td  align="right" class="cabec1">Usuário:</td>
					<td class="cabec2">'.$user.'</td><td align="right">
						</td></tr>
				</table>
				</td></tr>
  				</table>
				</div>';
  	}

	//recebe uma coleção e monta um Combo simples
	public function montaCombo($nome,$colecao,$value,$texto,$selected,$onchange,$todos=null){
		echo '<select name="'.$nome.'" onchange="'.$onchange.'">';
		$obj = $colecao->iniciaBusca1();
		if($todos != null){

			echo '<option value ="'.$todos.'"';
			if (isset($selected)&&($selected == $todos)){
				echo 'selected';
			}
				echo '>'.$todos.'</option>';
		}
		while ($obj != null){
			echo '<option value ="'.call_user_func(array($obj,$value)).'"';
			if (isset($selected)&&($selected == call_user_func(array($obj,$value)))){
				echo 'SELECTED';
			}
			echo '>'.call_user_func(array($obj,$texto)).'</option>';
			$obj = $colecao->getProximo1();
		}
		echo '</select>';
	}
	// Monta os combos para controles de páginas
	public function montaComboPag($total,$item,$selected,$location){
		//echo $total;
		if ($item < 20){ // Limite inferior
			$anterior = 0;
		} else {
			$anterior = $item - 20;
		}
		if (($item + 20) >= $total){ // Limite superior
			$proximo = $item;
		} else {
			$proximo = $item + 20;
		}
		$pagAtual = floor(($item/20) + 1);
		$totalPaginas = floor($total/20) + 1;
		echo '<script type="text/javascript">';
		if($location !== null){
			echo 'function go(go){
					window.location.href="'.$location.'&item="+go;
			}';
		}
		echo '</script>';
		echo '<a href="javascript:go('.$anterior.')"><img src="./imagens/a_back.gif" border="0" align="middle" title="P&aacute;gina anterior." alt=""></a>&nbsp;';
		echo 'P&aacute;gina: ';
		echo '<select name="nPagina" onchange="go(this.value)">';
		for ($i = 0;$i <= $totalPaginas - 1; $i++){
			echo '<option value ="'.($i*20).'" ';
			if (($pagAtual - 1) == $i){
				echo 'SELECTED';
			}
			echo '>'.($i + 1).' de '.$totalPaginas.'</option>';
		}
		echo '</select>';
		echo '&nbsp;<a href="javascript:go('.($proximo).')">';
		echo '<img src="./imagens/a_go.gif"  alt="" border="0" align="middle" title="Pr&oacute;xima p&aacute;gina." ></a>';
		//echo '</TD></TR></TABLE>';
	}

	//recebe uma coleção e monta um Combo para ano simples
	public function montaComboAnoBI($nome,$colecao,$selected,$onchange){
		echo '<select name="'.$nome.'" onchange="'.$onchange.'">';
		$obj = $colecao->iniciaBusca1();
		$achouAnoAtual = false;
		if($obj == null){
			echo '<option value="'.$selected.'">'.$selected.'</option>';
		}
		while ($obj != null){
			echo '<option value ="'.$obj->getDataPub()->getIAno().'"';
			if (isset($selected)&&($selected == $obj->getDataPub()->getIAno())){
				$achouAnoAtual = true;
				echo 'SELECTED';
			}
			echo '>'.$obj->getDataPub()->getIAno().'</option>';
			$obj = $colecao->getProximo1();
		}
		if(!$achouAnoAtual){
			echo '"'.$selected.'>'.$selected.'</option>';
		}
		echo '</select>';
	}
	function montaComboMes($nome,$selected,$onchange){
		echo '<td><select name="'.$nome.'" onchange="'.$onchange.'">';
		for($i = 1;$i <= count($this->aMes);$i++){
			echo '<option value ="'.$i.'" '.($i==$selected?"Selected":"").'>'.$this->aMes[$i].'</option>';
		}
		echo '</select>';
	}
	private function texto2entidade($var) {
		$var = str_replace("'", "aspassimples", $var);
		$var = preg_replace("/([^ a-zA-Z0-9])/e", "\"&#\".ord(\"\\0\").\";\"", $var);
		$var = str_replace("aspassimples", "'", $var);
		return $var;
	}
	//recebe uma coleção e monta um Combo simples
	public function montaLista($nome,$colecao,$value,$texto,$selected,$onchange,$size){
		$obj = $colecao->iniciaBusca1();
		$totItens = $colecao->getQTD();
		if($totItens < $size){
			$size = $totItens;
		}
		if ($obj == null){
			echo '<script type="text/javascript">window.alert("Não há ítens cadastrados");</script>';
			return;
		}
		echo '<select name="'.$nome.'" onclick="'.$onchange.'" size="'.$size.'">';
		while ($obj != null){
			echo '<option value ="'.call_user_func(array($obj,$value)).'"';
			if (isset($selected)&&($selected == call_user_func(array($obj,$value)))){
				echo 'SELECTED';
			}
			echo '>'.call_user_func(array($obj,$texto)).'</option>';
			$obj = $colecao->getProximo1();
		}
		echo '</select>';
	}

	public function montaFlyForm($Largura,$Altura,$corFundo,$borda=0){
		if(!isset($Largura)){
			$Largura = 400;
		}
		if(!isset($Altura)){
			$Altura = 360;
		}

		echo '<div id="flyframe" style="position:absolute;z-index:10;visibility:hidden;>';
    	echo '<iframe src= "marginwidth:0; marginheight:0; frameborder:0; vspace:0; hspace:0; width:500; height:400;" >' .
    			'<form method="post" name="subscribe" onsubmit="myHint.hide(); return true;" id="subscrForm" style="position:absolute;z-index:1;visibility:hidden;width:'.$Largura.'px; height:'.$Altura.'px; padding:0px; background-color:#D5EADC;border:'.$borda.'px solid green; " action="#"><div id="buscador"><p></p></div><div id="textoForm" align="center"></div></form>';
		echo '</iframe></div>';
	}

	/**
	*Retorna um ícone para os campos S ou N.
	*@access public
	*@return string
	*/
	public function retornaCheck($s_n){
		return ($s_n == 'S'?'<img src="imagens/check.gif" alt="">':'-');
	}

	/**
	*Retorna um ícone para o status da matéria.
        * Opcoes -> N - Em elaboracao
        *           C - Concluida
        *           E - Correcao
        *           A - Aprovada
        *           S - Publicada
        *           X - Não Publicada
	*@access public
	*@return string
	*/
	public function retornaStatus($op){
            switch ($op) {
                case 'N':
                    return '<img src="imagens/elab.png" alt="">';
                    break;
                case 'E':
                    return '<img src="imagens/correcao.png" alt="">';
                    break;
                case 'C':
                    return '<img src="imagens/concluida.png" alt="">';
                    break;
                case 'K':
                    return '<img src="imagens/corrigida.png" alt="">';
                    break;
                case 'A':
                    return '<img src="imagens/check.gif" alt="">';
                    break;
                case 'S':
                    return '<img src="imagens/concluir.png" alt="">';
                    break;
                case 'X':
                    return '<img src="imagens/naprovada.png" alt="">';
                    break;
            }
	}
	public function montaSemestre($ano,$semestre){
		$this->dtIniSem = $semestre==1?'01/01/'.$ano:'01/07/'.$ano;
		$this->dtFimSem = $semestre==1?'30/06/'.$ano:'31/12/'.$ano;
	}
	public function registraSemestre($ano = 1){
		$hoje = date("d/m/Y");
		$hoje = explode("/",$hoje);
		$anoAnterior = $hoje[2] - $ano;
		$Sem = 0;

	if ($hoje[1] == "01") {
		$this->dtIniSem = "01/07/".$anoAnterior;
		$this->dtFimSem = "31/12/".$anoAnterior;
		$this->Sem = 1;
	} else {
		if (($hoje[1] > "01") && ($hoje[1] < "08")) {
			$this->dtIniSem = "01/01/".$hoje[2];
			$this->dtFimSem = "30/06/".$hoje[2];
			$this->Sem = 0;
		} else {
			$this->dtIniSem = "01/07/".$hoje[2];
			$this->dtFimSem = "31/12/".$hoje[2];
			$this->Sem = 1;
		}
	}
	}
  	public function formataNumBi($numBi){
		while (strlen($numBi) < 3){
			$numBi = 0 . $numBi;
		}
		return $numBi;
    }
	//retorna o nome completo com o nome de guerra setado
	function setaNomeGuerra($nome,$nomeguerra){
		$Retorno = '';
		$nome=strtoupper($nome);
	  	$nome = strtr($nome,'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ');
		$nomeguerra=strtoupper($nomeguerra);
	  	$nomeGuerra = strtr($nomeGuerra,'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ');
		$c1 = explode(" ",$nome);
		$c2 = explode(" ",$nomeguerra);
		$pri = 0;

		for ($i = 0; $i < count($c1); $i++) {		//percorre todas as palavras do nome
			for ($j = 0; $j < count($c2); $j++){			//percorre todas as palavras do nome de guerra
				//verifica se a palavra do nome é igual a palavra do nome de guerra
				//ou se a letra inicial do nome é igual a palavra do nome de guerra
				if ( ($c1[$i] == $c2[$j]) or ( substr($c1[$i],0,1) == $c2[$j] and $pri==0) ) {
					if (strlen($c2[$j]) == 1){
						//coloca apenas a letra inicial da palavra em negrito
						$Retorno = $Retorno.'<B>'.substr($c1[$i],0,1).'</B>'.substr($c1[$i],1,strlen($c1[$i]));
						$pri=1;
						break;//sai do for (palavras do nome de guerra)
					}else {
						//coloca a palavra em negrito
						$Retorno = $Retorno.'<B>'.$c1[$i].'</B>'.' ';
						break;//sai do for (palavras do nome de guerra)
					}
				} else {
					//verifica se é a última palavra do for (palavras do nome de guerra)
					if ($c2[$j+1]==''){
						$Retorno = $Retorno.$c1[$i];//coloca a palavra com o padrão normal
					}
				}
				$Retorno = $Retorno.' ';
			}
		}
		return $Retorno;
	}

	public function dif_datas($data1, $data2){
		// se data2 for omitida, o calculo sera feito ate a data atual
		$data2 = $data2=='' ? date("d/m/Y",mktime()) : $data2;

		// separa as datas em dia,mes e ano
		list($dia1,$mes1,$ano1) = explode("/",$data1);
		list($dia2,$mes2,$ano2) = explode("/",$data2);

		// Se for semestre fechado, não há o que calcular
		if(($dia1.$mes1 == "0101") and ($dia2.$mes2 == "3006")){
			return "0|6|0";
		}
		if(($dia1.$mes1 == "0107") and ($dia2.$mes2 == "3112")){
			return "0|6|0";
		}
		// so lembrando que o padrao eh MM/DD/AAAA
		$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
		$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2);



		// calcula a diferenca em timestamp
		$diferenca = ($timestamp1 > $timestamp2) ? ($timestamp1 - $timestamp2) : ($timestamp2 - $timestamp1);

		// retorna o calculo em anos, meses e dias

		return (date("Y",$diferenca)-1970)."|".(date("m",$diferenca)-1)."|".(date("d",$diferenca)-1);
		//return $diferenca;
	}

	function SomarTempoSv($data, $dias, $meses){
	   //passe a data no formato dias/meses/anos
	   $data = explode("/", $data);
	   // Somar dias
	   $dias = $data[0] + $dias;
	   if($dias >= 30){
		 $meses++;
		 $dias = $dias - 30;
	   }
	   $meses = $data[1] + $meses;
		if($meses >= 12){
			$meses = $meses - 12;
			$anos++;
		}
		$anos = $data[2] + $anos;

	   //$newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano) );
	   return array($dias,$meses,$anos);
	}

 	public function getVersao(){
 		return $this->versao;
 	}
 	public function getDataVersao(){
 		return $this->dataVersao;
 	}
	public function getUser(){
		return (isset($_SESSION['NOMEUSUARIO']))?($_SESSION['NOMEUSUARIO']):'Visitante';
	}
	public function getCodom(){
		return (isset($_SESSION['OM_VINC']))?($_SESSION['OM_VINC']):'999999';
	}
	public function getCodSubun(){
		return (isset($_SESSION['SUBUN']))?($_SESSION['SUBUN']):'99';
	}
	public function getTodasOmVinc(){
		return (isset($_SESSION['TODAS_OMVINC']))?($_SESSION['TODAS_OMVINC']):'N';
	}
	public function getTodasOmVinc2(){
		return (isset($_SESSION['TODAS_OMVINC2']))?($_SESSION['TODAS_OMVINC2']):'N';
	}
	public function getTodasSubun(){
		return (isset($_SESSION['TODAS_SUBUN']))?($_SESSION['TODAS_SUBUN']):'N';
	}
	public function getTodasSubun2(){
		return (isset($_SESSION['TODAS_SUBUN2']))?($_SESSION['TODAS_SUBUN2']):'N';
	}

	public function montaComboAssina($colMilitar,$idtMilitar,$colPgrad){
		$Militar = $colMilitar->iniciaBusca1();
		if ($idtMilitar!=null){
			$Assina = true;
		}
		echo '<select name="seleMilitarAssina">';
		while ($Militar != null){
			$pGrad = $colPgrad->iniciaBusca1();
			while ($Militar->getPGrad()->getCodigo() != $pGrad->getCodigo() ){
				$pGrad = $colPgrad->getProximo1();
			}
			if ($Militar->getIdMilitar() === $idtMilitar){
				echo '<option value="'.$Militar->getIdMilitar().'" SELECTED'.$pGrad->getDescricao().' '.$Militar->getNome().' - '.$Militar->getFuncao()->getDescricao().'</option>';
			}else{
				echo '<option value="'.$Militar->getIdMilitar().'">'.$pGrad->getDescricao().' '.$Militar->getNome().' - '.$Militar->getFuncao()->getDescricao().'</option>';
			}
			$Militar = $colMilitar->getProximo1();
		}
		echo '</select>';
	}
 }
