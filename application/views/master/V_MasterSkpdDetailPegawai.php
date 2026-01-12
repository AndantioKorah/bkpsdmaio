<?php if($result) { ?>
    <style>
        .label_tabel{
            font-style: italic;
            font-size: .65rem;
            color: grey;
        }

        .value_tabel{
            font-size: .8rem;
            color: black;
            font-weight: bold;
        }

        .sec_value{
            font-size: .75rem;
            font-weight: 500;
        }

        .table_data{
            line-height: .9rem;
        }

        .div_item{
            border: 1px solid;
            padding-top: 10px;
            padding-bottom: 5px;
            margin-left: 0px;
            margin-right: 0px;
            border-radius: 5px;
        }

        .div_item:hover{
            background-color: #f4f4f4;
            cursor: pointer;
            transition: .2s;
        }

        .span_jumlah_option{
            font-size: .7rem !important;
            color: grey !important;
            font-style: italic !important;
        }

        #div_result{
            /* max-height: 400px;
            overflow-y: scroll;
            overflow-x: hidden; */
        }
    </style>
    <div class="p-3 bg-white">
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <button id="btn_filter" class="btn btn-sm btn-navy">Filter Pegawai <i class="fa fa-filter"></i></button>
                    </div>
                    <div class="col-lg-12">
                        <form id="form_cari" style="display:none;" class="form-group mt-2">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label class="label-group">Jenis Kelamin</label>
                                    <select class="form-control form-control-sm select2-navy" style="width: 100%"
                                        id="jenis_kelamin" data-dropdown-css-class="select2-navy" name="jenis_kelamin">
                                        <option value="0" selected>
                                            Semua
                                        </option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="label-group">Agama</label>
                                    <select class="form-control form-control-sm select2-navy" style="width: 100%"
                                        id="agama" data-dropdown-css-class="select2-navy" name="agama">
                                        <option value="0" selected>
                                            Semua
                                        </option>
                                        <?php foreach($result['agama'] as $a){ if($a['jumlah'] > 0){ ?>
                                            <option value="<?=$a['id_agama']?>"><?=$a['nama']?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="label-group">Status Pegawai</label>
                                    <select class="form-control form-control-sm select2-navy" style="width: 100%"
                                        id="status_pegawai" data-dropdown-css-class="select2-navy" name="status_pegawai">
                                        <option value="0" selected>
                                            Semua
                                        </option>
                                        <?php foreach($result['statuspeg'] as $sp){ if($sp['jumlah'] > 0){ ?>
                                            <option value="<?=$sp['id_statuspeg']?>"><?=$sp['nama']?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="label-group">Golongan</label>
                                    <select class="form-control form-control-sm select2-navy" style="width: 100%"
                                        id="golongan" data-dropdown-css-class="select2-navy" name="golongan">
                                        <option value="0" selected>
                                            Semua
                                        </option>
                                        <?php foreach($result['golongan'] as $g){ if($g['jumlah'] > 0){ ?>
                                            <option value="<?=$g['id_golongan']?>"><?=$g['nama']?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label class="label-group">Eselon</label>
                                    <select class="form-control form-control-sm select2-navy" style="width: 100%"
                                        id="eselon" data-dropdown-css-class="select2-navy" name="eselon">
                                        <option value="0" selected>
                                            Semua
                                        </option>
                                        <?php foreach($result['eselon'] as $e){ if($e['jumlah'] > 0){ ?>
                                            <option value="<?=$e['nama']?>"><?=$e['nama']?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label class="label-group">Pendidikan</label>
                                    <select class="form-control form-control-sm select2-navy" style="width: 100%"
                                        id="pendidikan" data-dropdown-css-class="select2-navy" name="pendidikan">
                                        <option value="0" selected>
                                            Semua
                                        </option>
                                        <?php foreach($result['pendidikan'] as $pend){ if($pend['jumlah'] > 0){ ?>
                                            <option value="<?=$pend['id_tktpendidikan']?>"><?=$pend['nama']?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label class="label-group">Jenis Jabatan</label>
                                    <select class="form-control form-control-sm select2-navy" style="width: 100%"
                                        id="jenis_jabatan" data-dropdown-css-class="select2-navy" name="jenis_jabatan">
                                        <option value="0" selected>Semua</option>
                                        <option value="Struktural">Struktural</option>
                                        <option value="JFT">JFT</option>
                                        <option value="JFU">JFU</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label class="label-group">Nama Pegawai</label>
                                    <input autocomplete="off" id="nama_pegawai" class="form-control" name="nama_pegawai" />
                                </div>
                                <div class="col-lg-12"></div>
                                <input style="display:none;" name="id_unitkerja" value="<?=$result['list_pegawai'][0]['id_unitkerja']?>" />
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-12">
                        <hr>
                        <h5 class="" style="font-weight: bold; font-style: italic;">Jabatan Fungsional</h5>
                        <?php if($result['list_jft']){ ?>
                            <table class="table table-sm" style="border: 1px black solid;" border-collapse="collapse">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Jabatan</th>
                                    <th class="text-center">Kelas Jabatan</th>
                                    <th class="text-center">Jumlah</th>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($result['list_jft'] as $lj){ ?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="text-left"><?=$lj['nama_jabatan']?></td>
                                            <td class="text-center"><?=$lj['kelas_jabatan']?></td>
                                            <td class="text-center"><?=$lj['total']?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <hr>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12" id="div_result">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('.select2-navy').select2()
            loadSemuaPegawai()
        })

        $('#jenis_kelamin').on('change', function(){
            $('#form_cari').submit()
        })

        $('#agama').on('change', function(){
            $('#form_cari').submit()
        })

        $('#status_pegawai').on('change', function(){
            $('#form_cari').submit()
        })

        $('#eselon').on('change', function(){
            $('#form_cari').submit()
        })

        $('#pendidikan').on('change', function(){
            $('#form_cari').submit()
        })

        $('#golongan').on('change', function(){
            $('#form_cari').submit()
        })

        $('#nama_pegawai').on('input', function(){
            $('#form_cari').submit()
        })

        $('#jenis_jabatan').on('change', function(){
            $('#form_cari').submit()
        })

        $('#form_cari').on('submit', function(e){
            e.preventDefault()
            $('#div_result').html('')
            $('#div_result').append(divLoaderNavy)
            $.ajax({
                url: '<?=base_url("master/C_Master/searchPegawaiSkpdByFilter/")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(data){
                    $('#div_result').html(data)
                    $('#loader').hide()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                    console.log(e)
                }
            })
        })

        function loadSemuaPegawai(){
            $('#div_result').html('')
            $('#div_result').append(divLoaderNavy)
            $('#div_result').load('<?=base_url("master/C_Master/loadSkpdDetailPegawai")?>', function(){
                $('#loader').hide()
            })
        }

        $('#btn_filter').on('click', function(){
            $('#form_cari').toggle({
                height: true,
                width: true
            })
        })
    </script>
<?php } ?>