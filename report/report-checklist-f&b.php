<?php
	session_start();
	include '../core/helper/myHelper.php';
	
	$sub_id = $_POST['sub-area'];
	$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
	//$to_date =  date('Y/m/d', strtotime($_POST['to_date']));
	
	if (!empty($_SESSION['username']) AND !empty($_SESSION['password'])) {
	
		// Set Template PDF Berdasarkan SUb Area
		//Jika Checklist Bar Pool
		if($sub_id == 27){
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
					$this->SetX($left); $this->Cell(0, 13, 'DAILY CHECKLIST ' . strtoupper($area['name']), 0, 1,'C');
					$this->SetFont("", "", 10);
					$this->Ln(40);
					
					$left = 60;
					$this->SetFont('Arial','',10);
					$this->SetX($left);
					$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
					$this->SetX($left);
					$this->Cell(0, 12, 'Divisi 	     : Food & Beverage', 0, 1,'L');
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
					$this->SetX($left += 25); $this->Cell(210,$h,'Area',1,0,'C',true);
					$h = 12;
					$this->SetX($left += 210); $this->Cell(260,$h,'Kondisi',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(65,$h,'Bersih',1,0,'C',true);
					$this->SetX($left += 65); $this->Cell(65,$h,'Kotor',1,0,'C',true);
					$this->SetX($left += 65); $this->Cell(65,$h,'Lengkap',1,0,'C',true);
					$this->SetX($left += 65); $this->Cell(65,$h,'Tdk Lengkap',1,0,'C',true);
					$this->SetY(122.3);
					$this->SetX($left += 65); $this->Cell(130,$h,'Fungsi',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(65,$h,'Baik',1,0,'C',true);
					$this->SetX($left += 65); $this->Cell(65,$h,'Rusak',1,0,'C',true);
					$h = 24;
					$this->SetY(122.3);
					$this->SetX($left += 65); $this->Cell(200,$h,'Keterangan',1,0,'C',true);

					$this->SetY(146.3);
					$this->SetFont('Arial','',8);
					$this->SetWidths(array(25,210,65,65,65,65,65,65,200));
					$this->SetAligns(array('C','L','C','C','C','C','C','C','L'));
					
					
					$no = 1; $this->SetFillColor(255);
					
					foreach ($this->data as $baris) {
						$left = 60;
						$this->SetX($left);

						if ($baris['c_item_status_id'] == '3') {
							$kondisi_bersih = 'V';
							$kondisi_kotor = '';
						}
						elseif ($baris['c_item_status_id'] == '4') {
							$kondisi_bersih = '';
							$kondisi_kotor = 'V';
						}

						if ($baris['c_item_kondisi_id'] == '1') {
							$status_lengkap = 'V';
							$status_tidak_lengkap = '';
						}
						elseif ($baris['c_item_kondisi_id'] == '2') {
							$status_lengkap = '';
							$status_tidak_lengkap = 'V';
						}

						if ($baris['c_item_fungsi_id'] == '1') {
							$fungsi_baik = 'V';
							$fungsi_rusak = '';
						}
						elseif ($baris['c_item_fungsi_id'] == '2') {
							$fungsi_baik = '';
							$fungsi_rusak = 'V';
						}
					
						$this->Row(
							array($no++,
							$baris['i_item_name'], 
							$kondisi_bersih,
							$kondisi_kotor,
							$status_lengkap,
							$status_tidak_lengkap,
							$fungsi_baik,
							$fungsi_rusak, 
							ucfirst($baris['c_description'])
						));
					}

					$this->SetFont("", "B", 9);
					$this->Ln(10);
					$left = 50;
					$h=14;
					$this->SetX($left += 50); $this->Cell(100,$h,'Prepared By :',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Check By :',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Check By :',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Approved By :',0,0,'L',true);
					$this->Ln(25);
					$left = 50;
					$this->SetX($left += 50); $this->Cell(100,1,'Staff In Charge',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'Leader Cook',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'SPV Floor',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'Assist. Manager/Manager',0,0,'L',true);
					
					$left = 110;
					$staffs = $db->users()
								->where("user_type", "operator")
								->where("divisi_id", 4)
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
					$this->Ln(65);
					$left = 50;
					$this->SetX($left += 50); $this->Cell(100,1,'(.............................................)',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'(.............................................)',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'(.............................................)',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'( ' . $mgr['first_name'] . ' ' . $mgr['last_name'] . ' )',0,0,'L',true);
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
				
			$query = "Select	i.item_name AS i_item_name,
								c.item_status_id AS c_item_status_id,
								c.item_kondisi_id AS c_item_kondisi_id,
								c.item_fungsi_id AS c_item_fungsi_id,
								c.description AS c_description
						From item i, item_checklist c
						WHERE i.item_area_id = '27' AND i.divisi_id = '4' AND i.id = c.item_id AND Convert(c.checked_at, date) Between '$from_date' AND '$from_date'";
				
			$sql = mysqli_query($link,$query);
			while($row =mysqli_fetch_assoc($sql)){
				array_push($data, $row);
			}
					
			//pilihan
			//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($from_date) . '.pdf';
			$filename = 'report_checklist_f&b_bar_pool_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
			
			$options = array(
				'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
				'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
				'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
				'orientation'=>'L' //orientation: P=portrait, L=landscape
			);
			
			$tabel = new FPDF_AutoWrapTable($data, $options);
			$tabel->printPDF();
		}
	
		//Jika Checklist Bar Cafe
		if($sub_id == 26){
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
					$this->SetX($left); $this->Cell(0, 13, 'DAILY CHECKLIST ' . strtoupper($area['name']), 0, 1,'C');
					$this->SetFont("", "", 10);
					$this->Ln(40);
					
					$left = 60;
					$this->SetFont('Arial','',10);
					$this->SetX($left);
					$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
					$this->SetX($left);
					$this->Cell(0, 12, 'Divisi 	     : Food & Beverage', 0, 1,'L');
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
					$this->SetX($left += 25); $this->Cell(210,$h,'Area',1,0,'C',true);
					$h = 12;
					$this->SetX($left += 210); $this->Cell(260,$h,'Kondisi',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(65,$h,'Bersih',1,0,'C',true);
					$this->SetX($left += 65); $this->Cell(65,$h,'Kotor',1,0,'C',true);
					$this->SetX($left += 65); $this->Cell(65,$h,'Lengkap',1,0,'C',true);
					$this->SetX($left += 65); $this->Cell(65,$h,'Tdk Lengkap',1,0,'C',true);
					$this->SetY(122.3);
					$this->SetX($left += 65); $this->Cell(130,$h,'Fungsi',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(65,$h,'Baik',1,0,'C',true);
					$this->SetX($left += 65); $this->Cell(65,$h,'Rusak',1,0,'C',true);
					$h = 24;
					$this->SetY(122.3);
					$this->SetX($left += 65); $this->Cell(200,$h,'Keterangan',1,0,'C',true);

					$this->SetY(146.3);
					$this->SetFont('Arial','',8);
					$this->SetWidths(array(25,210,65,65,65,65,65,65,200));
					$this->SetAligns(array('C','L','C','C','C','C','C','C','L'));
					
					
					$no = 1; $this->SetFillColor(255);
					
					foreach ($this->data as $baris) {
						$left = 60;
						$this->SetX($left);

						if ($baris['c_item_status_id'] == '3') {
							$kondisi_bersih = 'V';
							$kondisi_kotor = '';
						}
						elseif ($baris['c_item_status_id'] == '4') {
							$kondisi_bersih = '';
							$kondisi_kotor = 'V';
						}

						if ($baris['c_item_kondisi_id'] == '1') {
							$status_lengkap = 'V';
							$status_tidak_lengkap = '';
						}
						elseif ($baris['c_item_kondisi_id'] == '2') {
							$status_lengkap = '';
							$status_tidak_lengkap = 'V';
						}

						if ($baris['c_item_fungsi_id'] == '1') {
							$fungsi_baik = 'V';
							$fungsi_rusak = '';
						}
						elseif ($baris['c_item_fungsi_id'] == '2') {
							$fungsi_baik = '';
							$fungsi_rusak = 'V';
						}
					
						$this->Row(
							array($no++,
							$baris['i_item_name'], 
							$kondisi_bersih,
							$kondisi_kotor,
							$status_lengkap,
							$status_tidak_lengkap,
							$fungsi_baik,
							$fungsi_rusak, 
							ucfirst($baris['c_description'])
						));
					}

					$this->SetFont("", "B", 9);
					$this->Ln(10);
					$left = 50;
					$h=14;
					$this->SetX($left += 50); $this->Cell(100,$h,'Prepared By :',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Check By :',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Check By :',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Approved By :',0,0,'L',true);
					$this->Ln(25);
					$left = 50;
					$this->SetX($left += 50); $this->Cell(100,1,'Staff In Charge',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'Leader Cook',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'SPV Floor',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'Assist. Manager/Manager',0,0,'L',true);
					
					$left = 110;
					$staffs = $db->users()
								->where("user_type", "operator")
								->where("divisi_id", 4)
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
					$this->Ln(65);
					$left = 50;
					$this->SetX($left += 50); $this->Cell(100,1,'(.............................................)',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'(.............................................)',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'(.............................................)',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'( ' . $mgr['first_name'] . ' ' . $mgr['last_name'] . ' )',0,0,'L',true);
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
				
			$query = "Select	i.item_name AS i_item_name,
								c.item_status_id AS c_item_status_id,
								c.item_kondisi_id AS c_item_kondisi_id,
								c.item_fungsi_id AS c_item_fungsi_id,
								c.description AS c_description
						From item i, item_checklist c
						WHERE i.item_area_id = '26' AND i.divisi_id = '4' AND i.id = c.item_id AND Convert(c.checked_at, date) Between '$from_date' AND '$from_date'";
				
			$sql = mysqli_query($link,$query);
			while($row =mysqli_fetch_assoc($sql)){
				array_push($data, $row);
			}
					
			//pilihan
			//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($from_date) . '.pdf';
			$filename = 'report_checklist_f&b_bar_cafe_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
			
			$options = array(
				'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
				'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
				'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
				'orientation'=>'L' //orientation: P=portrait, L=landscape
			);
			
			$tabel = new FPDF_AutoWrapTable($data, $options);
			$tabel->printPDF();
		}
		
		//Jika Checklist Buffet
		if($sub_id == 29){
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

					$connect = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
					
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
					$this->SetX($left); $this->Cell(0, 13, 'DAILY CHECKLIST ' . strtoupper($area['name']), 0, 1,'C');
					$this->SetFont("", "", 10);
					$this->Ln(40);
					
					$left = 28.4;
					$this->SetFont('Arial','',10);
					$this->SetX($left);
					$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
					$this->SetX($left);
					$this->Cell(0, 12, 'Divisi 	     : Food & Beverage', 0, 1,'L');

					$this->Ln(5);
					$h = 12;
					$left = 28.4;
					$top = 90;	
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(255);
					$left = $this->GetX();
					$this->Cell(480,$h,'SALES REPORT',0,1,'C',true);
					$this->SetY(122.3);
					$this->SetFillColor(200,200,200);
					$this->SetX($left += 0); $this->Cell(120,$h,'HARI / TANGGAL',1,0,'L',true);
					$this->SetFont('Arial','',9);
					$this->SetFillColor(250);
					$this->SetX($left += 120); $this->Cell(120,$h,tgl_indo($from_date),1,0,'C',true);
					$this->SetFont('Arial','B',10);
					$this->SetFillColor(200,200,200);
					$this->SetX($left += 120); $this->Cell(120,$h,'TOTAL TAMU',1,0,'L',true);
					$this->SetFillColor(250);
					$this->SetX($left += 120); $this->Cell(120,$h,'',1,0,'C',true);
					$h = 12;
					$this->SetY(134.3);
					$left = 28.4;
					$this->SetFillColor(200,200,200);
					$this->SetX($left += 0); $this->Cell(120,$h,'OMZET FOOD',1,0,'L',true);
					$this->SetFillColor(250);
					$this->SetX($left += 120); $this->Cell(120,$h,'',1,0,'C',true);
					$this->SetFillColor(200,200,200);
					$this->SetX($left += 120); $this->Cell(120,$h,'FOOD COVER',1,0,'L',true);
					$this->SetFillColor(250);
					$this->SetX($left += 120); $this->Cell(120,$h,'',1,0,'C',true);
					$h = 12;
					$this->SetY(146.3);
					$left = 28.4;
					$this->SetFillColor(200,200,200);
					$this->SetX($left += 0); $this->Cell(120,$h,'OMZET BEVERAGE',1,0,'L',true);
					$this->SetFillColor(250);
					$this->SetX($left += 120); $this->Cell(120,$h,'',1,0,'C',true);
					$this->SetFillColor(200,200,200);
					$this->SetX($left += 120); $this->Cell(120,$h,'BEV COVER',1,0,'L',true);
					$this->SetFillColor(250);
					$this->SetX($left += 120); $this->Cell(120,$h,'',1,0,'C',true);

					$h = 12;
					$this->SetY(170);
					$left = 28.4;
					$this->SetFillColor(200,200,200);
					$this->SetX($left += 0); $this->Cell(600,$h,'WASTEGES',1,0,'C',true);
					$this->SetX($left += 600); $this->Cell(280,$h,'COMMENT',1,0,'C',true);
					$h = 12;
					$this->SetY(182);
					$this->SetFont('Arial','',9);
					$left = 28.4;
					$this->SetFillColor(250);
					$this->SetWidths(array(25,215,120,120,120,280));
					$this->SetAligns(array('C','L','C','C','C','L'));
					$query2 = mysqli_query($connect,"SELECT i.name AS i_name, c.comment AS c_comment FROM item_wasteges i, checklist_buffet_wasteges c WHERE i.id = c.item_wasteges_id AND CONVERT(c.checked_at, date) BETWEEN '$from_date' AND '$from_date'");
					$no = 1;
					while($data2 = mysqli_fetch_array($query2,MYSQLI_ASSOC)){
						$this->SetX($left);
						$this->Row(
							array( 
								$no++,
								ucfirst($data2['i_name']),
								'',
								'',
								'',
								ucfirst($data2['c_comment']),
						));
					}

					$this->Ln(20);
					$h = 12;
					$left = 60;
					$top = 90;	
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(255);
					$left = $this->GetX();
					$this->Cell(780,$h,'DAILY CHECKLIST OPERATIONAL BUFFET',0,1,'C',true);
					$h = 36;
					$this->Ln(5);
					$left = 28.4;
					$this->SetFont('Arial','B',6.5);
					$this->SetFillColor(200,200,200);
					$this->SetX($left += 0); $this->Cell(25,$h,'NO',1,0,'C',true);
					$this->SetX($left += 25); $this->Cell(135,$h,'ITEMS',1,0,'C',true);
					//12:00-15:00
					$h = 12;
					$query4 = mysqli_query($connect,"SELECT description FROM checktime_buffet WHERE id = '1'");
					$data4 = mysqli_fetch_array($query4,MYSQLI_ASSOC);
					$this->SetX($left += 135); $this->Cell(180,$h,$data4['description'],1,2,'C',true);
					$h = 24;
					$this->SetX($left += 0); $this->Cell(30,$h,'ADA',1,0,'C',true);
					$this->SetX($left += 30); $this->Cell(30,$h,'TDK ADA',1,0,'C',true);
					$h = 12;
					$this->SetX($left += 30); $this->Cell(45,$h,'PRESENTASI',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(22.5,$h,'B',1,0,'C',true);
					$this->SetX($left += 22.5); $this->Cell(22.5,$h,'K',1,0,'C',true);
					$h = 12;
					$this->Ln(-12);
					$this->SetX($left += 22.5); $this->Cell(30,$h,'TASTE',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(15,$h,'B',1,0,'C',true);
					$this->SetX($left += 15); $this->Cell(15,$h,'K',1,0,'C',true);
					$h = 24;
					$this->Ln(-12);
					$this->SetX($left += 15); $this->Cell(45,$h,'KET',1,0,'C',true);
					//15:00-18:00
					$h = 12;
					$this->Ln(-12);
					$query5 = mysqli_query($connect,"SELECT description FROM checktime_buffet WHERE id = '2'");
					$data5 = mysqli_fetch_array($query5,MYSQLI_ASSOC);
					$this->SetX($left += 45); $this->Cell(180,$h,$data5['description'],1,2,'C',true);
					$h = 24;
					$this->SetX($left += 0); $this->Cell(30,$h,'ADA',1,0,'C',true);
					$this->SetX($left += 30); $this->Cell(30,$h,'TDK ADA',1,0,'C',true);
					$h = 12;
					$this->SetX($left += 30); $this->Cell(45,$h,'PRESENTASI',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(22.5,$h,'B',1,0,'C',true);
					$this->SetX($left += 22.5); $this->Cell(22.5,$h,'K',1,0,'C',true);
					$h = 12;
					$this->Ln(-12);
					$this->SetX($left += 22.5); $this->Cell(30,$h,'TASTE',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(15,$h,'B',1,0,'C',true);
					$this->SetX($left += 15); $this->Cell(15,$h,'K',1,0,'C',true);
					$h = 24;
					$this->Ln(-12);
					$this->SetX($left += 15); $this->Cell(45,$h,'KET',1,0,'C',true);
					//18:00-21:00
					$h = 12;
					$this->Ln(-12);
					$query6 = mysqli_query($connect,"SELECT description FROM checktime_buffet WHERE id = '3'");
					$data6 = mysqli_fetch_array($query6,MYSQLI_ASSOC);
					$this->SetX($left += 45); $this->Cell(200,$h,$data6['description'],1,2,'C',true);
					$h = 24;
					$this->SetX($left += 0); $this->Cell(30,$h,'ADA',1,0,'C',true);
					$this->SetX($left += 30); $this->Cell(30,$h,'TDK ADA',1,0,'C',true);
					$h = 12;
					$this->SetX($left += 30); $this->Cell(45,$h,'PRESENTASI',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(22.5,$h,'B',1,0,'C',true);
					$this->SetX($left += 22.5); $this->Cell(22.5,$h,'K',1,0,'C',true);
					$h = 12;
					$this->Ln(-12);
					$this->SetX($left += 22.5); $this->Cell(30,$h,'TASTE',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(15,$h,'B',1,0,'C',true);
					$this->SetX($left += 15); $this->Cell(15,$h,'K',1,0,'C',true);
					$h = 24;
					$this->Ln(-12);
					$this->SetX($left += 15); $this->Cell(45,$h,'KET',1,0,'C',true);
					//21:00-23:00
					$h = 12;
					$this->Ln(-12);
					$query7 = mysqli_query($connect,"SELECT description FROM checktime_buffet WHERE id = '4'");
					$data7 = mysqli_fetch_array($query7,MYSQLI_ASSOC);
					$this->SetX($left += 45); $this->Cell(180,$h,$data7['description'],1,2,'C',true);
					$h = 24;
					$this->SetX($left += 0); $this->Cell(30,$h,'ADA',1,0,'C',true);
					$this->SetX($left += 30); $this->Cell(30,$h,'TDK ADA',1,0,'C',true);
					$h = 12;
					$this->SetX($left += 30); $this->Cell(45,$h,'PRESENTASI',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(22.5,$h,'B',1,0,'C',true);
					$this->SetX($left += 22.5); $this->Cell(22.5,$h,'K',1,0,'C',true);
					$h = 12;
					$this->Ln(-12);
					$this->SetX($left += 22.5); $this->Cell(30,$h,'TASTE',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(15,$h,'B',1,0,'C',true);
					$this->SetX($left += 15); $this->Cell(15,$h,'K',1,0,'C',true);
					$h = 24;
					$this->Ln(-12);
					$this->SetX($left += 15); $this->Cell(45,$h,'KET',1,0,'C',true);

					$this->Ln(24);
					$this->SetFont('Arial','',7);
					$left = 28.4;
					$this->SetFillColor(250);
					$this->SetWidths(array(25,20,115,30,30,22.5,22.5,15,15,45,30,30,22.5,22.5,15,15,45,30,30,22.5,22.5,15,15,45,30,30,22.5,22.5,15,15,45));
					$this->SetAligns(array('C','C','L','C','C','C','C','C','C','L','C','C','C','C','C','C','L','C','C','C','C','C','C','L','C','C','C','C','C','C','L'));
					$query3 = mysqli_query($connect,"SELECT DISTINCT item_id FROM checklist_buffet WHERE CONVERT(checked_at, date) BETWEEN '$from_date' AND '$from_date'");
					$no = 1;
					while($data3 = mysqli_fetch_array($query3,MYSQLI_ASSOC)) {
						$query8 = mysqli_query($connect,"SELECT item_name, variant_id FROM item WHERE id = '".$data3['item_id']."'");
						$data8 = mysqli_fetch_array($query8,MYSQLI_ASSOC);
						//12:00-15:00
						$query9 = mysqli_query($connect,"SELECT * FROM checklist_buffet WHERE checktime_buffet_id = '1' AND item_id = '".$data3['item_id']."' AND CONVERT(checked_at, date) BETWEEN '$from_date' AND '$from_date'");
						$data9 = mysqli_fetch_array($query9,MYSQLI_ASSOC);
						if ($data9['ready'] == '1') {
							$ada12 = 'V';
							$tidak_ada12 = '';
						}
						elseif ($data9['ready'] == '0') {
							$ada12 = '';
							$tidak_ada12 = 'V';
						}
						if ($data9['presentasi'] == '1') {
							$presentasi_baik12 = 'V';
							$presentasi_kurang12 = '';
						}
						elseif ($data9['presentasi'] == '0') {
							$presentasi_baik12 = '';
							$presentasi_kurang12 = 'V';
						}
						if ($data9['taste'] == '1') {
							$taste_baik12 = 'V';
							$taste_kurang12 = '';
						}
						elseif ($data9['taste'] == '0') {
							$taste_baik12 = '';
							$taste_kurang12 = 'V';
						}
						//15:00-18:00
						$query10 = mysqli_query($connect,"SELECT * FROM checklist_buffet WHERE checktime_buffet_id = '2' AND item_id = '".$data3['item_id']."' AND CONVERT(checked_at, date) BETWEEN '$from_date' AND '$from_date'");
						$data10 = mysqli_fetch_array($query10,MYSQLI_ASSOC);
						if ($data10['ready'] == '1') {
							$ada15 = 'V';
							$tidak_ada15 = '';
						}
						elseif ($data10['ready'] == '0') {
							$ada15 = '';
							$tidak_ada15 = 'V';
						}
						if ($data10['presentasi'] == '1') {
							$presentasi_baik15 = 'V';
							$presentasi_kurang15 = '';
						}
						elseif ($data10['presentasi'] == '0') {
							$presentasi_baik15 = '';
							$presentasi_kurang15 = 'V';
						}
						if ($data10['taste'] == '1') {
							$taste_baik15 = 'V';
							$taste_kurang15 = '';
						}
						elseif ($data10['taste'] == '0') {
							$taste_baik15 = '';
							$taste_kurang15 = 'V';
						}
						//18:00-21:00
						$query11 = mysqli_query($connect,"SELECT * FROM checklist_buffet WHERE checktime_buffet_id = '3' AND item_id = '".$data3['item_id']."' AND CONVERT(checked_at, date) BETWEEN '$from_date' AND '$from_date'");
						$data11 = mysqli_fetch_array($query11,MYSQLI_ASSOC);
						if ($data11['ready'] == '1') {
							$ada18 = 'V';
							$tidak_ada18 = '';
						}
						elseif ($data11['ready'] == '0') {
							$ada18 = '';
							$tidak_ada18 = 'V';
						}
						if ($data11['presentasi'] == '1') {
							$presentasi_baik18 = 'V';
							$presentasi_kurang18 = '';
						}
						elseif ($data11['presentasi'] == '0') {
							$presentasi_baik18 = '';
							$presentasi_kurang18 = 'V';
						}
						if ($data11['taste'] == '1') {
							$taste_baik18 = 'V';
							$taste_kurang18 = '';
						}
						elseif ($data11['taste'] == '0') {
							$taste_baik18 = '';
							$taste_kurang18 = 'V';
						}
						//21:00-23:00
						$query12 = mysqli_query($connect,"SELECT * FROM checklist_buffet WHERE checktime_buffet_id = '4' AND item_id = '".$data3['item_id']."' AND CONVERT(checked_at, date) BETWEEN '$from_date' AND '$from_date'");
						$data12 = mysqli_fetch_array($query12,MYSQLI_ASSOC);
						if ($data12['ready'] == '1') {
							$ada21 = 'V';
							$tidak_ada21 = '';
						}
						elseif ($data12['ready'] == '0') {
							$ada21 = '';
							$tidak_ada21 = 'V';
						}
						if ($data12['presentasi'] == '1') {
							$presentasi_baik21 = 'V';
							$presentasi_kurang21 = '';
						}
						elseif ($data12['presentasi'] == '0') {
							$presentasi_baik21 = '';
							$presentasi_kurang21 = 'V';
						}
						if ($data12['taste'] == '1') {
							$taste_baik21 = 'V';
							$taste_kurang21 = '';
						}
						elseif ($data12['taste'] == '0') {
							$taste_baik21 = '';
							$taste_kurang21 = 'V';
						}

						$this->SetX($left);
						$this->Row(
							array( 
								$no++,
								$data8['variant_id'],
								$data8['item_name'],
								$ada12,
								$tidak_ada12,
								$presentasi_baik12,
								$presentasi_kurang12,
								$taste_baik12,
								$taste_kurang12,
								ucfirst($data9['description']),
								$ada15,
								$tidak_ada15,
								$presentasi_baik15,
								$presentasi_kurang15,
								$taste_baik15,
								$taste_kurang15,
								ucfirst($data10['description']),
								$ada18,
								$tidak_ada18,
								$presentasi_baik18,
								$presentasi_kurang18,
								$taste_baik18,
								$taste_kurang18,
								ucfirst($data11['description']),
								$ada21,
								$tidak_ada21,
								$presentasi_baik21,
								$presentasi_kurang21,
								$taste_baik21,
								$taste_kurang21,
								ucfirst($data12['description']),
						));
					}


					$this->SetFont("", "B", 9);
					$this->Ln(10);
					$this->SetFillColor(255);
					$left = 50;
					$h=14;
					$this->SetX($left += 200); $this->Cell(100,$h,'Control 1 :',0,0,'L',true);
					$this->SetX($left += 180); $this->Cell(100,$h,'Control 2 :',0,0,'L',true);
					$this->SetX($left += 180); $this->Cell(100,$h,'Control 3 :',0,0,'L',true);
					$this->SetX($left += 180); $this->Cell(100,$h,'Control 4 :',0,0,'L',true);
					$this->Ln(25);
					$left = 50;
					$this->SetX($left += 200); $this->Cell(100,1,'Pantry',0,0,'L',true);
					$this->SetX($left += 180); $this->Cell(100,1,'MOD',0,0,'L',true);
					$this->SetX($left += 180); $this->Cell(100,1,'MOD',0,0,'L',true);
					$this->SetX($left += 180); $this->Cell(100,1,'MOD',0,0,'L',true);
					
					$left = 110;
					$staffs = $db->users()
								->where("user_type", "operator")
								->where("divisi_id", 4)
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
					$this->Ln(65);
					$left = 50;
					$this->SetX($left += 200); $this->Cell(100,1,'(...................................)',0,0,'L',true);
					$this->SetX($left += 180); $this->Cell(100,1,'( ' . $mgr['first_name'] . ' ' . $mgr['last_name'] . ' )',0,0,'L',true);
					$this->SetX($left += 180); $this->Cell(100,1,'( ' . $mgr['first_name'] . ' ' . $mgr['last_name'] . ' )',0,0,'L',true);
					$this->SetX($left += 180); $this->Cell(100,1,'( ' . $mgr['first_name'] . ' ' . $mgr['last_name'] . ' )',0,0,'L',true);
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
				
			$query = "Select	i.item_name AS i_item_name,
								c.item_status_id AS c_item_status_id,
								c.item_kondisi_id AS c_item_kondisi_id,
								c.item_fungsi_id AS c_item_fungsi_id,
								c.description AS c_description
						From item i, item_checklist c
						WHERE i.item_area_id = '26' AND i.divisi_id = '4' AND i.id = c.item_id AND Convert(c.checked_at, date) Between '$from_date' AND '$from_date'";
				
			$sql = mysqli_query($link,$query);
			while($row =mysqli_fetch_assoc($sql)){
				array_push($data, $row);
			}
					
			//pilihan
			//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($from_date) . '.pdf';
			$filename = 'report_checklist_f&b_buffet_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
			
			$options = array(
				'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
				'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
				'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
				'orientation'=>'L' //orientation: P=portrait, L=landscape
			);
			
			$tabel = new FPDF_AutoWrapTable($data, $options);
			$tabel->printPDF();
		}
	
		//Jika Checklist Pantry Kitchen
		if($sub_id == 28){
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
					$this->SetX($left); $this->Cell(0, 13, 'DAILY CHECKLIST ' . strtoupper($area['name']), 0, 1,'C');
					$this->SetFont("", "", 10);
					$this->Ln(40);
					
					$left = 60;
					$this->SetFont('Arial','',10);
					$this->SetX($left);
					$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
					$this->SetX($left);
					$this->Cell(0, 12, 'Divisi 	     : Food & Beverage', 0, 1,'L');
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
					$this->SetX($left += 25); $this->Cell(210,$h,'Area',1,0,'C',true);
					$h = 12;
					$this->SetX($left += 210); $this->Cell(260,$h,'Kondisi',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(65,$h,'Bersih',1,0,'C',true);
					$this->SetX($left += 65); $this->Cell(65,$h,'Kotor',1,0,'C',true);
					$this->SetX($left += 65); $this->Cell(65,$h,'Lengkap',1,0,'C',true);
					$this->SetX($left += 65); $this->Cell(65,$h,'Tdk Lengkap',1,0,'C',true);
					$this->SetY(122.3);
					$this->SetX($left += 65); $this->Cell(130,$h,'Fungsi',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(65,$h,'Baik',1,0,'C',true);
					$this->SetX($left += 65); $this->Cell(65,$h,'Rusak',1,0,'C',true);
					$h = 24;
					$this->SetY(122.3);
					$this->SetX($left += 65); $this->Cell(200,$h,'Keterangan',1,0,'C',true);

					$this->SetY(146.3);
					$this->SetFont('Arial','',8);
					$this->SetWidths(array(25,210,65,65,65,65,65,65,200));
					$this->SetAligns(array('C','L','C','C','C','C','C','C','L'));
					
					
					$no = 1; $this->SetFillColor(255);
					
					foreach ($this->data as $baris) {
						$left = 60;
						$this->SetX($left);

						if ($baris['c_item_status_id'] == '3') {
							$kondisi_bersih = 'V';
							$kondisi_kotor = '';
						}
						elseif ($baris['c_item_status_id'] == '4') {
							$kondisi_bersih = '';
							$kondisi_kotor = 'V';
						}

						if ($baris['c_item_kondisi_id'] == '1') {
							$status_lengkap = 'V';
							$status_tidak_lengkap = '';
						}
						elseif ($baris['c_item_kondisi_id'] == '2') {
							$status_lengkap = '';
							$status_tidak_lengkap = 'V';
						}

						if ($baris['c_item_fungsi_id'] == '1') {
							$fungsi_baik = 'V';
							$fungsi_rusak = '';
						}
						elseif ($baris['c_item_fungsi_id'] == '2') {
							$fungsi_baik = '';
							$fungsi_rusak = 'V';
						}
					
						$this->Row(
							array($no++,
							$baris['i_item_name'], 
							$kondisi_bersih,
							$kondisi_kotor,
							$status_lengkap,
							$status_tidak_lengkap,
							$fungsi_baik,
							$fungsi_rusak, 
							ucfirst($baris['c_description'])
						));
					}

					$this->SetFont("", "B", 9);
					$this->Ln(10);
					$left = 50;
					$h=14;
					$this->SetX($left += 50); $this->Cell(100,$h,'Prepared By :',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Check By :',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Check By :',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Approved By :',0,0,'L',true);
					$this->Ln(25);
					$left = 50;
					$this->SetX($left += 50); $this->Cell(100,1,'Staff In Charge',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'Leader Cook',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'SPV Floor',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'Assist. Manager/Manager',0,0,'L',true);
					
					$left = 110;
					$staffs = $db->users()
								->where("user_type", "operator")
								->where("divisi_id", 4)
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
					$this->Ln(65);
					$left = 50;
					$this->SetX($left += 50); $this->Cell(100,1,'(.............................................)',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'(.............................................)',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'(.............................................)',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'( ' . $mgr['first_name'] . ' ' . $mgr['last_name'] . ' )',0,0,'L',true);
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
				
			$query = "Select	i.item_name AS i_item_name,
								c.item_status_id AS c_item_status_id,
								c.item_kondisi_id AS c_item_kondisi_id,
								c.item_fungsi_id AS c_item_fungsi_id,
								c.description AS c_description
						From item i, item_checklist c
						WHERE i.item_area_id = '28' AND i.divisi_id = '4' AND i.id = c.item_id AND Convert(c.checked_at, date) Between '$from_date' AND '$from_date'";
				
			$sql = mysqli_query($link,$query);
			while($row =mysqli_fetch_assoc($sql)){
				array_push($data, $row);
			}
					
			//pilihan
			//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($from_date) . '.pdf';
			$filename = 'report_checklist_f&b_pantry_kitchen_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
			
			$options = array(
				'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
				'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
				'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
				'orientation'=>'L' //orientation: P=portrait, L=landscape
			);
			
			$tabel = new FPDF_AutoWrapTable($data, $options);
			$tabel->printPDF();
		}	}
?>