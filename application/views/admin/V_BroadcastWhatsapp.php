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
    $this->load->view('admin/V_BroadcastWhatsappForm', $data);
?>