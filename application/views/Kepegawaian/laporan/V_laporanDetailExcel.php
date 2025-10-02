<?php

    $filename = 'DATA Jumlah ASN Kota Manado '.formatDateNamaBulan(date('Y-m-d')).'.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=$filename");
?>
 
 <div class="row">
 	<div class="col-lg-12">
 		<div class="card card-default">
 			<div class="row p-3">
 				<div class="col-md-12 col-sm-12">
 					<span><b>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Tingkat Pendidikan</b></span>
 					<div class="row">
 						<div class="col-lg-12 table-responsive">
 						 	<table border="1" class="table table-hover table-striped thead-dark datatable" id="pendidikanall" style="width:100%;">
 								<thead>
 									<th class="text-left">No</th>
 									<th class="text-left">Pendidikan</th>
 									<th class="text-left">Laki-laki</th>
 									<th class="text-left">Perempuan</th>
 									<th class="text-left">Total</th>
 								</thead>
 								<tbody>
 									<?php $no = 1;  
            $total_perempuan = 0; 
            $total_laki = 0; 
             $belum_terdata_laki =0;
            foreach($pendidikan['pendidikan'] as $rs){ ?>
 									<?php if(isset($rs['nama'])){ ?>
 									<tr>
 										<td class="text-left"><?=$no++;?></td>
 										<td class="text-left"><?=$rs['nama']?></td>
 										<td class="text-left"><?=$rs['laki']?></td>
 										<td class="text-left"><?=$rs['perempuan']?></td>
 										<td class="text-left"><?=$rs['laki']+$rs['perempuan']?></td>
 									</tr>
 									<?php 
         $total_laki += $rs['laki']; 
         $total_perempuan += $rs['perempuan'];
         $belum_terdata_laki = $pendidikan['pendidikan']['belum_terdata']['laki'];
         $belum_terdata_perempuan = $pendidikan['pendidikan']['belum_terdata']['perempuan'];
         } } ?>
 									<tr>
 										<td>11</td>
 										<td>Belum terdata</td>
 										<td><?=$belum_terdata_laki;?></td>
 										<td><?=$belum_terdata_perempuan;?></td>
 										<td><?=$belum_terdata_laki+$belum_terdata_perempuan;?></td>
 									</tr>
 									<tr>
 										<td style="color:#fff;">12</td>
 										<td>Total</td>
 										<td><?=$total_laki+$belum_terdata_laki;?></td>
 										<td><?=$total_perempuan+$belum_terdata_perempuan;?></td>
 										<td><?=$total_laki+$total_perempuan+$belum_terdata_laki+$belum_terdata_perempuan;?></td>
 									</tr>
 								</tbody>
 							</table>
 						</div>
 					</div>

 				</div>
 			</div>
 		</div>
 	</div>
 </div>

<br>
  <div class="row">
 	<div class="col-lg-12">
 		<div class="card card-default">
 			<div class="row p-3">
 				<div class="col-md-12 col-sm-12">
<span><b>Jumlah Pegawai Negeri Sipil (PNS) Pemerintah Kota Manado Menurut Tingkat Pendidikan</b></span>
 <div class="row">
 	<div class="col-lg-12 table-responsive">
 	  <table border="1" class="table table-hover table-striped thead-dark datatable" id="pendidikanpns">
 			<thead>
 				<th class="text-left">No</th>
 				<th class="text-left">Pendidikan</th>
 				<th class="text-left">Laki-laki</th>
 				<th class="text-left">Perempuan</th>
 				<th class="text-left">Total</th>
 			</thead>
 			<tbody>
 				<?php $no = 1;  
            $total_perempuan_pns = 0; 
            $total_laki_pns = 0; 
             $belum_terdata_laki_pns =0;
            foreach($pendidikan_pns['pendidikan'] as $rs){ ?>
 				<?php if(isset($rs['nama'])){ ?>
 				<tr>
 					<td class="text-left"><?=$no++;?></td>
 					<td class="text-left"><?=$rs['nama']?></td>
 					<td class="text-left"><?=$rs['laki']?></td>
 					<td class="text-left"><?=$rs['perempuan']?></td>
 					<td class="text-left"><?=$rs['laki']+$rs['perempuan']?></td>
 				</tr>
 				<?php 
         $total_laki_pns += $rs['laki']; 
         $total_perempuan_pns += $rs['perempuan'];
         $belum_terdata_laki_pns = $pendidikan_pns['pendidikan']['belum_terdata']['laki'];
         $belum_terdata_perempuan_pns = $pendidikan_pns['pendidikan']['belum_terdata']['perempuan'];
         } } ?>
 				<tr>
 					<td>11</td>
 					<td>Belum terdata</td>
 					<td><?=$belum_terdata_laki_pns;?></td>
 					<td><?=$belum_terdata_perempuan_pns;?></td>
 					<td><?=$belum_terdata_laki_pns+$belum_terdata_perempuan_pns;?></td>
 				</tr>
 				<tr>
 					<td style="color:#fff;">12</td>
 					<td>Total</td>
 					<td><?=$total_laki_pns+$belum_terdata_laki_pns;?></td>
 					<td><?=$total_perempuan_pns+$belum_terdata_perempuan_pns;?></td>
 					<td><?=$total_laki_pns+$total_perempuan_pns+$belum_terdata_laki_pns+$belum_terdata_perempuan_pns;?></td>
 				</tr>
 			</tbody>
 		</table>
 	</div>
 </div>
        </div>
 			</div>
 		</div>
 	</div>
 </div>

<br>
   <div class="row">
 	<div class="col-lg-12">
 		<div class="card card-default">
 			<div class="row p-3">
 				<div class="col-md-12 col-sm-12">
<span><b>Jumlah Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Pemerintah Kota Manado Menurut Tingkat
 	Pendidikan</b></span>
 <div class="row">
 	<div class="col-lg-12 table-responsive">
 		<table border="1" class="table table-hover table-striped thead-dark datatable">
 			<thead>
 				<th class="text-left">No</th>
 				<th class="text-left">Pendidikan</th>
 				<th class="text-left">Laki-laki</th>
 				<th class="text-left">Perempuan</th>
 				<th class="text-left">Total</th>
 			</thead>
 			<tbody>
 				<?php $no = 1;  
            $total_perempuan_pppk = 0; 
            $total_laki_pppk = 0; 
             $belum_terdata_laki_pppk =0;
            foreach($pendidikan_pppk['pendidikan'] as $rs){ ?>
 				<?php if(isset($rs['nama'])){ ?>
 				<tr>
 					<td class="text-left"><?=$no++;?></td>
 					<td class="text-left"><?=$rs['nama']?></td>
 					<td class="text-left"><?=$rs['laki']?></td>
 					<td class="text-left"><?=$rs['perempuan']?></td>
 					<td class="text-left"><?=$rs['laki']+$rs['perempuan']?></td>
 				</tr>
 				<?php 
         $total_laki_pppk += $rs['laki']; 
         $total_perempuan_pppk += $rs['perempuan'];
         $belum_terdata_laki_pppk = $pendidikan_pppk['pendidikan']['belum_terdata']['laki'];
         $belum_terdata_perempuan_pppk = $pendidikan_pppk['pendidikan']['belum_terdata']['perempuan'];
         } } ?>
 				<tr>
 					<td>11</td>
 					<td>Belum terdata</td>
 					<td><?=$belum_terdata_laki_pppk;?></td>
 					<td><?=$belum_terdata_perempuan_pppk;?></td>
 					<td><?=$belum_terdata_laki_pppk+$belum_terdata_perempuan_pppk;?></td>
 				</tr>
 				<tr>
 					<td></td>
 					<td>Total</td>
 					<td><?=$total_laki_pppk+$belum_terdata_laki_pppk;?></td>
 					<td><?=$total_perempuan_pppk+$belum_terdata_perempuan_pppk;?></td>
 					<td><?=$total_laki_pppk+$total_perempuan_pppk+$belum_terdata_laki_pppk+$belum_terdata_perempuan_pppk;?></td>
 				</tr>
 			</tbody>
 		</table>
 	</div>
 </div>
        </div>
 			</div>
 		</div>
 	</div>
 </div>

<br>
    <div class="row">
 	<div class="col-lg-12">
 		<div class="card card-default">
 			<div class="row p-3">
 				<div class="col-md-12 col-sm-12">
<span><b>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado per Kecamatan</b></span>
 <div class="row">
 	<div class="col-lg-12 table-responsive">
 		<table border="1" class="table table-hover table-striped thead-dark datatable">
 			<thead>
 				<th class="text-left">No</th>
 				<th class="text-left">Kecamatan</th>
 				<th class="text-left">Laki-laki</th>
 				<th class="text-left">Perempuan</th>
 				<th class="text-left">Total</th>
 			</thead>
 			<tbody>
 				<?php $no = 1; $total_perempuan = 0; $total_laki = 0; foreach($kecamatan['unitkerjamaster']   as $rs){ ?>
 				<tr>
 					<td class="text-left"><?=$no++;?></td>
 					<td class="text-left"><?=$rs['nama']?></td>
 					<td class="text-left"><?=$rs['laki']?></td>
 					<td class="text-left"><?=$rs['perempuan']?></td>
 					<td class="text-left"><?=$rs['laki']+$rs['perempuan']?></td>
 				</tr>
 				<?php 
         $total_laki += $rs['laki']; 
         $total_perempuan += $rs['perempuan']; } ?>
 				<tr>
 					<td></td>
 					<td>Total</td>
 					<td><?=$total_laki;?></td>
 					<td><?=$total_perempuan;?></td>
 					<td><?=$total_laki+$total_perempuan;?></td>
 				</tr>
 			</tbody>
 		</table>
 	</div>
 </div>

			</div>
 			</div>
 		</div>
 	</div>
 </div>
 