<form method="post" id="form_cuti" enctype="multipart/form-data">
    <input type="hidden" name="jenis_layanan" id="jenis_layanan" value="3">
	<!-- <div class="mb-3">
		<label for="exampleInputPassword1" class="form-label">Nomor Usul</label>
		<input type="text" class="form-control" id="nomor_usul" name="nomor_usul">
	</div> -->

	<div class="mb-3">
		<!-- <label for="" class="form-label ">Tanggal Usul</label> -->
		<input type="hidden" class="form-control datepicker" id="tanggal_usul" name="tanggal_usul"
			value="<?= date('Y-m-d');?>">
	</div>

<!-- 
	<div class="mb-3">
		<label for="exampleInputEmail1" class="form-label">Jenis Cuti </label>
		<select onchange="openform()" class="form-control select22"
			data-dropdown-css-class="select2-navy" name="jenis_cuti" id="jenis_cuti" required>
			<option value="" disabled selected>Pilih Item</option>
			<?php if($jenis_cuti){ foreach($jenis_cuti as $r){ ?>
                        <option value="<?=$r['id_cuti']?>"><?=$r['nm_cuti']?></option>
                    <?php } } ?>
		</select>
	</div>





	<div class="row align-items-center">
		<label for="inputPassword6" class="col-form-label">Lamanya</label>
		<div class="col-auto">
			<input onkeyup="offdisabled()" type="number" id="lama_cuti" name="lama_cuti" class="form-control"
				aria-describedby="passwordHelpInline">
		</div>
		<div class="col-auto">

			<div class="form-check form-check-inline">
				<input onclick="offdisabled();" class="form-check-input" type="radio" name="jenis_lama_cuti"
					id="inlineRadio1" value="1">
				<label class="form-check-label" for="inlineRadio1">Hari</label>
			</div>
			<div class="form-check form-check-inline">
				<input onclick="offdisabled();" class="form-check-input" type="radio" name="jenis_lama_cuti"
					id="inlineRadio2" value="2">
				<label class="form-check-label" for="inlineRadio2">Bulan</label>
			</div>

		</div>
	</div>

  <div id="haripertahun" style="display:none">
	<div class="row align-items-center">
		<label for="" class="form-label ">Tahun
			<?= date('Y') ;?>
		</label>
		<div class="col-auto">
			<input disabled onkeyup="hitungTotalHari()" type="number" id="tahun1" name="tahun1" class="form-control"
				aria-describedby="passwordHelpInline">
		</div>
		<div class="col-auto">
			<span id="passwordHelpInline" class="">
				Hari
			</span>
		</div>
	</div>


	<div class="row align-items-center">
		<label for="" class="form-label ">Tahun
			<?php
            $date =  date('Y-m-d');
            $dateMinusOneYear = date("Y", strtotime("-1 year", strtotime($date)));
            echo $dateMinusOneYear;
            ?>

		</label>
		<div class="col-auto">
			<input disabled onkeyup="hitungTotalHari()" type="number" id="tahun2" name="tahun2" class="form-control"
				aria-describedby="passwordHelpInline">
		</div>
		<div class="col-auto">
			<span id="passwordHelpInline" class="">
				Hari
			</span>
		</div>
	</div>


	<div class="row align-items-center">
		<label for="" class="form-label ">Tahun
			<?php
            $date =  date('Y-m-d');
            $dateMinusOneYear = date("Y", strtotime("-2 year", strtotime($date)));
            echo $dateMinusOneYear;
            ?>

		</label>
		<div class="col-auto">
			<input disabled onkeyup="hitungTotalHari()" type="number" id="tahun3" name="tahun3" class="form-control"
				aria-describedby="passwordHelpInline">
		</div>
		<div class="col-auto">
			<span id="passwordHelpInline" class="">
				Hari
			</span>
		</div>
	</div>
  </div>

	<div class="mb-3">
		<label for="" class="form-label ">Tanggal Mulai</label>
		<input type="text" class="form-control datepicker" id="tanggal_mulai" name="tanggal_mulai" autocomplete="off">
	</div>


	<div class="mb-3">
		<label for="" class="form-label ">Tanggal Selesai</label>
		<input type="text" class="form-control datepicker" id="tanggal_selesai" name="tanggal_selesai"
			autocomplete="off">
	</div> -->


	<div class="mb-3">
		<label>File Pengantar</label>
		<input class="form-control my-image-field" type="file" id="file_pengantar" name="berkas[]" />
	</div>
<!-- 
  <div class="form-group">
		<label>Surat Keterangan Sakit/Dokter (bagi ASN yang mengajukan cuti sakit) <br>
          Surat Keterangan dari Pihak yang berwenang (bagi ASN yang mengajukan cuti karena alasan penting) <br>
    </label>
		<input class="form-control my-image-field" type="file" id="surat_keterangan" name="berkas[]" />
	</div> -->

<br>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
       $(function(){
      // loadListUsulLayanan()
        
  $(".select22").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
        $('#datatable').dataTable()
        
    })

    
      $('#form_cuti').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_cuti');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('file_pengantar').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }

        // var lama_cuti = $('#lama_cuti').val();
        // var radioValue = $("input[name='jenis_lama_cuti']:checked").val();
        // var jenis_cuti = $('#jenis_cuti').find(":selected").val();
        

        // var tanggal_mulai = $('#tanggal_mulai').val();
        // var tanggal_selesai = $('#tanggal_selesai').val();

        // var tahun1 = $('#tahun1').val()
        // var tahun2 = $('#tahun2').val()
        // var tahun3 = $('#tahun3').val()

        // if(tahun1 == ""){
        // tahun1 = 0;
        // }

        // if(tahun2 == ""){
        //   tahun2 = 0;
        // }
        // if(tahun3 == ""){
        //   tahun3 = 0;
        // }
     
        // var jenis_layanan = $('#jenis_layanan').find(":selected").val();
        // if(jenis_layanan == 3){
        //   if(lama_cuti == ""){
        //     errortoast("Lama hari cuti belum di isi")
        //     return false
        //   }
        //   if(tanggal_mulai == ""){
        //     errortoast("Tanggal mulai belum di isi")
        //     return false
        //   }
        //   if(tanggal_selesai == ""){
        //     errortoast("Tanggal Selesai belum di isi")
        //     return false
        //   }


        //   if( $('input[name="jenis_lama_cuti"]').is(':checked') ){
        //     if(jenis_cuti == 0){
        //       var total_semua_tahun = parseInt(tahun1)+parseInt(tahun2)+parseInt(tahun3);
        //       if(parseInt(total_semua_tahun) < parseInt(lama_cuti)){
        //       errortoast('Totah hari belum sesuai')
        //       }  
        //     }
            
        //    } else{
        //    errortoast("Hari atau Bulan belum di pilih");
        //   }
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
                document.getElementById("form_cuti").reset();
                loadListUsulLayanan(3)
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

      
      $("#surat_keterangan").change(function (e) {

        var extension = surat_keterangan.value.split('.')[1];

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
