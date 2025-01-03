<?php

function dd($var)
{
    die(var_dump($var));
}

function render($pageContent, $parent_active, $active, $data)
{
    $CI = &get_instance();
    $data['page_content'] = $pageContent;
    $data['parent_active'] = $parent_active;
    $data['active'] = $active;
    $CI->load->view('adminkit/base/V_BaseLayout', $data);
}

function validateKey($arr_needed, $arr_request){
    foreach($arr_request as $ar){
        if(!array_key_exists($ar, $arr_needed)){
            return ['code' => 1, 'message' => "Unknown Key '".$ar."'"];
        }
    }
    return ['code' => 0, 'message' => ''];
}

function fileToBase64($filename){
    if(file_exists($filename)){
        $type = pathinfo($filename, PATHINFO_EXTENSION);
        $data = file_get_contents($filename);
        $base64 = 'data:application/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    } 
    return null;
}

function fileToBytes($file){
    $fh = fopen($file, 'rb');
    $fbytes = fread($fh, filesize($file));
    return array(base64_encode($fbytes));
}

function base64ToFile($base64_string, $output_file) {
    $ifp = fopen( $output_file, 'wb' ); 
    $data = explode(',', $base64_string );
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );
    fclose( $ifp );

    return $output_file; 
}

function checkIfValidDate($bulan, $tahun){
    $result = true;
    $thisMonth = date('m');
    $thisYear = date('Y');
    if($tahun <= $thisYear && strlen($tahun) == 4){
        if($bulan <= $thisMonth){
            $result = true;
        } else {
            $result = false;
        }
    } else {
        $result = false;
    }

    return $result;
}

function getFileTypeBu($string){
    $filedata = base64_decode($string);
    $f = finfo_open();
    return finfo_buffer($f, $filedata, FILEINFO_MIME_TYPE);
}

function getBase64FileType($string){
    $ex1 = explode("/", $string);
    if(isset($ex1[1])){
        $ex2 = explode(";", $ex1[1]);
        if(isset($ex2[0])){
            return $ex2[0];
        }
    }

    return null;
}

function getFileTypeFromWaBot($string){
    $ex = explode("/", $string);
    if(isset($ex[1])){
        return $ex[1];
    }
    return null;
}

function countHariKerjaDateToDate($tanggal_awal, $tanggal_akhir){
    $helper = &get_instance();
    $helper->load->model('user/M_User', 'm_user');

    $list_hari_libur = $helper->m_user->getListHariLibur($tanggal_awal, $tanggal_akhir);
    $hari_libur = null;
    if($list_hari_libur){
        foreach($list_hari_libur as $lhl){
            $hari_libur[$lhl['tanggal']] = $lhl;
        }
    }

    $list_hari = getDateBetweenDates($tanggal_awal, $tanggal_akhir);
    $list_hari_kerja = null;

    $jhk = 0;
    $hk = 0;
    foreach($list_hari as $lh){
        if(!isset($hari_libur[$lh]) && getNamaHari($lh) != 'Sabtu' && getNamaHari($lh) != 'Minggu'){
            $list_hari_kerja[$lh] = $lh;
            $jhk++;
            if($lh <= date('Y-m-d')){
                $hk++;
            }
        }
    }
    return [$jhk, $hari_libur, $list_hari, $list_hari_kerja, $hk];
}

function formatNip($nip)
{
    $str = strlen($nip);
    $formatted_nip = '';
    $nip_split = str_split($nip);
    for ($i = 0; $i < $str; $i++) {
        $formatted_nip .= $nip_split[$i];
        if ($i == 7 || $i == 13 || $i == 14) {
            $formatted_nip .= " ";
        }
    }
    return $formatted_nip;
}

function generateNorm($last_norm)
{
    if ($last_norm) {
        $cur_count_norm = ltrim($last_norm, '0');
        $cur_count_norm = floatval($cur_count_norm) + 1;
    } else {
        $cur_count_norm = 1;
    }
    return str_pad($cur_count_norm, 7, '0', STR_PAD_LEFT);
}

function countNilaiKomponen($data)
{
    $capaian = floatval($data['berorientasi_pelayanan']) +
        floatval($data['akuntabel']) +
        floatval($data['kompeten']) +
        floatval($data['harmonis']) +
        floatval($data['loyal']) +
        floatval($data['adaptif']) +
        floatval($data['kolaboratif']);
    // $capaian = floatval($data['perilaku_1']) +
    // floatval($data['perilaku_2']) +
    // floatval($data['perilaku_3']) +
    // floatval($data['perilaku_4']) +
    // floatval($data['perilaku_5']) +
    // floatval($data['perilaku_6']) +
    // floatval($data['perilaku_7']);
    $bobot = 30;
    if ($capaian < 350) {
        $bobot = 0;
    } else if ($capaian > 350 && $capaian < 679) {
        $bobot = ($capaian / 700) * floatval(BOBOT_NILAI_KOMPONEN_KINERJA);
        $bobot = $bobot * 100;
    }

    return [$capaian, $bobot];
}

function countNilaiSkp($data)
{
    $result['capaian'] = 0;
    $result['bobot'] = 0;
    if ($data) {
        $akumulasi_nilai_capaian = 0;
        foreach ($data as $d) {
            $nilai_capaian = 0;
            if (floatval($d['realisasi']) > 0) {
                if(floatval($d['target_kuantitas']) == 0){
                    $nilai_capaian = 0;
                } else {
                    $nilai_capaian = (floatval($d['realisasi']) / floatval($d['target_kuantitas'])) * 100;
                }
            }
            $akumulasi_nilai_capaian += $nilai_capaian;
        }

        if (count($data) != 0) {
            $result['capaian'] = floatval($akumulasi_nilai_capaian) / count($data);
        }
        $result['bobot'] = $result['capaian'] * floatval(BOBOT_NILAI_SKBP);
        if ($result['bobot'] > 30) {
            $result['bobot'] = 30;
        }
        if ($result['capaian'] > 100) {
            $result['capaian'] = 100;
        }
    }
    return $result;
}

function stringStartWith($string, $string_check){
    return substr($string_check, 0, strlen($string)) == $string;
}

function getListDateByMonth($month, $year){
    $list=array();
    for($d=1; $d<=31; $d++)
    {
        $time=mktime(12, 0, 0, $month, $d, $year);          
        if (date('m', $time)==$month)       
            $list[]=date('Y-m-d', $time);
    }
    return $list;
}

function getDateBetweenDates($startDate, $endDate)
{
    $rangArray = [];

    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    for (
        $currentDate = $startDate;
        $currentDate <= $endDate;
        $currentDate += (86400)
    ) {

        $date = date('Y-m-d', $currentDate);
        $rangArray[] = $date;
    }

    return $rangArray;
}

function explodeRangeDate($date)
{
    $tanggal = explode("-", $date);
    $awal = explode("/", $tanggal[0]);
    $akhir = explode("/", $tanggal[1]);

    $start_date = trim($awal[2]) . '-' . trim($awal[1]) . '-' . trim($awal[0]);
    $end_date = trim($akhir[2]) . '-' . trim($akhir[1]) . '-' . trim($akhir[0]);
    return [$start_date, $end_date];
}

function explodeRangeDateNew($date)
{
    $tanggal = explode("-", $date);
    $awal = explode("/", $tanggal[0]);
    $akhir = explode("/", $tanggal[1]);

    $start_date = trim($awal[2]) . '-' . trim($awal[0]) . '-' . trim($awal[1]);
    $end_date = trim($akhir[2]) . '-' . trim($akhir[0]) . '-' . trim($akhir[1]);

    return [$start_date, $end_date];
}

function getStatusTransaksi($status)
{
    switch ($status) {
        case 1:
            return 'Aktif';
            break;
        case 2:
            return 'Lunas';
            break;
        case 3:
            return 'Belum Lunas';
            break;
        default:
            return '';
    }
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateRandomNumber($length = 10)
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getPphByIdPangkat($id_pangkat)
{
    if (in_array($id_pangkat, [31, 32, 33, 34])) {
        return 5;
    } else if (in_array($id_pangkat, [41, 42, 43, 44, 45])) {
        return 15;
    }
    return 0;
}

function greeting(){
    date_default_timezone_set("Asia/Singapore");

    $time = date('H');
    $greeting = "Pagi";
    if(intval($time) >= 11 && intval($time) < 15){
        $greeting = "Siang";
    } else if(intval($time) >= 15 && intval($time) < 18){
        $greeting = "Siang";
    } else if(intval($time) >= 18 && intval($time) < 24 && intval($time) >= 0 && intval($time) < 2){
        $greeting = "Malam";
    }

    return $greeting;
}

function clearString($str)
{
    return str_replace('.', '', preg_replace('/[^0-9.\.]+/', '', (trim($str))));
}

function formatCurrency($data)
{
    return "Rp " . number_format($data, 2, ",", ".");
}

function formatCurrencyWithoutRp($data, $decimal = 2)
{
    return number_format($data, $decimal, ",", ".");
}

function formatDateOnly($data)
{
    $date1 = strtr($data, '/', '-');
    return date("d/m/Y", strtotime($date1));
}

function formatDateOnlyForEdit2($data)
{
    $date1 = strtr($data, '/', '-');
    return date("d-m-Y", strtotime($date1));
}

function formatDate($data)
{
    $date1 = strtr($data, '/', '-');
    return date("d/m/Y H:i:s", strtotime($date1));
}

function formatDateOnlyForEdit($data)
{
    return date("Y-m-d", strtotime($data));
}

function formatDateForEdit($data)
{
    return date("Y-m-d H:i:s", strtotime($data));
}

function array_flatten($array)
{
    if (!is_array($array)) {
        return false;
    }
    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, array_flatten($value));
        } else {
            $result = array_merge($result, array($key => $value));
        }
    }
    return $result;
}

function getProgressBarColor($progress, $use_important = true)
{
    $bgcolor = '#ff0000 !important';
    if ($progress > 25 && $progress <= 50) {
        $bgcolor = '#ff7100 !important';
    } else if ($progress > 50 && $progress <= 65) {
        $bgcolor = '#ffcf00 !important';
    } else if ($progress > 65 && $progress <= 85) {
        $bgcolor = '#5bff00 !important';
    } else if ($progress > 85 && $progress < 100) {
        $bgcolor = '#41b302 !important';
    } else if ($progress >= 100) {
        $bgcolor = '#006600 !important';
    }
    if (!$use_important) {
        $arr = explode(" ", $bgcolor);
        $bgcolor = $arr[0];
    }
    return $bgcolor;
}

function formatTwoMaxDecimal($data)
{
    $dt = explode(".", $data);
    $rs = $dt[0];
    if (isset($dt[1])) {
        $rs .= ".";
        $dtsplit = str_split($dt[1]);
        $rs = $rs . $dtsplit[0];
        if (isset($dtsplit[1])) {
            $rs = $rs . $dtsplit[1];
        } else {
            $rs = $rs . '0';
        }
    } else {
        $rs .= ".00";
    }
    // if($rs > 100){
    //     $rs = 100;
    // }
    return $rs;
}

function formatDateNamaBulan($data)
{
    $date_only = formatDateOnly($data);
    $explode = explode('/', $date_only);
    return $explode[0] . ' ' . getNamaBulan($explode[1]) . ' ' . $explode[2];
}

function formatDateNamaBulanWT($data)
{
    $date_only = formatDate($data);
    $explode = explode('/', $date_only);
    return $explode[0] . ' ' . getNamaBulan($explode[1]) . ' ' . $explode[2];
}

function formatDateNamaBulanWithTime($data)
{
    $date_only = formatDate($data);
    $explode = explode('/', $date_only);
    $explode_time = explode(' ', $date_only);
    return $explode[0] . ' ' . getNamaBulan($explode[1]) . ' ' . $explode[2];
}

function getNamaPegawaiFull($pegawai)
{
    return trim(trim($pegawai['gelar1']).' '.trim($pegawai['nama']).' '.trim($pegawai['gelar2']));
}

function sortArrayObjectValue($object1, $object2, $value)
{
    return $object1->$value > $object2->$value;
}

function getNamaBulan($bulan)
{
    $bulan = floatval($bulan);
    switch ($bulan) {
        case 1:
            return 'Januari';
            break;
        case 2:
            return 'Februari';
            break;
        case 3:
            return 'Maret';
            break;
        case 4:
            return 'April';
            break;
        case 5:
            return 'Mei';
            break;
        case 6:
            return 'Juni';
            break;
        case 7:
            return 'Juli';
            break;
        case 8:
            return 'Agustus';
            break;
        case 9:
            return 'September';
            break;
        case 10:
            return 'Oktober';
            break;
        case 11:
            return 'November';
            break;
        case 12:
            return 'Desember';
            break;
        default:
            return '';
    }
}

function roundDown($number, $length){
    $explode = explode(".", $number);
    $comma = 0;
    if(isset($explode[1])){
        $comma = $explode[1];
    }
    $digits = substr($explode[0], -3);
    return floatval($number) - floatval($digits.'.'.$comma);
}

function getJumlahHariDalamBulan($m, $y)
{
    $kalendar = CAL_GREGORIAN;
    return cal_days_in_month($kalendar, $m, $y);
}

function getNamaHariFromNumber($hari)
{
    switch ($hari) {
        case 0:
            return 'Minggu';
            break;
        case 1:
            return 'Senin';
            break;
        case 2:
            return 'Selasa';
            break;
        case 3:
            return 'Rabu';
            break;
        case 4:
            return 'Kamis';
            break;
        case 5:
            return 'Jumat';
            break;
        case 6:
            return 'Sabtu';
            break;
        default:
            return 'invalid';
    }
}

function getNamaHari($date)
{
    $dayofweek = date('w', strtotime($date));
    return getNamaHariFromNumber($dayofweek);
}

function formatTimeAbsen($value){
    $expl = explode(":", $value);
    if(count($expl) > 1){
        return $expl[0].':'.$expl[1];
    } else {
        return $value;  
    }
}

function countDiffDateLengkap($date1, $date2, $params = '')
{
    $total_waktu = "";
    $tahun = 0;
    $bulan = 0;
    $hari = 0;
    $jam = 0;
    $menit = 0;
    $detik = 0;

    $date1 = strtotime($date1);
    $date2 = strtotime($date2);
    $diff = abs($date2 - $date1);

    $tahun = floor($diff / (365 * 60 * 60 * 24));
    $bulan = floor(($diff - $tahun * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $hari = floor(($diff - $tahun * 365 * 60 * 60 * 24 -  $bulan * 30 * 60 * 60 * 24) / (60 * 60 * 24));
    $jam = $hours = floor(($diff - $tahun * 365 * 60 * 60 * 24 - $bulan * 30 * 60 * 60 * 24 - $hari * 60 * 60 * 24) / (60 * 60));
    $menit = floor(($diff - $tahun * 365 * 60 * 60 * 24 - $bulan * 30 * 60 * 60 * 24 - $hari * 60 * 60 * 24 - $jam * 60 * 60) / 60);
    $detik = floor(($diff - $tahun * 365 * 60 * 60 * 24 - $bulan * 30 * 60 * 60 * 24 - $hari * 60 * 60 * 24 - $jam * 60 * 60 - $menit * 60));

    if ($tahun != '0' && in_array('tahun', $params)) {
        $total_waktu = $total_waktu . ' ' . $tahun . ' tahun';
    }
    if ($bulan != '0' && in_array('bulan', $params)) {
        $total_waktu = $total_waktu . ' ' . $bulan . ' bulan';
    }
    if ($hari != '0' && in_array('hari', $params)) {
        $total_waktu = $total_waktu . ' ' . $hari . ' hari';
    }
    if ($jam != '0' && in_array('jam', $params)) {
        $total_waktu = $total_waktu . ' ' . $jam . ' jam';
    }
    if ($menit != '0' && in_array('menit', $params)) {
        $total_waktu = $total_waktu . ' ' . $menit . ' menit';
    }
    if ($detik != '0' && in_array('detik', $params)) {
        $total_waktu = $total_waktu . ' ' . $detik . ' detik';
    }
    if (strlen($total_waktu) == 0) {
        $total_waktu = 'Hari Ini';
    }
    return $total_waktu;
}

function terbilang($x)
{
    $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");

    if ($x < 12)
        return " " . $abil[$x];

    elseif ($x < 20)
        return terbilang($x - 10) . " Belas";
    elseif ($x < 100)
        return terbilang($x / 10) . " Puluh" . terbilang($x % 10);
    elseif ($x < 200)
        return " Seratus" . terbilang($x - 100);
    elseif ($x < 1000)
        return terbilang($x / 100) . " Ratus" . terbilang($x % 100);
    elseif ($x < 2000)
        return " Seribu" . terbilang($x - 1000);
    elseif ($x < 1000000)
        return terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
    elseif ($x < 1000000000)
        return terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
    else
        return terbilang($x / 1000000000) . " Miliar " . terbilang($x % 1000000000);
}

function isValidTokenHeader($token, $kode_merchant)
{
    return $token == encrypt('nikita', $kode_merchant);
}

function logErrorTelegram($data)
{
    $this->general_library->logErrorTelegram($data);
}

function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function encrypt($string1, $string2)
{
    $key = 'nikitalab' . DEVELOPER;
    $userKey = substr($string1, -3);
    $passKey = substr($string2, -3);
    $generatedForHash = strtoupper($userKey) . $string1 . $key . strtoupper($passKey) . $string2;
    return md5($generatedForHash);
    // return $this->general_library->encrypt($string1, $string2);
}

function encrypt_custom($pure_string)
{
    $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

    $key_size =  strlen($key);

    $plaintext = $pure_string;

    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

    $ciphertext = mcrypt_encrypt(
        MCRYPT_RIJNDAEL_128,
        $key,
        $plaintext,
        MCRYPT_MODE_CBC,
        $iv
    );

    $ciphertext = $iv . $ciphertext;

    $ciphertext_base64 = base64_encode($ciphertext);

    return $ciphertext_base64;
}

function decrypt_custom($encrypted_string)
{
    $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

    $ciphertext_dec = base64_decode($encrypted_string);

    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

    # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
    $iv_dec = substr($ciphertext_dec, 0, $iv_size);

    # retrieves the cipher text (everything except the $iv_size in the front)
    $ciphertext_dec = substr($ciphertext_dec, $iv_size);

    # may remove 00h valued characters from end of plain text
    $plaintext_dec = mcrypt_decrypt(
        MCRYPT_RIJNDAEL_128,
        $key,
        $ciphertext_dec,
        MCRYPT_MODE_CBC,
        $iv_dec
    );

    return $plaintext_dec;
}


// /Fungsi Konversi nilai angka menjadi nilai huruf
 function penyebut($nilai) {
  $nilai = abs($nilai);
  $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
  $temp = "";
  if ($nilai < 12) {
   $temp = " ". $huruf[$nilai];
  } else if ($nilai <20) {
   $temp = penyebut($nilai - 10). " belas";
  } else if ($nilai < 100) {
   $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
  } else if ($nilai < 200) {
   $temp = " seratus" . penyebut($nilai - 100);
  } else if ($nilai < 1000) {
   $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
  } else if ($nilai < 2000) {
   $temp = " seribu" . penyebut($nilai - 1000);
  } else if ($nilai < 1000000) {
   $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
  } else if ($nilai < 1000000000) {
   $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
  } else if ($nilai < 1000000000000) {
   $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
  } else if ($nilai < 1000000000000000) {
   $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
  }   
  return $temp;
 }

//  function terbilang($nilai) {
//   if($nilai<0) {
//    $hasil = "minus ". trim(penyebut($nilai));
//   } else {
//    $hasil = trim(penyebut($nilai));
//   }       
//   return $hasil;
//  }

function pemeringkatanKriteriaKinerja($nilai){
    $helper = &get_instance();
    $helper->load->model('simata/M_Simata', 'simata');
    $list_interval = $helper->simata->getListIntervalKinerja();

    $pemeringkatan = null;
    $badge = null;
    foreach ($list_interval as $li) {
        if($nilai == 0) {
            $badge = "primary";
            $pemeringkatan = "-";
        } else {
            if($nilai >= $li['dari'] AND $nilai <= $li['sampai']){
                if($li['id'] == 1) {
                $badge = "success";
                } else if($li['id'] == 3) {
                $badge = "secondary";
                } else if($li['id'] == 4) {
                $badge = "danger";
                }
                $pemeringkatan = "<span class='badge bg-".$badge."'>".$li['kriteria']."</span>";
            }   
        }
       
       
    }

    return $pemeringkatan;
}