<?php

/**
 *	Copyright (C)			: Doktersiaga
 *	Developer				: Fatah Iskandar Akbar
 *	Email					: fatah@doktersiaga.com
 *	Date					: Mei 2019
 *	Nama Aplikasi			: Dialogflow Webhook for Whatsapp
 *	Dialogflow API version	: 2.0
 *	Version					: 2.1 (Non OOP)
**/

date_default_timezone_set("Asia/Jakarta");

$dbhost = 'ls-94ee73dc203afa75d99e36d8d0edc786afe1a222.ctuhohy0axyn.ap-southeast-1.rds.amazonaws.com';
$dbuser = 'botrsi';
$dbpass = 'startuppedia66';
	
$method = $_SERVER['REQUEST_METHOD'];
$now 	= date('Y-m-d H:i:s');
$hari_daftar_bpjs = -1;
$jam_buka_daftar_bpjs = "07:00";
$jam_tutup_daftar_bpjs = "23:30";

if($method == 'POST'){
	
	$requestBody 	= file_get_contents('php://input');
	$json			= json_decode($requestBody);
	
	/** init param **/
	$responseId			= $json->responseId;
	$sessionId			= $json->session;
	$intentName			= $json->queryResult->intent->displayName;
	$queryText			= $json->queryResult->queryText;
	$senderId			= "";
	$platform			= "";
	$tipeFaskes			= "";	
	$namaFaskes			= "RSI";
	$faskesServices		= "";
	$gelar				= "";	
	$spesialisDokter	= "";
	$namaDokter			= "";
	$gelarSpesialis		= "";
	$hari				= "";
	$jam				= "";
	$jenisPasien		= "";
	$namaPasien			= "";
	$namaPendaftar		= "";
	$gender				= "";
	$ttl				= "";
	$phoneNumber		= "";
	$jadwalID			= "";
	$penjamin			= "";
	$rencanaBerobat		= "";
	$medrec				= "";
	$poliKlinik			= "";
	$pageId 			= ""; 
	$faskesServices 	= ""; 
	$namaAsuransi 		= ""; 
	$jamPendaftaran 	= ""; 
	$jadwalID			= "";
	$tglBerobat			= "";
	$kodeBoking			= "";
	$phone				= ""; // nmr wa pendaftar
	
	$online				= true;
	
	if(isset($json->queryResult->outputContexts)){
		for($i=0; $i < count($json->queryResult->outputContexts); $i++){
			
			if(isset($json->queryResult->outputContexts[$i]->parameters->twilio_sender_id)){
				$senderId			= str_replace('whatsapp:','',$json->queryResult->outputContexts[$i]->parameters->twilio_sender_id);
				$platform			= 'whatsapp';
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->facebook_sender_id)){
				$senderId			= str_replace('facebook:','',$json->queryResult->outputContexts[$i]->parameters->facebook_sender_id);
				$platform			= 'facebook';
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->tipeFaskes)){
				$tipeFaskes			= $json->queryResult->outputContexts[$i]->parameters->tipeFaskes;
			} 
			if(isset($json->queryResult->outputContexts[$i]->parameters->faskesServices)){
				$faskesServices		= $json->queryResult->outputContexts[$i]->parameters->faskesServices;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->gelar)){
				$gelar	= $json->queryResult->outputContexts[$i]->parameters->gelar;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->spesialisDokter)){
				$spesialisDokter	= $json->queryResult->outputContexts[$i]->parameters->spesialisDokter;
			}		
			if(isset($json->queryResult->outputContexts[$i]->parameters->namaDokter)){
				$namaDokter			= $json->queryResult->outputContexts[$i]->parameters->namaDokter;
			}		
			if(isset($json->queryResult->outputContexts[$i]->parameters->gelarSpesialis)){
				$gelarSpesialis		= $json->queryResult->outputContexts[$i]->parameters->gelarSpesialis;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->hari)){
				$hari			= $json->queryResult->outputContexts[$i]->parameters->hari;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->jam)){
				$jam			= $json->queryResult->outputContexts[$i]->parameters->jam;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->jenisPasien)){
				$jenisPasien	= $json->queryResult->outputContexts[$i]->parameters->jenisPasien;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->namaPasien)){
				$namaPasien		= $json->queryResult->outputContexts[$i]->parameters->namaPasien->name;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->namaPendaftar)){
				$namaPendaftar		= $json->queryResult->outputContexts[$i]->parameters->namaPendaftar->name;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->gender)){
				$gender			= $json->queryResult->outputContexts[$i]->parameters->gender;
			}	
			if(isset($json->queryResult->outputContexts[$i]->parameters->ttl)){
				$ttl			= $json->queryResult->outputContexts[$i]->parameters->ttl;
			}	
			if(isset($json->queryResult->outputContexts[$i]->parameters->phoneNumber)){
				$phoneNumber	= $json->queryResult->outputContexts[$i]->parameters->phoneNumber;
			}			
			if(isset($json->queryResult->outputContexts[$i]->parameters->jadwalID)){
				$jadwalID		= $json->queryResult->outputContexts[$i]->parameters->jadwalID;
			}		
			if(isset($json->queryResult->outputContexts[$i]->parameters->penjamin)){
				$penjamin		= $json->queryResult->outputContexts[$i]->parameters->penjamin;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->rencanaBerobat)){
				$rencanaBerobat		= $json->queryResult->outputContexts[$i]->parameters->rencanaBerobat;
			}	
			if(isset($json->queryResult->outputContexts[$i]->parameters->medrec)){
				$medrec		= $json->queryResult->outputContexts[$i]->parameters->medrec;
			}			
			if(isset($json->queryResult->outputContexts[$i]->parameters->poliKlinik)){
				$poliKlinik		= $json->queryResult->outputContexts[$i]->parameters->poliKlinik;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->faskesService)){
				$faskesService	= $json->queryResult->outputContexts[$i]->parameters->faskesService;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->namaAsuransi)){
				$namaAsuransi	= $json->queryResult->outputContexts[$i]->parameters->namaAsuransi;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->jamPendaftaran)){
				$jamPendaftaran	= $json->queryResult->outputContexts[$i]->parameters->jamPendaftaran;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->tglBerobat)){
				$tglBerobat	= $json->queryResult->outputContexts[$i]->parameters->tglBerobat;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->kodeBoking)){
				$kodeBoking	= $json->queryResult->outputContexts[$i]->parameters->kodeBoking;
			}
			if(isset($json->queryResult->outputContexts[$i]->parameters->phone)){
				$phone	= $json->queryResult->outputContexts[$i]->parameters->phone;
			}
		}	
	} else {
		if(isset($json->queryResult->parameters->tipeFaskes)){
			$tipeFaskes				= $json->queryResult->parameters->tipeFaskes;
		}				
		if(isset($json->queryResult->parameters->faskesServices)){
			$faskesServices		= $json->queryResult->parameters->faskesServices;
		}
		if(isset($json->queryResult->parameters->gelar)){
			$gelar	= $json->queryResult->parameters->gelar;
		}
		if(isset($json->queryResult->parameters->spesialisDokter)){
			$spesialisDokter	= $json->queryResult->parameters->spesialisDokter;
		}		
		if(isset($json->queryResult->parameters->namaDokter)){
			$namaDokter			= $json->queryResult->parameters->namaDokter;
		}		
		if(isset($json->queryResult->parameters->gelarSpesialis)){
			$gelarSpesialis		= $json->queryResult->parameters->gelarSpesialis;
		}
		if(isset($json->queryResult->parameters->hari)){
			$hari			= $json->queryResult->parameters->hari;
		}
		if(isset($json->queryResult->parameters->jam)){
			$jam			= $json->queryResult->parameters->jam;
		}
		if(isset($json->queryResult->parameters->jenisPasien)){
			$jenisPasien	= $json->queryResult->parameters->jenisPasien;
		}
		if(isset($json->queryResult->parameters->namaPasien)){
			$namaPasien		= $json->queryResult->parameters->namaPasien->name;
		}
		if(isset($json->queryResult->parameters->namaPendaftar)){
			$namaPendaftar		= $json->queryResult->parameters->namaPendaftar->name;
		}
		if(isset($json->queryResult->parameters->gender)){
			$gender			= $json->queryResult->parameters->gender;
		}	
		if(isset($json->queryResult->parameters->ttl)){
			$ttl			= $json->queryResult->parameters->ttl;
		}	
		if(isset($json->queryResult->parameters->phoneNumber)){
			$phoneNumber	= $json->queryResult->parameters->phoneNumber;
		}			
		if(isset($json->queryResult->parameters->jadwalID)){
			$jadwalID		= $json->queryResult->parameters->jadwalID;
		}		
		if(isset($json->queryResult->parameters->penjamin)){
			$penjamin		= $json->queryResult->parameters->penjamin;
		}
		if(isset($json->queryResult->parameters->rencanaBerobat)){
			$rencanaBerobat		= $json->queryResult->parameters->rencanaBerobat;
		}	
		if(isset($json->queryResult->parameters->medrec)){
			$medrec		= $json->queryResult->parameters->medrec;
		}			
		if(isset($json->queryResult->parameters->poliKlinik)){
			$poliKlinik		= $json->queryResult->parameters->poliKlinik;
		}	
		if(isset($json->queryResult->parameters->faskesService)){
			$faskesService		= $json->queryResult->parameters->faskesService;
		}		
		if(isset($json->queryResult->parameters->namaAsuransi)){
			$namaAsuransi		= $json->queryResult->parameters->namaAsuransi;
		}
		if(isset($json->queryResult->parameters->jamPendaftaran)){
			$jamPendaftaran		= $json->queryResult->parameters->jamPendaftaran;
		}	
		if(isset($json->queryResult->parameters->tglBerobat)){
			$tglBerobat		= $json->queryResult->parameters->tglBerobat;
		}		
		if(isset($json->queryResult->parameters->kodeBoking)){
			$kodeBoking		= $json->queryResult->parameters->kodeBoking;
		}	
		if(isset($json->queryResult->parameters->phone)){
			$phone		= $json->queryResult->parameters->phone;
		}
	}
	
	if(empty($senderId)){
		$senderId			= "";
	} 	
	
	if($platform == 'facebook'){
		$pageId = ""; // fb page 
	} 
	
	$jenis_message	= 'IN';
	$tipe_message	= 'text';
	$tgl	 		= date('Y-m-d H:i:s', strtotime('+7 hour', strtotime(date("Y-m-d H:i:s"))));
	$tag			= strtolower($namaFaskes);
	$tag		   .= ",".strtolower(str_replace(" ", ",", $queryText));
	
	// Create connection to db
	$conndb = mysqli_connect($dbhost, $dbuser, $dbpass, 'chatbotrsi');
	
	// Check connection
	if (!$conndb) {
		  die("Connection dbmaster failed: " . mysqli_connect_error());
	}
	
	// save pesan masuk
	$sql = "INSERT INTO `kaio_bot_messages` (`messages_id`,`page_id`, `sender_id`,`conversation_id`,`tgl`,`message`,`tipe_message`,`tag`,`jenis_message`,`platform`, `source`) VALUES('','$pageId','$senderId','$responseId','$tgl','$queryText','$tipe_message','$tag','$jenis_message','$platform','')";
	
	mysqli_query($conndb, $sql) or die(mysqli_error($conndb));
		
	
	$speech = "";
	
	if($online OR is_admin($senderId)){
		
		switch($intentName){
								
			/*** PENDAFTARAN RAJAL PASIEN PRIBADI ***/
			
			case "daftar-rajal":
				$speech = "Mau berobat ke dr spesialis apa?";
			break;
			
			case "daftar-rajal-fallback":
				$speech = "Silahkan pilih dokter spesialis yang ingin kamu tuju seperti di bawah ini :\n\n";
				
				// get data poli 
				$sql = "SELECT * FROM kaio_poli ORDER BY nama_poli ASC";
												
				$res 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
				
				while ($row = mysqli_fetch_assoc($res)) {
					$rest[] = $row;
				}
				
				if(count($rest) > 0){	
					for($i=0; $i < count($rest); $i++){
						$speech .= "dr ".$rest[$i]['nama_poli']."\n";
					}
				} else {
					$speech = "Mohon maaf kami belum menginput data poli";
				}
				
			break;
			
			case 'poliklinik':
			
				// get data poli 
				$sql = "SELECT * FROM kaio_poli ";
				$sql .= "WHERE  nama_poli='".$spesialisDokter."' ";
				
				/*if(!is_null($spesialisDokter)){
					$sql .= "AND (d.nama_poli LIKE '%$spesialisDokter%') ";
				}*/
								
				$res 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
				
				while ($row = mysqli_fetch_assoc($res)) {
					$rest[] = $row;
				}
				
				if(count($rest) > 0){	
					$speech = "Untuk jadwal hari apa?";
				} else {
					$speech = "Mohon maaf, kami tidak ada poli $spesialisDokter";
				}
			
			break;
			
			case 'poliklinik-fallback':
				$speech = "Silahkan pilih hari, contoh : senin, selasa, rabu, kamis, jumat, sabtu, minggu";
			break;
					
			case "hari-berobat":
							
				$daftar_hari = array(
					'Sunday' => 'Minggu',
					 'Monday' => 'Senin',
					 'Tuesday' => 'Selasa',
					 'Wednesday' => 'Rabu',
					 'Thursday' => 'Kamis',
					 'Friday' => 'Jumat',
					 'Saturday' => 'Sabtu'
				);
				
				// konversi ke nama hari 
				if( ($hari=='hari ini') OR ($hari=='nanti sore ') OR ($hari=='nanti malam') OR ($hari=='sekarang')){
					$date		= date('Y-m-d');
					$namahari 	= date('l', strtotime($date));
				
					$hari 		= strtolower($daftar_hari[$namahari]);
				} else if($hari=='besok'){
					$date		=  mktime(0, 0, 0, date("m"),date("d")+1,date("Y"));
					$namahari 	= date('l',$date);
				
					$hari = strtolower($daftar_hari[$namahari]);					
					
				}
				
				$speech = "Jadwal dokter $spesialisDokter di RS Islam Jakarta pada hari ".$hari." :\n\n";
			
				$hariInteger = hari_to_integer($hari);
				
				// get jadwal dokter 
				$sql = "SELECT a.*,b.gelar,b.gelar_depan,b.nama_dokter,b.gelar_belakang,c.title,c.alias,d.nama_poli ";
				$sql .= "FROM kaio_jadwal_dokter AS a ";
				$sql .= "LEFT JOIN kaio_dokter AS b ON b.id=a.dokter_id ";
				$sql .= "LEFT JOIN kaio_spesialis AS c ON c.id=b.spesialis_id ";
				$sql .= "LEFT JOIN kaio_poli AS d ON d.poli_id=a.poli_id ";
				
				if($hari == 'semua hari'){
					
				} else {
					$sql .= "WHERE  a.hari=$hariInteger AND (d.nama_poli LIKE '%$spesialisDokter%') ";
				}
												
				$sql .= "ORDER BY b.nama_dokter,a.hari ASC ";
				
				$resdb 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
				
				while ($row = mysqli_fetch_assoc($resdb)) {
					$res[] = $row;
				}
				
				if(count($res) > 0){
					for($i=0; $i < count($res); $i++){
						
						if($res[$i]['hari']=='1'){
							$res[$i]['hari'] = 'Senen';
						} else if($res[$i]['hari']=='2'){
							$res[$i]['hari'] = 'Selasa';
						} else if($res[$i]['hari']=='3'){
							$res[$i]['hari'] = 'Rabu';
						} else if($res[$i]['hari']=='4'){
						$res[$i]['hari'] = 'Kamis';
						} else if($res[$i]['hari']=='5'){
							$res[$i]['hari'] = 'Jumat';
						} else if($res[$i]['hari']=='6'){
							$res[$i]['hari'] = 'Sabtu';
						} else if($res[$i]['hari']=='7'){
							$res[$i]['hari'] = 'Minggu';
						}
						
						if($res[$i]['bpjs']=='N'){
							$bpjs = "Tidak";
						} else if($res[$i]['bpjs']=='Y'){
							$bpjs = "Ya";
						}
						
						$speech	.= "Jadwal ID : *".$res[$i]['jadwal_id']."* \n";
						$speech	.= $res[$i]['gelar']." ".$res[$i]['nama_dokter']." ".$res[$i]['gelar_belakang']." ".$res[$i]['title']."\n";
						$speech	.= ucwords(strtolower($res[$i]['alias']))."\n";
						$speech	.= "Hari : ".$res[$i]['hari']."\n";
						$speech .= "Jam Praktek : ".$res[$i]['jam_mulai']." - ".$res[$i]['jam_selesai']."\n";
						$speech	.= "BPJS : ".$bpjs;
						$speech .= "\n\n";	
					}
					
				} else {
						$speech	.= "Mohon maaf, *tidak ada* dokter $spesialisDokter pada hari $hari" ;
						$speech .= "\n\n";					
				}
								
				$speech .= "Untuk mencari jadwal dokter lainya silahkan ketikan nama hari. Contoh : Minggu. \n\n";
				$speech .= "Untuk mendaftar silahkan ketikan Nomor *JADWAL ID*. Contoh : 5  \n\n";
				$speech .= "*PENDAFTARAN BPJS HANYA BISA H-1 PADA JAM PELAYANAN*";
				
			break;
			
			case 'hari-berobat-fallback':
				$speech = "Silahkan pilih jadwal ID di atas";
			break;
			
			case 'jadwal-id-lainya':
			case 'jadwal-id':
			
				$sql = "SELECT * FROM kaio_jadwal_dokter WHERE jadwal_id='".$jadwalID."'";
				
				$resdb 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
				
				while ($row = mysqli_fetch_assoc($resdb)) {
					$res[] = $row;
				}
				
				if(count($res) > 0){
					$speech = "Rencana pembayaran akan menggunakan apa? Pilih salah satu : Pribadi, Asuransi atau BPJS ?";					
				} else {
					$speech = "Jadwal ID *$jadwalID tidak ada* di dalam data kami. Silahkan pilih jadwal ID lainya";	
				}
				

			break;
			
			/*** Pasien Baru Penjamin Pribadi ***/
			case 'pribadi':
			
				if($penjamin=='asuransi' or $penjamin=='pribadi'){
					$speech = "Mau berobat di tanggal berapa? Format tanggal tgl bln thn, Contoh : 02 02 2021";
				} else {
					$speech = "Penjamin tidak di kenal, *ILLEGAL OPERATION*";
				}
				
			break;
			
			case 'tgl-berobat':
				$speech = "Pasien baru atau lama ka?";
			break;			
			
			case 'jenis-pasien':
				// pendaftaran pasien bpjs H-1
				
				if($jenisPasien=='pasien baru'){
					$speech = "Nama lengkap pasien (sesuai KTP)? ";
				} else {
					$speech = "Sebutkan nomor rekam medis kamu. Contoh *08-99-79-21* ";
				}
				
			break;

			case 'pasien-baru-pribadi':
				$speech = "Nomor Handphone pasien yang dapat dihubungi?";
			break;

			//case 'hp-pasien-baru-bpjs':
			case 'tgl-lahir':
				$speech = "Tanggal Lahir Pasien ? Format tanggal tgl bln thn, Contoh 03 04 1980";
			break;			
			
			case 'jenis-kelamin':
				$speech = "Jenis Kelamin Pasien?";
			break;

			case 'upload-ktp':			
				$speech = "upload-ktp&".$jadwalID;
			break;		

			/**** End Of Pasien Baru Penjamin Pribadi ***/
			
			/*** Pasien Lama Penjamin Pribadi ***/
			
			case "pasien-lama-pribadi":
				$kode_booking 	= date('yd-His');
				$tgl_daftar		= date('Y-m-d h:i:s');
				
				switch(strtolower($penjamin)){
					case 'asuransi':
						$penjamin = 'AS';
						$status = 'TK';
					break;
					
					case 'pribadi':
						$penjamin = 'P';
						$status = 'TK';
					break;
					
					case 'bpjs':
						$penjamin = 'BPJS';
						$status = 'MV';
					break;
				}
				
				// get jadwal 
				$sql = "SELECT * FROM kaio_jadwal_dokter AS a ";
				$sql .= "LEFT JOIN kaio_dokter AS b ON b.id=a.dokter_id ";
				$sql .= "LEFT JOIN kaio_spesialis AS c ON c.id=b.spesialis_id ";
				$sql .= "LEFT JOIN kaio_poli AS d ON d.poli_id=a.poli_id ";
				$sql .= "WHERE a.jadwal_id=$jadwalID";

				$resdb 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
				
				while ($row = mysqli_fetch_assoc($resdb)) {
					$res[] = $row;
				}	
				
				// get data pasien 
				$q = "SELECT * FROM kaio_pasien WHERE nmr_medrec='".$medrec."'";	

				$respasien 	= mysqli_query($conndb, $q) or die(mysqli_error($conndb));	
				
				while ($rowpasien = mysqli_fetch_assoc($respasien)) {
					$pasien[] = $rowpasien;
				}				
				
				if(count($pasien) > 0){
					$jadwal 	 	= pilihJadwalBerobat(integer_to_hari($res[0]['hari']));
					$tgl_berobat 	= date('Y-m-d', strtotime($jadwal['minggu1']));
					$jam			= $res[0]['jam_mulai'];
					
					// jika sdh terdaftar tdk dpt daftar ulang 
					
					// save data booking
					$sql = "INSERT INTO `kaio_pasien_booking_rajal` (`booking_id`,`jadwal_id`, `dokter_id`,`spesialis_id`,`poli_id`,`kode_booking`, `tgl_daftar`, `nama_pendaftar`, `nama_pasien`, `penjamin`,`nmr_medrec`,`tgl_berobat`, `jam_berobat`, `nama_dokter`,`nama_spesialis`,`nama_poli`,`nama_faskes`,`keluhan`,`status`) VALUES('','$jadwalID','".$res[0]['dokter_id']."','".$res[0]['spesialis_id']."','".$res[0]['poli_id']."','".$kode_booking."','".$tgl_daftar."','".$namaPendaftar."','".$pasien[0]['nama_pasien']."','".$penjamin."','".$medrec."','".$tgl_berobat."','".$jam."','".$res[0]['nama_dokter']."','".$res[0]['description']."','".$res[0]['nama_poli']."','".$res[0]['nama_faskes']."','','".$status."')";
					
					mysqli_query($conndb, $sql) or die(mysqli_error($conndb));		

					if($penjamin == 'P'){
						$penjamin = "Pribadi";
					} else if($penjamin == 'AS'){
						$penjamin = "Asuransi";
					} else if($penjamin == 'BPJS'){
						$penjamin = "BPJS";
					}				
								
					$speech  = "*PENDAFTARAN PASIEN RAWAT JALAN* \n\n";
					$speech .= "Terima kasih telah mendaftar di *RS Islam Cempaka Putih*. Berikut data anda \n\n";
					$speech .= "Kode Booking : $kode_booking\n";
					$speech .= "Nomor Urut : Per kedatangan\n";
					$speech .= "Jenis Pasien : ".ucwords($jenisPasien)."\n";
					$speech .= "Nama Pasien : ".ucwords($pasien[0]['nama_pasien'])."\n";			
					$speech .= "Nomor HP : ".$pasien[0]['nmr_hp']."\n";				
					$speech .= "Poliklinik : ".ucwords($spesialisDokter)."\n";	
					$speech .= "Dokter : ".$res[0]['nama_dokter']." ".$res[0]['title']."\n";	
					$speech .= "Hari / Tgl : ".integer_to_hari($res[0]['hari'])." / ".$jadwal['minggu1']."  \n";			
					$speech .= "Jam : ".$res[0]['jam_mulai']." - ".$res[0]['jam_selesai']."\n";
					$speech .= "Penjamin : ".$penjamin."\n";
					$speech .= "Status : *SUKSES TERDAFTAR* \n\n ";
					$speech .= "Harap datang 30 menit sebelum jam praktek dibuka & tunjukan pesan ini kepada petugas kami saat datang berobat";	
					
				} else {
					$speech  = "Mohon maaf nomor medical record *$medrec* tidak ada ";
				}
				
			break;			
			
			/**** End Of Pasien Lama Penjamin Pribadi ***/
			
			case "daftar-pasien-baru-pribadi":
			
				// get kode booking 
				$q = "SELECT * FROM kaio_files WHERE nmr_wa_pendaftar='".$phone."' AND tgl='".date('Y-m-d')."' AND jadwal_id='".$jadwalID."' ORDER BY ID DESC LIMIT 0,1";
				$resx 	= mysqli_query($conndb, $q) or die(mysqli_error($conndb));	
				
				while ($rows = mysqli_fetch_assoc($resx)) {
					$rt[] = $rows;
				}				
				
				$kode_booking = $rt[0]['kode_booking'];
				
				switch(strtolower($gender)){
					case 'ce':
					case 'wanita':
					case 'cewe':
					case 'cewek':
					case 'perempuan':
						$sex = 'F';
					break;
					
					case 'co':
					case 'cowo':
					case 'cowok':
					case 'pria':
						$sex = 'M';
					break;
				}
				
				if($jenisPasien == 'pasien baru'){
									
					// save data pasien baru 
					$sql = "INSERT INTO `kaio_pasien` (`pasien_id`,`nama_pasien`, `ttl`,`gender`,`nmr_hp`,`email`,`nmr_bpjs`,`nmr_medrec`) VALUES('','$namaPasien','$ttl','$sex','$phoneNumber','','','$medrec')";
									
					mysqli_query($conndb, $sql) or die(mysqli_error($conndb));		
					
					// get last id 
					$sql = "SELECT LAST_INSERT_ID() AS pasien_id";
					$resdb 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
					
					while ($row = mysqli_fetch_assoc($resdb)) {
						$rest[] = $row;
					}

					$pasienID = $rest[0]['pasien_id'];
				}

				$tgl_daftar		= date('Y-m-d h:i:s');
				$nmr_medrec 	= null;
				
				switch(strtolower($penjamin)){
					case 'asuransi':
						$penjamin = 'AS';
						$status = 'TK';
					break;
					
					case 'pribadi':
						$penjamin = 'P';
						$status = 'TK';
					break;
					
					case 'bpjs':
						$penjamin = 'BPJS';
						$status = 'MV';
					break;

				}
				
				// get jadwal 
				$sql = "SELECT * FROM kaio_jadwal_dokter AS a ";
				$sql .= "LEFT JOIN kaio_dokter AS b ON b.id=a.dokter_id ";
				$sql .= "LEFT JOIN kaio_spesialis AS c ON c.id=b.spesialis_id ";
				$sql .= "LEFT JOIN kaio_poli AS d ON d.poli_id=a.poli_id ";
				$sql .= "WHERE a.jadwal_id=$jadwalID";

				$resdb 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
				
				while ($row = mysqli_fetch_assoc($resdb)) {
					$res[] = $row;
				}	
				
				$jadwal 	 	= pilihJadwalBerobat(integer_to_hari($res[0]['hari']));
				$tgl_berobat 	= date('Y-m-d', strtotime($jadwal['minggu1']));
				$jam			= $res[0]['jam_mulai'];
				
				// save data booking
				$sql = "INSERT INTO `kaio_pasien_booking_rajal` (`booking_id`,`jadwal_id`,`pasien_id`,`dokter_id`,`spesialis_id`,`poli_id`,`kode_booking`, `tgl_daftar`, `nama_pendaftar`, `nmr_wa_pendaftar`, `nama_pasien`, `penjamin`,`nmr_medrec`,`tgl_berobat`, `jam_berobat`, `nama_dokter`,`nama_spesialis`,`nama_poli`,`nama_faskes`,`keluhan`,`status`) VALUES('','$jadwalID','".$pasienID."','".$res[0]['dokter_id']."','".$res[0]['spesialis_id']."','".$res[0]['poli_id']."','".$kode_booking."','".$tgl_daftar."','".$namaPendaftar."','".$phone."','".$namaPasien."','".$penjamin."','".$nmr_medrec."','".$tgl_berobat."','".$jam."','".$res[0]['nama_dokter']."','".$res[0]['description']."','".$res[0]['nama_poli']."','".$res[0]['nama_faskes']."','','".$status."')";
									
				mysqli_query($conndb, $sql) or die(mysqli_error($conndb));		

				if($penjamin == 'P'){
					$penjamin = "Pribadi";
				} else if($penjamin == 'AS'){
					$penjamin = "Asuransi";
				} else if($penjamin == 'BPJS'){
					$penjamin = "BPJS";
				}				
							
				$speech  = "*PENDAFTARAN PASIEN RAWAT JALAN* \n\n";
				$speech .= "Terima kasih telah mendaftar di *RS Islam Cempaka Putih*. Berikut data anda \n\n";
				$speech .= "Kode Booking : $kode_booking\n";
				$speech .= "Nomor Urut : Per kedatangan\n";
				$speech .= "Jenis Pasien : ".ucwords($jenisPasien)."\n";
				$speech .= "Nama Pasien : ".ucwords($namaPasien)."\n";			
				$speech .= "Nomor HP : $phoneNumber\n";				
				$speech .= "Poliklinik : ".ucwords($spesialisDokter)."\n";	
				$speech .= "Dokter : ".$res[0]['nama_dokter']." ".$res[0]['title']."\n";	
				$speech .= "Hari / Tgl : ".integer_to_hari($res[0]['hari'])." / ".$jadwal['minggu1']."  \n";			
				$speech .= "Jam : ".$res[0]['jam_mulai']." - ".$res[0]['jam_selesai']."\n";
				$speech .= "Penjamin : ".$penjamin."\n\n";
				
				if($penjamin == 'BPJS'){
					$speech .= "Status : *MENUNGGU KONFIRMASI* \n\n";
				} else {
					$speech .= "Status : *SUKSES TERDAFTAR* \n\n ";
					$speech .= "Harap datang 30 menit sebelum jam praktek dibuka & tunjukan pesan ini kepada petugas kami saat datang berobat";
				}
				
			break;
			
			/*** END OF PENDAFTARAN RAJAL PASIEN PRIBADI ***/
			
			
			
			/*** PENDAFTARAN RAJAL PASIEN BPJS ***/			
			
			case 'bpjs':
			
				// get jadwal 
				$sql = "SELECT * FROM kaio_jadwal_dokter AS a ";
				$sql .= "LEFT JOIN kaio_dokter AS b ON b.id=a.dokter_id ";
				$sql .= "LEFT JOIN kaio_spesialis AS c ON c.id=b.spesialis_id ";
				$sql .= "LEFT JOIN kaio_poli AS d ON d.poli_id=a.poli_id ";
				$sql .= "WHERE a.jadwal_id=$jadwalID ";

				$resdb 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
				
				while ($row = mysqli_fetch_assoc($resdb)) {
					$jadwal[] = $row;
				}	
				
				if($jadwal[0]['bpjs']=='N'){
					// jika dr tdk menerima bpjs 
					$speech = "Mohom maaf ".$jadwal[0]['gelar']." ".$jadwal[0]['nama_dokter']." ".$jadwal[0]['title']." tidak menerima BPJS. Silahkan pilih jadwal ID lainya.";
				} else {
					
					$daftar_hari = array(
						'Sunday' => 'Minggu',
						 'Monday' => 'Senin',
						 'Tuesday' => 'Selasa',
						 'Wednesday' => 'Rabu',
						 'Thursday' => 'Kamis',
						 'Friday' => 'Jumat',
						 'Saturday' => 'Sabtu'
					);
					
					// konversi ke nama hari 
					if( ($hari=='hari ini') OR ($hari=='nanti sore ') OR ($hari=='nanti malam') OR ($hari=='sekarang')){
						$date		= date('Y-m-d');
						$namahari 	= date('l', strtotime($date));
					
						$hari 		= strtolower($daftar_hari[$namahari]);
					} else if($hari=='besok'){
						$date		=  mktime(0, 0, 0, date("m"),date("d")+1,date("Y"));
						$namahari 	= date('l',$date);
					
						$hari = strtolower($daftar_hari[$namahari]);					
						
					}
										
					$pilih_tgl = pilihJadwalBerobat($hari);
					
					$speech = "Untuk hari $hari tanggal berapa? Silahkan pilih salah satu tanggal di bawah ini : \n";
					$speech .= ucwords($hari).", ".$pilih_tgl['minggu1']."\n";
					$speech .= ucwords($hari).", ".$pilih_tgl['minggu2']."\n";
					$speech .= ucwords($hari).", ".$pilih_tgl['minggu3']."\n";
					$speech .= ucwords($hari).", ".$pilih_tgl['minggu4']."\n";
					$speech .= "Contoh : 24 02 2021\n";
				}
				
			break;
			
			case 'tgl-berobat-bpjs':
				$tgl = substr($tglBerobat,0,10);
				// cek apakah tgl merah
				$sql = "SELECT * FROM kaio_tgl_merah WHERE tgl_merah='".$tgl."'";
				
				$resdb 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
				
				while ($row = mysqli_fetch_assoc($resdb)) {
					$res[] = $row;
				}
				
				if(count($res) > 0){
					$speech = "Mohon maaf tgl *".date('d F Y', strtotime($tglBerobat))."* kami *libur* karena tanggal merah";
				} else {
					// cek apakah dr cuti 
					$sql = "SELECT * FROM kaio_dokter_cuti WHERE tgl_cuti='".$tgl."'";
					
					$resdb 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
					
					while ($row = mysqli_fetch_assoc($resdb)) {
						$res[] = $row;
					}
					
					if(count($res) > 0){
						$speech = "Mohon maaf tgl *".date('d F Y', strtotime($tglBerobat))."* dr sedang *cuti*. Silahkan pilih dokter lainya atau hubungi Customer Service kami di nomor 02142801567 untuk info lebih detail ";
					} else {
						// cek quota 
						// cek jam pendaftaran 
						// hari buka pendaftaran pasien bpjs 						
						if(date('d')==substr($tglBerobat,8,2)){
							// same day
							$daftar_hari = array(
								'Sunday' => 'Minggu',
								 'Monday' => 'Senin',
								 'Tuesday' => 'Selasa',
								 'Wednesday' => 'Rabu',
								 'Thursday' => 'Kamis',
								 'Friday' => 'Jumat',
								 'Saturday' => 'Sabtu'
							);
				
							// konversi ke nama hari 
							if( ($hari=='hari ini') OR ($hari=='nanti sore ') OR ($hari=='nanti malam') OR ($hari=='sekarang')){
								$date		= date('Y-m-d');
								$namahari 	= date('l', strtotime($date));
							
								$hari 		= strtolower($daftar_hari[$namahari]);
							} else if($hari=='besok'){
								$date		=  mktime(0, 0, 0, date("m"),date("d")+1,date("Y"));
								$namahari 	= date('l',$date);
							
								$hari = strtolower($daftar_hari[$namahari]);					
								
							}
							
							$speech = "Pendaftaran pasien BPJS untuk *H-1*, jika Gawat Darurat bisa datang langsung ke IGD atau ke loket 3 (khusus BPJS). Silahkan pilih tanggal lainya atau untuk melihat jadwal lainya silahkan ketik : *jadwal*";
						} else {
							// cek apakah user mendaftar di jam pelayanan?
							if(date('Y-m-d H:i', strtotime('+7')) > date('Y-m-d')." ".$jam_tutup_daftar_bpjs){
								$speech = "Mohon maaf saat ini untuk pendaftaran pasien BPJS sudah tutup.\n";
								$speech .= "Jam Tutup pendaftaran BPJS : ".$jam_tutup_daftar_bpjs."\n";
								$speech .= "Jam Buka pendaftaran BPJS : ".$jam_buka_daftar_bpjs."\n";
							} else {
								// jam pendaftaran masih buka 
								$speech = "Pasien baru atau pasien lama?";
							}
							//$speech = "Now : ".date('Y-m-d H:i', strtotime('+7'));
							//$speech .= "Jam tutup : ".date('Y-m-d')." ".$jam_tutup_daftar_bpjs;

						}
						
					}	
				}
				
			break;
			
			case 'hari-lainya':
				$daftar_hari = array(
					'Sunday' => 'Minggu',
					 'Monday' => 'Senin',
					 'Tuesday' => 'Selasa',
					 'Wednesday' => 'Rabu',
					 'Thursday' => 'Kamis',
					 'Friday' => 'Jumat',
					 'Saturday' => 'Sabtu'
				);
				
				// konversi ke nama hari 
				if( ($hari=='hari ini') OR ($hari=='nanti sore ') OR ($hari=='nanti malam') OR ($hari=='sekarang')){
					$date		= date('Y-m-d');
					$namahari 	= date('l', strtotime($date));
				
					$hari 		= strtolower($daftar_hari[$namahari]);
				} else if($hari=='besok'){
					$date		=  mktime(0, 0, 0, date("m"),date("d")+1,date("Y"));
					$namahari 	= date('l',$date);
				
					$hari = strtolower($daftar_hari[$namahari]);					
					
				}
				
				$speech = "Jadwal dokter $spesialisDokter di RS Islam Jakarta pada hari ".$hari." :\n\n";
			
				$hariInteger = hari_to_integer($hari);
				
				// get jadwal dokter 
				$sql = "SELECT a.*,b.gelar,b.gelar_depan,b.nama_dokter,b.gelar_belakang,c.title,c.alias,d.nama_poli ";
				$sql .= "FROM kaio_jadwal_dokter AS a ";
				$sql .= "LEFT JOIN kaio_dokter AS b ON b.id=a.dokter_id ";
				$sql .= "LEFT JOIN kaio_spesialis AS c ON c.id=b.spesialis_id ";
				$sql .= "LEFT JOIN kaio_poli AS d ON d.poli_id=a.poli_id ";
				
				if($hari == 'semua hari'){
					
				} else {
					$sql .= "WHERE  a.hari=$hariInteger AND (d.nama_poli LIKE '%$spesialisDokter%') ";
				}
												
				$sql .= "ORDER BY b.nama_dokter,a.hari ASC ";
				
				$resdb 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
				
				while ($row = mysqli_fetch_assoc($resdb)) {
					$res[] = $row;
				}
				
				if(count($res) > 0){
					for($i=0; $i < count($res); $i++){
						
						if($res[$i]['hari']=='1'){
							$res[$i]['hari'] = 'Senen';
						} else if($res[$i]['hari']=='2'){
							$res[$i]['hari'] = 'Selasa';
						} else if($res[$i]['hari']=='3'){
							$res[$i]['hari'] = 'Rabu';
						} else if($res[$i]['hari']=='4'){
						$res[$i]['hari'] = 'Kamis';
						} else if($res[$i]['hari']=='5'){
							$res[$i]['hari'] = 'Jumat';
						} else if($res[$i]['hari']=='6'){
							$res[$i]['hari'] = 'Sabtu';
						} else if($res[$i]['hari']=='7'){
							$res[$i]['hari'] = 'Minggu';
						}
						
						if($res[$i]['bpjs']=='N'){
							$bpjs = "Tidak";
						} else if($res[$i]['bpjs']=='Y'){
							$bpjs = "Ya";
						}
						
						$speech	.= "Jadwal ID : *".$res[$i]['jadwal_id']."* \n";
						$speech	.= $res[$i]['gelar']." ".$res[$i]['nama_dokter']." ".$res[$i]['gelar_belakang']." ".$res[$i]['title']."\n";
						$speech	.= ucwords(strtolower($res[$i]['alias']))."\n";
						$speech	.= "Hari : ".$res[$i]['hari']."\n";
						$speech .= "Jam Praktek : ".$res[$i]['jam_mulai']." - ".$res[$i]['jam_selesai']."\n";
						$speech	.= "BPJS : ".$bpjs;
						$speech .= "\n\n";	
					}
					
				} else {
						$speech	.= "Mohon maaf, *tidak ada* dokter $spesialisDokter pada hari $hari" ;
						$speech .= "\n\n";					
				}
								
				$speech .= "Untuk mencari jadwal dokter lainya silahkan ketikan nama hari. Contoh : Minggu. \n\n";
				$speech .= "Untuk mendaftar silahkan ketikan Nomor *JADWAL ID*. Contoh : 5  \n\n";
				$speech .= "*PENDAFTARAN BPJS HANYA BISA H-1 PADA JAM PELAYANAN*";			
			break;
			
			case'penjamin':
			
				if(strtolower($penjamin)=='bpjs'){
					$speech = "Jaminan BPJS";
				} 
			break;
			
			case 'daftar-pasien-baru-bpjs':
				$speech = "Nama pasien sesuai KTP ?";		
			break;			
			
			case 'nama-pasien-baru-bpjs':
				$speech = "Nomor Handphone *pasien* yang dapat dihubungi? ";
			break;
			
			case 'hp-pasien-baru-bpjs':
				$speech = "Tanggal lahir pasien ? Format tanggal tgl bln thn, Contoh : 07 11 1985";
			break;
			
			case 'ttl-pasien-baru-bpjs':
				$speech = "Jenis kelamin pasien ?";
			break;
			
			case 'upload-ktp-dok-bpjs':
				$speech = "upload-ktp-dok-bpjs&".$jadwalID;			
			break;	

			case "finish-daftar-pasien-baru-bpjs":
				
				// get kode booking 
				$q = "SELECT * FROM kaio_files WHERE nmr_wa_pendaftar='".$phone."' AND tgl='".date('Y-m-d')."' AND jadwal_id='".$jadwalID."' ORDER BY ID DESC LIMIT 0,1";
				$resx 	= mysqli_query($conndb, $q) or die(mysqli_error($conndb));	
				
				while ($rows = mysqli_fetch_assoc($resx)) {
					$rt[] = $rows;
				}				
				
				$kode_booking = $rt[0]['kode_booking'];
				
				switch(strtolower($gender)){
					case 'ce':
					case 'wanita':
					case 'cewe':
					case 'cewek':
					case 'perempuan':
						$sex = 'F';
					break;
					
					case 'co':
					case 'cowo':
					case 'cowok':
					case 'pria':
						$sex = 'M';
					break;
				}
				
				if($jenisPasien == 'pasien baru'){
					$ttl = substr($ttl,0,10);		
					
					// save data pasien baru 
					$sql = "INSERT INTO `kaio_pasien` (`pasien_id`,`nama_pasien`, `ttl`,`gender`,`nmr_hp`,`email`,`nmr_bpjs`,`nmr_medrec`) VALUES('','$namaPasien','$ttl','$sex','$phoneNumber','','','$medrec')";
									
					mysqli_query($conndb, $sql) or die(mysqli_error($conndb));		
					
					// get last id 
					$sql = "SELECT LAST_INSERT_ID() AS pasien_id";
					$resdb 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
					
					while ($row = mysqli_fetch_assoc($resdb)) {
						$rest[] = $row;
					}

					$pasienID = $rest[0]['pasien_id'];
				}
				//$speech = "Pasien id ".$pasienID.", ttl ".$ttl.", jenis pasien ".$jenisPasien;
				

				//$UploadModel->
				
				$tgl_daftar		= date('Y-m-d h:i:s');
				$nmr_medrec 	= null;
				
				switch(strtolower($penjamin)){
					case 'asuransi':
						$penjamin = 'AS';
						$status = 'TK';
					break;
					
					case 'pribadi':
						$penjamin = 'P';
						$status = 'TK';
					break;
					
					case 'bpjs':
						$penjamin = 'BPJS';
						$status = 'MV';
					break;

				}
				
				// get jadwal 
				$sql = "SELECT * FROM kaio_jadwal_dokter AS a ";
				$sql .= "LEFT JOIN kaio_dokter AS b ON b.id=a.dokter_id ";
				$sql .= "LEFT JOIN kaio_spesialis AS c ON c.id=b.spesialis_id ";
				$sql .= "LEFT JOIN kaio_poli AS d ON d.poli_id=a.poli_id ";
				$sql .= "WHERE a.jadwal_id=$jadwalID";

				$resdb 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
				
				while ($row = mysqli_fetch_assoc($resdb)) {
					$res[] = $row;
				}	
				
				$jadwal 	 	= pilihJadwalBerobat(integer_to_hari($res[0]['hari']));
				$tgl_berobat 	= date('Y-m-d', strtotime($jadwal['minggu1']));
				$jam			= $res[0]['jam_mulai'];
				
				// save data booking
				$sql = "INSERT INTO `kaio_pasien_booking_rajal` (`booking_id`,`jadwal_id`, `pasien_id`,`dokter_id`,`spesialis_id`,`poli_id`,`kode_booking`, `tgl_daftar`, `nama_pendaftar`, `nama_pasien`, `penjamin`,`nmr_medrec`,`tgl_berobat`, `jam_berobat`, `nama_dokter`,`nama_spesialis`,`nama_poli`,`nama_faskes`,`keluhan`,`status`) VALUES('','$jadwalID','$pasienID','".$res[0]['dokter_id']."','".$res[0]['spesialis_id']."','".$res[0]['poli_id']."','".$kode_booking."','".$tgl_daftar."','".$namaPendaftar."','".$namaPasien."','".$penjamin."','".$nmr_medrec."','".$tgl_berobat."','".$jam."','".$res[0]['nama_dokter']."','".$res[0]['description']."','".$res[0]['nama_poli']."','".$res[0]['nama_faskes']."','','".$status."')";
									
				mysqli_query($conndb, $sql) or die(mysqli_error($conndb));		
							
				$speech  = "*PENDAFTARAN PASIEN RAWAT JALAN* \n\n";
				$speech .= "Terima kasih telah mendaftar di *RS Islam Cempaka Putih*. Berikut data anda \n\n";
				$speech .= "Kode Booking : $kode_booking\n";
				$speech .= "Nomor Urut : Per kedatangan\n";
				$speech .= "Jenis Pasien : ".ucwords($jenisPasien)."\n";
				$speech .= "Nama Pasien : ".ucwords($namaPasien)."\n";			
				$speech .= "Nomor HP : $phoneNumber\n";				
				$speech .= "Poliklinik : ".ucwords($spesialisDokter)."\n";	
				$speech .= "Dokter : ".ucwords($res[0]['nama_dokter'])." ".$res[0]['title']."\n";	
				$speech .= "Hari / Tgl : ".integer_to_hari($res[0]['hari'])." / ".$jadwal['minggu1']."  \n";			
				$speech .= "Jam : ".$res[0]['jam_mulai']." - ".$res[0]['jam_selesai']."\n";
				$speech .= "Penjamin : BPJS\n\n";
				$speech .= "Status : *MENUNGGU KONFIRMASI* \n\n";
				$speech .= "Untuk peserta BPJS harap membawa : \n";
				$speech .= "- FC KTP 1x beserta aslinya\n";
				$speech .= "- FC Kartu BPJS 1x  beserta aslinya\n";
				$speech .= "- FC Surat rujukan 4x dan aslinya\n";
				$speech .= "- Jika ada surat konsul intern mohon dilampirkan yg ASLI\n";
				$speech .= "- Jika ada kontrol kembali lampirkan surat Rekomendasi DPJP (Dokter Penanggung Jawab Pasien) yang ASLI\n\n";
				$speech .= "*KONFIRMASI AKAN DI INFO KAN PADA JAM PELAYANAN DARI HARI SENIN - JUMAT PADA JAM 8.00 - 19.00 WIB*";
				
			break;
			
			case 'daftar-pasien-lama-bpjs':
				$speech = "Nomor Medical Record kamu ? Contoh nomor medical record *01-02-76-88* atau jika kaka tidak ingat dapat menghubungi customer service kami";
			break;				
			
			case 'medrec-pasien-bpjs':
				// cek medrec pasien 

				$q = "SELECT * FROM kaio_pasien WHERE nmr_medrec='".$medrec."'";	

				$respasien 	= mysqli_query($conndb, $q) or die(mysqli_error($conndb));	
				
				while ($rowpasien = mysqli_fetch_assoc($respasien)) {
					$pasien[] = $rowpasien;
				}				
				
				if(count($pasien) > 0){
					$speech = "upload-dok-bpjs&".$jadwalID;
				} else {
					$speech = "Mohon maaf nomor medical record *$medrec* tidak ada di dalam sistem kami. Silahkan hub Customer Service kami untuk menanyakan Medical Record anda";
				}
				
			break;
			
			case 'lanjut-pasien-bpjs':
			
				// get kode booking 
				$q = "SELECT * FROM kaio_files WHERE nmr_wa_pendaftar='".$phone."' AND tgl='".date('Y-m-d')."' AND jadwal_id='".$jadwalID."' ORDER BY ID DESC LIMIT 0,1";
				$resx 	= mysqli_query($conndb, $q) or die(mysqli_error($conndb));	
				
				while ($rows = mysqli_fetch_assoc($resx)) {
					$rt[] = $rows;
				}				
				
				$kode_booking = $rt[0]['kode_booking'];
				
				$tgl_daftar		= date('Y-m-d h:i:s');
				
				switch(strtolower($penjamin)){
					case 'asuransi':
						$penjamin = 'AS';
						$status = 'TK';
					break;
					
					case 'pribadi':
						$penjamin = 'P';
						$status = 'TK';
					break;
					
					case 'bpjs':
						$penjamin = 'BPJS';
						$status = 'MV';
					break;
				}
				
				// get jadwal 
				$sql = "SELECT * FROM kaio_jadwal_dokter AS a ";
				$sql .= "LEFT JOIN kaio_dokter AS b ON b.id=a.dokter_id ";
				$sql .= "LEFT JOIN kaio_spesialis AS c ON c.id=b.spesialis_id ";
				$sql .= "LEFT JOIN kaio_poli AS d ON d.poli_id=a.poli_id ";
				$sql .= "WHERE a.jadwal_id=$jadwalID";

				$resdb 	= mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
				
				while ($row = mysqli_fetch_assoc($resdb)) {
					$res[] = $row;
				}	
				
				// get data pasien 
				$q = "SELECT * FROM kaio_pasien WHERE nmr_medrec='".$medrec."'";	

				$respasien 	= mysqli_query($conndb, $q) or die(mysqli_error($conndb));	
				
				while ($rowpasien = mysqli_fetch_assoc($respasien)) {
					$pasien[] = $rowpasien;
				}				
				
				if(count($pasien) > 0){
					$jadwal 	 	= pilihJadwalBerobat(integer_to_hari($res[0]['hari']));
					$tgl_berobat 	= date('Y-m-d', strtotime($jadwal['minggu1']));
					$jam			= $res[0]['jam_mulai'];
					
					// jika sdh terdaftar tdk dpt daftar ulang 
					
					// save data booking
					$sql = "INSERT INTO `kaio_pasien_booking_rajal` (`booking_id`,`jadwal_id`, `dokter_id`,`spesialis_id`,`poli_id`,`kode_booking`, `tgl_daftar`, `nama_pendaftar`, `nama_pasien`, `penjamin`,`nmr_medrec`,`tgl_berobat`, `jam_berobat`, `nama_dokter`,`nama_spesialis`,`nama_poli`,`nama_faskes`,`keluhan`,`status`) VALUES('','$jadwalID','".$res[0]['dokter_id']."','".$res[0]['spesialis_id']."','".$res[0]['poli_id']."','".$kode_booking."','".$tgl_daftar."','".$namaPendaftar."','".$pasien[0]['nama_pasien']."','".$penjamin."','".$medrec."','".$tgl_berobat."','".$jam."','".$res[0]['nama_dokter']."','".$res[0]['description']."','".$res[0]['nama_poli']."','".$res[0]['nama_faskes']."','','".$status."')";
					
					mysqli_query($conndb, $sql) or die(mysqli_error($conndb));		
								
					$speech  = "*PENDAFTARAN PASIEN RAWAT JALAN* \n\n";
					$speech .= "Terima kasih telah mendaftar di *RS Islam Cempaka Putih*. Berikut data anda \n\n";
					$speech .= "Kode Booking : $kode_booking\n";
					$speech .= "Nomor Urut : Per kedatangan\n";
					$speech .= "Jenis Pasien : ".ucwords($jenisPasien)."\n";
					$speech .= "Nama Pasien : ".ucwords($pasien[0]['nama_pasien'])."\n";			
					$speech .= "Nomor HP : ".$pasien[0]['nmr_hp']."\n";				
					$speech .= "Poliklinik : ".ucwords($spesialisDokter)."\n";	
					$speech .= "Dokter : ".ucwords($res[0]['nama_dokter'])." ".$res[0]['title']."\n";	
					$speech .= "Hari / Tgl : ".integer_to_hari($res[0]['hari'])." / ".$jadwal['minggu1']."  \n";			
					$speech .= "Jam : ".$res[0]['jam_mulai']." - ".$res[0]['jam_selesai']."\n";
					$speech .= "Penjamin : BPJS \n";
					$speech .= "Status : *MENUNGGU KONFIRMASI* \n\n ";
					$speech .= "Untuk peserta BPJS harap membawa : \n";
					$speech .= "- FC KTP 1x beserta aslinya\n";
					$speech .= "- FC Kartu BPJS 1x  beserta aslinya\n";
					$speech .= "- FC Surat rujukan 4x dan aslinya\n";
					$speech .= "- Jika ada surat konsul intern mohon dilampirkan yg ASLI\n";
					$speech .= "- Jika ada kontrol kembali lampirkan surat Rekomendasi DPJP (Dokter Penanggung Jawab Pasien) yang ASLI\n\n";
					$speech .= "*KONFIRMASI AKAN DI INFO KAN PADA JAM PELAYANAN DARI HARI SENIN - JUMAT PADA JAM 8.00 - 19.00 WIB*";
									
				} else {
					$speech  = "Mohon maaf nomor medical record *$medrec* tidak ada di dalam sistem kami. Silahkan hub Customer Service kami untuk menanyakan Medical Record anda";
				}
				
			break; 
			
			/**************** END OF DAFTAR BEROBAT *************/
					
			case 'cancel':
				$speech = "Untuk membatalkan pendaftaran rawat jalan, sebutkan kode boking anda...";
			break;
			
			case 'kode-boking':
				// save data pasien baru 
				$sql = "UPDATE `kaio_pasien_booking_rajal` SET status='Cancel by Pasien' WHERE kode_booking='".$kodeBoking."'";
								
				mysqli_query($conndb, $sql) or die(mysqli_error($conndb));	
				
				$speech = "Pendaftaran anda dengan kode booking : $kodeBoking telah di batalkan";
			break;
			
			case 'help':
				$speech = "Panduan cara mengggunakan aplikas ini :";
				$speech .= "\n\n";
				$speech .= "Ketik : *daftar* \n";
				$speech .= "Untuk pendaftaran rawat jalan \n\n";
				$speech .= "Ketik : *cancel* \n";
				$speech .= "Untuk membatalkan pendaftaran rawat jalan \n\n";				
			break;

			/**************** DEFAULT *************/
			case 'default-welcome':
				$speech = "Selamat datang di Whatsapp *RS Islam Jakarta Cempaka Putih*.\n\n Nomor ini khusus untuk melayani *pendaftaran* pasien rawat jalan dan dijawab otomatis oleh *Customer Service Virtual RS Islam*. Untuk memulai ketik : *daftar* \n\n";
				$speech .= "Untuk melihat cara pengunaan aplikasi ini ketik *help*. Untuk pertanyaan lainya silahkan hubungi Customer Service kami di 02142801567 "; 
			break;
		}
		
	} else {
		$speech = "Mohon maaf, Jadwal dokter sedang dalam maintenance...Silahkan kembali beberapa saat lagi";
	}
	$jenis_message	= 'OUT';
	$tag			= strtolower($namaFaskes);
	
	// replace /n sebelum di save ke db
	$speech = str_replace('\n','',$speech);	
		
	// save pesan keluar
	//$sql = "INSERT INTO `kaio_bot_messages` (`messages_id`,`page_id`, `sender_id`,`conversation_id`,`tgl`,`message`,`tipe_message`,`tag`,`jenis_message`,`platform`, `source`) VALUES('','$pageId','masmitra','$responseId','$tgl','$speech','$tipe_message','$tag','$jenis_message','$platform','$source')";
	
	//mysqli_query($conndbdsid, $sql) or die(mysqli_error($conndbdsid));

	mysqli_close($conndb);
	
	// replace <br> sebelum di send ke wa
	//$pesan = str_replace('<br>','',$speech);
	
	$response = new \stdClass();
	$response->fulfillmentText = $speech;	
	$response->source = "webhook";	
	
	echo json_encode($response);
	

} else {
	echo "Method not allowed";
}


	/*
	* 	Konversi hari dalam bahasa Indonesia ke integer
	*	example : 	'senen' => 1
	*				'all'	=> 0
	*/
	function hari_to_integer($hari){
		
		switch($hari){
			case 'senen':
			case 'senin':
				$hari = '1';
				break;
				
			case 'selasa':
				$hari = '2';
				break;

			case 'rabu':
				$hari = '3';
				break;

			case 'kamis':
				$hari = '4';
				break;

			case 'jumat':
				$hari = '5';
				break;

			case 'sabtu':
				$hari = '6';
				break;

			case 'minggu':
				$hari = '7';
				break;	
			
			case 'semua hari':
			default:
				$hari = 0;
				break;				
		}		
		
		return $hari;
	}
	
	function integer_to_hari($integer){

		if($integer=='1'){
			$hari = 'Senin';
		} else if($integer=='2'){
			$hari = 'Selasa';
		} else if($integer=='3'){
			$hari = 'Rabu';
		} else if($integer=='4'){
			$hari = 'Kamis';
		} else if($integer=='5'){
			$hari = 'Jumat';
		} else if($integer=='6'){
			$hari = 'Sabtu';
		} else if($integer=='7'){
			$hari = 'Minggu';
		}
		
		return $hari;
	}
	
	function random_str($type = 'alphanum', $length = 8){
		switch($type)
		{
			case 'basic'    : return mt_rand();
				break;
			case 'alpha'    :
			case 'alphanum' :
			case 'num'      :
			case 'nozero'   :
					$seedings             = array();
					$seedings['alpha']    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$seedings['alphanum'] = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$seedings['num']      = '0123456789';
					$seedings['nozero']   = '123456789';
					
					$pool = $seedings[$type];
					
					$str = '';
					for ($i=0; $i < $length; $i++)
					{
						$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
					}
					return $str;
				break;
			case 'unique'   :
			case 'md5'      :
						return md5(uniqid(mt_rand()));
				break;
		}
	}
	
/* return true jika admin */
function is_admin($senderId){
	
	$admin 	= array('1099241550194014','1155542017832393');
	
	if(in_array($senderId, $admin)) {
		return true;
	} else {
		return false;
	}
}
	
function pilihJadwalBerobat($hari){
	$hari = strtolower($hari);
	
	$daftar_hari = array(
		'minggu' => 'sunday',
		'senin' => 'monday',
		'selasa' => 'tuesday',
		'rabu' => 'wednesday',
		'kamis' => 'thursday',
		'jumat' => 'friday',
		'sabtu' => 'saturday'
	);
	
	switch($hari){
		case 'minggu':
			$day = 0;
		break;
		
		case 'senin':
			$day = 1;
		break;

		case 'selasa':
			$day = 2;
		break;

		case 'rabu':
			$day = 3;
		break;

		case 'kamis':
			$day = 4;
		break;

		case 'jumat':
			$day = 5;
		break;		

		case 'sabtu':
			$day = 6;
		break;	
	}
		
	$hari_berobat = $daftar_hari[$hari];
	$date = date('d-m-Y');
	$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday', 'Saturday');

	$w1	= date('d-m-Y', strtotime($days[$day], strtotime($date)));;
	$w2	= date('d-m-Y', strtotime($days[$day], strtotime($date. ' + 7 days')));;
	$w3 = date('d-m-Y', strtotime($days[$day], strtotime($date. ' + 14 days')));;
	$w4 = date('d-m-Y', strtotime($days[$day], strtotime($date. ' + 21 days')));;

	$res = array('minggu1'=>$w1,'minggu2'=>$w2,'minggu3'=>$w3,'minggu4'=>$w4);
	
	return $res;

	//echo date('l', strtotime(' + 1 days'));

}
?>
