<style>
  .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    background-color: var(--primary-color);
    color: white;
  }

  .nav-link{
    color: var(--primary-color);
  }
  
  .nav-link:hover{
    background-color: #e2e2e2;
    transition: .1s;
  }
</style>

<div class="card p-3">
  <div class="tabs-to-dropdown">
    <div class="nav-wrapper d-flex align-items-center justify-content-between">
      <ul class="nav nav-pills d-none d-md-flex" id="pills-tab" role="tablist" >
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="pills-company-tab" data-toggle="pill" href="#pills-profil" role="tab" aria-controls="pills-company" aria-selected="true">Profil</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pills-product-tab" data-toggle="pill" href="#pills-pangkat" role="tab" aria-controls="pills-product" aria-selected="false">Pangkat</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pills-news-tab" data-toggle="pill" href="#pills-pendidikan" role="tab" aria-controls="pills-news" aria-selected="false">Pendidikan</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-jabatan" role="tab" aria-controls="pills-contact" aria-selected="false">Jabatan</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-diklat" role="tab" aria-controls="pills-contact" aria-selected="false">Diklat</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-berkala" role="tab" aria-controls="pills-contact" aria-selected="false">Gaji Berkala</a>
        </li>
      </ul>

    </div>

    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-profil" role="tabpanel" aria-labelledby="pills-company-tab">
        <table width="100%" border="0">
          <p>
              <tr>
                <td width="152">Nama</td>
                <td width="13">:</td>
                <td width="806">
          <?= getNamaPegawaiFull($profil_pegawai) ?></td>
              </tr>
              <tr>
                <td>Tempat/Tgl Lahir </td>
                <td>:</td>
                <td><?= $profil_pegawai['tptlahir']?> / <?= formatDateNamaBulan($profil_pegawai['tgllahir'])?><td>
              </tr>
              <tr>
                <td>NIP</td>
                <td>:</td>
                <td><?= $profil_pegawai['nipbaru']?></td>
              </tr>
              <tr>
                <td>Jenis Kelamin </td>
                <td>:</td>
                <td><?= $profil_pegawai['jk']?></td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $profil_pegawai['alamat']?></td>
              </tr>
              <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?= $profil_pegawai['nm_agama']?></td>
              </tr>
              <tr>
                <td>Pendidikan</td>
                <td>:</td>
                <td><?= $profil_pegawai['nm_tktpendidikan']?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>

              </tr>
              <tr>
                <td>Pangkat / TMT </td>
                <td>:</td>
                <td><?php echo $profil_pegawai['nm_pangkat']?> /
                  <?php 
                        if ($profil_pegawai['tmtpangkat'] =='0000-00-00')
                        {
                        echo "-";
                        }
                        else
                        {
                        echo format_indo(date($profil_pegawai['tmtpangkat']->tmtpangkat)); 
                        }
                        ?></td>
              </tr>
              <tr>
                <td>TMT Gaji Berkala </td>
                <td>:</td>
                <td><?php 
                        if ($profil_pegawai['tmtgjberkala']=='0000-00-00')
                        {
                        
                          echo "-";
                        }
                        else
                        {
                        echo formatDateNamaBulan($profil_pegawai['tmtgjberkala']); 
                        }
                        ?></td>
              </tr>
              <tr>
                <td>Jabatan / TMT </td>
                <td>:</td>
                <td><?php echo $profil_pegawai['nama_jabatan']?> /
                  <?php 
                        if ($profil_pegawai['tmtjabatan']=='0000-00-00')
                        {
                        echo "-";
                        }
                        else
                        {
                        echo formatDateNamaBulan($profil_pegawai['tmtjabatan']); 
                        }
                        ?></td>
              </tr>
              <tr>
                <td>Unit Kerja </td>
                <td>:</td>
                <td><?php echo $profil_pegawai['nm_unitkerja']?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>NIK </td>
                <td>:</td>
                <td><?= $profil_pegawai['nik']?></td>
              </tr>
              <tr>
                <td>No HP </td>
                <td>:</td>
                <td><?= $profil_pegawai['handphone']?></td>
              </tr>
              <tr>
                <td>Email </td>
                <td>:</td>
                <td><?= $profil_pegawai['email'] ?></td>
              </tr>
          </p>
        </table>
      </div>
      <div class="tab-pane fade" id="pills-pangkat" role="tabpanel" aria-labelledby="pills-product-tab">
        <table class="table table-striped table-bordered" style="width:100%;" id="data_table">
                        <thead class="thead-dark">
                          <th width="20">No</th>
                          <th width="258">Pangkat</th>
                          <th width="185">TMT Pangkat </th>
                          <th width="205">Masa Kerja </th>
                          <th width="96">Nomor SK </th>
                          <th width="184">Tanggal SK </th>
                          <th width="60">File</th>
                        </thead>	
                        <tbody>
                        <?php $no = 1; foreach($pangkat as $rs) {?>
                        <tr>
                          <td align="center"><?=$no++;?></td>
                          <td><?=$rs['nm_pangkat'];?></td>
                          <td><?=$rs['tmtpangkat'];?></td>
                          <td><?=$rs['masakerjapangkat']; ?></td>
                          <td><?=$rs['nosk']; ?></td>
                          <td><?=$rs['tglsk']; ?></td> 
                        </tr>
                        <?php } ?>
                        </tbody>											
          </table>
      </div>
      <div class="tab-pane fade" id="pills-pendidikan" role="tabpanel" aria-labelledby="pills-news-tab">
      <table class="table table-striped table-bordered" style="width:100%;" id="data_table">
                        <thead class="thead-dark">
                          <th width="20">No</th>
                          <th width="258">Pendidikan</th>
                          <th width="185">Jurusan</th>
                          <th width="205">Fakultas</th>
                          <th width="96">Nama Sekolah</th>
                          <th width="184">Tahun Lulus</th>
                          <th width="60">Nomor /Tgl Ijazah</th>
                          <th width="60">File</th>
                        </thead>	
                        <tbody>
                        <?php $no = 1; foreach($pendidikan as $rs) {?>
                        <tr>
                          <td align="center"><?=$no++;?></td>
                          <td><?=$rs['nm_tktpendidikan'];?></td>
                          <td><?=$rs['jurusan'];?></td>
                          <td><?=$rs['fakultas']; ?></td>
                          <td><?=$rs['namasekolah']; ?></td>
                          <td><?=$rs['tahunlulus']; ?></td> 
                          <td><?=$rs['noijasah']; ?> / <?=$rs['tglijasah'];?></td> 
                          <td><?=$rs['gambarsk']; ?></td> 
                        </tr>
                        <?php } ?>
                        </tbody>											
      </table>
      </div>
      <!-- <div class="tab-pane fade" id="pills-jabatan" role="tabpanel" aria-labelledby="pills-news-tab">
      <table class="table table-striped table-bordered" style="width:100%;" id="data_table">
                        <thead class="thead-dark">
                          <th width="20">No</th>
                          <th width="258">Jabatan</th>
                          <th width="185">TMT Jabatan</th>
                          <th width="205">PD</th>
                          <th width="96">Nomor SK</th>
                          <th width="184">Tanggal SK</th>
                          <th width="60">File</th>
                        </thead>	
                        <tbody>
                        <?php $no = 1; foreach($jabatan as $rs) {?>
                        <tr>
                          <td align="center"><?=$no++;?></td>
                          <td><?=$rs['nm_jabatan'];?></td>
                          <td><?=$rs['jurusan'];?></td>
                          <td><?=$rs['fakultas']; ?></td>
                          <td><?=$rs['namasekolah']; ?></td>
                          <td><?=$rs['tahunlulus']; ?></td> 
                          <td><?=$rs['gambarsk']; ?></td> 
                        </tr>
                        <?php } ?>
                        </tbody>											
      </table>
      </div> -->
    </div>
  </div>
</div>