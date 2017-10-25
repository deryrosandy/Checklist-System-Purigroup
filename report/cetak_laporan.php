<?php
	session_start();
	include '../core/helper/myHelper.php';
	
	if (!empty($_SESSION['username']) AND !empty($_SESSION['password'])) {
	
		include '../core/init.php';
		
		require_once("../assets/pdf/fpdf/fpdf.php");

class FPDF_AutoWrapTable extends FPDF {
  	private $data = array();
  	private $options = array(
  		'filename' => '',
  		'destinationfile' => '',
  		'paper_size'=>'A4',
  		'orientation'=>'L'
  	);
  	
  	function __construct($data = array(), $options = array()) {
    	parent::__construct();
    	$this->data = $data;
    	$this->options = $options;
	}
	
	public function rptDetailData () {
		//
		$border = 0;
		$this->AddPage();
		$this->SetAutoPageBreak(true,60);
		$this->AliasNbPages();
		$left = 25;
		
		//header
		$this->SetFont("", "B", 15);
		$this->SetX($left); $this->Cell(0, 12, 'CHECK LIST SUB. SEKSI LOKER', 0, 1,'C');
		//$this->Cell(0, 0, " ", "B");
		$this->Ln(30);
		
		$this->SetFont('Arial','B',12);
		$this->SetX($left); $this->Cell(0, 10, 'TANGGAL  :', 0, 1,'L');
		$this->Ln(5);
		$h = 24;
		$left = 40;
		$top = 80;	
		
		$this->SetFont('Arial','B',10);
		#tableheader
		$this->SetFillColor(200,200,200);	
		$left = $this->GetX();
		
		//$this->SetX($left += 20); $this->Cell(75, $h, 'NIP', 1, 0, 'C',true);
		$this->Cell(20,$h,'No.',1,0,'C',true);
		$this->SetX($left += 20); $this->Cell(180,$h,'Perlengkapan & Pekerjaan',1,0,'C',true);
		$this->SetX($left += 180); $this->Cell(80,$h,'Kondisi',1,0,'C',true);
		$this->SetX($left += 80); $this->Cell(80,$h,'Fungsi',1,0,'C',true);
		$this->SetX($left += 80); $this->Cell(180,$h,'Keterangan',1,0,'C',true);
		$this->SetY(109.2);

		$this->SetFont('Arial','',9);
		$this->SetWidths(array(20,180,80,80,180));
		$this->SetAligns(array('C','L','C','C','L'));
		
		$no = 1; $this->SetFillColor(255);
		
		foreach ($this->data as $baris) {
			$this->Row(
				array($no++, 
				$baris['item_name'], 
				$baris['kondisi'], 
				$baris['fungsi'], 
				$baris['description'],
			));
		}
	}

	public function printPDF () {
				
		if ($this->options['paper_size'] == "A4") {
			$a = 8.3 * 72; //1 inch = 72 pt
			$b = 13.0 * 72;
			$this->FPDF($this->options['orientation'], "pt", array($a,$b));
		} else {
			$this->FPDF($this->options['orientation'], "pt", $this->options['paper_size']);
		}
		
	    $this->SetAutoPageBreak(false);
	    $this->AliasNbPages();
	    $this->SetFont("helvetica", "B", 10);
	    //$this->AddPage();
	
	    $this->rptDetailData();
			    
	    $this->Output($this->options['filename'],$this->options['destinationfile']);
  	}
  	
  	
  	
  	private $widths;
	private $aligns;

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=14*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,14,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}
} //end of class
		
		$checklist = $db->item_checklist();
		
		
		$area_id = "7";
		
		mysql_connect("localhost","root","");
		mysql_select_db("projects_db");
		
		$data = array();
		
		$query = "Select	b.`name` as kondisi,
				d.`name` as fungsi,
				c.item_name,
				a.item_status_id,
				a.item_fungsi_id,
				a.item_id,
				a.description

			From item_checklist a
			Left Join item_fungsi d
			On d.id = a.item_fungsi_id
			Left Join item_status b
			On a.item_status_id = b.id
			Left Join item c
			On a.item_id = c.id


			WHERE c.item_area_id = $area_id
			GROUP BY c.id;";
		
		$sql = mysql_query($query);
		while($row =mysql_fetch_assoc($sql)){
			array_push($data, $row);
		}

		
//pilihan
$options = array(
	'filename' => 'report_daftar_services.pdf', //nama file penyimpanan, kosongkan jika output ke browser
	'destinationfile' => 'I', //I=inline browser (default), F=local file, D=download
	'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
	'orientation'=>'P' //orientation: P=portrait, L=landscape
);

$tabel = new FPDF_AutoWrapTable($data, $options);
$tabel->printPDF();

}
?>