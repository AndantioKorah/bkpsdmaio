<style>
    .lbl_value_detail_cuti{
        font-weight: bold;
        font-size: .9rem;
        color: black;
    }
</style>
<div class="row">
    <?php if($result['code'] == 1){ ?>
        <div class="col-lg-12 text-center">
            <span style="
                font-size: 2rem;
                font-weight: bold;
                color: red;
            "
            ><i class="fa fa-times"></i> <?=$result['message']?></span>
        </div>
    <?php } else { ?>
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title"><h3>VERIFIKASI CUTI</h3></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if($result['data']){ ?>
                        <div class="col-lg-12 text-left mb-3">
                            <?php foreach($result['data']['progress'] as $p){ ?>
                            <span style="
                                background-color: <?=$p['color']?>;
                                padding: 2px;
                                border-radius: 5px;
                                font-weight: bold;
                                margin-bottom: 5px;
                                font-size: .9rem;
                                color: <?=$p['font-color']?>
                            "><i class="<?=$p['icon']?>"></i> <?=$p['keterangan']?></span><br>
                            <?php } ?>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <table>
                                <tr valign=top>
                                    <td style="width: 30%;">Nama Pegawai</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 65%;">
                                        <span class="lbl_value_detail_cuti"><?=getNamaPegawaiFull($result['data'])?></span>
                                    </td>
                                </tr>
                                <tr valign=top>
                                    <td style="width: 30%;">NIP</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 65%;">
                                        <span class="lbl_value_detail_cuti"><?=$result['data']['nipbaru_ws']?></span>
                                    </td>
                                </tr>
                                <tr valign=top>
                                    <td style="width: 30%;">Jabatan</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 65%;">
                                        <span class="lbl_value_detail_cuti"><?=$result['data']['nama_jabatan']?></span>
                                    </td>
                                </tr>
                                <tr valign=top>
                                    <td style="width: 30%;">Pangkat</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 65%;">
                                        <span class="lbl_value_detail_cuti"><?=$result['data']['nm_pangkat']?></span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <table>
                                <tr valign=top>
                                    <td style="width: 30%;">Jenis Cuti</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 65%;">
                                        <span class="lbl_value_detail_cuti"><?=$result['data']['nm_cuti']?></span>
                                    </td>
                                </tr>
                                <tr valign=top>
                                    <td style="width: 30%;">Tanggal Pengajuan</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 65%;">
                                        <span class="lbl_value_detail_cuti"><?=formatDateNamaBulanWT($result['data']['created_date'])?></span>
                                    </td>
                                </tr>
                                <tr valign=top>
                                    <td style="width: 30%;">Lama Cuti</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 65%;">
                                        <span class="lbl_value_detail_cuti"><?=($result['data']['lama_cuti']).' hari'?></span>
                                    </td>
                                </tr>
                                <tr valign=top>
                                    <td style="width: 30%;">Tanggal Cuti</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 65%;">
                                        <?php 
                                            $tanggal_cuti = formatDateNamaBulan($result['data']['tanggal_mulai']).' - '.formatDateNamaBulan($result['data']['tanggal_akhir']);
                                            if($result['data']['lama_cuti'] == 1){
                                                $tanggal_cuti = formatDateNamaBulan($result['data']['tanggal_mulai']);
                                            }
                                        ?>
                                        <span class="lbl_value_detail_cuti"><?=$tanggal_cuti?></span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="row">
                                <?php if($result['data']['id_cuti'] == "00"){ ?>
                                    <div class="col-lg-12 mt-2">
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                        <span>Keterangan Cuti</span>
                                        </div>
                                        <?php foreach($result['data']['detail'] as $d){ ?>
                                        <div class="col">
                                            <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <span><?=$d['tahun']?></span>
                                            </div>
                                            <div class="col-lg-12 text-center">
                                                <span class="lbl_value_detail_cuti"><?=$d['jumlah']?></span>
                                            </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    </div>
                                <?php } else if($result['data']['id_cuti'] != "00" && $result['data']['id_cuti'] != "10"){ ?>
                                    <table>
                                        <tr valign=top>
                                            <td style="width: 30%;">Surat Pendukung</td>
                                            <td style="width: 5%;">:</td>
                                            <td style="width: 65%;">
                                                <a href="<?=base_url('assets/dokumen_pendukung_cuti/'.$result['data']['surat_pendukung'])?>" target="_blank" class="">
                                                    Lihat Surat Pendukung <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <hr>
                            <h5>REKAP ABSENSI 3 BULAN TERAKHIR</h5>
                            <div class="col-lg-12">
                            <div class="row">
                                <?php
                                $list_bulan_tahun = getBulanTahunTerakhir(date('Y-m-d'), 3);
                                foreach($list_bulan_tahun as $l){
                                    $rekap['data_absen'][$l['bulan'].'-'.$l['tahun']]['bulan'] = $l['bulan'];
                                    $rekap['data_absen'][$l['bulan'].'-'.$l['tahun']]['tahun'] = $l['tahun'];
                                    $rekap['data_absen'][$l['bulan'].'-'.$l['tahun']]['data'] = $this->general_library->getAbsensiPegawai($result['data']['id_m_user'], $l['bulan'], $l['tahun']);
                                }
                                $rekap['list_disiplin_kerja'] = $list_disiplin_kerja;
                                $rekap['data_rekap'] = $result['data'];
                                $this->load->view('kepegawaian/V_RekapAbsensiVerifPermohonanCuti', $rekap);
                                ?>
                            </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <hr>
                            <div class="col-lg-12">
                            <form id="form_verifikasi">
                                <div class="row">
                                    <?php if(($result['kepalapd'] && $result['data']['id_m_status_pengajuan_cuti'] == 1 && !$result['kepalabkpsdm']) || 
                                    ($result['data']['id_m_status_pengajuan_cuti'] == 2 && $result['kepalabkpsdm']) || 
                                    ($result['data']['id_m_status_pengajuan_cuti'] == 1 && $result['kepalabkpsdm'] && $result['id_unitkerja'] == $result['data']['id_unitkerja'])){ ?>
                                        <table>
                                            <tr valign=top>
                                                <td style="width: 30%;">VERIFIKASI</td>
                                                <td style="width: 5%;">:</td>
                                                <td style="width: 65%">
                                                    <select class="form-control select2-navy" style="width: 100%"
                                                    id="id_verif_pengajuan" data-dropdown-css-class="select2-navy" name="id_verif_pengajuan">
                                                        <option value="1" selected>Terima</option>
                                                        <option value="0">Tolak</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr valign=top>
                                                <td style="width: 30%;">KETERANGAN</td>
                                                <td style="width: 5%;">:</td>
                                                <td style="width: 65%">
                                                    <textarea rows=5 name="keterangan_verif" class="form-control"></textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-12 mt-2 text-right">
                                    <div class="row">
                                        <div class="col-lg-6 text-left">
                                        <?php if($result['data']['id_m_status_pengajuan_cuti'] == 4 && !$result['data']['url_sk']){ ?>
                                            <button onclick="digitalSign()" id="button_ds" class="btn btn-success"><i class="fa fa-signature fa-2x"></i> Digital Sign </button>
                                            <button style="display: none;" id="button_ds_loader" disabled class="btn btn-success"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu... </button>
                                        <?php } ?>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                        <?php if(($result['kepalapd'] && $result['data']['id_m_status_pengajuan_cuti'] == 1 && !$result['kepalabkpsdm']) || 
                                        ($result['data']['id_m_status_pengajuan_cuti'] == 2 && $result['kepalabkpsdm']) ||
                                        ($result['data']['id_m_status_pengajuan_cuti'] == 1 && $result['kepalabkpsdm'] && $result['id_unitkerja'] == $result['data']['id_unitkerja'])){ ?> 
                                            <button id="button_submit" type="submit" class="btn btn-navy"><i class="fa fa-save"></i> Simpan Verifikasi </button>
                                            <button style="display: none;" id="button_submit_loader" disabled class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Menyimpan... </button>
                                        <?php } else if(($result['kepalapd'] && ($result['data']['id_m_status_pengajuan_cuti'] == 2 || $result['data']['id_m_status_pengajuan_cuti'] == 3) && !$result['kepalabkpsdm']) || 
                                        ($result['data']['id_m_status_pengajuan_cuti'] == 4 && $result['data']['url_sk'] == null && $result['kepalabkpsdm'])){ ?>
                                            <button id="btn_batal_verif" onclick="batalVerifikasi()" type="button" class="btn btn-danger"><i class="fa fa-times"></i> Batal Verifikasi </button>
                                            <button style="display: none;" id="btn_batal_verif_loading" type="button" disabled class="btn btn-danger"><i class="fa fa-spin fa-spinner"></i> Menyimpan... </button>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="col-lg-12">
                            <h5><i class="fa fa-exclamation"></i> Data Tidak Ditemukan</h5>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<script>
    $('#form_verifikasi').on('submit', function(e){
        e.preventDefault()
        $('#button_submit').hide()
        $('#button_submit_loader').show()
        $.ajax({
        url: '<?=base_url("verif_whatsapp/C_VerifWhatsapp/saveVerifikasiPermohonanCuti/")?>'+$('#id_verif_pengajuan').val()+'/'+'<?=$result['data']['id']?>'+'/'+'<?=$result['kepalapd'] ? 1 : 0; ?>'+'/'+'<?=$result['kepalabkpsdm'] ? 1 : 0 ;?>',
        method:"POST",  
        data: $(this).serialize(),
        success: function(res){
            let rs = JSON.parse(res)
            if(rs.code == 1){
                errortoast(rs.message)
            } else {
                successtoast('Verifikasi Berhasil')
                window.location = ""
            }
            $('#button_submit').show()
            $('#button_submit_loader').hide()
        }, error: function(err){
            errortoast('Terjadi Kesalahan')
            $('#button_submit').show()
            $('#button_submit_loader').hide()
        }
        })
    })

    function digitalSign(){
        $('#button_ds').hide()
        $('#button_ds_loader').show()
        $.ajax({
        url: '<?=base_url("verif_whatsapp/C_VerifWhatsapp/dsCuti/")?>'+'<?=$result['data']['id']?>',
        method:"POST",  
        data: $(this).serialize(),
        success: function(res){
            let rs = JSON.parse(res)
            if(rs.code == 1){
                errortoast(rs.message)
            } else {
                successtoast('DS Berhasil')
                window.location = ""
            }
            $('#button_ds').show()
            $('#button_ds_loader').hide()
        }, error: function(err){
            errortoast('Terjadi Kesalahan')
            $('#button_ds').show()
            $('#button_ds_loader').hide()
        }
        })
    }

    function batalVerifikasi(){
        $('#btn_batal_verif').hide()
        $('#btn_batal_verif_loading').show()
        $.ajax({
        url: '<?=base_url("verif_whatsapp/C_VerifWhatsapp/batalVerifikasiPermohonanCuti/")?>'+'<?=$result['data']['id']?>'+'/'+'<?=$result['kepalapd'] ? 1 : 0; ?>'+'/'+'<?=$result['kepalabkpsdm'] ? 1 : 0 ;?>',
        method:"POST",  
        data: $(this).serialize(),
        success: function(res){
            let rs = JSON.parse(res)
            if(rs.code == 1){
                errortoast(rs.message)
            $('#btn_batal_verif').show()
            $('#btn_batal_verif_loading').hide()
            } else {
                successtoast('Pembatalan Verifikasi Berhasil')
                window.location = ""
            }
        }, error: function(err){
            errortoast('Terjadi Kesalahan')
            $('#btn_batal_verif').show()
            $('#btn_batal_verif_loading').hide()
        }
        })
    }
</script>