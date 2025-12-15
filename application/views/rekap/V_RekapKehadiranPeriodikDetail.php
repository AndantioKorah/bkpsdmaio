<div class="row p-3">
    <?php if($result){ ?>
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
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-3" style="align-content: space-evenly;">
                    <center>
                        <!-- <img style="width: 75px; height: 75px" class="img-fluid rounded-circle mb-2 b-lazy"
                        src="<?=$this->general_library->getFotoPegawai($result['data']['fotopeg'])?>"/> -->
                        <img style="width: 75px; height: 75px;object-fit: cover" class="img-fluid rounded-circle mb-2 b-lazy"
                        src="<?php
                            $path = './assets/fotopeg/'.$result['data']['fotopeg'];
                            // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                            if($result['data']['fotopeg']){
                            if (file_exists($path)) {
                                $src = './assets/fotopeg/'.$result['data']['fotopeg'];
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
                            <td><span class="value_tabel"><?=getNamaPegawaiFull($result['data'])?></span></td>
                        </tr>
                        <tr>
                            <td><span class="sec_value"><?=formatNip($result['data']['nipbaru_ws'])?></span></td>
                        </tr>
                        <tr>
                            <td><span class="sec_value"><?=($result['data']['nm_pangkat'])?></span></td>
                        </tr>
                        <tr>
                            <td><span class="sec_value"><?=($result['data']['nama_jabatan'])?></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12 table-responsive">
            <table border=1 style="width: 100%; border-collapse: collapse;" class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center">Bulan</th>
                        <th rowspan="1" colspan=18 class="text-center">Keterangan</th>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1" class="text-center">TMK 1</th>
                        <th rowspan="1" colspan="1" class="text-center">TMK 2</th>
                        <th rowspan="1" colspan="1" class="text-center">TMK 3</th>
                        <th rowspan="1" colspan="1" class="text-center">PKSW 1</th>
                        <th rowspan="1" colspan="1" class="text-center">PKSW 2</th>
                        <th rowspan="1" colspan="1" class="text-center">PKSW 3</th>
                        <?php foreach($jenisdisiplin as $jd){ ?>
                            <th rowspan="1" colspan="1" class="text-center"><?=$jd['keterangan']?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i = 1; $i <= 12; $i++){ ?>
                        <tr>
                            <td class="text-left"><?=getNamaBulan($i)?></td>
                            <td class="text-center <?=isset($result[$i]['rekap']['tmk1']) && $result[$i]['rekap']['tmk1'] > 0 ? 'classNotZero' : 'classZero'?>"><?=isset($result[$i]['rekap']['tmk1']) ? $result[$i]['rekap']['tmk1'] : 0?></td>
                            <td class="text-center <?=isset($result[$i]['rekap']['tmk2']) && $result[$i]['rekap']['tmk2'] > 0 ? 'classNotZero' : 'classZero'?>"><?=isset($result[$i]['rekap']['tmk2']) ? $result[$i]['rekap']['tmk2'] : 0?></td>
                            <td class="text-center <?=isset($result[$i]['rekap']['tmk3']) && $result[$i]['rekap']['tmk3'] > 0 ? 'classNotZero' : 'classZero'?>"><?=isset($result[$i]['rekap']['tmk3']) ? $result[$i]['rekap']['tmk3'] : 0?></td>
                            <td class="text-center <?=isset($result[$i]['rekap']['pksw1']) && $result[$i]['rekap']['pksw1'] > 0 ? 'classNotZero' : 'classZero'?>"><?=isset($result[$i]['rekap']['pksw1']) ? $result[$i]['rekap']['pksw1'] : 0?></td>
                            <td class="text-center <?=isset($result[$i]['rekap']['pksw2']) && $result[$i]['rekap']['pksw2'] > 0 ? 'classNotZero' : 'classZero'?>"><?=isset($result[$i]['rekap']['pksw2']) ? $result[$i]['rekap']['pksw2'] : 0?></td>
                            <td class="text-center <?=isset($result[$i]['rekap']['pksw3']) && $result[$i]['rekap']['pksw3'] > 0 ? 'classNotZero' : 'classZero'?>"><?=isset($result[$i]['rekap']['pksw3']) ? $result[$i]['rekap']['pksw3'] : 0?></td>
                            <?php foreach($jenisdisiplin as $jd){ ?>
                                <td class="text-center <?=isset($result[$i]['rekap'][$jd['keterangan']]) && $result[$i]['rekap'][$jd['keterangan']] > 0 ? 'classNotZero' : 'classZero'?>"><?=isset($result[$i]['rekap'][$jd['keterangan']]) ? $result[$i]['rekap'][$jd['keterangan']] : 0?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="text-center text-danger">DATA TIDAK DITEMUKAN</div>
    <?php } ?>
</div>