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
      <ul class="nav nav-pills d-none d-md-flex" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="pills-company-tab" data-toggle="pill" href="#pills-company" role="tab" aria-controls="pills-company" aria-selected="true">Profil</a>
        </li>
        <li class="nav-item" role="presentation">
          <a onclick="loadListPangkat()" class="nav-link" id="" data-toggle="pill" href="#tab_pangkat" role="tab" aria-controls="pills-product" aria-selected="false">Pangkat</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pills-news-tab" data-toggle="pill" href="#pills-news" role="tab" aria-controls="pills-news" aria-selected="false">Pendidikan</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Jabatan</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Diklat</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Gaji Berkala</a>
        </li>

        

        
      </ul>
    </div>
    <hr>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-company" role="tabpanel" aria-labelledby="pills-company-tab">
        <div class="container-fluid">
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
                        echo formatDateNamaBulan(date($profil_pegawai['tmtpangkat'])); 
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
      </div>
      <div class="tab-pane fade" id="tab_pangkat" role="tabpanel" aria-labelledby="">
      asdsadsad
      </div>
      <div class="tab-pane fade" id="pills-news" role="tabpanel" aria-labelledby="pills-news-tab">
        <div class="container-fluid">
          <h2 class="mb-3 font-weight-bold">News</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce porttitor leo nec ligula viverra, quis facilisis nunc vehicula. Maecenas purus orci, efficitur in dapibus vel, rutrum in massa. Sed auctor urna sit amet eros mattis interdum. Integer imperdiet ante in quam lacinia, a laoreet risus imperdiet.</p>
          <p>Proin maximus iaculis rhoncus. Morbi ante nibh, facilisis semper faucibus consequat, facilisis ut ante. Mauris at nisl vitae justo auctor imperdiet. Cras sodales, justo sed tincidunt venenatis, ante erat ultricies eros, at mollis eros lorem ac mi. Fusce sagittis nibh nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec mollis eros sodales convallis faucibus. Vestibulum sit amet odio lectus. Duis eu dolor vitae est venenatis viverra eu sit amet nisl. Aenean vel sagittis odio. Quisque in lacus orci. Etiam ut odio lobortis odio consectetur ornare.</p>
        </div>
      </div>
      <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
        <div class="container-fluid">
          <h2 class="mb-3 font-weight-bold">Contact</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce porttitor leo nec ligula viverra, quis facilisis nunc vehicula. Maecenas purus orci, efficitur in dapibus vel, rutrum in massa. Sed auctor urna sit amet eros mattis interdum. Integer imperdiet ante in quam lacinia, a laoreet risus imperdiet.</p>
          <p>Proin maximus iaculis rhoncus. Morbi ante nibh, facilisis semper faucibus consequat, facilisis ut ante. Mauris at nisl vitae justo auctor imperdiet. Cras sodales, justo sed tincidunt venenatis, ante erat ultricies eros, at mollis eros lorem ac mi. Fusce sagittis nibh nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec mollis eros sodales convallis faucibus. Vestibulum sit amet odio lectus. Duis eu dolor vitae est venenatis viverra eu sit amet nisl. Aenean vel sagittis odio. Quisque in lacus orci. Etiam ut odio lobortis odio consectetur ornare.</p>
        </div>
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

<div class="modal fade" id="modal_view_file" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
    </div>
  </div>
</div>                      

<script>
  function loadListPangkat(){
    $('#tab_pangkat').html('')
    $('#tab_pangkat').append(divLoaderNavy)
    $('#tab_pangkat').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadListPangkat/")?>', function(){
      $('#loader').hide()
    })
  }
</script>
