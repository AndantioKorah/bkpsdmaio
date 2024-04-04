<?php if($result){ ?>
<style>
	.list-group-item {
		background-color: #222e3c;
		border-color: var(--bs-list-group-active-border-color);
		color: var(--bs-list-group-active-color);
		/* z-index: 2; */
	}

</style>

<div class="table-responsive">


<style>
	tr.group,
	tr.group:hover {
		background-color: #2e4963 !important;
		color: #fff;
	}

    .tdnama {
		background-color: #2e4963 !important;
		color: #fff;
	}

	/* table {
    counter-reset: 1;
    }

    table tr {
        counter-increment: rowNumber;
    }

    table tr td:first-child::before {
        content: counter(rowNumber);
        min-width: 1em;
        margin-right: 0.5em;
    } */
</style>
<table id="kinerja_jptx" class="display table table-bordered kinerja_jpt" style="width:100%">
        <thead>
            <tr>
                <!-- <th>Jabatan Target</th> -->
                <th class="text-center" style="width:5%">No</th>
                <th class="text-center">Nama</th>
                <th>Nilai Kinerja</th>
				<th>Pemeringkatan</th>
				<th></th>
            </tr>
        </thead>
        <tbody>
		<?php $no = 1; foreach($result as $rs2){ ?>
            <tr>
                <!-- <td><?=$rs2['nama_jabatan'];?></td> -->
                <td class="text-center tdnama"><?=$no++;?></td>
                <td class="tdnama"><a target="_blank" href="<?= base_url('kepegawaian/profil-pegawai/')?><?=$rs2['nipbaru_ws'];?>" style="color:#fff"><b><?=$rs2['gelar1'];?> <?=$rs2['nama'];?> <?=$rs2['gelar2'];?></b> | NIP. <?=formatNip($rs2['nipbaru_ws']);?></a><br><i><?=$rs2['jabatan_sekarang'];?></i></td>

                 <td class="text-center"><?php if($rs2['res_kinerja']) echo $rs2['res_kinerja']; else echo "0" ;?></td>
				<td class="text-center"><?= pemeringkatanKriteriaKinerja($rs2['res_kinerja'])?></td>
				<td>
				<button data-toggle="modal" data-id="<?=$rs2['id_pegawai']?>" data-nip="<?=$rs2['nipbaru']?>" data-jt="<?=$rs2['id_jabatan_target']?>" data-kode="<?=$kode;?>" 
										href="#modal_penilaian_kinerja" title="Ubah Data" class="open-DetailPenilaian btn btn-sm btn-info">
										<i class="fa fa-edit"></i></button>
				</td>
            </tr>
			<?php  } ?>
             
        </tbody>
        <tfoot>
            <tr>
			<!-- <th>Jabatan Target</th> -->
            <th>Nama</th>
                <th>Nilai Kinerja</th>
				<th>Pemeringkatan</th>
				<th></th>
            </tr>
        </tfoot>
    </table>
</div>

</div>

<script>


	var groupColumn = 1;
     var table = $('.kinerja_jpt').DataTable({
    // columnDefs: [{ visible: false, targets: groupColumn }],
    // order: [[groupColumn, 'asc']],
    displayLength: 100,
    // drawCallback: function (settings) {
    //     var api = this.api();
    //     var rows = api.rows({ page: 'current' }).nodes();
    //     var last = null;
    //     let no = 0;
       
    //     api.column(groupColumn, { page: 'current' })
    //         .data()
    //         .each(function (group, i) {
    //             if (last !== group) {
    //                 no += 1;
    //                 $(rows)
    //                     .eq(i)
    //                     .before(
    //                         '<tr class="group"><td colspan="7">'+no+'. '+
    //                             group +
    //                             '</td></tr>'
    //                     );
 
    //                 last = group;
    //             }
    //         });
    // }
});
 
// Order by the grouping
// $('#kinerja_jpt tbody').on('click', 'tr.group', function () {
//     var currentOrder = table.order()[0];
//     if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
//         // table.order([groupColumn, 'desc']).draw();
//     }
//     else {
//         // table.order([groupColumn, 'asc']).draw();
//     }
// });
</script>

<script>
	$(function () {
		$('#table-adm').dataTable({
			"ordering": false
		});

		$('#table-adm2').dataTable({
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
