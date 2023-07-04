<?php
  interface IColMateriaBi
  { public function incluirRegistro($materiaBi, $boletim);
    public function setaOrdem($codMateria, $ordemMateria);
    public function alterarRegistro($materiaBi, $boletim);
	// Chamar função para inserir comentário nas NBI - Sgt Bedin
	public function alterarComentario($codMateriaBI, $textoComentario);
	//
    public function excluirRegistro($materiaBi);
    public function lerRegistro($codMateriaBi);
    public function lerColecao($codBi, $numeroParte, $numeroSecao);
    public function lerColecao2($codTipoBol, $aprovada, $order, $incluidaEmBI, $codom, $codSubun, $todasOmVinc, $todasSubun);
    public function lerColecao3($codBoletim, $order);
    public function lerBoletimQuePublicou($codMateriaBi);
    public function getProximoCodigo();
  }
?>
