<style>
    .nav-link-kinerja{
      padding: 5px !important;
      font-size: .8rem;
      color: black;
      border: .5px solid var(--primary-color) !important;
      border-bottom-left-radius: 0px;
    }

    .nav-item-kinerja:hover, .nav-link-kinerja:hover{
      color: white !important;
      background-color: #222e3c91;
    }

    .nav-tabs .nav-link.active, .nav-tabs .show>.nav-link{
      /* border-radius: 3px; */
      background-color: var(--primary-color);
      color: white;
    }
</style>

<div class="col-lg-12 pl-3 pr-3 pt-3">
    <ul class="nav nav-tabs" id="pills-tab" role="tablist">
        <li class="nav-item nav-item-kinerja" role="presentation">
        <button class="nav-link nav-link-kinerja active" id="pills-kinerja-tab" data-bs-toggle="pill" data-bs-target="#pills-kinerja" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Kinerja</button>
        </li>
        <li class="nav-item nav-item-kinerja" role="presentation">
        <button class="nav-link nav-link-kinerja" id="pills-komponen-kinerja-tab" data-bs-toggle="pill" data-bs-target="#pills-komponen-kinerja" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Komponen Kinerja</button>
        </li>
    </ul>
</div>

<div class="col-lg-12 p-3">
    <div class="tab-content" id="pills-tabContent" style="margin-bottom: 0px;">
        <div class="tab-pane show active" id="pills-kinerja" role="tabpanel" aria-labelledby="pills-kinerja-tab">
            <div class="col-lg-12 table-responsive" id="konten_skp">
                <h3 class="text-center">TABEL KINERJA</h3>
                <table border=1 style="width: 100%;" class="table-bordered">
                    <tr>
                        <td style="padding: 5px; font-weight: bold; width: 5%" class="text-center" rowspan=2>No</td>
                        <td style="padding: 5px; font-weight: bold; width: 20%" class="text-center" rowspan=2>Uraian Tugas</td>
                        <td style="padding: 5px; font-weight: bold; width: 20%" class="text-center" rowspan=2>Sasaran Kerja</td>
                        <td style="padding: 5px; font-weight: bold; width: 10%" class="text-center" rowspan=1 colspan=2>Target</td>
                        <td style="padding: 5px; font-weight: bold; width: 10%" class="text-center" rowspan=1 colspan=2>Realisasi</td>
                        <td style="padding: 5px; font-weight: bold; width: 5%" class="text-center" rowspan=2>Nilai Capaian</td>
                        <td style="padding: 5px; font-weight: bold; width: 10%" class="text-center" rowspan=2>Pilihan</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px; font-weight: bold; width: 10%" class="text-center" rowspan=1>Kuantitas</td>
                        <td style="padding: 5px; font-weight: bold; width: 10%" class="text-center" rowspan=1>Output</td>
                        <td style="padding: 5px; font-weight: bold; width: 10%" class="text-center" rowspan=1>Kuantitas</td>
                        <td style="padding: 5px; font-weight: bold; width: 10%" class="text-center" rowspan=1>Output</td>
                    </tr>
                    <tbody class="tbody">
                    </tbod>
                </table>
            </div>
        </div>
        <div class="tab-pane" id="pills-komponen-kinerja" role="tabpanel" aria-labelledby="pills-komponen-kinerja-tab">
            <div class="col-lg-12 table-responsive" id="konten_skp">
                <h3 class="text-center">TABEL KOMPONEN KINERJA</h3><br>
                <h6 class="text-center" style="font-style: italic; margin-top: -25px; color: red; font-weight: bold;">(Nilai ini dapat diintervensi oleh atasan)</h6>
                <form id="form_komponen_kinerja">
                    <table border=1 style="width: 100%;" class="table table-bordered table-hover table-striped">
                        <tr>
                            <td style="padding: 5px; font-weight: bold; width: 5%; text-align: center;">NO</td>
                            <td style="padding: 5px; font-weight: bold; width: 70%; text-align: center;">KOMPONEN KINERJA</td>
                            <td style="padding: 5px; font-weight: bold; width: 25%; text-align: center;">NILAI</td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding: 5px;">1</td>
                            <td style="padding: 5px;">Berorientasi Pelayanan</td>
                            <td class="text-center" style="padding: 5px;">
                                <input class="form-control form-control-sm" name="berorientasi_pelayanan" value="<?=$komponen_kinerja ? $komponen_kinerja['berorientasi_pelayanan'] : '97'?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding: 5px;">2</td>
                            <td style="padding: 5px;">Akuntabel</td>
                            <td class="text-center" style="padding: 5px;">
                                <input class="form-control form-control-sm" name="akuntabel" value="<?=$komponen_kinerja ? $komponen_kinerja['akuntabel'] : '97'?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding: 5px;">3</td>
                            <td style="padding: 5px;">Kompeten</td>
                            <td class="text-center" style="padding: 5px;">
                                <input class="form-control form-control-sm" name="kompeten" value="<?=$komponen_kinerja ? $komponen_kinerja['kompeten'] : '97'?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding: 5px;">4</td>
                            <td style="padding: 5px;">Harmonis</td>
                            <td class="text-center" style="padding: 5px;">
                                <input class="form-control form-control-sm" name="harmonis" value="<?=$komponen_kinerja ? $komponen_kinerja['harmonis'] : '97'?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding: 5px;">5</td>
                            <td style="padding: 5px;">Loyal</td>
                            <td class="text-center" style="padding: 5px;">
                                <input class="form-control form-control-sm" name="loyal" value="<?=$komponen_kinerja ? $komponen_kinerja['loyal'] : '97'?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding: 5px;">6</td>
                            <td style="padding: 5px;">Adaptif</td>
                            <td class="text-center" style="padding: 5px;">
                                <input class="form-control form-control-sm" name="adaptif" value="<?=$komponen_kinerja ? $komponen_kinerja['adaptif'] : '97'?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding: 5px;">7</td>
                            <td style="padding: 5px;">Kolaboratif</td>
                            <td class="text-center" style="padding: 5px;">
                                <input class="form-control form-control-sm" name="kolaboratif" value="<?=$komponen_kinerja ? $komponen_kinerja['kolaboratif'] : '97'?>" />
                            </td>
                        </tr>
                    </table>
                    <div class="col-lg-12 text-right">
                        <?php if($komponen_kinerja) { ?>
                            <button onclick="hapusKomponenKinerja('<?=$komponen_kinerja['id']?>')" id="btn_delete_komponen_kinerja" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                            <button style="display:none;" disabled id="btn_delete_loading_komponen_kinerja" class="btn btn-danger btn-sm"><i class="fa fa-spin fa-spinner"></i> Loading</button>
                        <?php } ?>
                        <button type="submit" id="btn_save_komponen_kinerja" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
                        <button style="display:none;" disabled id="btn_loading_komponen_kinerja" class="btn btn-success btn-sm"><i class="fa fa-spin fa-spinner"></i> Loading</button>
                    </div>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- <hr style="margin-bottom: 0px;">
<div class="pr-3 pl-3 pb-3 text-right">
    <br>
    <button class="btn btn-success text-right"><i class="fa fa-save"></i> Simpan</button>
</div> -->
<script>
    var id_komponen = '<?=$komponen_kinerja ? $komponen_kinerja['id'] : 0 ?>';
    
    $(function(){
        // if(validator()){
            loadSkbpDetail(true)
            $('.modal-title').html('SKBP '+'<?=$nama_bulan.' '.$tahun?>')
        // }
    })

    function loadSkbpDetail(flagUseLoader){
        $('.tbody').html('')
        $('.tbody').load('<?=base_url("kinerja/C_Kinerja/loadSkbpDetailPegawai/".$id.'/'.$bulan.'/'.$tahun)?>', function(){
            $('#loader').hide()
        })
    }

    function hapusKomponenKinerja(id){
        if(confirm('Apakah Anda yakin ingin menghapus data?')){
            $('#btn_delete_komponen_kinerja').hide()
            $('#btn_delete_loading_komponen_kinerja').show()
            $.ajax({
                url: '<?=base_url("kinerja/C_Kinerja/deleteKomponenKinerja/")?>'+id,
                method: 'post',
                data:$(this).serialize(), 
                success: function(result){
                    var rs = JSON.parse(result);
                    if(rs.code == 1){
                        errortoast(rs.message)
                    } else {
                        successtoast(rs.message)
                        $('#btn_delete_loading_komponen_kinerja').hide()
                        loadListSkbp()
                        inputSkbp('<?=$bulan?>', '<?=$tahun?>', 1)
                    }
                }, error: function(e){
                    errortoast(e)
                }
            })
        }
    }

    $('#form_komponen_kinerja').on('submit', function(e){
        e.preventDefault()
        $('#btn_save_komponen_kinerja').hide()
        $('#btn_loading_komponen_kinerja').show()
        if(id_komponen == 0){
            $.ajax({
                url: '<?=base_url("kinerja/C_Kinerja/inputKomponenKinerja/".$id.'/'.$bulan.'/'.$tahun)?>',
                method: 'post',
                data:$(this).serialize(), 
                success: function(result){
                    var rs = JSON.parse(result);
                    if(rs.code == 1){
                        errortoast(rs.message)
                    } else {
                        successtoast(rs.message)
                        id_komponen = rs.data
                        loadListSkbp()
                        inputSkbp('<?=$bulan?>', '<?=$tahun?>', 1)
                    }
                }, error: function(e){
                    errortoast(e)
                }
            })
        } else {
            $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/updateKomponenKinerja/".$id.'/'.$bulan.'/'.$tahun.'/')?>'+id_komponen,
            method: 'post',
            data:$(this).serialize(), 
            success: function(result){
                var rs = JSON.parse(result);
                if(rs.code == 1){
                    errortoast(rs.message)
                } else {
                    successtoast(rs.message)
                    id_komponen = rs.data
                    loadListSkbp()
                }
            }, error: function(e){
                errortoast(e)
            }
        })
        }
        $('#btn_save_komponen_kinerja').show()
        $('#btn_loading_komponen_kinerja').hide()
    })
</script>