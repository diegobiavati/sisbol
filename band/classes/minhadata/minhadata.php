<?php
  class MinhaData
  {
    private $cDia;
    private $cMes;
    private $cAno;

    private $iDia;
    private $iMes;
    private $iAno;
    private $nomeMes;
    private $nomeMes2;

    public function MinhaData($cDataMySql)
    { //recebe a data no formato mysql= yyyy-mm-dd e configura o objeto
      $cDia = substr($cDataMySql,8,2);
      $cMes = substr($cDataMySql,5,2);
      $cAno = substr($cDataMySql,0,4);
      
      $this->SetcDia($cDia);
      $this->SetcMes($cMes);
      $this->SetcAno($cAno);
	  $this->nomeMes = array(1 => 'Janeiro',2 =>  'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 
	    7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro');      
	  $this->nomeMes2 = array(1 => 'janeiro',2 =>  'fevereiro', 3 => 'março', 4 => 'abril', 5 => 'maio', 6 => 'junho', 
	    7 => 'julho', 8 => 'agosto', 9 => 'setembro', 10 => 'outubro', 11 => 'novembro', 12 => 'dezembro');      
    }
    
    public function SetcDia($valor)
    { $this->cDia = $valor;
      $this->iDia = intval($valor);
    }
    public function SetcMes($valor)
    { $this->cMes = $valor;
      $this->iMes = intval($valor);
    }
    public function SetcAno($valor)
    { $this->cAno = $valor;
      $this->iAno = intval($valor);
    }
    public function getNomeMes()
    { return $this->nomeMes[$this->iMes];
    }
    public function getNomeMes2()
    { return $this->nomeMes2[$this->iMes];
    }
    public function getIDia()
    { return $this->iDia;
    }
    public function getIMes()
    { return $this->iMes;
    }
    public function getIAno()
    { return $this->iAno;
    }
    public function GetcDataYYYYHMMHDD()
    { //retorna a data no formato YYYY-MM-DD no formato do mysql
      return $this->cAno . '-' . $this->cMes . '-' . $this->cDia;
    }
    public function GetcDataDDBMMBYYYY()
    { //retorna a data no formato DD/MM/YYYY
      return $this->cDia . '/' . $this->cMes . '/' . $this->cAno;
    }
    public function GetcDataMMBDDBYYYY()
    { //retorna a data no formato MM/DD/YYYY
      return $this->cMes . '/' . $this->cDia . '/' . $this->cAno;
    }
    public function GetIDataYYYYMMDD()
    { return $this->iAno * 10000 + $this->iMes * 100 + $this->iDia;
    }
    public function MaiorQue($valor)    
    { //retornaverdadeiro se a data do obj e maior que a passada
      $iBase = $this->GetIDataYYYYMMDD();
      $iValor = $valor->GetIDataYYYYMMDD();
	  if ($iBase > $iValor)
      { return TRUE;
	  }
      else
      { return FALSE;
	  }
    }
    public function ValidaData()
    { if (($this->iMes > 12) or ($this->iMes <=0)) 
      { return "Mês Inválido";
	  }
      else
      { if ($this->iAno < 0) 
        { return "Ano Inválido";
        }
        else
        { if (($this->iDia <= 0) or ($this->iDia > 31))
          { return "Dia Inválido";
          }  
          else
          { return ValidaUltimoDia();
          }
        }
      }
    }
    private function ValidaUltimoDia()
    {
      $Limite = 31;
      if (($this->iMes = 4) or ($this->iMes = 6) or ($this->iMes = 9) or 
        ($this->iMes = 11))
      { $Limite = 30;
	  }
	  else
	  if ($this->iMes = 2)
	  { if (($this->iAno %4) == 0)
	    { $Limite = 29;
	    }
	    else
	    { $Limite = 28;
	    }
	  }
	  if ($this->iDia > $Limite)
	  { return "Dia Inválido";
      }
	  else
	  { return ''; //tudo ok
      }
    }
  }
?>
