<?php 
	session_start();
	
	if(empty($_SESSION['username']) AND empty($_SESSION[password])) {
		header('location:login.php');
	}
	
	include 'core/init.php';
	include 'core/helper/myHelper.php';
	require_once("assets/pdf/pdf.php");
	
	$voucher_id 	= $_GET['voucher_id'];
	$customer_name 	= $_GET['customer_name'];
	
	$voucher = $db->voucher()
				->where("id",$voucher_id)
				->fetch();
	
	$user = $db->users()
			->where("id",  $_SESSION['id'])
			->fetch();
	
	$branch_name = $user->branch['name'];
	
	$user_name = $user['first_name'];
							
	$v_transaction = $db->voucher_history()
							->where("voucher_id", $voucher_id)
							->fetch();
?>
<?php
			$html .= '';
			//$html .= include('report/print-evoucher.php');		
			$html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							<title><?php echo $title; ?></title>
							<style type="text/css">
								html {
										margin : 0px;
								}
								table.gridtable {
									font-family: times,arial,sans-serif;
									font-size:9px;
									width: 6.800cm; 
									
								}
								table.gridtable td {
									padding: 0px;
									text-align: left;
								}
							</style>
								
							</head>
							<body>
								<table class="gridtable">
									<tr>
										<td colspan="3" align="center" style="font-size:250%" ><strong>E-VOUCHER</strong></td>
									</tr>
									<tr>
										<td colspan="3" align="center" style="font-size:150%" >';
			$html .= $branch_name;
			$html .= '</td>
									</tr>
									<tr>
										<td colspan="3" align="center" >www.deltaspa.net</td>
									</tr>
									<tr>
										<td colspan="3" align="center" ></td>
									</tr>
								</table>
								<table class="gridtable">
									<tr>
										<td colspan="4" align="center" ><hr/></td>
									</tr>
									<tr>
										<td colspan="4" align="center"><br/></td>
									</tr>
									<tr>
										<td width="40%">Transaction Code</td><td width="10%">:</td><td colspan="2">';
			$html .= $v_transaction["id"];
			$html .= '</td>
									</tr> 
									<tr>
										<td>Customer Name</td><td>:</td><td colspan="2">';
			$html .= $customer_name;
			$html .= '</td>
									</tr>
									<tr>
										<td>Date</td><td>:</td><td colspan="2">';
			$html .= date("d/m/Y");
			$html .= '</td>
									</tr>
								</table>
								<table class="gridtable">
									<tr>
										<td colspan="2" align="center" ></td>
									</tr>
									<tr>
										<td colspan="2" width="100%" align="center" >Barcode</td></tr><tr><td colspan="2" align="center" width="100%" style="font-size:180%"><strong>';
			$html .= $voucher["barcode"];
			$html .= '</strong></td></tr>									
									<tr>
										<td colspan="2" width="100%" align="center" >Nominal</td></tr><tr><td colspan="2" align="center" width="100%" style="font-size:180%"><strong>';
			$html .= $voucher["nominal"] . ' POINT';
			$html .= '</strong></td></tr>
								</table>
								<table class="gridtable">
									<tr>
										<td colspan="3" align="center"><br/></td>
									</tr>
									<tr>
										<td colspan="3" align="center" ><hr/></td>
									</tr>
									<tr>
										<td colspan="3" align="center"><br/></td>
									</tr>
									<tr>
										<td width="35%">Transaction By</td>
										<td width="10%">:</td>
										<td width="55%">';
			$html .= $user_name;
			$html .= '</td>
									</tr>
									<tr>
										<td colspan="3" height="10px"></td>
									</tr>
									<tr>
										<td colspan="3" align="center">Terima Kasih Atas Kunjungan Anda</td>
									</tr>
								</table>
							</body>
						</html>';		
			//var_dump($html);die();
			ob_end_clean();
			$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		
			$pdf->SetTitle('e-Voucher Delta SPA');
			$pdf->SetAutoPageBreak(false);
			$pdf->SetAuthor('Dery Rosandy');
			$pdf->SetDisplayMode('real', 'default');
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$pdf->SetMargins(7, 0, 0);
			$pdf->AddPage();
			
			$pdf->writeHTML($html, true, false, true, false, '');
			
			$pdf->lastPage();
			
			$pdf->Output('Voucher-Bill.pdf', 'I');
?>