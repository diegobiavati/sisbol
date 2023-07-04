<?php
  class QM
  { //propriedades privadas
    private $cod;
    private $descricao;
	private $abreviacao; //bedin
    
    //construtor
    public function QM()
    {
    }
    //funcoes de acesso-get
    public function getCod()
    { return $this->cod;
    }
    public function getDescricao()
    { return $this->descricao;
    }
	public function getAbreviacao() //bedin
    { return $this->abreviacao;
    }
    
    //funcoes de acesso set
    public function setCod($valor)
    { $this->cod = $valor;
    }
    public function setDescricao($valor)
    { $this->descricao = $valor;
    }
     public function setAbreviacao($valor) //bedin
    { $this->abreviacao = $valor;
    }
    public function exibeDados()
    { echo 'Codigo QM= ' . $this->cod . ' Descricao= ' . $this->descricao . ' Abreviacao= ' . $this->abreviacao; //bedin
    }
  }
?>
