<?php
	session_start();
	include '../core/helper/myHelper.php';
	
	$sub_id = $_POST['sub-area'];
	$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
	//$to_date =  date('Y/m/d', strtotime($_POST['to_date']));
	
	if (!empty($_SESSION['username']) AND !empty($_SESSION['password'])) {
	
		// Set Template PDF Berdasarkan SUb Area
		//Jika Checklist Vichy Shower
	if($sub_id == 11){
		
		require_once("../assets/pdf/fpdf/fpdf.php");
	
		$time_now 	=  date('Y-m-d H:i:s');
		$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
		
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
		
		$area_id = $_POST['sub-area'];
		$user_id = $_SESSION['id'];
		
		$link = mysqli_connect('localhost', 'root', 'ilovejkt48', 'checklist_system_db');
		
		$query_user = "select * FROM users WHERE id='$user_id'";
		$sql = mysqli_query($link, $query_user);
		$user =mysqli_fetch_assoc($sql);
		
		$name = ($user['first_name'] . ' ' . $user['last_name']);
		
		$query = "Select name FROM item_area
				WHERE id='$area_id'";
				
		$sql = mysqli_query($link, $query);
		$area =mysqli_fetch_assoc($sql);

		$time_now 	=  date('Y-m-d H:i:s');
		$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
		
		$border = 0;
		$this->AddPage();
		$this->SetAutoPageBreak(true,60);
		$this->AliasNbPages();
		$left = 0;
		
		//header
		$this->SetFont("", "B", 13);
		$this->SetX($left); $this->Cell(0, 13, 'CHECK LIST ' . strtoupper($area['name']), 0, 1,'C');
		$this->SetFont("", "", 10);
		$this->Ln(40);
		
		$left = 60;
		$this->SetFont('Arial','',10);
		$this->SetX($left);
		$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
		$this->SetX($left);
		$this->Cell(0, 12, 'Divisi 	     : Mechanical Engineering', 0, 1,'L');
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
		$this->SetX($left += 25); $this->Cell(240,$h,'Perlengkapan',1,0,'C',true);
		$this->SetX($left += 240); $this->Cell(70,$h,'Pressure',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(80,$h,'Kondisi',1,0,'C',true);
		$this->SetX($left += 80); $this->Cell(70,$h,'Fungsi',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(200,$h,'Keterangan',1,0,'C',true);
		$this->SetY(146.4);

		$this->SetFont('Arial','',9);
		$this->SetWidths(array(25,240,70,80,70,200));
		$this->SetAligns(array('C','L','C','C','C','L'));
		
		
		$no = 1; $this->SetFillColor(255);
		
		foreach ($this->data as $baris) {
			$left = 60;
			$this->SetX($left);
		
			$this->Row(
				array($no++, 
				$baris['item_name'], 
				$baris['pressure'], 
				$baris['kondisi'], 
				$baris['fungsi'], 
				$baris['description']
			));
		}
		
		$this->SetFont("", "B", 9);
		$this->Ln(25);
		$left = 100;
		$h=14;
		
		$this->SetX($left += 0); $this->Cell(450,$h,'Di Kerjakan Oleh',0,1,'L',true);
		$this->SetX($left += 0); $this->Cell(450,$h,'Staff ME :',0,0,'L',true);
		$this->SetX($left += 480); $this->Cell(140,$h,'Mengetahui :',0,1,'C',true);
		
		$left = 110;
		$staffs = $db->users()
					->where("user_type", "operator")
					->where("divisi_id", 2)
					->where("branch_id", $branch['id']);
		$no=1;
		foreach($staffs as $staff){
			$this->SetX($left); $this->Cell(250,$h,$no . '. ' . $staff['first_name'] . ' ' . $staff['last_name'],0,1,'L',true);
		
		$no++;
		}
		$mgr = $db->users()
					->where("user_type", "manager")
					->where("branch_id", $branch['id'])
					->fetch();
		$this->Ln(15);
		$left = 100;
		$this->SetX($left += 480); $this->Cell(140,$h,'( ' . $mgr['first_name'] . ' ' . $mgr['last_name'] . ' )',0,1,'C',true);
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
							a.pressure,
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


					WHERE c.item_area_id = '$area_id' AND Convert(checked_at, date) Between '$from_date' AND '$from_date'
					GROUP BY c.id;";
		
			$sql = mysqli_query($link,$query);
			while($row =mysqli_fetch_assoc($sql)){
				array_push($data, $row);
			}
			
	//pilihan
	//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($from_date) . '.pdf';
	$filename = 'report_checklist_hk_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
	
	$options = array(
		'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
		'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
		'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
		'orientation'=>'L' //orientation: P=portrait, L=landscape
	);
	
	$tabel = new FPDF_AutoWrapTable($data, $options);
	$tabel->printPDF();
	}
	
	//Jika Checklist Panel
	if($sub_id == 12){
		
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
		
		$area_id = $_POST['sub-area'];
		
		$user_id = $_SESSION['id'];
		
		$link = mysqli_connect('localhost', 'root', 'ilovejkt48', 'checklist_system_db');
		
		$query_user = "select * FROM users WHERE id='$user_id'";
		$sql = mysqli_query($link, $query_user);
		$user =mysqli_fetch_assoc($sql);
		
		$name = ($user['first_name'] . ' ' . $user['last_name']);
		
		$query = "Select name FROM item_area
				WHERE id='$area_id'";
				
		$sql = mysqli_query($link, $query);
		$area =mysqli_fetch_assoc($sql);

		$time_now 	=  date('Y-m-d H:i:s');
		$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
		
		$border = 0;
		$this->AddPage();
		$this->SetAutoPageBreak(true,60);
		$this->AliasNbPages();
		$left = 0;
		
		//header
		$this->SetFont("", "B", 13);
		$this->SetX($left); $this->Cell(0, 13, 'CHECK LIST ' . strtoupper($area['name']), 0, 1,'C');
		$this->SetFont("", "", 10);
		$this->Ln(40);
		
		$left = 60;
		$this->SetFont('Arial','',10);
		$this->SetX($left);
		$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
		$this->SetX($left);
		$this->Cell(0, 12, 'Divisi 	     : Mechanical Engineering', 0, 1,'L');
		$this->SetX(59.6);
		$this->Cell(0, 12, 'Periode   : '. tgl_indo($from_date), 0, 1,'L');
		$this->Ln(5);
		$h = 14;
		$left = 60;
		$top = 90;	
		$this->SetX($left);
		$this->SetFont('Arial','B',9);
		#tableheader
		$this->SetFillColor(200,200,200);	
		$left = $this->GetX();
		
		$h = 14*2;
		$this->Cell(25,$h,'No.',1,0,'C',true);
		$this->SetX($left += 25); $this->Cell(180,$h,'Peralatan',1,0,'C',true);
		$h = 14;
		$this->SetX($left += 180); $this->Cell(90,$h,'Tegangan',1,1,'C',true);
		$this->SetX($left += 0); $this->Cell(30,$h,'R',1,0,'C',true);
		$this->SetX($left += 30); $this->Cell(30,$h,'S',1,0,'C',true);
		$this->SetX($left += 30); $this->Cell(30,$h,'T',1,0,'C',true);
		$this->SetY(122.3);
		$this->SetX($left += 30); $this->Cell(90,$h,'Arus',1,1,'C',true);
		$this->SetX($left += 0); $this->Cell(30,$h,'R',1,0,'C',true);
		$this->SetX($left += 30); $this->Cell(30,$h,'S',1,0,'C',true);
		$this->SetX($left += 30); $this->Cell(30,$h,'T',1,0,'C',true);
		$this->SetY(122.3);
		$h = 14*2;
		$this->SetX($left += 30); $this->Cell(60,$h,'Koneksi',1,0,'C',true);
		$this->SetX($left += 60); $this->Cell(60,$h,'Wiring',1,0,'C',true);
		$this->SetX($left += 60); $this->Cell(60,$h,'kondisi',1,0,'C',true);
		$this->SetX($left += 60); $this->Cell(60,$h,'Fungsi',1,0,'C',true);
		$this->SetX($left += 60); $this->Cell(200,$h,'Keterangan',1,0,'C',true);
		$this->SetY(150.4);

		$this->SetFont('Arial','',9);
		$this->SetWidths(array(25,180,30,30,30,30,30,30,60,60,60,60,200));
		$this->SetAligns(array('C','L','C','C','C','C','C','C','C','C','C','C','L'));
		
		
		$no = 1; $this->SetFillColor(255);
		
		foreach ($this->data as $baris) {
			$left = 60;
			$this->SetX($left);
			
			if($baris['koneksi']==1){
				$baris['koneksi'] = 'Ok';
			}else{
				$baris['koneksi'] = '-';
			}
			
			if($baris['wiring']==1){
				$baris['wiring'] = 'Ok';
			}else{
				$baris['wiring'] = '-';
			}
			
			$this->Row(
				array($no++, 
				$baris['item_name'], 
				$baris['tegangan_r'], 
				$baris['tegangan_s'], 
				$baris['tegangan_t'], 
				$baris['arus_r'], 
				$baris['arus_s'], 
				$baris['arus_t'], 
				$baris['koneksi'], 
				$baris['wiring'], 
				$baris['kondisi'], 
				$baris['fungsi'], 
				$baris['description']
			));
		}
		
	
		$this->SetFont("", "B", 9);
		$this->Ln(25);
		$h = 14;
		//$this->Cell(0, 0, " ", "B");
		$left = 150;
		$this->SetX($left += 0); $this->Cell(400,$h,'Di Kerjakan Oleh',0,1,'L',true);
		
		$this->SetX($left += 0); $this->Cell(400,$h,'Staff ME :',0,0,'L',true);
		$this->SetX($left += 540); $this->Cell(140,$h,'Mengetahui :',0,1,'C',true);
		$h=14;
	
		
		$staffs = $db->users()
					->where("user_type", "operator")
					->where("divisi_id", 2)
					->where("branch_id", $branch['id']);
		$left = 155;
		$no=1;
		foreach($staffs as $staff){
			$this->SetX($left); $this->Cell(140,$h,$no . '. ' . $staff['first_name'] . ' ' . $staff['last_name'],0,1,'L',true);
		$no++;
		}
		$mgr = $db->users()
					->where("user_type", "manager")
					->where("branch_id", $branch['id'])
					->fetch();
		$left = 150;
		$this->Ln(15);
		$this->SetX($left += 540); $this->Cell(140,$h,'( ' . $mgr['first_name'] . ' ' . $mgr['last_name'] . ' )',0,1,'C',true);
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
				a.tegangan_r,
				a.tegangan_s,
				a.tegangan_t,
				a.arus_r,
				a.arus_s,
				a.arus_t,
				a.koneksi,
				a.wiring,
				a.pressure,
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

				WHERE c.item_area_id = '$area_id' AND Convert(checked_at, date) Between '$from_date' AND '$from_date'
				GROUP BY c.id;";
		
			$sql = mysqli_query($link,$query);
			while($row =mysqli_fetch_assoc($sql)){
				array_push($data, $row);
			}
			
	//pilihan
	//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($from_date) . '.pdf';
	$filename = 'report_checklist_hk_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
	
	$options = array(
		'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
		'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
		'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
		'orientation'=>'L' //orientation: P=portrait, L=landscape
	);
	
	$tabel = new FPDF_AutoWrapTable($data, $options);
	$tabel->printPDF();
	}
		
	//Jika Checklist Service AC
	if($sub_id == 13){
		
		require_once("../assets/pdf/fpdf/fpdf.php");
	
		$time_now 	=  date('Y-m-d H:i:s');
		
class FPDF_AutoWrapTable extends FPDF {
  	private $data = array();
  	private $options = array(
  		'filename' => '',
  		'destinationfile' => '',
  		'paper_size'=>'A4',
  		'orientation'=>'P'
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
		
		$area_id = $_POST['sub-area'];
		
		$user_id = $_SESSION['id'];
		
		$link = mysqli_connect('localhost', 'root', 'ilovejkt48', 'checklist_system_db');
		
		$query_user = "select * FROM users WHERE id='$user_id'";
		$sql = mysqli_query($link, $query_user);
		$user =mysqli_fetch_assoc($sql);
		
		$name = ($user['first_name'] . ' ' . $user['last_name']);
		
		$query = "Select name FROM item_area
				WHERE id='$area_id'";
				
		$sql = mysqli_query($link, $query);
		$area =mysqli_fetch_assoc($sql);

		$time_now 	=  date('Y-m-d H:i:s');
		$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
		
		$border = 0;
		$this->AddPage();
		$this->SetAutoPageBreak(true,60);
		$this->AliasNbPages();
		$left = 0;
		
		//header
		$this->SetFont("", "B", 13);
		$this->SetX($left); $this->Cell(0, 13, 'CHECK LIST ' . strtoupper($area['name']), 0, 1,'C');
		$this->SetFont("", "", 10);
		$this->Ln(40);
		
		$left = 25;
		$this->SetFont('Arial','',10);
		$this->SetX($left);
		$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
		$this->SetX($left);
		$this->Cell(0, 12, 'Divisi 	     : Mechanical Engineering', 0, 1,'L');
		$this->SetX(24.6);
		$this->Cell(0, 12, 'Tanggal   : '. tgl_indo($from_date), 0, 1,'L');
		$this->Ln(5);
		
		$h = 14;
		$left = 25;
		$top = 90;	
		$this->SetX($left);
		$this->SetFont('Arial','B',9);
		#tableheader
		$this->SetFillColor(200,200,200);	
		$left = $this->GetX();
		
		$h = 14*2;
		$this->Cell(25,$h,'No.',1,0,'C',true);
		$this->SetX($left += 25); $this->Cell(60,$h,'Code AC',1,0,'C',true);
		$this->SetX($left += 60); $this->Cell(100,$h,'Area',1,0,'C',true);
		$h = 14;
		$this->SetX($left += 100); $this->Cell(100,$h,'Sebelum',1,1,'C',true);
		$this->SetX($left += 0); $this->Cell(50,$h,'Ampere',1,0,'C',true);
		$this->SetX($left += 50); $this->Cell(50,$h,'Psi',1,0,'C',true);
		$this->SetY(122.3);
		$this->SetX($left += 50); $this->Cell(100,$h,'Sesudah',1,1,'C',true);
		$this->SetX($left += 0); $this->Cell(50,$h,'Ampere',1,0,'C',true);
		$this->SetX($left += 50); $this->Cell(50,$h,'Psi',1,0,'C',true);
		$this->SetY(122.3);
		$h = 14*2;
		$this->SetX($left += 50); $this->Cell(140,$h,'Keterangan',1,0,'C',true);
		$this->SetY(150.4);

		$this->SetFont('Arial','',9);
		$this->SetWidths(array(25,60,100,50,50,50,50,140));
		$this->SetAligns(array('C','L','L','C','C','C','C','L'));
		
		
		$no = 1; $this->SetFillColor(255);
		
		foreach ($this->data as $baris) {
			$left = 25;
			$this->SetX($left);
		
			$this->Row(
				array($no++, 
				$baris['code'], 
				$baris['item_name'], 
				$baris['ampere_before'], 
				$baris['psi_before'], 
				$baris['ampere_after'], 
				$baris['psi_after'], 
				$baris['description']
			));
		}
		
	
		$this->SetFont("", "B", 9);
		$this->Ln(25);
		$left = 50;
		$h=14;
		
		$this->SetX($left += 0); $this->Cell(250,$h,'Di Kerjakan Oleh',0,1,'L',true);
		$this->SetX($left += 0); $this->Cell(250,$h,'Staff ME :',0,0,'L',true);
		$this->SetX($left += 350); $this->Cell(140,$h,'Mengetahui :',0,1,'C',true);
		
		$left = 55;
		$staffs = $db->users()
					->where("user_type", "operator")
					->where("divisi_id", 2)
					->where("branch_id", $branch['id']);
		$no=1;
		foreach($staffs as $staff){
			$this->SetX($left); $this->Cell(250,$h,$no . '. ' . $staff['first_name'] . ' ' . $staff['last_name'],0,1,'L',true);
		
		$no++;
		}
		$mgr = $db->users()
					->where("user_type", "manager")
					->where("branch_id", $branch['id'])
					->fetch();
		$this->Ln(15);
		$left = 50;
		$this->SetX($left += 350); $this->Cell(140,$h,'( ' . $mgr['first_name'] . ' ' . $mgr['last_name'] . ' )',0,1,'C',true);
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
		$query = "Select	c.item_name,
							a.item_id,
							b.code,
							b.ampere_before,
							b.ampere_after,
							b.psi_before,
							b.psi_after,
							b.description

					From item_checklist a
					Left Join checklist_ac b
					On a.item_id = b.item_id
					left JOIN item c
					On b.item_id = c.id

					WHERE c.item_area_id = '$area_id'
							AND Convert(a.checked_at, date) Between '$from_date'
							AND '$from_date'
					GROUP BY b.id";
					
					$sql = mysqli_query($link,$query);
					while($row =mysqli_fetch_assoc($sql)){
						array_push($data, $row);
					}
			
	//pilihan
	//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($from_date) . '.pdf';
	$filename = 'report_checklist_hk_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
	
	$options = array(
		'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
		'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
		'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
		'orientation'=>'P' //orientation: P=portrait, L=landscape
	);
	
	$tabel = new FPDF_AutoWrapTable($data, $options);
	$tabel->printPDF();
	}
	
	//Jika Checklist Genset
	if($sub_id == 14){
		
		require_once("../assets/pdf/fpdf/fpdf.php");
	
		$time_now 	=  date('Y-m-d H:i:s');
		
class FPDF_AutoWrapTable extends FPDF {
  	private $data = array();
  	private $options = array(
  		'filename' => '',
  		'destinationfile' => '',
  		'paper_size'=>'A4',
  		'orientation'=>'P'
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
		
		$area_id = $_POST['sub-area'];
		
		$user_id = $_SESSION['id'];
		
		$link = mysqli_connect('localhost', 'root', 'ilovejkt48', 'checklist_system_db');
		
		$query_user = "select * FROM users WHERE id='$user_id'";
		$sql = mysqli_query($link, $query_user);
		$user =mysqli_fetch_assoc($sql);
		
		$name = ($user['first_name'] . ' ' . $user['last_name']);
		
		$query = "Select name FROM item_area
				WHERE id='$area_id'";
				
		$sql = mysqli_query($link, $query);
		$area =mysqli_fetch_assoc($sql);

		$time_now 	=  date('Y-m-d H:i:s');
		$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
		
		$border = 0;
		$this->AddPage();
		$this->SetAutoPageBreak(true,60);
		$this->AliasNbPages();
		$left = 0;
		
		//header
		$this->SetFont("", "B", 13);
		$this->SetX($left); $this->Cell(0, 13, 'CHECK LIST ' . strtoupper($area['name']), 0, 1,'C');
		$this->SetFont("", "", 10);
		$this->Ln(40);
		
		$left = 40;
		$this->SetFont('Arial','',10);
		$this->SetX($left);
		$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
		$this->SetX($left);
		$this->Cell(0, 12, 'Divisi 	     : Mechanical Engineering', 0, 1,'L');
		$this->SetX($left);
		$this->Cell(0, 12, 'Tanggal   : '. tgl_indo($from_date), 0, 1,'L');
		$this->Ln(15);
		
		$this->SetX($left);
		$this->SetFont('Arial','B',9);
		$this->Cell(0, 14, 'Hour Meter Genset', 0, 1,'L');
		$h = 18;
		$left = 40;
		$top = 90;	
		$this->SetX($left);
		$this->SetFont('Arial','',9);
		
		$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
		//$to_date =  date('Y/m/d', strtotime($_POST['to_date']));
		
		$link = mysqli_connect('localhost', 'root', 'ilovejkt48', 'checklist_system_db');
		
		$data = array();
		
		$query = "Select * from hour_meter_genset

			WHERE item_area_id = '14' AND Convert(created_at, date) Between '$from_date' AND '$from_date'
			GROUP BY id;";

			$sql = mysqli_query($link,$query);

			$row =mysqli_fetch_assoc($sql);
			
			//var_dump($row['start_hour_meter']);
		
				$this->SetFillColor(255);	
				$left = $this->GetX();
				$top = 90;
				$h = 18;
				$this->SetX($left += 0); 
				$this->Cell(180,$h,'Tanggal',1,0,'L',true);
				$this->SetX($left += 180); $this->Cell(120,$h,tgl_indo($from_date),1,1,'C',true);
				$this->SetX($left -= 180); 
				$this->Cell(180,$h,'Hour Meter Awal (Sebelum Pemanasan)',1,0,'L',true);
				$this->SetX($left += 180); $this->Cell(120,$h,$row['start_hour_meter'],1,1,'C',true);
				$this->SetX($left -= 180); 
				$this->Cell(180,$h,'Hour Meter Akhir (Setelah Pemanasan)',1,0,'L',true);
				$this->SetX($left += 180); $this->Cell(120,$h,$row['after_hour_meter'],1,1,'C',true);
				$this->SetY(212.3);
				
		$h = 18;
		$left = 40;
		$top = 90;	
		$this->SetX($left);
		$this->SetFont('Arial','B',9);
		#tableheader
		$this->SetFillColor(200,200,200);	
		$left = $this->GetX();
		
		$h = 18;
		$this->Cell(25,$h,'No.',1,0,'C',true);
		$this->SetX($left += 25); $this->Cell(240,$h,'Tindakan',1,0,'C',true);
		$this->SetX($left += 240); $this->Cell(260,$h,'Keterangan',1,0,'C',true);
		$this->SetY(230.4);

		$this->SetFont('Arial','',9);
		$this->SetWidths(array(25,240,260));
		$this->SetAligns(array('C','L','L'));

		$no = 1; $this->SetFillColor(255);

		foreach ($this->data as $baris) {
			$left = 40;
			$this->SetX($left);
			
			if($baris['id_item'] == 151){
				$this->Row(
					array($no++, 
					$baris['item_name'], 
					'AMPR =  ' . $baris['ampr'] . '   ' . 'Volt =  ' . $baris['volt']
				));
			}else{
				$this->Row(
					array($no++, 
					$baris['item_name'], 
					$baris['description']
				));
			}
		}
		
		$this->SetFont("", "B", 9);
		$this->Ln(25);
		$left = 50;
		$h=14;
		
		$this->SetX($left += 0); $this->Cell(250,$h,'Di Kerjakan Oleh',0,1,'L',true);
		$this->SetX($left += 0); $this->Cell(250,$h,'Staff ME :',0,0,'L',true);
		$this->SetX($left += 350); $this->Cell(140,$h,'Mengetahui :',0,1,'C',true);
		
		$left = 55;
		$staffs = $db->users()
					->where("user_type", "operator")
					->where("divisi_id", 2)
					->where("branch_id", $branch['id']);
		$no=1;
		foreach($staffs as $staff){
			$this->SetX($left); $this->Cell(250,$h,$no . '. ' . $staff['first_name'] . ' ' . $staff['last_name'],0,1,'L',true);
		
		$no++;
		}
		$mgr = $db->users()
					->where("user_type", "manager")
					->where("branch_id", $branch['id'])
					->fetch();
		$this->Ln(15);
		$left = 50;
		$this->SetX($left += 350); $this->Cell(140,$h,'( ' . $mgr['first_name'] . ' ' . $mgr['last_name'] . ' )',0,1,'C',true);
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
					c.id as id_item,
					a.item_status_id,
					a.item_fungsi_id,
					a.item_id,
					a.ampere_before,
					a.ampere_after,
					a.psi_before,
					a.psi_after,
					a.total_unit,
					a.arus_t,
					a.ampr,
					a.volt,
					a.pressure,
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

					WHERE c.item_area_id = '$area_id' AND Convert(checked_at, date) Between '$from_date' AND '$from_date'
					GROUP BY c.id;";
		
					$sql = mysqli_query($link,$query);
					while($row =mysqli_fetch_assoc($sql)){
						array_push($data, $row);
					}
			
	//pilihan
	//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($from_date) . '.pdf';
	$filename = 'report_checklist_hk_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
	
	$options = array(
		'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
		'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
		'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
		'orientation'=>'P' //orientation: P=portrait, L=landscape
	);
	
	$tabel = new FPDF_AutoWrapTable($data, $options);
	$tabel->printPDF();
	}
	
	//Jika Checklist Pest Control
	if($sub_id == 15){
		
		require_once("../assets/pdf/fpdf/fpdf.php");
	
		$time_now 	=  date('Y-m-d H:i:s');
		
class FPDF_AutoWrapTable extends FPDF {
  	private $data = array();
  	private $options = array(
  		'filename' => '',
  		'destinationfile' => '',
  		'paper_size'=>'A4',
  		'orientation'=>'P'
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
		
		$area_id = $_POST['sub-area'];
		
		$user_id = $_SESSION['id'];
		
		$link = mysqli_connect('localhost', 'root', 'ilovejkt48', 'checklist_system_db');
		
		$query_user = "select * FROM users WHERE id='$user_id'";
		$sql = mysqli_query($link, $query_user);
		$user =mysqli_fetch_assoc($sql);
		
		$name = ($user['first_name'] . ' ' . $user['last_name']);
		
		$query = "Select name FROM item_area
				WHERE id='$area_id'";
				
		$sql = mysqli_query($link, $query);
		$area =mysqli_fetch_assoc($sql);

		$time_now 	=  date('Y-m-d H:i:s');
		$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
		
		$border = 0;
		$this->AddPage();
		$this->SetAutoPageBreak(true,60);
		$this->AliasNbPages();
		$left = 0;
		
		//header
		$this->SetFont("", "B", 13);
		$this->SetX($left); $this->Cell(0, 13, 'CHECK LIST ' . strtoupper($area['name']), 0, 1,'C');
		$this->SetFont("", "", 10);
		$this->Ln(40);
		
		$left = 40;
		$this->SetFont('Arial','',10);
		$this->SetX($left);
		$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
		$this->SetX($left);
		$this->Cell(0, 12, 'Divisi 	     : Mechanical Engineering', 0, 1,'L');
		$this->SetX($left);
		$this->Cell(0, 12, 'Tanggal   : '. tgl_indo($from_date), 0, 1,'L');
		$this->Ln(15);
		
		$this->SetX($left);
		//$this->SetFont('zapfdingbats','B',9);
		//$this->Cell(0, 14, '4', 0, 1,'L');
		$h = 18;
		$left = 40;
		$top = 90;	
		$this->SetX($left);
		$this->SetFont('Arial','',9);
		#tableheader
		$this->SetFillColor(200,200,200);
		
		$h = 18;
		$left = 40;
		$top = 90;	
		$this->SetX($left);
		$this->SetFont('Arial','B',9);
		#tableheader
		$this->SetFillColor(200,200,200);	
		$left = $this->GetX();
		
		$h = 18;
		$this->Cell(25,$h,'No.',1,0,'C',true);
		$this->SetX($left += 25); $this->Cell(140,$h,'Tindakan',1,0,'C',true);
		$this->SetX($left += 140); $this->Cell(60,$h,'Spraying',1,0,'C',true);
		$this->SetX($left += 60); $this->Cell(60,$h,'Batting',1,0,'C',true);
		$this->SetX($left += 60); $this->Cell(60,$h,'Dusting',1,0,'C',true);
		$this->SetX($left += 60); $this->Cell(60,$h,'Controling',1,0,'C',true);
		$this->SetX($left += 60); $this->Cell(125,$h,'Keterangan',1,0,'C',true);
		$this->SetY(150.4);

		$this->SetFont('Arial','',9);
		$this->SetWidths(array(25,140,60,60,60,60,125));
		$this->SetAligns(array('C','L','C','C','C','C','L'));

		$no = 1; $this->SetFillColor(255);

		foreach ($this->data as $baris) {
			$left = 40;
			$this->SetX($left);
			
			if($baris['spraying']==1){
				$baris['spraying'] = 'Ok';
			}else{
				$baris['spraying'] = '-';
			}
			if($baris['batting']==1){
				$baris['batting'] = 'Ok';
			}else{
				$baris['batting'] = '-';
			}
			if($baris['dusting']==1){
				$baris['dusting'] = 'Ok';
			}else{
				$baris['dusting'] = '-';
			}
			if($baris['controling']==1){
				$baris['controling'] = 'Ok';
			}else{
				$baris['controling'] = '-';
			}
			
			$this->Row(
				array($no++,
				$baris['item_name'], 
				$baris['spraying'],
				$baris['batting'],
				$baris['dusting'],
				$baris['controling'],
				$baris['description']
			));
		}
		
	
		$this->SetFont("", "B", 9);
		$this->Ln(25);
		$left = 50;
		$h=14;
		
		$this->SetX($left += 0); $this->Cell(250,$h,'Di Kerjakan Oleh',0,1,'L',true);
		$this->SetX($left += 0); $this->Cell(250,$h,'Staff ME :',0,0,'L',true);
		$this->SetX($left += 350); $this->Cell(140,$h,'Mengetahui :',0,1,'C',true);
		
		$left = 55;
		$staffs = $db->users()
					->where("user_type", "operator")
					->where("divisi_id", 2)
					->where("branch_id", $branch['id']);
		$no=1;
		foreach($staffs as $staff){
			$this->SetX($left); $this->Cell(250,$h,$no . '. ' . $staff['first_name'] . ' ' . $staff['last_name'],0,1,'L',true);
		
		$no++;
		}
		$mgr = $db->users()
					->where("user_type", "manager")
					->where("branch_id", $branch['id'])
					->fetch();
		$this->Ln(15);
		$left = 50;
		$this->SetX($left += 350); $this->Cell(140,$h,'( ' . $mgr['first_name'] . ' ' . $mgr['last_name'] . ' )',0,1,'C',true);
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
		
		$query = "Select
					b.item_name,
					a.item_id,
					a.spraying,
					a.batting,
					a.dusting,
					a.controling,
					a.description

					From item_checklist a
					Left Join item b
					On a.item_id = b.id
					

					WHERE b.item_area_id = '$area_id' AND Convert(checked_at, date) Between '$from_date' AND '$from_date'
					GROUP BY b.id;";
		
					$sql = mysqli_query($link,$query);
					while($row =mysqli_fetch_assoc($sql)){
						array_push($data, $row);
					}
			
	//pilihan
	//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($from_date) . '.pdf';
	$filename = 'report_checklist_hk_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
	
	$options = array(
		'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
		'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
		'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
		'orientation'=>'P' //orientation: P=portrait, L=landscape
	);
	
	$tabel = new FPDF_AutoWrapTable($data, $options);
	$tabel->printPDF();
	}
	
	//Jika Checklist Fasilitas
	if($sub_id == 16){
		
		require_once("../assets/pdf/fpdf/fpdf.php");
	
		$time_now 	=  date('Y-m-d H:i:s');
		
class FPDF_AutoWrapTable extends FPDF {
  	private $data = array();
  	private $options = array(
  		'filename' => '',
  		'destinationfile' => '',
  		'paper_size'=>'A4',
  		'orientation'=>'P'
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
		
		$area_id = $_POST['sub-area'];
		
		$user_id = $_SESSION['id'];
		
		$link = mysqli_connect('localhost', 'root', 'ilovejkt48', 'checklist_system_db');
		
		$query_user = "select * FROM users WHERE id='$user_id'";
		$sql = mysqli_query($link, $query_user);
		$user =mysqli_fetch_assoc($sql);
		
		$name = ($user['first_name'] . ' ' . $user['last_name']);
		
		$query = "Select name FROM item_area
				WHERE id='$area_id'";
				
		$sql = mysqli_query($link, $query);
		$area =mysqli_fetch_assoc($sql);

		$time_now 	=  date('Y-m-d H:i:s');
		$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
		
		$border = 0;
		$this->AddPage();
		$this->SetAutoPageBreak(true,60);
		$this->AliasNbPages();
		$left = 0;
		
		//header
		$this->SetFont("", "B", 13);
		$this->SetX($left); $this->Cell(0, 13, 'CHECK LIST ' . strtoupper($area['name']), 0, 1,'C');
		$this->SetFont("", "", 10);
		$this->Ln(20);
		
		$left = 40;
		$this->SetFont('Arial','',10);
		$this->SetX($left);
		$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
		$this->SetX($left);
		$this->Cell(0, 12, 'Divisi 	     : Mechanical Engineering', 0, 1,'L');
		$this->SetX($left);
		$this->Cell(0, 12, 'Tanggal   : '. tgl_indo($from_date), 0, 1,'L');
		$this->Ln(5);
		
		$this->SetX($left);
		//$this->SetFont('zapfdingbats','B',9);
		//$this->Cell(0, 14, '4', 0, 1,'L');
		$h = 18;
		$left = 40;
		$top = 90;	
		$this->SetX($left);
		$this->SetFont('Arial','',9);
		#tableheader
		$this->SetFillColor(200,200,200);
		
		$h = 16;
		$left = 40;
		$top = 90;	
		$this->SetX($left);
		$this->SetFont('Arial','B',9);
		#tableheader
		$this->SetFillColor(200,200,200);	
		$left = $this->GetX();
		
		
		$h = 16*2;
		$this->Cell(25,$h,'No.',1,0,'C',true);
		$this->SetX($left += 25); $this->Cell(220,$h,'Object',1,0,'C',true);
		$h = 16;
		$this->SetX($left += 220); $this->Cell(560,$h,'Waktu',1,1,'C',true);
		$this->SetX($left += 0); $this->Cell(70,$h,'11.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'12.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'14.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'16.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'18.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'20.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'22.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'23.00',1,0,'C',true);
		$this->SetY(134.4);
		/*
		$h = 14*2;
		$this->Cell(25,$h,'No.',1,0,'C',true);
		$this->SetX($left += 25); $this->Cell(220,$h,'Object',1,0,'C',true);
		$h = 14;
		$this->SetX($left += 220); $this->Cell(560,$h,'Waktu',1,1,'C',true);
		$this->SetX($left += 0); $this->Cell(70,$h,'11.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'12.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'14.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'16.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'18.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'20.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'22.00',1,0,'C',true);
		$this->SetX($left += 70); $this->Cell(70,$h,'23.00',1,0,'C',true);
		$this->SetY(160.4);
		
		$this->SetFont('Arial','',9);
		$this->SetWidths(array(25,220,70,70,70,70,70,70,70,70));
		$this->SetAligns(array('C','L','C','C','C','C','C','C','C','C'));
		*/
		$this->SetFont('Arial','',9);
		$this->SetWidths(array(25,220));
		$this->SetAligns(array('C','L'));

		$no = 1; $this->SetFillColor(255);

		foreach ($this->data as $baris) {
			$left = 40;
			$this->SetX($left);
			
			$this->Row(
				array($no++,
				strip_tags($baris['item_name']),
			));
		}
		$h=16;
		$this->SetY(134.4);
		$this->SetX($left += 245);
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 307)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 307)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 307)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 307)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 307)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 307)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 307)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 307)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left);
		
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 308)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 308)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 308)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 308)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 308)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 308)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 308)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 308)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left);
		
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 309)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 309)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 309)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 309)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 309)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 309)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 309)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 309)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left);
		
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 310)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 310)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 310)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 310)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 310)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 310)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 310)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 310)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left);
		
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 311)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 311)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 311)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 311)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 311)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 311)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 311)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 311)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left);
		
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 312)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 312)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 312)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 312)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 312)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 312)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 312)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 312)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left); 
		
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 313)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 313)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 313)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 313)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 313)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 313)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 313)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 313)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left); 
		
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 314)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 314)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 314)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 314)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 314)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 314)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 314)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 314)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left);
		
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 315)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 315)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 315)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 315)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 315)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 315)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 315)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 315)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left); 
		
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 316)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 316)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 316)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 316)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 316)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 316)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 316)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 316)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left);
		
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 317)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 317)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 317)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 317)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 317)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 317)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 317)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 317)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left);
		
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 318)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 318)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 318)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 318)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 318)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 318)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 318)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 318)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left);
		
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 319)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 319)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 319)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 319)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 319)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 319)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 319)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 319)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left);
		
		$cek1_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 320)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 320)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 320)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 320)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 320)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 320)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 320)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek1_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 320)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek1_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek1_8['description'],1,1,'C',true);
		$this->SetX($left);
		
		$cek8_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 321)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek8_2 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 2)
			->where("branch_id", $branch['id'])
			->where("item_id", 321)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek8_3 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 3)
			->where("branch_id", $branch['id'])
			->where("item_id", 321)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek8_4 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 4)
			->where("branch_id", $branch['id'])
			->where("item_id", 321)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek8_5 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 5)
			->where("branch_id", $branch['id'])
			->where("item_id", 321)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek8_6 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 6)
			->where("branch_id", $branch['id'])
			->where("item_id", 321)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek8_7 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 7)
			->where("branch_id", $branch['id'])
			->where("item_id", 321)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek8_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 321)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->Cell(70,$h,$cek8_1['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek8_2['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek8_3['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek8_4['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek8_5['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek8_6['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek8_7['description'],1,0,'C',true);
		$this->Cell(70,$h,$cek8_8['description'],1,1,'C',true);
		$this->SetX($left);
		
		$cek9_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, cl, ph, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 322)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek9_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, cl, ph, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 322)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->SetX($left);
		$this->Cell(70,$h,'11.00',1,0,'C',true);
		$this->Cell(70,$h,'PH  =  ' . $cek9_1['ph'],1,0,'L',true);
		$this->Cell(70,$h,'PH  =  ' . $cek9_1['cl'],1,0,'L',true);
		$this->Cell(70,$h,  ucfirst($cek9_1['description']),1,0,'C',true);
		$this->Cell(70,$h,'23.00',1,0,'C',true);
		$this->Cell(70,$h,'PH  =  ' . $cek9_8['ph'],1,0,'L',true);
		$this->Cell(70,$h,'PH  =  ' . $cek9_8['cl'],1,0,'L',true);
		$this->Cell(70,$h,  ucfirst($cek9_8['description']),1,1,'C',true);
		
		$cek10_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, description, cl, ph, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 323)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek10_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, description,  cl, ph, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 323)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->SetX($left);
		$this->Cell(70,$h,'11.00',1,0,'C',true);
		$this->Cell(70,$h,'PH  =  ' . $cek10_1['ph'],1,0,'L',true);
		$this->Cell(70,$h,'PH  =  ' . $cek10_1['cl'],1,0,'L',true);
		$this->Cell(70,$h,  ucfirst($cek10_1['description']),1,0,'C',true);
		$this->Cell(70,$h,'23.00',1,0,'C',true);
		$this->Cell(70,$h,'PH  =  ' . $cek10_8['ph'],1,0,'L',true);
		$this->Cell(70,$h,'PH  =  ' . $cek10_8['cl'],1,0,'L',true);
		$this->Cell(70,$h,  ucfirst($cek10_8['description']),1,1,'C',true);
		
		$cek11_1 = $db->checklist_me_fas()
			->select("id, check_hour_id, cl, ph, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 1)
			->where("branch_id", $branch['id'])
			->where("item_id", 324)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$cek11_8 = $db->checklist_me_fas()
			->select("id, check_hour_id, cl, ph, description, item_id, Convert(checked_at, Date) As tanggal")
			->where("check_hour_id", 8)
			->where("branch_id", $branch['id'])
			->where("item_id", 324)
			->where("Convert(checked_at, Date)", $from_date)
			->fetch();
		$this->SetX($left);
		$this->Cell(70,$h,'11.00',1,0,'C',true);
		$this->Cell(70,$h,'PH  =  ' . $cek11_1['ph'],1,0,'L',true);
		$this->Cell(70,$h,'PH  =  ' . $cek11_1['cl'],1,0,'L',true);
		$this->Cell(70,$h,  ucfirst($cek11_1['description']),1,0,'C',true);
		$this->Cell(70,$h,'23.00',1,0,'C',true);
		$this->Cell(70,$h,'PH  =  ' . $cek11_8['ph'],1,0,'L',true);
		$this->Cell(70,$h,'PH  =  ' . $cek11_8['cl'],1,0,'L',true);
		$this->Cell(70,$h,  ucfirst($cek11_8['description']),1,1,'C',true);
	
		$this->SetFont("", "B", 9);
		$this->Ln(10);
		$this->SetY(445);
		$left = 100;
		$h=14;
		
		$this->SetX($left += 0); $this->Cell(450,$h,'Di Kerjakan Oleh',0,1,'L',true);
		$this->SetX($left += 0); $this->Cell(450,$h,'Staff ME :',0,0,'L',true);
		$this->SetX($left += 600); $this->Cell(140,$h,'Mengetahui :',0,1,'L',true);
		
		$left = 110;
		$staffs = $db->users()
					->where("user_type", "operator")
					->where("divisi_id", 2)
					->where("branch_id", $branch['id']);
		$no=1;
		foreach($staffs as $staff){
			$this->SetX($left); $this->Cell(250,$h,$no . '. ' . $staff['first_name'] . ' ' . $staff['last_name'],0,1,'L',true);
		
		$no++;
		}
		$mgr = $db->users()
					->where("user_type", "manager")
					->where("branch_id", $branch['id'])
					->fetch();
		$this->Ln(15);
		$this->SetX($left += 550); $this->Cell(140,$h,'( ' . $mgr['first_name'] . ' ' . $mgr['last_name'] . ' )',0,1,'C',true);
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
		$h=16*$nb;
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
			$this->MultiCell($w,16,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}
	
	function Row2($data)
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
			$this->Cell($w,18,$data[$i],0,$a);
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
		
		$query = "Select
					id,
					item_name,
					item_area_id

				  FROM item

					WHERE item_area_id = '$area_id'
					ORDER BY id ASC;";

					$sql = mysqli_query($link,$query);
					while($row =mysqli_fetch_assoc($sql)){
						array_push($data, $row);
					}

		/*
		$query = "Select
					a.item_id,
					a.checked_at,
					b.item_name,
					b.item_area_id

				  FROM item_checklist a
					LEFT JOIN item b
					ON a.item_id = b.id

					WHERE b.item_area_id = '$area_id' AND Convert(checked_at, date) Between '$from_date' AND '$from_date'
					ORDER BY b.id ASC;";

					$sql = mysqli_query($link,$query);
					while($row =mysqli_fetch_assoc($sql)){
						array_push($data, $row);
					}
		*/
		$data2 = array();
		
		$query2 = "Select
					a.item_id,
					a.description,
					a.checked_at,
					a.ph,
					a.cl,
					a.check_hour_id,
					b.id

					FROM checklist_me_fas a
						LEFT JOIN check_hour b
						ON a.check_hour_id = b.id
						
						WHERE
						Convert(a.checked_at, date) Between '$from_date' AND '$from_date'
						GROUP BY b.id;";

					$sql = mysqli_query($link,$query2);
					while($row =mysqli_fetch_assoc($sql)){
						array_push($data2, $row);
						//echo $row['check_hour_id']. '<br/>';
					}

	$filename = 'report_checklist_hk_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
	
	$options = array(
		'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
		'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
		'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
		'orientation'=>'L' //orientation: P=portrait, L=landscape
	);
	
	$tabel = new FPDF_AutoWrapTable($data, $options);
	$tabel->printPDF();
	}
	
	}
?>