<?php
  class BandIniFile
  { private $iniFile;
    //private $vetor;
    public function BandIniFile($iniFile)
    { $this->iniFile = $iniFile;
    }
    public function getBackupFileName()
    { return $this->iniFile->lerChave('backupfilename');
    }
    public function getBackupCommand()
    { return $this->iniFile->lerChave('backupcommand');
    }
    public function getRestoreCommand()
    { return $this->iniFile->lerChave('restorecommand');
    }
    public function getDeleteCommand()
    { return $this->iniFile->lerChave('deletecommand');
    }
    public function getFPDFFontDir()
    { return $this->iniFile->lerChave('fpdffontdir');
    }
    public function getOutPutAltDir()
    { return $this->iniFile->lerChave('outputaltdir');
    }
    public function getOutPutBolDir()
    { return $this->iniFile->lerChave('outputboldir');
    }
    public function getBrasaoDir()
    { return $this->iniFile->lerChave('brasaodir');
    }
    public function getBackupDir()
    { return $this->iniFile->lerChave('backupdir');
    }
    public function getUsuario()
    { return $this->iniFile->lerChave('user');
    }
    public function getHost()
    { return $this->iniFile->lerChave('host');
    }
    public function getPassword()
    { return $this->iniFile->lerChave('password');
    }
    public function getDatabase()
    { return $this->iniFile->lerChave('database');
    }
    public function getOutPutFicDir()
    { return $this->iniFile->lerChave('outputficdir');
    }
    public function getImportDir()
    { return $this->iniFile->lerChave('importdir');
    }
    public function getImportBackupDir()
    { return $this->iniFile->lerChave('importbackupdir');
    }
    public function getVersao()
    { return $this->iniFile->lerChave('versao');
    }
    public function getOutPutNotaBiDir()
    { return $this->iniFile->lerChave('outputnotabidir');
    }
    public function getAssinaturaDir()
    { return $this->iniFile->lerChave('assinaturadir');
    }
  }
?>
