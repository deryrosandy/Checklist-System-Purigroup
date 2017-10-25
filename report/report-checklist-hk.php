<?php
	session_start();
	include '../core/helper/myHelper.php';
	
	$sub_id = $_POST['sub-area'];
	$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
	//$to_date =  date('Y/m/d', strtotime($_POST['to_date']));
	
	
	if (!empty($_SESSION['username']) AND !empty($_SESSION['password'])) {
		
		require_once("../assets/pdf/fpdf/fpdf.php");
	
		$time_now 	=  date('Y-m-d H:i:s');
		
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
	
	public function rptDetailData (){
		
		include '../core/init.php';
		
		$branch = $db->branch()
				->where("id", $_SESSION['branch_id'])
				->fetch();
		
		$divisi = $db->divisi()
				->where("id", $_SESSION['divisi_id'])
				->fetch();
		
		$sub_id = $_POST['sub-area'];
		$user_id = $_SESSION['id'];
		
		$link = mysqli_connect('localhost', 'root', 'ilovejkt48', 'checklist_system_db');
		
		$query_user = "select * FROM users WHERE id='$user_id'";
		$sql = mysqli_query($link, $query_user);
		$user =mysqli_fetch_assoc($sql);
		
		$name = ($user['first_name'] . ' ' . $user['last_name']);
		
		$query = "Select name FROM item_area
				WHERE id='$sub_id'";
				
		$sql = mysqli_query($link, $query);
		$area =mysqli_fetch_assoc($sql);

		$time_now 	=  date('Y-m-d H:i:s');
		$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
				
		$border = 0;
		$this->AddPage();
		$this->SetAutoPageBreak(true,60);
		$this->AliasNbPages();
		$left = 60;
		
		//header
		$this->SetFont("", "B", 13);
		$this->SetX($left); $this->Cell(0, 13, 'CHECK LIST ' . strtoupper($area['name']), 0, 1,'C');
		$this->SetFont("", "", 10);
		$this->Ln(40);
		
		$this->SetFont('Arial','',10);
		$this->SetX($left);
		$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
		$this->SetX($left);
		$this->Cell(0, 12, 'Divisi 	     : House Keeping', 0, 1,'L');
		$this->SetX(59.6);
		$this->Cell(0, 12, 'Tanggal   : '. tgl_indo($from_date), 0, 1,'L');
		$this->Ln(5);
		$h = 24;
		$left = 60;
		$top = 90;	
		$this->SetX($left);
		$this->SetFont('Arial','B',10);
		#tableheader
		$this->SetFillColor(200,200,200);	
		$left = $this->GetX();
		
		$this->Cell(25,$h,'No.',1,0,'C',true);
		$this->SetX($left += 25); $this->Cell(180,$h,'Perlengkapan & Pekerjaan',1,0,'C',true);
		$this->SetX($left += 180); $this->Cell(70,$h,'Status',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(80,$h,'Kondisi',1,0,'C',true);
		$this->SetX($left += 80); $this->Cell(70,$h,'Fungsi',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(180,$h,'Keterangan',1,0,'C',true);
		$this->SetX($left += 180); $this->Cell(220,$h,'Catatan / Koreksi',1,0,'C',true);
		$this->SetY(146.4);

		$this->SetFont('Arial','',9);
		$this->SetWidths(array(25,180,70,80,70,180,220));
		$this->SetAligns(array('C','L','C','C','C','L','L'));
		
		
		$no = 1; $this->SetFillColor(255);
		
		foreach ($this->data as $baris) {
			$left = 60;
			$this->SetX($left);
		
			$this->Row(
				array($no++, 
				$baris['item_name'], 
				$baris['kondisi'], 
				$baris['kondisi'], 
				$baris['fungsi'], 
				$baris['description'],
				$baris['comments'],
			));
		}
		
		
	//header
		$this->SetFont("", "B", 9);
		$this->Ln(20);
		//$this->SetX($left);
		$left = 50;
		//$this->Cell(0, 0, " ", "B");
		
		$this->SetX($left += 0); $this->Cell(200,$h,'Dibuat Oleh',0,0,'C',true);
		$this->SetX($left += 200); $this->Cell(200,$h,'Diperiksa I,',0,0,'C',true);
		$this->SetX($left += 200); $this->Cell(200,$h,'Diperiksa II,',0,0,'C',true);
		$this->SetX($left += 200); $this->Cell(200,$h,'Diperiksa III,',0,1,'C',true);
		$this->Ln(40);
		$left = 50;
		$this->SetX($left += 0); $this->Cell(200,$h,'( Staff )',0,0,'C',true);
		$this->SetX($left += 200); $this->Cell(200,$h,'( Leader )',0,0,'C',true);
		$this->SetX($left += 200); $this->Cell(200,$h,'( Supervisor )',0,0,'C',true);
		$this->SetX($left += 200); $this->Cell(200,$h,'( Pimpinan Outlet )',0,1,'C',true);
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
	    $this->SetFont("arial", "B", 10);
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
		$h=18*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++){
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,18,$data[$i],0,$a);
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

	function NbLines($w,$txt){
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
		while($i<$nb){
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
		
		//$checklist = $db->item_checklist();
		
		$area_id = $sub_id;
		
		$link = mysqli_connect('localhost', 'root', 'ilovejkt48', 'checklist_system_db');
		
		$data = array();
		
		$query = "Select	b.name as kondisi,
							d.`name` as fungsi,
							c.item_name,
							a.item_status_id,
							a.item_fungsi_id,
							a.item_id,
							a.description,
							e.description as comments

					From item_checklist a
					Left Join item_fungsi d
					On d.id = a.item_fungsi_id
					Left Join comments e
					On a.id = e.item_checklist_id
					Left Join item_status b
					On a.item_status_id = b.id
					Left Join item c
					On a.item_id = c.id

					WHERE c.item_area_id='$id_area' AND Convert(a.checked_at, date) Between '$from_date' AND '$from_date'
					GROUP BY c.id;";
		
			$sql = mysqli_query($link, $query);
			while($row =mysqli_fetch_assoc($sql)){
				array_push($data, $row);
			}
			
	//pilihan
	//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($time_now) . '.pdf';
	$filename = 'report_checklist_hk_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
	
	$options = array(
		'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
		'destinationfile' => 'I', //I=inline browser (default), F=local file, D=download
		'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
		'orientation'=>'L' //orientation: P=portrait, L=landscape
	);
	
	$tabel = new FPDF_AutoWrapTable($data, $options);
	$tabel->printPDF();
}
?>