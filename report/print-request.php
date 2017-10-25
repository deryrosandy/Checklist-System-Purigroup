<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('../location:login.php');
	}else{
		
		$from_date =  date('Y/m/d', strtotime($_POST['from_date']));
		//$to_date =  date('Y/m/d', strtotime($_POST['to_date']));
		
		//var_dump($from_date);
		//var_dump($to_date);
		
		include '../core/init.php';
		include '../core/helper/myHelper.php';
		require ('../assets/pdf/fpdf/fpdf.php');
		
		$reqid = $_GET['id'];
		
		$request = $db->request()
						->where("id", $reqid)
						->fetch();
		
		$userid = $_SESSION['id'];
		
		$branch = $db->users("id", $request['branch'])->fetch();
		
		$branch_name = $request->branch["name"];
		
		$pdf = new FPDF("P","cm","A4");

		$pdf->SetMargins(2,1,1);
		$pdf->SetLeftMargin(1.2);
		$pdf->setRightMargin(1.2);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','BU',16);            
		$pdf->MultiCell(0,0.5,'Inventory Request Sheet',0,'C');
		$pdf->SetFont('Times','B',16); 
		$pdf->MultiCell(0,0.8,'(IRS)',0,'C');
		$pdf->ln(1);
		$pdf->SetFont('Times','B',10);
		
		$time_now =  date('Y-m-d H:i:s');
		
		$datenow = tgl_indo($from_date);
		$timenow =  date('H:i');
		
		$pdf->SetFont('Arial','',12);
		
		$pdf->MultiCell(19.5,0.5,"No. IRS : " . $request['noreq'] ,0,'L');    
		$pdf->MultiCell(19.5,0.5,"Nama Barang : " . $request['title'] ,0,'L');    
		$pdf->MultiCell(19.5,0.5,"Outlet : " . $branch_name ,0,'L');    
		$outlet = $branch;
		$pdf->ln(0.3);

		$pdf->ln(0);
		$pdf->SetFont('Arial','B',9);

		$pdf->setFillColor(200,200,200);
		$pdf->Cell(0.8,0.9,'NO.',1,0,'C',1);
		$pdf->Cell(6,0.9,'AREA',1,0,'C',1);
		$pdf->Cell(2.2,0.9,'STATUS',1,0,'C',1);
		$pdf->Cell(8.5,0.9,'KETERANGAN',1,1,'C',1);

		$items_checklist = $db->item_checklist();

		$item_area = $db->item_area()
						->where("divisi_id", 1)
						->where("branch_id", 1);
		
		$no=1;
		foreach ($item_area as $area){
			$pdf->SetFont('Arial','B',8);
			$pdf->setFillColor(255,255,255);
			$pdf->Cell(0.8, 0.5, $no, 1, 0,'C',0);
			$pdf->Cell(16.7, 0.5, strtoupper($area['name']), 1, 1,'L',1);
			
			//foreach ($item_select as $checklist){
				$con = mysqli_connect("localhost","root","ilovejkt48","checklist_system_db");
				
				$user_id = $_SESSION['id'];
				$id_area = $area['id'];
				
				$sql = "select item_checklist.item_id, item_checklist.description, item_checklist.item_status_id, item_checklist.checked_at, 
						item.id as item_id, item.item_name as item_name, item.item_area_id as area_id
						from item_checklist
						LEFT JOIN item on item_checklist.item_id=item.id
						WHERE item_area_id='$id_area' AND Convert(checked_at, date) Between '$from_date' AND '$from_date'
						ORDER BY area_id";
				/*
				$sql = "select item_checklist.item_id, item_checklist.description, item_checklist.item_status_id, item_checklist.checked_at, 
						item.id as item_id, item.item_name as item_name, item.item_area_id as area_id
						from item_checklist
						LEFT JOIN item on item_checklist.item_id=item.id
						WHERE item_area_id='$id_area' AND Convert(checked_at, date) Between '$startd' AND '$endd'
						ORDER BY area_id";
				*/
				
				$data = mysqli_query($con,$sql); //or die(mysql_error);
				
				if ($data->num_rows > 0) {
				
				$pdf->SetFont('Arial','',8);
					While ($checklist = $data->fetch_assoc()){

						if ($checklist['item_status_id']==2){
							$pdf->setFillColor(223,237,231);
							
							$pdf->Cell(0.8, 0.5,'' , 1, 0,'L',1);
							$pdf->Cell(6, 0.5, ucwords('  - '. $checklist['item_name']), 1, 0,'L',1);
							$pdf->Cell(2.2, 0.5, status_item($checklist['item_status_id']), 1, 0,'C',1);	
							$pdf->Cell(8.5, 0.5, $checklist['description'], 1, 1,'L',1);
						}else{
							$pdf->setFillColor(255,255,255);
							$pdf->Cell(0.8, 0.5,'' , 1, 0,'L',1);
							$pdf->Cell(6, 0.5, ucwords('  - '. $checklist['item_name']), 1, 0,'L',0);
							$pdf->Cell(2.2, 0.5, status_item($checklist['item_status_id']), 1, 0,'C',0);	
							$pdf->Cell(8.5, 0.5, $checklist['description'], 1, 1,'L',0);
						}
					}
				}else{
					$pdf->Cell(0.8, 0.5,'' , 1, 0,'L',1);
					$pdf->Cell(6, 0.5, ucwords('-'), 1, 0,'C',0);
					$pdf->Cell(2.2, 0.5, '-', 1, 0,'C',0);	
					$pdf->Cell(8.5, 0.5, '-', 1, 1,'C',0);
				}
			/*
			$pdf->Cell(1.8, 0.8, status_item($item['item_status']), 1, 0,'C');
			
			*/
			$pdf->SetFont('Arial','',6);
			$no++;
		}
		
		$filename = 'report_checklist_it_' . $datenow . '.pdf';
		$pdf->Output($filename,'I');
	
	}
?>