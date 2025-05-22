<div class="row p-3">
    <?php
        $listFileDone = null;
        if($result){ ?>
        <?php if($result['flag_done'] == 0 ){ ?>
            <!-- <div class="col-lg-12 text-right">
                <button class="btn btn-sm btn-danger" onclick="deleteData('<?=$result['id']?>')"><i class="fa fa-trash"></i> Hapus</button>
            </div> -->
        <?php } ?>
        <div class="col-lg-12 mb-3">
            <h5>JENIS LAYANAN</h5>
            <h3><?=$result['id_m_jenis_layanan'] == 104 ? $result['nama_layanan'].' / '.$result['keterangan'] : $result['nama_layanan']?></h3>
            <h4>Keterangan: <?=$result['id_m_jenis_layanan'] != 104 ? $result['keterangan'] : ""?></h4>
            <h4>DS CODE: <?=$result['ds_code']?></h4>
            <button onclick="downloadAllDoneFile()" class="float-right btn btn-danger"><i class="fa fa-download"></i> Download File</button>
        </div>
        <div class="col-lg-12 table-responsive">
            <table border=1 style="border-collapse: collapse;" id="table_detail_usul_ds" class="mt-3 table table-hover table-sm table-striped">
                <thead>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama File</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">File</th>
                </thead>
                <tbody>
                    <?php if($result['detail']){ $no = 1; foreach($result['detail'] as $d){
                        $fileName = $d['filename'];
                        if($d['flag_status'] == 1 && $d['flag_done'] == 1){
                            $tName = explode("/", $d['url_done']);
                            $fileName = $tName[3];
                        }
                    ?>
                        <tr style="cursor: pointer;" onclick="openProgress('<?=$d['id']?>')">
                            <td class="text-center"><?=$no++;?></td>
                            <td class="text-left"><?=$fileName?></td>
                            <td class="text-center">
                                <?php
                                    $badge = "badge-warning";
                                    $status_text = "Belum Selesai";
                                    if($d['flag_status'] == 1){
                                        $badge = "badge-success";
                                        $status_text = "Selesai";
                                    } else if($d['flag_status'] == 2){
                                        $badge = "badge-danger";
                                        $status_text = "Ditolak";
                                    }
                                ?>
                                <span class="badge badge-sm <?=$badge?>"><?=$status_text?></span>
                            </td>
                            <td class="text-left"><?=$d['keterangan']?></td>
                            <td class="text-center">
                                <?php if($d['flag_done'] == 1){
                                    $listFileDone[] = base_url($d['url_done']);
                                ?>
                                    <a target="_blank" href="<?=base_url($d['url_done'])?>"><button class="btn btn-sm btn-success"><i class="fa fa-file-pdf"></i></button></a>
                                <?php } else { ?>
                                    <a target="_blank" href="<?=base_url($d['url'])?>"><button class="btn btn-sm btn-warning"><i class="fa fa-file-pdf"></i></button></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-12 mt-3" id="div_progress">

        </div>
        <script>
            $(function(){
                $('#table_detail_usul_ds').dataTable()
            })

            function openProgress(id){
                $('#div_progress').html('')
                $('#div_progress').append(divLoaderNavy)
                $('#div_progress').load('<?=base_url('kepegawaian/C_Layanan/loadProgressUsulDs/')?>'+id, function(){
                    $('#loader').hide()
                })
            }

            function downloadAllDoneFile(){
                let totalFile = "<?=count($result['detail'])?>"
                let totalFileDone = "<?=$listFileDone ? count($listFileDone) : 0?>"
                let downloadNow = 0
                if(totalFile != totalFileDone){
                    if(confirm("Jumlah File yang sudah selesai adalah "+totalFileDone+" dari "+totalFile+". Apakah Anda ingin melanjutkan untuk tetap download?")){
                        downloadNow = 1;
                    }
                } else {
                    downloadNow = 1;
                }

                if(downloadNow == 1){
                    successtoast("halo")
                } else {
                    return
                }
            }
        </script>
    <?php } else { ?>
        <div class="col-lg-12 text-center">
            <h4><i class="fa fa-exclamation"></i> Data Tidak Ditemukan</h4>
        </div>
    <?php } ?>
</div>