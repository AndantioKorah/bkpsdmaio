<div class="row p-3">
    <div class="col-lg-12 text-right mb-3">
        <button onclick="validasiBerkas()" class="btn btn-success"><i class="fa fa-check"></i> VALIDASI</button>
    </div>
    <?php if($result){ ?>
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
                <?php $j = 1; foreach($url as $u){ ?>
                    <div class="tab-pane <?= $j == 1 ? 'show active' : ''?>" id="pills-data-<?=$j?>" role="tabpanel" aria-labelledby="pills-data-<?=$j?>">
                        <iframe src="<?=$u?>" style="width: 100%; height: 75vh;"></iframe>
                    </div>
                <?php $j++; } ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-lg-12 text-center">
            <h5 style="font-style: italic;">FILE TIDAK DITEMUKAN</h5>
        </div>
    <?php } ?>
</div>
<script>
    function validasiBerkas(){
        <?php if($result){ ?>
            saveValidasi()
        <?php } else { ?>
            if(confirm('Berkas belum diupload, apakah Anda yakin ingin melanjutkan validasi berkas?')){
                saveValidasi()
            }
        <?php } ?>
    }

    function saveValidasi(){
        console.log('asdsda')
        $.ajax({
            url: '<?=base_url('kepegawaian/C_Layanan/validasiBerkas/'.$nip.'/'.$jenis_berkas.'/'.$id_t_checklist_pensiun)?>',
            method: 'post',
            data: null,
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    successtoast('Validasi Berhasil')
                } else {
                    successtoast(rs.message)
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
            }
        })
    }
</script>