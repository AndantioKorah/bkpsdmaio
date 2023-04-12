<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-striped datatable" id="datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Jenis Penugasan</th>
          <th class="text-left">Tujuan</th>
          <th class="text-left">Pejabat Yang Menetapkan</th>
          <th class="text-left">Nomor SK</th>
          <th class="text-left">Tanggal SK</th>
          <th class="text-left">Lamanya</th>



        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_jenistugas']?></td>
              <td class="text-left"><?= $rs['tujuan']?></td>          
              <td class="text-left"><?= $rs['pejabat']?></td> 
              <td class="text-left"><?= $rs['nosk']?></td> 
              <td class="text-left"><?= $rs['tglsk']?></td> 
              <td class="text-left"><?= $rs['lamanya']?></td> 
              
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>


 
<script>
  $(function(){
    $('.datatable').dataTable()
  })


</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>