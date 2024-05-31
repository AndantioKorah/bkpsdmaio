<style type="text/css">
.thumb{
  margin: 24px 5px 20px 0;
  width: 150px;
  float: left;
}
#blah {
  border: 2px solid;
  display: block;
  background-color: white;
  border-radius: 5px;
}
</style>


<h1 class="h3 mb-3">Form Peninjauan Absensi</h1>
<div class="card card-default">
    <!-- <div class="card-header"  style="display: block;">
        <h3 class="card-title">Realisasi Kerja</h3>
    </div> -->
    
    <div class="card-body" style="display: block;">

  <div class="card" id="bar-progress-realisaasi" style="display: none;"> 
  <div class="card-body">
    <?php $progress = 60;?>
                      <center>
                      <small style="font-size: 90% !important; font-weight: bold !important;" id="ket_tugas_jabatan">
                        </small>
                  
                        </center>
    <div class="progress progress-sm" style="height:30px;">
            <div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="" aria-valuemax="100"  style="height:30px; width: 0%; background-color: #000;">
                            </div>
                        </div>
                        <center>
                        <small style="font-size: 90% !important; font-weight: bold !important;" id="ket_proogress">
                        </small>
                        <!-- <br>
                        <small style="font-size: 90% !important; font-weight: bold !important;" id="ket_target">
                        </small>
                        <br>
                        <small style="font-size: 90% !important; font-weight: bold !important;" id="ket_sudah_verif">
                        </small>
                        <br>
                        <small style="font-size: 90% !important; font-weight: bold !important;" id="ket_belum_verif">
                        </small> -->
                        </center>
  </div>
  </div>
  <style>

  </style>
    <form method="post" id="form_tinjau_absen" enctype="multipart/form-data" >
    <div class="form-group" >
    <label for="exampleFormControlInput1">Tanggal Absensi</label>
    <input  class="form-control customInput datepicker2" id="tanggal_absensi" name="tanggal_absensi" readonly value="<?= date('Y-m-d') ;?>">
    </div>

    <div class="form-group mt-2">
         <label class="bmd-label-floating">Jenis Absensi </label>
         <select class="form-control select2-navy select2" name="jenis_absensi" id="jenis_absensi"  required>
         <option value="" selected disabled>- Pilih Jenis Absen -</option>
         <option value="1" >Absen Pagi </option>
         <option value="2" >Absen Sore </option>
         </select>
    </div>

    <div class="form-group mt-2">
         <label class="bmd-label-floating">Jenis Bukti Absensi </label>
         <select class="form-control select2-navy select2" name="jenis_bukti" id="jenis_bukti"  required>
         <option value="" selected disabled>- Pilih Jenis Bukti Absen -</option>
         <option value="1" >Foto Bersama Teman </option>
         <option value="2" >Screenshot Whatsapp </option>
         </select>
    </div>

    <div class="form-group mt-2" style="display:none;" id="teman_pegawai">
         <label class="bmd-label-floating">Nama Teman Pegawai </label>
         <select class="form-control select2-navy select2" name="teman_absensi" id="teman_absensi" >
         <option value="" selected>- Pilih Pegawai -</option>
         <?php if($pegawai){ foreach($pegawai as $r){ ?>
                        <option value="<?=$r['id']?>"><?=$r['gelar1']?><?=$r['nama']?><?=$r['gelar2']?></option>
                    <?php } } ?>
         </select>
    </div>


  <!-- <div class="form-group mt-2">
    <label for="exampleFormControlTextarea1">Keterangan</label>
    <textarea class="form-control" style="margin-bottom:10px;" id="keterangan" name="keterangan" rows="3" required></textarea>
  </div> -->

   

  <div class="form-group mt-2">
    <label>Dokumen Bukti  (Format PNG/JPG)</label>
    <!-- <input onclick="getDok()" class="form-control" type="file" id="image_file" name="files[]" multiple="multiple" /> -->
    <!-- <input  class="form-control" type="file" id="image_file" name="files[]" multiple="multiple" /> -->
    <input class="form-control my-image-field" type="file" id="image_file" name="files[]"  multiple="multiple" />


  </div>
  <div class="form-group col-lg-12 mt-2">
     <button class="btn btn-block btn-primary customButton" style="width:100%;" id="btn_upload"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 

<span>
    <br>
    Keterangan : <br> 
    <!-- - Pada bagian keterangan jika bukti foto berupa foto bersama teman, tuliskan nama pegawai yang tersebut jika bukan cukup ketik - saja.<br> -->
    - Jika menggunakan foto bersama stiker, upload foto tersebut ke grup kepegawaian setelah itu discreenshot dan di upload sebagai bukti.<br>
    - Maksimal Peninjauan Absensi hanya 2 kali dalam sebulan.
</span>

    </div>
</div>

<h1 class="h3 mb-3">List Peninjauan Absensi</h1>
<div class="card card-default" id="list_kegiatan">
   
</div>


<script>



$(function(){

  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});

        loadListPeninjauan()
    })

    $('.datepicker2').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-0d',
    // todayBtn: true,
    todayHighlight: true,
    autoclose: true,
});

function loadListPeninjauan(){
       
 
       $('#list_kegiatan').html('')
       $('#list_kegiatan').append(divLoaderNavy)
       $('#list_kegiatan').load('<?=base_url("kinerja/C_Kinerja/loadPeninjauanAbsensi/")?>', function(){
           $('#loader').hide()
       })
   }

$('#form_tinjau_absen').on('submit', function(e){  
       
        e.preventDefault();
        var tanggal = $('#tanggal_kegiatan').val()
       

        var formvalue = $('#form_tinjau_absen');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('image_file').files.length;
        var jenis_bukti = $('#jenis_bukti').val()
        var teman_absensi = $('#teman_absensi').val()

        if(jenis_bukti == 1) {
          if(teman_absensi == ""){
            errortoast('Pegawai belum diisi')
            return false;
          }
        }

        if(ins == 0){
        errortoast("Silahkan upload bukti kegiatan terlebih dahulu");
        document.getElementById('btn_upload').disabled = false;
        $('#btn_upload').html('<i class="fa fa-save"></i>  SIMPAN')
        return false;
        }
       
        document.getElementById('btn_upload').disabled = true;
        $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        $.ajax({  
        url:"<?=base_url("kinerja/C_Kinerja/insertPeninjauanAbsensi")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        // dataType: "json",
        success:function(res){ 
            var result = JSON.parse(res); 
            console.log(result);
            // console.log(result.msg);
            // return false;
            
              if(result.success == true){
                document.getElementById('btn_upload').disabled = true;
                successtoast(result.msg)
                loadListPeninjauan()
              } else {
                errortoast(result.msg)
                document.getElementById('btn_upload').disabled = false;
                $('#btn_upload').html('<i class="fa fa-save"></i>  SIMPAN')
                return false;
              }
                
                document.getElementById("form_tinjau_absen").reset();
                $('#uploadPreview').html('');
                $('#btn_upload').html('<i class="fa fa-save"></i>  SIMPAN')
                document.getElementById('btn_upload').disabled = false;
        }  
        });  
          
        });


$("#image_file").change(function (e) {
    
var fileSize = this.files[0].size/1024;

var doc = image_file.value.split('.')
var extension = doc[doc.length - 1]
const  fileType = this.files[0].type;

const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];

if (!validImageTypes.includes(fileType)) {
    errortoast("Harus File Gambar")
    $(this).val('');
}

// if (extension != "png" || extension != "jpg" || extension != "jpeg"){
//   errortoast("Harus File Gambar")
//   $(this).val('');
// }

});



const compressImage = async (file, { quality = 1, type = file.type }) => {
      
      // Get as image data
      const imageBitmap = await createImageBitmap(file);

      // Draw to canvas
      const canvas = document.createElement('canvas');
      canvas.width = imageBitmap.width;
      canvas.height = imageBitmap.height;
      const ctx = canvas.getContext('2d');
      ctx.drawImage(imageBitmap, 0, 0);

      // Turn into Blob
      const blob = await new Promise((resolve) =>
          canvas.toBlob(resolve, type, quality)
      );

      // Turn Blob into File
      return new File([blob], file.name, {
          type: blob.type,
      });
  };

  // Get the selected file from the file input
  const input = document.querySelector('.my-image-field');
  input.addEventListener('change', async (e) => {
      // Get the files
      // console.log(e.target)
      const { files } = e.target;

      // No files selected
      if (!files.length) return;

      // We'll store the files in this data transfer object
      const dataTransfer = new DataTransfer();


      // For every file in the files list
      for (const file of files) {
        // alert()
          // We don't have to compress files that aren't images
          if (!file.type.startsWith('image')) {
              // Ignore this file, but do add it to our result
              dataTransfer.items.add(file);
              continue;
          }

          // We compress the file by 50%
          console.log(file)
          const compressedFile = await compressImage(file, {
              quality: 0.5,
              type: 'image/jpeg',
          });
          console.log(compressedFile)
          // Save back the compressed file instead of the original file
          dataTransfer.items.add(compressedFile);
          // alert()
      }

      var F = files;
      if (F && F[0]) {
      for (var i = 0; i < F.length; i++) {
        
      readImage(F[i]);
      }
      }

      // Set value of the file input to our new files list
      e.target.files = dataTransfer.files;
  });

  $('#jenis_bukti').on('change', function() {
        if(this.value == 1){
        $('#teman_pegawai').show('fast')
        } else {
          $('#teman_pegawai').hide('fast')
        }
              
          });
</script>