<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION[password])){
		header('location:login.php');
	}else{
		include '../core/init.php';
		include '../core/helper/myHelper.php';
		include 'alert/alert.php';
	
		$branch = $db->branch()
					->where("id", $_SESSION['branch_id'])
					->fetch();
		$user = $db->users()
					->where("id", $_SESSION['id'])
					->fetch();
		$barcode = str_replace(' ', '', $_POST['barcode']);
        //var_dump($barcode); die();
        
		$customer_name 	= ucwords($_POST['customer_name']);
		$customer_email = $_POST['customer_email'];
		$voucher_id 	= $_POST['voucher_id'];
		$branch_id 		= $_SESSION['branch_id'];
		$users_id 		= $_SESSION['id'];
		$created_at     = date('Y-m-d H:i:s');
		//var_dump($_POST); die();
		$insert_evcr_cust = $db->evoucher_customer()->insert(array(
			"name"  => $customer_name,
			"email" => $customer_email,
			"voucher_id"    => $voucher_id,
			"users_id"       => $users_id,
			"created_at"     => $created_at
		));
		
		if($insert_evcr_cust->evoucher_customer()){
		
            $voucher = $db->voucher[$voucher_id];

            if ($voucher){
                $active_date = date('Y-m-d H:i:s');
                $expire_date = date('Y-m-d H:i:s', strtotime('+3 month'));
              
                $data = array(
                        "status" => 'ACTIVE',
                        "active_date" 	=> $active_date,
                        "expire_date" 	=> $expire_date
                    );
                
                $result = $voucher->update($data);
               
                if($result){
                    $send_mail_notification = sendMail($customer_name, $customer_email, $barcode);
                   
                    if($send_mail_notification = true){
                        
                        echo "<button id='btnShowAlert' style='display:none;'></button>
                                <script type='text/javascript'>
                                sweetAlert({
                                        title: 'Sukses!',
                                        text: 'Voucher Berhasil Di Aktifkan!',
                                        type: 'success'
                                    },
                                    function () {
                                        window.location.href = '../content.php?module=evoucher&act=aktivasi&id=$voucher_id';
                                    });
                                </script>";
                        exit();	
                    }
                }
            }
		}
	}
?>