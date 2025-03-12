<style>
    .form-check-input:disabled {
        opacity: 1 !important;
    }
</style>

<div class="card card-default p-3">
    <?php if($result){ ?>
        <div class="col-lg-12 mt-3 text-right">
            <button id="btn_ds_top_selected" class="btn btn-success">Digital Sign (<span class="count_selected_files">0</span>)</button>
        </div>
    <?php } ?>
    <div class="div_table mt-3" style="min-height: 50vh; overflow-y: scroll;">
        <table class="table" id="table_pilih_ds">
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
                <th class="text-center">NIP</th>
                <th class="text-center">Unit Kerja</th>
                <th class="text-center">Jenis Dokumen</th>
                <th class="text-center">Tanggal Pengajuan</th>
                <th class="text-center">Lihat</th>
            </thead>
            <tbody>
                <?php $all_check = null; if($result){ $no = 1; foreach($result as $rs){$all_check[] = $rs['id']; ?>
                    <tr class="data_tr" onclick="setSelectedItem('<?=$rs['id']?>')" data-id="<?=$rs['id']?>" style="cursor: pointer;">
                        <td class="text-center">
                            <div class="form-check">
                                <input disabled style="cursor: pointer; height: 20px; width: 20px;"
                                class="form-check-input form-check-input-data" type="checkbox" value="<?=$rs['id']?>" id="checkbox_pilih_<?=$rs['id']?>">
                                <label class="form-check-label" for="checkbox_pilih_<?=$rs['id']?>">
                                </label>
                            </div>
                        </td>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=getNamaPegawaiFull($rs)?></td>
                        <td class="text-center"><?=($rs['nip'])?></td>
                        <td class="text-left"><?=($rs['nm_unitkerja'])?></td>
                        <td class="text-left"><?=($rs['id_m_jenis_layanan'] != 104 ? $rs['nama_layanan'] : $rs['nama_layanan'].' / '.$rs['jenis_ds'])?></td>
                        <td class="text-center"><?=formatDateNamaBulanWT($rs['tanggal_pengajuan'])?></td>
                        <td class="text-center">
                            <?php if($jenis_layanan == 4){ ?>
                                <button type="button" href="#modal_detail" onclick="loadDetailCuti('<?=$rs['id']?>')"
                                data-toggle="modal" class="btn btn-sm btn-navy">Detail</button>
                            <?php } else { ?>
                                <button type="button" href="#modal_detail_ds" onclick="openFile('<?=$rs['id']?>')"
                                data-toggle="modal" class="btn btn-sm btn-navy"><i class="fa fa-file"></i></button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } } else { ?>
                    <tr>
                        <td colspan=7 class="text-center">Tidak ada data</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php if($result){ ?>
        <div class="col-lg-12 mt-3 text-right">
            <button id="btn_ds_selected" class="btn btn-success">Digital Sign (<span class="count_selected_files">0</span>)</button>
        </div>
    <?php } ?>
</div>

<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div id="modal-dialog" class="modal-dialog modal-md">
		<div class="modal-content" id="content_modal_detail">
		</div>
	</div>
</div>

<div class="modal fade" id="modal_detail_ds" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div id="modal-dialog" class="modal-dialog modal-xl">
		<div class="modal-content" id="content_modal_detail_ds">
		</div>
	</div>
</div>
<script>
    $(function(){
        list_checked = [];
    })

    // $('.data_tr').click(function(){
    //     setSelectedItem($(this).data("id"))
    // })

    function openFile(id){
        $('#content_modal_detail_ds').html('')
        $('#content_modal_detail_ds').append(divLoaderNavy)
        $('#content_modal_detail_ds').load('<?=base_url('kepegawaian/C_Kepegawaian/openFileDs/')?>'+id, function(){
            $('#loader').hide()
        })
    }

    function setSelectedItem(id){
        if(id == '0'){
            if($('#checkbox_pilih_semua').is(":checked")){
                list_checked = null;
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

            // if($('#checkbox_pilih_'+id).is(":checked")){
            //     list_checked.push(id)
            // } else {
            //     $('#checkbox_pilih_semua').prop('checked', false)
            //     list_checked.pop(id)
            // }
        }

        if($('.form-check-input-data:checkbox:not(:checked)').length == 0){
            $('#checkbox_pilih_semua').prop('checked', true)
        } else {
            $('#checkbox_pilih_semua').prop('checked', false)
        }
        terpilih = $('.form-check-input-data:checkbox:checked').length
        $('.count_selected_files').html(terpilih)
    }

    $('#btn_ds_top_selected').on('click', function(){
        $('#btn_ds_selected').click()    
    })

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
                    $('#auth_modal_tte_content').load('<?=base_url('kepegawaian/C_Kepegawaian/loadAuthModalTteBulk')?>', function(){
                        $('#loader').hide()
                    })
                }
            });
        } else {
            errortoast('Anda belum memilih data yang akan dilakukan Digital Signature')
        }
    })
    
    function loadDetailCuti(id){
        $('#content_modal_detail').html('')
        $('#content_modal_detail').append(divLoaderNavy)
        $('#content_modal_detail').load('<?=base_url('kepegawaian/C_Kepegawaian/loadDetailCutiForDs/')?>'+id, function(){
            $('#loader').hide()
        })
    }
</script>

<!-- INSERT INTO m_sub_bidang (a.id_m_bidang, nama_sub_bidang) 
VALUES
	(174, 'Sub Bagian Umum dan Kepegawaian'),
    (184, 'Sub Bagian Umum dan Kepegawaian'),
    (196, 'Sub Bagian Umum dan Kepegawaian'),
    (214, 'Sub Bagian Umum dan Kepegawaian'),
    (228, 'Sub Bagian Umum dan Kepegawaian'),
    (242, 'Sub Bagian Umum dan Kepegawaian'),
    (251, 'Sub Bagian Umum dan Kepegawaian'),
    (262, 'Sub Bagian Umum dan Kepegawaian'),
    (275, 'Sub Bagian Umum dan Kepegawaian'),
    (831, 'Sub Bagian Umum dan Kepegawaian'),
    (833, 'Sub Bagian Umum dan Kepegawaian'); -->