<?php if($result){ ?>
    <style>
        .lbl_nm_verif_balasan{
            font-size: .6rem;
            color: grey;
            font-style: italic;
            font-weight: bold;
        }

        .lbl_val_verif_balasan{
            font-size: 1rem;
            color: black;
            font-weight: bold;
        }
    </style>
    <form id="form_upload_balasan">
        <div class="row p-3">
                <div class="col-lg-12 text-center">
                    <label class="lbl_nm_verif_balasan">Tanggal Balasan</label><br>
                    <span class="lbl_val_verif_balasan">
                        <?=$result['tanggal_balasan'] ? formatDateNamaBulanWT($result['tanggal_balasan']) : '-'?>
                    </span>
                </div>
                <div class="col-lg-12 text-center">
                    <label class="lbl_nm_verif_balasan">Pilih File</label><br>
                    <input class="form-control" type="file" name="file_balasan" id="file_balasan" /><br>
                    <?php if($result['url_file_balasan']){ ?>
                        <iframe style="width: 100%; height: 55vh; margin-top: 10px;" src="<?=base_url($result['url_file_balasan'])?>"></iframe>
                    <?php } else { ?>
                    <?php } ?>
                </div>
                <div class="col-lg-6 text-left">
                    <?php if($result['url_file_balasan']){ ?>
                        <button id="btn_delete" type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus File Balasan</button>
                        <button style="display: none;" id="btn_delete_loading" disabled class="btn btn-danger"><i class="fa fa-spin fa-spinner"></i> Menghapus...</button>    
                    <?php } ?>
                </div>
                <div class="col-lg-6 text-right">
                    <button id="btn_simpan" type="submit" class="btn btn-navy"><i class="fa fa-upload"></i> Simpan File Balasan</button>
                    <button style="display: none;" id="btn_simpan_loading" disabled class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Menyimpan...</button>
                </div>
        </div>
    </form>
    <script>
        $(function(){
            $('#flag_verif').select2()
        })

        $('#form_upload_balasan').on('submit', function(e){
            $('#btn_simpan').hide()
            $('#btn_simpan_loading').show()

            var formvalue = $('#form_upload_balasan');
            var form_data = new FormData(formvalue[0]);
            var ins = document.getElementById('file_balasan').files.length;
            
            if(ins == 0){
                $('#btn_simpan').show()
                $('#btn_simpan_loading').hide()
                errortoast("Silahkan upload file terlebih dahulu");

                return false;
            }

            e.preventDefault()
                $.ajax({
                url: '<?=base_url('rekap/C_Rekap/saveUploadBerkasTppBalasan/'.$result['id'])?>',
                method: 'POST',
                data: form_data,  
                contentType: false,  
                cache: false,  
                processData:false,
                success: function(rs){
                    let res = JSON.parse(rs)
                    if(res.code == 0){
                        successtoast('Upload file balasan berhasil')    
                        // $('#btn_modal_balasan_close').click()
                        loadListData(1)
                        uploadFileBalasan('<?=$result['id']?>')
                    } else {
                        errortoast(res.message)
                    }
                    $('#btn_simpan').show()
                    $('#btn_simpan_loading').hide()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                    console.log(e)
                    $('#btn_simpan').show()
                    $('#btn_simpan_loading').hide()
                }
            })
        })

        $('#btn_delete').on('click', function(){
            if(confirm('Apakah Anda yakin ingin menghapus file balasan?')){
                $('#btn_delete').hide()
                $('#btn_delete_loading').show()
                $.ajax({
                    url: '<?=base_url('rekap/C_Rekap/deleteBerkasTppBalasan/'.$result['id'])?>',
                    method: 'POST',
                    data: null,
                    success: function(rs){
                        let res = JSON.parse(rs)
                        if(res.code == 1){
                            errortoast(res.message)
                        } else {
                            successtoast('File balasan berhasil dihapus')    
                            // $('#btn_modal_balasan_close').click()
                            uploadFileBalasan('<?=$result['id']?>')
                        }
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                        console.log(e)
                    }
                })
            }
        })
    </script>
<?php } else { ?>
    <div class="col-lg-12 text-center">
        <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
    </div>
<?php } ?>