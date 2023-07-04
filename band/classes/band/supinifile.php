<?php
  class SupIniFile
  { private $iniFile;
    //private $vetor;
    public function SupIniFile($iniFile)
    { $this->iniFile = $iniFile;
    }
    public function getPassword()
    { return $this->iniFile->lerChave('supersenha');
    }
    
    public function apagarChave($valor)
    { $this->iniFile->escreverChave($valor);
    }
    
  }
?>
