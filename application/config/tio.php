<?php
$route['users'] = 'user/C_User/users';
$route['user/setting'] = 'user/C_User/userSetting';
$route['roles'] = 'user/C_User/roles';
$route['menu'] = 'user/C_User/menu';
$route['master/pesan/jenis'] = 'master/C_Master/jenisPesan';
$route['master/hari-libur'] = 'master/C_Master/hariLibur';
$route['master/jam-kerja'] = 'master/C_Master/jamKerja';
$route['pesan/send/individu'] = 'message/C_Message/individuMessage';
$route['pesan/send/bulk'] = 'message/C_Message/bulkMessage';
$route['master/bidang'] = 'master/C_Master/masterBidang';
$route['master/bidang/sub'] = 'master/C_Master/masterSubBidang';
$route['master/perangkat-daerah'] = 'master/C_Master/masterSkpd';
$route['master/perangkat-daerah/detail/(:any)'] = 'master/C_Master/detailMasterSkpd/$1';


// $route['kinerja/verifikasi'] = 'kinerja/C_VerifKinerja/verifKinerja';
$route['kinerja/verifikasi'] = 'kinerja/C_VerifKinerja/verifKinerjaNew';
$route['kinerja/rekapitulasi-realisasi'] = 'kinerja/C_VerifKinerja/rekapRealisasi';
$route['kinerja/skp-bulanan'] = 'kinerja/C_Kinerja/skpBulanan';
$route['kinerja/skbp'] = 'kinerja/C_Kinerja/skbp';
// $route['kinerja/skbp'] = 'kinerja/C_Kinerja/skpBulanan';
$route['kinerja/komponen'] = 'kinerja/C_Kinerja/komponenKinerja';
// $route['kinerja/disiplin'] = 'kinerja/C_Kinerja/disiplinKerja';
$route['dokumen-pendukung-absensi/upload'] = 'kinerja/C_Kinerja/disiplinKerja';
$route['dokumen-pendukung-absensi/verifikasi'] = 'kinerja/C_Kinerja/verifikasiDokumenPendukung';

$route['rekapitulasi/realisasi-kinerja'] = 'kinerja/C_VerifKinerja/rekapRealisasi';
// $route['rekapitulasi/absensi'] = 'rekap/C_Rekap/rekapAbsensi';
$route['rekapitulasi/absensi'] = 'rekap/C_Rekap/rekapAbsensiNew';
$route['rekapitulasi/penilaian/disiplin'] = 'rekap/C_Rekap/rekapPenilaianDisiplin';
$route['rekapitulasi/penilaian/produktivitas'] = 'rekap/C_Rekap/rekapPenilaian';
$route['rekapitulasi/tpp'] = 'rekap/C_Rekap/rekapTpp';
$route['master/tpp'] = 'master/C_Master/tpp';

$route['dashboard'] = 'dashboard/C_Dashboard/dashboard';
$route['pegawai/tpp/detail'] = 'user/C_User/detailTppPegawai';
$route['rekap/presensi-pegawai'] = 'user/C_User/absensiPegawai';

$route['list-pegawai/pensiun'] = 'user/C_User/pegawaiPensiun';
$route['list-pegawai/naik-pangkat'] = 'user/C_User/pegawaiNaikPangkat';
$route['list-pegawai/gaji-berkala'] = 'user/C_User/pegawaiGajiBerkala';