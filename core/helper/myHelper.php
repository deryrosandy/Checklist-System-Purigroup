<?php
function jenis_kel($jenis) {
	
	$jenis_kelamin = array("Perempuan", "Laki-laki");
	
	$result = $jenis_kelamin[$jenis];
	
	return($result);
}

function status($user_type) {
				
	$user = array("Tidak Aktif","Aktif");
	
	$result = $user[$user_type];
	
	return($result);
}

function color_req_status($request_id) {
	switch ($request_id){
		case "Approve":
			return "success";
			break;
		case "Reject":
			return "danger";
			break;
		case "Pending":
			return "warning";
			break;
	}
}

function icon_req_status($request_id) {
	switch ($request_id){
		case "Approve":
			return "glyphicon-ok";
			break;
		case "Reject":
			return "glyphicon-remove";
			break;
		case "Pending":
			return "glyphicon-pause";
			break;
	}
}

function status_item($status_id) {
				
	$status = array("11","BAGUS","RUSAK");
	
	$result = $status[$status_id];
	
	return($result);
}

function kondisi_item($kondisi_id) {
				
	$kondisi = array("","","","Bersih","Kotor");
	
	$result = $kondisi[$kondisi_id];
	
	return($result);
}

function fungsi_item($fungsi_id) {
				
	$fungsi = array("Baik","Rusak");
	
	$result = $fungsi[$fungsi_id];
	
	return($result);
}

function isLoginSessionExpired() {
	$login_session_duration = 1; 
	$current_time = time(); 
	if(isset($_SESSION['loggedin_time']) and isset($_SESSION["id"])){  
		if(((time() - $_SESSION['loggedin_time']) > $login_session_duration)){ 
			return true; 
		} 
	}
	return false;
}
/*
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
*/

function anti_injection($data){
  $filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  return $filter;
}

function tgl_indo($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = getBulan(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;		 
}

function getBulan($bln){
	switch ($bln){
		case 1: 
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
} 

function tgl_indo2($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = getBulan2(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;		 
}

function jam_indo($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = getBulan2(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;		 
}

function getHour($hour){
	$jam = substr($hour,10,6);
	return $jam;	
}

function getBulan2($bln){
	switch ($bln){
		case 1: 
			return "Jan";
			break;
		case 2:
			return "Feb";
			break;
		case 3:
			return "Mar";
			break;
		case 4:
			return "Apr";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Jun";
			break;
		case 7:
			return "Jul";
			break;
		case 8:
			return "Agus";
			break;
		case 9:
			return "Sep";
			break;
		case 10:
			return "Okt";
			break;
		case 11:
			return "Nov";
			break;
		case 12:
			return "Des";
			break;
	}
} 

function status_request($status){
	switch ($status){
		case "Done":
			return "label-success";
			break;
		case "On Process":
			return "label-warning";
			break;
		case "Cancel":
			return "label-danger";
			break;
		case 'Assigned':
			return 'label-primary';
			break;
	}
}

function tgl_indo_short($tgl){
	$hour = substr($tgl,10,3);
	$minute = substr($tgl,14,2);
	return $hour.':'.$minute;	
}

function tgl_short($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = substr($tgl,5,2);
	$tahun = substr($tgl,0,4);
	return $tanggal .''. $bulan . '' . $tahun;	
}
function tgl_short_slash($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = substr($tgl,5,2);
	$tahun = substr($tgl,0,4);
	return $bulan .'/'. $tanggal . '/' . $tahun;	
}
function create_path_bulan($path){
	if(!is_dir($path)){
		
		mkdir($path, 0755);
	}
	
	return $path;
}
function create_path_year($path){
	if(!is_dir($path)){
		
		mkdir($path, 0755);
	}
	
	return $path;
}

function status_confirm($status){
	switch ($status){
		case "0": 
			return "label-danger";
			break;
		case "1":
			return "label-warning";
			break;
	}
}

function noreq(){
	
	include '/../connect/database.php';
	
	$datanoreq = $db->request()
					->select("SUBSTR(MAX(noreq),-5) as noreq")
					->fetch();
	
	// bila data kosong
	if($datanoreq['noreq']==''){ 
		$reqid = "0001";
	}else {
		$noreqid = $datanoreq['noreq'];
		$noreqid++;
		if($noreqid < 10) $reqid = "0000".$noreqid; // nilai kurang dari 10
		elseif($noreqid < 100) $reqid = "000".$noreqid; // nilai kurang dari 100													
		elseif($noreqid < 1000) $reqid = "00".$noreqid; // nilai kurang dari 1000
		elseif($noreqid < 10000) $reqid = "0".$noreqid; // nilai kurang dari 10000
		else $reqid = $noreqid; // lebih dari 100000
	}
	
	return $reqid;
}

function nobtb(){
	
	include '/../connect/database.php';
	
	$datanobtb = $db->request_received()
					->select("SUBSTR(MAX(btb_number),-5) as btb_number")
					->fetch();
	
	// bila data kosong
	if($datanobtb['btb_number']==''){ 
		$btbid = "0001";
	}else {
		$nobtbid = $datanobtb['btb_number'];
		$nobtbid++;
		if($nobtbid < 10) $btbid = "0000".$nobtbid; // nilai kurang dari 10
		elseif($nobtbid < 100) $btbid = "000".$nobtbid; // nilai kurang dari 100													
		elseif($nobtbid < 1000) $btbid = "00".$nobtbid; // nilai kurang dari 1000
		elseif($nobtbid < 10000) $btbid = "0".$nobtbid; // nilai kurang dari 10000
		else $btbid = $nobtbid; // lebih dari 100000
	}
	
	return $btbid;
}

/*Generate Image Voucher */

function generateVoucher($barcode) {
    
    generateBarcode($barcode);
    $v_barcode = str_replace(' ', '', $barcode);
    
    $gambar = @imagecreatefromjpeg('assets/img/blanko_evoucher.jpg');

    // Mengalokasikan warna untuk teks, masukkan nilai RGB
    $warna_putih = imagecolorallocate($gambar, 255, 255, 255);

    // Menetapkan file path font
    $font_path = 'dist/fonts/StagSans-Book.ttf';

    // Mendapatkan isi teks dari input form untuk dicetak ke gambar
    $isiteks = 'No : ' . substr($barcode, -5);

    $ukuran=28;
    $angle=0;
    $kiri=40;
    $atas=65;
    
    //$canvas = imagecreatetruecolor(304, 179);
    
    // Cetak teks ke gambar
    imagettftext($gambar, $ukuran,$angle,$kiri,$atas, $warna_putih, $font_path, $isiteks);
    //imagejpeg($gambar, 'assets/generate_voucher/' . $v_barcode . '.jpg');

    //Kirim Gambar ke Browser
    //imagejpeg($gambar);
   
    // ganti baris kode diatas dengan dibawah ini jika kmau ingin menyimpan hasilnya
    imagejpeg($gambar, 'assets/generate_voucher/' . $v_barcode . '.jpg');
    
    $img_voucher = @imagecreatefrompng('assets/generate_voucher/' . $v_barcode . '.jpg');
    
    $img_barcode = @imagecreatefrompng('assets/generate_barcode/barcode_' . $v_barcode . '.png');
    
    $ukuran2=22;
    $angle2=0;
    $kiri2=895;
    $atas2=50;
 
    $img_barcode_width = imagesx($img_barcode);  
    $img_barcode_height = imagesy($img_barcode);  
    $image_barcode = imagecreatetruecolor($img_barcode_width, $img_barcode_height); 
    
    imagecopymerge($gambar, $img_barcode, $kiri2, $atas2, 0, 0, $img_barcode_width, $img_barcode_height, 100);
    imagejpeg($gambar, 'assets/generate_voucher/' . $v_barcode . '.jpg');
    //imagejpeg($image_barcode);  
    
    // Membersihkan Memory
    imagedestroy($gambar);
    imagedestroy($img_barcode);
}

function getVoucherJpg($barcode){
    $text_barcode = str_replace(' ', '', $barcode);
    $imagejpeg = 'assets/generate_voucher/' . $text_barcode . '.jpg';
    return $imagejpeg;
}
function generateBarcode($barcode){
    // Including all required classes
    require_once('assets/barcode/class/BCGFontFile.php');
    require_once('assets/barcode/class/BCGColor.php');
    require_once('assets/barcode/class/BCGDrawing.php');

    // Including the barcode technology
    require_once('assets/barcode/class/BCGcode39.barcode.php');

    // Loading Font
    $font = new BCGFontFile('dist/fonts/StagSans-Book.ttf', 14);

    // Don't forget to sanitize user inputs
    $text = $barcode;

    // The arguments are R, G, B for color.
    $color_black = new BCGColor(0, 0, 0);
    $color_white = new BCGColor(255, 255, 255);

    $drawException = null;
    try {
        $code = new BCGcode39();
        $code->setScale(1); // Resolution
        $code->setThickness(60); // Thickness
        $code->setForegroundColor($color_black); // Color of bars
        $code->setBackgroundColor($color_white); // Color of spaces
        $code->setFont($font); // Font (or 0)
        $code->parse($text); // Text
    } catch(Exception $exception) {
        $drawException = $exception;
    }

    /* Here is the list of the arguments
    1 - Filename (empty : display on screen)
    2 - Background color */
    $drawing = new BCGDrawing('', $color_white);
    if($drawException) {
        $drawing->drawException($drawException);
    } else {
        $drawing->setBarcode($code);
        $drawing->draw();
    }

    // Header that says it is an image (remove it if you save the barcode to a file)
    //header('Content-Type: image/png');
    //header('Content-Disposition: inline; filename="barcode.png"');
    
    $v_barcode = str_replace(' ', '', $barcode);
    // Draw (or save) the image into PNG format.
    $drawing->setFilename('assets/generate_barcode/'. 'barcode_' . $v_barcode . '.png');
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
}

function sendMail($customer_name, $customer_email, $barcode){
    
    require '../assets/PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'deryrosandy@gmail.com';
    $mail->Password = 'budakwarkir123';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    
    $mail->setFrom('deryrosandy@gmail.com', 'Delta Spa');
    //$mail->addReplyTo('deryrosandy@gmail.com', 'Delta Spa');
    // Menambahkan penerima
    $mail->addAddress($customer_email);
    // Menambahkan cc atau bcc 
    //$mail->addCC('cc@contoh.com');
    //$mail->addBCC('bcc@contoh.com');
    // Subjek email
    $mail->Subject = 'eVoucher Delta Spa';
    // Mengatur format email ke HTML
    $mail->isHTML(true);
    // Konten/isi email
    $mailContent = '<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Simple Transactional Email</title>
    <style>
    /* -------------------------------------
        INLINED WITH htmlemail.io/inline
    ------------------------------------- */
    /* -------------------------------------
        RESPONSIVE AND MOBILE FRIENDLY STYLES
    ------------------------------------- */
    @media only screen and (max-width: 620px) {
      table[class=body] h1 {
        font-size: 28px !important;
        margin-bottom: 10px !important;
      }
      table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
        font-size: 16px !important;
      }
      table[class=body] .wrapper,
            table[class=body] .article {
        padding: 10px !important;
      }
      table[class=body] .content {
        padding: 0 !important;
      }
      table[class=body] .container {
        padding: 0 !important;
        width: 100% !important;
      }
      table[class=body] .main {
        border-left-width: 0 !important;
        border-radius: 0 !important;
        border-right-width: 0 !important;
      }
      table[class=body] .btn table {
        width: 100% !important;
      }
      table[class=body] .btn a {
        width: 100% !important;
      }
      table[class=body] .img-responsive {
        height: auto !important;
        max-width: 100% !important;
        width: auto !important;
      }
    }

    /* -------------------------------------
        PRESERVE THESE STYLES IN THE HEAD
    ------------------------------------- */
    @media all {
      .ExternalClass {
        width: 100%;
      }
      .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
        line-height: 100%;
      }
      .apple-link a {
        color: inherit !important;
        font-family: inherit !important;
        font-size: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
        text-decoration: none !important;
      }
      .btn-primary table td:hover {
        background-color: #34495e !important;
      }
      .btn-primary a:hover {
        background-color: #34495e !important;
        border-color: #34495e !important;
      }
    }
    </style>
  </head>
  <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
    <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
      <tr>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
          <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

            <!-- START CENTERED WHITE CONTAINER -->
            <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">This is preheader text. Some clients will show this text as a preview.</span>
            <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                    <tr>
                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Hi ' . $customer_name . '</p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Silahkan klik tombol di bawah, untuk download eVcouher Delta Spa Anda!</p>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                          <tbody>
                            <tr>
                              <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                                  <tbody>
                                    <tr>
                                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;"> <a href="//110.50.85.26:82/checklist/assets/generate_voucher/' . $barcode . '.jpg" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;" download>Download EVOUCHER</a> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Best Regards</p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Thanks You.</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>

            <!-- START FOOTER -->
            <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                <tr>
                  <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                    <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">www.deltaspa.net</span>
                  </td>
                </tr>
              </table>
            </div>
            <!-- END FOOTER -->

          <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
      </tr>
    </table>
  </body>
</html>';
    // Menambahakn lampiran
    //$mail->addAttachment('lmp/file1.pdf');
    //$mail->addAttachment('lmp/file2.png', 'nama-baru-file2.png');
    
    $mail->Body = $mailContent;
    // Kirim email
    if(!$mail->send()){
        echo 'Pesan tidak dapat dikirim.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        return false;
        
    }else{
        return true;
    }
    
   
}

$body = '';
$active = '';

?>