<?php
	session_start();
	include '../core/helper/myHelper.php';
	
	$sub_id = $_POST['sub-area'];
	$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
	//$to_date =  date('Y/m/d', strtotime($_POST['to_date']));
	
	if (!empty($_SESSION['username']) AND !empty($_SESSION['password'])) {
	
		// Set Template PDF Berdasarkan SUb Area
		//Jika Checklist Body Checking
		if($sub_id == 30){
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
					
					$left = 30;
					$this->SetFont('Arial','',10);
					$this->SetX($left);
					$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
					$this->SetX($left);
					$this->Cell(0, 12, 'Divisi 	     : Security', 0, 1,'L');
					$this->SetX($left);
					$this->Cell(0, 12, 'Tanggal   : '. tgl_indo($from_date), 0, 1,'L');
					$this->Ln(5);
					$h = 24;
					$left = 30;
					$top = 90;	
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(200,200,200);	
					$left = $this->GetX();
					
					$this->Cell(25,$h,'No.',1,0,'C',true);
					$this->SetX($left += 25); $this->Cell(150,$h,'Nama',1,0,'C',true);
					$this->SetX($left += 150); $this->Cell(100,$h,'Jabatan',1,0,'C',true);
					$h = 12;
					$this->SetX($left += 100); $this->Cell(120,$h,'Jam',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(60,$h,'Masuk',1,0,'C',true);
					$this->SetX($left += 60); $this->Cell(60,$h,'Keluar',1,0,'C',true);
					$this->SetY(122.3);
					$h = 12*2;
					$this->SetX($left += 60); $this->Cell(150,$h,'Keterangan',1,0,'C',true);
					$this->SetY(146.4);

					$this->SetFont('Arial','',9);
					$this->SetWidths(array(25,150,100,60,60,150));
					$this->SetAligns(array('C','L','C','C','C','L'));
					
					
					$no = 1; $this->SetFillColor(255);
					
					foreach ($this->data as $baris) {
						$left = 30;
						$this->SetX($left);
					
						if ($baris['jam_keluar'] == '00:00:00') {
							$jam_keluar = '-';
						}
						elseif ($baris['jam_keluar'] !== '00:00:00') {
							$jam_keluar = date("H:i", strtotime($baris['jam_keluar']));
						}
						$this->Row(
							array($no++, 
							$baris['nama'], 
							$baris['jabatan'], 
							date("H:i", strtotime($baris['jam_masuk'])), 
							$jam_keluar,
							$baris['keterangan']
						));
					}
					
					$this->SetFont("", "B", 9);
					$this->Ln(25);
					$left = 30;
					$h=14;
					
					$this->SetX($left += 50); $this->Cell(100,$h,'Dibuat Oleh :',0,0,'L',true);
					$this->SetX($left += 150); $this->Cell(100,$h,'Diketahui Oleh :',0,0,'L',true);
					$this->SetX($left += 150); $this->Cell(100,$h,'Diperiksa Oleh :',0,0,'L',true);
					$this->Ln(25);
					$left = 30;
					$this->SetX($left += 50); $this->Cell(100,1,'Anggota Security',0,0,'L',true);
					$this->SetX($left += 150); $this->Cell(100,1,'Koor. Lap',0,0,'L',true);
					$this->SetX($left += 150); $this->Cell(100,1,'Pimpinan Outlet / MOD',0,0,'L',true);
					
					$left = 110;
					$staffs = $db->users()
								->where("user_type", "operator")
								->where("divisi_id", 5)
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
					$this->Ln(75);
					$left = 30;
					$this->SetX($left += 50); $this->Cell(100,1,'(........................................)',0,0,'L',true);
					$this->SetX($left += 150); $this->Cell(100,1,'(........................................)',0,0,'L',true);
					$this->SetX($left += 150); $this->Cell(100,1,'( ' . $mgr['first_name'] . ' ' . $mgr['last_name'] . ' )',0,0,'L',true);
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
				
			$query = "Select	nama,
								jabatan,
								jam_masuk,
								jam_keluar,
								keterangan

						From body_checking

						WHERE Convert(jam_masuk_created, date) Between '$from_date' AND '$from_date'
						GROUP BY id;";
				
			$sql = mysqli_query($link,$query);
			while($row =mysqli_fetch_assoc($sql)){
				array_push($data, $row);
			}
					
			//pilihan
			//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($from_date) . '.pdf';
			$filename = 'report_checklist_sc_body_checking_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
			
			$options = array(
				'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
				'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
				'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
				'orientation'=>'P' //orientation: P=portrait, L=landscape
			);
			
			$tabel = new FPDF_AutoWrapTable($data, $options);
			$tabel->printPDF();
		}
	
		//Jika Checklist Kegiatan Security (Harian)
		if($sub_id == 36){
			require_once("../assets/pdf/fpdf/fpdf.php");
			$time_now 	=  date('Y-m-d H:i:s');
			$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
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
					$this->SetX($left); $this->Cell(0, 13, 'LAPORAN ' . strtoupper($area['name']), 0, 1,'C');
					$this->SetFont("", "", 10);
					$this->Ln(40);
					
					$left = 20;
					$this->SetFont('Arial','',10);
					$this->SetX($left);
					$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
					$this->SetX($left);
					$this->Cell(0, 12, 'Divisi 	     : Security', 0, 1,'L');
					$this->SetX($left);
					$this->Cell(0, 12, 'Tanggal   : '. tgl_indo($from_date), 0, 1,'L');
					$this->Ln(5);
					$h = 24;
					$left = 20;
					$top = 90;	
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(200,200,200);	
					$left = $this->GetX();
					
					$this->Cell(25,$h,'No.',1,0,'C',true);
					$this->SetX($left += 25); $this->Cell(200,$h,'Kegiatan',1,0,'C',true);
					$h = 12;
					$this->SetX($left += 200); $this->Cell(170,$h,'Opening',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(30,$h,'On',1,0,'C',true);
					$this->SetX($left += 30); $this->Cell(30,$h,'Off',1,0,'C',true);
					$this->SetX($left += 30); $this->Cell(110,$h,'Kondisi',1,0,'C',true);
					$this->SetY(122.3);
					$h = 12;
					$this->SetX($left += 110); $this->Cell(170,$h,'Closing',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(30,$h,'On',1,0,'C',true);
					$this->SetX($left += 30); $this->Cell(30,$h,'Off',1,0,'C',true);
					$this->SetX($left += 30); $this->Cell(110,$h,'Kondisi',1,0,'C',true);
					$this->SetY(146.4);

					$this->SetFont('Arial','',9);
					$this->SetWidths(array(25,200,30,30,110,30,30,110));
					$this->SetAligns(array('C','L','C','C','L','C','C','L'));
					
					
					$no = 1; $this->SetFillColor(255);
					
					foreach ($this->data as $baris) {
						$left = 20;
						$this->SetX($left);

						if ($baris['c_bc_opening_status'] == '2') {
							$bc_opening_status_on = 'V';
							$bc_opening_status_off = '';
						}
						elseif ($baris['c_bc_opening_status'] == '1')	{
							$bc_opening_status_on = '';
							$bc_opening_status_off = 'V';
						}

						if ($baris['c_bc_closing_status'] == '2') {
							$bc_closing_status_on = 'V';
							$bc_closing_status_off = '';
						}
						elseif ($baris['c_bc_closing_status'] == '1')	{
							$bc_closing_status_on = '';
							$bc_closing_status_off = 'V';
						}


						$this->Row(
							array($no++, 
							$baris['i_item_name'],
							$bc_opening_status_on,
							$bc_opening_status_off,
							ucfirst($baris['c_bc_opening_keterangan']),
							$bc_closing_status_on,
							$bc_closing_status_off,
							ucfirst($baris['c_bc_closing_keterangan']),
						));
					}

					$h = 24;
					$left = 20;
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(200,200,200);	
					$left = $this->GetX();
					$this->Cell(565,$h,'PENGAMBILAN DAN PENYIMPANAN UANG DIBRANGKAS',1,0,'C',true);
					
					$this->Ln(24);
					$left = 20;
					$this->SetFillColor(255);	
					$this->SetX($left);
					$h = 12;
					$this->Cell(282.5,$h,'PENGAMBILAN',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(80,$h,'Jam',1,0,'C',true);
					$this->SetX($left += 80); $this->Cell(101.5,$h,'Diambil Oleh',1,0,'C',true);
					$this->SetX($left += 101.5); $this->Cell(101,$h,'Saksi',1,0,'C',true);
					$this->SetY(296.4);
					$this->SetX($left += 101); $this->Cell(282.5,$h,'PENYIMPANAN',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(80,$h,'Jam',1,0,'C',true);
					$this->SetX($left += 80); $this->Cell(101.5,$h,'Disimpan Oleh',1,0,'C',true);
					$this->SetX($left += 101.5); $this->Cell(101,$h,'Saksi',1,0,'C',true);
					$this->SetY(320.4);

					$this->SetFont('Arial','',9);
					$this->SetWidths(array(80,101.5,101,80,101.5,101));
					$this->SetAligns(array('C','C','C','C','C','C'));


					foreach ($this->data as $baris1) {
						$left = 20;
						$this->SetX($left);
						$this->Row(
							array( 
								date("H:i", strtotime($baris1['k_ambil_jam'])),
								ucfirst($baris1['k_ambil_oleh']),
								ucfirst($baris1['k_ambil_saksi1'])."\n".ucfirst($baris1['k_ambil_saksi2']),
								date("H:i", strtotime($baris1['k_simpan_jam'])),
								ucfirst($baris1['k_simpan_oleh']),
								ucfirst($baris1['k_simpan_saksi1'])."\n".ucfirst($baris1['k_simpan_saksi2']),
						));
						break;
					}


					$h = 24;
					$left = 20;
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(200,200,200);
					$left = $this->GetX();
					$this->Cell(565,$h,'LAPORAN SITUASI',1,0,'C',true);

					$this->SetY(380.4);

					$this->SetFont('Arial','',9);
					$this->SetWidths(array(565));
					$this->SetAligns(array('L'));
					$this->SetFillColor(255);	

					foreach ($this->data as $baris1) {
						$left = 20;
						$this->SetX($left);
						$this->Row(
							array(
								"1. ".ucfirst($baris1['k_laporan_situasi1'])."\n".
								"2. ".ucfirst($baris1['k_laporan_situasi2'])."\n".
								"3. ".ucfirst($baris1['k_laporan_situasi3'])."\n".
								"4. ".ucfirst($baris1['k_laporan_situasi4'])."\n".
								"5. ".ucfirst($baris1['k_laporan_situasi5'])."\n".
								"6. ".ucfirst($baris1['k_laporan_situasi6'])."\n".
								"7. ".ucfirst($baris1['k_laporan_situasi7'])."\n",
						));
						break;
					}



					
					$this->SetFont("", "B", 9);
					$this->Ln(20);
					$h=14;
				
					$left = 20;
					$this->SetX($left += 40); $this->Cell(100,1,'MOD',0,0,'L',true);
					$this->SetX($left += 140); $this->Cell(100,1,'MEP',0,0,'L',true);
					$this->SetX($left += 140); $this->Cell(100,1,'HK',0,0,'L',true);
					$this->SetX($left += 140); $this->Cell(100,1,'SECURITY',0,0,'L',true);

					$connect = mysqli_connect('localhost', 'root', 'ilovejkt48', 'checklist_system_db');
					$query2 = mysqli_query($connect,"SELECT first_name, last_name FROM users WHERE branch_id = '".$branch['id']."' AND user_type = 'manager'");
					$data2 = mysqli_fetch_array($query2,MYSQLI_ASSOC);

					$this->Ln(75);
					$left = 20;
					$this->SetX($left += 20); $this->Cell(150,1, ucfirst($data2['first_name'].' '.$data2['last_name']),0,0,'L',true);
					$this->SetX($left += 120); $this->Cell(150,1,'(........................................)',0,0,'L',true);
					$this->SetX($left += 140); $this->Cell(150,1,'(........................................)',0,0,'L',true);
					$this->SetX($left += 150); $this->Cell(150,1,'(........................................)',0,0,'L',true);
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
				
			$query = "Select 	i.id AS i_id,
								i.item_name AS i_item_name,
								c.item_id AS c_item_id,
								c.bc_opening_status AS c_bc_opening_status,
								c.bc_opening_keterangan AS c_bc_opening_keterangan,
								c.bc_closing_status AS c_bc_closing_status,
								c.bc_closing_keterangan AS c_bc_closing_keterangan,
								k.ambil_jam AS k_ambil_jam,
								k.ambil_oleh AS k_ambil_oleh,
								k.ambil_saksi1 AS k_ambil_saksi1,
								k.ambil_saksi2 AS k_ambil_saksi2,
								k.simpan_jam AS k_simpan_jam,
								k.simpan_oleh AS k_simpan_oleh,
								k.simpan_saksi1 AS k_simpan_saksi1,
								k.simpan_saksi2 AS k_simpan_saksi2,
								k.laporan_situasi1 AS k_laporan_situasi1,
								k.laporan_situasi2 AS k_laporan_situasi2,
								k.laporan_situasi3 AS k_laporan_situasi3,
								k.laporan_situasi4 AS k_laporan_situasi4,
								k.laporan_situasi5 AS k_laporan_situasi5,
								k.laporan_situasi6 AS k_laporan_situasi6,
								k.laporan_situasi7 AS k_laporan_situasi7
						From item i, item_checklist c, kegiatan_security k
						WHERE i.item_area_id = '36' AND i.divisi_id = '5' AND i.id = c.item_id AND Convert(c.checked_at, date) Between '$from_date' AND '$from_date' AND Convert(k.created_at, date) Between '$from_date' AND '$from_date'";
				
			$sql = mysqli_query($link,$query);
			while($row =mysqli_fetch_assoc($sql)){
				array_push($data, $row);
			}
					
			//pilihan
			//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($from_date) . '.pdf';
			$filename = 'report_checklist_sc_kegiatan_security_harian_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
			
			$options = array(
				'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
				'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
				'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
				'orientation'=>'P' //orientation: P=portrait, L=landscape
			);
			
			$tabel = new FPDF_AutoWrapTable($data, $options);
			$tabel->printPDF();
		}
		
		//Jika Checklist Kendaraan
		if($sub_id == 34){
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
					$this->SetX($left); $this->Cell(0, 13, 'CHECKLIST ' . strtoupper($area['name']), 0, 1,'C');
					$this->SetFont("", "", 10);
					$this->Ln(40);
					
					$left = 20;
					$this->SetFont('Arial','',10);
					$this->SetX($left);
					$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
					$this->SetX($left);
					$this->Cell(0, 12, 'Divisi 	     : Security', 0, 1,'L');
					$this->SetX($left);
					$this->Cell(0, 12, 'Tanggal   : '. tgl_indo($from_date), 0, 1,'L');
					$this->Ln(5);
					$h = 36;
					$left = 20;
					$top = 90;	
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(200,200,200);	
					$left = $this->GetX();
					
					$this->Cell(25,$h,'No.',1,0,'C',true);
					$h = 36;
					$this->SetX($left += 25); $this->Cell(100,$h,'Plat Nomor',1,0,'C',true);
					$this->SetX($left += 100); $this->Cell(150,$h,'Jenis Kendaraan',1,0,'C',true);
					$this->SetY(122.4);
					$h = 18;
					$this->SetX($left += 150); $this->Cell(100,$h,'Kondisi Kendaraan',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(50,$h,'Baik',1,0,'C',true);
					$this->SetX($left += 50); $this->Cell(50,$h,'Rusak',1,0,'C',true);
					$h = 36;
					$this->SetY(122.4);
					$this->SetX($left += 50); $this->Cell(180,$h,'Keterangan',1,0,'C',true);

					$this->SetFont('Arial','',10);
					$this->SetWidths(array(25,100,150,50,50,180));
					$this->SetAligns(array('C','L','L','C','L'));
					$this->SetY(158.4);

					$connect = mysqli_connect('localhost', 'root', 'ilovejkt48', 'checklist_system_db'); 
					$query3 = mysqli_query($connect,"SELECT * FROM sc_kendaraan WHERE CONVERT(created_at, date) BETWEEN '$from_date' AND '$from_date' ORDER BY created_at DESC");
					$no=1;
					while($data3 = mysqli_fetch_array($query3,MYSQLI_ASSOC)){
						if ($data3['kondisi_kendaraan'] == '1') {
							$kondisi_baik = 'V';
							$kondisi_rusak = '';
						}
						elseif ($data3['kondisi_kendaraan'] == '0') {
							$kondisi_baik = '';
							$kondisi_rusak = 'V';
						}
						$left = 20;
						$this->SetX($left);
						$this->Row(
							array(
								$no++,
								ucfirst($data3['plat_kendaraan']),
								ucfirst($data3['jenis_kendaraan']),
								$kondisi_baik,
								$kondisi_rusak,
								ucfirst($data3['keterangan']),
						));
					}

					$this->SetFont("", "B", 9);
					$this->SetFillColor(255);
					$this->Ln(25);
					$left = 0;
					$h=14;
					
					$this->SetX($left += 40); $this->Cell(100,$h,'Dibuat Oleh :',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Diketahui Oleh :',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Diperiksa Oleh :',0,0,'L',true);
					$this->Ln(25);
					$left = 0;
					$this->SetX($left += 40); $this->Cell(100,1,'Anggota Security',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'Koor. Lap',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'Pimpinan Outlet / MOD',0,0,'L',true);

					$query2 = mysqli_query($connect,"SELECT first_name, last_name FROM users WHERE branch_id = '".$branch['id']."' AND user_type = 'manager'");
					$data2 = mysqli_fetch_array($query2,MYSQLI_ASSOC);

					$this->Ln(90);
					$left = 0;
					$this->SetX($left += 40); $this->Cell(100,1,'(...................................)',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1,'(...................................)',0,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,1, ucfirst($data2['first_name'].' '.$data2['last_name']),0,0,'L',true);
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
			$data = array();
					
			//pilihan
			//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($from_date) . '.pdf';
			$filename = 'report_checklist_sc_kendaraan_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
			
			$options = array(
				'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
				'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
				'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
				'orientation'=>'P' //orientation: P=portrait, L=landscape
			);
			
			$tabel = new FPDF_AutoWrapTable($data, $options);
			$tabel->printPDF();
		}
	
		//Jika Checklist Laporan Situasi
		if($sub_id == 35){
			require_once("../assets/pdf/fpdf/fpdf.php");
			$time_now 	=  date('Y-m-d H:i:s');
			$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
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
					$this->SetX($left); $this->Cell(0, 13, strtoupper($area['name']), 0, 1,'C');
					$this->SetFont("", "", 10);
					$this->Ln(40);
					
					$left = 20;
					$this->SetFont('Arial','',10);
					$this->SetX($left);
					$this->Cell(0, 12, 'Cabang   : ' . ucwords($branch['name']), 0, 1,'L');
					$this->SetX($left);
					$this->Cell(0, 12, 'Divisi 	     : Security', 0, 1,'L');
					$this->SetX($left);
					$this->Cell(0, 12, 'Tanggal   : '. tgl_indo($from_date), 0, 1,'L');
					$this->SetFont('Arial','',10);
					$this->Ln(20);
					$this->SetX($left);
					$connect = mysqli_connect('localhost','root','ilovejkt48','checklist_system_db');
					$query4 = mysqli_query($connect,"SELECT * FROM sc_laporan_situasi WHERE CONVERT(created_at, date) BETWEEN '$from_date' AND '$from_date'");
					$data4 = mysqli_fetch_array($query4,MYSQLI_ASSOC);

					//Pagi Keterangan 1
					if ($data4['pagi_keterangan1'] == '0') {
						$pagi_keterangan1 = '';
					}
					elseif ($data4['pagi_keterangan1'] == '1') {
						$pagi_keterangan1 = 'Sakit';
					}
					elseif ($data4['pagi_keterangan1'] == '2') {
						$pagi_keterangan1 = 'Izin';
					}
					elseif ($data4['pagi_keterangan1'] == '3') {
						$pagi_keterangan1 = 'Alfa';
					}

					//Pagi Keterangan 2
					if ($data4['pagi_keterangan2'] == '0') {
						$pagi_keterangan2 = '';
					}
					elseif ($data4['pagi_keterangan2'] == '1') {
						$pagi_keterangan2 = 'Sakit';
					}
					elseif ($data4['pagi_keterangan2'] == '2') {
						$pagi_keterangan2 = 'Izin';
					}
					elseif ($data4['pagi_keterangan2'] == '3') {
						$pagi_keterangan2 = 'Alfa';
					}

					//Pagi Keterangan 3
					if ($data4['pagi_keterangan3'] == '0') {
						$pagi_keterangan3 = '';
					}
					elseif ($data4['pagi_keterangan3'] == '1') {
						$pagi_keterangan3 = 'Sakit';
					}
					elseif ($data4['pagi_keterangan3'] == '2') {
						$pagi_keterangan3 = 'Izin';
					}
					elseif ($data4['pagi_keterangan3'] == '3') {
						$pagi_keterangan3 = 'Alfa';
					}

					//Pagi Keterangan 4
					if ($data4['pagi_keterangan4'] == '0') {
						$pagi_keterangan4 = '';
					}
					elseif ($data4['pagi_keterangan4'] == '1') {
						$pagi_keterangan4 = 'Sakit';
					}
					elseif ($data4['pagi_keterangan4'] == '2') {
						$pagi_keterangan4 = 'Izin';
					}
					elseif ($data4['pagi_keterangan4'] == '3') {
						$pagi_keterangan4 = 'Alfa';
					}

					//Pagi Keterangan 5
					if ($data4['pagi_keterangan5'] == '0') {
						$pagi_keterangan5 = '';
					}
					elseif ($data4['pagi_keterangan5'] == '1') {
						$pagi_keterangan5 = 'Sakit';
					}
					elseif ($data4['pagi_keterangan5'] == '2') {
						$pagi_keterangan5 = 'Izin';
					}
					elseif ($data4['pagi_keterangan5'] == '3') {
						$pagi_keterangan5 = 'Alfa';
					}

					//Siang Keterangan 1
					if ($data4['siang_keterangan1'] == '0') {
						$siang_keterangan1 = '';
					}
					elseif ($data4['siang_keterangan1'] == '1') {
						$siang_keterangan1 = 'Sakit';
					}
					elseif ($data4['siang_keterangan1'] == '2') {
						$siang_keterangan1 = 'Izin';
					}
					elseif ($data4['siang_keterangan1'] == '3') {
						$siang_keterangan1 = 'Alfa';
					}

					//Siang Keterangan 2
					if ($data4['siang_keterangan2'] == '0') {
						$siang_keterangan2 = '';
					}
					elseif ($data4['siang_keterangan2'] == '1') {
						$siang_keterangan2 = 'Sakit';
					}
					elseif ($data4['siang_keterangan2'] == '2') {
						$siang_keterangan2 = 'Izin';
					}
					elseif ($data4['siang_keterangan2'] == '3') {
						$siang_keterangan2 = 'Alfa';
					}

					//Siang Keterangan 3
					if ($data4['siang_keterangan3'] == '0') {
						$siang_keterangan3 = '';
					}
					elseif ($data4['siang_keterangan3'] == '1') {
						$siang_keterangan3 = 'Sakit';
					}
					elseif ($data4['siang_keterangan3'] == '2') {
						$siang_keterangan3 = 'Izin';
					}
					elseif ($data4['siang_keterangan3'] == '3') {
						$siang_keterangan3 = 'Alfa';
					}

					//Siang Keterangan 4
					if ($data4['siang_keterangan4'] == '0') {
						$siang_keterangan4 = '';
					}
					elseif ($data4['siang_keterangan4'] == '1') {
						$siang_keterangan4 = 'Sakit';
					}
					elseif ($data4['siang_keterangan4'] == '2') {
						$siang_keterangan4 = 'Izin';
					}
					elseif ($data4['siang_keterangan4'] == '3') {
						$siang_keterangan4 = 'Alfa';
					}

					//Siang Keterangan 5
					if ($data4['siang_keterangan5'] == '0') {
						$siang_keterangan5 = '';
					}
					elseif ($data4['siang_keterangan5'] == '1') {
						$siang_keterangan5 = 'Sakit';
					}
					elseif ($data4['siang_keterangan5'] == '2') {
						$siang_keterangan5 = 'Izin';
					}
					elseif ($data4['siang_keterangan5'] == '3') {
						$siang_keterangan5 = 'Alfa';
					}

					//Malam Keterangan 1
					if ($data4['malam_keterangan1'] == '0') {
						$malam_keterangan1 = '';
					}
					elseif ($data4['malam_keterangan1'] == '1') {
						$malam_keterangan1 = 'Sakit';
					}
					elseif ($data4['malam_keterangan1'] == '2') {
						$malam_keterangan1 = 'Izin';
					}
					elseif ($data4['malam_keterangan1'] == '3') {
						$malam_keterangan1 = 'Alfa';
					}

					//Malam Keterangan 2
					if ($data4['malam_keterangan2'] == '0') {
						$malam_keterangan2 = '';
					}
					elseif ($data4['malam_keterangan2'] == '1') {
						$malam_keterangan2 = 'Sakit';
					}
					elseif ($data4['malam_keterangan2'] == '2') {
						$malam_keterangan2 = 'Izin';
					}
					elseif ($data4['malam_keterangan2'] == '3') {
						$malam_keterangan2 = 'Alfa';
					}

					//Malam Keterangan 3
					if ($data4['malam_keterangan3'] == '0') {
						$malam_keterangan3 = '';
					}
					elseif ($data4['malam_keterangan3'] == '1') {
						$malam_keterangan3 = 'Sakit';
					}
					elseif ($data4['malam_keterangan3'] == '2') {
						$malam_keterangan3 = 'Izin';
					}
					elseif ($data4['malam_keterangan3'] == '3') {
						$malam_keterangan3 = 'Alfa';
					}

					//Malam Keterangan 4
					if ($data4['malam_keterangan4'] == '0') {
						$malam_keterangan4 = '';
					}
					elseif ($data4['malam_keterangan4'] == '1') {
						$malam_keterangan4 = 'Sakit';
					}
					elseif ($data4['malam_keterangan4'] == '2') {
						$malam_keterangan4 = 'Izin';
					}
					elseif ($data4['malam_keterangan4'] == '3') {
						$malam_keterangan4 = 'Alfa';
					}

					//Malam Keterangan 5
					if ($data4['malam_keterangan5'] == '0') {
						$malam_keterangan5 = '';
					}
					elseif ($data4['malam_keterangan5'] == '1') {
						$malam_keterangan5 = 'Sakit';
					}
					elseif ($data4['malam_keterangan5'] == '2') {
						$malam_keterangan5 = 'Izin';
					}
					elseif ($data4['malam_keterangan5'] == '3') {
						$malam_keterangan5 = 'Alfa';
					}

					$this->Cell(0, 12, 'Pada hari ini dilaporkan situasi dan kondisi pengamanan di lokasi dalam keadaan : ',0,1,'L');
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					$this->Cell(0, 24, ucfirst($data4['keadaan']),0,1,'L');

					$h = 12;
					$left = 15;
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(255);	
					$left = $this->GetX();
					$this->Cell(250,$h,'I. KONDISI PERSONIL',0,0,'L',true);

					//Shift Pagi
					$this->SetY(197.4);
					$h = 24;
					$left = 23;
					$top = 90;	
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(200,200,200);	
					$left = $this->GetX();
					
					$this->Cell(250,$h,'Shift Pagi',1,0,'C',true);
					$h = 12;
					$this->SetX($left += 250); $this->Cell(300,$h,'Keterangan Tidak Hadir',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(200,$h,'Nama',1,0,'C',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Keterangan',1,0,'C',true);
					
					$this->SetY(221.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Jumlah                 :     '.$data4['pagi_jumlah'].' Personil',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['pagi_nama1'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$pagi_keterangan1,1,0,'L',true);

					$this->SetY(233.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Hadir                    :     '.$data4['pagi_hadir'].' Personil',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['pagi_nama2'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$pagi_keterangan2,1,0,'L',true);

					$this->SetY(245.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Tidak Hadir          :     '.$data4['pagi_tidak_hadir'].' Personil',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['pagi_nama3'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$pagi_keterangan3,1,0,'L',true);

					$this->SetY(257.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Backup                :     '.$data4['pagi_backup'].' Personil',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['pagi_nama4'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$pagi_keterangan4,1,0,'L',true);

					$this->SetY(269.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['pagi_nama5'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$pagi_keterangan5,1,0,'L',true);
					//End Shift Pagi

					//Shift Siang
					$this->SetY(293.4);
					$h = 24;
					$left = 23;
					$top = 90;	
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(200,200,200);	
					$left = $this->GetX();
					
					$this->Cell(250,$h,'Shift Siang',1,0,'C',true);
					$h = 12;
					$this->SetX($left += 250); $this->Cell(300,$h,'Keterangan Tidak Hadir',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(200,$h,'Nama',1,0,'C',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Keterangan',1,0,'C',true);
					
					$this->SetY(317.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Jumlah                 :     '.$data4['siang_jumlah'].' Personil',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['siang_nama1'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$siang_keterangan1,1,0,'L',true);

					$this->SetY(329.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Hadir                    :     '.$data4['siang_hadir'].' Personil',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['siang_nama2'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$siang_keterangan2,1,0,'L',true);

					$this->SetY(341.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Tidak Hadir          :     '.$data4['siang_tidak_hadir'].' Personil',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['siang_nama3'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$siang_keterangan3,1,0,'L',true);

					$this->SetY(353.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Backup                :     '.$data4['siang_backup'].' Personil',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['siang_nama4'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$siang_keterangan4,1,0,'L',true);

					$this->SetY(365.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['siang_nama5'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$siang_keterangan5,1,0,'L',true);
					//End Shift Siang

					//Shift Malam
					$this->SetY(389.4);
					$h = 24;
					$left = 23;
					$top = 90;	
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(200,200,200);	
					$left = $this->GetX();
					
					$this->Cell(250,$h,'Shift Malam',1,0,'C',true);
					$h = 12;
					$this->SetX($left += 250); $this->Cell(300,$h,'Keterangan Tidak Hadir',1,1,'C',true);
					$this->SetX($left += 0); $this->Cell(200,$h,'Nama',1,0,'C',true);
					$this->SetX($left += 200); $this->Cell(100,$h,'Keterangan',1,0,'C',true);
					
					$this->SetY(413.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Jumlah                 :     '.$data4['malam_jumlah'].' Personil',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['malam_nama1'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$malam_keterangan1,1,0,'L',true);

					$this->SetY(425.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Hadir                    :     '.$data4['malam_hadir'].' Personil',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['malam_nama2'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$malam_keterangan2,1,0,'L',true);

					$this->SetY(437.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Tidak Hadir          :     '.$data4['malam_tidak_hadir'].' Personil',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['malam_nama3'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$malam_keterangan3,1,0,'L',true);

					$this->SetY(449.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Backup                :     '.$data4['malam_backup'].' Personil',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['malam_nama4'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$malam_keterangan4,1,0,'L',true);

					$this->SetY(461.4);
					$h = 12;
					$this->SetX(23);
					$this->SetFont('Arial','',9);
					#tableheader
					$this->SetFillColor(250);	
					$left = $this->GetX();
					$this->Cell(250,$h,'',1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,$data4['malam_nama5'],1,0,'L',true);
					$this->SetX($left += 200); $this->Cell(100,$h,$malam_keterangan5,1,0,'L',true);
					//End Shift Malam

					$this->SetY(485.4);
					$h = 12;
					$left = 23;
					$top = 90;	
					$this->SetX($left);
					$this->SetFont('Arial','',10);
					#tableheader
					$this->SetFillColor(255);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Lembur          :     '.$data4['lembur_jumlah'].' Personil',0,1,'L',true);

					$this->SetY(497.4);
					$h = 12;
					$left = 23;
					$top = 90;	
					$this->SetX($left);
					$this->SetFont('Arial','',10);
					#tableheader
					$this->SetFillColor(255);	
					$left = $this->GetX();
					$this->Cell(250,$h,'Keterangan : '.$data4['lembur_keterangan'],0,1,'L',true);

					$this->SetY(533.4);
					$h = 12;
					$left = 15;
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(255);	
					$left = $this->GetX();
					$this->Cell(250,$h,'II. KONDISI MATERIIL',0,0,'L',true);

					$this->SetY(545.4);
					$h = 24;
					$left = 23;
					$top = 90;	
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(200,200,200);	
					$left = $this->GetX();
					
					$this->Cell(250,$h,'Kondisi',1,0,'C',true);
					$this->SetX($left += 250); $this->Cell(300,$h,'Keterangan',1,0,'C',true);

					$this->SetY(569.4);
					$this->SetFont('Arial','',9);
					$h = 12;
					$left = 23;
					$top = 90;	
					$this->SetX($left);
					$this->SetFillColor(255);	
					$left = $this->GetX();
					$this->Cell(250,$h,ucfirst($data4['materiil_kondisi1']),1,0,'L',true);
					$this->SetX($left += 250); $this->Cell(300,60,'Keterangan',1,0,'L',true);

					$this->SetY(581.4);
					$h = 12;
					$left = 23;
					$this->SetX($left);
					$left = $this->GetX();
					$this->Cell(250,$h,ucfirst($data4['materiil_kondisi2']),1,0,'L',true);

					$this->SetY(593.4);
					$h = 12;
					$left = 23;
					$this->SetX($left);
					$left = $this->GetX();
					$this->Cell(250,$h,ucfirst($data4['materiil_kondisi3']),1,0,'L',true);

					$this->SetY(605.4);
					$h = 12;
					$left = 23;
					$this->SetX($left);
					$left = $this->GetX();
					$this->Cell(250,$h,ucfirst($data4['materiil_kondisi4']),1,0,'L',true);

					$this->SetY(617.4);
					$h = 12;
					$left = 23;
					$this->SetX($left);
					$left = $this->GetX();
					$this->Cell(250,$h,ucfirst($data4['materiil_kondisi5']),1,0,'L',true);



					$this->SetY(653.4);
					$h = 12;
					$left = 15;
					$this->SetX($left);
					$this->SetFont('Arial','B',10);
					#tableheader
					$this->SetFillColor(255);	
					$left = $this->GetX();
					$this->Cell(250,$h,'III. AKTIVITAS',0,0,'L',true);

					$this->SetY(665.4);
					$this->SetFont('Arial','',9);
					$h = 12;
					$left = 23;
					$top = 90;	
					$this->SetX($left);
					$this->SetFillColor(255);	
					$left = $this->GetX();
					$this->Cell(550,$h,ucfirst($data4['aktivitas1']),1,0,'L',true);

					$this->SetY(677.4);
					$h = 12;
					$left = 23;
					$this->SetX($left);
					$left = $this->GetX();
					$this->Cell(550,$h,ucfirst($data4['aktivitas2']),1,0,'L',true);

					$this->SetY(689.4);
					$h = 12;
					$left = 23;
					$this->SetX($left);
					$left = $this->GetX();
					$this->Cell(550,$h,ucfirst($data4['aktivitas3']),1,0,'L',true);

					$this->SetY(701.4);
					$h = 12;
					$left = 23;
					$this->SetX($left);
					$left = $this->GetX();
					$this->Cell(550,$h,ucfirst($data4['aktivitas4']),1,0,'L',true);

					$this->SetY(713.4);
					$h = 12;
					$left = 23;
					$this->SetX($left);
					$left = $this->GetX();
					$this->Cell(550,$h,ucfirst($data4['aktivitas5']),1,0,'L',true);


					$this->SetFont("", "B", 9);
					$this->SetFillColor(255);
					$this->Ln(25);
					$left = 0;
					$h=14;
					$this->SetX($left += 150); $this->Cell(200,$h,'Dibuat Oleh :',0,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,$h,'Mengetahui :',0,0,'L',true);
					$this->Ln(25);
					$left = 0;
					$this->SetX($left += 150); $this->Cell(200,1,'Koordinator Lapangan',0,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,1,'Pimpinan Outlet',0,0,'L',true);

					$query2 = mysqli_query($connect,"SELECT first_name, last_name FROM users WHERE branch_id = '".$branch['id']."' AND user_type = 'manager'");
					$data2 = mysqli_fetch_array($query2,MYSQLI_ASSOC);

					$this->Ln(90);
					$left = 0;
					$this->SetX($left += 150); $this->Cell(200,1,'(........................................)',0,0,'L',true);
					$this->SetX($left += 250); $this->Cell(200,1, ucfirst($data2['first_name'].' '.$data2['last_name']),0,0,'L',true);
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
			$data = array();
					
			//pilihan
			//$filename = 'report_checklist_hk_' . $area['name'] . '_'. tgl_indo($from_date) . '.pdf';
			$filename = 'report_checklist_sc_laporan_situasi_' .  str_replace(' ', '', date(tgl_short($from_date))) . '.pdf';
			
			$options = array(
				'filename' => $filename, //nama file penyimpanan, kosongkan jika output ke browser
				'destinationfile' => 'D', //I=inline browser (default), F=local file, D=download
				'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
				'orientation'=>'P' //orientation: P=portrait, L=landscape
			);
			
			$tabel = new FPDF_AutoWrapTable($data, $options);
			$tabel->printPDF();
		}
	}
?>