<?php
require_once 'tio.php';
require_once 'laporan.php';

defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'C_Main';
$route['404_override'] = 'login/C_Login/notFoundOverride';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'login/C_Login/login';
$route['logout'] = 'login/C_Login/logout';


// admin
$route['welcome'] = 'login/C_Login/welcomePage';
$route['kinerja/realisasi'] = 'kinerja/C_Kinerja/Kinerja';
$route['kinerja/rencana'] = 'kinerja/C_Kinerja/rencanaKinerja';
$route['kinerja/rekap'] = 'kinerja/C_Kinerja/rekapKinerja';
$route['users/mutasi'] = 'user/C_User/mutasiPegawai';




// Kepegawaian
// $route['kepegawaian/upload'] = 'kepegawaian/C_Kepegawaian/uploadDokumen';
$route['kepegawaian/pasPhoto'] = 'kepegawaian/C_pasphoto/pasPhoto';
$route['kepegawaian/upload'] = 'kepegawaian/C_Kepegawaian/uploadDokumen';
$route['kepegawaian/profil'] = 'kepegawaian/C_Kepegawaian/uploadDokumen';
$route['kepegawaian/layanan'] = 'kepegawaian/C_Kepegawaian/layanan';
$route['kepegawaian/teknis'] = 'kepegawaian/C_Kepegawaian/Adminlayanan';
$route['kepegawaian/cetak/'] = 'kepegawaian/C_Kepegawaian/CetakSurat';
$route['kepegawaian/verifikasi/(:any)/(:any)'] = 'kepegawaian/C_Kepegawaian/verifikasiLayanan/$1/$2';
$route['kepegawaian/dokumen/verifikasi'] = 'kepegawaian/C_Kepegawaian/verifikasiDokumen';

$route['kepegawaian/profil-pegawai/(:any)'] = 'kepegawaian/C_Kepegawaian/profilPegawai/$1';
$route['kepegawaian/profil/(:any)'] = 'kepegawaian/C_Kepegawaian/uploadDokumen/$1'; 
$route['kepegawaian/tambah'] = 'kepegawaian/C_Kepegawaian/LoadFormTambahPegawai';


//api
$route['api/get-sasaran-kerja'] = 'api/C_ApiKinerja/getKinerja';
$route['api/rekap-absensi/personal'] = 'api/User/getRekapAbsenPersonal';

// simata 
$route['mt/data-master-indikator'] = 'simata/C_Simata/masterIndikator';
$route['mt/data-master-interval'] = 'simata/C_Simata/masterInterval';
// $route['mt/jabatan-target/(:any)'] = 'simata/C_Simata/jabatanTarget/$1';
$route['mt/jabatan-target'] = 'simata/C_Simata/jabatanTarget';
$route['mt/submit-jabatan-target'] = 'simata/C_Simata/submitJabatanTarget';
$route['mt/list-jabatan-target'] = 'simata/C_Simata/loadListPegawaiDinilai';
$route['mt/penilaian-kinerja'] = 'simata/C_Simata/penilaianKinerja';
$route['mt/ninebox'] = 'simata/C_Simata/nineBox';
$route['mt/penilaian-potensial'] = 'simata/C_Simata/penilaianPotensial';
$route['mt/profil-talenta'] = 'simata/C_Simata/profilTalenta';
$route['mt/data-master-jabatan'] = 'simata/C_Simata/masterJabatan';
$route['mt/data-rumpun'] = 'simata/C_Simata/rumpun';
$route['mt/data-rumpun/(:any)'] = 'simata/C_Simata/rumpun/$1';
$route['mt/penilaian-kompetensi'] = 'simata/C_Simata/penilaianKompetensi';

