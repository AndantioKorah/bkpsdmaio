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
</style>
<table id="potensial_jpt" class="display table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Jabatan Target</th>
                <th>Nilai Asessment</th>
                <th>Nama</th>
                <th>Nilai Rekam Jejak</th>
                <th>Nilai Pertimbangan Lainnya</th>
                <th>Total</th>
				<th>Pemeringkatan</th>
				<th></th>
            </tr>
        </thead>
        <tbody>
		<?php $no = 1; foreach($result as $rs2){ ?>
			<?php $total_nilai = $rs2['res_potensial_cerdas'] + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];?>
            <tr>
                <td><?=$rs2['nama_jabatan'];?></td>
                <td><?=$rs2['res_potensial_cerdas'];?></td>
                <td><?=$rs2['gelar1'];?><?=$rs2['nama'];?> <?=$rs2['gelar2'];?></td>
                <td><?=$rs2['res_potensial_rj'];?></td>
                <td><?=$rs2['res_potensial_lainnya'];?></td>
                <td><?=$total_nilai;?></td>
				<td><?= pemeringkatanKriteriaPotensial($total_nilai)?></td>
				<td>
				<button data-toggle="modal" data-id="<?=$rs2['id']?>" data-nip="<?=$rs2['nipbaru']?>" data-jt="<?=$rs2['id_jabatan_target']?>" data-kode="2"
										href="#modal_penilaian_potensial" title="Ubah Data" class="open-DetailPenilaian btn btn-sm btn-info">
										<i class="fa fa-edit"></i></button>
				</td>
            </tr>
			<?php } ?>
            
        </tbody>
        <tfoot>
            <tr>
			<th>Jabatan Target</th>
                <th>Nilai Asessment</th>
                <th>Nama</th>
                <th>Nilai Rekam Jejak</th>
                <th>Nilai Pertimbangan Lainnya</th>
                <th>Total</th>
				<th>Pemeringkatan</th>
				<th></th>
            </tr>
        </tfoot>
    </table>
</div>

</div>

<script>
	var groupColumn = 2;
var table = $('#potensial_jpt').DataTable({
    columnDefs: [{ visible: false, targets: groupColumn },
    {targets: 0,orderable: false}],
    order: [[groupColumn, 'asc']],
    displayLength: 25,
    drawCallback: function (settings) {
        var api = this.api();
        var rows = api.rows({ page: 'current' }).nodes();
        var last = null;
 
        api.column(groupColumn, { page: 'current' })
            .data()
            .each(function (group, i) {
                if (last !== group) {
                    $(rows)
                        .eq(i)
                        .before(
                            '<tr class="group"><td colspan="7">' +
                                group +
                                '</td></tr>'
                        );
 
                    last = group;
                }
            });
    }
});
 
// Order by the grouping
$('#potensial_jpt tbody').on('click', 'tr.group', function () {
    var currentOrder = table.order()[0];
    if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
        table.order([groupColumn, 'desc']).draw();
    }
    else {
        table.order([groupColumn, 'asc']).draw();
    }
});
</script>

<script>
	$(function () {
		$('#table-adm').dataTable({
			"ordering": false
		});



	})

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
