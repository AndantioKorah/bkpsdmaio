<?php if($result){ ?>
    <style>
        .lbl_vr_nm{
            color: grey;
            font-size: .7rem;
            font-weight: bold;
            font-style: italic;
        }

        .lbl_vr_val{
            color: black;
            font-size: 1rem;
            font-weight: bold;
        }
    </style>
    <div class="col-lg-12" style="
        background-color: lightgreen;
        border-radius: 10px;
        padding: 15px;
        width: 100%;
    ">
        <span style="
            font-size: 1.5rem;
            color: green;
            font-weight: bold;
        "><i class="fa fa-check"></i> Dokumen ditandangani secara digital oleh Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota Manado melalui aplikasi Siladen pada <?=formatDateNamaBulanWithTime($result['date_generate_sertifikat'])?></span>
    </div>
    <div class="card card-default">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <span class="lbl_vr_nm">Nama Pegawai</span><br>
                            <span class="lbl_vr_val"><?=getNamaPegawaiFull($result)?></span>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <span class="lbl_vr_nm">NIP</span><br>
                            <span class="lbl_vr_val"><?=($result['nipbaru_ws'])?></span>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <span class="lbl_vr_nm">Nomor Sertifikat</span><br>
                            <span class="lbl_vr_val"><?=$result['nosttpp']?></span>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <span class="lbl_vr_nm">Topik</span><br>
                            <span class="lbl_vr_val"><?=$result['nm_diklat']?></span>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <span class="lbl_vr_nm">Tempat</span><br>
                            <span class="lbl_vr_val"><?=$result['tptdiklat']?></span>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <span class="lbl_vr_nm">Penyelenggara</span><br>
                            <span class="lbl_vr_val"><?=$result['penyelenggara']?></span>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <span class="lbl_vr_nm">Angkatan</span><br>
                            <span class="lbl_vr_val"><?=$result['angkatan']?></span>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <span class="lbl_vr_nm">Jumlah JP</span><br>
                            <span class="lbl_vr_val"><?=$result['jam']?></span>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <span class="lbl_vr_nm">Tanggal Mulai</span><br>
                            <span class="lbl_vr_val"><?=formatDateNamaBulan($result['tglmulai'])?></span>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <span class="lbl_vr_nm">Tanggal Selesai</span><br>
                            <span class="lbl_vr_val"><?=formatDateNamaBulan($result['tglselesai'])?></span>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <span class="lbl_vr_nm">Tanggal Sertifikat</span><br>
                            <span class="lbl_vr_val"><?=formatDateNamaBulan($result['tglsttpp'])?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <iframe style="width: 100%; height: 80vh;" src="<?=base_url($result['url_sertifikat'])."?v=".generateRandomNumber(5)?>"></iframe>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="col-lg-12 text-center text-danger">
        <h4>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h4>
    </div>
<?php } ?>