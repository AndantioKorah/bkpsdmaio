<style>
  .lbl_field_modal_delete_cuti{
    font-size: .65rem;
    font-style: italic;
    font-weight: bold;
    color: grey;
  }

  .lbl_val_modal_delete_cuti{
font-size: 1.1rem;
    font-weight: bold;
    color: black;
  }
</style>

<div class="row">
  <div class="col-md-6 col-sm-6 col-lg-6">
    <div class="row">
      <div class="col-lg-12">
        <label class="lbl_field_modal_delete_cuti">
          Nama Pegawai
        </label><br>
        <span class="lbl_val_modal_delete_cuti"><?=getNamaPegawaiFull($result)?></span>
      </div>
      <div class="col-lg-12">
        <label class="lbl_field_modal_delete_cuti">
          NIP
        </label><br>
        <span class="lbl_val_modal_delete_cuti"><?=($result['nipbaru_ws'])?></span>
      </div>
      <div class="col-lg-12">
        <label class="lbl_field_modal_delete_cuti">
          Jenis Cuti
        </label><br>
        <span class="lbl_val_modal_delete_cuti"><?=($result['nm_cuti'])?></span>
      </div>
      <div class="col-lg-12">
        <label class="lbl_field_modal_delete_cuti">
          Tanggal Cuti
        </label><br>
        <?php
          $tanggalCutiDelete = formatDateNamaBulan($result['tanggal_mulai']);
          if($result['tanggal_mulai'] != $result['tanggal_akhir']){
            $tanggalCutiDelete .= " - ".formatDateNamaBulan($result['tanggal_akhir']);
          }
        ?>
        <span class="lbl_val_modal_delete_cuti"><?=($tanggalCutiDelete)?></span>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-6 col-lg-6">
    <form id="form_delete_cuti">
      <div class="row">
        <div class="col-lg-12">
          <label class="lbl_field_modal_delete_cuti">Keterangan</label>
          <textarea class="form-control" rows=5 name="keterangan"></textarea>
        </div>
        <div class="col-lg-12">
          <label class="lbl_field_modal_delete_cuti">Dokumen Pendukung</label>
          <input type="file" name="file_delete_cuti" class="form-control" />
        </div>
        <div class="col-lg-12 text-right mt-3">
          <button id="btn_submit_delete_cuti" class="btn btn-navy" type="submit">Submit</button>
          <button id="btn_submit_delete_cuti_loading" disabled class="btn btn-navy" style="display: none;" type="button"><i class="fa fa-spin fa-spinner"></i> Menunggu....</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $('#form_delete_cuti').on('submit', function(e){
    e.preventDefault()
    $('#btn_submit_delete_cuti').hide()
    $('#btn_submit_delete_cuti_loading').show()
    if(confirm('Apakah Anda yakin ingin menghapus data cuti ini?')){
      var formvalue = $('#form_delete_cuti');
      var form_data = new FormData(formvalue[0]);

      $.ajax({
        url: '<?=base_url("kepegawaian/C_Kepegawaian/deletePermohonanCutiTerbitSk/".$result['id'])?>',
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,
        success: function(res){
          let rs = JSON.parse(res)
          if(rs.code == 1){
            errortoast(rs.message)
          } else {
            $('#modal_delete_cuti').modal('hide')
            successtoast("Data Berhasil Dihapus")
            window.location=""
          }
          $('#btn_submit_delete_cuti').show()
          $('#btn_submit_delete_cuti_loading').hide()
        }, error: function(err){
          $('#btn_submit_delete_cuti').show()
          $('#btn_submit_delete_cuti_loading').hide()
          errortoast('Terjadi Kesalahan')
        }
      })
    }
  })
</script>