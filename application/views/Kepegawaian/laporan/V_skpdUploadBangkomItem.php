<div class="card card-default">
    
 <div class="row">
 	<div class="col-lg-12">
	
		

		
	</div>
</div>

    <div class="card-header" style="margin-bottom:-40px">
    
 <form  method="post" enctype="multipart/form-data" class="float-right mr-1 mb-4" action="<?=base_url('kepegawaian/C_Kepegawaian/openListUploadBangkomSkpdItemExcel')?>" target="_blank">
			<input type="hidden" name="tahun" value="<?=$tahun;?>">
            	<input type="hidden" name="bulan" value="<?=$bulan;?>">
                <button type="submit" class="btn btn-success"><i class="fa fa-file"></i> Download as Excel</button>
		</form>
    </div>


    <div class="card-body table-responsive" >
<?php if($result) { ?>
         <table class="table datatable" style="border: 0px black solid;" border-collapse="collapse">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-left" style="width:10%;">Nama </th>
                                    <th class="text-center">Unit Kerja</th>
                                    <th class="text-center">Tahun</th>
                                    <th class="text-center">Bulan</th>
                                    <th class="text-center">Data Bangkom</th>
                                    <!-- <th class="text-center">Total JP</th> -->
                                    <th class="text-center">Status</th>

                                    

                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($result as $lj){ ?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="text-left"><?= getNamaPegawaiFull($lj)?></td>
                                            <td class="text-center"><?=$lj['nm_unitkerja']?></td>
                                            <td class="text-center"><?=$tahun?></td>
                                            <td class="text-center"><?= getNamaBulan($bulan)?></td>
                                            <td class="text-center"><?php if($lj['id'] == null) echo "-"; else echo "Ada";?></td>
                                            <!-- <td class="text-center"><?=$lj['total_jp']?></td> -->
                                            <td class="text-center">
                                                <?php if($lj['status'] == null) echo "-"; else if($lj['status'] == 2) echo "Sudah Verif"; else echo "Belum Verif";?>
                                            </td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php } else { ?>
                            <h5>Belum ada data </h5>
                            <?php } ?>
    </div>
</div>

<div class="row">
    
</div>

<script>
      $(function(){
    // $('.datatable').dataTable()
    	$('.datatable').dataTable({
			"pageLength": 50
		}) 
  })
</script>