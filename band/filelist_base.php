<?php
  require_once('./classes/minhadata/minhadata.php');
  require_once('./classes/tempos/tempos.php');
  require_once('./apresentacao.php');

  require_once('./classes/inifile/inifile.php');
  require_once('./classes/band/bandinifile.php');
  require_once('./classes/band/supinifile.php');

  require_once('./classes/pessoa/pessoa.php');
  require_once('./classes/pessoa/icolpessoa.php');
  require_once('./classes/pessoa/colpessoa.php');
  require_once('./classes/pessoa/rgrpessoa.php');

  require_once('./classes/militar/militar.php');
  require_once('./classes/militar/icolmilitar2.php');
  require_once('./classes/militar/colmilitar2.php');
  require_once('./classes/militar/icolmilitar.php');
  require_once('./classes/militar/colmilitar.php');
  require_once('./classes/militar/rgrmilitar.php');

  require_once('./classes/parteboletim/parteboletim.php');
  require_once('./classes/parteboletim/icolparteboletim2.php');
  require_once('./classes/parteboletim/colparteboletim2.php');
  require_once('./classes/parteboletim/icolparteboletim.php');
  require_once('./classes/parteboletim/colparteboletim.php');
  require_once('./classes/parteboletim/rgrparteboletim.php');
  
  require_once('./classes/secaopartebi/secaopartebi.php');
  require_once('./classes/secaopartebi/icolsecaopartebi.php');
  require_once('./classes/secaopartebi/colsecaopartebi.php');
  require_once('./classes/secaopartebi/rgrsecaopartebi.php');
  require_once('./classes/secaopartebi/icolsecaopartebi2.php');
  require_once('./classes/secaopartebi/colsecaopartebi2.php');
  
  require_once('./classes/assuntogeral/assuntogeral.php');
  require_once('./classes/assuntogeral/icolassuntogeral2.php');
  require_once('./classes/assuntogeral/colassuntogeral2.php');
  require_once('./classes/assuntogeral/icolassuntogeral.php');
  require_once('./classes/assuntogeral/colassuntogeral.php');
  require_once('./classes/assuntogeral/rgrassuntogeral.php');
  
  require_once('./classes/assuntoespec/assuntoespec.php');
  require_once('./classes/assuntoespec/icolassuntoespec.php');
  require_once('./classes/assuntoespec/colassuntoespec.php');
  require_once('./classes/assuntoespec/icolassuntoespec2.php');
  require_once('./classes/assuntoespec/colassuntoespec2.php');
  require_once('./classes/assuntoespec/rgrassuntoespec.php');
  
  require_once('./classes/tipodoc/tipodoc.php');
  require_once('./classes/tipodoc/icoltipodoc2.php');
  require_once('./classes/tipodoc/coltipodoc2.php');
  require_once('./classes/tipodoc/icoltipodoc.php');
  require_once('./classes/tipodoc/coltipodoc.php');
  require_once('./classes/tipodoc/rgrtipodoc.php');

  require_once('./classes/pgrad/rgrpgrad.php');
  require_once('./classes/pgrad/pgrad.php');
  require_once('./classes/pgrad/icolpgrad.php');
  require_once('./classes/pgrad/colpgrad.php');
  require_once('./classes/pgrad/icolpgrad2.php');
  require_once('./classes/pgrad/colpgrad2.php');
 
  require_once('./classes/qm/rgrqm.php');
  require_once('./classes/qm/qm.php');
  require_once('./classes/qm/icolqm2.php');
  require_once('./classes/qm/colqm2.php');
  require_once('./classes/qm/icolqm.php');
  require_once('./classes/qm/colqm.php');


  require_once('./classes/funcao/funcao.php');
  require_once('./classes/funcao/icolfuncao2.php');
  require_once('./classes/funcao/colfuncao2.php');
  require_once('./classes/funcao/icolfuncao.php');
  require_once('./classes/funcao/colfuncao.php');
  require_once('./classes/funcao/rgrfuncao.php');

  require_once('./classes/tipobol/tipobol.php');
  require_once('./classes/tipobol/icoltipobol2.php');
  require_once('./classes/tipobol/coltipobol2.php');
  require_once('./classes/tipobol/icoltipobol.php');
  require_once('./classes/tipobol/coltipobol.php');
  require_once('./classes/tipobol/rgrtipobol.php');

  require_once('./classes/boletim/boletim.php');
  require_once('./classes/boletim/icolboletim2.php');
  require_once('./classes/boletim/colboletim2.php');
  require_once('./classes/boletim/icolboletim.php');
  require_once('./classes/boletim/colboletim.php');
  require_once('./classes/boletim/rgrboletim.php');

  require_once('./classes/materiabi/materiabi.php');
  require_once('./classes/materiabi/icolmateriabi2.php');
  require_once('./classes/materiabi/colmateriabi2.php');
  require_once('./classes/materiabi/icolmateriabi.php');
  require_once('./classes/materiabi/colmateriabi.php');
  require_once('./classes/materiabi/rgrmateriabi.php');

  require_once('./classes/om/om.php');
  require_once('./classes/om/icolom.php');
  require_once('./classes/om/colom.php');
  require_once('./classes/om/rgrom.php');
  require_once('./classes/om/icolom2.php');
  require_once('./classes/om/colom2.php');

  require_once('./classes/omvinc/omvinc.php');
  require_once('./classes/omvinc/icolomvinc.php');
  require_once('./classes/omvinc/colomvinc.php');
  require_once('./classes/omvinc/rgromvinc.php');
  require_once('./classes/omvinc/icolomvinc2.php');
  require_once('./classes/omvinc/colomvinc2.php');

  require_once('./classes/assinaconferebi/assinaconferebi.php');
  require_once('./classes/assinaconferebi/icolassinaconferebi.php');
  require_once('./classes/assinaconferebi/colassinaconferebi.php');
  require_once('./classes/assinaconferebi/rgrassinaconferebi.php');


  require_once('./classes/pessoamateriabi/pessoamateriabi.php');
  require_once('./classes/pessoamateriabi/icolpessoamateriabi.php');
  require_once('./classes/pessoamateriabi/colpessoamateriabi.php');
  require_once('./classes/pessoamateriabi/rgrpessoamateriabi.php');
  require_once('./classes/pessoamateriabi/icolpessoamateriabi2.php');
  require_once('./classes/pessoamateriabi/colpessoamateriabi2.php');
  
  
  require_once('./classes/meulinkdb/meulinkdb.php');
  require_once('./classes/arquivotexto/arquivotexto.php');
  require_once('./classes/band/fachadasist2.php');
  require_once('./classes/band/conincoualtboletim.php');
  require_once('./classes/band/conexcluirboletim.php');
  require_once('./classes/band/congerarboletim.php');
  require_once('./classes/band/congerarboletimpdf.php');
  require_once('./classes/band/congerarboletimhtml.php');
  require_once('./classes/band/congeraralteracoes.php');
  require_once('./classes/band/congerarficha.php');
  require_once('./classes/band/congerarindice.php');
  require_once('./classes/band/congerarboletimpdfhtml.php');  
  
  require_once('./classes/temposerper/temposerper.php');
  require_once('./classes/temposerper/icoltemposerper.php');
  require_once('./classes/temposerper/coltemposerper.php');
  require_once('./classes/temposerper/rgrtemposerper.php');
  require_once('./classes/temposerper/icoltemposerper2.php');
  require_once('./classes/temposerper/coltemposerper2.php');
  
  require_once('./classes/fpdf/fpdf.php');
  require_once('./classes/fpdf/html2fpdf.php');
  require_once('./classes/fpdf/meuhtml2fpdf.php');
  //require_once('./classes/meupdf/meupdf.php');
  //require_once('./classes/meupdfalt/meupdfalt.php');
  require_once('./classes/fpdf/meuhtml2fpdfalt.php');
  require_once('./classes/meupdffic/meupdffic.php');
  require_once('./classes/meupdflistas/meupdflistas.php');
  require_once('./classes/meupdfind/meupdfind.php');
	

  //require_once('./classes/nomeguerra/nomeguerra.php');
  
  require_once('./classes/usuario/usuario.php');
  require_once('./classes/usuario/icolusuario.php');
  require_once('./classes/usuario/colusuario.php');
  require_once('./classes/usuario/icolusuario2.php');
  require_once('./classes/usuario/colusuario2.php');
  require_once('./classes/usuario/rgrusuario.php');

  require_once('./classes/funcaodosistema/funcaodosistema.php');
  require_once('./classes/funcaodosistema/icolfuncaodosistema.php');
  require_once('./classes/funcaodosistema/colfuncaodosistema.php');
  require_once('./classes/funcaodosistema/icolfuncaodosistema2.php');
  require_once('./classes/funcaodosistema/colfuncaodosistema2.php');
  require_once('./classes/funcaodosistema/rgrfuncaodosistema.php');

  require_once('./classes/usuariofuncao/icolusuariofuncao.php');
  require_once('./classes/usuariofuncao/colusuariofuncao.php');
  require_once('./classes/usuariofuncao/rgrusuariofuncao.php');

  require_once('./classes/usuariofuncaotipobol/usuariofuncaotipobol.php');
  require_once('./classes/usuariofuncaotipobol/icolusuariofuncaotipobol.php');
  require_once('./classes/usuariofuncaotipobol/colusuariofuncaotipobol.php');
  require_once('./classes/usuariofuncaotipobol/rgrusuariofuncaotipobol.php');

  require_once('./classes/indice/indice.php');
  require_once('./classes/indice/icolindice.php');
  require_once('./classes/indice/colindice.php');
  require_once('./classes/indice/icolindice2.php');
  require_once('./classes/indice/colindice2.php');
  require_once('./classes/indice/rgrindice.php');

  require_once('./classes/indicepessoa/indicepessoa.php');
  require_once('./classes/indicepessoa/icolindicepessoa.php');
  require_once('./classes/indicepessoa/colindicepessoa.php');
  require_once('./classes/indicepessoa/icolindicepessoa2.php');
  require_once('./classes/indicepessoa/colindicepessoa2.php');
  require_once('./classes/indicepessoa/rgrindicepessoa.php');
  require_once('./classes/band/congerarindicepessoa.php');

function encriptaSenha($senha){
  return strrev( md5( strrev( md5( $senha ) ) ) );
}

function comparaSenha($senha, $var){
	//echo 'Senha: '.$senha;
	//echo 'Senha: '.strrev(md5(strrev(md5($var))));
	if($senha === strrev(md5(strrev(md5($var))))){
		return true;
	} else {
		return false;
	}
}
  
?>
