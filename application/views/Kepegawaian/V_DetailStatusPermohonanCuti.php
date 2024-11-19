<style>
  .sp_nohp:hover{
    cursor: pointer;
    font-weight: bold;
    color: black;
    background-color: aqua;
    padding: 5px;
    border-radius: 5px;
    transition: .2s;
  }
</style>
<div class="row">
  <div class="col-lg-12">
    <?php if($progress['list']){ ?>
      <table class="table table-hover table-striped" border=1>
        <thead>
          <th style="width: 5%;" class="text-center">No</th>
          <th style="width: 5%;" class="text-center">Status</th>
          <th style="width: 40%;" class="text-left">Keterangan</th>
          <th style="width: 20%;" class="text-center">No. HP</th>
          <th style="width: 20%;" class="text-center">Dikirim</th>
          <th style="width: 20%;" class="text-center">Terkirim</th>
          <?php if($this->general_library->isProgrammer()){ ?>
            <th style="width: 15%;" class="text-center">Resend</th>
          <?php } ?>
          <tbody>
            <?php $no = 1; foreach($progress['list'] as $p){ ?>
              <tr>
                <td class="text-center"><?=$no++?></td>
                <td class="text-center">
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
                <td class="text-left"><?=$p['keterangan']?></td>
                <td class="text-center">
                  <span id="span_nohp_<?=$p['id']?>" onclick="editNohp('<?=$p['id']?>')" class="sp_nohp"><?=$p['nohp']?></span>
                  <div style="display: none;" id="div_edit_nohp_<?=$p['id']?>">
                    <form id="form_edit_nohp_<?=$p['id']?>">
                      <div class="row">
                        <div class="col-lg-12">
                          <input class="form-control form-control-sm" value="<?=$p['nohp']?>" id="nohp_<?=$p['id']?>" />
                        </div>
                        <div class="col-lg-6 mt-2 text-left">
                          <button id="btn_save_no_hp_<?=$p['id']?>" type="button" onclick="saveNohp('<?=$p['id']?>')" class="btn btn-sm btn-success"><i class="fa fa-save"></i></button>
                          <button style="display: none;" id="btn_save_no_hp_loading_<?=$p['id']?>" type="button" disabled class="btn btn-sm btn-success"><i class="fa fa-spin fa-spinner"></i></button>
                        </div>
                        <div class="col-lg-6 mt-2 text-right">
                          <button type="button" onclick="cancelSaveNohp('<?=$p['id']?>')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </td>
                <td class="text-center"><?=$p['date_sending'] ? formatDateNamaBulanWT($p['date_sending']) : ''?></td>
                <td class="text-center"><?=$p['date_sent'] ? formatDateNamaBulanWT($p['date_sent']) : ''?></td>
                <td class="text-center">
                  <?php if($this->general_library->isProgrammer() &&
                  $p['flag_verif'] == 0 &&
                  $p['jabatan'] != ID_JABATAN_KABAN_BKPSDM && 
                  $progress['current'] &&
                  $progress['current']['id'] == $p['id']){ ?>
                    <button id="btn_resend_<?=$p['id']?>" class="btn btn-sm btn-danger" type="button" onclick="resendMessage('<?=$p['id']?>')">
                      <i class="fa fa-bell"></i> Resend
                    </button>
                    <button style="display: none;" disabled id="btn_resend_loading_<?=$p['id']?>" class="btn btn-sm btn-danger" type="button">
                      <i class="fa fa-bell"></i> Loading...
                    </button>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </thead>
      </table>
      <script>
        function saveNohp(id){
          $('#btn_save_no_hp_'+id).hide()
          $('#btn_save_no_hp_loading_'+id).show()
          $.ajax({
              url: '<?=base_url("kepegawaian/C_Kepegawaian/saveNohpVerifikatorCuti/")?>'+id,
              method:"POST",  
              data: {
                nohp: $('#nohp_'+id).val()
              },
              success: function(res){
                let rs = JSON.parse(res)
                if(rs.code == 1){
                  errortoast(rs.message)
                } else {
                  successtoast('Nomor HP berhasil diganti')
                  $('#span_nohp_'+id).html($('#nohp_'+id).val())
                  $('#span_nohp_'+id).show()
                  $('#div_edit_nohp_'+id).hide()
                }
                $('#btn_save_no_hp_').show()
                $('#btn_save_no_hp_loading').hide()
              }, error: function(err){
                errortoast('Terjadi Kesalahan')
                $('#btn_save_no_hp_').show()
                $('#btn_save_no_hp_loading').hide()
              }
            })  
        }

        function cancelSaveNohp(id){
          $('#span_nohp_'+id).show()
          $('#div_edit_nohp_'+id).hide()
        }

        function editNohp(id){
          $('#span_nohp_'+id).hide()
          $('#div_edit_nohp_'+id).show()
        }

        function resendMessage(id){
          if(confirm('Apakah Anda yaking ingin mengirim pesan lagi?')){
            $('#btn_resend_'+id).hide()
            $('#btn_resend_loading_'+id).show()
            $.ajax({
              url: '<?=base_url("kepegawaian/C_Kepegawaian/resendMessage/")?>'+id,
              method:"POST",  
              data: null,
              success: function(res){
                let rs = JSON.parse(res)
                if(rs.code == 1){
                  errortoast(rs.message)
                } else {
                  successtoast('Resend berhasil')
                }
                $('#btn_resend_'+id).show()
                $('#btn_resend_loading_'+id).hide()
              }, error: function(err){
                errortoast('Terjadi Kesalahan')
                $('#btn_resend_'+id).show()
                $('#btn_resend_loading_'+id).hide()
              }
            })
          }
        }
      </script>
    <?php } else { ?>
      <div class="text-center"><h5><i class="fa fa-exclamation"></i> Data Tidak Ditemukan</h5></div>
    <?php } ?>
  </div>
</div>