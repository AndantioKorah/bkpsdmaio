<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
    <form method="post" id="form_hasil"  enctype="multipart/form-data" >
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered" >
        <thead style="background-color:#222e3c;color:#fff;">
          <th class="text-left">Kriteria</th>
          <th class="text-left" style="width:25%;">Skor</th>
          <th></th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
                <td>
                <input type="hidden" name="id[]"  value="<?=$rs['id']?>" />
                <textarea name="nm_kriteria[]"  class="form-control hsl"  rows="3" ><?=$rs['nm_kriteria']?></textarea>
                <!-- <input type="text" class="form-control" value="<?=$rs['nm_kriteria']?>"> -->
                </td>
                <td >
                <input  name="skor[]" type="number" class="form-control" value="<?=$rs['skor']?>" autocomplete="off">
                </td>
                <td>
                <a onclick="deleteDataKriteria('<?=$rs['id']?>')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </a>
                </td>
            </tr>
          <?php } ?>
           
        </tbody>
      </table>
      </div>
      <div class="modal-footer" style="margin-bottom:5px;">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      <button type="submit" class="btn btn-navy "> Simpan</button> 
      </div>
      </form>
    </div>
  </div>
       

 
<script>
 $('#form_hasil').on('submit', function(event){
    var base_url = "<?=base_url();?>";
    var count_data = 0;
	event.preventDefault();
	
  $('.hsl').each(function(){
   count_data = count_data + 1;
  });
  console.log(count_data)
  if(count_data > 0)
  {
   var form_data = $(this).serialize();
   $.ajax({
	url:  base_url + "simata/C_Simata/updateKriteria",
    // url:"insert.php",
    method:"post",
	data:form_data,
	
    success:function(res){ 
           console.log(res)
           var result = JSON.parse(res); 
           console.log(result)
           if(result.success == true){
               successtoast(result.msg)
               loadListKriteria()
             } else {
               errortoast(result.msg)
               return false;
             } 
           
       } 
   })
  }
  else
  {
   $('#action_alert').html('<p>Please Add atleast one data</p>');
   $('#action_alert').dialog('open');
  }
 });

 function deleteDataKriteria(id){
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("simata/C_Simata/deleteDataKriteria/")?>'+id,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               loadListKriteria()
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }
</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>