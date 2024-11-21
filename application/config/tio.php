<?php
$route['users'] = 'user/C_User/users';
$route['user/password/change'] = 'user/C_User/personalChangePassword';
$route['user/setting'] = 'user/C_User/userSetting';
$route['roles'] = 'user/C_User/roles';
$route['menu'] = 'user/C_User/menu';
$route['master/pesan/jenis'] = 'master/C_Master/jenisPesan';
$route['master/lock-tpp'] = 'master/C_Master/lockTpp';
$route['master/hari-libur'] = 'master/C_Master/hariLibur';
$route['master/jam-kerja'] = 'master/C_Master/jamKerja';
$route['master/jenis-layanan'] = 'master/C_Master/jenisLayanan';
$route['pesan/send/individu'] = 'message/C_Message/individuMessage';
$route['pesan/send/bulk'] = 'message/C_Message/bulkMessage';
$route['master/bidang'] = 'master/C_Master/masterBidang';
$route['master/bidang/sub'] = 'master/C_Master/masterSubBidang';
$route['master/perangkat-daerah'] = 'master/C_Master/masterSkpd';
$route['master/hak-akses'] = 'master/C_Master/masterHakAkses';
$route['master/pelanggaran'] = 'master/C_Master/masterPelanggaran';
$route['master/perangkat-daerah/detail/(:any)'] = 'master/C_Master/detailMasterSkpd/$1';
$route['rekap/verif-pdm'] = 'rekap/C_Rekap/rekapVerifPdm';




//pelanggaran
$route['pelanggaran'] = 'kinerja/C_Kinerja/pelanggaran';

// $route['kinerja/verifikasi'] = 'kinerja/C_VerifKinerja/verifKinerja';
$route['kinerja/verifikasi'] = 'kinerja/C_VerifKinerja/verifKinerjaNew';
$route['kinerja/rekapitulasi-realisasi'] = 'kinerja/C_VerifKinerja/rekapRealisasi';
$route['kinerja/skp-bulanan'] = 'kinerja/C_Kinerja/skpBulanan';
$route['kinerja/skbp-perangkatdaerah'] = 'kinerja/C_Kinerja/skbpPd';
// $route['kinerja/skbp'] = 'kinerja/C_Kinerja/skbp';
$route['kinerja/skbp'] = 'kinerja/C_Kinerja/skpBulanan';
$route['kinerja/komponen'] = 'kinerja/C_Kinerja/komponenKinerja';
// $route['kinerja/disiplin'] = 'kinerja/C_Kinerja/disiplinKerja';
$route['dokumen-pendukung-absensi/upload'] = 'kinerja/C_Kinerja/disiplinKerja';
$route['dokumen-pendukung-absensi/verifikasi'] = 'kinerja/C_Kinerja/verifikasiDokumenPendukung';
$route['dokumen-pendukung-absensi/hukdis/input'] = 'kinerja/C_Kinerja/hukdis';

$route['rekapitulasi/realisasi-kinerja'] = 'kinerja/C_VerifKinerja/rekapRealisasi';
// $route['rekapitulasi/absensi'] = 'rekap/C_Rekap/rekapAbsensi';
$route['rekapitulasi/absensi'] = 'rekap/C_Rekap/rekapAbsensiNew';
$route['rekapitulasi/penilaian/disiplin'] = 'rekap/C_Rekap/rekapPenilaianDisiplin';
$route['rekapitulasi/penilaian/produktivitas'] = 'rekap/C_Rekap/rekapPenilaian';
$route['rekapitulasi/tpp'] = 'rekap/C_Rekap/rekapTpp';
$route['master/tpp'] = 'master/C_Master/tpp';

$route['dashboard'] = 'dashboard/C_Dashboard/dashboard';
$route['pdm/dashboard'] = 'dashboard/C_Dashboard/dashboardPdm';
$route['kepegawaian/dashboard'] = 'dashboard/C_Dashboard/dashboardKepegawaian';
$route['kepegawaian/nomor-surat'] = 'kepegawaian/C_Kepegawaian/nomorSurat';
$route['pegawai/tpp/detail'] = 'user/C_User/detailTppPegawai';
$route['rekap/presensi-pegawai'] = 'user/C_User/absensiPegawai';

$route['database'] = 'user/C_User/pegawaiList';
$route['database/(:any)'] = 'user/C_User/pegawaiList/$1';
$route['list-pegawai'] = 'user/C_User/pegawaiList';
$route['list-pegawai/pensiun'] = 'user/C_User/pegawaiPensiun';
$route['list-pegawai/naik-pangkat'] = 'user/C_User/pegawaiNaikPangkat';
$route['list-pegawai/gaji-berkala'] = 'user/C_User/pegawaiGajiBerkala';
$route['master/list-tpp'] = 'master/C_Master/listTpp';
$route['master/input-gaji'] = 'master/C_Master/inputGaji';

//maxchat
$route['api/maxchat/webhook'] = 'maxchat/C_Maxchat/webhook';
$route['api/maxchat/message/send/(:any)'] = 'maxchat/C_Maxchat/sendMessage/$1';

//cron
$route['cron/absensi/skpd/rekap'] = 'cron/C_Cron/cronRekapAbsen';
$route['cron/rekap-absensi-pd'] = 'cron/C_Cron/cronRekapAbsenPD';
$route['cron/send-wa-message'] = 'cron/C_Cron/cronSendWa';
$route['cron/cron-ds-bulk-tte-cuti'] = 'cron/C_Cron/cronDsBulkTte';
$route['cron/cron-bkad-update-gaji'] = 'cron/C_Cron/cronUpdateGajiBkad';

//walikota
$route['walikota/dashboard'] = 'dashboard/C_Dashboard/dashboardWalikota';

//cuti
$route['kepegawaian/permohonan-cuti'] = 'kepegawaian/C_Kepegawaian/permohonanCuti';
$route['kepegawaian/verifikasi-permohonan-cuti'] = 'kepegawaian/C_Kepegawaian/verifikasiPermohonanCuti';
$route['whatsapp-verification/cuti/(:any)'] = 'verif_whatsapp/C_VerifWhatsapp/verifWhatsapp/$1';

//rating layanan
$route['survey-kepuasan-layanan/(:any)'] = 'verif_whatsapp/C_VerifWhatsapp/surveyKepuasan/$1';

//verifikasi TTE pdf
$route['verifPdf/(:any)'] = 'kepegawaian/C_VerifTte/verifPdf/$1';

//DS
$route['kepegawaian/digital-signature'] = 'kepegawaian/C_Kepegawaian/digitalSignature';

//SIASN
$route['siasn/mapping/unor'] = 'master/C_Master/mappingUnor';
$route['siasn/mapping/bidang'] = 'master/C_Master/mappingBidang';
$route['siasn/mapping/jabatan'] = 'master/C_Master/mappingJabatan';

//SIMPONI ASN (Pensiun Otomatis)
$route['kepegawaian/pensiun/kelengkapan-berkas/(:any)'] = 'kepegawaian/C_Layanan/kelengkapanBerkas/$1';

//BKAD
$route['bkad/rekapitulasi/tpp/format-bkad'] = 'rekap/C_Rekap/formatTppBkad';
$route['bkad/upload-gaji'] = 'rekap/C_Rekap/uploadGajiBkad';

//TPP
$route['tpp/upload-berkas'] = 'rekap/C_Rekap/uploadBerkasTpp';