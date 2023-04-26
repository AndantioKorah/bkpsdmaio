<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_penugasan">
  Tambah Data Penugasan
</button>


<div class="modal fade" id="modal_penugasan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Upload Data Penugasan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
      <form method="post" id="upload_form_penugasan" enctype="multipart/form-data" >
        
      <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">

<div class="form-group " style="margin-bottom:10px !important;">
<label for="exampleFormControlInput1">Jenis Penugasan</label>
<select  class="form-control select2 " data-dropdown-css-class="select2-navy" name="jenispenugasan" id="jenispenugasan" required>
                <option value="" disabled selected>Pilih Jenis Penugasan</option>
                <?php if($jenis_penugasan){ foreach($jenis_penugasan as $r){ ?>
                  <option value="<?=$r['id_jenistugas']?>"><?=$r['nm_jenistugas']?></option>
                <?php } } ?>
</select>
</div>

<div class="form-group">
<label>Tempat/Negara Tujuan</label>
<input  class="form-control"   id="tujuan" name="tujuan" required/>
</div>

<div class="form-group">
<label>Pejabat Yang Menetapkan</label>
<input class="form-control" type="text" id="pejabat" name="pejabat"  required/>
</div>

<div class="form-group">
<label>Nomor SK</label>
<input class="form-control" type="text" id="nosk" name="nosk"  required/>
</div>

<div class="form-group">
<label>Tanggal SK</label>
<input  class="form-control datepicker"   id="tglsk" name="tglsk" required/>
</div>

<div class="form-group">
<label>Lamanya</label>
<input class="form-control" type="text" id="lamanya" name="lamanya"  required/>
</div>

<div class="form-group col-lg-12">
<br>
 <button class="btn btn-block btn-primary"  id="btn_upload"><i class="fa fa-save"></i> SIMPAN</button>
</div>
</form> 
      </div>
    </div>
  </div>
</div>                      


<div id="list_penugasan">

</div>



<script type="text/javascript">


$(function(){
        // $('.select2').select2()

   $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
  
        $('#datatable').dataTable()
        loadListPenugasan()
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_penugasan').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_penugasan');
        var form_data = new FormData(formvalue[0]);
        // var ins = document.getElementById('pdf_file').files.length;
        
        // if(ins == 0){
        // errortoast("Silahkan upload file terlebih dahulu");
        // return false;
        // }
       
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/doUpload2")?>",
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
                document.getElementById("upload_form_penugasan").reset();
                loadListPenugasan()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListPenugasan(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_penugasan').html('')
    $('#list_penugasan').append(divLoaderNavy)
    $('#list_penugasan').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadListPenugasan/")?>'+nip, function(){
      $('#loader').hide()
    })
  }

  
</script>