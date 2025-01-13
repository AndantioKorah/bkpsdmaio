<?php if($result){
?>
    <style>
        .text-nama{
            font-size: .9rem;
            font-weight: bold;
        }

        .text-small{
            font-size: .8rem;
            color: gray;
        }

        #table_result, #table_result thead, #table_result th, #table_result tr, #table_result td{
            border: 1px solid gray;
        }
    </style>
    <div class="row p-3">
        <div class="col-lg-12 pb-3 text-right float-right">
            <!-- <form target="_blank" action="<?=base_url('user/C_User/cetakNaikPangkat')?>">
                <button type='submit' class="btn btn-sm btn-navy"><i class="fa fa-download"></i> Download File</button>
                <button type='button' onclick="cetak()" class="btn btn-sm btn-navy"><i class="fa fa-print"></i> Cetak</button>
            </form> -->
        </div>
        <div class="col-lg-12">
            <table border=1 id="table_result" class="table table-hover datatable">
                <thead>
                    <th style="width: 5%;" class="text-center">No</th>
                    <th style="width: 35%;" class="text-center">Nama Pegawai</th>
                    <th style="width: 35%;" class="text-center">Pangkat</th>
                    <th style="width: 20%;" class="text-center">Jabatan</th>
                    <th style="width: 20%;" class="text-center">Unit Kerja</th>
                    <th style="width: 10%;" class="text-center">TMT Gaji Berkala</th>
                    <th style="width: 10%;" class="text-center"></th>
                    <!-- <th style="width: 10%;" class="text-center">Tgl. Naik Pangkat Selanjutnya</th> -->
                </thead>
                <tbody>
                    <?php $no = 1; foreach($result as $rs){ ?>
                        <tr>
                            <td class="text-center"><?=$no++;?></td>
                            <td class="text-left">
                            <a style="color:#000" target="_blank" href="<?= base_url('kepegawaian/profil-pegawai/')?><?=$rs['nipbaru_ws'];?>" style="color:#fff">
                                <span class="text-nama"><?=getNamaPegawaiFull($rs)?></span><br>
                                <span class="text-small"><?=formatNip($rs['nipbaru_ws'])?></span><br>
                                <!-- <span class="text-small"><?=($rs['nama_jabatan'])?></span><br> -->
                                <!-- <span class="text-small"><?=($rs['nm_pangkat'])?></span> -->
                                </a>
                            </td>
                            <td class="text-center"><?=($rs['nm_pangkat'])?> <br> <?=formatDateNamaBulan($rs['tmtpangkat'])?></td>
                            <td class="text-center"><?=($rs['nama_jabatan'])?></td>
                            <td class="text-left"><?=($rs['nm_unitkerja'])?></td>
                            <td class="text-center">
                                <?= formatDateNamaBulan(date('Y-m-d H:i:s', strtotime('+2 years', strtotime($rs['tmtgjberkala']))));?>
                                <!-- <?=formatDateNamaBulan($rs['tmtgjberkala'])?> -->
                            </td>
                            <td class="text-center">
                            <a target="_blank" href="<?= base_url();?>kepegawaian/C_Kepegawaian/prosesGajiBerkala/<?=$rs['nipbaru_ws']?>/<?=$tahun;?>">
                                <button class="btn btn-primary btn-sm">Proses</button>
                            </a>
                            </td>
                            <!-- <td class="text-center"><?=formatDateOnly($rs['tmtpangkat'])?></td> -->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } else { ?>
    <div class="p-3">
        <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
    </div>
<?php } ?>

<script>
    $(function(){
        $('.datatable').dataTable()
    })

    function cetak() {
        $("#print_div").load('<?= base_url('user/C_User/cetakNaikPangkat')?>',
            function () {
                printSpace('print_div');
            });
    }

    function printSpace(elementId) {
        var isi = document.getElementById(elementId).innerHTML;
        window.frames["print_frame"].document.title = document.title;
        window.frames["print_frame"].document.body.innerHTML = isi;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }
</script>