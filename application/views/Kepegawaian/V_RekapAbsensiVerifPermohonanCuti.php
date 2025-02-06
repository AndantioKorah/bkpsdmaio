<style>
  #table_rekap_absensi, #table_rekap_absensi th, #table_rekap_absensi td{
    border: 1px solid black;
    border-collapse: collapse;
    text-align: center;
  }
</style>
<div class="table-responsive">
  <table id="table_rekap_absensi" class="table">
    <thead>
      <tr>
        <th rowspan=2>No</th>
        <th rowspan=2>Periode</th>
        <th rowspan=2>Gol/Ruang</th>
        <th rowspan=2>Jabatan</th>
        <th rowspan=2>Eselon</th>
        <th rowspan=2>JHK</th>
        <th rowspan=1 colspan=<?=count($list_disiplin_kerja)+1?>>KETERANGAN</th>
        <th rowspan=2>% H</th>
      </tr>
      <tr>
        <th rowspan=1 colspan=1><span title="Hadir">H</span></th>
        <?php foreach($list_disiplin_kerja as $l){ ?>
          <th rowspan=1 colspan=1><span title="<?=$l['nama_jenis_disiplin_kerja']?>"><?=strtoupper($l['keterangan'])?></span></th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; foreach($data_absen as $d){
        $golruang = explode(", ", $data_rekap['nm_pangkat']);
        $presentase_hadir = ($d['data']['hadir'] / $d['data']['jhk']) * 100
      ?>
        <tr>
          <td class="text-center"><?=$no++;?></td>
          <td class="text-left"><?=getNamaBulan($d['bulan']).' '.$d['tahun']?></td>
          <td class="text-center"><?=isset($golruang[1]) ? $golruang[1] : ''?></td>
          <td class="text-center"><?=$data_rekap['nama_jabatan']?></td>
          <td class="text-center"><?=$data_rekap['eselon'] == "Non Eselon" ? "" : $data_rekap['eselon']?></td>
          <td style="width: 5% !important;" class="text-center"><?=$d['data']['jhk']?></td>
          <td style="width: 5% !important;" class="text-center"><?=$d['data']['hadir']?></td>
          <?php foreach($list_disiplin_kerja as $ld){ ?>
            <td class="text-center">
              <?=isset($d['data']['rincian_pengurangan_dk'][$ld['keterangan']]) ? $d['data']['rincian_pengurangan_dk'][$ld['keterangan']] == 0 ? "" : $d['data']['rincian_pengurangan_dk'][$ld['keterangan']] : ""?>
            </td>
          <?php } ?>
          <td style="width: 5% !important;" class="text-center"><?=formatCurrencyWithoutRp($presentase_hadir, 2).' %'?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>