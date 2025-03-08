<div class="row">
  <div class="col-lg-12 table-responsive">
    <table id="table_verif_usul_detail" class="table table-hover">
      <thead>
        <th class="text-center">
          <div class="form-check">
            <input onclick="setSelectedItem('0')" style="cursor: pointer; height: 20px; width: 20px;" class="form-check-input" type="checkbox" value="all"
            id="checkbox_pilih_semua">
            <label class="form-check-label" for="checkbox_pilih_semua">
            </label>
          </div>
        </th>
        <th class="text-center">No</th>
        <th class="text-center">Uploader</th>
        <th class="text-center">Nama File</th>
        <th class="text-center">Pilihan</th>
      </thead>
      <tbody>
        <?php $all_check = null; if($result){ $no = 1; foreach($result as $rs){ $all_check[] = $rs['id']; ?>
          <tr class="data_tr" onclick="setSelectedItem('<?=$rs['id']?>')" data-id="<?=$rs['id']?>" style="cursor: pointer;">
            <td class="text-center">
              <div class="form-check">
                <input style="cursor: pointer; height: 20px; width: 20px;"
                class="form-check-input form-check-input-data" type="checkbox" value="<?=$rs['id']?>" id="checkbox_pilih_<?=$rs['id']?>">
                <label class="form-check-label" for="checkbox_pilih_<?=$rs['id']?>">
                </label>
              </div>
            </td>
            <td class="text-center"><?=$no++;?></td>
            <td class="text-left"><?=$rs['user_inputer']?></td>
            <td class="text-left"><?=$rs['id'].$rs['filename']?></td>
            <td class="text-center">
              <button class="btn btn-sm btn-outline-danger" onclick="openFile('<?=$rs['url']?>')"><i class="fa fa-file-pdf"></i></button>
            </td>
          </tr>
        <?php } } ?>
      </tbody>
    </table>
  </div>
  <div class="col-lg-12 mt-3 text-right">
    <button id="btn_ds_selected" class="btn btn-success">Submit (<span class="count_selected_files">0</span>)</button>
  </div>
</div>
<script>
  $(function(){
    $('#table_verif_usul_detail').dataTable()
    list_checked = [];
    terpilih = 0
  })

  function openFile(url){
    // successtoast(url)
    window.open('<?=base_url()?>'+url, '_blank');
  }

  function setSelectedItem(id){
        if(id == '0'){
            if($('#checkbox_pilih_semua').is(":checked")){
                list_checked = "semua";
                list_checked = JSON.parse('<?=json_encode($all_check)?>')
                $('.form-check-input').prop('checked', true)
            } else {
                list_checked = [];
                $('.form-check-input').prop('checked', false)
            }
        } else {
            if($('#checkbox_pilih_'+id).is(":checked")){
                $('#checkbox_pilih_'+id).prop('checked', false)
                list_checked.pop(id)
            } else {
                $('#checkbox_pilih_'+id).prop('checked', true)
                list_checked.push(id)
            }
        }

        if($('.form-check-input-data:checkbox:not(:checked)').length == 0){
            $('#checkbox_pilih_semua').prop('checked', true)
        } else {
            $('#checkbox_pilih_semua').prop('checked', false)
        }
        // terpilih = $('.form-check-input-data:checkbox:checked').length
        terpilih = list_checked.length
        $('.count_selected_files').html(terpilih)

        console.log(list_checked)
    }

    $('#btn_ds_selected').on('click', function(){
        if(parseInt(terpilih) > 0){
            Swal.fire({
                title: 'Apakah anda yakin ingin melanjutkan DS terhadap '+terpilih+' file ini?',
                // text: '',
                reverseButtons: true,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: "#222e3c",
                cancelButtonColor: "grey",
                cancelButtonText: 'Batal',
                confirmButtonText: 'Lanjutkan',
            }).then((result) => {
                if (result.value == true) {
                    $('#auth_modal_tte').modal('show')
                    $('#auth_modal_tte_content').html('')
                    $('#auth_modal_tte_content').append(divLoaderNavy)
                    $('#auth_modal_tte_content').load('<?=base_url('kepegawaian/C_Layanan/loadAuthModalTteBulk')?>', function(){
                        $('#loader').hide()
                    })
                }
            });
        } else {
            errortoast('Anda belum memilih data yang akan dilakukan Digital Signature')
        }
    })
</script>