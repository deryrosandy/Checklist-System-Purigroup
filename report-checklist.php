<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}else{
		include 'core/init.php';
		include 'core/helper/myHelper.php';
		require ('assets/pdf/fpdf/fpdf.php');

		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		
		$pdf = new FPDF("P","cm","A4");
		$pdf = new FPDF("P","cm","A4");

		$pdf->SetMargins(2,1,1);
		$pdf->SetLeftMargin(2.2);
		$pdf->setRightMargin(2.2);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','BU',14);            
		$pdf->MultiCell(0,0.5,'CHECKLIST IT',0,'C');
		$pdf->ln(1);
		$pdf->SetFont('Times','B',10);

		$tanggal_check = '28 Juli 2016';
		$jam_check = '11:42';
		$pdf->MultiCell(19.5,0.5,"Tanggal / Jam Check : " . $tanggal_check . " / " . $jam_check ,0,'L');    
		$outlet = "Surabaya 1";
		$pdf->MultiCell(0,0.5,"Outlet : " . $outlet,0,'L');
		$pdf->ln(0.3);

		$pdf->ln(0);
		$pdf->SetFont('Arial','B',9);

		$pdf->setFillColor(0,102,204);
		$pdf->Cell(6,1,'AREA',1,0,'C',1);
		$pdf->Cell(2.2,1,'STATUS',1,0,'C',1);
		$pdf->Cell(6.5,1,'KETERANGAN',1,1,'C',1);

		$items_checklist = $db->item_checklist();

		$item_area = $db->item_area();
		
		foreach ($item_area as $area){
			$pdf->SetFont('Arial','B',9);
			$pdf->setFillColor(102,178,255);
			$pdf->Cell(14.7, 0.8, strtoupper($area['name']), 1, 1,'L',1);
			
			//foreach ($item_select as $checklist){
				$con = mysqli_connect("localhost","root","ilovejkt48","checklist_system_db");

				$sql = "select * from item_checklist WHERE user_id='1' AND Convert(checked_at, date) Between '20160727' AND '20160728'";

				$data = mysqli_query($con,$sql); //or die(mysql_error);

				//var_dump(count($data));

				While ($checklist = mysqli_fetch_array($data)) {

					if ($checklist['item_status_id']==2){
						$pdf->setFillColor(255,255,0);
						
						$pdf->Cell(6, 0.8, ucwords($checklist['item_id']), 1, 0,'L',1);
						$pdf->Cell(2.2, 0.8, status_item($checklist['item_status_id']), 1, 0,'C',1);	
						$pdf->Cell(6.5, 0.8, $checklist['description'], 1, 1,'L',1);
					}else{
						$pdf->Cell(6, 0.8, ucwords($checklist['item_id']), 1, 0,'L',0);
						$pdf->Cell(2.2, 0.8, status_item($checklist['item_status_id']), 1, 0,'C',0);	
						$pdf->Cell(6.5, 0.8, $checklist['description'], 1, 1,'L',0);		}
				}
			/*
			$pdf->Cell(1.8, 0.8, status_item($item['item_status']), 1, 0,'C');
			
			*/
			$pdf->SetFont('Arial','',8);
		}
	
			$pdf->Output('report_checklist_it.pdf','I');
	
	}
?>