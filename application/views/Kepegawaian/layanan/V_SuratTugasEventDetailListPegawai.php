<?php if($list_pegawai){ foreach($list_pegawai as $lp){ ?>
    <style>
        .value_tabel{
            font-size: .8rem;
            color: black;
            font-weight: bold;
        }

        .sec_value{
            font-size: .7em;
            color: black;
            font-weight: bold;
        }
    </style>
    <div class="row">
        <div class="col-lg-3">
            <center>
                <!-- <img style="width: 75px; height: 75px" class="img-fluid rounded-circle mb-2 b-lazy"
                src="<?=$this->general_library->getFotoPegawai($lp['fotopeg'])?>"/> -->
                <img style="width: 75px; height: 75px;object-fit: cover" class="img-fluid rounded-circle mb-2 b-lazy"
                data-src="<?php
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
        <div class="col-lg-8">
            <table class="table_data" style="line-height: 13px;">
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
            <div class="text-right float-right">
                <?php if(date('Y-m-d') <= $lp['max_change_date']){ ?>
                    <button id="btn_delete_pegawai_<?=$lp['id_t_pegawai_event_detail']?>"
                        onclick="deletePegawai('<?=$lp['id_t_pegawai_event_detail']?>')" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i>
                    </button>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-12">
            <hr>
        </div>
    </div>
    <script>
        $(function(){
            var bLazy = new Blazy();
            $('#sp_total_pegawai').html('<?=count($list_pegawai)?>')
        })

        function deletePegawai(id){
            if(confirm("Apakah Anda yakin ingin menghapus pegawai?")){
                btnLoader("btn_delete_pegawai_"+id)
                $.ajax({
                    url: '<?=base_url("kepegawaian/C_Layanan/deletePegawaiSuratTugasEvent/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(data){
                        successtoast('Data berhasil dihapus')
                        loadListPegawaiSTEvent()
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }
    </script>
<?php } } else { ?>
    <div class="text-center">
        <h5>Data Tidak Ditemukan</h5>
    </div>
<?php } ?>