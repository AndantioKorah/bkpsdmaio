<!-- <table style="width: 100%;">
	<tr>
		<td valign=bottom >
			<img style="width: 100px;" src="<?=base_url('assets/adminkit/img/logo-pemkot-small.png')?>">
		</td>
		<td colspan="3" valign=bottom style="width: 1900px; text-align:center;">
			<h5 class="top_header_secondary">PEMERINTAH KOTA MANADO<br>
			BADAN KEPEGAWAIAN DAN PENGEMBANGAN <br>
			SUMBER DAYA MANUSIA<br>
			<?= ALAMAT_BKPSDM ?><br>
			website: <?=WEBSITE_BKPSDM?> | email: <?=EMAIL_BKPSDM?>
		</td>
		<td valign=bottom >
			<img style="width: 100px;" src="<?=base_url('assets/adminkit/img/logo-pemkot-small.png')?>">
		</td>
	</tr>
	<tr>
		<td colspan=3 style="border-bottom: 3px solid black;"></td>
	</tr>
</table> -->

<?php if(isset($skpd)) { ?>
 <div class="row">
 	<div class="col-lg-12">
 		<div class="card card-default">
 			<div class="row p-3">
 				<div class="col-md-12 col-sm-12">
 					<span><b>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Unit Kerja Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
 					<div class="row">
 						<div class="col-lg-12 table-responsive">
 						 	<table style="border-collapse: collapse;border: none;width: 111px;" border="1" class="table table-hover table-striped thead-dark datatable" id="pendidikanall" style="width:100%;">
 								<thead>
 									<th style="width: 26.7pt;border: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;" class="text-left">No</th>
 									<th style="width: 26.7pt;border: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;" style="width:70%" class="text-left" >Unit Kerja</th>
 									<th class="text-left">Laki-laki</th>
 									<th class="text-left">Perempuan</th>
 									<th class="text-left">Total</th>
 								</thead>
 								<tbody>
 									<?php $no = 1;  
            $skpd_total_perempuan = 0; 
            $skpd_total_laki = 0; 
             $skpd_belum_terdata_laki =0;
            foreach($skpd['skpd'] as $rs){ ?>
 									<?php if(isset($rs['nama'])){ ?>
 									<tr>
 										<td class="text-left"><?=$no++;?></td>
 										<td class="text-left"><?=$rs['nama']?></td>
 										<td class="text-left"><?=$rs['laki']?></td>
 										<td class="text-left"><?=$rs['perempuan']?></td>
 										<td class="text-left"><?=$rs['laki']+$rs['perempuan']?></td>
 									</tr>
 									<?php 
         $skpd_total_laki += $rs['laki']; 
         $skpd_total_perempuan += $rs['perempuan'];
         } } ?>
		 <tr>
 										<td style="color:#fff;">600</td>
 										<td>Total</td>
 										<td><?=$skpd_total_laki;?></td>
 										<td><?=$skpd_total_perempuan;?></td>
 										<td><?=$skpd_total_laki+$skpd_total_perempuan;?></td>
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
 <?php } ?>

<br>
<?php if(isset($jabatan)) { ?>
 <div class="row">
 	<div class="col-lg-12">
 		<div class="card card-default">
 			<div class="row p-3">
 				<div class="col-md-12 col-sm-12">
 					<span><b>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Jabatan Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
 					<div class="row">
 						<div class="col-lg-12 table-responsive">
 						 	<table border="1" class="table table-hover table-striped thead-dark datatable" id="pendidikanall" style="width:100%;">
 								<thead>
 									<th class="text-left">No</th>
 									<th style="width:70%" class="text-left">Jabatan</th>
 									<th class="text-left">Laki-laki</th>
 									<th class="text-left">Perempuan</th>
 									<th class="text-left">Total</th>
 								</thead>
 								<tbody>
 									<?php $no = 1;  
            $jab_total_perempuan = 0; 
            $jab_total_laki = 0; 
             $jab_belum_terdata_laki =0;
            foreach($jabatan['jabatan'] as $rs){ ?>
 									<?php if(isset($rs['nama'])){ ?>
 									<tr>
 										<td class="text-left"><?=$no++;?></td>
 										<td class="text-left"><?=$rs['nama']?></td>
 										<td class="text-left"><?=$rs['laki']?></td>
 										<td class="text-left"><?=$rs['perempuan']?></td>
 										<td class="text-left"><?=$rs['laki']+$rs['perempuan']?></td>
 									</tr>
 									<?php 
         $jab_total_laki += $rs['laki']; 
         $jab_total_perempuan += $rs['perempuan'];
         } } ?>
		 <tr>
 										<td style="color:#fff;">23</td>
 										<td>Total</td>
 										<td><?=$jab_total_laki;?></td>
 										<td><?=$jab_total_perempuan;?></td>
 										<td><?=$jab_total_laki+$jab_total_perempuan;?></td>
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
 <?php } ?>

 <br>
<?php if(isset($pangkat)) { ?>
 <div class="row">
 	<div class="col-lg-12">
 		<div class="card card-default">
 			<div class="row p-3">
 				<div class="col-md-12 col-sm-12">
 					<span><b>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Pangkat/Golongan Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b><span>
 					<div class="row">
 						<div class="col-lg-12 table-responsive">
 						 	<table border="1" class="table table-hover table-striped thead-dark datatable" id="pendidikanall" style="width:100%;">
 								<thead>
 									<th class="text-left">No</th>
 									<th style="width:70%" class="text-left">Pangkat/Golongan</th>
 									<th class="text-left">Laki-laki</th>
 									<th class="text-left">Perempuan</th>
 									<th class="text-left">Total</th>
 								</thead>
 								<tbody>
 									<?php $no = 1;  
            $gol_total_perempuan = 0; 
            $gol_total_laki = 0; 
             $gol_belum_terdata_laki =0;
            foreach($pangkat['pangkat'] as $rs){ ?>
 									<?php if(isset($rs['nama'])){ ?>
 									<tr>
 										<td class="text-left"><?=$no++;?></td>
 										<td class="text-left"><?=$rs['nama']?></td>
 										<td class="text-left"><?=$rs['laki']?></td>
 										<td class="text-left"><?=$rs['perempuan']?></td>
 										<td class="text-left"><?=$rs['laki']+$rs['perempuan']?></td>
 									</tr>
 									<?php 
         $gol_total_laki += $rs['laki']; 
         $gol_total_perempuan += $rs['perempuan'];
         } } ?>
		 <tr>
 										<td style="color:#fff;">23</td>
 										<td>Total</td>
 										<td><?=$gol_total_laki;?></td>
 										<td><?=$gol_total_perempuan;?></td>
 										<td><?=$gol_total_laki+$gol_total_perempuan;?></td>
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
 <?php } ?>

 <br>
<?php if(isset($pendidikan)) { ?>
 <div class="row">
 	<div class="col-lg-12">
 		<div class="card card-default">
 			<div class="row p-3">
 				<div class="col-md-12 col-sm-12">
 					<span><b>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Tingkat Pendidikan Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
 					<div class="row">
 						<div class="col-lg-12 table-responsive">
 						 	<table border="1" class="table table-hover table-striped thead-dark datatable" id="pendidikanall" style="width:100%;">
 								<thead>
 									<th class="text-left">No</th>
 									<th style="width:70%" class="text-left">Pendidikan</th>
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
 <?php } ?>

<br>
<?php if(isset($pendidikan_pns)) { ?>
  <div class="row">
 	<div class="col-lg-12">
 		<div class="card card-default">
 			<div class="row p-3">
 				<div class="col-md-12 col-sm-12">
<span><b>Jumlah Pegawai Negeri Sipil (PNS) Pemerintah Kota Manado Menurut Tingkat Pendidikan Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
 <div class="row">
 	<div class="col-lg-12 table-responsive">
 	  <table border="1" class="table table-hover table-striped thead-dark datatable" id="pendidikanpns">
 			<thead>
 				<th class="text-left">No</th>
 				<th style="width:70%" class="text-left">Pendidikan</th>
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
 		<?php if($belum_terdata_laki_pns+$belum_terdata_perempuan_pns != 0) { ?>
 				<tr>
 					<td>11</td>
 					<td>Belum terdata</td>
 					<td><?=$belum_terdata_laki_pns;?></td>
 					<td><?=$belum_terdata_perempuan_pns;?></td>
 					<td><?=$belum_terdata_laki_pns+$belum_terdata_perempuan_pns;?></td>
 				</tr>
		<?php } ?>
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
<?php } ?>

<br>
<?php if(isset($pendidikan_pppk)) { ?>
   <div class="row">
 	<div class="col-lg-12">
 		<div class="card card-default">
 			<div class="row p-3">
 				<div class="col-md-12 col-sm-12">
<span><b>Jumlah Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Pemerintah Kota Manado Menurut Tingkat Pendidikan Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
 <div class="row">
 	<div class="col-lg-12 table-responsive">
 		<table border="1" class="table table-hover table-striped thead-dark datatable">
 			<thead>
 				<th class="text-left">No</th>
 				<th style="width:70%" class="text-left">Pendidikan</th>
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
<?php } ?>

<br>
<?php if(isset($kecamatan)) { ?>
    <div class="row">
 	<div class="col-lg-12">
 		<div class="card card-default">
 			<div class="row p-3">
 				<div class="col-md-12 col-sm-12">
<span><b>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado per Kecamatan Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
 <div class="row">
 	<div class="col-lg-12 table-responsive">
 		<table border="1" class="table table-hover table-striped thead-dark datatable">
 			<thead>
 				<th class="text-left">No</th>
 				<th style="width:70%" class="text-left">Kecamatan</th>
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
<?php } ?>
 