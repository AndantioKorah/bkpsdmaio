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

    /* .card-title{
        font-weight: bold;
        font-size: 15px;
        color: black;
    }

    .card{

    }

    .card:hover{
        cursor: pointer;
        background-color: #ced4da;
        transition: .2s;
        .card-title{
            color: white;
        }
    } */
</style>

<div class="card card-default">
    <div class="card-header">
        <h3>LIVE ABSEN KEGIATAN RAPAT KOORDINASI</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <label class="label-filter">Eselon</label>
                        <div class="filter-option">
                            <?php foreach($eselon as $e){ ?>
                                <span id="btn_filter_eselon_<?=$e['id_eselon']?>" onclick="filterClicked('eselon_<?=$e['id_eselon']?>')"
                                class="filter-btn filter-unselect"><?=$e['nm_eselon']?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="label-filter">Golongan</label>
                        <div class="filter-option">
                            <?php foreach($golongan as $g){ ?>
                                <span id="btn_filter_golongan_<?=$g['id_golongan']?>" onclick="filterClicked('golongan_<?=$g['id_golongan']?>')"
                                class="filter-btn filter-unselect"><?=$g['nm_golongan']?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <label class="label-filter">Pangkat</label>
                        <div class="filter-option">
                            <?php foreach($pangkat as $p){ ?>
                                <span id="btn_filter_pangkat_<?=$p['id_pangkat']?>" onclick="filterClicked('pangkat_<?=$p['id_pangkat']?>')"
                                class="filter-btn filter-unselect"><?=$p['nm_pangkat']?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-3">
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
                <!-- <div class="col-lg-12">
                    <button onclick="loadDataLiveAbsen()" class="btn btn-sm btn-navy">Cari</button>
                </div> -->
            </div>
            <div class="col-lg-12"><hr></div>
            <div class="col-lg-12 table-responsive" id="div_data_absen"></div>
        </div>
    </div>
</div>

<script>
    let eselon = [];
    let pangkat = [];
    let golongan = [];
    // setInterval(loadDataLiveAbsen, 5000);
    
    $(function(){
        $('.select2-navy').select2()
        loadDataLiveAbsen()
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
        loadDataLiveAbsen()
    }

    function loadDataLiveAbsen(){
        $.ajax({
            url: '<?=base_url("dashboard/C_Dashboard/getDataLiveAbsen/11")?>',
            method: 'post',
            data: {
                eselon: eselon,
                golongan: golongan,
                pangkat: pangkat,
                unitkerja: $('#unitkerja').val(),
            },
            success: function(data){
                $('#div_data_absen').html('')
                $('#div_data_absen').append(data)
                loadDataLiveAbsen()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
            }
        })
    }
</script>