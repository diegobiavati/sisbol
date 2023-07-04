<?php
  class RgrIndicePessoa
  { private $colIndicePessoa;
    public function RgrIndicePessoa($colIndicePessoa)
    { $this->colIndicePessoa = $colIndicePessoa;
    }
    public function lerColecao($codTipoBol, $dtInicio, $dtTermino)
    {  return $this->colIndicePessoa->lerColecao($codTipoBol, $dtInicio, $dtTermino);
    }
//
  }
?>
