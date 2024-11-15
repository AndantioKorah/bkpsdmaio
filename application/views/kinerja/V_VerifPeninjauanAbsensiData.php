<?php if($result){ ?>
    <div class="table-responsive">
    <table border=1 class="table table-hover" id="table_disiplin_kerja_result_data">
        <thead>
            <th class="text-center">No</th>
            <th class="text-left">Nama Pegawai</th>
            <th class="text-left">Unit Kerja</th>
            <th class="text-center">Tanggal Absensi</th>
            <th class="text-center">Jenis Absensi</th>
            <th class="text-center">Jenis Bukti Absensi</th>
            <th class="text-center">Teman Absensi</th>
            <th class="text-center">Dokumen</th>
            <th class="text-center">Keterangan Verif</th>
            <th></th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $r){ ?>
                <tr id="tr_<?=$r['id']?>" style="<?php if($status == 0) { if($r['total_diverif'] >= 2) echo 'background-color:#f0a095'; }?>">
                    <td class="text-center"><?=$no?></td>
                    <td class="text-left">
                    <a target="_blank" href="<?= base_url('kepegawaian/profil-pegawai/')?><?=$r['nipbaru'];?>" style="color:#495057"><?=getNamaPegawaiFull($r).'<br>NIP. '.$r['nipbaru']?></a></td>
                    <td class="text-left"><?=($r['nm_unitkerja'])?> </td>
                    <?php
                        // $bulan = $r['bulan'] < 10 ? '0'.$r['bulan'] : $r['bulan'];
                        // $tanggal = $r['tanggal'] < 10 ? '0'.$r['tanggal'] : $r['tanggal'];
                    ?>
                  
                    <td class="text-center"><?= formatDateNamaBulan($r['tanggal_absensi'])?></td>
                    <td class="text-left">
                          <?php if($r['jenis_absensi'] == 1) echo "Absen Pagi"; else echo "Absen Sore";?>
                        </td>
                        <td class="text-left">
                          <?php if($r['jenis_bukti'] == 1) echo "Foto Bersama Teman"; else echo "Screenshot Whatsapp";?>
                        </td>
                        <td class="text-left">
                        <a target="_blank" href="<?= base_url('kepegawaian/profil-pegawai/')?><?=$r['teman_nip'];?>" style="color:#495057"><?=$r['teman_gelar1']?><?=$r['teman_nama']?><?=$r['teman_gelar2']?></a></td>

                    <td class="text-center">  
                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-file"></i> Dokumen
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php 
                            
                            $file = json_decode($r['bukti_kegiatan']);
                            $nodok = 1;
                            $tanggal = new DateTime($r['tanggal_absensi']);
                            $tahun = $tanggal->format("Y");
                            $bulan = $tanggal->format("m");
                            if($file) {
                            foreach($file as $file_name)
                                {
                                  $data = $file_name;    
                                  // $ekstension = substr($data, strpos($data, ".") + 1); 
                                  $ekstension = pathinfo($data, PATHINFO_EXTENSION);
                                  
                                    if($file_name == null){
                                        echo "<a class='dropdown-item' >Tidak Ada File</a>";
                                    } else {
                                      if($ekstension == "png" || $ekstension == "jpg" || $ekstension == "jpeg"){
                                        echo "<a class='dropdown-item' href=".base_url('assets/peninjauan_absen/'.$tahun.'/'.$bulan.'/'.$file_name.'')." target='_blank'>Dokumen ".$nodok."</a>";
                                        // echo "<a class='dropdown-item'  href='javascript:;' data-id='".$r['id']."' data-bulan='".$bulan."' data-tahun='".$tahun."'  data-gambar='".$file_name."' data-toggle='modal' data-target='#edit-data'>Dokumen ".$nodok."</a>";

                                      } else {
                                        echo "<a class='dropdown-item' href=".base_url('assets/peninjauan_absen/'.$tahun.'/'.$bulan.'/'.$file_name.'')." target='_blank'>Dokumen ".$nodok."</a>";
                                        // echo "<a class='dropdown-item'  href='javascript:;' data-id='".$r['id']."'  data-gambar='".$file_name."' data-toggle='modal' data-target='#edit-data'>Dokumen ".$nodok."</a>";
                                      }
                                    }
                                   $nodok++;
                                } 
                              } else {
                                echo "<a class='dropdown-item' >Tidak Ada File</a>";
                              }
                            ?>
   
                        </div>
                           
                        </td>
                    <td>
                        <?php if($status == 1 || $status == 2){ ?>
                            <span><strong><?=$r['keterangan_verif']?></strong></span><br>
                            <input type="hidden" class="form-control" id="id_user_<?=$r['id']?>" value="<?=$r['id_m_user']?>"/>
                            
                            <!-- <span style="font-size: 14px;"><?='(oleh '.$r['nama_verif'].' pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span> -->
                            <span style="font-size: 14px;"><?='(pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span>
                        <?php } else if($status == 0) { ?> 
                            
                            <input class="form-control" id="ket_verif_<?=$r['id']?>" />
                            <?php if($r['jenis_bukti'] == 2) { ?>
                            <input type="time" class="form-control" id="jam_<?=$r['id']?>"  value="10:05 AM" />
                            <?php } ?>

                            <input type="hidden" class="form-control" id="jenis_bukti_<?=$r['id']?>" value="<?=$r['jenis_bukti']?>"/>
                            <input type="hidden" class="form-control" id="teman_absensi_<?=$r['id']?>" value="<?=$r['teman_absensi']?>"/>
                            <input type="hidden" class="form-control" id="tanggal_absensi_<?=$r['id']?>" value="<?=$r['tanggal_absensi']?>"/>
                            <input type="hidden" class="form-control" id="id_user_<?=$r['id']?>" value="<?=$r['id_m_user']?>"/>
                            <input type="hidden" class="form-control" id="jenis_absensi_<?=$r['id']?>" value="<?=$r['jenis_absensi']?>"/>
                       
                            <?php } else if($status == 3){ ?>
                            <input type="hidden" class="form-control" id="id_user_<?=$r['id']?>" value="<?=$r['id_m_user']?>"/>
                            <input class="form-control" id="ket_verif_<?=$r['id']?>" />
                            <?php if($r['jenis_bukti'] == 2) { ?>
                            <input type="time" class="form-control" id="jam_<?=$r['id']?>" />
                            <?php } ?>
                            
                            <input type="hidden" class="form-control" id="jenis_bukti_<?=$r['id']?>" value="<?=$r['jenis_bukti']?>"/>
                            <input type="hidden" class="form-control" id="teman_absensi_<?=$r['id']?>" value="<?=$r['teman_absensi']?>"/>
                            <input type="hidden" class="form-control" id="tanggal_absensi_<?=$r['id']?>" value="<?=$r['tanggal_absensi']?>"/>
                            <input type="hidden" class="form-control" id="id_user_<?=$r['id']?>" value="<?=$r['id_m_user']?>"/>
                            <input type="hidden" class="form-control" id="jenis_absensi_<?=$r['id']?>" value="<?=$r['jenis_absensi']?>"/>
                            

                            <span style="font-size: 14px;"><?='(DIBATALKAN pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <?php if($r['total_diverif'] < 2) { ?>
                            <button data-list_id='<?=json_encode($r['list_id'])?>' onclick="verifDokumen(1, '<?=$r['id']?>',<?=$status?>,'<?=$r['jenis_bukti']?>')" style="display: <?=$status == 0 || $status == 3 ? 'block' : 'none'?>" class="btn_verif_<?=$r['id']?> btn btn-sm btn-success" title="Terima"><i class="fa fa-check"></i></button>
                            <?php } ?>
                            <button data-list_id='<?=json_encode($r['list_id'])?>' onclick="verifDokumen(2, '<?=$r['id']?>',<?=$status?>,'<?=$r['jenis_bukti']?>')" style="display: <?=$status == 0 || $status == 3 ? 'block' : 'none'?>" class="btn_verif_<?=$r['id']?> btn btn-sm btn-danger" title="Tolak"><i class="fa fa-times"></i></button>
                            <button data-list_id='<?=json_encode($r['list_id'])?>' onclick="verifDokumen(3, '<?=$r['id']?>',<?=$status?>,'<?=$r['jenis_bukti']?>')" style="display: <?=$status == 0 || $status == 3 ? 'none' : 'block'?>" class="btn_batal_<?=$r['id']?> btn btn-sm btn-warning" title="Batal"><i class="fa fa-trash"></i></button>
                            <button disabled style="display: none;" id="btn_loading_<?=$r['id']?>" class="btn btn-sm btn-info"><i class="fa fa-spin fa-spinner"></i></button>
                        </div>
                    </td>
                </tr>
            <?php $no++; } ?>
        </tbody>
    </table>
    </div>

<?php } else { ?>
    <div class="col-12 text-center">
        <h6>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h6>
    </div>
<?php } ?>
<script>
    $(function(){
       
        // $("#sidebar_toggle" ).trigger( "click" );
        $('#table_disiplin_kerja_result_data').dataTable()
    })

    function verifDokumen(status, id, tab,jenis_absen){

        if(jenis_absen == 2){
            if(status == 1){
           if($('#jam_'+id).val() == "" || $('#jam_'+id).val() == null){
            errortoast('Jam belum diisi')
            return false;
           }
        }

           
        }

        $('.btn_verif_'+id).hide()
        $('#btn_loading_'+id).show()
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/verifPeninjauanAbsensi/")?>'+'/'+id+'/'+status,
            method: 'post',
            data: {
                list_id : $('.btn_verif_'+id).data('list_id'),
                keterangan: $('#ket_verif_'+id).val(),
                jenis_bukti: $('#jenis_bukti_'+id).val(),
                teman_absensi: $('#teman_absensi_'+id).val(),
                tanggal_absensi: $('#tanggal_absensi_'+id).val(),
                jenis_absensi: $('#jenis_absensi_'+id).val(),
                jam_absen : $('#jam_'+id).val(),
                id_user: $('#id_user_'+id).val()
            },
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    // successtoast('Data Berhasil Diverifikasi')
                    // openListData(active_status)
                    // $('#count_pengajuan').html(rs.data.pengajuan)
                    // $('#count_diterima').html(rs.data.diterima)
                    // $('#count_ditolak').html(rs.data.ditolak)
                    // $('#count_batal').html(rs.data.batal)
                    // $('#tr_'+id).hide();
                    console.log(tab)
                    if(tab == 0){
                        // openListData(0)
                        $('#tr_'+id).hide();
                    } else if(tab == 3) {
                        openListData(3)
                    } else {
                        $('#tr_'+id).hide();
                    }
             
                    // 
                } else {
                    errortoast(rs.message)
                }
                $('.btn_verif_'+id).show()
                $('#btn_loading_'+id).hide()
            }, error: function(e){
                $('.btn_verif_'+id).show()
                $('#btn_loading_'+id).hide()
                errortoast('Terjadi Kesalahan')
            }
        })
    }
</script>