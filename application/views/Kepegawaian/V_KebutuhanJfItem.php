<div class="card card-default">
    <div class="card-header" style="margin-bottom:-40px">
        <!-- <h4>Jabatan Fungsional</h4> -->
    </div>
    <div class="card-body " >
<?php if($result) { ?>
         <table id="example" class="table table-sm datatable" style="border: 0px black solid;" border-collapse="collapse">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-left">Nama Jabatan</th>
                                    <th class="text-center">Unit Kerja</th>
                                    <th class="text-center">Kebutuhan</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($result as $lj){ ?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="text-left"><?=$lj['nama_jabatan']?></td>
                                            <td class="text-center"><?=$lj['nm_unitkerja']?></td>
                                            <td class="text-center">
                                                <input onkeyup="editKebutuhan(<?=$lj['id']?>)" type="text" class="text-center"  id="kebutuhan_edit_<?=$lj['id']?>" value="<?=$lj['kebutuhan']?>" size="4">
                                        </td>
                                            <td>              
                                                <button onclick="deleteData('<?=$lj['id']?>' )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php } else { ?>
                            <h5>Tidak ada Jabatan Fungsional</h5>
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
