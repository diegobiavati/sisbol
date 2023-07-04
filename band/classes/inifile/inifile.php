<?php
  class IniFile
  { //private $arquivo;
    //private $vetor;
    private $vetorPesquisa;
    private $arqEncontrado;
    private $arquivo;
	public function IniFile($arquivo)
    { 
	  $this->arqEncontrado = false;
	  $this->arquivo = $arquivo;	
		//le o arquivo e coloca num vetor
      if (file_exists($arquivo)){
			$vetor = file($arquivo);
      		$numerolinhas = count($vetor);
      		for ($i=0;$i<$numerolinhas;$i++){ 
			  	$line=explode('=',$vetor[$i]);
        		$this->vetorPesquisa[$line[0]] = trim($line[1]);
      		}
      		$this->arqEncontrado = true;
      }
    }
    public function lerChave($chave)
    { return $this->vetorPesquisa[$chave];
    }
    
    public function escreverChave($valor)
    { file_put_contents($this->arquivo,$valor);
    }
       
    public function arqEncontrado()
    { return $this->arqEncontrado;
    }
    
  }
?>
