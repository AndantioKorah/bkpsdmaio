<?php if($result){ ?>
  <style>
    .td-lab-dd{
      font-size: .8rem;
      font-weight: 800;
      width: 25%;
    }

    .td-smc-dd{
      font-size: .7rem;
      font-weight: 800;
      width: 5%;
    }

    .td-val-dd{
      font-size: .9rem;
      font-weight: bold;
      width: 70%;
    }
  </style>
  <div class="modal-header pt-3 pl-3">
    <h3 class="modal-title">VERIFIKASI DOKUMEN <?=strtoupper($param['jenisdokumen']['nama'])?></h3>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-lg-6 text-left">
        <span style="color: grey; font-size .8rem; font-style: italic;">Nama</span><br>
        <span style="font-size: 1rem; font-weight: bold;"><?=getNamaPegawaiFull($result)?></span>
      </div>
      <div class="col-lg-6 text-right">
        <span style="color: grey; font-size .8rem; font-style: italic;">NIP</span><br>
        <span style="font-size: 1rem; font-weight: bold;"><?=formatNip($result['nipbaru_ws'])?></span>
      </div>
      <div class="col-lg-12"><hr></div>
    </div>
    <!-- HERE -->
    <?php if($param['jenisdokumen']['value'] == 'pangkat') { ?>
    <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Jenis</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_jenispengangkatan']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Pangkat/Gol.Ruang</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_pangkat']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">TMT Pangkat</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tmt_pangkat'])?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Pejabat</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['pejabat']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Masa Kerja</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['masakerjapangkat']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">No. SK</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nosk']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tgl. SK</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglsk'])?></td>
          </tr>
        </table>
      </div>
      <div class="col-lg-6">
        <!-- <span style="font-weight: bold;">GAMBAR SK</span> -->
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 60vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	
      </div>
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'gajiberkala') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Pangkat/Gol.Ruang</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_pangkat']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Masa Kerja</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['masakerja']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Pejabat</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['pejabat']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Pejabat Yang Menetapkan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['pejabat']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">No. SK</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nosk']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tgl. SK</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglsk'])?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">TMT Gaji Berkala</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['tmtgajiberkala']?></td>
          </tr>
        </table>
      </div>
      <div class="col-lg-6">
        <!-- <span style="font-weight: bold;">GAMBAR SK</span> -->
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 60vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	

      </div>
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'jabatan') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Unit Kerja</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['unit_kerja']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Jenis Jabatan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_jenisjab']?></td>
          </tr>
  
          <tr>
            <td class="td-lab-dd">Nama Jabatan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nama_jabatan']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Pejabat Yang Menetapkan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['pejabat']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Status Jabatan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_statusjabatan']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">TMT Jabatan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tmtjabatan'])?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Eselon</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_eselon']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">No SK</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nosk']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tanggal SK</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglsk'])?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Angka Kredit</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['angkakredit']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Keterangan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['ket']?></td>
          </tr>
        </table>
      </div>
      <div class="col-lg-6">
        <!-- <span style="font-weight: bold;">GAMBAR SK</span> -->
        <!-- <iframe style="height: 50vh; width: 100%;" src="<?=base_url('arsipjabatan/').$result['gambarsk']?>"></iframe> -->
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 60vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	
      </div>
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'diklat') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Jenis Diklat</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_jdiklat']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Nama Diklat</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_diklat']?></td>
          </tr>
  
          <tr>
            <td class="td-lab-dd">Tempat Diklat</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['tptdiklat']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Penyelenggara</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['penyelenggara']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Angkatan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['angkatan']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Jam</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['jam']?></td>
          </tr>
         
          <tr>
            <td class="td-lab-dd">Tanggal Mulai</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglmulai'])?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tanggal Selesai</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglselesai'])?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">No. STTPP</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nosttpp']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tanggal STTPP</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglsttpp'])?></td>
          </tr>
        </table>
      </div>
      <div class="col-lg-6">
        <!-- <span style="font-weight: bold;">GAMBAR SK</span> -->
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 60vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	
      </div>
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'organisasi') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Jenis Organisasi</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_organisasi']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Nama Organisasi</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nama_organisasi']?></td>
          </tr>
  
          <tr>
            <td class="td-lab-dd">Kedudukan / Jabatan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_jabatan_organisasi']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tanggal Mulai</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglmulai'])?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tanggal Berakhir</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglselesai'])?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Nama Pimpinan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['pemimpin']?></td>
          </tr>
         
          <tr>
            <td class="td-lab-dd">Tempat</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['tempat']?></td>
          </tr>
        
        </table>
        </div>
        <div class="col-lg-6">
        <!-- <span style="font-weight: bold;">GAMBAR SK</span> -->
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 60vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	
      </div>

    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'penghargaan') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Nama Penghargaan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_pegpenghargaan']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Nomo SK</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nosk']?></td>
          </tr>
  
          <tr>
            <td class="td-lab-dd">Tanggal SK</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglsk'])?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tahun</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['tahun_penghargaan']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Asal Perolehan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_pemberipenghargaan']?></td>
          </tr>
      
        </table>
        </div>
        <div class="col-lg-6">
        <span style="font-weight: bold;">GAMBAR SK</span>
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 60vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	
      </div>
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'sumpahjanji') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Sumpah / Janji</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_sumpah']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Yang Mengambil Sumpah</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['pejabat']?></td>
          </tr>
  
          <tr>
            <td class="td-lab-dd">Nomor Berita Acara</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['noba']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tanggal Berita Acara</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglba'])?></td>
          </tr>
          
      
        </table>
    </div>

    <div class="col-lg-6">
        <!-- <span style="font-weight: bold;">GAMBAR SK</span> -->
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 60vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	
      </div>

    
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'keluarga') { ?>
      <div class="row">
      <div class="col-lg-12">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Hubungan Keluarga</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_keluarga']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Nama </td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['namakel']?></td>
          </tr>
  
          <tr>
            <td class="td-lab-dd">Tempat Lahir</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['tempat_lahir']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tanggal lahir</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tanggal_lahir'])?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Pendidikan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['pendidikan_kel']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Pekerjaan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['pekerjaan']?></td>
          </tr>
      
        </table>
      </div>
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'penugasan') { ?>
      <div class="row">
      <div class="col-lg-12">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Jenis Penugasan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_jenistugas']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tempat/Negara Tujuan </td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['tujuan']?></td>
          </tr>
  
          <tr>
            <td class="td-lab-dd">Pejabat Yang Menetapkan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['pejabat']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Nomor SK</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nosk']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tanggal SK</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglsk'])?></td>
          </tr>
  
          <tr>
            <td class="td-lab-dd">Lamanya </td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['lamanya']?></td>
          </tr>
      
        </table>
      </div>
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'cuti') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Jenis Cuti</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_cuti']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tanggal Mulai</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglmulai'])?></td>
          </tr>
  
          <tr>
            <td class="td-lab-dd">Tanggal Selesai</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglselesai'])?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Nomor Surat Ijin</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nosttpp']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tanggal Surat Ijin</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglsttpp'])?></td>
          </tr>
      
        </table>
      </div>
      <div class="col-lg-6">
        <!-- <span style="font-weight: bold;">GAMBAR SK</span> -->
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 60vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	
      </div>
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'skp') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Tahun</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['tahun']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Predikat</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['predikat']?></td>
          </tr>
  
        </table>
      </div>
      <div class="col-lg-6">
        <!-- <span style="font-weight: bold;">GAMBAR SK</span> -->
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 60vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	
      </div>
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'assesment') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Nama Assesment</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_assesment']?></td>
          </tr>
   
        </table>
      </div>
      <div class="col-lg-6">
        <span style="font-weight: bold;">File Assesment</span>
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 60vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	
      </div>
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'arsip') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Nama Arsip</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['name']?></td>
          </tr>
   
        </table>
      </div>
      <div class="col-lg-6">
        <span style="font-weight: bold;">File</span>
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 60vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>
      </div>
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'berkaspns') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Jenis SK</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?php if($result['jenissk'] == 1) echo 'SK CPNS'; else echo 'SK PNS';?> </td>
          </tr>
   
        </table>
      </div>
      <div class="col-lg-6">
        <span style="font-weight: bold;">File </span>
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 60vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	
      </div>
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'pendidikan') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Tingkat Pendidikan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['nm_tktpendidikanb']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">Jurusan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['jurusan']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">Fakultas</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['fakultas']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">Nama Sekolah / Universitas</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['namasekolah']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">Nama Pimpinan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['pimpinansekolah']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">Tahun Lulus</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['tahunlulus']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">No. STTB/Ijazah</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['noijasah']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">Tgl. STTB/Ijazah</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['tglijasah']?> </td>
          </tr>
   
        </table>
      </div>
      <div class="col-lg-6">
        <span style="font-weight: bold;">File </span>
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 60vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	
      </div>
    </div>
     <?php } else if($param['jenisdokumen']['value'] == 'pendidikan') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Tingkat Pendidikan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['nm_tktpendidikanb']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">Jurusan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['jurusan']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">Fakultas</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['fakultas']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">Nama Sekolah / Universitas</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['namasekolah']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">Nama Pimpinan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['pimpinansekolah']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">Tahun Lulus</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['tahunlulus']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">No. STTB/Ijazah</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['noijasah']?> </td>
          </tr>

          <tr>
            <td class="td-lab-dd">Tgl. STTB/Ijazah</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= $result['tglijasah']?> </td>
          </tr>
   
        </table>
      </div>
      <div class="col-lg-6">
        <span style="font-weight: bold;">File </span>
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	
      </div>
    </div>
    <?php } else if($param['jenisdokumen']['value'] == 'timkerja') { ?>
      <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Nama Tim Kerja</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_timkerja']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Jabatan</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd">
            <?= ($result['jabatan_tim'] == '1') ? 'Ketua/Penanggung Jawab' : 'Anggota'; ?>
            </td>
          </tr>

          <tr>
            <td class="td-lab-dd">Ruang Lingkup</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_lingkup_timkerja']?></td>
          </tr>
  
        </table>
      </div>
      <div class="col-lg-6">
        <span style="font-weight: bold;">GAMBAR SK</span>
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  class="view_file_ws"  frameborder="0" ></iframe>	
      </div>
    </div>
      <?php } ?>
   <!-- END HERE  -->
    <div class="row">
      <!-- <div class="col-lg-12"><hr></div> -->
  <?php if ($result['status_dokumen'] == 1) { ?>
    
 <form method="post" id="form_verifikasi_dokumen" enctype="multipart/form-data" >
  <input type="hidden" name="jenis_dokumen" id="jenis_dokumen" value="<?= $param['jenisdokumen']['value'];?>">
  <input type="hidden" name="db_dokumen" id="db_dokumen" value="<?= $param['jenisdokumen']['db'];?>">
  <input type="hidden" value="<?=$result['id_pegawai']?>" name="id_pegawai" value="id_pegawai">

  <input type="hidden" value="<?=$result['id']?>" name="id" value="id">
  <div class="form-group">
    <label for="exampleInputEmail1">Verifikasi</label>
    <select onchange="showKeterangan()" class="form-select" aria-label="Default select example" name="verif" id="verif">
  <option selected></option>
  <option value="2">ACC</option>
  <option value="3">Tolak</option>
  </select>
  </div>
  <div class="form-group" style="display:none" id="field_ket">
    <label for="exampleFormControlTextarea1">Keterangan</label>
    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
  </div>
<br>
<button class="btn btn-block btn-primary float-right"><i class="fa fa-save"></i> SIMPAN</button>
</form>
<?php } ?>

<?php if ($result['status_dokumen'] != 1) { ?>
  <div class="row">
<div class="col-lg-6">
<span style="color: grey; font-size .8rem; font-style: italic;">Status Dokumen</span><br>
<span style="font-size: 1rem; font-weight: bold;">
<?php if ($result['status_dokumen'] == 2) echo "ACC"; else if($result['status_dokumen'] == 3) echo "Di Tolak :"; ?>
  <?php if ($result['status_dokumen'] == 3) echo $result['keterangan'];?>
</span>
</div>
<div class="col-lg-6">
<form method="post" id="form_batal_verifikasi_dokumen" enctype="multipart/form-data" >
 <input type="hidden" name="jenis_dokumen_batal" id="jenis_dokumen_batal" value="  <?= $param['jenisdokumen']['value'];?>">
  <input type="hidden" value="<?=$result['id']?>" name="id_batal" value="id_batal">
  <input type="hidden" name="db_dokumen_batal" id="db_dokumen_batal" value="  <?= $param['jenisdokumen']['db'];?>">
  <input type="hidden" value="<?=$result['id_pegawai']?>" name="id_pegawai_batal" value="id_pegawai_batal">
<button class="btn btn-block btn-danger float-right"  id=""> Batal Verifikasi</button>
</form>
</div>

  </div>

<?php } ?>
      <!-- KOLOM KETERANGAN DAN VERIF -->
    </div>
  </div>
  <script>
    $(function(){
      getDokumenWs()
    })

     function getDokumenWs(){
    $('.view_file_ws').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
   
    // $.ajax({
    //   url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
    //   method: 'POST',
    //   data: {
    //    'username': '<?=$this->general_library->getUserName()?>',
    //     'password': '<?=$this->general_library->getPassword()?>',
    //     'filename': '<?= $path?>'
    //   },
    //   success: function(data){
    //     let res = JSON.parse(data)

    //    console.log(data)
    //     if(res == null){
    //       $('iframe_loader').show()  
    //       $('.iframe_loader').html('Tidak ada file SK')
    //     }

    //     $('.view_file_ws').attr('src', res.data)
    //     $('.view_file_ws').on('load', function(){
    //       $('.iframe_loader').hide()
    //       $(this).show()
    //     })
    //   }, error: function(e){
    //     errortoast('Terjadi Kesalahan')
    //   }
    // })

    var number = Math.floor(Math.random() * 1000);
    var path = "<?= $path?>"
    $link = "http://siladen.manadokota.go.id/bidik/"+path+"?v="+number;


    $('.view_file_ws').attr('src', $link)
        $('.view_file_ws').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })
  }

    $('#form_verifikasi_dokumen').on('submit', function(e){ 
      
      e.preventDefault();
      var formvalue = $('#form_verifikasi_dokumen');
      var form_data = new FormData(formvalue[0]);
      
      var val = $('#verif').val()
      var ket = $('#keterangan').val()
      if (val == ""){
        errortoast("Silahkan Pilih Verifikasi")
        return false;
      } else if (val == 3){
        if(ket == ""){
        errortoast("Keterangan Belum di isi");
        return false;
        }
      }
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/submitVerifikasiDokumen")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        // dataType: "json",
        success:function(res){ 
          successtoast("Data berhasil disimpan")
          const myTimeout = setTimeout(closeModal, 5000);
            
        }  , error: function(e){
                    errortoast('Terjadi Kesalahan')
          }
        });
        return false;  
          
        });
        

      $('#form_batal_verifikasi_dokumen').on('submit', function(e){  
      e.preventDefault();
      
      var formvalue = $('#form_batal_verifikasi_dokumen');
      var form_data = new FormData(formvalue[0]);
    
      if(confirm('Apakah Anda yakin ingin batal verifikasi?')){
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/batalSubmitVerifikasiDokumen")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        // dataType: "json",
        success:function(res){ 
          successtoast("Batal verifikasi berhasil")
          // const myTimeout = setTimeout(closeModal, 5000);
          // $('#edit_data').modal('hide');
          closeModal()
         
            
        }  , error: function(e){
                    errortoast('Terjadi Kesalahan')
          }
        });
      }
          
        });


  function closeModal(){
    $('#edit_data').modal('hide');
  }

  function showKeterangan(){
    var val = $('#verif').val()
    if(val == 3){
      $('#field_ket').show('fast')
    } else {
      $('#field_ket').hide('fast') 
    }
   }
  </script>
<?php } else { ?>
  <div class="col-lg-12 text-center">
    <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
  </div>
<?php } ?>