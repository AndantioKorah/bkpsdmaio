<?php if($result){ ?>
    <div class="row">
        <div class="col-lg-12 text-left">
            <h2><?=$result[0]['nama_hak_akses']?></h2>
            <hr>
        </div>
        <div class="col-lg-12 mb-3">
            <form id="tambah_hak_akses_user">
                <div class="row">
                    <div class="col-lg-9">
                        <label>Tambah Pegawai</label>
                        <select class="form-control select2-navy" style="width: 100%"
                        id="id_m_user" data-dropdown-css-class="select2-navy" name="id_m_user">
                            <?php if($list_pegawai){
                                foreach($list_pegawai as $lp){
                                ?>
                                <option value="<?=$lp['id_m_user']?>">
                                    <?=getNamaPegawaiFull($lp)?>
                                </option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" style="margin-top: 23px;" class="btn btn-navy btn-block"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <hr>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-hover table-striped data-table-list-user">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Nama Pegawai</th>
            <th class="text-center">Jabatan</th>
            <th class="text-center">Unit Kerja</th>
            <th class="text-center">Pilihan</th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $rs){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-left"><?=getNamaPegawaiFull($rs)?></td>
                    <td class="text-left"><?=$rs['nama_jabatan']?></td>
                    <td class="text-left"><?=$rs['nm_unitkerja']?></td>
                    <td class="text-center">
                        <button onclick="deleteUserAkses('<?=$rs['id']?>')" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i> Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        $(function(){
            $('#id_m_user').select2()
            $('.data-table-list-user').dataTable()
        })

        $('#tambah_hak_akses_user').on('submit', function(e){
            e.preventDefault()
            $.ajax({
                url: '<?=base_url("master/C_Master/tambahHakAksesUser/")?>'+$('#id_m_user').val()+'/'+'<?=$result[0]['id_m_hak_akses']?>',
                method: 'post',
                data: $(this).serialize,
                success: function(rs){
                    if(rs.code == 1){
                        errortoast(rs.message)
                    } else {
                        successtoast('Data Berhasil Ditambahkan')
                        openModalHakAkses('<?=$result[0]['id_m_hak_akses']?>')
                    }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })

        function tambah_hak_akses_user($id){
            
        }

        function deleteUserAkses(id){
            if(confirm('Apakah Anda yakin?')){
                $.ajax({
                    url: '<?=base_url("master/C_Master/deleteUserAkses/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(rs){
                        successtoast('Data Berhasil Dihapus')
                        openModalHakAkses('<?=$result[0]['id_m_hak_akses']?>')
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })       
            }
        }
    </script>
<?php } else { ?>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h4>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h4>
        </div>
    </div>
<?php } ?>