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

    .tdnama {
		background-color: #2e4963 !important;
		color: #fff;
	}
</style>
<div class="col-lg-12 text-right mb-2">
            <form action="<?=base_url('simata/C_Simata/downloadDataSearch')?>" target="_blank">
                <button type="submit" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Download as Pdf</button>
            </form>
        </div>
<table id="kinerja_adm" class="display table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
            <th >Nama</th>
                <th>Jabatan Target</th>
                <th style="width:10%">Nilai (80% Nilai Talent Pool) </th>
               
				<th style="width:10%">Nilai Kompetensi Teknis Bidang (20%) </th>
                <th>Total Nilai </th>
				<th></th>
            </tr>
        </thead>
        <tbody>
		<?php $no = 1; foreach($result as $rs2){ ?>
            <?php 
                $total = $rs2['total']/2;
                $total = $total * 80 / 100;
                $total_kompentesi = $rs2['res_kompetensi'] * 20 / 100;
                $total_nilai = $total + $total_kompentesi;
                
                if($jenis_jabatan == 2){
                    if($rs2['es_jabatan'] == "II A" || $rs2['es_jabatan'] == "II B"){
                        $keterangan = "Rotasi";
                    } else {
                        $keterangan = "Promosi";
                    }
                }

                if($jenis_jabatan == 1){
                    if($rs2['es_jabatan'] == "III A" || $rs2['es_jabatan'] == "III B"){
                        $keterangan = "Rotasi";
                    } else {
                        $keterangan = "Promosi";
                    }
                }
                
                  
                  ?>
            <tr>
                <td class="tdnama"><?=$no++;?></td>
            <td class="tdnama"><a target="_blank" href="<?= base_url('kepegawaian/profil-pegawai/')?><?=$rs2['nipbaru_ws'];?>" style="color:#fff"><b><?=$rs2['gelar1'];?> <?=$rs2['nama'];?> <?=$rs2['gelar2'];?></b> <br> NIP. <?=formatNip($rs2['nipbaru_ws']);?></a><br><i><?=$rs2['jabatan_sekarang'];?></i></td>
                <td><?=$rs2['nama_jabatan'];?></td>
                <td><?=$total;?></td>
				<td><?=$total_kompentesi;?></td>
                <td><?=$total_nilai;?></td>
				<td>
				<button data-toggle="modal" data-id="<?=$rs2['id']?>" data-nip="<?=$rs2['nipbaru']?>" data-jt="<?=$rs2['id_jabatan_target']?>" data-kode="1"
										href="#modal_penilaian_kompetensi" title="Ubah Data" class="open-DetailPenilaian btn btn-sm btn-info">
										<i class="fa fa-edit"></i></button>
				</td>
            </tr>
			<?php } ?>
            
        </tbody>
        <tfoot>
            <tr>
            <th>No</th>
            <th >Nama</th>
                <th>Jabatan Target</th>
                <th>Nilai (80% Nilai Talent Pool) </th>
				<th>Nilai Kompetensi Teknis Bidang (20%) </th>
                <th>Total Nilai </th>
				<th></th>
            </tr>
        </tfoot>
    </table>
</div>

</div>

<script>
	var groupColumn = 2;
var table = $('#kinerja_adm').DataTable({
    // columnDefs: [{ visible: false, targets: groupColumn },
    // {targets: 0,orderable: false}],
    // order: [[groupColumn, 'asc']],
    displayLength: 25,
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
    //                         '<tr class="group"><td colspan="6">' +
    //                             group +
    //                             '</td></tr>'
    //                     );
 
    //                 last = group;
    //             }
    //         });
    // }
});
 
// Order by the grouping
$('#kinerja_adm tbody').on('click', 'tr.group', function () {
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
