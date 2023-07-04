<?php
class MeuPDFListas extends FPDF {
	private $cabec;
	private $tabela;
	private $largPag;
	public function MeuPDFListas($orientation = 'P', $unit = 'mm', $format = 'A4', $cabec, $tabela) {
		FPDF :: FPDF($orientation, $unit, $format);
		$this->cabec = $cabec;
		$this->tabela = $tabela;
		if ($orientation == 'P') {
			$this->largPag = 180;
		} else {
			$this->largPag = 260;
		}
	}
	function Footer() {
		//Vai para 1.5 cm da borda inferior
		$this->SetLeftMargin(20);
		$this->SetY(-15);
		$this->SetFont('Times', 'I', 12);
		$this->Cell($this->largPag / 2, 5, 'Sistema de Boletim (SisBol)', "T", 0, 'L');
		$this->Cell($this->largPag / 2, 5, 'Página ' . $this->PageNo(), "T", 0, 'R');
	}
	function Header() {
		$this->SetFont('Times', 'B', 12);
		$this->SetY(19);
		if ($this->PageNo() == 1) {
			$this->SetY(10);
			$this->Cell($this->largPag, 5, $this->cabec, 0, 1, 'C');
			if ($this->tabela != null) {
				$this->SetY(19);
				for ($i = 0; $i <= count($this->tabela) - 1; $i++) {
					$this->Cell($this->tabela[$i][2], 5, $this->tabela[$i][1], 1, 0, 'C');
				}
				$this->SetY(24);
			}
		} else {
			if ($this->tabela != null) {
				//	    	$this->SetY(17);
				for ($i = 0; $i <= count($this->tabela) - 1; $i++) {
					$this->Cell($this->tabela[$i][2], 5, $this->tabela[$i][1], 1, 0, 'C');
				}
				$this->SetY(24);
			}
		}
	}
}
?>
