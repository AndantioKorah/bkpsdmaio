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
<div class="table-responsive">
<table id="example2" class="display table table-bordered" style="width:100%;color:#000">
        <thead>
            <tr>
                <th>Jabatan Target</th>
                <th>Nilai Kinerja</th>
                <th>Nama</th>
                <th>Nilai Potensial</th>
                <th>Hasil Pemetaan Talenta</th>
                <th>Peringkat</th>
            </tr>
        </thead>
        <tbody >
		<?php $no = 1; foreach($result as $rs2){ ?>
			<?php $total_nilai = $rs2['res_kinerja'] + $rs2['res_potensial_total'];?>
            <tr>
                <td><?=$rs2['nama_jabatan'];?></td>
                <td class="text-center"><?=$rs2['res_kinerja'];?></td>
                <td><?=$rs2['gelar1'];?><?=$rs2['nama'];?> <?=$rs2['gelar2'];?></td>
                <td class="text-center"><?=$rs2['res_potensial_total'];?> </td>
                <td class="text-center"><?=numberToRoman($kotak);?></td>
                <td class="text-center"><?=$no++;?></td>
				
            </tr>
			<?php } ?>
            
        </tbody>
        <tfoot>
            <tr>
            <th>Jabatan Target</th>
                <th>Nilai Kinerja</th>
                <th>Nama</th>
                <th>Nilai Potensial</th>
                <th>Hasil Pemetaan Talenta</th>
                <th>Peringkat</th>
            </tr>
        </tfoot>
    </table>
    </div>
</div>

</div>

<script>
	var groupColumn = 2;
var table = $('#example2').DataTable({
    order: [[5, 'asc']],
    columnDefs: [{ visible: false, targets: groupColumn },
    {targets: [0],orderable: false}],
    // order: [[groupColumn, 'asc']],
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
$('#example2 tbody').on('click', 'tr.group', function () {
    var currentOrder = table.order()[0];
    if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
        // table.order([groupColumn, 'desc']).draw();
    }
    else {
        // table.order([groupColumn, 'asc']).draw();
    }
});
</script>


<?php } else { ?>
<div class="col-12 text-center">
	<h5>TIDAK ADA DATA !</h5>
</div>
<?php } ?>
