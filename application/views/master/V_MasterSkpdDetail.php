<?php if($result){ ?>
    <style>
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            font-weight: bold;
            border-radius: 0;
        }

        .nav-tabs .nav-link {
            /* background-color: #f8f8f8; */
            border-color: var(--primary-color);
            border-top-left-radius: var(--bs-nav-tabs-border-radius);
            border-top-right-radius: var(--bs-nav-tabs-border-radius);
            color: var(--primary-color);
            border-radius: 0;
            padding: .5rem;
            /* margin-left: -5px; */
        }

        .class_kepalaskpd:hover{
            background-color: #efefef;
            cursor: pointer;
            border-radius: 5px;
            transition: .2s;
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default p-3">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Profile</button>
                    </li>
                    <li class="nav-item" onclick="openListPegawai()" role="presentation">
                        <button class="nav-link" id="pegawai-tab" data-bs-toggle="tab" data-bs-target="#pegawai" type="button" role="tab" aria-controls="Pegawai" aria-selected="true">Pegawai</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-lg-12">
                                <table style="width: 100%;" class="mt-4">
                                    <tr>
                                        <td style="width: 35%; padding: 12px;">
                                            <div class="row">
                                                <div style="
                                                    top: 0;
                                                    position: relative;
                                                    background-color: var(--primary-color);
                                                    color: white;
                                                    font-size: .9rem;
                                                    border-radius: 15px;"
                                                    class="col-lg-12">
                                                    <center>KEPALA SKPD</center>
                                                </div>
                                                <div class="col-lg-12 mt-2 <?=isset($result['kepala_skpd']) && $result['kepala_skpd'] ? 'class_kepalaskpd' : ''?>">
                                                    <center>
                                                        <?php if($result['kepala_skpd']){ ?>
                                                            <!-- <img style="width: 128px; height: 128px" class="img-fluid rounded-circle mb-2 b-lazy"
                                                            src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== data-src="<?=$this->general_library->getFotoPegawai($result['kepala_skpd']['fotopeg'])?>" /> -->
                                                            <img style="width: 128px; height: 128px" class="img-fluid rounded-circle mb-2 b-lazy"
                                                            src="<?php
                                                                $path = './assets/fotopeg/'.$result['kepala_skpd']['fotopeg'];
                                                                // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                                                if($result['kepala_skpd']['fotopeg']){
                                                                if (file_exists($path)) {
                                                                $src = './assets/fotopeg/'.$result['kepala_skpd']['fotopeg'];
                                                                //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                                                } else {
                                                                $src = './assets/img/user.png';
                                                                // $src = '../siladen/assets/img/user.png';
                                                                }
                                                                } else {
                                                                $src = './assets/img/user.png';
                                                                }
                                                                echo base_url().$src;?>" /> 
                                                        <?php } else { ?>
                                                            <img style="width: 128px; height: 128px" class="img-fluid rounded-circle mb-2 b-lazy"
                                                            src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== data-src="<?=$this->general_library->getFotoPegawai('default')?>" />
                                                        <?php } ?>
                                                        <br>
                                                        <span style="font-weight: bold; font-size: 1rem;"><?=$result['kepala_skpd'] ? getNamaPegawaiFull($result['kepala_skpd']) : ''?></span>
                                                        <br>
                                                        <span style="font-weight: bold; font-size: .8rem;"><?=$result['kepala_skpd'] ? formatNip($result['kepala_skpd']['nipbaru_ws']) : ''?></span>
                                                        <br>
                                                        <span style="font-weight: bold; font-size: .8rem;"><?=$result['kepala_skpd'] ? ($result['kepala_skpd']['nm_pangkat']) : ''?></span>
                                                    </center>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 65%;">
                                            <div class="row ml-3">
                                                <div class="col-lg-12" style="font-size: .8rem;">Nama Perangkat Daerah:</div>
                                                <div class="col-lg-12 fw-bold" style="font-size: 1rem;"><?=$result['list_pegawai'][0]['nm_unitkerja'] ? $result['list_pegawai'][0]['nm_unitkerja'] : '-' ?></div>
                                                <div class="col-lg-12" style="margin: -10px;"><hr></div>
                                            </div>
                                            <div class="row ml-3">
                                                <div class="col-lg-12" style="font-size: .8rem;">Alamat:</div>
                                                <div class="col-lg-12 fw-bold" style="font-size: 1rem;"><?=$result['list_pegawai'][0]['alamat_uk'] ? $result['list_pegawai'][0]['alamat_uk'] : '-' ?></div>
                                                <div class="col-lg-12" style="margin: -10px;"><hr></div>
                                            </div>
                                            <div class="row ml-3">
                                                <div class="col-lg-12" style="font-size: .8rem;">Nomor Telepon:</div>
                                                <div class="col-lg-12 fw-bold" style="font-size: 1rem;"><?=$result['list_pegawai'][0]['notelp_uk'] ? $result['list_pegawai'][0]['notelp_uk'] : '-' ?></div>
                                                <div class="col-lg-12" style="margin: -10px;"><hr></div>
                                            </div>
                                            <div class="row ml-3">
                                                <div class="col-lg-12" style="font-size: .8rem;">Email:</div>
                                                <div class="col-lg-12 fw-bold" style="font-size: 1rem;"><?=$result['list_pegawai'][0]['email_uk'] ? $result['list_pegawai'][0]['email_uk'] : '-' ?></div>
                                                <div class="col-lg-12" style="margin: -10px;"><hr></div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0 ml-0">
                                                <h5 class="card-title">Jumlah Pegawai</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle fa fa-users" ></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3" id="h1_total_pegawai"><?=$result['total']?></h1>
                                        <div class="mb-0">
                                            <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span> -->
                                            <!-- <span class="text-muted">Per Tahun <?=date('Y')?></span> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div onclick="openPensiunCardDetail()" class="card info_card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0 ml-0">
                                                        <h5 class="card-title">Pensiun</h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="stat text-primary">
                                                            <i class="align-middle fa fa-user-slash" ></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="mt-1 mb-3" id="h1_pensiun"><i class="fa fa-spin fa-spinner"></i></h1>
                                                <div class="mb-0">
                                                    <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span> -->
                                                    <!-- <span class="text-muted">Tahun <?=date('Y')?></span> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div onclick="openNaikPangkatCardDetail()" class="card info_card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0 ml-0">
                                                        <h5 class="card-title">Naik Pangkat</h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="stat text-primary">
                                                            <i class="align-middle fa fa-upload" ></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="mt-1 mb-3" id="h1_pangkat"><i class="fa fa-spin fa-spinner"></i></h1>
                                                <div class="mb-0">
                                                    <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span> -->
                                                    <!-- <span class="text-muted">Tahun <?=date('Y')?></span> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div onclick="openGajiBerkalaCardDetail()" class="card info_card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0 ml-0">
                                                        <h5 class="card-title">Gaji Berkala</h5>
                                                    </div>
                                                    <div class="col-auto">
                                                    <div class="stat text-primary">
                                                        <i class="align-middle fa fa-money-bill" ></i>
                                                    </div>
                                                    </div>
                                                </div>
                                                <h1 class="mt-1 mb-3" id="h1_gaji_berkala"><i class="fa fa-spin fa-spinner"></i></h1>
                                                <div class="mb-0">
                                                    <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span> -->
                                                    <!-- <span class="text-muted">Tahun <?=date('Y')?></span> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 mt-0 ml-0">
                                                <h5 class="card-title">Jenis Kelamin</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php
                                            $data_jenis_kelamin['result'] = $result['jenis_kelamin'];
                                            $data_jenis_kelamin['id_chart'] = 'chart_jenis_kelamin';
                                            $this->load->view('master/V_ChartPieDetailSkpd', $data_jenis_kelamin);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0 ml-0">
                                                <h5 class="card-title">Agama</h5>
                                            </div>
                                            <div class="col-auto">
                                                <!-- <div class="stat text-primary">
                                                    <i class="align-middle fa fa-users" ></i>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php
                                                $data_agama['result'] = $result['agama'];
                                                $data_agama['id_chart'] = 'chart_agama';
                                                $this->load->view('master/V_ChartPieDetailSkpd', $data_agama);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0 ml-0">
                                                <h5 class="card-title">Status Pegawai</h5>
                                            </div>
                                            <div class="col-auto">
                                            <!-- <div class="stat text-primary">
                                                <i class="align-middle fa fa-users" ></i>
                                            </div> -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php
                                                $data_statuspeg['result'] = $result['statuspeg'];
                                                $data_statuspeg['id_chart'] = 'chart_statuspeg';
                                                $this->load->view('master/V_ChartPieDetailSkpd', $data_statuspeg);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0 ml-0">
                                                <h5 class="card-title">Golongan</h5>
                                            </div>
                                            <div class="col-auto">
                                            <!-- <div class="stat text-primary">
                                                <i class="align-middle fa fa-users" ></i>
                                            </div> -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php
                                                $data_golongan['result'] = $result['golongan'];
                                                $data_golongan['id_chart'] = 'chart_golongan';
                                                $this->load->view('master/V_ChartPieDetailSkpd', $data_golongan);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0 ml-0">
                                                <h5 class="card-title">Eselon</h5>
                                            </div>
                                            <div class="col-auto">
                                                <!-- <div class="stat text-primary">
                                                    <i class="align-middle fa fa-users" ></i>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php
                                                $data_eselon['result'] = $result['eselon'];
                                                $data_eselon['id_chart'] = 'chart_eselon';
                                                $this->load->view('master/V_ChartPieDetailSkpd', $data_eselon);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0 ml-0">
                                                <h5 class="card-title">Pendidikan</h5>
                                            </div>
                                            <div class="col-auto">
                                                <!-- <div class="stat text-primary">
                                                    <i class="align-middle fa fa-users" ></i>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php
                                                $data_pendidikan['result'] = $result['pendidikan'];
                                                $data_pendidikan['id_chart'] = 'chart_pendidikan';
                                                $this->load->view('master/V_ChartPieDetailSkpd', $data_pendidikan);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pegawai" role="tabpanel" aria-labelledby="pegawai-tab">                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?=base_url('')?>assets/adminkit/js/app.js"></script>

    <script>
        $(function(){
            getJumlahPensiun()
            getJumlahNaikpangkat()
            getJumlahGajiBerkala()
            renderChart('<?=json_encode($data_jenis_kelamin)?>')
            renderChart('<?=json_encode($data_agama)?>')
            renderChart('<?=json_encode($data_statuspeg)?>')
            renderChart('<?=json_encode($data_golongan)?>')
            renderChart('<?=json_encode($data_eselon)?>')
            renderChart('<?=json_encode($data_pendidikan)?>')
        })

        function openListPegawai(){
            $('#pegawai').html('')
            $('#pegawai').append(divLoaderNavy)
            $('#pegawai').load('<?=base_url("master/C_Master/openListPegawaiDetailSkpd")?>', function(){
                $('#loader').hide()
            })
        }

        <?php if($result['kepala_skpd']){ ?>
            $('.class_kepalaskpd').on('click', function(){
                window.location="<?=base_url('kepegawaian/profil-pegawai/'.$result['kepala_skpd']['nipbaru_ws'])?>"
            })
        <?php } ?>

        function renderChart(rs){
            let dt = JSON.parse(rs)
            // document.addEventListener("DOMContentLoaded", function() {
                let labels = [];
                let values = [];
                let temp = Object.keys(dt.result)
                temp.forEach(function(i) {
                    if(dt.result[i].jumlah > 0){
                        labels.push(dt.result[i].nama)
                        values.push(dt.result[i].jumlah)
                    }
                })
                console.log(labels)

                let colors = JSON.parse('<?=json_encode(CHART_COLORS)?>')                
                // let data_labels = 
                new Chart(document.getElementById(dt.id_chart), {
                    type: "doughnut",
                    data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                backgroundColor: colors,
                                borderColor: "transparent"
                            }]
                    },
                    options: {
                            maintainAspectRatio: false,
                            legend: {
                                display: false
                            }
                    }
                });
            // });
        }
        function getJumlahPensiun(){
            $('#h1_pensiun').html('<i class="fa fa-spin fa-spinner"></i>')
            $.ajax({
                url: '<?=base_url("user/C_User/getListPegawaiPensiunByYear/1")?>',
                method: 'post',
                data: {
                    eselon: 0,
                    pangkat: 0,
                    tahun: '<?=date('Y')?>',
                    skpd: '<?=$id_unitkerja?>'
                },
                success: function(data){
                let rs = JSON.parse(data)
                // console.log(data)
                $('#h1_pensiun').html(rs.total)
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                    console.log(e)
                }
            })
        }

        function getJumlahNaikpangkat(){
            $('#h1_pangkat').html('<i class="fa fa-spin fa-spinner"></i>')
            $.ajax({
                url: '<?=base_url("user/C_User/getListPegawaiNaikPangkatByYear/1")?>',
                method: 'post',
                data: {
                    eselon: 0,
                    pangkat: 0,
                    tahun: '<?=date('Y')?>',
                    skpd: '<?=$id_unitkerja?>'
                },
                success: function(data){
                let rs = JSON.parse(data)
                // console.log(data)
                $('#h1_pangkat').html(rs.total)
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                    console.log(e)
                }
            })
        }

        function getJumlahGajiBerkala(){
            $('#h1_gaji_berkala').html('<i class="fa fa-spin fa-spinner"></i>')
            $.ajax({
                url: '<?=base_url("user/C_User/getListPegawaiGajiBerkalaByYear/1")?>',
                method: 'post',
                data: {
                    eselon: 0,
                    pangkat: 0,
                    tahun: '<?=date('Y')?>',
                    skpd: '<?=$id_unitkerja?>'
                },
                success: function(data){
                let rs = JSON.parse(data)
                // console.log(data)
                $('#h1_gaji_berkala').html(rs.total)
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                    console.log(e)
                }
            })
        }

    </script>
<?php } ?>