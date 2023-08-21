<style>
    .label-filter{
        color: #434242;
        font-weight: bold;
        font-size: 15px;
    }
    
    .filter-option{
        overflow: auto;
        white-space: nowrap;
        padding-bottom: 5px;
        padding-top: 5px;
    }

    .filter-btn {
        display: inline-block;
        text-align: center;
        padding: 5px;
        border-radius: 5px;
        margin-right: 3px;
        transition: .2s;
    }

    .filter-unselect{
        border: 1px solid #939ba2;
        color: #939ba2;
    }

    .filter-unselect:hover{
        cursor: pointer;
        background-color: #43556b;
        color: white;
    }

    .filter-select{
        border: 1px solid #222e3c;
        color: white;
        font-weight: bold;
        background-color: #222e3c;
    }

    .filter-select:hover{
        cursor: pointer;
        background-color: #222e3c;
        color: white;
    }
</style>

<div class="card card-default">
    <div class="card-header">
        <h5 class="card-title">DATA PEGAWAI</h5>
        <hr>
    </div>
    <div class="card-body" style="margin-top: -30px;">
        <form id="form_search">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="label-filter">Eselon</label>
                            <div class="filter-option">
                                <?php foreach($eselon as $e){ ?>
                                    <span id="btn_filter_eselon_<?=$e['id_eselon']?>" onclick="filterClicked('eselon_<?=$e['id_eselon']?>')"
                                    class="filter-btn filter-unselect"><?=$e['nm_eselon']?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label class="label-filter">Status Pegawai</label>
                            <div class="filter-option">
                                <?php foreach($statuspeg as $sp){ ?>
                                    <span id="btn_filter_statuspeg_<?=$sp['id_statuspeg']?>" onclick="filterClicked('statuspeg_<?=$sp['id_statuspeg']?>')"
                                    class="filter-btn filter-unselect"><?=$sp['nm_statuspeg']?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label class="label-filter">Pendidikan</label>
                            <div class="filter-option">
                                <?php foreach($tktpendidikan as $tkp){ ?>
                                    <span id="btn_filter_tktpendidikan_<?=$tkp['id_tktpendidikan']?>" onclick="filterClicked('tktpendidikan_<?=$tkp['id_tktpendidikan']?>')"
                                    class="filter-btn filter-unselect"><?=$tkp['nm_tktpendidikan']?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label class="label-filter">Jenis Kelamin</label>
                            <div class="filter-option">
                                <?php foreach($jenis_kelamin as $jk){ ?>
                                    <span id="btn_filter_jenis_kelamin_<?=$jk['id_jenis_kelamin']?>" onclick="filterClicked('jenis_kelamin_<?=$jk['id_jenis_kelamin']?>')"
                                    class="filter-btn filter-unselect"><?=$jk['nm_jenis_kelamin']?></span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="label-filter">Pangkat</label>
                            <div class="filter-option">
                                <?php foreach($pangkat as $p){ ?>
                                    <span id="btn_filter_pangkat_<?=$p['id_pangkat']?>" onclick="filterClicked('pangkat_<?=$p['id_pangkat']?>')"
                                    class="filter-btn filter-unselect"><?=$p['nm_pangkat']?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label class="label-filter">Golongan</label>
                            <div class="filter-option">
                                <?php foreach($golongan as $g){ ?>
                                    <span id="btn_filter_golongan_<?=$g['id_golongan']?>" onclick="filterClicked('golongan_<?=$g['id_golongan']?>')"
                                    class="filter-btn filter-unselect"><?=$g['nm_golongan']?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label class="label-filter">Agama</label>
                            <div class="filter-option">
                                <?php foreach($agama as $g){ ?>
                                    <span id="btn_filter_agama_<?=$g['id_agama']?>" onclick="filterClicked('agama_<?=$g['id_agama']?>')"
                                    class="filter-btn filter-unselect"><?=$g['nm_agama']?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label class="label-filter">Unit Kerja</label>
                            <div class="">
                                <select class="form-control select2-navy" 
                                    id="unitkerja" data-dropdown-css-class="select2-navy" name="unitkerja" required>
                                    <option value="0" selected>Semua</option>
                                    <?php foreach($unitkerja as $u){ ?>
                                        <option value="<?=$u['id_unitkerja']?>"><?=$u['nm_unitkerja']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9"></div>
                <div class="col-lg-3 text-right mt-2">
                    <button id="btn_search" type="submit" class="btn btn-navy"><i class="fa fa-search"></i> Cari</button>
                    <button style="display:none;" id="btn_loading" disabled type="button" class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default" id="div_result">
</div>
<script>
    let eselon = [];
    let statuspeg = [];
    let tktpendidikan = [];
    let jeniskelamin = [];
    let pangkat = [];
    let golongan = [];
    let agama = [];
    $(function(){
        $('.select2-navy').select2()
    })

    $('#tahun').on('change', function(){
        $('#form_search').submit()
    })

    function filterClicked(btn){
        jenis = btn.split("_")
        if($('#btn_filter_'+btn).hasClass('filter-unselect')){
            $('#btn_filter_'+btn).removeClass('filter-unselect')
            $('#btn_filter_'+btn).addClass('filter-select')
            if(jenis[0] == 'eselon'){
                eselon.push(jenis[1])
            } else if(jenis[0] == 'jenis'){
                jeniskelamin.push(jenis[2])
            } else if(jenis[0] == 'statuspeg'){
                statuspeg.push(jenis[1])
            } else if(jenis[0] == 'agama'){
                agama.push(jenis[1])
            } else if(jenis[0] == 'tktpendidikan'){
                tktpendidikan.push(jenis[1])
            } else if(jenis[0] == 'pangkat'){
                pangkat.push(jenis[1])
            } else if(jenis[0] == 'golongan'){
                golongan.push(jenis[2])
            }
        } else {
            $('#btn_filter_'+btn).addClass('filter-unselect')
            $('#btn_filter_'+btn).removeClass('filter-select')
            if(jenis[0] == 'eselon'){
                eselon = eselon.filter(function(e){
                    return e !== jenis[1]
                })
            } else if(jenis[0] == 'jenis'){
                jeniskelamin = jeniskelamin.filter(function(e){
                    return e !== jenis[2]
                })
            } else if(jenis[0] == 'statuspeg'){
                statuspeg = statuspeg.filter(function(e){
                    return e !== jenis[1]
                })
            } else if(jenis[0] == 'agama'){
                agama = agama.filter(function(e){
                    return e !== jenis[1]
                })
            } else if(jenis[0] == 'tktpendidikan'){
                tktpendidikan = tktpendidikan.filter(function(e){
                    return e !== jenis[1]
                })
            } else if(jenis[0] == 'pangkat'){
                pangkat = pangkat.filter(function(e){
                    return e !== jenis[1]
                })
            } else if(jenis[0] == 'golongan'){
                golongan = golongan.filter(function(e){
                    return e !== jenis[2]
                })
            }
        }
        console.log(golongan)
    }

    $('#form_search').on('submit', function(e){
        $('#btn_loading').show()
        $('#btn_search').hide()
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("user/C_User/searchAllPegawai/")?>',
            method: 'post',
            data: {
                eselon: eselon,
                tktpendidikan: tktpendidikan,
                golongan: golongan,
                jeniskelamin: jeniskelamin,
                pangkat: pangkat,
                agama: agama,
                statuspeg: statuspeg,
                unitkerja: $('#unitkerja').val(),
            },
            success: function(data){
                $('#div_result').html('')
                $('#div_result').append(divLoaderNavy)
                $('#div_result').html('')
                $('#div_result').append(data)

                $('#btn_loading').hide()
                $('#btn_search').show()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
                $('#btn_loading').hide()
                $('#btn_search').show()
            }
        })
    })
</script>