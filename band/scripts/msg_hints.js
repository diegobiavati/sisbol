function getMsg(cod){
	if (cod == "1"){
		texto = 	   "- Faz o c�lculo de tempo de servi�o a partir do ";
		texto += "\<br\>do tempo de servi�o registrado no semestre anterior.";
		return texto;
	}
	if (cod == "2"){
		texto =  "- Voc� pode omitir a impress�o deste t�tulo no";
		texto += "\<br\> boletim, adicionando-se par�nteses no in�cio";
		texto += "\<br\> e no fim do texto. Ex:";
		texto += "\<br\>\<br\>  (Autoriza��o de Deslocamento)";
		return texto;
	}
	if (cod == "3"){
		texto =  "- Tamanho m�ximo: 10 caracteres alfanum�ricos";
		return texto;
	}
	if (cod == "4"){
		texto =  "- Tamanho m�ximo: 20 caracteres alfanum�ricos";
		return texto;
	}
}


