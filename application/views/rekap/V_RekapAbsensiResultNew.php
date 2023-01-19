<?php if(isset($skpd)){ ?>
    <html>
        <head>
            <style>
   
                .content{
                     font-size: 13px;
                     text-align: center;
                        }
                .fixTableHead { 
                /* width: 6000px;  */
                overflow-y: auto; 
                height: 500px; 
                } 
                .fixTableHead thead th { 
                position: sticky; 
                top: 0; 
                } 
                table { 
                /* border-collapse: collapse;		  */
                width: 100%; 
                } 
                th, 
                td { 
                padding: 8px 15px; 
                border: 1px solid #000; 
                } 
                th { 
                background: #dc3545; 
                width: 500px;
                border-top: 5px;
                } 

                

table {
    width: 6000px;
  margin: 1em 0;
  border-collapse: collapse;
  border: 0.1em solid #d6d6d6;
}

caption {
  text-align: left;
  font-style: italic;
  padding: 0.25em 0.5em 0.5em 0.5em;
}

th,
td {
  padding: 0.25em 0.5em 0.25em 1em;
  vertical-align: text-top;
  text-align: left;
  text-indent: -0.5em;
}

/* th {
  vertical-align: bottom;
  background-color: #666;
  color: #fff;
} */

tr:nth-child(even) th[scope=row] {
  background-color: #f2f2f2;
}

tr:nth-child(odd) th[scope=row] {
  background-color: #fff;
}

tr:nth-child(even) {
  background-color: rgba(0, 0, 0, 0.05);
}

tr:nth-child(odd) {
  background-color: rgba(255, 255, 255, 0.05);
}

td:nth-of-type(2) {
  font-style: italic;
}

th:nth-of-type(3),
td:nth-of-type(3) {
  text-align: right;
}

/* Fixed Headers */

th {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
  z-index: 2;
}

th[scope=row] {
  position: -webkit-sticky;
  position: sticky;
  left: 0;
  z-index: 1;
}

th[scope=row] {
  vertical-align: top;
  color: inherit;
  background-color: inherit;
  background: linear-gradient(90deg, transparent 0%, transparent calc(100% - .05em), #d6d6d6 calc(100% - .05em), #d6d6d6 100%);
}

table:nth-of-type(2) th:not([scope=row]):first-child {
  left: 0;
  z-index: 3;
  background: linear-gradient(90deg, #666 0%, #666 calc(100% - .05em), #ccc calc(100% - .05em), #ccc 100%);
}

/* Strictly for making the scrolling happen. */

th[scope=row] + td {
  min-width: 24em;
}

th[scope=row] {
  min-width: 20em;
}



</style> 
        <head>
        <?php
            if(isset($flag_print) && $flag_print == 1){
                $filename = $nama_file;
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=\"$filename\""); 
            }
        ?>
        <body>
                <center>
                <h5 style="font-size: 20px;">
                    REKAP ABSENSI <?=strtoupper($skpd)?><br>
                    <?=strtoupper($periode)?>
                </h5>
                <?php if(isset($flag_print) && $flag_print == 0){ ?>
                    <form target="blank" action="<?=base_url('rekap/C_Rekap/downloadAbsensiNew')?>">
                        <button class="btn btn-sm btn-navy" type="submit"><i class="fa fa-download"></i> Download as Excel</button>
                    </form>
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
                                <td style="text-align: center; font-size: 14px;"><?=$jam_kerja['wfo_masuk']?></td>
                                <td style="text-align: center; font-size: 14px;"><?=$jam_kerja['wfo_pulang']?></td>
                            </tr>
                            <tr>
                                <td style="font-size: 14px; text-align: center;">Jumat</td>
                                <td style="text-align: center; font-size: 14px;"><?=$jam_kerja['wfoj_masuk']?></td>
                                <td style="text-align: center; font-size: 14px;"><?=$jam_kerja['wfoj_pulang']?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>
                </center>
                <div >
              



<div class="fixTableHead"> 
<table>
  <thead>
  <tr> 
        <thead>
                        <?php $i=0; 
                        $list_dk = null;
                        if($disiplin_kerja){
                            foreach($disiplin_kerja as $dk){
                                if($dk['keterangan']){
                                    $list_dk[] = $dk['keterangan'];
                                }
                            }
                        }
                        foreach($header[0] as $h){
                            $val = $h;
                            $rowspan = 1;
                            if($i !=0 || $i != 1){
                                $val = $val.'<br>'.$header[1][$i];
                            }
                            if(strlen($val) >= 5){
                        ?>  
                            <th style="text-align: center; font-size: 13px;"><?=$val?></th>
                        <?php $i++; } }?>
                        <th style="text-align: center; font-size: 13px;">JHK</th>
                        <th style="text-align: center; font-size: 13px;">Hadir</th>
                        <!-- <th style="text-align: center; font-size: 13px;">Alpa</th> -->
                        <th style="text-align: center; font-size: 13px;">TMK 1</th>
                        <th style="text-align: center; font-size: 13px;">TMK 2</th>
                        <th style="text-align: center; font-size: 13px;">TMK 3</th>
                        <th style="text-align: center; font-size: 13px;">PKSW 1</th>
                        <th style="text-align: center; font-size: 13px;">PKSW 2</th>
                        <th style="text-align: center; font-size: 13px;">PKSW 3</th>
                        <?php
                            if($list_dk){
                                foreach($list_dk as $ldk){
                        ?>
                            <th style="text-align: center; font-size: 13px;"><?=$ldk?></th>
                        <?php } } ?>
		</tr> 
  </thead>
  <tbody>
  <?php  $no = 1; foreach($result as $rs){
                          
                          if(isset($rs['absen'])){
                          $bgtr = fmod($no, 2) == 0 ? "tr_even" : "tr_odd";
                          ?>
                              <tr class="<?=$bgtr?>">
                                  <td  style="text-align: center; font-size: 13px;"><?=$no++;?></td>
                                  <th scope="row"  style="width: 300px; font-size: 13px; text-align: left;"><a><?=$rs['nama_pegawai']?></a></th>
                                  <td style="font-size: 13px;"><a><?=isset($flag_print) && $flag_print == 1 ? '`' : '';?><?=$rs['nip']?></a></td>
                                  <?php
                                  foreach($rs['absen'] as $a){
                                      $bgcolor = '';
                                      $textcolor = 'black';
                                      $txtcolormasuk = 'black';
                                      $txtcolorpulang = 'black';
                                      $txtcolordisker = '#05ada5';
  
                                      if($a['ket'] == "A"){
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
                                      }
  
                                      if($a['ket_pulang'] == 'pksw1'){
                                          $txtcolorpulang = '#d3b700';
                                      } else if($a['ket_pulang'] == 'pksw2'){
                                          $txtcolorpulang = '#d37c00';
                                      } else if($a['ket_pulang'] == 'pksw3'){
                                          $txtcolorpulang = '#ff0000';
                                      }
                                  ?>
                                  <td class="content" bgcolor="<?=$bgcolor?>">
                                      <?php if($a['ket'] == "A"){ ?>
                                          <span style="color: <?=$textcolor?>;"><?=$a['ket']?></span>
                                      <?php } else if(in_array($a['ket'], $list_dk)){ ?>
                                          <span style="color: <?=$txtcolordisker?>;"><?=$a['ket']?></span>
                                      <?php } else { ?>
                                          <span style="color: <?=$txtcolormasuk?>"><?=$a['jam_masuk']?></span> - <span style="color: <?=$txtcolorpulang?>"><?=$a['jam_pulang']?></span>
                                      <?php } ?>
                                  </td>
                                  <?php } ?>
                                  <td style="font-size: 13px; text-align: center; font-weight: bold;"><?=$rs['rekap']['jhk']?></td>
                                  <td style="font-size: 13px; text-align: center; font-weight: bold;"><?=$rs['rekap']['hadir']?></td>
                                  <!-- <td style="font-size: 13px; text-align: center; color: <?= $rs['rekap']['alpa'] > 0 ? 'red;' : '#efefef;' ?> font-weight: bold;"><?=$rs['rekap']['alpa']?></td> -->
                                  <td style="font-size: 13px; text-align: center; color: <?= $rs['rekap']['tmk1'] > 0 ? '#d3b700;' : '#efefef;' ?> font-weight: bold;"><?=$rs['rekap']['tmk1']?></td>
                                  <td style="font-size: 13px; text-align: center; color: <?= $rs['rekap']['tmk2'] > 0 ? '#d37c00;' : '#efefef;' ?> font-weight: bold;"><?=$rs['rekap']['tmk2']?></td>
                                  <td style="font-size: 13px; text-align: center; color: <?= $rs['rekap']['tmk3'] > 0 ? '#ff0000;' : '#efefef;' ?> font-weight: bold;"><?=$rs['rekap']['tmk3']?></td>
                                  <td style="font-size: 13px; text-align: center; color: <?= $rs['rekap']['pksw1'] > 0 ? '#d3b700;' : '#efefef;' ?> font-weight: bold;"><?=$rs['rekap']['pksw1']?></td>
                                  <td style="font-size: 13px; text-align: center; color: <?= $rs['rekap']['pksw2'] > 0 ? '#d37c00;' : '#efefef;' ?> font-weight: bold;"><?=$rs['rekap']['pksw2']?></td>
                                  <td style="font-size: 13px; text-align: center; color: <?= $rs['rekap']['pksw3'] > 0 ? '#ff0000;' : '#efefef;' ?> font-weight: bold;"><?=$rs['rekap']['pksw3']?></td>
                                  <?php foreach($list_dk as $l){ ?>
                                      <td style="font-size: 13px; text-align: center; color: <?= $rs['rekap'][$l] > 0 ? $txtcolordisker.';' : '#efefef;' ?> font-weight: bold;"><?=$rs['rekap'][$l]?></td>
                                  <?php } ?>
                              </tr>
                          <?php } } ?>
  </tbody>
</table>


                                </div>
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