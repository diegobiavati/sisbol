<?php
  class ColAssinaConfereBi implements ICOLAssinaConfereBi
  { private $db;
    public function ColAssinaConfereBi($db)
    { $this->db = $db;
    }
    public function incluirRegistro($assinaConfereBi)//alterado
    { $q = "insert into assina_confere_bi (codigo, pgrad_confere, pgrad_assina, militar_confere, militar_assina, funcao_confere, funcao_assina)";
	  $q = $q . " values (" . $assinaConfereBi->getCodigo() . "," . $assinaConfereBi->getMilitarConfere()->getPGrad()->getCodigo() . ",";
	  $q = $q . $assinaConfereBi->getMilitarAssina()->getPGrad()->getCodigo() . ",'" ;
	  $q = $q . $assinaConfereBi->getMilitarConfere()->getIdMilitar() . "','" ;
	  $q = $q . $assinaConfereBi->getMilitarAssina()->getIdMilitar() . "'," ;
	  $q = $q . $assinaConfereBi->getMilitarConfere()->getFuncao()->getCod() . "," ;
	  $q = $q . $assinaConfereBi->getMilitarAssina()->getFuncao()->getCod() . ")";
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLASSINACONFEREBI->Registro não Incluido');
	  }
    }
    public function lerRegistro($codMilitarAssina, $codPGradMilitarAssina, $codFuncaoMilitarAssina, $codMilitarConfere, 
	  $codPGradMilitarConfere, $codFuncaoMilitarConfere)//alterado
    { $q = "select  codigo, pgrad_confere, pgrad_assina, militar_confere, militar_assina, funcao_confere, funcao_assina";
	  $q = $q . " from assina_confere_bi where  militar_assina = '" . $codMilitarAssina . "' and militar_confere = '";
	  $q = $q . $codMilitarConfere . "' and ";
	  $q = $q . " funcao_assina = " . $codFuncaoMilitarAssina . " and funcao_confere = " . $codFuncaoMilitarConfere . " and ";
	  $q = $q . " pgrad_assina = " . $codPGradMilitarAssina . " and pgrad_confere = " . $codPGradMilitarConfere;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $militarAssina = new Militar(new PGrad(), null, new Funcao(), null, null,null);
        $militarConfere = new Militar(new PGrad(), null, new Funcao(), null, null,null);
        $assinaConfereBi = new AssinaConfereBi($militarAssina, $militarConfere);
        $row = mysqli_fetch_array($result);
        $assinaConfereBi->setCodigo($row['codigo']);
        $assinaConfereBi->getMilitarAssina()->setIdMilitar($row['militar_assina']);
        $assinaConfereBi->getMilitarConfere()->setIdMilitar($row['militar_confere']);
        $assinaConfereBi->getMilitarAssina()->getPGrad()->setCodigo($row['pgrad_assina']);
        $assinaConfereBi->getMilitarConfere()->getPGrad()->setCodigo($row['pgrad_confere']);
        $assinaConfereBi->getMilitarAssina()->getFuncao()->setCod($row['funcao_assina']);
        $assinaConfereBi->getMilitarConfere()->getFuncao()->setCod($row['funcao_confere']);
        return $assinaConfereBi;
	  }
    }
    public function lerPorCodigo($codigo)
    { $q = "select  codigo, pgrad_confere, pgrad_assina, militar_confere, militar_assina, funcao_confere, funcao_assina";
	  $q = $q . " from assina_confere_bi where  codigo = " . $codigo;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $militarAssina = new Militar(new PGrad(), null, new Funcao(), null, null,null);
        $militarConfere = new Militar(new PGrad(), null, new Funcao(), null, null,null);
        $assinaConfereBi = new AssinaConfereBi($militarAssina, $militarConfere);
        $row = mysqli_fetch_array($result);
        $assinaConfereBi->setCodigo($row['codigo']);
        $assinaConfereBi->getMilitarAssina()->setIdMilitar($row['militar_assina']);
        $assinaConfereBi->getMilitarConfere()->setIdMilitar($row['militar_confere']);
        $assinaConfereBi->getMilitarAssina()->getPGrad()->setCodigo($row['pgrad_assina']);
        $assinaConfereBi->getMilitarConfere()->getPGrad()->setCodigo($row['pgrad_confere']);
        $assinaConfereBi->getMilitarAssina()->getFuncao()->setCod($row['funcao_assina']);
        $assinaConfereBi->getMilitarConfere()->getFuncao()->setCod($row['funcao_confere']);
        return $assinaConfereBi;
      }
    }
    public function getProximoCodigo()
    { $q = "select max(codigo) as ultimo from assina_confere_bi";
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return 1;
	  }
	  else
	  { $row = mysqli_fetch_array($result);
        $proximo = $row['ultimo'];
        if ($proximo == null)
        {  return 1;
        }
        else
        { return $proximo + 1;
        }
      }    
    }
    
  }
?>
