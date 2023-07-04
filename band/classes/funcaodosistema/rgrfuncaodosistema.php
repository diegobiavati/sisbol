<?php
  class RgrFuncaoDoSistema
  { private $colFuncaoDoSistema;
    public function RgrFuncaoDoSistema($colFuncaoDoSistema)
    { $this->colFuncaoDoSistema = $colFuncaoDoSistema;
    }
    private function consisteDados($funcaoDoSistema, $oper)
    { if ($funcaoDoSistema->getCodigo() <= 0)
      { throw new Exception('C�digo Inv�lido!');
      }
    }
    public function incluirRegistro($funcaoDoSistema)
    { $this->consisteDados($funcaoDoSistema, 'I');
	  $this->colFuncaoDoSistema->incluirRegistro($funcaoDoSistema);
    }
    public function alterarRegistro($funcaoDoSistema)
    { $this->consisteDados($funcaoDoSistema, 'A');
	  $this->colFuncaoDoSistema->alterarRegistro($funcaoDoSistema);
    }
    public function excluirRegistro($funcaoDoSistema)
    { $this->colFuncaoDoSistema->excluirRegistro($funcaoDoSistema);
    }
    public function lerRegistro($codigo)
    { return $this->colFuncaoDoSistema->lerRegistro($codigo);
    }
    public function lerColecao()
    { return $this->colFuncaoDoSistema->lerColecao();
    }
    public function inicializarBase()
    { $this->criarObjeto(1001, 'Incluir Posto/Gradua��o','N');
      $this->criarObjeto(1002, 'Alterar Posto/Gradua��o','N');
      $this->criarObjeto(1003, 'Excluir Posto/Gradua��o','N');
      $this->criarObjeto(1004, 'Consultar Posto/Gradua��o','N');

      $this->criarObjeto(1011, 'Incluir Fun��o do Militar','N');
      $this->criarObjeto(1012, 'Alterar Fun��o do Militar','N');
      $this->criarObjeto(1013, 'Excluir Fun��o do Militar','N');
      $this->criarObjeto(1014, 'Consultar Fun��o do Militar','N');

      $this->criarObjeto(1021, 'Incluir QM','N');
      $this->criarObjeto(1022, 'Alterar QM','N');
      $this->criarObjeto(1023, 'Excluir QM','N');
      $this->criarObjeto(1024, 'Consultar QM','N');

      $this->criarObjeto(1031, 'Incluir Militar','N');
      $this->criarObjeto(1032, 'Alterar Militar','N');
      $this->criarObjeto(1033, 'Excluir Militar','N');
      $this->criarObjeto(1034, 'Consultar Militar','N');

      $this->criarObjeto(1041, 'Incluir OM Vincula�ao','N');
      $this->criarObjeto(1042, 'Alterar OM Vincula��o','N');
      $this->criarObjeto(1043, 'Excluir OM Vincula��o','N');
      $this->criarObjeto(1044, 'Consultar OM Vincula��o','N');

      $this->criarObjeto(1046, 'Incluir Subunidade/Divis�o','N');
      $this->criarObjeto(1047, 'Alterar Subunidade/Divis�o','N');
      $this->criarObjeto(1048, 'Excluir Subunidade/Divis�o','N');
      $this->criarObjeto(1049, 'Consultar Subunidade/Divis�o','N');

      $this->criarObjeto(1051, 'Incluir Tipo de Boletim','N');
      $this->criarObjeto(1052, 'Alterar Tipo de Boletim','N');
      $this->criarObjeto(1053, 'Excluir Tipo de Boletim','N');
      $this->criarObjeto(1054, 'Consultar Tipo de Boletim','N');

      $this->criarObjeto(1061, 'Incluir OM','N');
      $this->criarObjeto(1062, 'Alterar OM','N');
      $this->criarObjeto(1063, 'Excluir OM','N');
      $this->criarObjeto(1064, 'Consultar OM','N');

      $this->criarObjeto(1071, 'Incluir Tipo de Documento','N');
      $this->criarObjeto(1072, 'Alterar Tipo de Documento','N');
      $this->criarObjeto(1073, 'Excluir Tipo de Documento','N');
      $this->criarObjeto(1074, 'Consultar Tipo de Documento','N');

      $this->criarObjeto(1081, 'Incluir Partes do Boletim','N');
      $this->criarObjeto(1082, 'Alterar Partes do Boletim','N');
      $this->criarObjeto(1083, 'Excluir Partes do Boletim','N');
      $this->criarObjeto(1084, 'Consultar Partes do Boletim','N');
      
      $this->criarObjeto(1091, 'Incluir Se��o do Boletim','N');
      $this->criarObjeto(1092, 'Alterar Se��o do Boletim','N');
      $this->criarObjeto(1093, 'Excluir Se��o do Boletim','N');
      $this->criarObjeto(1094, 'Consultar se��o do Boletim','N');

      $this->criarObjeto(1101, 'Incluir Assunto Geral','S');
      $this->criarObjeto(1102, 'Alterar Assunto geral','S');
      $this->criarObjeto(1103, 'Excluir Assunto Geral','S');
      $this->criarObjeto(1104, 'Consultar Assunto Geral','S');
      
      $this->criarObjeto(1111, 'Incluir Assunto Espec','S');
      $this->criarObjeto(1112, 'Alterar Assunto Espec','S');
      $this->criarObjeto(1113, 'Excluir Assunto Espec','S');
      $this->criarObjeto(1114, 'Consultar Assunto Espec','S');

      //OK-verificado em 27/07/07
      $this->criarObjeto(1121, 'Incluir Tempo de Serv','N');
      //OK-verificado em 27/07/07
      $this->criarObjeto(1122, 'Alterar Tempo de Serv','N');
      //OK-verificado em 27/07/07
      $this->criarObjeto(1123, 'Excluir Tempo de Serv','N');
      //OK-verificado em 27/07/07
      $this->criarObjeto(1124, 'Consultar Tempo de Serv','N');
      //OK-verificado em 27/07/07
      $this->criarObjeto(1131, 'Registrar Assinatura de Altera��es','N');
      //OK-verificado em 27/07/07
//      $this->criarObjeto(1132, 'Cancelar Registro de Assinatura de Altera��es','N');
      
      //OK-verificado em 27/07/07
      $this->criarObjeto(1133, 'Gerar Altera��es','N');
      //OK-verificado em 26/07/07
      $this->criarObjeto(1134, 'Gerar Ficha de Identifica��o','N');
      //OK-verificado em 12/02/08 - Renato
      $this->criarObjeto(1135, 'Baixar Altera��es Geradas','N');
      
      //OK-verificado em 26/07/07
      $this->criarObjeto(1141, 'Gerar Backup','N');
      //OK-verificado em 26/07/07
      $this->criarObjeto(1142, 'Restaurar/Apagar Backup','N');
      //OK-verificado em 26/07/07
      $this->criarObjeto(1143, 'Encerrar Ano','N');
      //OK-verificado em 26/07/07
      $this->criarObjeto(1144, 'Inicializar Base de Fun��es','N');
      //OK-verificado em 12/02/08 - Renato
      $this->criarObjeto(1194, 'Importa a Tabela Militar do ME1','N');
      $this->criarObjeto(1195, 'Configura��es','N');
      
      //OK-verificado em 26/07/07
      $this->criarObjeto(1151, 'Incluir Usu�rio','N');
      //OK-verificado em 26/07/07
      $this->criarObjeto(1152, 'Alterar Usu�rio','N');
      //OK-verificado em 26/07/07
      $this->criarObjeto(1153, 'Excluir Usu�rio','N');
      //OK-verificado em 26/07/07
      $this->criarObjeto(1154, 'Consultar Usu�rio','N');
      //OK-verificado em 26/07/07
      $this->criarObjeto(1161, 'Incluir Usu�rio/Fun��o','N');
      //OK-verificado em 26/07/07
      $this->criarObjeto(1163, 'Excluir Usu�rio/Fun��o','N');      
      //OK-verificado em 26/07/07
      $this->criarObjeto(1164, 'Consultar Usu�rio/Fun��o','N');
      //OK-verificado em 26/07/07
      $this->criarObjeto(1181, 'Incluir Usu�rio/Fun��o/Tipobol','N');
      //OK-verificado em 26/07/07
      $this->criarObjeto(1183, 'Excluir Usu�rio/Fun��o/Tipobol','N');      
      //OK-verificado em 26/07/07
      $this->criarObjeto(1184, 'Consultar Usu�rio/Fun��o/Tipobol','N');


      //OK-verificado em 26/07/07
      $this->criarObjeto(2001, 'Incluir Mat�ria p/ BI','S');
      //OK-verificado em 26/07/07
      $this->criarObjeto(2002, 'Alterar Mat�ria p/ BI','S');
      //OK-verificado em 26/07/07
      $this->criarObjeto(2003, 'Excluir Mat�ria p/ BI','S');
      //OK-verificado em 26/07/07
      $this->criarObjeto(2004, 'Consultar Mat�ria p/ BI','S');
      
      //OK-verificado em 26/07/07
      $this->criarObjeto(2011, 'Aprovar Nota p/ BI (SU/Div)','S');
      $this->criarObjeto(2013, 'Aprovar Nota p/ BI (Cmt/Ch/Dir)','S');

      //OK-verificado em 26/07/07
//      $this->criarObjeto(2012, 'Cancelar Aprova��o de Mat�ria p/ BI','S');
      //OK-verificado em 26/07/07
      $this->criarObjeto(2021, 'Incluir Mat�ria em BI','S');
      //OK-verificado em 26/07/07
      $this->criarObjeto(2022, 'Excluir Mat�ria do BI','S');
      //OK-verificado em 26/07/07
      $this->criarObjeto(3001, 'Incluir boletim','S');
      //OK-verificado em 26/07/07
      $this->criarObjeto(3002, 'Alterar boletim','S');
      //OK-verificado em 26/07/07
      $this->criarObjeto(3003, 'Excluir boletim','S');
      //OK-verificado em 26/07/07
      $this->criarObjeto(3004, 'Consultar boletim','S');
      //OK-verificado em 25/07/07
      $this->criarObjeto(3011, 'Aprovar boletim','S');
      //ok VERIFICADO EM 25/07/07
//      $this->criarObjeto(3012, 'Cancelar Aprova��o de boletim','S');

      //ok-verificado em 25/07/07
      $this->criarObjeto(3021, 'Assinar boletim','S');
      //ok-verificado em 25/07/07
      $this->criarObjeto(3022, 'Cancelar assinatura de boletim','S');
      $this->criarObjeto(3023, 'Ordenar Mat�rias','S');
      //okverificado em 25/07/07
      $this->criarObjeto(3030, 'Baixar Boletim','S');	//rv 05
      $this->criarObjeto(3031, 'Gerar boletim','S');
      $this->criarObjeto(3032, 'Gerar Indice','S');

      
    }
    private function criarObjeto($codigo, $descricao, $assocTipoBol)
    {
	  $funcaoDoSistema = new FuncaoDoSistema();
      $funcaoDoSistema->setCodigo($codigo);
      $funcaoDoSistema->setDescricao($descricao);
      $funcaoDoSistema->setAssocTipoBol($assocTipoBol);
      $lFuncaoDoSistema = $this->colFuncaoDoSistema->lerRegistro($funcaoDoSistema->getCodigo());
      if ($lFuncaoDoSistema == null)
      { $this->incluirRegistro($funcaoDoSistema);
      }
      else
      { $this->alterarRegistro($funcaoDoSistema);
      }      
    }
//
  }
?>
