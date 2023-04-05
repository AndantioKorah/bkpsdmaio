<?php if($result){ ?>
<div class="row">
  <div class="col-lg-12">
  <table width="100%" border="0">
          <p>
              <tr>
                <td width="152">Nama</td>
                <td width="13">:</td>
                <td width="806">
          <?= getNamaPegawaiFull($result) ?></td>
              </tr>
              <tr>
                <td>Tempat/Tgl Lahir </td>
                <td>:</td>
                <td><?= $result['tptlahir']?> / <?= formatDateNamaBulan($result['tgllahir'])?><td>
              </tr>
              <tr>
                <td>NIP</td>
                <td>:</td>
                <td><?= $result['nipbaru']?></td>
              </tr>
              <tr>
                <td>Jenis Kelamin </td>
                <td>:</td>
                <td><?= $result['jk']?></td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $result['alamat']?></td>
              </tr>
              <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?= $result['nm_agama']?></td>
              </tr>
              <tr>
                <td>Pendidikan</td>
                <td>:</td>
                <td><?= $result['nm_tktpendidikan']?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>

              </tr>
              <tr>
                <td>Pangkat / TMT </td>
                <td>:</td>
                <td><?php echo $result['nm_pangkat']?> /
                  <?php 
                        if ($result['tmtpangkat'] =='0000-00-00')
                        {
                        echo "-";
                        }
                        else
                        {
                        echo formatDateNamaBulan(date($result['tmtpangkat'])); 
                        }
                        ?></td>
              </tr>
              <tr>
                <td>TMT Gaji Berkala </td>
                <td>:</td>
                <td><?php 
                        if ($result['tmtgjberkala']=='0000-00-00')
                        {
                        
                          echo "-";
                        }
                        else
                        {
                        echo formatDateNamaBulan($result['tmtgjberkala']); 
                        }
                        ?></td>
              </tr>
              <tr>
                <td>Jabatan / TMT </td>
                <td>:</td>
                <td><?php echo $result['nama_jabatan']?> /
                  <?php 
                        if ($result['tmtjabatan']=='0000-00-00')
                        {
                        echo "-";
                        }
                        else
                        {
                        echo formatDateNamaBulan($result['tmtjabatan']); 
                        }
                        ?></td>
              </tr>
              <tr>
                <td>Unit Kerja </td>
                <td>:</td>
                <td><?php echo $result['nm_unitkerja']?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>NIK </td>
                <td>:</td>
                <td><?= $result['nik']?></td>
              </tr>
              <tr>
                <td>No HP </td>
                <td>:</td>
                <td><?= $result['handphone']?></td>
              </tr>
              <tr>
                <td>Email </td>
                <td>:</td>
                <td><?= $result['email'] ?></td>
              </tr>
          </p>
        </table>
  </div>
</div>


<script>
  function openFilePendidikan(filename){
    $('#iframe_view_file').attr('src', 'http://bkd.manadokota.go.id/simpegonline/adm/arsipelektronik/'+filename)
  }
</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>