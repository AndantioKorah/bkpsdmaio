<?php if($result){ ?>

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
        width:90% !important;
	}

    .tdno {
		background-color: #2e4963 !important;
		color: #fff;
        width:2% !important;
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
<table  class="display table table-bordered potensial_jpt" >
        <thead>
            <tr>
                <!-- <th>Jabatan Target</th> -->
                <th valign="middle">No</th>
                <th valign="middle" class="text-center">Nama</th>
                <th style="width:10%" class="text-center">Nilai Asessment (50%)</th>
                <th style="width:10%" class="text-center">Nilai Rekam<br> Jejak (40%)</th>
                <th style="width:5%" class="text-center">Nilai Pertimbangan Lainnya (10%)</th>
                <th class="text-center">Total Nilai</th>
				<th class="text-center">Pemeringkatan</th>
				<th></th>
            </tr>
        </thead>
        <tbody>
		<?php $no = 1; foreach($result as $rs2){ ?>
			<?php $total_nilai = $rs2['res_potensial_cerdas'] + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];?>
            <tr>
                <td class="text-center tdno" style="display:nonex"><?=$no++;?> </td>
                <td  class="tdnama"><a target="_blank" href="<?= base_url('kepegawaian/profil-pegawai/')?><?=$rs2['nipbaru_ws'];?>" style="color:#fff"><b><?=$rs2['gelar1'];?> <?=$rs2['nama'];?> <?=$rs2['gelar2'];?></b> <br> NIP. <?=formatNip($rs2['nipbaru_ws']);?></a><br><i><?=$rs2['jabatan_sekarang'];?></i></td>
                <td class="text-center"><?php if($rs2['res_potensial_cerdas']) echo $rs2['res_potensial_cerdas']; else echo "0.00" ;?></td>
                <td class="text-center"><?php if($rs2['res_potensial_rj']) echo $rs2['res_potensial_rj']; else echo "0.00" ;?></td>
                <td class="text-center"><?php if($rs2['res_potensial_lainnya']) echo $rs2['res_potensial_lainnya']; else echo "0.00" ;?></td>
                <td class="text-center"><?=$total_nilai;?></td>
				<td class="text-center"><?= pemeringkatanKriteriaPotensial($total_nilai)?></td>
				<td>
				<button data-toggle="modal" data-id="<?=$rs2['id_pegawai']?>" data-nip="<?=$rs2['nipbaru']?>" data-jt="<?=$rs2['id_jabatan_target']?>" data-kode="<?=$kode;?>" data-jenispengisian="<?=$jenis_pengisian;?>"
										href="#modal_penilaian_potensial" title="Ubah Data" class="open-DetailPenilaian btn btn-sm btn-info">
										<i class="fa fa-edit"></i></button>
				</td>
            </tr>
			<?php } ?>
            
        </tbody>
        <tfoot>
            <tr>
			<!-- <th>Jabatan Target</th> -->
            <th valign="middle">No</th>
                <th valign="middle" class="text-center">Nama</th>
                <th style="width:10%" class="text-center">Nilai Asessment (50%)</th>
                <th style="width:10%" class="text-center">Nilai Rekam<br> Jejak (40%)</th>
                <th style="width:5%" class="text-center">Nilai Pertimbangan Lainnya (10%)</th>
                <th class="text-center">Total Nilai</th>
				<th class="text-center">Pemeringkatan</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>

</div>

<script>
     $(function(){
    // $('.datatable').dataTable()
  })
	var groupColumn = 1;
    var table = $('.potensial_jpt').DataTable({
        

    // columnDefs: [{ visible: false, targets: groupColumn },
    // {targets: 0,orderable: false}],
    // order: [[groupColumn, 'asc']],
    displayLength: 100,
    // drawCallback: function (settings) {
    //     var api = this.api();
    //     var rows = api.rows({ page: 'current' }).nodes();
    //     var last = null;
 
    //     api.column(groupColumn, { page: 'current' })
    //         .data()
    //         .each(function (group, i) {
    //             if (last !== group) {
    //                 $(rows)
    //                     .eq(i)
    //                     .before(
    //                         '<tr class="group"><td colspan="7">' +
    //                             group +
    //                             '</td></tr>'
    //                     );
 
    //                 last = group;
    //             }
    //         });
    // }
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
