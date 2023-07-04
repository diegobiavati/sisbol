<?php
  class RgrConfiguracoes { 
  	private $colConfiguracoes;
    public function RgrConfiguracoes($colConfiguracoes)
    { $this->colConfiguracoes = $colConfiguracoes;
    }
    public function alterarRegistro($Configuracoes)
    { 
      $this->colConfiguracoes->alterarRegistro($Configuracoes);
    }
    public function lerRegistro()
    { return $this->colConfiguracoes->lerRegistro();
    }
  }
?>
