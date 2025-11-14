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
<table id="" class="display table table-bordered table_pt_jpt" style="width:100%">
        <thead>
            <tr>
                <th>Pns id</th>
                <th>jenjang jabatan</th>
                <th>rumpun jabatan</th>
                <th>nilai potensial</th>
                <th>nilai kinerja</th>
                <th>Total Nilai </th>
                <th>Hasil Pemetaan</th>
				<th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
		<?php $no = 1; foreach($result as $rs2){ ?>
           
			<?php 
                $total_nilai = $rs2['res_potensial_cerdas'] + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];?>
            <tr data-toggle="modal" data-id="<?=$rs2['id']?>" data-nip="<?=$rs2['nipbaru']?>" data-jt="<?=$rs2['id']?>" data-kode="1"
            href="#modal_detail_profil_talenta" title="Detail" class="open-DetailPT">
                <td>
                    <?=$rs2['pns_id'];?>
                </td>
                <td></td>
                <td></td>
                <td><?=$rs2['res_potensial_total'];?></td>
                <td><?=$rs2['res_kinerja'];?></td>

                <td><?=($total_nilai+$rs2['res_kinerja'])/2;?></td>
                <td><?= pemetaanTalenta($rs2['res_potensial_total'],$rs2['res_kinerja'],)?></td>
                <td><?= ($rs2['nama'])?></td>
                <td ><?=$rs2['nama_jabatan'];?></td>
				
            </tr>
			<?php 
            // }
             ?>
            <?php } ?>
            
        </tbody>
        
    </table>
</div>

</div>

<script>
	var groupColumn = 1;
    var table = $('.table_pt_jptx').DataTable({
    columnDefs: [{ visible: false, targets: groupColumn},
    { "searchable": false, "targets": [11] }],
    order: [[9, 'desc']],
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
                            '<tr class="group"><td colspan="13">'+no+'. '+
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
