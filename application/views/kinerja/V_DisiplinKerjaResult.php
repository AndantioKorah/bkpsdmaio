<div class="card card-default">
    <div class="card-header">
        <h5>Data Disiplin Kerja</h5>
    </div>
    <div class="card-body">
        <?php if($result){ ?>
            <table class="table table-hover" id="table_disiplin_kerja_result">
                <thead>
                    <th class="text-center">No</th>
                    <th class="text-left">Nama Pegawai</th>
                    <th class="text-center">NIP</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Pilihan</th>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($result as $r){ ?>
                        <tr>
                            <td class="text-center"><?=$no?></td>
                            <td class="text-left"><?=($r['nama'])?></td>
                            <td class="text-center"><?=formatNip($r['nip'])?></td>
                            <td class="text-center"><?= json_encode($r['jenis_disiplin']) ?></td>
                            <td class="text-center">
                                <button data-toggle="modal" onclick="openDetailModalDataDisiplinKerja('<?=$r['id_m_user']?>')" href="#detailModalDataDisiplinKerja" type="button" class="btn btn-navy btn-sm"><i class="fa fa-list"></i> Detail</button>
                                <button onclick="deleteDisiplinKerjaByIdUser('<?=$r['id_m_user']?>')" type="button" id="btn_delete_<?=$r['id_m_user']?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                                <button type="button" disabled style="display: none;" id="btn_loading_<?=$r['id_m_user']?>" class="btn btn-danger btn-sm"><i class="fa fa-spin fa-spinner"></i> Loading....</button>
                            </td>
                        </tr>
                    <?php $no++; } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="col-12 text-center">
                <h6>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h6>
            </div>
        <?php } ?>
    </div>
</div>
<div class="modal fade" id="detailModalDataDisiplinKerja" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content" id="detailModalDataDisiplinKerjaContent">
      </div>
  </div>
</div>

<script>
    $(function(){
        $('#table_disiplin_kerja_result').dataTable()
    })

    function deleteDisiplinKerjaByIdUser(id){
        if(confirm('Apakah Anda yakin ingin menghapus data?')){
            $('#btn_delete_'+id).hide()
            $('#btn_loading_'+id).show()
            $.ajax({
                url: '<?=base_url("kinerja/C_Kinerja/deleteDataDisiplinKerjaByIdUser")?>',
                method: 'post',
                data: {
                    id_m_user: id,
                    bulan: $('#bulan').val() ,
                    tahun: $('#tahun').val() 
                },
                success: function(data){
                    successtoast('Berhasil Menghapus Data Disiplin Kerja')
                    $('#form_search_disiplin_kerja').submit()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }

    function openDetailModalDataDisiplinKerja(id){
        var bulan = $('#bulan').val() 
        var tahun = $('#tahun').val() 
        $('#detailModalDataDisiplinKerjaContent').html('')
        $('#detailModalDataDisiplinKerjaContent').append(divLoaderNavy)
        $('#detailModalDataDisiplinKerjaContent').load('<?=base_url("kinerja/C_Kinerja/openModalDetailDisiplinKerja")?>'+'/'+id+'/'+bulan+'/'+tahun, function(){
            $('#loader').hide()
        })
    }
    
</script>