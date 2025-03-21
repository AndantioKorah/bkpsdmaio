<style>
    .nav-link-profile{
      padding: 5px !important;
      font-size: .7rem;
      color: black;
      border: .5px solid var(--primary-color) !important;
      border-bottom-left-radius: 0px;
    }

    .nav-item-profile:hover, .nav-link-profile:hover{
      color: white !important;
      background-color: #222e3c91;
    }

    .nav-tabs .nav-link.active, .nav-tabs .show>.nav-link{
      /* border-radius: 3px; */
      background-color: var(--primary-color);
      color: white;
    }

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
        <h5 class="card-title">BROADCAST WHATSAPP</h5>
        <hr>
    </div>
    <div class="card-body" style="margin-top: -30px;">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item nav-item-profile" role="presentation">
                        <button class="nav-link nav-link-profile active" id="pills-form-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-form" type="button" role="tab" aria-controls="pills-home" aria-selected="true">FORM</button>
                    </li>
                    <li>
                        <button class="nav-link nav-link-profile" id="pills-monitoring-tab" data-bs-toggle="pill" onclick="loadBroadcastHistory()"
                            data-bs-target="#pills-monitoring" type="button" role="tab" aria-controls="pills-home" aria-selected="true">MONITORING</button>
                    </li>
                </ul>
            </div>
            <div class="col-lg-12">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane show active" id="pills-form" role="tabpanel" aria-labelledby="pills-form-tab">
                        <form id="form_search">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="label-filter">Nama Pegawai</label>
                                            <div class="filter-option">
                                                <input value="" style="margin-top: -5px;" class="form-control" name="nama_pegawai" id="nama_pegawai" />
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="label-filter">Jenis Jabatan</label>
                                            <div class="filter-option">
                                                <?php foreach($jenis_jabatan as $e){ ?>
                                                    <span id="btn_filter_jenis_jabatan_<?=$e['id_jenis_jabatan']?>" onclick="filterClicked('jenis_jabatan_<?=$e['id_jenis_jabatan']?>')"
                                                    class="filter-btn filter-unselect"><?=$e['nm_jenis_jabatan']?></span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-2">
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
                                        <div class="col-lg-12 mt-2">
                                            <label class="label-filter">Jabatan Fungsional</label>
                                            <div class="">
                                                <select multiple="multiple" class="form-control select2-navy" 
                                                    id="jft" data-dropdown-css-class="select2-navy" name="jft" required>
                                                    <option value="0" selected>Semua</option>
                                                    <option value="991">Semua Ahli Utama</option>
                                                    <option value="992">Semua Ahli Madya</option>
                                                    <option value="993">Semua Ahli Muda</option>
                                                    <option value="994">Semua Ahli Pertama</option>
                                                    <option value="995">Semua Penyelia</option>
                                                    <option value="996">Semua Mahir</option>
                                                    <option value="997">Semua Terampil</option>
                                                    <option value="998">Semua Pemula</option>
                                                    <?php foreach($jft as $u){ ?>
                                                        <option value="<?=$u['id_jabatanpeg']?>"><?=$u['nama_jabatan']?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="label-filter">Unit Kerja</label>
                                            <div class="">
                                                <select class="form-control select2-navy" 
                                                    id="unitkerja" data-dropdown-css-class="select2-navy" name="unitkerja" required>
                                                    <option value="0" selected>Semua</option>
                                                    <?php foreach($unitkerja as $u){ ?>
                                                        <option value="<?=$u['id_unitkerja']?>"><?=$u['nm_unitkerja']?></option>
                                                    <?php } ?>
                                                    <option value="990" >Semua TK</option>
                                                    <option value="991" >Semua SD</option>
                                                    <option value="992" >Semua SMP</option>
                                                    <option value="993" >Semua UPTD Dinas kesehatan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <label class="label-filter">Satyalencana</label>
                                            <div class="filter-option">
                                                <?php foreach($satyalencana as $sl){ ?>
                                                    <span id="btn_filter_satyalencana_<?=$sl['masa_kerja']?>" onclick="filterClicked('satyalencana_<?=$sl['masa_kerja']?>')"
                                                    class="filter-btn btn-filter-satyalencana filter-unselect"><?=$sl['nama_satya_lencana']?></span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-2">
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
                                            <label class="label-filter">Keterangan Pegawai</label>
                                            <div class="filter-option">
                                                <?php foreach($keteranganpegawai as $kp){ ?>
                                                    <span id="btn_filter_keteranganpegawai_<?=$kp['id']?>" onclick="filterClicked('keteranganpegawai_<?=$kp['id']?>')"
                                                    class="filter-btn filter-unselect"><?=$kp['nama_status_pegawai']?></span>
                                                <?php } ?>
                                            
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
                    <div class="tab-pane fade" id="pills-monitoring" role="tabpanel" aria-labelledby="pills-monitoring-tab">
                        <div id="div_broadcast"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-default mt-2" id="div_result">
</div>

<div class="modal fade" id="broadcast_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" 
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">BROADCAST WHATSAPP</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="broadcast_modal_content">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="broadcast_monitoring_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" 
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">BROADCAST WHATSAPP</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="broadcast_monitoring_modal_content">
            </div>
        </div>
    </div>
</div>

<script>
    let eselon = [];
    let statuspeg = [];
    let tktpendidikan = [];
    let jeniskelamin = [];
    let pangkat = [];
    let golongan = [];
    let agama = [];
    let satyalencana = [];
    let jenis_jabatan = [];
    let keteranganpegawai = [];
    $(function(){
        // $('#form_search').submit()
        $('.select2-navy').select2()
    })
    
    function loadBroadcastHistory(){
        $('#div_broadcast').html('')
        $('#div_broadcast').append(divLoaderNavy)
        $('#div_broadcast').load('<?=base_url('admin/C_Admin/loadBroadcastHistory')?>', function(){

        })
    }

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
            } else if(jenis[1] == 'kelamin'){
                jeniskelamin.push(jenis[2])
            } else if(jenis[0] == 'statuspeg'){
                statuspeg.push(jenis[1])
            } else if(jenis[0] == 'agama'){
                agama.push(jenis[1])
            } else if(jenis[0] == 'tktpendidikan'){
                tktpendidikan.push(jenis[1])
            } else if(jenis[1] == 'jabatan'){
                jenis_jabatan.push(jenis[2])
            } else if(jenis[0] == 'satyalencana'){
                satyalencana = []
                satyalencana.push(jenis[1])
            } else if(jenis[0] == 'pangkat'){
                pangkat.push(jenis[1])
            } else if(jenis[0] == 'golongan'){
                golongan.push(jenis[2])
            } else if(jenis[0] == 'keteranganpegawai'){
                keteranganpegawai.push(jenis[1])
            }
        } else {
            $('#btn_filter_'+btn).addClass('filter-unselect')
            $('#btn_filter_'+btn).removeClass('filter-select')
            if(jenis[0] == 'eselon'){
                eselon = eselon.filter(function(e){
                    return e !== jenis[1]
                })
            } else if(jenis[1] == 'kelamin'){
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
            } else if(jenis[0] == 'satyalencana'){
                satyalencana = satyalencana.filter(function(e){
                    return e !== jenis[1]
                })
            } else if(jenis[1] == 'jabatan'){
                jenis_jabatan = jenis_jabatan.filter(function(e){
                    return e !== jenis[2]
                })
            } else if(jenis[0] == 'pangkat'){
                pangkat = pangkat.filter(function(e){
                    return e !== jenis[1]
                })
            } else if(jenis[0] == 'golongan'){
                golongan = golongan.filter(function(e){
                    return e !== jenis[2]
                })
            } else if(jenis[0] == 'keteranganpegawai'){
                keteranganpegawai = keteranganpegawai.filter(function(e){
                    return e !== jenis[1]
                })
            }
        }
    }

    $('#form_search').on('submit', function(e){
        $('#btn_loading').show()
        $('#btn_search').hide()
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("admin/C_Admin/searchAllPegawai/")?>',
            method: 'post',
            data: {
                eselon: eselon,
                tktpendidikan: tktpendidikan,
                golongan: golongan,
                jeniskelamin: jeniskelamin,
                pangkat: pangkat,
                agama: agama,
                statuspeg: statuspeg,
                satyalencana: satyalencana,
                jenis_jabatan: jenis_jabatan,
                keteranganpegawai: keteranganpegawai,
                unitkerja: $('#unitkerja').val(),
                jft: $('#jft').val(),
                nama_pegawai: $('#nama_pegawai').val()
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