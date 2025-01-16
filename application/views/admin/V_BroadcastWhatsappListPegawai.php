<style>
    .badge-cpns{
      /* box-shadow: 3px 3px 10px #888888; */
      background-color: #ed1818;
      border: 2px solid #ed1818;
      color: white;
    }

    .badge-pppk{
      /* box-shadow: 3px 3px 10px #888888; */
      background-color: #8f8657;
      border: 2px solid #8f8657;
      color: white;
    }

    .namapegawai:hover{
        cursor:pointer;
        text-decoration: underline;
        color: #17a2b8 !important;
    }
</style>
<div class="col-lg-12 p-3">
    <?php if($result){ ?>
        <div class="col-lg-12 mt-3 text-right p-3">
            <button id="btn_broadcast_selected" class="btn btn-success">Pilih (<span class="count_selected_files">0</span>) Pegawai</button>
        </div>
    <?php } ?>
    <table class="table table-hover" id="result_all_pegawai">
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
            <th class="text-center">Pegawai</th>
            <th class="text-center">Eselon</th>
            <th class="text-center">Pangkat</th>
            <?php if($use_masa_kerja == 1){ ?>
                <th class="text-center">Masa Kerja</th>
            <?php } ?>
            <th class="text-center">Unit Kerja</th>
        </thead>
        <tbody>
            <?php $all_check = null; if($result){ $no=1; foreach($result as $rs){ $all_check[] = $rs['nipbaru_ws'];
                    $badge_status = 'badge-cpns';
                if($rs['statuspeg'] == 2){
                    $badge_status = 'badge-pns';
                } else if($rs['statuspeg'] == 3){
                    $badge_status = 'badge-pppk';
                }

                $badge_aktif = 'badge-aktif';
                if($rs['id_m_status_pegawai'] == 2){
                    $badge_aktif = 'badge-pensiun-bup';
                } else if($rs['id_m_status_pegawai'] == 3){
                    $badge_aktif = 'badge-pensiun-dini';
                } else if($rs['id_m_status_pegawai'] == 4){
                    $badge_aktif = 'badge-diberhentikan';
                } else if($rs['id_m_status_pegawai'] == 5){
                    $badge_aktif = 'badge-mutasi';
                } else if($rs['id_m_status_pegawai'] == 6){
                    $badge_aktif = 'badge-meninggal';
                } else if($rs['id_m_status_pegawai'] == 8){
                    $badge_aktif = 'badge-tidak-aktif';
                }
            ?>  
                <tr class="data_tr" onclick="setSelectedItem('<?=$rs['nipbaru_ws']?>')" data-id="<?=$rs['nipbaru_ws']?>" style="cursor: pointer;">
                    <td class="text-center">
                        <div class="form-check">
                            <input style="cursor: pointer; height: 20px; width: 20px;"
                            class="form-check-input form-check-input-data" type="checkbox" value="<?=$rs['nipbaru_ws']?>" id="checkbox_pilih_<?=$rs['nipbaru_ws']?>">
                            <label class="form-check-label" for="checkbox_pilih_<?=$rs['nipbaru_ws']?>">
                            </label>
                        </div>
                    </td>
                    <td class="text-center"><?=$no++?></td>
                    <td class="text-left">
                        <span class="fw-bold namapegawai">
                            <!-- <a target="_blank" style="color: black !important;" href="<?=base_url('kepegawaian/profil-pegawai/'.$rs['nipbaru_ws'])?>"><?=getNamaPegawaiFull($rs)?></a> -->
                            <a><?=getNamaPegawaiFull($rs)?></a>
                        </span><br>
                        <span><?=($rs['nama_jabatan'])?></span><br>
                        <span><?="NIP. ".($rs['nipbaru_ws'])?></span><br>
                        <span class="badge <?=$badge_status?>"><?=$rs['nm_statuspeg']?></span>
                        <span class="badge <?=$badge_aktif?>"><?=$rs['nama_status_pegawai']?></span>
                    </td>
                    <td class="text-center"><?=$rs['eselon']?></td>
                    <td class="text-left"><?=$rs['nm_pangkat']?></td>
                    <?php if($use_masa_kerja == 1){ ?>
                        <td class="text-center"><?=$rs['masa_kerja']?></td>
                    <?php } ?>
                    <td class="text-left"><?=$rs['nm_unitkerja']?></td>
                </tr>
            <?php } } ?>
        </tbody>
    </table>
</div>
<script>
    $(function(){
        list_checked = [];
        $('#result_all_pegawai').dataTable()
    })

    $('#btn_broadcast_selected').on('click', function(){
        if(parseInt(terpilih) > 0){
            $('#broadcast_modal').modal('show')
            $('#broadcast_modal_content').html('')
            $('#broadcast_modal_content').append(divLoaderNavy)
            $.ajax({
                url: '<?=base_url("admin/C_Admin/loadModalBroadcast")?>',
                method: 'post',
                data: {
                    list_nip: list_checked
                },
                success: function(data){
                    $('#broadcast_modal_content').html('')
                    $('#broadcast_modal_content').append(data)
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })

            // Swal.fire({
            //     title: 'Lanjutkan Broadcast ke '+terpilih+' pegawai?',
            //     // text: '',
            //     reverseButtons: true,
            //     icon: 'question',
            //     showCancelButton: true,
            //     confirmButtonColor: "#222e3c",
            //     cancelButtonColor: "grey",
            //     cancelButtonText: 'Batal',
            //     confirmButtonText: 'Lanjutkan',
            // }).then((result) => {
            //     if (result.value == true) {
                    
            //     }
            // });
        } else {
            errortoast('Anda belum memilih pegawai untuk dikirimkan pesan')
        }
    })

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
</script>