
<?php if(isset($skpd)) { ?>
    <?php if(isset($json_result)) { ?>
<form target="blank" action="<?=base_url('rekap/C_Rekap/downloadPdf')?>" enctype="multipart/form-data" method="post">
<input type="hidden" autocomplete="off" class="form-control" id="skpd" name="skpd" value="<?= $data_search['skpd']; ?>" />
<input type="hidden" autocomplete="off" class="form-control" id="tahun" name="tahun" value="<?= $data_search['tahun']; ?>" />
<input type="hidden" autocomplete="off" class="form-control" id="bulan" name="bulan" value="<?= $data_search['bulan']; ?>" />
<button class="btn btn-sm btn-navy" type="submit"><i class="fa fa-download"></i> Download as PDF</button>
                    </form>
<?php } ?>
        <div class="col-lg-12" style="width: 100%; margin-top: -35px;">
            <!-- <form action="<?=base_url('rekap/C_Rekap/rekapPenilaianSearch/1')?>" method="post" target="_blank"> -->
                <!-- <center><h5><strong>REKAPITULASI PENILAIAN DISIPLIN KERJA</strong></h5></center> -->
                <br>
                <div class="col-lg-12 row">
                    <div class="col-lg-4">
                        <form action="<?=base_url('rekap/C_Rekap/downloadBerkasTpp')?>" target="_blank" method="post">
                            <input style="display: none;" autocomplete="off" class="form-control" id="skpd" name="skpd" value="<?= $data_search['skpd']; ?>" />
                            <input style="display: none;" autocomplete="off" class="form-control" id="tahun" name="tahun" value="<?= $data_search['tahun']; ?>" />
                            <input style="display: none;" autocomplete="off" class="form-control" id="bulan" name="bulan" value="<?= $data_search['bulan']; ?>" />
                            <?php // if($this->general_library->isProgrammer()){ ?>
                            <?php if($data_search['tahun'] <= 2024){ ?>
                                <button id="btn_download_berkas" type="submit" class="btn btn-block btn-danger">
                                    <i class="fa fa-download"></i> Download as PDF
                                </button>
                            <?php } else { ?>
                                <h5 style="font-weight: bold; color: red;">Rekap TPP belum dapat dilakukan karena masih menunggu KEPWAL terbaru</h5>
                            <?php } ?>
                            <?php // } ?>
                        </form>
                    </div>
                    <?php if($data_format_excel){ ?>
                        <div class="col-lg-4">
                            <form action="<?=base_url('rekap/C_Rekap/formatTppBkadDownload/'.$data_format_excel['id'])?>" method="post" target="_blank">
                                <input style="display: none;" autocomplete="off" class="form-control" id="skpd" name="skpd" value="<?= $data_search['skpd']; ?>" />
                                <input style="display: none;" autocomplete="off" class="form-control" id="tahun" name="tahun" value="<?= $data_search['tahun']; ?>" />
                                <input style="display: none;" autocomplete="off" class="form-control" id="bulan" name="bulan" value="<?= $data_search['bulan']; ?>" />
                                <?php // if($this->general_library->isProgrammer()){ ?>
                                <?php if($data_search['tahun'] <= 2024){ ?>
                                    <button id="btn_download_berkas" type="submit" class="btn btn-block btn-success">
                                        <i class="fa fa-download"></i> Download Format Excel
                                    </button>
                                <?php } else { ?>
                                    <h5 style="font-weight: bold; color: red;">Rekap TPP belum dapat dilakukan karena masih menunggu Kepwal terbaru</h5>
                                <?php } ?>
                                <?php // } ?>
                            </form>
                        </div>
                    <?php } ?>
                    <?php if($tpp_tambahan){ ?>
                        <div class="btn-group col-lg-4" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-block btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            TPP TAMBAHAN
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <?php foreach($tpp_tambahan as $tt) {?>
                                    <form action="<?=base_url('rekap/C_Rekap/downloadBerkasTpp/'.$tt['id'])?>" target="_blank" method="post">
                                        <input style="display: none;" autocomplete="off" class="form-control" id="skpd" name="skpd" value="<?= $data_search['skpd']; ?>" />
                                        <input style="display: none;" autocomplete="off" class="form-control" id="tahun_<?=$tt['id']?>" name="tahun" value="<?= $tt['tahun']; ?>" />
                                        <input style="display: none;" autocomplete="off" class="form-control" id="bulan_<?=$tt['id']?>" name="bulan" value="<?= $tt['bulan']; ?>" />
                                        <input style="display: none;" autocomplete="off" class="form-control" id="presentasi_tpp_tambahan_<?=$tt['id']?>" name="presentasi_tpp_tambahan" value="<?= $tt['presentasi_tpp_tambahan']; ?>" />
                                        <input style="display: none;" autocomplete="off" class="form-control" id="nama_tpp_tambahan_<?=$tt['id']?>" name="nama_tpp_tambahan" value="<?= $tt['nama_tpp_tambahan']; ?>" />
                                        <a class="dropdown-item"><button id="btn_download_berkas" type="submit" class="btn btn-block btn-info">
                                            <i class="fa fa-download"></i> <?=$tt['nama_tpp_tambahan']?>
                                        </button></a>
                                    </form>
                                <?php } ?>
                                <!-- <a class="dropdown-item" href="#">Dropdown link</a> -->
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <table style="width: 100%; position: relative;">
                    <tr>
                        <td>SKPD</td>
                        <td>:</td>
                        <td><?=$skpd?></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>:</td>
                        <td><?=getNamaBulan($bulan).' '.$tahun?></td>
                    </tr>
                    <tr>
                        <td>Jenis File</td>
                        <td>:</td>
                        <td>
                            <select class="form-control select2-navy" style="width: 100%"
                                id="jenis_file" data-dropdown-css-class="select2-navy" name="jenis_file">
                                <option value="absen">Rekap Absensi</option> 
                                <option selected value="kehadiran">Rekap Kehadiran</option> <!-- belum  -->
                                <option value="penilaian_disiplin_kerja">Rekap Penilaian Disiplin Kerja</option>
                                <option value="produktivitas_kerja">Rekap Produktivitas Kerja</option>
                                <option value="daftar_penilaian_tpp">Rekap Penilaian TPP</option> <!-- belum  -->
                                <option value="daftar_perhitungan_tpp">Daftar Perhitungan TPP</option>
                                <option value="daftar_permintaan">Daftar Permintaan</option>
                                <option value="daftar_permintaan_bkad">Daftar Permintaan (BKAD)</option>
                                <option value="daftar_pembayaran">Daftar Pembayaran</option>
                                <option value="surat_pengantar">Surat Pengantar</option>
                                <option value="salinan_surat_pengantar">Salinan Surat Pengantar</option>
                            </select>    
                        </td>
                    </tr>
                </table>
            <!-- </form> -->
        </div>
        <div class="col-lg-12 table-responsive mt-3" style="width: 100%; height: 70vh; overflow: auto;" id="result_rekap_div">
        
        </div>
        <script>
            $(function(){
                $('#jenis_file').select2()
                loadViewByJenisFile()
            })

            $('#jenis_file').on('change', function(){
                loadViewByJenisFile()
            })

            // $('.form_download_berkas_tpp').on('submit', function(e){
            //     e.preventDefault()
            //     $('#btn_download_berkas').hide()
            //     $('#btn_download_berkas_loading').show()
            //     $.ajax({
            //         url: '<?=base_url("rekap/C_Rekap/downloadBerkasTpp")?>',
            //         method: 'post',
            //         data: $(this).serialize(),
            //         success: function(data){
            //             $('#btn_download_berkas').show()
            //             $('#btn_download_berkas_loading').hide()
            //         }, error: function(e){
            //             errortoast('Terjadi Kesalahan')
            //             $('#btn_download_berkas').show()
            //             $('#btn_download_berkas_loading').hide()
            //         }
            //     })
            // })

            function loadViewByJenisFile(){
                $('#result_rekap_div').html('')
                $('#result_rekap_div').append(divLoaderNavy)
                $('#result_rekap_div').load('<?=base_url("rekap/C_Rekap/loadViewByJenisFile/")?>'+$('#jenis_file').val(), function(){
                    $('#loader').hide()
                })
            }
        </script>
<?php } else { ?>
    <h5>Data Absen Tidak Ditemukan <i class="fa fa-exclamation"></i></h5>
<?php } ?>