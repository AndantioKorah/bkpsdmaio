<style>
  .lbl_value_detail_cuti{
    font-weight: bold;
    font-size: .9rem;
    color: black;
  }
</style>
<div class="modal-header">
    <button onclick="backButton()" class="btn btn-navy"><i class="fa fa-chevron-left"></i> Kembali</button>
    <h5 class="modal-title">DETAIL VERIFIKASI CUTI</h5>
    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button> -->
</div>
<div class="modal-body">
  <div class="row">
    <?php if($result){ ?>
      <div class="col-lg-12 text-left mb-3">
        <?php foreach($result['progress'] as $p){ ?>
          <span style="
            background-color: <?=$p['color']?>;
            padding: 2px;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: .9rem;
            color: <?=$p['font-color']?>
          "><i class="<?=$p['icon']?>"></i> <?=$p['keterangan']?></span><br>
        <?php } ?>
      </div>
      <div class="col-lg-6">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4">
            <span>Nama Pegawai</span>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-1 text-center">
            <span>:</span>
          </div>
          <div class="col-lg-7 col-md-7 col-sm-7">
            <span class="lbl_value_detail_cuti"><?=getNamaPegawaiFull($result)?></span>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <span>NIP</span>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-1 text-center">
            <span>:</span>
          </div>
          <div class="col-lg-7 col-md-7 col-sm-7">
            <span class="lbl_value_detail_cuti"><?=$result['nipbaru_ws']?></span>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <span>Jabatan</span>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-1 text-center">
            <span>:</span>
          </div>
          <div class="col-lg-7 col-md-7 col-sm-7">
            <span class="lbl_value_detail_cuti"><?=$result['nama_jabatan']?></span>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <span>Pangkat</span>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-1 text-center">
            <span>:</span>
          </div>
          <div class="col-lg-7 col-md-7 col-sm-7">
            <span class="lbl_value_detail_cuti"><?=$result['nm_pangkat']?></span>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4">
            <span>Jenis Cuti</span>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-1 text-center">
            <span>:</span>
          </div>
          <div class="col-lg-7 col-md-7 col-sm-7">
            <span class="lbl_value_detail_cuti"><?=$result['nm_cuti']?></span>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <span>Tanggal Pengajuan</span>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-1 text-center">
            <span>:</span>
          </div>
          <div class="col-lg-7 col-md-7 col-sm-7">
            <span class="lbl_value_detail_cuti"><?=formatDateNamaBulanWT($result['created_date'])?></span>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <span>Lama Cuti</span>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-1 text-center">
            <span>:</span>
          </div>
          <div class="col-lg-7 col-md-7 col-sm-7">
            <span class="lbl_value_detail_cuti"><?=($result['lama_cuti']).' hari'?></span>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <span>Tanggal Cuti</span>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-1 text-center">
            <span>:</span>
          </div>
          <div class="col-lg-7 col-md-7 col-sm-7">
            <?php 
              $tanggal_cuti = formatDateNamaBulan($result['tanggal_mulai']).' - '.formatDateNamaBulan($result['tanggal_akhir']);
              if($result['lama_cuti'] == 1){
                $tanggal_cuti = formatDateNamaBulan($result['tanggal_mulai']);
              }
            ?>
            <span class="lbl_value_detail_cuti"><?=$tanggal_cuti?></span>
          </div>
          <?php if($result['id_cuti'] == "00"){ ?>
            <div class="col-lg-12 mt-2">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <span>Keterangan Cuti</span>
                </div>
                <?php foreach($result['detail'] as $d){ ?>
                  <div class="col">
                    <div class="row">
                      <div class="col-lg-12 text-center">
                        <span><?=$d['tahun']?></span>
                      </div>
                      <div class="col-lg-12 text-center">
                        <span class="lbl_value_detail_cuti"><?=$d['jumlah']?></span>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } else if($result['id_cuti'] != "00" && $result['id_cuti'] != "10"){ ?>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <span>Surat Pendukung</span>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 text-center">
              <span>:</span>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7">
              <a href="<?=base_url('assets/dokumen_pendukung_cuti/'.$result['surat_pendukung'])?>" target="_blank" class="">
                Lihat Surat Pendukung <i class="fas fa-external-link-alt"></i>
              </a>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="row mt-2">
        <hr>
        <h5>REKAP ABSENSI 3 (TIGA) BULAN TERAKHIR</h5>
        <div class="col-lg-12">
          <div class="row">
            <?php
              $list_bulan_tahun = getBulanTahunTerakhir(date('Y-m-d'), 3);
              foreach($list_bulan_tahun as $l){
                $rekap['data_absen'][$l['bulan'].'-'.$l['tahun']]['bulan'] = $l['bulan'];
                $rekap['data_absen'][$l['bulan'].'-'.$l['tahun']]['tahun'] = $l['tahun'];
                $rekap['data_absen'][$l['bulan'].'-'.$l['tahun']]['data'] = $this->general_library->getAbsensiPegawai($result['id_m_user'], $l['bulan'], $l['tahun']);
              }
              $rekap['list_disiplin_kerja'] = $list_disiplin_kerja;
              $rekap['data_rekap'] = $result;
              $this->load->view('kepegawaian/V_RekapAbsensiVerifPermohonanCuti', $rekap);
            ?>
          </div>
        </div>
      </div>
      <div class="row mt-2">
        <hr>
        <div class="col-lg-12">
          <form id="form_verifikasi">
            <div class="row">
              <?php if(($this->general_library->isKepalaPd() && $result['id_m_status_pengajuan_cuti'] == 1 && !$this->general_library->isKepalaBkpsdm()) || 
              ($result['id_m_status_pengajuan_cuti'] == 2 && $this->general_library->isKepalaBkpsdm()) || 
              ($result['id_m_status_pengajuan_cuti'] == 1 && $this->general_library->isKepalaBkpsdm() && $this->general_library->getIdUnitKerjaPegawai() == $result['id_unitkerja'])){ ?>
                <div class="col-lg-3 col-md-3 col-sm-3">
                  <label>VERIFIKASI</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1">
                  <label>:</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8">
                  <select class="form-control select2-navy" style="width: 100%"
                  id="id_verif_pengajuan" data-dropdown-css-class="select2-navy" name="id_verif_pengajuan">
                      <option value="1" selected>Terima</option>
                      <option value="0">Tolak</option>
                  </select>
                </div>
                <div class="mt-2 col-lg-3 col-md-3 col-sm-3">
                  <label>KETERANGAN</label>
                </div>
                <div class="mt-2 col-lg-1 col-md-1 col-sm-1">
                  <label>:</label>
                </div>
                <div class="mt-2 col-lg-8 col-md-8 col-sm-8">
                  <textarea rows=5 name="keterangan_verif" class="form-control"></textarea>
                </div>
              <?php } ?>
            </div>
            <div class="col-lg-12 mt-2 text-right">
              <div class="row">
                <div class="col-lg-6 text-left">
                  <?php if($result['id_m_status_pengajuan_cuti'] == 4 && !$result['url_sk']){ ?>
                    <button type="button" onclick="digitalSign()" id="button_ds" class="btn btn-success"><i class="fa fa-signature fa-2x"></i> Digital Sign </button>
                    <button style="display: none;" id="button_ds_loader" disabled class="btn btn-success"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu... </button>
                  <?php } ?>
                </div>
                <div class="col-lg-6 text-right">
                  <?php if(($this->general_library->isKepalaPd() && $result['id_m_status_pengajuan_cuti'] == 1 && !$this->general_library->isKepalaBkpsdm()) || 
                  ($result['id_m_status_pengajuan_cuti'] == 2 && $this->general_library->isKepalaBkpsdm()) ||
                  ($result['id_m_status_pengajuan_cuti'] == 1 && $this->general_library->isKepalaBkpsdm() && $this->general_library->getIdUnitKerjaPegawai() == $result['id_unitkerja'])){ ?> 
                    <button id="button_submit" type="submit" class="btn btn-navy"><i class="fa fa-save"></i> Simpan Verifikasi </button>
                    <button style="display: none;" id="button_submit_loader" disabled class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Menyimpan... </button>
                  <?php } else if(($this->general_library->isKepalaPd() && ($result['id_m_status_pengajuan_cuti'] == 2 || $result['id_m_status_pengajuan_cuti'] == 3) && !$this->general_library->isKepalaBkpsdm()) || 
                  ($result['id_m_status_pengajuan_cuti'] == 4 && $result['url_sk'] == null && $this->general_library->isKepalaBkpsdm())){ ?>
                    <button id="btn_batal_verif" onclick="batalVerifikasi()" type="button" class="btn btn-danger"><i class="fa fa-times"></i> Batal Verifikasi </button>
                    <button style="display: none;" id="btn_batal_verif_loading" type="button" disabled class="btn btn-danger"><i class="fa fa-spin fa-spinner"></i> Menyimpan... </button>
                  <?php } ?>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    <?php } else { ?>
      <div class="col-lg-12">
        <h5><i class="fa fa-exclamation"></i> Data Tidak Ditemukan</h5>
      </div>
    <?php } ?>
  </div>
</div>
<script>
  $(function(){
    $('#id_verif_pengajuan').select2()
  })

  function backButton(){
    $('#form_search').submit()
  }

  function digitalSign(){
    $('#button_ds').hide()
    $('#button_ds_loader').show()
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/dsCuti/")?>'+'<?=$result['id']?>',
      method:"POST",  
      data: $(this).serialize(),
      success: function(res){
        let rs = JSON.parse(res)
        if(rs.code == 1){
          errortoast(rs.message)
        } else {
          successtoast('DS Berhasil')
          loadDetailCutiVerif('<?=$result["id"]?>')
        }
        $('#button_ds').show()
        $('#button_ds_loader').hide()
      }, error: function(err){
        errortoast('Terjadi Kesalahan')
        $('#button_ds').show()
        $('#button_ds_loader').hide()
      }
    })
  }

  function batalVerifikasi(){
    $('#btn_batal_verif').hide()
    $('#btn_batal_verif_loading').show()
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/batalVerifikasiPermohonanCuti/")?>'+'<?=$result['id']?>',
      method:"POST",  
      data: $(this).serialize(),
      success: function(res){
        let rs = JSON.parse(res)
        if(rs.code == 1){
          errortoast(rs.message)
          $('#btn_batal_verif').show()
          $('#btn_batal_verif_loading').hide()
        } else {
          successtoast('Pembatalan Verifikasi Berhasil')
          loadDetailCutiVerif('<?=$result["id"]?>')
        }
      }, error: function(err){
        errortoast('Terjadi Kesalahan')
        $('#btn_batal_verif').show()
        $('#btn_batal_verif_loading').hide()
      }
    })
  }

  $('#form_verifikasi').on('submit', function(e){
    e.preventDefault()
    $('#button_submit').hide()
    $('#button_submit_loader').show()
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/saveVerifikasiPermohonanCuti/")?>'+$('#id_verif_pengajuan').val()+'/'+'<?=$result['id']?>',
      method:"POST",  
      data: $(this).serialize(),
      success: function(res){
        let rs = JSON.parse(res)
        if(rs.code == 1){
          errortoast(rs.message)
        } else {
          successtoast('Verifikasi Berhasil')
          loadDetailCutiVerif('<?=$result["id"]?>')
        }
        $('#button_submit').show()
        $('#button_submit_loader').hide()
      }, error: function(err){
        errortoast('Terjadi Kesalahan')
        $('#button_submit').show()
        $('#button_submit_loader').hide()
      }
    })
  })
</script>