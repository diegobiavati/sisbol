<?php
  class RgrUsuario
  { private $colUsuario;
    public function RgrUsuario($colUsuario)
    { $this->colUsuario = $colUsuario;
    }
    private function consisteDados($usuario, $oper)
    { 
      if ($usuario->getLogin() == '')
      { throw new Exception('Login inválido!');
      }
      if ($usuario->getSenha() == '')
      { throw new Exception('Senha inválida!');
      }
    }
    public function incluirRegistro($usuario)
    { $this->consisteDados($usuario, 'I');
	  $this->colUsuario->incluirRegistro($usuario);
    }
    public function alterarRegistro($usuario)
    { $this->consisteDados($usuario, 'A');
	  $this->colUsuario->alterarRegistro($usuario);
    }
    public function excluirRegistro($usuario)
    { $this->colUsuario->excluirRegistro($usuario);
    }
    public function lerRegistro($login)
    { return $this->colUsuario->lerRegistro($login);
    }
    public function lerColecao()
    {  return $this->colUsuario->lerColecao();
    }
//
  }
?>
