<div class="card card-default">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-hover table-striped" id="table_list_pegawai">
                    <thead>
                        <th class="text-center">No</th>
                        <th class="text-center">Pegawai</th>
                        <th class="text-center">NIP</th>
                        <th class="text-center">Jabatan</th>
                        <!-- <th class="text-center">Pilihan</th> -->
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($result as $rs){ ?>
                            <tr style="cursor: pointer;" onclick="loadSkbp('<?=$rs['id_m_user']?>')" href="#modal_skbp_pd" data-toggle="modal">
                                <th class="text-center"><?=$no++;?></th>
                                <th class="text-left"><?=getNamaPegawaiFull($rs)?></th>
                                <th class="text-center"><?=$rs['nipbaru_ws']?></th>
                                <th class="text-left"><?=$rs['nama_jabatan']?></th>
                                <!-- <th class="text-center">
                                    <button class="btn btn-navy btn-sm" onclick="loadSkbp('<?=$rs['id_m_user']?>')"
                                    href="#modal_skbp_pd" data-toggle="modal"><i class="fa fa-file"></i> SKBP</button>
                                </th> -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#table_list_pegawai').dataTable()
    })

    function loadSkbp(id){
        $('#modal_skbp_pd_content').html('')
        $('#modal_skbp_pd_content').append(divLoaderNavy)
        $('#modal_skbp_pd_content').load('<?=base_url('kinerja/C_Kinerja/createSkpBulananVerifNew/')?>'+id+'/'+'<?=$param['bulan']?>'+'/'+<?=$param['tahun']?>, function(){
            $('#loader').hide()
        })
    }
</script>