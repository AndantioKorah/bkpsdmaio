<!-- <p>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado per Kecamatan</p>
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
  </div> -->

  <p>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Tingkat Pendidikan</p>
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
            <?php $no = 1; $total_perempuan = 0; $total_laki = 0; foreach($pendidikan['pendidikan']   as $rs){ ?>
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


 

