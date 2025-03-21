<div class="row p-3">
    <div class="col-lg-12 mb-3">
        <span style="display: <?=isset($progress[$berkas]) ? 'block' : 'none'?>" class="badge badge-success badge-progress-<?=$berkas?>">
            <?php if(isset($progress[$berkas])){ if($progress[$berkas]['verifikator'] != "" && $progress[$berkas]['verifikator']){ ?>
                Telah diverifikasi oleh <?=trim($progress[$berkas]['verifikator']).' pada '.formatDateNamaBulanWT($progress[$berkas]['created_date'])?>
            <?php } else { ?>
                Berkas sedang dalam proses Digital Signature (DS)
            <?php } } ?>
        </span>
        <br>
        <button style="display: <?=isset($progress[$berkas]) ? 'block' : 'none'?> " onclick="batalValidasiBerkas()" id="btn-batal-validasi" class="float-right btn btn-danger">
            <i class="fa fa-times"></i> BATAL VALIDASI
        </button>
        <button style="display: <?=isset($progress[$berkas]) ? 'none' : 'block'?> " onclick="validasiBerkas()" id="btn-validasi" class="float-right btn btn-success">
            <i class="fa fa-check"></i> VALIDASI
        </button>
    </div>
    <?php if($result){ ?>
        <div class="col-lg-12 mb-3">
            <?php if($jenis_berkas == 'akte_anak'){ ?>
                <table border=1 class="table table-hover">
                    <thead>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Nama Ortu</th>
                        <th class="text-center">TTL</th>
                        <th class="text-center">Pendidikan</th>
                        <th class="text-center">Pekerjaan</th>
                        <th class="text-center">Pilihan</th>
                    </thead>
                    <tbody>
                        <?php if($result){ $no = 1; foreach($result as $r){ ?>
                            <tr>
                                <td class="text-center"><?=$no++;?></td>
                                <td class="text-left"><?=$r['namakel']?></td>
                                <td class="text-left"><?=$r['nama_ortu_anak']?></td>
                                <td class="text-left"><?=$r['tptlahir'].', '.formatDateNamaBulan($r['tgllahir'])?></td>
                                <td class="text-left"><?=$r['pendidikan']?></td>
                                <td class="text-left"><?=$r['pekerjaan']?></td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input form-check-input-anak" type="checkbox" name="akte_anak[]"
                                        style="display: <?=!isset($progress[$berkas]) ? 'block' : 'none'?>"
                                        value="<?=json_encode($r)?>" id="check_<?=$r['id'];?>" onchange="changeCheckAnak('<?=$r['id']?>')">
                                    </div>
                                </td>
                            </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
        <div class="col-lg-12">
            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                <?php $i = 1; foreach($result as $rs){ ?>
                    <li class="nav-item nav-item-profile" role="presentation">
                        <button class="nav-link nav-link-profile <?= $i == 1 ? 'active' : ''?>" id="pills-data-<?=$i?>-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-data-<?=$i?>" type="button" role="tab" aria-controls="pills-data-<?=$i?>-tab" aria-selected="false">
                            <?=isset($rs['keterangan']) && ($rs['keterangan'] != null || $rs['keterangan'] != "")  ? strtoupper($rs['keterangan']).' '.$i : strtoupper($jenis_berkas)?>
                        </button>
                    </li>
                <?php $i++; } ?>
            </ul>
        </div>
        <div class="col-lg-12">
            <div class="tab-content" id="pills-tabContent">
                <?php if($url){ $j = 1; foreach($url as $u){ ?>
                    <div class="tab-pane <?= $j == 1 ? 'show active' : ''?>" id="pills-data-<?=$j?>" role="tabpanel" aria-labelledby="pills-data-<?=$j?>">
                        <iframe src="<?=$u?>" style="width: 100%; height: 75vh;"></iframe>
                    </div>
                <?php $j++; } } else { ?>
                    <div class="text-center">DATA ADA TAPI FILE TIDAK DITEMUKAN DI SERVER</div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-lg-12 text-center">
            <h5 style="font-style: italic;">FILE TIDAK DITEMUKAN</h5>
        </div>
    <?php } ?>
</div>
<script>
    $(function(){
        list_anak = []
    })

    function changeCheckAnak(id){
        if($('#check_'+id).prop('checked')){
            list_anak.push(id)
        } else {
            list_anak.pop(id)
        }
    }

    function validasiBerkas(){
        <?php if($result){ ?>
            saveValidasi()
        <?php } else { ?>
            if(confirm('Berkas belum diupload, apakah Anda yakin ingin melanjutkan validasi berkas?')){
                saveValidasi()
            }
        <?php } ?>
    }

    function batalValidasiBerkas(){
        if(confirm('Apakah Anda yakin?')){
            $.ajax({
                url: '<?=base_url('kepegawaian/C_Layanan/batalValidasiBerkas/'.$jenis_berkas.'/'.$id_t_checklist_pensiun)?>',
                method: 'post',
                data: null,
                success: function(data){
                    let rs = JSON.parse(data)
                    if(rs.code == 0){
                        $('.badge-progress-'+'<?=$berkas?>').hide()
                        successtoast('Batal Validasi Berhasil')
                        $('#btn-batal-validasi').hide()
                        $('#btn-validasi').show()
                        $('.form-check-input-anak').show()
                    } else {
                        successtoast(rs.message)
                    }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                    console.log(e)
                }
            })
        }
    }

    function saveValidasi(){
        $.ajax({
            url: '<?=base_url('kepegawaian/C_Layanan/validasiBerkas/'.$nip.'/'.$jenis_berkas.'/'.$id_t_checklist_pensiun)?>',
            method: 'post',
            data: {
                    list_anak: list_anak
                },
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    console.log('<?=$berkas?>')
                    console.log(rs.message)
                    successtoast('Validasi Berhasil')
                    $('#btn-batal-validasi').show()
                    $('#btn-validasi').hide()
                    $('.badge-progress-'+'<?=$berkas?>').show()
                    $('.badge-progress-'+'<?=$berkas?>').text("")
                    $('.badge-progress-'+'<?=$berkas?>').html(rs.message)
                    $('.form-check-input-anak').hide()
                } else {
                    errortoast(rs.message)
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
            }
        })
    }
</script>