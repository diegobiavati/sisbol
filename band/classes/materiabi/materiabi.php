<?php
  class MateriaBi
  { //propriedades privadas
    private $codigo;
    private $data;
    private $tipoDoc;
    private $assuntoEspec;
    private $assuntoGeral;
    private $textoAbert;
    private $textoFech;
    private $nrDocumento;
    private $vaiAltr;
    private $aprovada;
    private $descrAssEsp;
    private $descrAssGer;
    private $dataDoc;
    private $tipoBol;
    private $pagina;
    private $usuario;
    private $codom;
    private $codSubun;
    private $ord_mat;
    private $militarAss;
    private $mostraRef;
    private $textoFechVaiAltr;
	private $textoComentario;
	private $codMateriaBI;

    public function MateriaBi($data, $assuntoEspec, $assuntoGeral, $tipoDoc, $dataDoc, $colPessoaMateriaBi2, $tipoBol, $militarAss)
    { 
      $this->data = $data;
	  $this->assuntoEspec = $assuntoEspec;
      $this->assuntoGeral = $assuntoGeral;
      $this->tipoDoc = $tipoDoc;
      $this->dataDoc = $dataDoc;
      $this->colPessoaMateriaBi2 = $colPessoaMateriaBi2;
      $this->tipoBol = $tipoBol;
      $this->militarAss = $militarAss;
    }
    //funcoes de acesso-get
    public function getCodigo()
    { return $this->codigo;
    }
    public function getData()
    { return $this->data;
    }
    public function getTipoDoc()
    { return $this->tipoDoc;
    }
    public function getAssuntoEspec()
    { return $this->assuntoEspec;
    }
    public function getAssuntoGeral()
    { return $this->assuntoGeral;
    }
    public function getTextoAbert()
    { return $this->textoAbert;
    }
    public function getTextoFech()
    { return $this->textoFech;
    }
    public function getNrDocumento()
    { return $this->nrDocumento;
    }
    public function getVaiAltr()
    { return $this->vaiAltr;
    }
    public function getAprovada()
    { return $this->aprovada;
    }
    public function getDescrAssEsp()
    { return $this->descrAssEsp;
    }
    public function getDescrAssGer()
    { return $this->descrAssGer;
    }
    public function getDataDoc()
    { return $this->dataDoc;
    }
    public function getColPessoaMateriaBi2()
    { return $this->colPessoaMateriaBi2;
    }
    public function getTipoBol()
    { return $this->tipoBol;
    }
    public function getPagina()
    { return $this->pagina;
    }
    public function getUsuario()
    { return $this->usuario;
    }
    public function getCodom()
    { return $this->codom;
    }
    public function getCodSubun()
    { return $this->codSubun;
    }
    public function getOrd_mat()
    { return $this->ord_mat;
    }
    public function getMilitarAss()
    { return $this->militarAss;
    }
    public function getMostraRef()
    { return $this->mostraRef;
    }
    public function getTextoFechVaiAltr()
    { return $this->textoFechVaiAltr;
    }
	 public function getTextoComentario()
    { return $this->textoComentario;
    }
	public function getCodMateriaBI()
    { return $this->codMateriaBI;
    }
    //funcoes de acesso set
    public function setCodigo($valor)
    { $this->codigo = $valor;
    }
    public function setData($valor)
    { $this->data = $valor;
    }
    public function setTipoDoc($valor)
    { $this->tipoDoc = $valor;
    }
    public function setAssuntoEspec($valor)
    { $this->assuntoEspec = $valor;
    }
    public function setAssuntoGeral($valor)
    { $this->assuntoGeral = $valor;
    }
    public function setTextoAbert($valor)
    { $this->textoAbert = $valor;
    }
    public function setTextoFech($valor)
    { $this->textoFech = $valor;
    }
    public function setNrDocumento($valor)
    { $this->nrDocumento = $valor;
    }
    public function setVaiAltr($valor)
    { $this->vaiAltr = $valor;
    }
    public function setAprovada($valor)
    { $this->aprovada = $valor;
    }
    public function setDescrAssEsp($valor)
    { $this->descrAssEsp = $valor;
    }
    public function setDescrAssGer($valor)
    { $this->descrAssGer = $valor;
    }
    public function setDataDoc($valor)
    { $this->dataDoc = $valor;
    }
    public function setColPessoaMateriaBi2($valor)
    { $this->colPessoaMateriaBi2 = $valor;
    }
    public function setTipoBol($valor)
    { $this->tipoBol = $valor;
    }
    public function setPagina($valor)
    { $this->pagina = $valor;
    }
    public function setUsuario($valor)
    { $this->usuario = $valor;
    }
    public function setCodom($valor)
    { $this->codom = $valor;
    }
    public function setCodSubun($valor)
    { $this->codSubun = $valor;
    }
    public function setOrd_mat($valor)
    { $this->ord_mat = $valor;
    }
    public function setMilitarAss($militarAss)
    { $this->militarAss = $militarAss;
    }
    public function setMostraRef($valor)
    { $this->mostraRef = $valor;
    }
    public function setTextoFechVaiAltr($valor)
    { $this->textoFechVaiAltr = $valor;
    }
	// Função para inserir comentário nas NBI - Sgt Bedin
	 public function setTextoComentario($valor)
    { $this->textoComentario = $valor;
    }
	//
	public function setCodMateriaBI($valor)
    { $this->codMateriaBI = $valor;
    }
    public function exibeDados()
    { echo 'Codigo= ' . $this->codigo . ' textoAbert ' . $this->textoAbert . ' textoFech ' . $this->textoFech;
    }
  }
?>
