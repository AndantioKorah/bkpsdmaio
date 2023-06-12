<?php if(isset($skpd)){ ?>
    <html>
        <head>
            <style>
                .nm_hrl{
                    font-size: .9rem;
                    font-weight: bold;
                }

                .tgl_hrl{
                    font-size: .8rem;
                    font-weight: 600;
                }
            </style>
        </head>
        <?php
            if(isset($flag_print) && $flag_print == 1 && !isset($flag_pdf)){
                $filename = $nama_file;
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=\"$filename\""); 
            }
        ?>
        <?php if(isset($flag_print) && $flag_print == 1){ ?>
            <body style="font-family: Tahoma">
        <?php } else { ?>
            <body>
        <?php } ?>
            <?php if(isset($flag_print) && $flag_print == 1 && isset($flag_pdf) && $flag_pdf == 1){
                $this->load->view('adminkit/partials/V_HeaderRekapAbsen', '');
            ?>
            <?php } ?>
            <center>
                <h5 style="font-size: 20px; text-align: center;">
                    REKAP ABSENSI <?=strtoupper($skpd)?><br>
                    <?php if(isset($flag_rekap_aars)){ ?>
                        <?="BULAN ".strtoupper($periode)?>
                    <?php } else { ?>
                        <?=strtoupper($periode)?>
                    <?php } ?>
                </h5>
                <?php if(isset($flag_print) && $flag_print == 0){ ?>
                    <?php if(isset($flag_rekap_aars)){ ?>
                        <div class="row">
                            <div class="col">
                                <form target="_blank" action="<?=base_url('rekap/C_Rekap/downloadRekapAbsensiAars')?>">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-file-excel"></i> Download as Excel</button>
                                </form>
                            </div>
                            <div class="col">
                                <form target="_blank" action="<?=base_url('rekap/C_Rekap/downloadRekapAbsensiAars/1')?>">
                                    <button class="btn btn-danger" type="submit"><i class="fa fa-file-pdf"></i> Download as Pdf</button>
                                </form>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <div class="col">
                                <form target="_blank" action="<?=base_url('rekap/C_Rekap/downloadAbsensiNew')?>">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-file-excel"></i> Download as Excel</button>
                                </form>
                            </div>
                            <div class="col">
                                <form target="_blank" action="<?=base_url('rekap/C_Rekap/downloadAbsensiNew/1')?>">
                                    <button class="btn btn-danger" type="submit"><i class="fa fa-file-pdf"></i> Download as Pdf</button>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <br>
                    <span style="font-size: 14px; font-weight: bold;">Jadwal Jam Kerja <?=$jam_kerja['nama_jam_kerja']?></span>
                    <table style="width: 50%; margin-bottom: 10px;" border=1>
                        <thead>
                            <th style="text-align: center; font-size: 14px;">Hari</th>
                            <th style="text-align: center; font-size: 14px;">Jam Masuk</th>
                            <th style="text-align: center; font-size: 14px;">Jam Pulang</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-size: 14px; text-align: center;">Senin - Kamis</td>
                                <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($jam_kerja['wfo_masuk'])?></td>
                                <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($jam_kerja['wfo_pulang'])?></td>
                            </tr>
                            <tr>
                                <td style="font-size: 14px; text-align: center;">Jumat</td>
                                <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($jam_kerja['wfoj_masuk'])?></td>
                                <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($jam_kerja['wfoj_pulang'])?></td>
                            </tr>
                        </tbody>
                    </table>

                    <?php if(isset($jam_kerja_event) && count($jam_kerja_event) > 0){
                        foreach($jam_kerja_event as $jke){
                    ?>
                        <br>
                        <div>
                        <span style="font-size: 14px; font-weight: bold;">Jadwal Jam Kerja <?=$jke['nama_jam_kerja']?></span><br>
                        <span style="font-size: 14px; font-weight: normal;"><?='Berlaku dari '.formatDateNamaBulan($jke['berlaku_dari']).' - '.formatDateNamaBulan($jke['berlaku_sampai'])?></span>
                        <table style="width: 50%; margin-bottom: 10px;" border=1>
                            <thead>
                                <th style="text-align: center; font-size: 14px;">Hari</th>
                                <th style="text-align: center; font-size: 14px;">Jam Masuk</th>
                                <th style="text-align: center; font-size: 14px;">Jam Pulang</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-size: 14px; text-align: center;">Senin - Kamis</td>
                                    <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($jke['wfo_masuk'])?></td>
                                    <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($jke['wfo_pulang'])?></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px; text-align: center;">Jumat</td>
                                    <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($jke['wfoj_masuk'])?></td>
                                    <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($jke['wfoj_pulang'])?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } } ?>
                    <?php if(isset($info_libur)){ ?>
                        <div class="row" style="width: 100%;">
                            <div class="col-lg-12">
                                <span style="font-weight: bold;">HARI LIBUR</span>
                            </div>
                            <?php $i = 0; foreach($info_libur as $il){ ?>
                                <div style="line-height: 1rem;" class="mb-2 mt-2 col-lg-6 <?=fmod($i, 2) == 0 ? 'text-right' : 'text-left';?>">
                                    <span class="nm_hrl"><?=$il['keterangan']?></span><br>
                                    <?php
                                        $tgl_libur = formatDateNamaBulan($il['tanggal_awal']);
                                        if($il['tanggal_awal'] != $il['tanggal_akhir']){
                                            $explode_awal = explode("-", $il['tanggal_awal']);
                                            $explode_akhir = explode("-", $il['tanggal_akhir']);
                                            $tgl_libur = $explode_awal[2].' - '.$explode_akhir[2].' '.getNamaBulan($explode_akhir[1]).' '.$explode_akhir[0];
                                        }
                                    ?>
                                    <span class="tgl_hrl"><?=$tgl_libur?></span>
                                </div>
                            <?php $i++; } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
                </center>
               
    <?php if(isset($flag_print) && $flag_print == 0 && isset($flag_rekap_aars)){ ?>
        <br /><br /><br>
    <?php } if(isset($flag_print) && $flag_print == 0){ ?>
        <input type="text" class="cd-search table-filter" data-table="rekap-table" placeholder="Cari Pegawai" />
    <?php } ?>
    <div class="div_maintb">
    <table class="rekap-table table" style="border-collapse: collapse;" border="1" id="table_rekap_absenx">
        <thead>
            <tr> 
                    <?php $i=0; 
                        $list_dk = null;
                        if($disiplin_kerja){
                            foreach($disiplin_kerja as $dk){
                                // if($dk['keterangan'] && $dk['keterangan'] == 'TK'){
                                    $list_dk[] = $dk['keterangan'];
                                // }
                            }
                        }
                        if(isset($flag_rekap_aars)){
                        ?>
                            <th style="text-align: center; ">No</th>
                            <th style="text-align: center; ">Nama</th>
                            <th style="text-align: center; ">NIP</th>
                        <?php
                            foreach($list_hari as $lh){
                                $tanggal = explode("-", $lh);
                                $val = getNamaHari($lh).'<br>'.$tanggal[2];
                        ?>
                            <th style="text-align: center; "><?= $val?></th>
                        <?php
                            }
                        } else {
                            foreach($header[0] as $h){
                                $val = $h;
                                $rowspan = 1;
                                if($i !=0 || $i != 1){
                                    $val = $val.'<br>'.$header[1][$i];
                                }
                                if(strlen($val) >= 5){
                            ?>  
                            <th style="text-align: center; "><?= $val?></th>
                            <?php $i++; } }?>
                        <?php } ?>
                        <th style="text-align: center; ">JHK</th>
                        <th style="text-align: center; ">Hadir</th>
                        <th style="text-align: center; ">Anulir</th>
                        <!-- <th style="text-align: center; ">Alpa</th> -->
                        <th style="text-align: center; ">TMK 1</th>
                        <th style="text-align: center; ">TMK 2</th>
                        <th style="text-align: center; ">TMK 3</th>
                        <th style="text-align: center; ">PKSW 1</th>
                        <th style="text-align: center; ">PKSW 2</th>
                        <th style="text-align: center; ">PKSW 3</th>
                        <?php
                            if($list_dk){
                                foreach($list_dk as $ldk){
                        ?>
                            <th style="text-align: center; "><?=$ldk?></th>
                        <?php } } ?>
		</tr> 
            </thead>
            <tbody>
            <?php
                $data_foreach = $result;
                if(isset($flag_rekap_aars)){
                    $data_foreach = $result['result'];
                    // dd(json_encode($data_foreach));
                };
                $no = 1; foreach($data_foreach as $rs){
                        if(isset($rs['absen'])){
                          $bgtr = fmod($no, 2) == 0 ? "tr_even" : "tr_odd";
                          ?>
                              <tr class="<?=$bgtr?>">
                                  <td style="text-align: center; "><?=$no++;?></td>
                                  <td scope="row" style=" text-align: left;"><a><?=$rs['nama_pegawai']?></a></td>
                                  <td style=""><a><?=isset($flag_print) && $flag_print == 1 ? '`' : '';?><?=$rs['nip']?></a></td>
                                  <?php
                                  foreach($rs['absen'] as $a){
                                      $bgcolor = '';
                                      $textcolor = 'black';
                                      $txtcolormasuk = 'black';
                                      $txtcolorpulang = 'black';
                                      $txtcolordisker = '#05ada5';
  
                                      if($a['ket'] == "TK"){
                                          // $bgcolor = 'a3f0ec';
                                          $textcolor = '#05ada5';
                                      } else if(in_array($a['ket'], $list_dk)){
                                          // $bgcolor = 'a3f0ec';
                                          $txtcolordisker = '#05ada5';
                                      } else if($a['ket_masuk'] == 'tmk1'){
                                          $txtcolormasuk = '#d3b700';
                                      } else if($a['ket_masuk'] == 'tmk2'){
                                          $txtcolormasuk = '#d37c00';
                                      } else if($a['ket_masuk'] == 'tmk3'){
                                          $txtcolormasuk = '#ff0000';
                                      } else if($a['jam_masuk'] == 'TLP'){
                                        $txtcolormasuk = '#05ada5';
                                      } else if($a['jam_masuk'] == 'Anulir'){
                                        $txtcolormasuk = '#bb01c7';
                                      } 

                                      if($a['ket_pulang'] == 'pksw1'){
                                          $txtcolorpulang = '#d3b700';
                                      } else if($a['ket_pulang'] == 'pksw2'){
                                          $txtcolorpulang = '#d37c00';
                                      } else if($a['ket_pulang'] == 'pksw3'){
                                          $txtcolorpulang = '#ff0000';
                                      } else if($a['jam_pulang'] == 'TLS'){
                                        $txtcolorpulang = '#05ada5';
                                      } else if($a['jam_pulang'] == 'Anulir'){
                                        $txtcolorpulang = '#bb01c7';
                                      } 
                                  ?>
                                  <td style="text-align: center; padding: 0;" class="content_table" bgcolor="<?=$bgcolor?>">
                                      <?php if(isset($flag_rekap_aars) && isset($hari_libur[$a['tanggal']])){ ?>
                                        <span style="color: black;">-</span>
                                      <?php } else if($a['ket'] == "TK"){ ?>
                                          <span style="color: <?=$textcolor?>;"><?=$a['ket']?></span>
                                      <?php } else if(in_array($a['ket'], $list_dk)){ ?>
                                          <span style="color: <?=$txtcolordisker?>;"><?=$a['ket']?></span>
                                      <?php } else { ?>
                                          <span style="color: <?=$txtcolormasuk?>"><?=$a['jam_masuk']?></span>
                                          <?php if(isset($flag_print) && $flag_print == 1 && isset($flag_pdf) && $flag_pdf == 1) { ?>
                                            <br>-<br>
                                          <?php } else { ?>
                                            -
                                          <?php } ?>
                                          <span style="color: <?=$txtcolorpulang?>"><?=$a['jam_pulang']?></span>
                                      <?php } ?>
                                      <?php if($a['status_absensi'] == 4 || $a['status_absensi'] == 5 || $a['status_absensi'] == 6){ ?>
                                        <br>
                                        <span style="
                                            font-size: 8px;
                                            color: #bb01c7;
                                            font-weight: bold;
                                        "
                                        class="txt_keterangan_anulir">(<?=$a['ket_status_absensi']?>)</span>
                                      <?php } ?>
                                  </td>
                                  <?php } ?>
                                  <td style=" text-align: center; font-weight: bold;"><?=$rs['rekap']['jhk']?></td>
                                  <td style=" text-align: center; font-weight: bold;"><?=$rs['rekap']['hadir']?></td>
                                  <td style=" text-align: center; font-weight: bold; color: <?=$rs['jumlah_anulir'] > 0 ? '#bb01c7;' : '#aaaeb3;'?>"><?=$rs['jumlah_anulir']?></td>
                                  <!-- <td style=" text-align: center; color: <?= $rs['rekap']['alpa'] > 0 ? 'red;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['alpa']?></td> -->
                                  <td style=" text-align: center; color: <?= $rs['rekap']['tmk1'] > 0 ? '#d3b700;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['tmk1']?></td>
                                  <td style=" text-align: center; color: <?= $rs['rekap']['tmk2'] > 0 ? '#d37c00;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['tmk2']?></td>
                                  <td style=" text-align: center; color: <?= $rs['rekap']['tmk3'] > 0 ? '#ff0000;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['tmk3']?></td>
                                  <td style=" text-align: center; color: <?= $rs['rekap']['pksw1'] > 0 ? '#d3b700;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['pksw1']?></td>
                                  <td style=" text-align: center; color: <?= $rs['rekap']['pksw2'] > 0 ? '#d37c00;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['pksw2']?></td>
                                  <td style=" text-align: center; color: <?= $rs['rekap']['pksw3'] > 0 ? '#ff0000;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['pksw3']?></td>
                                  <?php foreach($list_dk as $l){ ?>
                                      <td style=" text-align: center; color: <?= $rs['rekap'][$l] > 0 ? $txtcolordisker.';' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap'][$l]?></td>
                                  <?php } ?>
                              </tr>
                          <?php } } ?>
            
            </tbody>
        </table>
    </div>

                <!-- tutup tes  -->
               
                
                <br>
                <center>
                <span style="font-size: 12px;">printed by: </span><span style="font-size: 12px; font-weight: bold;"><?=$this->general_library->getNamaUser()?></span>
                <br>
                <span style="font-size: 12px;">date: </span><span style="font-size: 12px; font-weight: bold;"><?=date('d/m/Y H:i:s')?></span>
                                  </center>
        </body>
    </html>
<?php } else { ?>
    <div class="row">
        <div class="col-lg-12 text-center">Data Tidak Ditemukan <i class="fa fa-exclamation"></i></div>
    </div>
<?php } ?>
<script>
   $(function(){
    fixedHeaderTable()
    })

    $('#table_rekap_absen').DataTable({
    "ordering": false
     });
    
</script>