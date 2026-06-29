
 <style>
   table {
      /* font-size: 14px;  */
    }
 </style>


<?php if(isset($list_pegawai)) { ?>

<p>
    
</p>
    <div class="row">
 	<div class="col-lg-12">
 		<div class="card card-default">
 			<div class="row p-3">
 				<div class="col-md-12 col-sm-12">
<h3><?= $nama_laporan;;?></h3>
 <div class="row">
 	<div class="col-lg-12 table-responsive">
 		<table class="table table-hover table-striped thead-dark datatable">
 			<thead>
 				<th class="text-left">No</th>
 				<th class="text-left">Nama</th>
 				<th class="text-left">NIP</th>
 				<th class="text-left">Unit Kerja</th>
 				<th class="text-left">Jabatan</th>


 			</thead>
 			<tbody>
 				<?php $no = 1; $total_perempuan = 0; $total_laki = 0; foreach($list_pegawai as $rs){ ?>
 				<tr>
 					<td class="text-left"><?=$no++;?></td>
 					<td class="text-left"><?= getNamaPegawaiFull($rs)?></td>
 					<td class="text-left"><?= $rs['nipbaru_ws']?></td>
 					<td class="text-left"><?= $rs['nm_unitkerja']?></td>
 					<td class="text-left"><?= $rs['nama_jabatan']?></td>

 	
 				</tr>
                <?php } ?>
 			</tbody>
 		</table>
 	</div>
 </div>

			</div>
 			</div>
 		</div>
 	</div>
 </div>
<?php } ?>

<script>
	    $(document).ready( function() {
		$('.datatable').dataTable({
			"pageLength": 25
		}) 
  		$('.select2-navy').select2()
        //   var table = $('.datatable').DataTable({
        //    "pageLength": 25,
        //    dom: 'Bfrtip', 
        //    buttons: [
        //         {
        //             extend: 'excel',
        //             orientation: 'landscape',
        //             title: 'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Tingkat Pendidikan',
        //             // messageTop:
        //             //     'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Tingkat Pendidikan'
        //         },
        //         {
        //             extend: 'pdf',
        //             orientation: 'landscape',
        //             title: 'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Tingkat Pendidikan'
        //         }
        //    ],
        // });

		} )



</script>