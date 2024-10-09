<?php if($result){ ?>
<style>
	.list-group-item.active {
		background-color: #222e3c;
		border-color: var(--bs-list-group-active-border-color);
		color: var(--bs-list-group-active-color);
		z-index: 2;
	}

</style>

<div class="table-responsive">


<style>
	tr.group,
	tr.group:hover {
		background-color: #2e4963 !important;
		color: #fff;
	}
    .table_pt_adm:hover {
    cursor: pointer;
    }
</style>
<table id="" class="display table table-bordered table_pt_adm" style="width:100%">
        <thead>
            <tr>
                <!-- <th>Jabatan Target</th> -->
                <th>Nilai Kinerja</th>
                <th>Pemeringkatan Kinerja</th>
                
                <th>Total Nilai Potensial</th>
				<th>Pemeringkatan Potensial</th>
                <th>Total Nilai </th>
                <th>Hasil Pemetanaan </th>
                <th>Rekomendasi</th>
				<th></th>
            </tr>
        </thead>
        <tbody>
		<?php $no = 1; foreach($result as $rs2){ ?>
           
			<?php 
                $total_nilai = $rs2['res_potensial_cerdas'] + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];?>
            <tr data-toggle="modal" data-id="<?=$rs2['id']?>" data-nip="<?=$rs2['nipbaru']?>" data-jt="<?=$jenis_pengisian?>" data-kode="1"
            href="#modal_detail_profil_talenta" title="Detail" class="open-DetailPT">
                <td><?=$rs2['res_kinerja'];?></td>
                <td><a target="_blank" href="<?= base_url('kepegawaian/profil-pegawai/')?><?=$rs2['nipbaru_ws'];?>" style="color:#fff"><b><?=$rs2['gelar1'];?> <?=$rs2['nama'];?> <?=$rs2['gelar2'];?></b> | NIP. <?=formatNip($rs2['nipbaru_ws']);?></a><br><i><?=$rs2['jabatan_sekarang'];?></i></td>
                <td><?= pemeringkatanKriteriaKinerja($rs2['res_kinerja'])?></td>
               
                <td><?=$rs2['res_potensial_total'];?></td>
				<td><?= pemeringkatanKriteriaPotensial($total_nilai)?></td>
                <td><?=($total_nilai+$rs2['res_kinerja'])/2;?></td>
                <td><?= pemetaanTalenta($rs2['res_potensial_total'],$rs2['res_kinerja'],)?></td>
                <td>
                <?= rekomendasi($rs2['res_potensial_total'],$rs2['res_kinerja'])  ?>
                </td>
				<td>
				<button data-toggle="modal" data-id="<?=$rs2['id']?>" data-nip="<?=$rs2['nipbaru']?>" data-jt="<?=$jenis_pengisian?>" data-kode="1"
										href="#modal_detail_profil_talenta" title="Detail" class="open-DetailPT btn btn-sm btn-info">
										<i class="fa fa-search"></i></button>
				</td>
            </tr>
			
            <?php } ?>
            
        </tbody>
        <tfoot>
            <tr>
            <th>Nilai Kinerja</th>
                <th>Pemeringkatan Kinerja</th>
                
                <th>Total Nilai Potensial</th>
				<th>Pemeringkatan Potensial</th>
                <th>Total Nilai </th>
                <th>Hasil Pemetanaan </th>
                <th>Rekomendasi</th>
				<th></th>
            </tr>
        </tfoot>
    </table>
</div>

</div>

<script>
	var groupColumn = 1;
    var table = $('.table_pt_adm').DataTable({
    columnDefs: [{ visible: false, targets: groupColumn},
    { "searchable": false, "targets": [11] }],
    order: [[groupColumn, 'asc']],
    displayLength: 200,
    drawCallback: function (settings) {
        var api = this.api();
        var rows = api.rows({ page: 'current' }).nodes();
        var last = null;
        let no = 0;
        api.column(groupColumn, { page: 'current' })
            .data()
            .each(function (group, i) {
                if (last !== group) {
                    no += 1;
                    $(rows)
                        .eq(i)
                        .before(
                            '<tr class="group"><td colspan="8">'+no+'. '+
                                group +
                                '</td></tr>'
                        );
 
                    last = group;
                }
            });
    }
});
 
// Order by the grouping
$('#example tbody').on('click', 'tr.group', function () {
    var currentOrder = table.order()[0];
    if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
        // table.order([groupColumn, 'desc']).draw();
    }
    else {
        // table.order([groupColumn, 'asc']).draw();
    }
});
</script>

<script>

	function deleteDataJt(id) {
		if (confirm('Apakah Anda yakin ingin menghapus data?')) {
			$.ajax({
				url: '<?=base_url("simata/C_Simata/deleteDataJabatanTarget/")?>' + id,
				method: 'post',
				data: null,
				success: function () {
					successtoast('Data sudah terhapus')
					location.reload()
				},
				error: function (e) {
					errortoast('Terjadi Kesalahan')
				}
			})
		}
	}



</script>
<?php } else { ?>
<div class="col-12 text-center">
	<h5>DATA TIDAK DITEMUKAN !</h5>
</div>
<?php } ?>
