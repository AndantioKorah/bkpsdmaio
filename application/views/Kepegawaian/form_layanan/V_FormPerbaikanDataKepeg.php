<form method="post" id="form_perbaikan_data" enctype="multipart/form-data">
    <input type="hidden" name="jenis_layanan" id="jenis_layanan" value="12">
	<!-- <div class="mb-3">
		<label for="exampleInputPassword1" class="form-label">Nomor Usul</label>
		<input type="text" class="form-control" id="nomor_usul" name="nomor_usul">
	</div> -->

	<div class="mb-3">
		<!-- <label for="" class="form-label ">Tanggal Usul</label> -->
		<input type="hidden" class="form-control datepicker" id="tanggal_usul" name="tanggal_usul"
			value="<?= date('Y-m-d');?>">
	</div>


	<div class="mb-3">
		<label heigt="200px;" for="" class="form-label ">Perbaikan data yang dimaksud</label>
		<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="keterangan_perbaikan" id="keterangan_perbaikan"></textarea>
	</div>


	<button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
       $(function(){
      // loadListUsulLayanan()
        $('.select2').select2()
        $('#datatable').dataTable()
        
    })

    
      $('#form_perbaikan_data').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_perbaikan_data');
        var form_data = new FormData(formvalue[0]);
        // var ins = document.getElementById('file_pengantar').files.length;
        
        // if(ins == 0){
        // errortoast("Silahkan upload file terlebih dahulu");
        // return false;
        // }       
      
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/insertUsulLayanan")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        // dataType: "json",
        success:function(res){ 
            console.log(res)
            var result = JSON.parse(res); 
            console.log(result)
            if(result.success == true){
                successtoast(result.msg)
                document.getElementById("form_perbaikan_data").reset();
                loadListUsulLayanan(12)
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });

      $("#file_pengantar").change(function (e) {

      var extension = file_pengantar.value.split('.')[1];

      if (extension != "pdf"){
        errortoast("Harus File PDF")
        $(this).val('');
      }


      });

      function hitungTotalHari(){
      var total_hari = $('#lama_cuti').val()
      var radioValue = $("input[name='jenis_lama_cuti']:checked").val();

      var tahun1 = $('#tahun1').val()
      var tahun2 = $('#tahun2').val()
      var tahun3 = $('#tahun3').val()

      if(tahun1 == ""){
        tahun1 = 0;
      }

      if(tahun2 == ""){
        tahun2 = 0;
      }
      if(tahun3 == ""){
        tahun3 = 0;
      }
  
 
  if(radioValue == 1){
   var total_semua_tahun = parseInt(tahun1)+parseInt(tahun2)+parseInt(tahun3);

   if(parseInt(total_semua_tahun) > parseInt(total_hari)){
    errortoast('Totah hari sudah melebihi jumlah hari cuti')
    $('#tahun1').val('')
    $('#tahun2').val('')
    $('#tahun3').val('')
   }
    

  }  
 }

 function offdisabled(){
  var total_hari = $('#lama_cuti').val()
  
  if(total_hari != "" && $("input[name='jenis_lama_cuti']").prop('checked') == true){
    document.getElementById("tahun1").disabled = false;
    document.getElementById("tahun2").disabled = false;
    document.getElementById("tahun3").disabled = false;
  } else {
    document.getElementById("tahun1").disabled = true;
    document.getElementById("tahun2").disabled = true;
    document.getElementById("tahun3").disabled = true;

  }
}


function openform(){
  var jenis_cuti = $('#jenis_cuti').val()
  if(jenis_cuti == 0){
   $('#haripertahun').show('fast')
  } else {
    $('#haripertahun').hide('fast')
  }
 
}



$('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    }); 


</script>
