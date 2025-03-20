<div class="row">
    <?php if($result){ ?>
        <div class="col-lg-12 table-responsive">
            <h4>Progress File: <?=$result[0]['filename']?></h4>
            <table border=1 style="border-collapse: collapse;" class="table table-hover table-sm table-striped">
                <thead>
                    <th class="text-center">No</th>
                    <th class="text-center">Verifikator</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">File</th>
                </thead>
                <tbody>
                    <?php if($result){ $no = 1; foreach($result as $d){ ?>
                        <tr>
                            <td class="text-center"><?=$no++;?></td>
                            <td class="text-left"><?=$d['nama_jabatan']?></td>
                            <td class="text-center">
                                <?php
                                    $badge = "badge-warning";
                                    $status_text = "Belum Selesai";
                                    if($d['flag_verif'] == 1){
                                        $badge = "badge-success";
                                        $status_text = "Selesai";
                                    } else if($d['flag_verif'] == 2){
                                        $badge = "badge-danger";
                                        $status_text = "Ditolak";
                                    }
                                ?>
                                <span class="badge badge-sm <?=$badge?>"><?=$status_text?></span>
                            </td>
                            <td class="text-left"><?=$d['keterangan']?></td>
                            <td class="text-center">
                                <?php if($d['url_file'] && $d['flag_verif'] != 2){ ?>
                                    <a target="_blank" href="<?=base_url($d['url_file'])?>"><button class="btn <?=$d['flag_verif'] == 1 ? "btn-success" : "btn-danger"?>"><i class="fa fa-file-pdf"></i></button></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php if($d['flag_verif'] == 2){break;} } } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="col-lg-12 text-center">
            <h4><i class="fa fa-exclamation"></i> Data Tidak Ditemukan</h4>
        </div>
    <?php } ?>
</div>