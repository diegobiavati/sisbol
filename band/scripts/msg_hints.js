function getMsg(cod){
	if (cod == "1"){
		texto = 	   "- Faz o cálculo de tempo de serviço a partir do ";
		texto += "\<br\>do tempo de serviço registrado no semestre anterior.";
		return texto;
	}
	if (cod == "2"){
		texto =  "- Você pode omitir a impressão deste título no";
		texto += "\<br\> boletim, adicionando-se parênteses no início";
		texto += "\<br\> e no fim do texto. Ex:";
		texto += "\<br\>\<br\>  (Autorização de Deslocamento)";
		return texto;
	}
	if (cod == "3"){
		texto =  "- Tamanho máximo: 10 caracteres alfanuméricos";
		return texto;
	}
	if (cod == "4"){
		texto =  "- Tamanho máximo: 20 caracteres alfanuméricos";
		return texto;
	}
}


