<?php if($result) { ?>
    <style>
        .label_tabel{
            font-style: italic;
            font-size: .65rem;
            color: grey;
        }

        .value_tabel{
            font-size: .8rem;
            color: black;
            font-weight: bold;
        }

        .sec_value{
            font-size: .75rem;
            font-weight: 500;
        }

        .table_data{
            line-height: .9rem;
        }

        .div_item{
            border: 1px solid;
            padding-top: 10px;
            padding-bottom: 5px;
            margin-left: 0px;
            margin-right: 0px;
            border-radius: 5px;
        }

        .div_item:hover{
            background-color: #f4f4f4;
            cursor: pointer;
            transition: .2s;
        }
    </style>
    <div class="row mt-3">
        <?php foreach($result['list_pegawai'] as $lp){ ?>
            <div class="col-lg-6 mb-3">
                <div onclick="openDetailPegawai('<?=$lp['nipbaru_ws']?>')" class="row div_item">
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
                        <table class="table_data">
                            <tr>
                                <td><span class="value_tabel"><?=getNamaPegawaiFull($lp)?></span></td>
                            </tr>
                            <tr>
                                <td><span class="sec_value"><?=formatNip($lp['nipbaru_ws'])?></span></td>
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
        <?php } ?>
    </div>
    <script>
        function openDetailPegawai(nip){
            window.location="<?=base_url('kepegawaian/profil-pegawai/')?>"+nip
        }
    </script>
<?php } else { ?>
    <div class="row">
        <div class="col-lg-12 text-center"><h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5></div>
    </div>
<?php } ?>