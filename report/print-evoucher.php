<?php 
	require_once("assets/pdf/pdf.php");
	
	$voucher_id 	= $_GET['voucher_id'];
	$customer_name 	= $_GET['customer_name'];
	
	$voucher = $db->voucher()
				->where("id",$voucher_id)
				->fetch();
				
	$user = $db->users()
			->where("id", "73")
			->fetch();
	
	$branch_name = $user->branch['name'];
	
	$user_name = $user['first_name'];
							
	$v_transaction = $db->voucher_history()
							->where("voucher_id", $voucher_id)
							->fetch();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
				<td colspan="3" align="center" style="font-size:300%" ><strong>E-VOUCHER</strong></td>
			</tr>
			<tr>
				<td colspan="3" align="center" ><?php echo $branch_name; ?></td>
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
				<td width="30%">Transaction Code</td><td width="10%">:</td><td colspan="2"><?php echo $v_transaction["id"]; ?></td>
			</tr> 
			<tr>
				<td>Customer Name</td><td>:</td><td colspan="2"><?php echo $customer_name; ?></td>
			</tr>
		</table>
	</body>
</html>