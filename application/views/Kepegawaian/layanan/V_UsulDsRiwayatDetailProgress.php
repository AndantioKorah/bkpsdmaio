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
                                <span class="badge badge-sm <?=$d['flag_verif'] == 1 ? 'badge-success' : 'badge-warning'?>"><?=$d['flag_verif'] == 1 ? 'Selesai' : 'Belum Selesai'?></span>
                            </td>
                            <td class="text-left"><?=$d['keterangan']?></td>
                            <td class="text-center">
                                <?php if($d['url_file']){ ?>
                                    <a target="_blank" href="<?=base_url($d['url_file'])?>"><button class="btn <?=$d['flag_verif'] == 1 ? "btn-success" : "btn-danger"?>"><i class="fa fa-file-pdf"></i></button></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="col-lg-12 text-center">
            <h4><i class="fa fa-exclamation"></i> Data Tidak Ditemukan</h4>
        </div>
    <?php } ?>
</div>