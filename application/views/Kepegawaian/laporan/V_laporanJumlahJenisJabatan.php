<?php
 $filename = 'Rincian ASN Kota Manado '.formatDateNamaBulan(date('Y-m-d')).'.xls';
    // header("Content-type: application/vnd-ms-excel");
    // header("Content-Disposition: attachment; filename=$filename");
?>
<div class="card card-default">
    <div class="row">
 	<div class="col-lg-12 mt-2">
		 <form  method="post" enctype="multipart/form-data" class="float-right" action="<?=base_url('kepegawaian/C_Kepegawaian/laporanJumlahASNPdf')?>" target="_blank">
			<input type="hidden" name="jenis_laporan" value="<?=$jenis_laporan;?>">
                <button type="submit" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Download as PDF</button>
		</form>
		 <form  method="post" enctype="multipart/form-data" class="float-right mr-1" action="<?=base_url('kepegawaian/C_Kepegawaian/laporanJumlahASNExcel')?>" target="_blank">
			<input type="hidden" name="jenis_laporan" value="<?=$jenis_laporan;?>">
                <button type="submit" class="btn btn-success"><i class="fa fa-file"></i> Download as Excel</button>
		</form>

		
	</div>
</div>

    <div class="card-header" style="margin-bottom:-40px">
        <!-- <h4>Jabatan Fungsional</h4> -->
    </div>
    <div class="card-body " >
<?php if($result) { ?>
         <table id="example" class="table table-sm datatable" style="border: 0px black solid;" border-collapse="collapse">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-left">Unit Kerja</th>
                                    <th class="text-center">Struktural</th>
                                    <th class="text-center">Fungsional</th>
                                    <th class="text-center">Pelaksana</th>



                                </thead>
                                <tbody>
                                    <?php $no=1; 
                                      $skpd_total_struktural = 0; 
                                        $skpd_total_jft = 0; 
                                        $skpd_total_pelaksana =0;
                                    foreach($result['skpd'] as $lj){ ?>
                                   
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="text-left"><?=$lj['nama']?></td>
                                            <td class="text-center"><?php if(isset($lj['total_struktural'])) echo $lj['total_struktural']; else echo 0;?></td>
                                            <td class="text-center"><?php if(isset($lj['total_jft'])) echo $lj['total_jft']; else echo 0;?></td>
                                            <td class="text-center"><?php if(isset($lj['total_pelaksana'])) echo $lj['total_pelaksana']; else echo 0;?></td>
                                           
                                        </tr>
                                     <?php  
                                    if(isset($lj['total_struktural'])){
                                        $skpd_total_struktural += $lj['total_struktural']; 
                                    }
                                        if(isset($lj['total_jft'])){
                                        $skpd_total_jft += $lj['total_jft']; 
                                    }
                                        if(isset($lj['total_pelaksana'])){
                                        $skpd_total_pelaksana += $lj['total_pelaksana']; 
                                    }
                                    }  ?>

                                    
                                </tbody>
                            </table>
                            <?php } ?>
    </div>
</div>

<div class="row">
    
</div>
<script>
     $(function(){
    // $('.datatable').dataTable()

    	$('.datatable').dataTable({
			"pageLength": 25
		}) 

        //      new DataTable('#example', {
        //     lengthMenu: [10, 25, 50, -1]
        // });

  })


function deleteData(id){           
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteKebutuhanJf/")?>'+id,
                           method: 'post',
                           data: null,
                           success: function(){
                            loadListkebutuhanJf()
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }

function editKebutuhan(id){


     var kebutuhan = $('#kebutuhan_edit_'+id).val()

     if(kebutuhan != ""){
        $.ajax({
            url: '<?=base_url("kepegawaian/C_Kepegawaian/editKebutuhanJf/")?>'+'/'+id,
            method: 'post',
            data: {
                kebutuhan : kebutuhan,
              
            },
            success: function(res){
                   var result = JSON.parse(res); 
                console.log(result)
                successtoast(result.msg)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
     } 
        
    }
</script>
