// JavaScript Document
msg='ajuda não especificada';
function ajuda(topico) {
	
	if (topico=='cadPGrad'){
		msg='<b>Cadastro de Posto e Gradua&ccedil;&otilde;es</b><br><br>O Posto e Gradua&ccedil;&atilde;o segue conforme o Manual de Abreviaturas, Siglas, S&iacute;mbolos e Conven&ccedil;&otilde;es Cartogr&aacute;ficas das For&ccedil;as Armadas - MD33-M-02 de 2008. <br><br> Neste menu voc&ecirc; poder&aacute; adicionar, alterar e excluir Posto/Gradua&ccedil;&atilde;o. ';
	}
	
	if (topico=='cadFuncoes'){
		msg='As informa&ccedil;&otilde;es contidas neste menu, definem o comportamento do sistema, pois configura as fun&ccedil;&otilde;es principais de assinatura e confer&ecirc;ncia de Boletim, assinatura da Nota para BI e das altera&ccedil;&otilde;es, atrelando o militar respons&aacute;vel &agrave; sua fun&ccedil;&atilde;o, sendo poss&iacute;vel realizar as mudan&ccedil;as sempre que os militares forem designados para as mesmas.';
	}
	
	if (topico=='cadQM'){
		msg='Nesta tela &eacute; poss&iacute;vel fazer a manuten&ccedil;&atilde;o das designa&ccedil;&otilde;es de cada qualifica&ccedil;&atilde;o militar, sendo poss&iacute;vel adicionar, alterar e excluir as qualifica&ccedil;&otilde;es militares.';	
	}
	
	if (topico=='cadOmVinc'){
		msg='Quando existir alguma OM  vinculada a esta Organiza&ccedil;&atilde;o &eacute; importante que seja feita o cadastro, para que os militares sejam organizados por OM.';	
	}
	
	if (topico=='cadSubun'){
		msg='Nesta tela &eacute; feito o cadastro das Subunidades, Divis&otilde;es e Se&ccedil;&otilde;es, como mostro o exemplo abaixo:<br><img src="./imagens/secao.png">'
	}
	
	if (topico=='cadMilitar'){
		msg='Clique em &quot;Adicionar&quot; para fazer inclus&atilde;o de militares da OM. <p>Alguns campos possuem (*) s&atilde;o obrigat&oacute;rios, n&atilde;o permitindo a grava&ccedil;&atilde;o do registro caso estejam em branco. <p>Clique em &quot;Incluir&quot; para gravar o registro. <p>O campo antiguidade dever&aacute; ser atualizado conforme a listagem de cada OM, sugere-se deixar uma folga (n&uacute;meros) entre os Postos e Gradua&ccedil;&atilde;o baseando-se no QCP da OM. <p>No item situa&ccedil;&atilde;o ser&aacute; definido se o militar est&aacute; ativado ou desativado , caso o militar n&atilde;o perten&ccedil;a mais a Unidade dever&aacute; ser colocado na situa&ccedil;&atilde;o de &quot;desativado&quot;, assim n&atilde;o ser&aacute; gerada qualquer tipo de altera&ccedil;&atilde;o do militar. <p>Para alterar a situa&ccedil;&atilde;o de &quot;ativado ou desativado&quot;, clique no &iacute;cone &quot;Alterar&quot;.'
	}
	
	
	if (topico=='cadTipoBoletim'){
		msg='Nesta tela, o usu&aacute;rio &eacute; direcionado ao cadastro dos tipos de boletins, onde devem ser inseridos a descri&ccedil;&atilde;o e a abreviatura usual no corpo do texto. <p>Este m&oacute;dulo mostrar&aacute; sempre o controle de p&aacute;ginas e a quantidade de boletins de cada tipo j&aacute; emitida pelo sistema.<p>Esses &uacute;ltimos dados  n&atilde;o s&atilde;o acessados pelo usu&aacute;rio, sendo controlados pelo sistema. <p>As op&ccedil;&otilde;es dispon&iacute;veis s&atilde;o de altera&ccedil;&atilde;o e exclus&atilde;o, sendo que esta &uacute;ltima somente ser&aacute; poss&iacute;vel nesta fase (Cadastro de Tipos de Boletim). <p>Ap&oacute;s esta fase, n&atilde;o ser&aacute; mais poss&iacute;vel excluir, pois j&aacute; ter&atilde;o sido gerados Boletins daquele tipo. <p>Caso haja necessidade, s&oacute; ser&aacute; poss&iacute;vel depois da exclus&atilde;o de todos os Boletins criados daquele tipo. <p>Para adicionar um novo boletim, clique no &iacute;cone &quot;Adicionar&quot;, preencha os respectivos campos. <p>Na op&ccedil;&atilde;o &quot;Outros&quot; &eacute; poss&iacute;vel optar em reiniciar a numera&ccedil;&atilde;o de p&aacute;ginas a cada boletim e tamb&eacute;m defini-lo como aditamento, atrav&eacute;s das caixas de sele&ccedil;&atilde;o.'
	}
	
	if (topico=='cadTipoDoc'){
		msg='Nesta tela &eacute; poss&iacute;vel fazer a manuten&ccedil;&atilde;o    dos cadastros de Tipos de Documentos, sendo poss&iacute;vel adicionar, alterar    e excluir os cadastros de tipos de Documentos.'
	}
	
	if (topico=='cadAssuntoGeral'){
		msg=''
	}
	
	mostra(msg);	
}

function mostra(msg){
//alert(msg);
$("#divAjuda").html(msg);
$("#divAjuda").dialog('open');
}

$(function(){
	$("#divAjuda").dialog({
		modal: true,
		title: "Ajuda",
		autoSize: true,
		autoOpen: false,
		buttons: {
		Ok: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});