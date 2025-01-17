<?php foreach($list_pegawai as $lp){ ?>
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
        <div class="col-lg-12">
            <hr>
        </div>
    </div>
<?php } ?>
<?php if($sisa > 0){ ?>
    <div class="col-lg-12 text-center">
        <button type="button" onclick="loadSelectedPegawai('all')" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i>Muat Lebih Banyak</button>
    </div>
<?php } ?>