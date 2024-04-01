<?php if($list_pegawai){ ?>
    <div class="col-lg-12 table-responsive">
    <table class="table table-striped" id="table_list_pegawai">
            <thead>
                <th class="text-center">No</th>
                <th class="text-left">Nama Pegawai</th>
                <?php if($this->general_library->isWalikota()){ ?>
                    <th class="text-left">Unit Kerja</th>
                    <th class="text-left">Jabatan</th>
                <?php } ?>
               
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
            <?php $no=1; foreach($list_pegawai as $p){
                $capaian = null;
                $pembobotan = null;
               
                if(isset($p['komponen_kinerja']) && $p['komponen_kinerja']){
                    // dd($p['komponen_kinerja']);
                    list($capaian, $pembobotan) = countNilaiKomponen($p['komponen_kinerja']);
                    // $pembobotan = $pembobotan * 100;
                    // dd($p['created_by']);
                    // dd($this->general_library->getId());
                    // $pembobotan = (formatTwoMaxDecimal($pembobotan)).'%';
                    $pembobotan = number_format((float)$pembobotan, 2, '.', '').'%';
                    // $capaian = $p['komponen_kinerja']['capaian'];
                    // $pembobotan = $p['komponen_kinerja']['bobot']."%";
                }
            ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td><?=getNamaPegawaiFull($p)?></td>
                    <?php if($this->general_library->isWalikota()){ ?>
                        <td class="text-left"><?=$p['nm_unitkerja']?></td>
                        <td class="text-left"><?=$p['nama_jabatan']?></td>
                    <?php } ?>
                     <td class="text-center">
                        <button data-toggle="modal" href="#modal_edit_data_nilai" onclick="lihatSKP('<?=$p['id_m_user']?>')" 
                        class="btn btn-sm btn-navy"><i class="fa fa-search"></i> Lihat SKP</button>
                        <?php // if($p['komponen_kinerja'] && $p['created_by'] == $this->general_library->getId()){ ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
          
        </table>
    </div>
    <div class="modal fade" id="modal_edit_data_nilai" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div id="modal-dialog" class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Sasaran Kerja Bulanan Pegawai</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_edit_data_nilai_content">
                </div>
            </div>
        </div>
    </div>
    <script>

$('#table_list_pegawai').DataTable({
    "ordering": false,
    "aLengthMenu": [[20, 50, 75, -1], [20, 50, 75, "All"]],
     });
    
        function lihatSKP(id){
            let bulan = "<?=$periode['bulan']?>"
            let tahun = "<?=$periode['tahun']?>"
            $('#modal_edit_data_nilai_content').html('')
            $('#modal_edit_data_nilai_content').append(divLoaderNavy)
            // $('#modal_edit_data_nilai_content').load('<?=base_url("kinerja/C_Kinerja/editNilaiKomponen/")?>'+id+'/'+bulan+'/'+tahun, function(){
            //     $('#loader').hide()
            // })

            $.ajax({
            // url: '<?=base_url("kinerja/C_Kinerja/createSkpBulananVerif")?>',
            url: '<?=base_url("kinerja/C_Kinerja/openVerifPegawai")?>',
            method: 'post',
            data: {bulan:bulan, tahun:tahun, id_user:id},
            success: function(data){
                $('#modal_edit_data_nilai_content').html('')
                $('#modal_edit_data_nilai_content').append(data)
                
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
          })
        }

        function deleteNilaiKomponen(id, id_user){
            if (confirm('Apakah Anda yakin ingin menghapus data?')){
                $('#btn_delete_'+id).hide()
                $('#btn_loading_'+id).show()
                $.ajax({
                    url: '<?=base_url("kinerja/C_Kinerja/deleteNilaiKomponen")?>'+'/'+id,
                    method: 'post',
                    data: null,
                    success: function(data){
                        let res = JSON.parse(data)
                        if(res.code != 0){
                            errortoast(res.message)
                        } else {
                            successtoast('Data berhasil dihapus')
                            $('#capaian_'+id_user).html('')
                            $('#pembobotan_'+id_user).html('')
                            $('#btn_loading_'+id).hide()
                        }
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }
    </script>
<?php } else { ?>
<?php } ?>