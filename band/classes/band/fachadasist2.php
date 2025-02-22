<?php
class FachadaSist2 {
	private $db;
	private $rgrParteBoletim;
	private $rgrSecaoParteBi;
	private $rgrAssuntoGeral;
	private $rgrAssuntoEspec;
	private $rgrTipoDoc;
	private $rgrPGrad;
	private $rgrBoletim;
	private $rgrQM;
	private $rgrTipoBol;
	private $rgrFuncao;
	private $rgrMateriaBi;
	//Bedin
	private $rgrOM;
	//
	private $rgrOMVinc;
	private $rgrSubun;
	private $rgrPessoa;
	private $rgrMilitar;
	private $rgrPessoaMateriaBi;
	private $rgrTempoSerPer;
	private $rgrUsuario;
	private $rgrFuncaoDoSistema;
	private $rgrUsuarioFuncao;
	private $rgrUsuarioFuncaoTipoBol;
	private $rgrIndice;
	private $rgrIndicePessoa;
	private $rgrConfiguracoes;

	private $meuLinkDB;
	private $bandIniFile;

	private function GerarConexao() { //carrega arquivo de configuracao dois niveis acima para nao ser acessivel
		$mysql_user = $this->bandIniFile->getUsuario('user');
		$mysql_host = $this->bandIniFile->getHost('host');
		$mysql_password = $this->bandIniFile->getPassword('password');
		$my_database = $this->bandIniFile->getDatabase('database');
		//echo $this->bandIniFile->getVersao();

		$this->meuLinkDB = new MeuLinkDB($mysql_host, $mysql_user, $mysql_password, $my_database);
		return $this->meuLinkDB->GerarConexao();
	}

	public function FachadaSist2() {
		// Alterado pelo Ten S.Lopes 17/04/2012 - $iniFile = new IniFile('..\sisbol.ini'); caminho errado. para-->
		$iniFile = new IniFile('../../sisbol.ini');
		$this->bandIniFile = new BandIniFile($iniFile);
		$this->db = $this->GerarConexao();
		$colUsuarioFuncao = new ColUsuarioFuncao($this->db);
		$this->rgrUsuarioFuncao = new RgrUsuarioFuncao($colUsuarioFuncao);
		$colConfiguracoes = new ColConfiguracoes($this->db);
		$this->rgrConfiguracoes = new RgrConfiguracoes($colConfiguracoes);
	}

	private function startPGrad() {
		$colPGrad = new ColPGrad($this->db);
		$this->rgrPGrad = new RgrPGrad($colPGrad);
	}

	private function startQM() {
		$colQM = new ColQM($this->db);
		$this->rgrQM = new RgrQM($colQM);
	}

	private function startBoletim() {
		$colTipoBol = new ColTipoBol($this->db);
		$this->rgrTipoBol = new RgrTipoBol($colTipoBol);
		$colBoletim = new ColBoletim($this->db);
		$this->rgrBoletim = new RgrBoletim($colBoletim);
		$colAssinaConfereBi = new ColAssinaConfereBi($this->db);
		$this->rgrAssinaConfereBi = new RgrAssinaConfereBi($colAssinaConfereBi);
	}

	private function startFuncao() {
		$colFuncao = new ColFuncao($this->db);
		$this->rgrFuncao = new RgrFuncao($colFuncao);
	}

	private function startMilitar() {
		$colMilitar = new ColMilitar($this->db);
		$this->rgrMilitar = new RgrMilitar($colMilitar);
		$colPessoa = new ColPessoa($this->db);
		$this->rgrPessoa = new RgrPessoa($colPessoa);
	}

	private function startTipoDoc() {
		$colTipoDoc = new ColTipoDoc($this->db);
		$this->rgrTipoDoc = new RgrTipoDoc($colTipoDoc);
	}

	private function startParteSecaoBI() {
		$colParteBoletim = new ColParteBoletim($this->db);
		$this->rgrParteBoletim = new RgrParteBoletim($colParteBoletim);
		$colSecaoParteBi = new ColSecaoParteBi($this->db);
		$this->rgrSecaoParteBi = new RgrSecaoParteBi($colSecaoParteBi);
	}

	private function startAssunto() {
		$colAssuntoGeral = new ColAssuntoGeral($this->db);
		$this->rgrAssuntoGeral = new RgrAssuntoGeral($colAssuntoGeral);
		$colAssuntoEspec = new ColAssuntoEspec($this->db);
		$this->rgrAssuntoEspec = new RgrAssuntoEspec($colAssuntoEspec);
	}

	private function startMateriaBI() {
		$colMateriaBi = new ColMateriaBi($this->db);
		$this->rgrMateriaBi = new RgrMateriaBi($colMateriaBi);
		$colPessoaMateriaBi = new ColPessoaMateriaBi($this->db);
		$this->rgrPessoaMateriaBi = new RgrPessoaMateriaBi($colPessoaMateriaBi);
	}

	private function startTempoSerPer() {
		$colTempoSerPer = new ColTempoSerPer($this->db);
		$this->rgrTempoSerPer = new RgrTempoSerPer($colTempoSerPer);
	}

	private function startUsuario() {
		$colUsuario = new ColUsuario($this->db);
		$this->rgrUsuario = new RgrUsuario($colUsuario);
	}

	private function startFuncoesDoSistema() {
		$colFuncaoDoSistema = new ColFuncaoDoSistema($this->db);
		$this->rgrFuncaoDoSistema = new RgrFuncaoDoSistema($colFuncaoDoSistema);
	}

	private function startUsuarioFuncaoTipoBol() {
		$colUsuarioFuncaoTipoBol = new ColUsuarioFuncaoTipoBol($this->db);
		$this->rgrUsuarioFuncaoTipoBol = new RgrUsuarioFuncaoTipoBol($colUsuarioFuncaoTipoBol);
	}

	private function startIndice() {
		$colIndice = new ColIndice($this->db);
		$this->rgrIndice = new RgrIndice($colIndice);
	}

	private function startIndicePessoa() {
		$colIndicePessoa = new ColIndicePessoa($this->db);
		$this->rgrIndicePessoa = new RgrIndicePessoa($colIndicePessoa);
	}

	public function getBackupFileName() {
		return $this->bandIniFile->getBackupFileName();
	}
	public function getBackupCommand() {
		$banco = $this->bandIniFile->getDatabase();
		return $this->bandIniFile->getBackupCommand() . " " . $banco;
	}
	public function getRestoreCommand() {
		return $this->bandIniFile->getRestoreCommand();
	}
	public function getDeleteCommand() {
		return $this->bandIniFile->getDeleteCommand();
	}
	public function getFPDFFontDir() {
		return $this->bandIniFile->getFPDFFontDir();
	}
	public function getOutPutAltDir() {
		return $this->bandIniFile->getOutPutAltDir();
	}
	public function getOutPutBolDir() {
		return $this->bandIniFile->getOutPutBolDir();
	}
	public function getBrasaoDir() {
		return $this->bandIniFile->getBrasaoDir();
	}
	public function getBackupDir() {
		return $this->bandIniFile->getBackupDir();
	}
	//
	//---------- parte boletim ----------
	//
	public function incluirParteBoletim($parteBoletim) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startParteSecaoBI();
			$this->rgrParteBoletim->incluirRegistro($parteBoletim);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());

		}
	}
	public function alterarParteBoletim($parteBoletim) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startParteSecaoBI();
			$this->rgrParteBoletim->alterarRegistro($parteBoletim);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function excluirParteBoletim($parteBoletim) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startParteSecaoBI();
			$this->rgrSecaoParteBi->excluirColecao($parteBoletim);
			$this->rgrParteBoletim->excluirRegistro($parteBoletim);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function lerColecaoParteBoletim($ordem) {
		$this->startParteSecaoBI();
		return $this->rgrParteBoletim->lerColecao($ordem);
	}
	public function LerParteQuePertenceAssuntoEspec($codAssuntoGeral, $codAssuntoEspec) {
		$this->startParteSecaoBI();
		$parteBoletim = $this->rgrParteBoletim->LerParteQuePertenceAssuntoEspec($codAssuntoGeral, $codAssuntoEspec);
		$this->startParteSecaoBI();
		return $parteBoletim;
	}
	public function lerParteBoletim($numeroParte) {
		$this->startParteSecaoBI();
		return $this->rgrParteBoletim->lerRegistro($numeroParte);
	}
	//
	//-----------------Se��o Parte de Boletim-------------------------------
	//
	public function lerColecaoSecaoParteBi($numeroParteBi) {
		$this->startParteSecaoBI();
		return $this->rgrSecaoParteBi->lerColecao($numeroParteBi);
	}
	//---------------------------BEDIN--------------
	public function lerSecaoParteBi2($numeroParte, $numeroSecao) {
		$this->startParteSecaoBI();
		return $this->rgrSecaoParteBi->lerRegistro($numeroParte, $numeroSecao);
	}
	/**
	* @Nome Fun��o: incluirSecaoParteBi
	* @Par�metros de entrada: $parteBoletim-parte do boletim (objeto)
	*                         $secaoParteBi-se��o do boletim (objeto)
	* @Retorno: N�o retorna nada
	* @Objetivo: Esta fun��o inclui uma se��o do boletim na parte do boletim
	*            que foi passada como par�metro
	*/
	public function incluirSecaoParteBi($parteBoletim, $secaoParteBi) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startParteSecaoBI();
			$this->rgrSecaoParteBi->incluirRegistro($parteBoletim, $secaoParteBi);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function alterarSecaoParteBi($parteBoletim, $secaoParteBi) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startParteSecaoBI();
			$this->rgrSecaoParteBi->alterarRegistro($parteBoletim, $secaoParteBi);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function excluirSecaoParteBi($parteBoletim, $secaoParteBi) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startParteSecaoBI();
			$this->rgrSecaoParteBi->excluirRegistro($parteBoletim, $secaoParteBi);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function lerSecaoParteBi($codSecaoParteBi) {
		$this->startParteSecaoBI();
		return $this->rgrSecaoParteBi->lerRegistro($codSecaoParteBi);
	}

	//
	//---------- assunto geral ----------
	//
	public function incluirAssuntoGeral($assuntoGeral) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startAssunto();
			$this->rgrAssuntoGeral->incluirRegistro($assuntoGeral);
			//	    $this->rgrAssuntoEspec->incluirColecao($assuntoGeral);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function alterarAssuntoGeral($assuntoGeral) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startAssunto();
			$this->rgrAssuntoGeral->alterarRegistro($assuntoGeral);
			//	    $this->rgrAssuntoEspec->alterarColecao($assuntoGeral);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function excluirAssuntoGeral($assuntoGeral) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startAssunto();
			$this->rgrAssuntoEspec->excluirColecao($assuntoGeral);
			$this->rgrAssuntoGeral->excluirRegistro($assuntoGeral);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function lerColecaoAssuntoGeral($numeroParteBi, $numeroSecaoParteBi, $codTipoBol) {
		$this->startAssunto();
		return $this->rgrAssuntoGeral->lerColecao($numeroParteBi, $numeroSecaoParteBi, $codTipoBol);
	}
	public function lerAssuntoGeralComp($codigo) {
		$this->startAssunto();
		$lAssuntoGeral = $this->rgrAssuntoGeral->lerRegistro($codigo);
		$colAssuntoEspec2 = $this->rgrAssuntoEspec->lerColecao($codigo);
		$lAssuntoGeral->setColAssuntoEspec2($colAssuntoEspec2);
		return $lAssuntoGeral;
	}
	public function lerAssuntoGeral($codigo) {
		$this->startAssunto();
		$lAssuntoGeral = $this->rgrAssuntoGeral->lerRegistro($codigo);
		return $lAssuntoGeral;
	}
	public function lerUltimoAssuntoGeral() {
		$this->startAssunto();
		$lAssuntoGeral = $this->rgrAssuntoGeral->lerUltimoRegistro();
		return $lAssuntoGeral;
	}

	public function lerColecaoAssuntoGeralLike($numeroParteBi, $numeroSecaoParteBi, $codTipoBol, $like) {
		$this->startAssunto();
		return $this->rgrAssuntoGeral->lerColecaoLike($numeroParteBi, $numeroSecaoParteBi, $codTipoBol, $like);
	}
	public function setaOrdemAssuntoGeral($codAssuntoGer, $ordemAssuntoGer) {
		$this->startAssunto();
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startAssunto();
			$this->rgrAssuntoGeral->setaOrdem($codAssuntoGer, $ordemAssuntoGer);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}

	}

	//
	//---------- assunto espec�fico ----------
	//
	public function incluirAssuntoEspec($assuntoGeral, $assuntoEspec) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startAssunto();
			$this->rgrAssuntoEspec->incluirRegistro($assuntoGeral, $assuntoEspec);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function alterarAssuntoEspec($assuntoGeral, $assuntoEspec) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startAssunto();
			$this->rgrAssuntoEspec->alterarRegistro($assuntoGeral, $assuntoEspec);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function excluirAssuntoEspec($assuntoGeral, $assuntoEspec) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startAssunto();
			$this->rgrAssuntoEspec->excluirRegistro($assuntoGeral, $assuntoEspec);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function lerColecaoAssuntoEspec($codAssuntoGeral) {
		$this->startAssunto();
		return $this->rgrAssuntoEspec->lerColecao($codAssuntoGeral);
	}
	public function buscaLetras($codAssuntoGeral) {
		$this->startAssunto();
		return $this->rgrAssuntoEspec->buscaLetras($codAssuntoGeral);
	}
	public function lerAssuntoEspec($codAssuntoGeral, $codAssuntoEspec) {
		$this->startAssunto();
		$lAssuntoEspec = $this->rgrAssuntoEspec->lerRegistro($codAssuntoGeral, $codAssuntoEspec);
		return $lAssuntoEspec;
	}
	public function lerUltimoAssuntoEspecifico() {
		$this->startAssunto();
		$AssuntoEspecifico = $this->rgrAssuntoEspec->lerUltimoRegistro();
		return $AssuntoEspecifico;
	}
	function lerColecaoAssuntoEspecLike($assuntoGeral, $like) {
		$this->startAssunto();
		return $this->rgrAssuntoEspec->lerColecaoLike($assuntoGeral, $like);

	}
	//
	//---------- tipodoc
	//
	public function incluirTipoDoc($tipoDoc) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startTipoDoc();
			$this->rgrTipoDoc->incluirRegistro($tipoDoc);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function alterarTipoDoc($tipoDoc) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startTipoDoc();
			$this->rgrTipoDoc->alterarRegistro($tipoDoc);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function excluirTipoDoc($tipoDoc) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startTipoDoc();
			$this->rgrTipoDoc->excluirRegistro($tipoDoc);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function lerColecaoTipoDoc($ordem) {
		$this->startTipoDoc();
		return $this->rgrTipoDoc->lerColecao($ordem);
	}
	//
	//---------- Posto Gradua��o ----------
	public function incluirPGrad($pGrad) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startPGrad();
			$this->rgrPGrad->incluirRegistro($pGrad);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}

	public function alterarPGrad($pGrad) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startPGrad();
			$this->rgrPGrad->alterarRegistro($pGrad);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}

	public function excluirPGrad($pGrad) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startPGrad();
			$this->rgrPGrad->excluirRegistro($pGrad);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function lerColecaoPGrad($ordem) {
		$this->startPGrad();
		return $this->rgrPGrad->lerColecao($ordem);
	}
	public function lerPGrad($codPgrad) {
		$this->startPGrad();
		return $this->rgrPGrad->lerRegistro($codPgrad);
	}
	//
	//*****Qualifica��o Militar*************************
	//

	public function incluirQM($QM) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startQM();
			$this->rgrQM->incluirRegistro($QM);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function alterarQM($QM) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startQM();
			$this->rgrQM->alterarRegistro($QM);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function excluirQM($QM) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startQM();
			$this->rgrQM->excluirRegistro($QM);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function lerQM($codQM) {
		$this->startQM();
		return $this->rgrQM->lerRegistro($codQM);
	}
	public function lerColecaoQM($ordem) {
		$this->startQM();
		return $this->rgrQM->lerColecao($ordem);
	}
	//
	//*****boletim*************************
	//
	public function incluirBoletim($boletim) {
		$this->startBoletim();
		$this->startFuncao();
		$this->startMilitar();

		$conIncOuAltBoletim = new ConIncOuAltBoletim($this->rgrTipoBol, $this->rgrBoletim, $this->rgrFuncao, $this->rgrMilitar, $this->rgrAssinaConfereBi);
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startBoletim();
			$conIncOuAltBoletim->incluirBoletim($boletim);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function alterarBoletim($boletim) {
		$this->startBoletim();
		$this->startFuncao();
		$this->startMilitar();
		$conIncOuAltBoletim = new ConIncOuAltBoletim($this->rgrTipoBol, $this->rgrBoletim, $this->rgrFuncao, $this->rgrMilitar, $this->rgrAssinaConfereBi);
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startBoletim();
			$conIncOuAltBoletim->alterarBoletim($boletim);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function excluirBoletim($boletim) {
		$this->startBoletim();
		$conExcluirBoletim = new ConExcluirBoletim($this->rgrTipoBol, $this->rgrBoletim);
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startBoletim();
			$conExcluirBoletim->excluirBoletim($boletim);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}

	//l� o ultimo bi do tipo recebido no parametro
	public function lerUltBi($codTipoBol) {
		$this->startBoletim();
		return $this->rgrBoletim->lerUltBi($codTipoBol);
	}

	public function lerPorNumeroBi($codTipoBol, $numeroBi) {
		$this->startBoletim();
		return $this->rgrBoletim->lerPorNumeroBi($codTipoBol, $numeroBi);
	}
	public function lerPorBiTipo($codTipoBol,$codBiAtual) {
		$this->startBoletim();
		return $this->rgrBoletim->lerPorBiTipo($codTipoBol,$codBiAtual);
	}
	public function lerColecaoBi($aprovado, $assinado, $codTipoBol, $ordem, $ano = null) {
		$this->startBoletim();
		return $this->rgrBoletim->lerColecao($aprovado, $assinado, $codTipoBol, $ordem, $ano);
	}
	public function lerColecaoBiSemPrimeiro($aprovado, $assinado, $codTipoBol, $ordem, $ano = null) {
		$this->startBoletim();
		return $this->rgrBoletim->lerColecaoSemPrimeiro($aprovado, $assinado, $codTipoBol, $ordem, $ano);
	}

	public function lerBoletimPorCodigo($cod) {
		$this->startBoletim();
		return $this->rgrBoletim->lerPorCodigo($cod);
	}
	public function lerBoletimQuePublicou($codMateriaBi) {
		$this->startBoletim();
		return $this->rgrMateriaBi->lerBoletimQuePublicou($codMateriaBi);
	}
	public function getQTDBoletim($codTipoBol) {
		$this->startBoletim();
		return $this->rgrBoletim->getQTD($codTipoBol);
	}
	public function getAnosBI() {
		$this->startBoletim();
		return $this->rgrBoletim->getAnosBI();
	}
	public function aprovarBoletim($boletim) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startBoletim();
			$this->rgrBoletim->aprovarBoletim($boletim);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function cancelarAprovarBoletim($boletim) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startBoletim();
			$this->rgrBoletim->cancelarAprovarBoletim($boletim);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function assinarBoletim($boletim) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startBoletim();
			$this->rgrBoletim->assinarBoletim($boletim);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function cancelarAssinarBoletim($boletim) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startBoletim();
			$this->rgrBoletim->cancelarAssinarBoletim($boletim);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function gerarBoletim($boletim, $original) {
		//boletim gerado em HTML
		/*
		$conGerarBoletim = new ConGerarBoletimHTML($this->rgrOM, $this->rgrParteBoletim, $this->rgrSecaoParteBi, $this->rgrAssuntoGeral,
		$this->rgrAssuntoEspec, $this->rgrBoletim, $this->rgrAssinaConfereBi, $this->rgrMilitar, $this->rgrFuncao, $this->rgrPGrad,
		$this->rgrTipoBol, $this->rgrMateriaBi, $this->rgrPessoaMateriaBi, $this->rgrPessoa, $this->bandIniFile);
		*/
		//boletim gerado em PDF sem interpretar tabelas
		/*
		$conGerarBoletim = new ConGerarBoletimPDF($this->rgrOM, $this->rgrParteBoletim, $this->rgrSecaoParteBi, $this->rgrAssuntoGeral,
		$this->rgrAssuntoEspec, $this->rgrBoletim, $this->rgrAssinaConfereBi, $this->rgrMilitar, $this->rgrFuncao, $this->rgrPGrad,
		$this->rgrTipoBol, $this->rgrMateriaBi, $this->rgrPessoaMateriaBi, $this->rgrPessoa, $this->bandIniFile);*/
		//boletim gerado em PDF com tabelas

		$this->startBoletim();
		$this->startOM();
		$this->startAssunto();
		$this->startPGrad();
		//Bedin
		$this->startQM();
		//
		$this->startMilitar();
		$this->startFuncao();
		$this->startParteSecaoBI();
		$this->startMateriaBI();
		$this->startTipoDoc();
		/*
		$conGerarBoletim = new ConGerarBoletim($this->rgrOM, $this->rgrParteBoletim, $this->rgrSecaoParteBi, $this->rgrAssuntoGeral,
		$this->rgrAssuntoEspec, $this->rgrBoletim, $this->rgrAssinaConfereBi, $this->rgrMilitar, $this->rgrFuncao, $this->rgrPGrad,
		$this->rgrTipoBol, $this->rgrMateriaBi, $this->rgrPessoaMateriaBi, $this->rgrPessoa, $this->bandIniFile);
		*/

		$conGerarBoletim = new ConGerarBoletimPDFHTML($this->rgrOM, $this->rgrOMVinc, $this->rgrSubun, $this->rgrParteBoletim, $this->rgrSecaoParteBi, $this->rgrAssuntoGeral, $this->rgrAssuntoEspec, $this->rgrBoletim, $this->rgrAssinaConfereBi, $this->rgrMilitar, $this->rgrFuncao, $this->rgrPGrad, $this->rgrQM, $this->rgrTipoBol, $this->rgrMateriaBi, $this->rgrPessoaMateriaBi, $this->rgrPessoa, $this->bandIniFile);

		try {
			$this->meuLinkDB->iniciarTransacao();
			$arq = $conGerarBoletim->gerarBoletim($boletim, $original);
			$this->meuLinkDB->terminarTransacao();
			return $arq;
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			return null;
		}
	}

	//rev07
	public function gerarMateriaBi($materiaBi) {
		$this->startBoletim();
		$this->startOM();
		$this->startAssunto();
		$this->startPGrad();
		//Bedin
		$this->startQM();
		//
		$this->startMilitar();
		$this->startFuncao();
		$this->startParteSecaoBI();
		$this->startMateriaBI();
		$this->startTipoDoc();
		$conGerarMateriaBi = new ConGerarMateriaBi($this->rgrOM, $this->rgrOMVinc, $this->rgrSubun, $this->rgrParteBoletim, $this->rgrSecaoParteBi, $this->rgrAssuntoGeral, $this->rgrAssuntoEspec, $this->rgrBoletim, $this->rgrAssinaConfereBi, $this->rgrMilitar, $this->rgrFuncao, $this->rgrPGrad, $this->rgrQM, $this->rgrTipoBol, $this->rgrTipoDoc, $this->rgrMateriaBi, $this->rgrPessoaMateriaBi, $this->rgrPessoa, $this->bandIniFile);
		try {
			$this->meuLinkDB->iniciarTransacao();
			$arq = $conGerarMateriaBi->gerarMateriaBi($materiaBi);
			$this->meuLinkDB->terminarTransacao();
			return ($arq);
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
			return null;
		}
	}

	public function gerarAlteracoes($colMilitar2, $dtInicio, $dtTermino) {
		$this->startOM();
		$this->startAssunto();
		$this->startPGrad();
		$this->startMilitar();
		$this->startFuncao();
		$this->startParteSecaoBI();
		$this->startMateriaBI();
		$this->startTempoSerPer();
		$this->startTipoDoc();
		$conGerarAlteracoes = new ConGerarAlteracoes($this->rgrOM, $this->rgrPessoaMateriaBi, $this->rgrTempoSerPer, $this->rgrMilitar, $this->rgrFuncao, $this->rgrPGrad, $this->rgrOMVinc, $this->bandIniFile);
		try {
			$this->meuLinkDB->iniciarTransacao();
			$arq = $conGerarAlteracoes->gerarAlteracoes($colMilitar2, $dtInicio, $dtTermino);
			$this->meuLinkDB->terminarTransacao();
			return ($arq);
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
			return null;
		}
	}

	public function gerarFicha($colMilitar2) {
		$this->startOM();
		$this->startMilitar();
		$this->startFuncao();
		$this->startPGrad();
		$this->startTempoSerPer();
		$conGerarFicha = new ConGerarFicha($this->rgrOM, $this->rgrMilitar, $this->rgrFuncao, $this->rgrPGrad, $this->rgrTempoSerPer, $this->bandIniFile);
		try {
			$this->meuLinkDB->iniciarTransacao();
			$arq = $conGerarFicha->gerarFicha($colMilitar2);
			$this->meuLinkDB->terminarTransacao();
			return $arq;
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
			return 'error';
		}
	}

	//
	// Tipo Boletim *************************************
	//
	public function lerTipoBol($codTipoBol) {
		$this->startBoletim();
		return $this->rgrTipoBol->lerRegistro($codTipoBol);
	}
	public function incluirTipoBol($tipoBol) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startBoletim();
			$this->rgrTipoBol->incluirRegistro($tipoBol);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}

	public function alterarTipoBol($tipoBol) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startBoletim();
			$this->rgrTipoBol->alterarRegistro($tipoBol);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}

	public function excluirTipoBol($tipoBol) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startBoletim();
			$this->rgrTipoBol->excluirRegistro($tipoBol);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	//esta funcao sera bloqueada deliberadamente, porque cada leitura da colecao do tipo de boletim ira depender
	//do usuario e da funcao que o mesmo deseja executar e a leitura devera retornar apenas os boletins em que
	//o usuario tem permissao de realizar aquela leitura

	public function lerColecaoTipoBol($ordem) {
		$this->startBoletim();
		return $this->rgrTipoBol->lerColecao($ordem);
	}
	//
	//*****Fun��o do Militar*************************
	//

	public function incluirFuncao($Funcao) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startFuncao();
			$this->rgrFuncao->incluirRegistro($Funcao);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function alterarFuncao($Funcao) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startFuncao();
			$this->rgrFuncao->alterarRegistro($Funcao);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function excluirFuncao($Funcao) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startFuncao();
			$this->rgrFuncao->excluirRegistro($Funcao);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function lerFuncao($codFuncao) {
		$this->startFuncao();
		return $this->rgrFuncao->lerRegistro($codFuncao);
	}
	public function lerColecaoFuncao($ordem) {
		$this->startFuncao();
		return $this->rgrFuncao->lerColecao($ordem);
	}
	//
	//materia bi
	//
	public function incluirMateriaBi($materiaBi, $boletim, $modelo) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			//      echo 'C�digo da Especifico:'.$materiaBi->getAssuntoEspec()->getCodigo();
			$this->startMateriaBI();
			$this->startAssunto();
			$this->rgrMateriaBi->incluirRegistro($materiaBi, $boletim);
			//$this->rgrPessoaMateriaBi->incluirColecao($materiaBi);
			if ($modelo){
                            $assuntoEspec = $this->rgrAssuntoEspec->lerRegistro($materiaBi->getAssuntoGeral()->getCodigo(), $materiaBi->getAssuntoEspec()->getCodigo());
                            $assuntoEspec->setTextoPadAbert($materiaBi->getTextoAbert());
                            $assuntoEspec->setTextoPadFech($materiaBi->getTextoFech());
                            $this->rgrAssuntoEspec->alterarRegistro($materiaBi->getAssuntoGeral(), $assuntoEspec);
                        }
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function alterarMateriaBi($materiaBi, $boletim, $modelo) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMateriaBI();
			$this->startAssunto();
			$this->rgrMateriaBi->alterarRegistro($materiaBi, $boletim);
			//	    $this->rgrPessoaMateriaBi->alterarColecao($materiaBi);
			if ($modelo){
                            $assuntoEspec = $this->rgrAssuntoEspec->lerRegistro($materiaBi->getAssuntoGeral()->getCodigo(), $materiaBi->getAssuntoEspec()->getCodigo());
                            $assuntoEspec->setTextoPadAbert($materiaBi->getTextoAbert());
                            $assuntoEspec->setTextoPadFech($materiaBi->getTextoFech());
                            $this->rgrAssuntoEspec->alterarRegistro($materiaBi->getAssuntoGeral(), $assuntoEspec);
                        }
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	//	public function excluirMateriaBi($materiaBi, $boletim)
	public function excluirMateriaBi($materiaBi) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMateriaBI();
			$this->rgrPessoaMateriaBi->excluirColecao($materiaBi);
			//	    $this->rgrMateriaBi->excluirRegistro($materiaBi, $boletim);
			$this->rgrMateriaBi->excluirRegistro($materiaBi);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function aprovarMateriaBi($materiaBi) //ainda n�o foi testada
	{
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMateriaBI();
			$this->rgrMateriaBi->aprovarMateriaBi($materiaBi);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function publicarMateriaBi($materiaBi)
	{
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMateriaBI();
			$this->rgrMateriaBi->publicarMateriaBi($materiaBi);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function concluirMateriaBi($materiaBi) //rv7
	{
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMateriaBI();
			$this->rgrMateriaBi->concluirMateriaBi($materiaBi);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function cancelarAprovarMateriaBi($materiaBi) //manda a materia para correcao
	{
		
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMateriaBI();
			$materiaBi = $this->rgrMateriaBi->LerRegistro($materiaBi->getCodigo());
			if ($materiaBi == null){
				throw new Exception('Mat�ria n�o existe');
			}

			if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='S')){
				if (($materiaBi->getAprovada() != 'X') && ($materiaBi->getAprovada() != 'C') && ($materiaBi->getAprovada() != 'A') && ($materiaBi->getAprovada() != 'K')){
					throw new Exception('Mat�ria n�o foi aprovada');
				}
			}
			//verifica se ja esta em boletim
			$boletim = $this->rgrMateriaBi->lerBoletimQuePublicou($materiaBi->getCodigo());
			if ($boletim != null)
				throw new Exception('Mat�ria inclu�da em boletim, deve ser primeiro exclu�da do boletim');
			//ajusta o campo
			if ($materiaBi->getAprovada() != 'A'){
               $materiaBi->setAprovada('E');//materia estava c/ status de Concluida (C) 
			   								//ou N�o Aprovada(X) ou Corrigida (K)
                                            //e volta com status de Correcao (E)
            }else{
				if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='S'))
					$status = "X";									
				if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='N'))
					$status = "E";									
				if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='S'))
					$status = "E";									

                $materiaBi->setAprovada($status);//materia estava c/ status de Aprovada (A) e volta com status
	                                            //Nao Aprovada (X)
	        }

			$this->rgrMateriaBi->alterarRegistro($materiaBi, null);

			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function cancelarPublicarMateriaBi($materiaBi)
	{
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMateriaBI();
			$materiaBi = $this->rgrMateriaBi->LerRegistro($materiaBi->getCodigo());
			if ($materiaBi == null)
				throw new Exception('Mat�ria n�o existe');
			if ($materiaBi->getAprovada() == 'X')
				throw new Exception('Mat�ria j� est� com status de "n�o aprovada"');
			// versao 2.3
			// inserido C - para cancelar materia com 1 nivel de aprovacao
			if (($materiaBi->getAprovada() != 'A')&&($materiaBi->getAprovada() != 'S')&&($materiaBi->getAprovada() != 'C')&&($materiaBi->getAprovada() != 'K'))
				throw new Exception('Mat�ria n�o foi aprovada');
			//verifica se ja esta em boletim
			$boletim = $this->rgrMateriaBi->lerBoletimQuePublicou($materiaBi->getCodigo());
			if ($boletim != null)
				throw new Exception('Mat�ria inclu�da em boletim, deve ser primeiro exclu�da do boletim');
			//ajusta o campo
                        $materiaBi->setAprovada('X');

			$this->rgrMateriaBi->alterarRegistro($materiaBi, null);

			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}

        public function incluirMateriaEmBi($materiaBi, $boletim) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMateriaBI();
			//le o boletim
			$boletim1 = $this->rgrMateriaBi->lerBoletimQuePublicou($materiaBi->getCodigo());
			//se o boletim que publicou existe
			if ($boletim1 != null)
				throw new Exception('Mat�ria j� foi inclu�da em boletim');
			//verifica se boletim ja foi aprovado
			$boletim1 = $this->rgrBoletim->lerPorCodigo($boletim->getCodigo());
			if ($boletim1->getAprovado() == 'S') {
				throw new Exception('Boletim j� foi aprovado');
			}
			$this->rgrMateriaBi->incluirMateriaEmBi($materiaBi, $boletim);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function excluirMateriaDoBi($materiaBi, $boletim) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMateriaBI();
			//ler boletim que publicou a materia
			$boletim1 = $this->rgrMateriaBi->lerBoletimQuePublicou($materiaBi->getCodigo());
			//se o boletim nao existe
			if ($boletim1 == null) { //se a materia nao foi incluida nao pode ser excluida
				throw new Exception('Mat�ria n�o est� inclu�da em boletim');
			}
			//le o boletim para verificar se boletim ja foi aprovado
			$boletim1 = $this->rgrBoletim->lerPorCodigo($boletim->getCodigo());
			if ($boletim1->getAprovado() == 'S') {
				throw new Exception('Boletim j� foi aprovado');
			}
			$this->rgrMateriaBi->excluirMateriaDoBi($materiaBi, $boletim);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function setaOrdemMateria($codMateria, $ordemMateria) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMateriaBI();
			$this->rgrMateriaBi->setaOrdemMateriaBI($codMateria, $ordemMateria);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			//$this->mensagem($e->getMessage());
		}
	}
	// Pega o pr�ximo c�digo de mat�ria para BI
	public function getProximoCodigoMateriaBI() {
		$this->startMateriaBI();
		$proximo = $this->rgrMateriaBi->getProximoCodigo();
		return $proximo;
	}

	//
	public function lerRegistroMateriaBI($codMateriaBi) {
		$this->startMateriaBI();
		return $this->rgrMateriaBi->lerRegistro($codMateriaBi);
	}
	// Fun��o para inserir coment�rio nas NBI - Sgt Bedin
	public function alterarComentario($codMateriaBI, $textoComentario) {
		$this->startMateriaBI();
		return $this->rgrMateriaBi->alterarComentario($codMateriaBI, $textoComentario);
	}
	//
	public function lerColMateriaBITipoBolAprov($codTipoBol, $aprovada, $order, $incluidaEmBI, $codom, $codSubun, $todasOmVinc, $todasSubun) {
		$this->startMateriaBI();
		return $this->rgrMateriaBi->lerColecao2($codTipoBol, $aprovada, $order, $incluidaEmBI, $codom, $codSubun, $todasOmVinc, $todasSubun);
	}
	public function lerColMateriaDoBi($codBoletim, $order) {
		$this->startMateriaBI();
		return $this->rgrMateriaBi->lerColecao3($codBoletim, $order);
	}
	public function lerColMateriaParteSecao($codBi, $numeroParte, $numeroSecao) {
		$this->startMateriaBI();
		return $this->rgrMateriaBi->lerColecao($codBi, $numeroParte, $numeroSecao);
	}
	public function lerColMateriaParteSecaoGeral($codBi, $numeroParte, $numeroSecao,$codAssuntoGer) {
		$this->startMateriaBI();
		return $this->rgrMateriaBi->lerColecaoPorAssGer($codBi, $numeroParte, $numeroSecao,$codAssuntoGer);
	}

	//
	//*****Organiza��o Militar*************************
	//
	private function startOM() {
		$colOM = new ColOM($this->db);
		$this->rgrOM = new RgrOM($colOM);
		$colOMVinc = new ColOMVinc($this->db);
		$this->rgrOMVinc = new RgrOMVinc($colOMVinc);
		$colSubun = new ColSubunidade($this->db);
		$this->rgrSubun = new RgrSubunidade($colSubun);
	}
	public function incluirOM($OM) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startOM();
			$this->rgrOM->incluirRegistro($OM);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function alterarOM($OM) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startOM();
			$this->rgrOM->alterarRegistro($OM);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function excluirOM($OM) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startOM();
			$this->rgrOM->excluirRegistro($OM);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function lerOM() {
		$this->startOM();
		return $this->rgrOM->lerRegistro();
	}

	public function lerColecaoOM($ordem) {
		$this->startOM();
		return $this->rgrOM->lerColecao($ordem);
	}
	//
	//*****OM Vinculada*************************
	//

	public function incluirOMVinc($OMVinc) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startOM();
			$this->rgrOMVinc->incluirRegistro($OMVinc);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function alterarOMVinc($OMVinc) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startOM();
			$this->rgrOMVinc->alterarRegistro($OMVinc);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function excluirOMVinc($OMVinc) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startOM();
			$this->rgrOMVinc->excluirRegistro($OMVinc);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function lerOMVinc($codOM) {
		$this->startOM();
		return $this->rgrOMVinc->lerRegistro($codOM);
	}
	public function lerColecaoOMVinc($ordem) {
		$this->startOM();
		return $this->rgrOMVinc->lerColecao($ordem);
	}

	//
	//*****Subunidade*************************
	//

	public function incluirSubun($omVinc,$subun) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startOM();
			$this->rgrSubun->incluirRegistro($omVinc,$subun);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function alterarSubun($omVinc,$subun) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startOM();
			$this->rgrSubun->alterarRegistro($omVinc,$subun);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function excluirSubun($omVinc,$subun) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startOM();
			$this->rgrSubun->excluirRegistro($omVinc,$subun);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function lerSubun($codom,$codSubun) {
		$this->startOM();
		//print_r($this->rgrSubun->lerRegistro($codom,$codSubun));
		return $this->rgrSubun->lerRegistro($codom,$codSubun);
	}
	public function lerColecaoSubun($codom) {
		$this->startOM();
		return $this->rgrSubun->lerColecao($codom);
	}

	// Ativa e dsativa pessoa
	public function ativaPessoa($idt) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMilitar();
			$this->rgrPessoa->ativaPessoa($idt);
			$this->meuLinkDB->terminarTransacao();
			return 'Ativado com Sucesso';
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			return $this->mensagem($e->getMessage());
		}
	}
	public function desativaPessoa($idt) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMilitar();
			$this->rgrPessoa->desativaPessoa($idt);
			$this->meuLinkDB->terminarTransacao();
			return 'Desativado com Sucesso';
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			return $this->mensagem($e->getMessage());
		}

	}

	//*****Militar*************************

	public function incluirMilitar($Militar) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMilitar();
			$this->rgrPessoa->incluirRegistro($Militar);
			$this->rgrMilitar->incluirRegistro($Militar);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}

	public function incluirMilitarME1($Militar) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMilitar();
			$this->rgrPessoa->incluirRegistro($Militar);
			$this->rgrMilitar->incluirRegistro($Militar);
			$this->meuLinkDB->terminarTransacao();
			return true;
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			//echo $e;
			return false;
		}
	}

	public function alterarMilitar($Militar) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMilitar();
			$this->rgrPessoa->alterarRegistro($Militar);
			$this->rgrMilitar->alterarRegistro($Militar);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function excluirMilitar($Militar) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMilitar();
			$this->rgrMilitar->excluirRegistro($Militar);
			$this->rgrPessoa->excluirRegistro($Militar);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			return $e->getMessage();
		}
	}
	public function lerMilitar($idMilitar) {
		$this->startMilitar();
		return $this->rgrMilitar->lerRegistro($idMilitar);
	}
	public function lerColecaoMilitar($ordem, $filtro) {
		$this->startMilitar();
		return $this->rgrMilitar->lerColecao($ordem, $filtro);
	}
	public function lerColMilNaoIncMatBI($codpgrad, $nome, $codMateriaBI, $codom, $codSubun, $todasOmVinc, $todasSubun) {
		$this->startMilitar();
		return $this->rgrMilitar->lerColMilNaoIncMatBI($codpgrad, $nome, $codMateriaBI, $codom, $codSubun, $todasOmVinc, $todasSubun);
	}
	public function lerColMilAssAlteracoes($filtro) {
		$this->startMilitar();
		return $this->rgrMilitar->lerColMilAssAlteracoes($filtro);
	}
	public function lerColMilAssNota($filtro) {
		$this->startMilitar();
		return $this->rgrMilitar->lerColMilAssNota($filtro);
	}
	// Pessoa materia BI--------------------------------------------------
	public function lerColecaoPessoaMateriaBI($codMateriaBi) {
		$this->startMateriaBI();
		$this->startMilitar();
		$this->startPGrad();
		$this->startQM();
		return $this->rgrPessoaMateriaBi->lerColecao($codMateriaBi);
	}

	public function lerPessoaMateriaBI($codMateriaBi, $idtMilitar) {
		$this->startMateriaBI();
		$this->startMilitar();
		$this->startPGrad();
		$this->startQM();
		return $this->rgrPessoaMateriaBi->lerRegistro($codMateriaBi, $idtMilitar);
	}

	public function incluirPessoaMateriaBI($materiaBi, $pessoaMateriaBi) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMateriaBI();
			$this->startMilitar();
			$this->startPGrad();
			$this->startQM();
			$this->rgrPessoaMateriaBi->incluirRegistro($materiaBi, $pessoaMateriaBi);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}

	public function excluirPessoaMateriaBI($materiaBi, $pessoaMateriaBi) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMateriaBI();
			$this->startMilitar();
			$this->startPGrad();
			$this->startQM();
			$this->rgrPessoaMateriaBi->excluirRegistro($materiaBi, $pessoaMateriaBi);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function alterarPessoaMateriaBI($materiaBi, $pessoaMateriaBi) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startMateriaBI();
			$this->startMilitar();
			$this->startPGrad();
			$this->startQM();
			$this->rgrPessoaMateriaBi->alterarRegistro($materiaBi, $pessoaMateriaBi);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}

	public function lerAlteracoes($idMilitar, $dtInicio, $dtTermino) {
		return $this->rgrPessoaMateriaBi->lerAlteracoes($idMilitar, $dtInicio, $dtTermino);
	}
	public function encerrarAno() {
		$this->startBoletim();
		$this->startOM();
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->rgrTipoBol->encerrarAno();
			$om = $this->rgrOM->lerRegistro();
			$om->setAnoCorrente($om->getAnoCorrente() + 1);
			$this->rgrOM->alterarRegistro($om);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	// Tempo de Servi�o --------------------------------------------------
	public function lerColecaoTempoSerPer($filtro, $ordem) {
		$this->startTempoSerPer();
		return $this->rgrTempoSerPer->lerColecao($filtro, $ordem);
	}
	public function incluirTempoSv($TempoSerPer) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startTempoSerPer();
			$this->rgrTempoSerPer->incluirRegistro($TempoSerPer);
			$this->meuLinkDB->terminarTransacao();
			//$this->mensagem_ajax('Registro Inclu�do com Sucesso!','Sucesso');
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem_ajax($e->getMessage(), 'Erro');
		}
	}
	public function excluirTempoSv($TempoSerPer) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startTempoSerPer();
			$this->rgrTempoSerPer->excluirRegistro($TempoSerPer);
			$this->meuLinkDB->terminarTransacao();
			//$this->mensagem_ajax('Registro exclu�do com Sucesso!','Sucesso');
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem_ajax($e->getMessage(), 'Erro');
		}
	}
	public function alterarTempoSv($TempoSerPer, $tipo = false) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startTempoSerPer();
			$this->rgrTempoSerPer->alterarRegistro($TempoSerPer);
			$this->meuLinkDB->terminarTransacao();
			//if($tipo){
			//	$this->mensagem_ajax('Registro alterado com Sucesso!','Sucesso');
			//}
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem_ajax($e->getMessage(), 'Erro');
		}
	}
	public function lerTempoSv($dataIn, $dataFim, $idMilitar, $idComport) {
		$this->startTempoSerPer();
		return $this->rgrTempoSerPer->lerRegistro($dataIn, $dataFim, $idMilitar);
	}
	// vzo versao 2.0
	public function lerComportamento($idComport) {
		switch ($idComport)
		{
			case 1:
				$Comport = "Excepcional";
			break;
			case 2:
				$Comport = "Otimo";
			break;
			case 3:
				$Comport = "Bom";
			break;
			case 5:
				$Comport = "Insuficiente";
			break;
			case 6:
				$Comport = "Mau";
			break;
			default:
				$Comport = "Invalido";
			break;
		}
		return $Comport;
$this->startMilitar();
		return ;
	}
	private function mensagem_ajax($msg, $tipo) {
		if ($tipo == "Erro") {
			$cor = "#FF0000";
		} else {
			$cor = "#0000FF";
		}
		echo '<TABLE width="300" bgcolor="' . $cor . '" CELLPADDING="1" ><TR><TD>
				<TABLE width="100%" border="0" BORDERCOLOR="#C0C0C0" BORDERCOLORLIGHT="#C0C0C0" CELLSPACING="0" CELLPADDING="0" name="tabela">
				<TR><TD><font size="2" color="white"><B>' . $tipo . '</B></font></TD></TR>
				<TR><TD  BGCOLOR="white"><br>&nbsp;' . $msg . '<br>&nbsp;</TD></TR>
				<TR><TD  align="center" BGCOLOR="white"><input type="button" value="Ok" onclick="ok(\'' . $tipo . '\')"></TD></TR>
				</TABLE></TD></TR></TABLE><BR>';
	}

	private function mensagem($i) {
		$msg = $i;
		if ($i === 0) {
			$msg = "Registro inclu�do com sucesso.";
		}
		elseif ($i === 1) {
			$msg = "Registro alterado com sucesso.";
		}
		elseif ($i === 2) {
			$msg = "Registro exclu�do com sucesso.";
		}
		//echo '<script>window.alert("'.$msg.'")</script>';
		echo $msg;
	}
	/*
	public function login($usuario)
	{ //verifica se e o supervisor
	  if (($this->local_user == $usuario->getLogin()) and ($this->local_senha == $usuario->getSenha()))
	  { // registra as variaveis de sessao
		$_SESSION['TIPOUSER']		=	1;
		$_SESSION['NOMEUSUARIO']	=	$usuario->getLogin();
		echo '<script>location.href="menuboletim.php"</script>';
	  }
	  else
	  { // se nao e o supervisor, ler o usuario

	    $lUsuario = $this->rgrUsuario->lerRegistro($usuario->getLogin());
	    //se o usuario nao existe
	    if ($lUsuario == null)
	    { echo '<script>window.alert("Usu�rio " ' . $usuario->getLogin() . ' "n�o existe")</script>';
	    }
	    else
	    { //se existe, verifica a senha
		  if ($usuario->getSenha() != $lUsuario->getSenha())
	      { echo 'senha infor='.$usuario->getSenha(). 'senha lida='. $lUsuario->getSenha();
		    echo '<script>window.alert("Senha inv�lida")</script>';
	      }
	      else
	      { //usuario e senha corretos, registra as variaveis de sessao
		    $_SESSION['TIPOUSER']		=	1;
	 		$_SESSION['NOMEUSUARIO']	=	$usuario->getLogin();
			echo '<script>location.href="menuboletim.php"</script>';
	      }
	    }
	  }
	}*/
	//
	//funcoes de usuario
	//
	public function incluirUsuario($usuario) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startUsuario();
			$this->rgrUsuario->incluirRegistro($usuario);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
		}
	}
	public function alterarUsuario($usuario) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startUsuario();
			$this->rgrUsuario->alterarRegistro($usuario);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
		}
	}
	public function excluirUsuario($usuario) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startUsuario();
			$this->rgrUsuario->excluirRegistro($usuario);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
		}
	}
	public function lerUsuario($login) {
		$this->startUsuario();
		return $this->rgrUsuario->lerRegistro($login);
	}
	public function lerColecaoUsuario() {
		$this->startUsuario();
		return $this->rgrUsuario->lerColecao();
	}
	//
	// funcoes do sistema
	//
	public function lerFuncaoDoSistema($codigo) {
		$this->startFuncoesDoSistema();
		return $this->rgrFuncaoDoSistema->lerRegistro($codigo);
	}
	public function lerColecaoFuncaoDoSistema() {
		$this->startFuncoesDoSistema();
		return $this->rgrFuncaoDoSistema->lerColecao();
	}
	public function inicializarBaseFuncoes() {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startFuncoesDoSistema();
			$this->rgrFuncaoDoSistema->inicializarBase();
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
		}
	}
	//
	// usuariofuncao
	//
	public function incluirUsuarioFuncao($usuario, $funcaoDoSistema) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startFuncoesDoSistema();
			$this->rgrUsuarioFuncao->incluirRegistro($usuario, $funcaoDoSistema);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
		}
	}
	public function excluirUsuarioFuncao($usuario, $funcaoDoSistema) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startFuncoesDoSistema();
			$this->rgrUsuarioFuncao->excluirRegistro($usuario, $funcaoDoSistema);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
		}
	}
	public function lerColecaoAutorizadaPorFuncao($codFuncao, $assocTipoBol) //alterado
	{
		$this->startFuncoesDoSistema();
		return $this->rgrUsuarioFuncao->lerColecaoAutorizadaPorFuncao($codFuncao, $assocTipoBol);
	}
	public function lerColecaoAutorizada($login, $assocTipoBol) {
		$this->startFuncoesDoSistema();
		return $this->rgrUsuarioFuncao->lerColecaoAutorizada($login, $assocTipoBol);
	}
	public function lerColecaoNaoAutorizada($login, $assocTipoBol) {
		$this->startFuncoesDoSistema();
		return $this->rgrUsuarioFuncao->lerColecaoNaoAutorizada($login, $assocTipoBol);
	}
	//
	// usuariofuncaotipobol
	//
	public function incluirUsuarioFuncaoTipoBol($usuario, $funcaoDoSistema, $tipoBol) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startUsuarioFuncaoTipoBol();
			$this->rgrUsuarioFuncaoTipoBol->incluirRegistro($usuario, $funcaoDoSistema, $tipoBol);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
		}
	}
	public function excluirUsuarioFuncaoTipoBol($usuario, $funcaoDoSistema, $tipoBol) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			$this->startUsuarioFuncaoTipoBol();
			$this->rgrUsuarioFuncaoTipoBol->excluirRegistro($usuario, $funcaoDoSistema, $tipoBol);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
		}
	}
	/*    public function lerColecaoUsuarioFuncaoTipoBol($login, $codigoFuncao)
	    { return $this->$rgrUsuarioFuncaoTipoBol->lerColecaoTipoBol($login, $codigoFuncao);
	    }*/
	public function lerColecaoAutorizadaTipoBol($login, $codigoFuncao) {
		$this->startUsuarioFuncaoTipoBol();
//	    die("passou...".$login."*");
		return $this->rgrUsuarioFuncaoTipoBol->lerColecaoAutorizada($login, $codigoFuncao);
	}
	public function lerColecaoNaoAutorizadaTipoBol($login, $codigoFuncao) {
		$this->startUsuarioFuncaoTipoBol();
		return $this->rgrUsuarioFuncaoTipoBol->lerColecaoNaoAutorizada($login, $codigoFuncao);
	}
	public function lerUsuarioFuncaoCodTipoBol($login, $codigoFuncao, $codTipoBol) {
		$this->startUsuarioFuncaoTipoBol();
		return $this->rgrUsuarioFuncaoTipoBol->lerRegistro($login, $codigoFuncao, $codTipoBol);
	}
	public function gerarIndice($codTipoBol, $dtInicio, $dtTermino) {
		$this->startIndice();
		$this->startOM();
		$conGerarIndice = new ConGerarIndice($this->rgrIndice, $this->rgrOM, $this->bandIniFile);
		$arq = $conGerarIndice->gerarIndice($codTipoBol, $dtInicio, $dtTermino);
		return $arq;
	}
	public function gerarIndicePessoa($codTipoBol, $dtInicio, $dtTermino) {
		$this->startIndicePessoa();
		$this->startOM();
		$conGerarIndicePessoa = new ConGerarIndicePessoa($this->rgrIndicePessoa, $this->rgrOM, $this->bandIniFile);
		$arq = $conGerarIndicePessoa->gerarIndicePessoa($codTipoBol, $dtInicio, $dtTermino);
		return $arq;
	}

	public function lerAssinaBi($codAssinaBI) {
		$this->startBoletim();
		$this->startFuncao();
		$this->startMilitar();
		return $this->rgrAssinaConfereBi->lerPorCodigo($codAssinaBI);
	}
	public function lerAssinaConfereBiAtual() {
		$this->startBoletim();
		$this->startFuncao();
		$this->startMilitar();
		$this->startOM();

		$conIncOuAltBoletim = new ConIncOuAltBoletim($this->rgrTipoBol, $this->rgrBoletim, $this->rgrFuncao, $this->rgrMilitar, $this->rgrAssinaConfereBi);
		return $conIncOuAltBoletim;
	}
	
	//
	//*****Configuracoes*************************
	//
	public function alterarConfiguracoes($Configuracoes) {
		try {
			$this->meuLinkDB->iniciarTransacao();
			//$this->startOM();
			$this->rgrConfiguracoes->alterarRegistro($Configuracoes);
			$this->meuLinkDB->terminarTransacao();
		} catch (Exception $e) {
			$this->meuLinkDB->cancelarTransacao();
			$this->mensagem($e->getMessage());
		}
	}
	public function lerConfiguracoes() {
		//$this->startOM();
		return $this->rgrConfiguracoes->lerRegistro();
	}
	
	
}
?>
