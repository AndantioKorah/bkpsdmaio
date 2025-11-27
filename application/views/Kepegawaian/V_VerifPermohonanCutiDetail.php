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
      <div class="col-lg-8 text-left mb-3">
        <table>
          <?php foreach($progress as $p){ ?>
            <tr valign="top">
              <td>
                <span style="
                  background-color: <?=$p['bg-color']?>;
                  padding: 5px;
                  border-radius: 1000px;
                  font-weight: bold;
                  margin-bottom: 5px;
                  font-size: .8rem;
                  color: <?=$p['font-color']?>
                "><i class="fa <?=$p['icon']?>"></i></span>
              </td>
              <td>
                <span style="font-size: .85rem; color: black; font-weight: bold;"><?=$p['keterangan']?></span><br>
                  <span style="
                    margin-top: 5px;
                    padding: 2px;
                    border-radius: 5px;
                    font-weight: bold;
                    margin-bottom: 5px;
                    font-size: .75rem;
                    color: #0092a4;
                  "> <?=$p['date_sent'] ? '<i class="fa fa-paper-plane"></i> '.formatDateNamaBulanWT($p['date_sent']) : 'pesan belum terkirim'?>
                </span>
              </td>
            </tr> 
          <?php } ?>
        </table>
        <br>
      </div>
      <div class="col-lg-4 text-right">
        <?php if($this->general_library->isProgrammer() && $p['flag_verif'] == 0){ ?>
          <button class="btn btn-sm btn-info" type="button" data-toggle="modal" href="#modal_detail_status"
            onclick="openModalDetailStatus('<?=$result['id']?>')">
              <i class="fa fa-edit"></i> DETAIL STATUS
          </button>

          <!-- <button id="btn_resend_<?=$p['id']?>" class="btn btn-sm btn-danger" type="button" onclick="resendMessage('<?=$p['id']?>','<?=$p['handphone']?>')">
            <i class="fa fa-bell"></i> Resend
          </button>
          <button style="display: none;" disabled id="btn_resend_loading_<?=$p['id']?>" class="btn btn-sm btn-danger" type="button">
            <i class="fa fa-bell"></i> Loading...
          </button> -->
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
          <div class="col-lg-4 col-md-4 col-sm-4">
            <span>Alasan</span>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-1 text-center">
            <span>:</span>
          </div>
          <div class="col-lg-7 col-md-7 col-sm-7">
            <span class="lbl_value_detail_cuti"><?=$result['alasan']?></span>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <span>Alamat</span>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-1 text-center">
            <span>:</span>
          </div>
          <div class="col-lg-7 col-md-7 col-sm-7">
            <span class="lbl_value_detail_cuti"><?=$result['alamat']?></span>
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

      <!-- <div class="row mt-2">
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
      </div> -->

      <div class="row mt-2">
        <hr>
        <div class="col-lg-12">
          <form id="form_verifikasi">
            <div class="row">
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
            </div>
            <div class="col-lg-12 mt-2 text-right">
              <div class="row">
                <div class="col-lg-12 text-right">
                    <?php if($result['id_m_user_verifikasi'] == $this->general_library->getId() || $this->general_library->isProgrammer()){ ?>
                      <button id="button_submit" type="submit" class="btn btn-navy"><i class="fa fa-save"></i> Simpan Verifikasi </button>
                      <button style="display: none;" id="button_submit_loader" disabled class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Menyimpan... </button>
                      <!-- <button id="btn_batal_verif" onclick="batalVerifikasi()" type="button" class="btn btn-danger"><i class="fa fa-times"></i> Batal Verifikasi </button>
                      <button style="display: none;" id="btn_batal_verif_loading" type="button" disabled class="btn btn-danger"><i class="fa fa-spin fa-spinner"></i> Menyimpan... </button> -->
                    <?php } else { ?>
                      <h5 style="color: red; font-style: italic;">Anda tidak dapat melakukan verifikasi di tahap ini</h5>
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

<div class="modal fade" id="modal_detail_status" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">STATUS PERMOHONAN CUTI</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="modal_detail_status_content">
          </div>
      </div>
  </div>
</div>

<script>
  $(function(){
    $('#id_verif_pengajuan').select2()
  })

  function backButton(){
    $('#form_search').submit()
  }

  function openModalDetailStatus(id){
    $('#modal_detail_status_content').html('')  
    $('#modal_detail_status_content').append(divLoaderNavy)  
    $('#modal_detail_status_content').load('<?=base_url("kepegawaian/C_Kepegawaian/loadDetailStatusPengajuanCuti/")?>'+id, function(){
      $('#loader').hide()
    })  
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
    // $('#button_submit').show()
    // $('#button_submit_loader').hide()
  })
</script>