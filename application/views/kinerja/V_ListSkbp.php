<div class="card col-lg-12 p-3">
    <div class="row">
        <div class="col-lg-12">
            <h4>LIST SKBP PEGAWAI</h4>
        </div>
        <div class="col-lg-12 mt-3">
            <?php if($result){?>
                <table class="table" style="width: 100%;" border=1>
                    <thead>
                        <tr>
                            <th style="border: 1px solid black; vertical-align: middle;" class="text-center" rowspan=2>No</th>
                            <th style="border: 1px solid black; vertical-align: middle;" class="text-center" rowspan=2>Periode</th>
                            <th style="border: 1px solid black; vertical-align: middle;" class="text-center" rowspan=1 colspan=2>Kinerja</th>
                            <th style="border: 1px solid black; vertical-align: middle;" class="text-center" rowspan=1 colspan=2>Komponen</th>
                            <th style="border: 1px solid black; vertical-align: middle;" class="text-center" rowspan=2>Pilihan</th>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black; vertical-align: middle; text-align: center !important;" clsas="text-center" rowspan=1>Capaian</th>
                            <th style="border: 1px solid black; vertical-align: middle; text-align: center !important;" clsas="text-center" rowspan=1 colspan=1>Bobot</th>
                            <th style="border: 1px solid black; vertical-align: middle; text-align: center !important;" clsas="text-center" rowspan=1 colspan=1>Capaian</th>
                            <th style="border: 1px solid black; vertical-align: middle; text-align: center !important;" clsas="text-center" rowspan=1>Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($result as $rs){ ?>
                            <tr>
                                <td style="border: 1px solid black;" class="text-center"><?=$no++;?></td>
                                <td style="border: 1px solid black;" class="text-left"><?=strtoupper(getNamaBulan($rs['bulan'])).' '.$rs['tahun']?></td>
                                <td style="border: 1px solid black;" class="text-center"><?=isset($rs['kinerja']) ? formatTwoMaxDecimal($rs['kinerja']['nilai']['capaian']) : "" ?></td>
                                <td style="border: 1px solid black;" class="text-center"><?=isset($rs['kinerja']) ? formatTwoMaxDecimal($rs['kinerja']['nilai']['bobot']).' %' : "" ?></td>
                                <td style="border: 1px solid black;" class="text-center"><?=isset($rs['komponen']) ? formatTwoMaxDecimal($rs['komponen']['nilai'][0]) : "" ?></td>
                                <td style="border: 1px solid black;" class="text-center"><?=isset($rs['komponen']) ? formatTwoMaxDecimal($rs['komponen']['nilai'][1]).' %' : "" ?></td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <button onclick="inputSkbp('<?=$rs['bulan']?>', '<?=$rs['tahun']?>', 1)" href="#skbp_modal" data-toggle="modal" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</button>
                                    <button id="btn_delete" onclick="deleteAll('<?=$rs['bulan']?>', '<?=$rs['tahun']?>')" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                    <button id="btn_delete_loading" disabled style="display: none;" class="btn btn-danger"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <script>
                    function deleteAll(bulan, tahun){
                        if(confirm('Apakah Anda yakin ingin menghapus data?')){
                            $('#btn_delete').hide()
                            $('#btn_delete_loading').show()
                            $.ajax({
                                url: '<?=base_url("kinerja/C_Kinerja/deleteSkbp/")?>'+bulan+'/'+tahun,
                                method: 'post',
                                data:$(this).serialize(), 
                                success: function(result){
                                    var rs = JSON.parse(result);
                                    if(rs.code == 1){
                                        errortoast(rs.message)
                                    } else {
                                        successtoast(rs.message)
                                        loadListSkbp()
                                    }
                                }, error: function(e){
                                    errortoast(e)
                                }
                            })
                        }
                    }
                </script>
            <?php } else { ?>
                <h6 class="text-center">Belum Ada Data SKBP <i class="fa fa-exclamation"></i></h6>
            <?php } ?>
        </div>
    </div>
</div>