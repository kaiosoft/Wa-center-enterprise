<?php

/**
 *	Copyright (C)			: Doktersiaga
 *	Developer			: Fatah Iskandar Akbar
 *	Email				: fatah@doktersiaga.com
 *	Date				: November 2020
 *	Nama Aplikasi			: Webhook Wablass to Dialogflow API
 *	Version				: 2.0
**/

header("Content-Type: text/plain");

date_default_timezone_set("Asia/Jakarta");

$tgl 				= date('Y-m-d H:i:s');
$id		 		= $_POST['id'];
$name 				= $_POST['pushName'];
$phone 				= $_POST['phone'];
$message 			= str_replace("'","",strtolower($_POST['message']));

$dbhost 			= 'ls-94ee73dc203afa75d99e36d8d0edc786afe1a222.ctuhohy0axyn.ap-southeast-1.rds.amazonaws.com';
$dbuser 			= 'botrsi';
$dbpass 			= 'startuppedia66';

$tipe_message		= 'text';
$phone_owner		= '6285888036899'; #change
$customer_id		= '29'; #change
$bot_id			= '9'; #change 
$page_id 		= 'rsi'; #change
$source			= 'rsi';
$tag			= strtolower($page_id); 
$tag		   	.= ",".strtolower(str_replace(" ", ",", $message));
$token 			= 'N1V3cV95d9svKUMyVgXGsuBWwvi8IFQB0U4vBUX5pmMF6R3Do95ohFVYgVMEfZBA';
$length 		= 45;
$conversation_id	= substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
$start_time 		= microtime(true);

$welcome_msg		= "Hi\n\n<br><br>";
$welcome_msg	   	.= "Selamat datang di layanan chatbot Rumah Sakit Islam Cempaka Putih";


if(isset($_POST['message'])) {

	/**
	 *  create connection to dbdsid
	 */
	$conn = new mysqli($dbhost, $dbuser, $dbpass, "chatbotrsi");

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	/* jika pesan dari personal, insert pesan yg masuk */
	// check if conversation_id is available for uniq user 
	$sql = "SELECT sender_id,conversation_id FROM kaio_session WHERE sender_id='$phone' AND (tgl > '".date('Y-m-d')." 00:00:00' AND tgl < '".date('Y-m-d')." 23:59:59') LIMIT 1";
	$result 	= $conn->query($sql);	

	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$conversation_id = $row["conversation_id"];
		}
	} else {
		$sql = "INSERT INTO `kaio_session` (`id`,`sender_id`,`conversation_id`, `tgl`) VALUES ('','$phone','$conversation_id','$tgl')";
		$conn->query($sql);	
		
		// welcome message
		/*$curl 	= curl_init();
		$data 	= [
			'phone' => $phone,
			'message' => $welcome_msg,
		];

		curl_setopt($curl, CURLOPT_HTTPHEADER,
			array(
				"Authorization: $token",
			)
		);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($curl, CURLOPT_URL, "https://kemusu.wablas.com/api/send-message");
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		
		curl_exec($curl);
		curl_close($curl);*/
	}
	
	// save pesan masuk
	$sql = "INSERT INTO kaio_bot_messages (messages_id, page_id, sender_id, sender_name, conversation_id, tgl, message, reply_by, tag, tipe_message, jenis_message, platform, source) VALUES ('', 'doktersiaga', '$phone', '', '$conversation_id', '$tgl', '$message', '', '$tag', '$tipe_message', 'IN', 'whatsapp', '$source')";
	
	$result 	= $conn->query($sql);	

	// bot 
	if ($result) {

		// cek jika user di block 
		$qt 	= "SELECT COUNT(*) AS jmlh FROM kaio_user_block WHERE sender_id='".$phone."' AND  bot_id='".$bot_id."'";	
		
		$results 	= $conn->query($qt);
		$res		= $results->fetch_array(MYSQLI_NUM);
			
		if($res[0] > 0) {
		
			// user di blok
			//echo "block";
			echo null;
		} else {
			if($message == 'lanjut'){
				$message = 'lanjut '.$phone;
			} 
			// detect intent dialogflow
			$dialogflow = shell_exec("php /var/www/html/dsbot.xyz/masmitra/detectIntent.php \"$message\"  \" $conversation_id\" ");
			$kode_booking 	= date('yd-His');
			
			//$answer = $dialogflow;
			if(strpos($dialogflow,"&") > 0){
				$jadwalID = substr($dialogflow,strpos($dialogflow,"&")+1);
				$answer = substr($dialogflow,0,strpos($dialogflow,"&"));
				
				if(trim($answer) == "upload-ktp"){
					$answer = "Harap di foto KTP nya setelah itu silahkan di upload di linik ini http://rsi.doktersiaga.com/rsi.php?phone=$phone&penjamin=pribadi&tipe=baru&book=$kode_booking&jadwalID=$jadwalID \n";
				} else if(trim($answer) == "upload-dok-bpjs"){
					$answer = "Harap di foto *Surat Rujukan dan Surat Kontrol* nya setelah itu silahkan di upload di linik ini http://rsi.doktersiaga.com/rsi.php?phone=$phone&penjamin=bpjs&tipe=lama&book=$kode_booking&jadwalID=$jadwalID \n";
				} else if(trim($answer) == "upload-ktp-dok-bpjs"){
					$answer = "Harap di foto *KTP, Surat Rujukan dan Surat Kontrol* nya setelah itu silahkan di upload di linik ini http://rsi.doktersiaga.com/rsi.php?phone=$phone&penjamin=bpjs&tipe=baru&book=$kode_booking&jadwalID=$jadwalID \n";
				} else {
					$answer = $dialogflow;	
				}
				
			} else {
				$answer = $dialogflow;
			}
			$end_time = microtime(true);
			$execution_time = ($end_time - $start_time);
			
			$answer .= "\n";
			$answer .= "Dijawab oleh *Customer Serive Virtual RS Islam Jakarta* dalam waktu : ".round($execution_time,1)." detik";
				
			echo $answer;			
			
		}
			
		// insert jawaban
		$q = "INSERT INTO kaio_bot_messages (messages_id, page_id, sender_id, sender_name, conversation_id, tgl, message, reply_by, tag, tipe_message, jenis_message, platform, source) VALUES ('', 'doktersiaga', '$phone_owner', 'doktersiaga', '$conversation_id', '$tgl', '$answer', 'bot', '$tag', '$tipe_message', 'OUT', 'whatsapp', '$source')";
		
		$conn->query($q);		
	} 
	
	
	if($conn->close()) {
		echo null;
	}
	
	
	
}


?>
