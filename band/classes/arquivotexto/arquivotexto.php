<?php
  class ArquivoTexto
  { //propriedades privadas
    private $fp;
    private $fileName;
    //construtor
    public function ArquivoTexto($fileName)
    { $this->fileName = $fileName;
    }
    public function Open($modo)
    { $this->fp = fopen($this->fileName, $modo);
    }
    public function Close()
    { fclose($this->fp);
    }
    public function IncluirTexto($texto)
    { fwrite($this->fp, $texto);
    }
    public function LerArquivo()
    { readFile($this->fileName);
    }
  }
?>
