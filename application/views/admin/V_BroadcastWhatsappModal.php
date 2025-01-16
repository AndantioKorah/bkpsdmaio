<style>
    .value_tabel{
        font-size: .8rem;
        color: black;
        font-weight: bold;
    }

    .sec_value{
        font-size: .75rem;
        font-weight: 500;
    }
</style>

<div class="row p-3">
    <div class="col-lg-6" style="min-height: 75vh; overflow-x: auto;">
        <div class="row">
            <div class="col-lg-12">
                BORADCAST TO:
                <hr>
            </div>
        </div>
        <?php if($list_pegawai){ foreach($list_pegawai as $lp){ ?>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3">
                        <center>
                            <!-- <img style="width: 75px; height: 75px" class="img-fluid rounded-circle mb-2 b-lazy"
                            src="<?=$this->general_library->getFotoPegawai($lp['fotopeg'])?>"/> -->
                            <img style="width: 75px; height: 75px;object-fit: cover" class="img-fluid rounded-circle mb-2 b-lazy"
                            src="<?php
                                $path = './assets/fotopeg/'.$lp['fotopeg'];
                                // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                if($lp['fotopeg']){
                                if (file_exists($path)) {
                                $src = './assets/fotopeg/'.$lp['fotopeg'];
                                //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                } else {
                                $src = './assets/img/user.png';
                                // $src = '../siladen/assets/img/user.png';
                                }
                                } else {
                                $src = './assets/img/user.png';
                                }
                                echo base_url().$src;?>" /> 
                        </center>
                    </div>
                    <div class="col-lg-9">
                        <table class="table_data" style="line-height: 15px;">
                            <tr>
                                <td><span class="value_tabel"><?=getNamaPegawaiFull($lp)?></span></td>
                            </tr>
                            <tr>
                                <td><span class="sec_value"><?=($lp['nipbaru_ws'])?></span></td>
                            </tr>
                            <tr>
                                <td><span class="sec_value"><?=($lp['nm_pangkat'])?></span></td>
                            </tr>
                            <tr>
                                <td><span class="sec_value"><?=($lp['nama_jabatan'])?></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        <?php } } ?>
    </div>
    <div class="col-lg-6">
        <div class="row">
            <div class="col-lg-12">
                FORM BROADCAST:
                <hr>
            </div>
            <div class="col-lg-12">
                <form id="form_broadcast">
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Nama Broadcast</label>
                            <input class="form-control" name="nama_broadcast"/>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <label>Pilih Jenis Pesan</label>
                            <select class="form-control select2-navy" style="width: 100%"
                            id="jenis_pesan" data-dropdown-css-class="select2-navy" name="jenis_pesan">
                                <option value="text">Text</option>
                                <option value="document">Dokumen</option>
                            </select>
                        </div>
                        <div class="col-lg-12 mt-3 div_document" style="display: none;">
                            <label>Pilih Dokumen</label>
                            <input class="form-control" type="file" name="dokumen_broadcast" id="dokumen_broadcast" /><br>
                        </div>
                        <div class="col-lg-12 div_document" style="display: none;">
                            <label>Nama File</label>
                            <input class="form-control" name="nama_file"/>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <label>Pesan Broadcast</label>
                            <textarea class="form-control" rows=5 name="pesan_broadcast"></textarea>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <button id="btn_submit" class="btn btn-navy">SUBMIT BROADCAST</button>
                            <button disabled id="btn_submit_loading" style="display: none;" class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#jenis_pesan').select2()
    })

    $('#form_broadcast').on('submit', function(e){
        $('#btn_submit').hide()
        $('#btn_submit_loading').show()

        var formvalue = $('#form_broadcast');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('dokumen_broadcast').files.length;
        
        if($('#jenis_pesan').val() != "text" && ins == 0){
            $('#btn_submit').show()
            $('#btn_submit_loading').hide()
            errortoast("Silahkan upload file terlebih dahulu");

            return false;
        }

        e.preventDefault()
            $.ajax({
            url: '<?=base_url('admin/C_Admin/submitBroadcast')?>',
            method: 'POST',
            data: form_data,  
            contentType: false,  
            cache: false,  
            processData:false,
            success: function(rs){
                let res = JSON.parse(rs)
                if(res.code == 0){
                    successtoast('Broadcast berhasil dikirim')
                    $('#broadcast_modal').modal('hide')
                    $('#form_search').submit()
                } else {
                    errortoast(res.message)
                }
                $('#btn_submit').show()
                $('#btn_submit_loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
                $('#btn_submit').show()
                $('#btn_submit_loading').hide()
            }
        })
    })

    $('#jenis_pesan').on('change', function(){
        if($(this).val() == "text"){
            $('.div_document').hide()
        } else {
            $('.div_document').show()
        }
    })
</script>