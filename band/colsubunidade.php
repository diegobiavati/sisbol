<?php

class ColSubunidade implements IColSubunidade {

    private $db;

    public function ColSubunidade($db) {
        $this->db = $db;
    }

    public function incluirRegistro($omVinc, $subun) {
        $q = "insert into subunidade (codom, cod, descricao, sigla) values ('" . $omVinc->getCodOM();
        $q = $q . "', " . $subun->getCod() . ",'" . $subun->getDescricao() . "','" . $subun->getSigla() . "')";
//      echo $q;
        $result = mysqli_query($this->db, $q);
        $num_rows = mysqli_affected_rows($this->db);
        if ($num_rows <= 0) {
            throw new Exception('Registro não Incluido');
            /* throw new Exception('COLSUBUNIDADE->Registro não Incluido'); texto antigo */
        }
    }

    public function alterarRegistro($omVinc, $subun) {
        $q = "update subunidade set ";
        $q = $q . "descricao = '" . $subun->getDescricao() . "',";
        $q = $q . "sigla = '" . $subun->getSigla() . "',";
        $q = $q . "data_atualiz = now()";
        $q = $q . " where codom = '" . $omVinc->getCodOM() . "' and cod = " .
                $subun->getCod();
        $result = mysqli_query($this->db, $q);
        $num_rows = mysqli_affected_rows($this->db);
        if ($num_rows <= 0) {
            throw new Exception('Registro não alterado');
            /* throw new Exception('COLSUBUNIDADE->Registro não alterado'); texto antigo */
        }
    }

    public function excluirRegistro($omVinc, $subun) {
        /* PARREIRA E WATANABE 05-06-2013 - validando exclusao de subunidade com militares cadastrados*/
        $val = "SELECT count(*) AS totalm FROM pessoa WHERE cod_subun =" . $subun->getCod();
        $result = mysqli_query($this->db, $val);
        
        
        $row = mysqli_fetch_array($result);
        $totalmil = $row['totalm'];
        
        
        if ($totalmil > 0) {
            throw new Exception('Existem pessoas alocadas à subunidade');
            /* throw new Exception('COLSUBUNIDADE->Existem pessoas alocadas à subunidade'); */
        }
        else {
                $q = "delete from subunidade";
                $q = $q . " where codom = '" . $omVinc->getCodOM() . "' and cod = " .
                $subun->getCod();
                $result = mysqli_query($this->db, $q);
                $num_rows = mysqli_affected_rows($this->db);
                if ($num_rows <= 0)
                { throw new Exception('Registro não excluído');
                /* { throw new Exception('COLSUBUNIDADE->Registro não excluído'); */
                }
        }
        

        /* antigo 05-06-2013
          $q = "delete from subunidade";
          $q = $q . " where codom = '" . $omVinc->getCodOM() . "' and cod = " .
          $subun->getCod() . "' and pessoa.cod_subun != " . $subun->getCod();
          //$subun->getCod();
          // echo $q;
         
          $result = mysqli_query($this->db, $q);
          $num_rows = mysqli_affected_rows($this->db);
          if ($num_rows <= 0)
          { throw new Exception('COLSUBUNIDADE->Registro não excluído');
          }


         */
    }

    public function lerRegistro($codom, $codSubun) {
        $q = "select * from subunidade ";
        $q = $q . " where codom = '" . $codom . "' and cod = " . $codSubun;
        //echo $q;
        $result = mysqli_query($this->db, $q);
        if (mysqli_num_rows($result) <= 0) {
            return null;
        } else {
            $subunidade = new Subunidade();

            $row = mysqli_fetch_array($result);
            $subunidade->setCod($row['cod']);
            $subunidade->setDescricao($row['descricao']);
            $subunidade->setSigla($row['sigla']);
            //print_r($subunidade);
            return $subunidade;
        }
    }

    public function lerColecao($codom) {
        $q = "select * from subunidade ";
        $q = $q . " where codom = '" . $codom . "'";
        //echo $q;
        $result = mysqli_query($this->db, $q);
        $num_rows = mysqli_num_rows($result);
        $colSubunidade2 = new ColSubunidade2();
        for ($i = 0; $i < $num_rows; $i++) {
            $row = mysqli_fetch_array($result);
            $subunidade = new Subunidade();
            $subunidade->setCod($row['cod']);
            $subunidade->setDescricao($row['descricao']);
            $subunidade->setSigla($row['sigla']);
            $colSubunidade2->incluirRegistro($subunidade);
        }
        return $colSubunidade2;
    }

}

?>
