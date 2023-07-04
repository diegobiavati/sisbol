function carregaedit(cod,idtMilAss,acao,status,tipoBol) {
	if (acao == "Excluir")  {
		if (!window.confirm("Deseja realmente excluir a matéria para Boletim selecionada ?")){
			return ;
		}
		document.elaboMateria.executar.value = acao;
		window.location.href="elabomatbi.php?codMateriaBIAtual="+cod+"&acao="+acao+"&codTipoBol="+document.elaboMateria.seleTipoBol.value;
		}

		if (acao == "Alterar")  {
		window.location.href="cadmateriabi.php?codMateriaBIAtual="+cod+"&codTipoBol="+tipoBol+"&acao=Alterar"+"&idtMilAss="+idtMilAss+"&status="+status;
		}
	}