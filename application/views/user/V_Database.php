<?php
    $data['pangkat'] = $pangkat;
    $data['eselon'] = $eselon;
    $data['statuspeg'] = $statuspeg;
    $data['tktpendidikan'] = $tktpendidikan;
    $data['agama'] = $agama;
    $data['unitkerja'] = $unitkerja;
    $data['satyalencana'] = $satyalencana;
    $data['golongan'] = $golongan;
    $data['jenis_kelamin'] = $jenis_kelamin;
    $data['jenis_jabatan'] = $jenis_jabatan;
    $data['search'] = $search;
    $this->load->view('user/V_PegawaiAll', $data);
?>