<h3>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Tingkat Pendidikan</h3>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
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
            <td></td>
            <td>Total</td>
            <td><?=$total_laki+$belum_terdata_laki;?></td>
            <td><?=$total_perempuan+$belum_terdata_perempuan;?></td>
            <td><?=$total_laki+$total_perempuan+$belum_terdata_laki+$belum_terdata_perempuan;?></td>
         </tr>
        </tbody>
      </table>
    </div>
  </div>


<br>
<h3>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado per Kecamatan</h3>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
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
