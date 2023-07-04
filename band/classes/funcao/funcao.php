<?php
  class Funcao
  { //propriedades privadas
    private $cod;
    private $descricao;
    private $assinaBI;
    private $assinaConfere;
    private $assinaAlt;
    private $assinaNota;
    private $assinaPubliquese;
    private $dataAtualiz;
    
    //construtor
    public function Funcao()
    {
    }
    //funcoes de acesso-get
    public function getCod()
    { return $this->cod;
    }
    public function getDescricao()
    { return $this->descricao;
    }
    public function getAssinaBI()
    { return $this->assinaBI;
    }
    public function getAssinaConfere()
    { return $this->assinaConfere;
    }
    public function getAssinaAlt()
    { return $this->assinaAlt;
    }
    public function getAssinaNota()
    { return $this->assinaNota;
    }
    public function getAssinaPubliquese()
    { return $this->assinaPubliquese;
    }
    
    public function getDataAtualiz()
    { return $this->dataAtualiz;
    }
    
    //funcoes de acesso set
    public function setCod($valor)
    { $this->cod = $valor;
    }
    public function setDescricao($valor)
    { $this->descricao = $valor;
    }
    public function setAssinaBI($valor)
    { $this->assinaBI = $valor;
    }
    public function setAssinaConfere($valor)
    { $this->assinaConfere = $valor;
    }
    public function setAssinaAlt($valor)
    { $this->assinaAlt = $valor;
    }
    public function setAssinaNota($valor)
    { $this->assinaNota = $valor;
    }
    public function setAssinaPubliquese($valor)
    { $this->assinaPubliquese = $valor;
    }
    public function setDataAtualiz($valor)
    { $this->dataAtualiz = $valor;
    }
    
    public function exibeDados()
    { echo 'Codigo Função = ' . $this->cod . ' Descrição = ' . $this->descricao . ' Assina BI? = ' . $this->assinaBI . ' Assina confere = ' .
							$this->assinaConfere;
    }
  }
?>
