<?php

use Endroid\QrCode\QrCode;

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

function renderVerifWhatsapp($pageContent, $parent_active, $active, $data)
{
    $CI = &get_instance();
    $data['page_content'] = $pageContent;
    $data['parent_active'] = $parent_active;
    $data['active'] = $active;
    $CI->load->view('adminkit/base/V_BaseLayoutVerifWhatsapp', $data);
}

function validateKey($arr_needed, $arr_request){
    foreach($arr_request as $ar){
        if(!array_key_exists($ar, $arr_needed)){
            return ['code' => 1, 'message' => "Unknown Key '".$ar."'"];
        }
    }
    return ['code' => 0, 'message' => ''];
}

function convertToBase64($path){
    if(file_exists($path)){
        return (base64_encode(file_get_contents($path)));
    }
    return null;
}

function fileToBase64($filename, $raw = 0){
    if(file_exists($filename)){
        $type = pathinfo($filename, PATHINFO_EXTENSION);
        $data = file_get_contents($filename);
        if($raw == 1){
            return base64_encode($data);
        } else {
            $base64 = 'data:application/' . $type . ';base64,' . base64_encode($data);
            return $base64;
        }
    } 
    return null;
}

function fileToBytes($file){
    $fh = fopen($file, 'rb');
    $fbytes = fread($fh, filesize($file));
    return array(base64_encode($fbytes));
}

function base64ToFile($base64_string, $output_file) {
    // $ifp = fopen( $output_file, 'wb' ); 
    // $data = explode(',', $base64_string );
    // fwrite( $ifp, base64_decode( $data[ 1 ] ) );
    // fclose( $ifp );

    $str_file = str_replace(" ", "+", $base64_string);
    $ifp = fopen( $output_file, 'wb' ); 
    $data = explode(',', $str_file );
    fwrite( $ifp, base64_decode( $data[ 0 ] ) );
    fclose( $ifp );

    // $pdf_base64 = $base64_string;
    // //Get File content from txt file
    // $pdf_base64_handler = fopen($pdf_base64,'r');
    // $pdf_content = fread ($pdf_base64_handler,filesize($pdf_base64));
    // fclose ($pdf_base64_handler);
    // //Decode pdf content
    // $pdf_decoded = base64_decode ($pdf_content);
    // //Write data back to pdf file
    // $pdf = fopen ($output_file,'w');
    // fwrite ($pdf,$pdf_decoded);
    // //close output file
    // fclose ($pdf);

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
            if($tahun == ($thisYear - 1)){
                $result = true;
            } else {
                $result = false;
            }
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

function getHariKerjaByBulanTahun($bulan, $tahun){
    $tanggal_awal = date("Y-m-01", strtotime($tahun.'-'.$bulan.'-01'));
    $tanggal_akhir = date("Y-m-t", strtotime($tahun.'-'.$bulan.'-01'));
    return countHariKerjaDateToDate($tanggal_awal, $tanggal_akhir);
}

function countMaxDateUpload($date, $max = 0, $operand = "minus"){
    $res = null;
    $untillDate = null;
    $tempMax = $max + 30;
    if($operand == 'plus'){
        $untillDate = date('Y-m-d', strtotime($date. ' +'.$tempMax.' days'));
        $res = countHariKerjaDateToDate($date, $untillDate);
    } else {
        $untillDate = date('Y-m-d', strtotime($date. ' -'.$tempMax.' days'));
        $res = countHariKerjaDateToDate($untillDate, $date);
    }
    $res['max_date'] = null;

    $lhk = null;
    $i = 0;
    $pointer = null;
    
    foreach($res[3] as $rs){
        $lhk[$i] = $rs;
        if($rs >= $date && $pointer != null){
        // if((strtotime($rs) >= strtotime($date)) && $pointer == 0){
            // echo $rs.'  '.$date;
            $pointer = $i;
            // dd($pointer+$max);
        }
        $i++;
    }
    if($operand == 'plus'){
        $res['max_date'] = $lhk[$pointer+$max];
    } else {
        $res['max_date'] = $lhk[$pointer-$max];
    }
    
    return $res;
}

function getPredikatSkp($data){
    if(isset($data['hasilKinerja']) && isset($data['perilakuKerja'])){
        $predikatAngka = [
            '33' => 'Sangat Kurang',
            '32' => 'Butuh Perbaikan',
            '31' => 'Butuh Perbaikan',
            '23' => 'Kurang / Misonduct',
            '13' => 'Kurang / Misconduct',
            '22' => 'Baik',
            '21' => 'Baik',
            '12' => 'Baik',
            '11' => 'Sangat Baik',
        ];

        $predikatKata = [
            'DIBAWAH' => 3,
            'SESUAI' => 2,
            'DIATAS' => 1,
        ];

        $explKinerja = explode(" ", $data['hasilKinerja']);
        $explPerilaku = explode(" ", $data['perilakuKerja']);

        return $predikatAngka[$predikatKata[$explPerilaku[0]].''.$predikatKata[$explKinerja[0]]];
    } else {
        return null;
    }
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
    if ($capaian <= 209) {
        $bobot = 0;
    } else if ($capaian > 209 && $capaian <= 678) {
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
                    $d['target_kuantitas'] = $d['realisasi'];
                    // $nilai_capaian = 0;
                } 
                // else {
                    $nilai_capaian = (floatval($d['realisasi']) / floatval($d['target_kuantitas'])) * 100;
                    if($nilai_capaian > 100){
                        $nilai_capaian = 100;
                    }
                // }
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

function countNilaiSkp2($data)
{
    $result['capaian'] = 0;
    $result['bobot'] = 0;
    if ($data) {
        $akumulasi_nilai_capaian = 0;
        foreach ($data as $d) {
            $nilai_capaian = 0;
            dd($d);
            
            if (floatval($d['realisasi']) > 0) {
                if(floatval($d['target']) == 0){
                    $d['target'] = $d['realisasi'];
                    // $nilai_capaian = 0;
                } 
                // else {
                    $nilai_capaian = (floatval($d['realisasi']) / floatval($d['target'])) * 100;
                    if($nilai_capaian > 100){
                        $nilai_capaian = 100;
                    }
                // }
            }
            print_r($d['realisasi']);
            $akumulasi_nilai_capaian += $nilai_capaian;
        }
        
        if (count($data) != 0) {
            $result['capaian'] = floatval($akumulasi_nilai_capaian) / count($data);
        }
        // dd($data);
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

function jsonToUrlEncode($json){
    $i = 0;
    $res = null;
    foreach($json as $key => $val){
        $res .= $key."=".$val;
        if($i != count($json) - 1){
            $res .= "&";
        }
        $i++;
    }

    return $res;
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

function generateRandomString($length = 10, $flag_check = 0, $table = '')
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    if($flag_check == 0) {
        return $randomString;
    } else {
        $helper = &get_instance();
        $helper->load->model('general/M_General', 'general');
        $exists = $helper->general->getOne($table, 'random_string', $randomString, 1);
        if($exists){
            $this->generateRandomString($length, $flag_check, $table);
        } else {
            return $randomString;
        }
    }
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

function getPphByPenghasilanBruto($nominal){

    if($nominal <= 5400000){
        return 0;
    } else if($nominal > 5400000 && $nominal <= 5650000){
        return 0.25;
    } else if($nominal > 5650000 && $nominal <= 5950000){
        return 0.5;
    } else if($nominal > 5950000 && $nominal <= 6300000){
        return 0.75;
    } else if($nominal > 6300000 && $nominal <= 6750000){
        return 1;
    } else if($nominal > 6750000 && $nominal <= 7500000){
        return 1.25;
    } else if($nominal > 7500000 && $nominal <= 8550000){
        return 1.5;
    } else if($nominal > 8550000 && $nominal <= 9650000){
        return 1.75;
    } else if($nominal > 9650000 && $nominal <= 10050000){
        return 2;
    } else if($nominal > 9650000 && $nominal <= 10350000){
        return 2.25;
    } else if($nominal > 10350000 && $nominal <= 10700000){
        return 2.5;
    } else if($nominal > 10700000 && $nominal <= 11050000){
        return 3;
    } else if($nominal > 11050000 && $nominal <= 11600000){
        return 3.5;
    } else if($nominal > 11600000 && $nominal <= 12500000){
        return 4;
    } else if($nominal > 12500000 && $nominal <= 13750000){
        return 5;
    } else if($nominal > 13750000 && $nominal <= 15100000){
        return 6;
    } else if($nominal > 15100000 && $nominal <= 16950000){
        return 7;
    } else if($nominal > 16950000 && $nominal <= 19750000){
        return 8;
    } else if($nominal > 19750000 && $nominal <= 24150000){
        return 9;
    } else if($nominal > 24150000 && $nominal <= 26450000){
        return 10;
    } else if($nominal > 26450000 && $nominal <= 28000000){
        return 11;
    } else if($nominal > 28000000 && $nominal <= 30050000){
        return 12;
    } else if($nominal > 30050000 && $nominal <= 32400000){
        return 13;
    } else if($nominal > 32400000 && $nominal <= 35400000){
        return 14;
    } else if($nominal > 35400000 && $nominal <= 39100000){
        return 15;
    } else if($nominal > 39100000 && $nominal <= 43850000){
        return 16;
    } else if($nominal > 43850000 && $nominal <= 47800000){
        return 17;
    } else if($nominal > 47800000 && $nominal <= 51400000){
        return 18;
    } else if($nominal > 51400000 && $nominal <= 56300000){
        return 19;
    } else if($nominal > 56300000 && $nominal <= 62200000){
        return 20;
    } else {
        return null;
    }
}

function getPphByIdPangkat($id_pangkat)
{
    if (in_array($id_pangkat, [31, 32, 33, 34, 59, 60])) {
        return 5;
    } else if (in_array($id_pangkat, [41, 42, 43, 44, 45])) {
        return 15;
    }
    return 0;
}

function getGolonganByIdPangkat($id_pangkat){
    if (in_array($id_pangkat, [31, 32, 33, 34])) {
        return 'III';
    } else if (in_array($id_pangkat, [11, 12, 13, 14, 15])) {
        return 'I';
    } else if (in_array($id_pangkat, [21, 22, 23, 24, 25])) {
        return 'II';
    } else if (in_array($id_pangkat, [41, 42, 43, 44, 45])) {
        return 'IV';
    } else if (in_array($id_pangkat, [51])) {
        return 'I';
    } else if (in_array($id_pangkat, [59])) {
        return 'IX';
    } else if (in_array($id_pangkat, [55])) {
        return 'V';
    } else if (in_array($id_pangkat, [57])) {
        return 'VII';
    }  else if (in_array($id_pangkat, [60])) {
        return 'X';
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
        $greeting = "Sore";
    } else if((intval($time) >= 18 && intval($time) < 24) || (intval($time) >= 0 && intval($time) < 2)){
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
    $explode = explode(".", $data);
    return number_format(floatval($explode[0]), $decimal, ",", ".");
}

function formatCurrencyWithoutRpWithDecimal($data, $decimal = 2)
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

function formatDateOnlyForEdit3($data)
{
    return date("m-d-Y", strtotime($data));
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
    if($data == "0000-00-00" || $data == ""){
    return "-";
    } else {
    return $explode[0] . ' ' . getNamaBulan($explode[1]) . ' ' . $explode[2];   
    }
    // return $explode[0] . ' ' . getNamaBulan($explode[1]) . ' ' . $explode[2];   

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
    return trim(trim($pegawai['gelar1']).' '.ucwords(strtolower(trim($pegawai['nama']))).' '.trim($pegawai['gelar2']));
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

function getBulanTahunTerakhir($date, $count){
    $explode = explode("-", $date);
    $result = null;
    $j = 0;
    $jumlah_bulan = 12;
    for($i = $count; $i > 0; $i--){
        $result[$j]['bulan'] = date('m', strtotime('-'.$i.' Months'));
        $result[$j]['tahun'] = date('Y', strtotime('-'.$i.' Months'));
        $j++;
    }
    return $result;
}

function decodeAsciiHex($input) {
    $output = "";

    $isOdd = true;
    $isComment = false;

    for($i = 0, $codeHigh = -1; $i < strlen($input) && $input[$i] != '>'; $i++) {
        $c = $input[$i];

        if($isComment) {
            if ($c == '\r' || $c == '\n')
                $isComment = false;
            continue;
        }

        switch($c) {
            case '\0': case '\t': case '\r': case '\f': case '\n': case ' ': break;
            case '%': 
                $isComment = true;
            break;

            default:
                $code = hexdec($c);
                if($code === 0 && $c != '0')
                    return "";

                if($isOdd)
                    $codeHigh = $code;
                else
                    $output .= chr($codeHigh * 16 + $code);

                $isOdd = !$isOdd;
            break;
        }
    }

    if($input[$i] != '>')
        return "";

    if($isOdd)
        $output .= chr($codeHigh * 16);

    return $output;
}
function decodeAscii85($input) {
    $output = "";

    $isComment = false;
    $ords = array();
    
    for($i = 0, $state = 0; $i < strlen($input) && $input[$i] != '~'; $i++) {
        $c = $input[$i];

        if($isComment) {
            if ($c == '\r' || $c == '\n')
                $isComment = false;
            continue;
        }

        if ($c == '\0' || $c == '\t' || $c == '\r' || $c == '\f' || $c == '\n' || $c == ' ')
            continue;
        if ($c == '%') {
            $isComment = true;
            continue;
        }
        if ($c == 'z' && $state === 0) {
            $output .= str_repeat(chr(0), 4);
            continue;
        }
        if ($c < '!' || $c > 'u')
            return "";

        $code = ord($input[$i]) & 0xff;
        $ords[$state++] = $code - ord('!');

        if ($state == 5) {
            $state = 0;
            for ($sum = 0, $j = 0; $j < 5; $j++)
                $sum = $sum * 85 + $ords[$j];
            for ($j = 3; $j >= 0; $j--)
                $output .= chr($sum >> ($j * 8));
        }
    }
    if ($state === 1)
        return "";
    elseif ($state > 1) {
        for ($i = 0, $sum = 0; $i < $state; $i++)
            $sum += ($ords[$i] + ($i == $state - 1)) * pow(85, 4 - $i);
        for ($i = 0; $i < $state - 1; $i++)
            $ouput .= chr($sum >> ((3 - $i) * 8));
    }

    return $output;
}
function decodeFlate($input) {
    return @gzuncompress($input);
}

function getObjectOptions($object) {
    $options = array();
    if (preg_match("#<<(.*)>>#ismU", $object, $options)) {
        $options = explode("/", $options[1]);
        @array_shift($options);

        $o = array();
        for ($j = 0; $j < @count($options); $j++) {
            $options[$j] = preg_replace("#\s+#", " ", trim($options[$j]));
            if (strpos($options[$j], " ") !== false) {
                $parts = explode(" ", $options[$j]);
                $o[$parts[0]] = $parts[1];
            } else
                $o[$options[$j]] = true;
        }
        $options = $o;
        unset($o);
    }

    return $options;
}
function getDecodedStream($stream, $options) {
    $data = "";
    if (empty($options["Filter"]))
        $data = $stream;
    else {
        $length = !empty($options["Length"]) ? $options["Length"] : strlen($stream);
        $_stream = substr($stream, 0, $length);

        foreach ($options as $key => $value) {
            if ($key == "ASCIIHexDecode")
                $_stream = decodeAsciiHex($_stream);
            if ($key == "ASCII85Decode")
                $_stream = decodeAscii85($_stream);
            if ($key == "FlateDecode")
                $_stream = decodeFlate($_stream);
        }
        $data = $_stream;
    }
    return $data;
}
function getDirtyTexts(&$texts, $textContainers) {
    for ($j = 0; $j < count($textContainers); $j++) {
        if (preg_match_all("#\[(.*)\]\s*TJ#ismU", $textContainers[$j], $parts))
            $texts = array_merge($texts, @$parts[1]);
        elseif(preg_match_all("#Td\s*(\(.*\))\s*Tj#ismU", $textContainers[$j], $parts))
            $texts = array_merge($texts, @$parts[1]);
    }
}
function getCharTransformations(&$transformations, $stream) {
    preg_match_all("#([0-9]+)\s+beginbfchar(.*)endbfchar#ismU", $stream, $chars, PREG_SET_ORDER);
    preg_match_all("#([0-9]+)\s+beginbfrange(.*)endbfrange#ismU", $stream, $ranges, PREG_SET_ORDER);

    for ($j = 0; $j < count($chars); $j++) {
        $count = $chars[$j][1];
        $current = explode("\n", trim($chars[$j][2]));
        for ($k = 0; $k < $count && $k < count($current); $k++) {
            if (preg_match("#<([0-9a-f]{2,4})>\s+<([0-9a-f]{4,512})>#is", trim($current[$k]), $map))
                $transformations[str_pad($map[1], 4, "0")] = $map[2];
        }
    }
    for ($j = 0; $j < count($ranges); $j++) {
        $count = $ranges[$j][1];
        $current = explode("\n", trim($ranges[$j][2]));
        for ($k = 0; $k < $count && $k < count($current); $k++) {
            if (preg_match("#<([0-9a-f]{4})>\s+<([0-9a-f]{4})>\s+<([0-9a-f]{4})>#is", trim($current[$k]), $map)) {
                $from = hexdec($map[1]);
                $to = hexdec($map[2]);
                $_from = hexdec($map[3]);

                for ($m = $from, $n = 0; $m <= $to; $m++, $n++)
                    $transformations[sprintf("%04X", $m)] = sprintf("%04X", $_from + $n);
            } elseif (preg_match("#<([0-9a-f]{4})>\s+<([0-9a-f]{4})>\s+\[(.*)\]#ismU", trim($current[$k]), $map)) {
                $from = hexdec($map[1]);
                $to = hexdec($map[2]);
                $parts = preg_split("#\s+#", trim($map[3]));
                
                for ($m = $from, $n = 0; $m <= $to && $n < count($parts); $m++, $n++)
                    $transformations[sprintf("%04X", $m)] = sprintf("%04X", hexdec($parts[$n]));
            }
        }
    }
}
function getTextUsingTransformations($texts, $transformations) {
    $document = "";
    for ($i = 0; $i < count($texts); $i++) {
        $isHex = false;
        $isPlain = false;

        $hex = "";
        $plain = "";
        for ($j = 0; $j < strlen($texts[$i]); $j++) {
            $c = $texts[$i][$j];
            switch($c) {
                case "<":
                    $hex = "";
                    $isHex = true;
                break;
                case ">":
                    $hexs = str_split($hex, 4);
                    for ($k = 0; $k < count($hexs); $k++) {
                        $chex = str_pad($hexs[$k], 4, "0");
                        if (isset($transformations[$chex]))
                            $chex = $transformations[$chex];
                        $document .= html_entity_decode("&#x".$chex.";");
                    }
                    $isHex = false;
                break;
                case "(":
                    $plain = "";
                    $isPlain = true;
                break;
                case ")":
                    $document .= $plain;
                    $isPlain = false;
                break;
                case "\\":
                    $c2 = $texts[$i][$j + 1];
                    if (in_array($c2, array("\\", "(", ")"))) $plain .= $c2;
                    elseif ($c2 == "n") $plain .= '\n';
                    elseif ($c2 == "r") $plain .= '\r';
                    elseif ($c2 == "t") $plain .= '\t';
                    elseif ($c2 == "b") $plain .= '\b';
                    elseif ($c2 == "f") $plain .= '\f';
                    elseif ($c2 >= '0' && $c2 <= '9') {
                        $oct = preg_replace("#[^0-9]#", "", substr($texts[$i], $j + 1, 3));
                        $j += strlen($oct) - 1;
                        $plain .= html_entity_decode("&#".octdec($oct).";");
                    }
                    $j++;
                break;

                default:
                    if ($isHex)
                        $hex .= $c;
                    if ($isPlain)
                        $plain .= $c;
                break;
            }
        }
        $document .= "\n";
    }

    return $document;
}

function pdf2text($filename) {
    $infile = @file_get_contents($filename, FILE_BINARY);
    if (empty($infile))
        return "";

    $transformations = array();
    $texts = array();

    preg_match_all("#obj(.*)endobj#ismU", $infile, $objects);
    $objects = @$objects[1];

    for ($i = 0; $i < count($objects); $i++) {
        $currentObject = $objects[$i];

        if (preg_match("#stream(.*)endstream#ismU", $currentObject, $stream)) {
            $stream = ltrim($stream[1]);

            $options = getObjectOptions($currentObject);
            if (!(empty($options["Length1"]) && empty($options["Type"]) && empty($options["Subtype"])))
                continue;

            $data = getDecodedStream($stream, $options); 
            if (strlen($data)) {
                if (preg_match_all("#BT(.*)ET#ismU", $data, $textContainers)) {
                    $textContainers = @$textContainers[1];
                    getDirtyTexts($texts, $textContainers);
                } else
                    getCharTransformations($transformations, $data);
            }
        }
    }

    return getTextUsingTransformations($texts, $transformations);
}

function isSuratCutiTahunan($array){
    $string = "SURAT IZIN CUTI TAHUNAN";
    $explode = explode(" ", $string);
    $lama_cuti = 0;
    $tanggal_mulai = 0;
    $ongoing = 0;
    $valid = 0;
    $i = 0;
    foreach($array as $a){
        if($valid == 1 && strcmp($a, "Selama") == 0){
            $lama_cuti = $array[$i+1];
        }
        if($valid == 0 && strcmp($a, $explode[$ongoing]) == 0){
            $ongoing++;
            if($ongoing == 3){
                $valid = 1;
            }
        } else {
            $ongoing = 0;
        }
        $i++;
    }
    return [
        'result' => $valid == 0 ? false : true,
        'lama_cuti' => $lama_cuti,
    ];
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
        return "" . $abil[$x];

    elseif ($x < 20)
        return terbilang($x - 10) . " Belas ";
    elseif ($x < 100)
        return terbilang($x / 10) . " Puluh " . terbilang($x % 10);
    elseif ($x < 200)
        return " Seratus" . terbilang($x - 100);
    elseif ($x < 1000)
        return terbilang($x / 100) . " Ratus " . terbilang($x % 100);
    elseif ($x < 2000)
        return " Seribu" . terbilang($x - 1000);
    elseif ($x < 1000000)
        return terbilang($x / 1000) . " Ribu " . terbilang($x % 1000);
    elseif ($x < 1000000000)
        return terbilang($x / 1000000) . " Juta " . terbilang($x % 1000000);
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

function getExcelColumnNameByNumber($num) {
    $numeric = ($num - 1) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($num - 1) / 26);
    if ($num2 > 0) {
        return getExcelColumnNameByNumber($num2) . $letter;
    } else {
        return $letter;
    }
}

function convertPhoneNumber($nohp){
    return "62".substr($nohp, 1, strlen($nohp)-1);
}

function isKasubKepegawaian($nama_jabatan, $eselon = null){
    $CI = &get_instance();
    if($eselon != null){
        $eselon = $CI->general_library->getEselon();
    }

    if(stringStartWith('Kepala Sub Bagian Tata Usaha', $nama_jabatan)){
        $eselon = $CI->general_library->getEselon();
    }

    if($CI->general_library->isHakAkses('role_kasubag_kepegawaian')){
        return true;
    }
    
    return (stringStartWith('Kepala Sub Bagian Umum dan Kepegawaian', $nama_jabatan) || 
    stringStartWith('Kepala Sub Bagian Kepegawaian', $nama_jabatan) ||
    stringStartWith('Kasubag. Umum dan Kepegawaian', $nama_jabatan) ||
    stringStartWith('Kepala Sub Bagian Administrasi dan Umum', $nama_jabatan) ||
    stringStartWith('Kepala Sub Bagian Umum, Hukum dan Kepegawaian', $nama_jabatan) ||
    (stringStartWith('Kepala Sub Bagian Tata Usaha', $nama_jabatan) && $eselon == 'IV A')) 
    ? true : false;
}

function countTmtPensiun($nip, $umur = 0){
    $tahun = floatval(substr($nip, 0, 4));
    $bulan = floatval(substr($nip, 4, 2));
    $tanggal = substr($nip, 6, 2);
    $tahun += $umur;
    
    if($bulan == '12'){
        $tahun += 1;
        return $tahun."-01-01";
    } else {
        $bulan += 1;
        return $tahun.'-'.$bulan.'-01';
    }
}

function pembulatan($number){
    // return $number;

    $temp = explode(".", $number);

    return $temp[0];

    // return number_format($number,0,'.','');

    // $CI = &get_instance();

    // $rounded = floor($number);
    // return $rounded;
    // $whole = $number - $rounded;
    // if($whole != 0){
    //     if($CI->general_library->isProgrammer()){
    //         $number = $rounded;
    //     } else {
    //         // pembulatan angka belakang comma, jika 0.5 ke atas, tambahkan 1
    //         $number = $whole >= 0.5 ? $rounded + 1 : $rounded;
    //     }
    // }
    // return $number;
}

function excelRoundDown($number, $length){
    $number = floor($number * pow(10, $length)) / pow(10, $length);
    return $number;
}

function pembulatanDecimal($number, $length = 1){
    $add = 0;
    $strnum = strval($number);
    $strlen = strlen($strnum);

    if($strlen < $length + 3 || $length == 0){
        return $number;
    }
    
    $substr = substr($strnum, 0, $length+2);
    $last_substr = substr($substr, strlen($substr)-1);
    
    $substr_po = substr($strnum, 0, $length+3); //substring plus one
    $last_substr_po = substr($substr_po, strlen($substr_po)-1);

    if(floatval($last_substr_po) >= 5){
        $awal_add = "0.";
        if($length == 1){
            $add = $awal_add."1";
        } else {
            $add = "";
            for($i = 1; $i <= $length-1; $i++){
                $add .= "0";
            }
            $add = $awal_add.$add."1";
        }
    }

    return floatval($substr) + $add;
}

function emojiToString($text) {
    $str = preg_replace_callback(
        "%(?:\xF0[\x90-\xBF][\x80-\xBF]{2} | [\xF1-\xF3][\x80-\xBF]{3} | \xF4[\x80-\x8F][\x80-\xBF]{2})%xs",
        function($emoji){
            $emojiStr = mb_convert_encoding($emoji[0], 'UTF-32', 'UTF-8');
            return strtoupper(preg_replace("/^[0]+/","U+",bin2hex($emojiStr)));
        },
        $text
    );
    return $str;
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

function isContainSeq($string, $match){
    $explodeStr = explode(" ", $string);
    $explodeMatch = explode(" ", $match);
    
    $countMatch = count($explodeMatch);
    $i = 0;
    $j = 0;

    foreach($explodeStr as $es){
        if($es == $explodeMatch[$i]){
            $i++;
            if($i == $countMatch){
                return true;
            }
        } else {
            $i = 0;
        }
    }
    return false;
}

function pemeringkatanKriteriaKinerja($nilai){
    $helper = &get_instance();
    $helper->load->model('simata/M_Simata', 'simata');
    $list_interval = $helper->simata->getListIntervalKinerja();
    $pemeringkatan = null;
    $badge = null;

    foreach ($list_interval as $li) {
        if($nilai == 0) {
            // $badge = "primary";
            // $pemeringkatan = "-";
            $badge = "danger";
            $pemeringkatan = "<span class='badge bg-".$badge."'>Di bawah ekspektasi</span>";
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

function generateQrOld($content, $filepath ){
    // $logo = (base_url('assets/img/logopemkot.png'));
    $logo = (base_url('assets/adminkit/img/logo-pemkot-small.png'));
    $QR = imagecreatefrompng("https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=".urlencode($content)."&choe=UTF-8");
    // if($logo !== FALSE){
        $logo = imagecreatefromstring(file_get_contents($logo));

        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);
        
        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);
        
        // Scale logo to fit in the QR Code
        $logo_qr_width = $QR_width/6;
        $scale = $logo_width/$logo_qr_width;
        $logo_qr_height = $logo_height/$scale;
        
        imagecopyresampled($QR, $logo, $QR_width/2.5, $QR_height/2.5, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
    // }
    // header('Content-Type: image/png');
    imagepng($QR, $filepath);
    return $filepath;
}

function generateQr($content = 'https://presensi.manadokota.go.id/siladen', $type = 'uri'){
    $logo = (base_url('assets/img/logopemkot.png'));
    $qr = new QrCode($content);
    $qr->setText($content)
        ->setLogoPath('assets/img/logopemkot.png')
        ->setLogoWidth(75)
        ->setSize(300)
        ->setMargin(0)
        ->setValidateResult(false)
        ->setForegroundColor(['r' => 148, 'g' => 0, 'b' => 0]);
    // dd($qr);
    return $qr->writeDataUri();
}

function pemeringkatanKriteriaPotensial($nilai){
    $helper = &get_instance();
    $helper->load->model('simata/M_Simata', 'simata');
    $list_interval = $helper->simata->getListIntervalPotensial();

    
    $pemeringkatan = null;
    $badge = null;
    foreach ($list_interval as $li) {
        if($nilai == 0) {
            $badge = "danger";
            // $pemeringkatan = "-";
            $pemeringkatan = "<span class='badge bg-".$badge."'>Rendah</span>";

        } else {
            if($nilai >= $li['dari'] AND $nilai <= $li['sampai']){
                if($li['id'] == 2) {
                $badge = "success";
                } else if($li['id'] == 5) {
                $badge = "secondary";
                } else if($li['id'] == 6) {
                $badge = "danger";
                }
                $pemeringkatan = "<span class='badge bg-".$badge."'>".$li['kriteria']."</span>";
            }   
        }
       
       
    }

    return $pemeringkatan;
}

function pemetaanTalenta($nilaix,$nilaiy){
    $helper = &get_instance();
    $helper->load->model('simata/M_Simata', 'simata');
    $list_interval = $helper->simata->getListIntervalPotensial();

    
    $hasil = null;
    $badge = null;
    if($nilaix >= 77 && $nilaiy >= 85) {
        $hasil = "IX";
       } 
       if($nilaix >= 77 && $nilaiy >= 70 && $nilaiy < 85) {
        // print_r($nilaix."-".$nilaiy.",");
        $hasil = "VIII";
       }
       if($nilaix >= 68 && $nilaix < 77 && $nilaiy >= 85) {
        $hasil = "VII";
       } 
      if($nilaix >= 77 && $nilaiy < 70) {
        $hasil = "VI";
       } 
       if($nilaix >= 68 && $nilaix < 77 && $nilaiy >= 70 && $nilaiy < 85) {
        $hasil = "V";
      } 
      if($nilaix < 68 && $nilaiy >= 85) {
        $hasil = "IV";
      } 
      if($nilaix >= 68 && $nilaix < 77 && $nilaiy < 70) {
        $hasil = "III";
      }
      if($nilaix < 68 && $nilaiy >= 70 && $nilaiy < 85) {
        $hasil = "II";
      }
      if($nilaix < 68 && $nilaiy < 70) {
        $hasil = "I";
      }  

    return $hasil;
}

function rekomendasi($nilaix,$nilaiy){
    $helper = &get_instance();
    $helper->load->model('simata/M_Simata', 'simata');
    $list_interval = $helper->simata->getListIntervalPotensial();
    // dd($list_interval[0]['dari']);

    
    $hasil = null;
    $badge = null;
    if($nilaix >= $list_interval[0]['dari'] && $nilaiy >= 85) {
        $hasil = "IX";
        $rekom = "1. Dipromosikan dan dipertahankan<br>
        2. Masuk Kelompok Rencana Suksesi
        Instansi/Nasional<br>
        3. Penghargaan";
       } 
       if($nilaix >= 77 && $nilaiy >= 70 && $nilaiy < 85) {
        // print_r($nilaix."-".$nilaiy.",");
        $hasil = "VIII";
        $rekom = "1. Dipertahankan<br>
        2. Masuk Kelompok Rencana Suksesi
        Instansi<br>
        3. Rotasi/Perluasan jabatan<br>
        4. Bimbingan kinerja";
       }
       if($nilaix >= 68 && $nilaix < 77 && $nilaiy >= 85) {
        $hasil = "VII";
        $rekom = "1. Dipertahankan <br>
        2. Masuk Kelompok Rencana Suksesi 
        Instansi<br>
        3. Rotasi/Pengayaan jabatan <br>
        4. Pengembangan kompetensi <br>
        5. Tugas belajar"; 
       } 
      if($nilaix >= 77 && $nilaiy < 70) {
        $hasil = "VI";
        $rekom = "1. Penempatan yang sesuai<br>
        2. Bimbingan kinerja<br>
        3. Konseling kinerja
        ";
       } 
       if($nilaix >= 68 && $nilaix < 77 && $nilaiy >= 70 && $nilaiy < 85) {
        $hasil = "V";
        $rekom = "1. Penempatan yang sesuai<br>
        2. Bimbingan kinerja<br>
        3. Pengembangan kompetensi";
      } 
      if($nilaix < 68 && $nilaiy >= 85) {
        $hasil = "IV";
        $rekom = "1. Rotasi<br>
        2. Pengembangan kompetensi";
      } 
      if($nilaix >= 68 && $nilaix < 77 && $nilaiy < 70) {
        $hasil = "III";
        $rekom = "1. Bimbingan kinerja<br>
        2. Konseling kinerja<br>
        3. Pengembangan kompetensi<br>
        4. Penempatan yang sesuai";
      }
      if($nilaix < 68 && $nilaiy >= 70 && $nilaiy < 85) {
        $hasil = "II";
        $rekom = "1. Bimbingan kinerja<br>
        2. Pengembangan kompetensi<br>
        3. Penempatan yang sesuai
        ";
      }
      if($nilaix < 68 && $nilaiy < 70) {
        $hasil = "I";
        $rekom = "Diproses sesuai ketentuan peraturan
        perundangan";
      }  

    return $rekom;
}



function numberToRoman($number) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
}

function simpleEncrypt($string){
    return strtr(base64_encode($string), '+/=', '-_,');
}

function simpleDecrypt($decrypted){
    return base64_decode(strtr($decrypted, '-_,', '+/='));
}

function qounterNomorSurat($tahun){
    $helper = &get_instance();
    $helper->load->model('general/M_General', 'general');
    $counter = $helper->general->getlastNomorSurat($tahun);
    return $counter;
}
