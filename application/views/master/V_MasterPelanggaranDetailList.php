<div class="row">
    <div class="col-lg-12">
        <form id="form_pelanggaran_detail">
            <div class="row">
                <div class="col-lg-6">
                    <label>Nama Pelanggaran</label>
                    <input autocomplete="off" id="nama_pelanggaran_detail" name="nama_pelanggaran_detail" class="form-control" />
                </div>
                <div class="col-lg-6">
                    <label>Presentase Pemotongan</label>
                    <input autocomplete="off" id="presentase_pemotongan" name="presentase_pemotongan" class="form-control" />
                </div>
                <div class="col-lg-9"></div>
                <div class="col-lg-3 mt-2 text-right">
                    <button type="submit" class="btn btn-block btn-navy"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-12"><hr></div>
    <div class="col-lg-12">
        <table class="table table-hover table-striped data_table_detail">
            <thead>
                <th class="text-center">No</th>
                <th class="text-center">Nama Hukuman Disiplin</th>
                <th class="text-center">Pemotongan</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php if($result) { $no=1; foreach($result as $rs){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$rs['nama_pelanggaran_detail']?></td>
                        <td class="text-center"><?=$rs['presentase_pemotongan'].' %'?></td>
                        <td class="text-center">
                            <button onclick="deletePelanggaranDetail('<?=$rs['id']?>')" 
                            class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                        </td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function(){
        $('.data_table_detail').dataTable()
    })

    $('#form_pelanggaran_detail').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("master/C_Master/insertPelanggaranDetail/".$id_m_pelanggaran)?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(rs){
                successtoast('Data Berhasil Dihapus')
                detailPelanggaran('<?=$id_m_pelanggaran?>')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })  
    })

    function deletePelanggaranDetail(id){
        if(confirm('Apakah Anda yakin?')){
            $.ajax({
                url: '<?=base_url("master/C_Master/deletePelanggaranDetail/")?>'+id,
                method: 'post',
                data: $(this).serialize(),
                success: function(rs){
                    successtoast('Data Berhasil Dihapus')
                    detailPelanggaran('<?=$id_m_pelanggaran?>')
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }
</script>