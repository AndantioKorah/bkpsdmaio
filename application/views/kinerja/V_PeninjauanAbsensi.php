<script src="//cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
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

    
    <div class="card-body" style="display: block;">

    <div class="row col-lg-12">
    <div class="col-lg-6">
    <span>
    <br>
    Keterangan : <br> 
    - Foto bersama teman adalah foto gandeng dengan teman saat melakukan presensi pada aplikasi AARS yang discreenshot lalu diupload sebagai bukti. <b  style="color:red">Jam absensi dari teman pegawai akan dijadikan jam absensi untuk pegawai yang melakukan pengajuan</b><br>
    - Jika menggunakan foto, kirim foto tersebut ke nomor Whatsapp Siladen setelah itu discreenshot dan diupload sebagai bukti.<br>
    - Maksimal Peninjauan Absensi per pegawai hanya 2 kali dalam sebulan.
    </span>
    <div class="row ml-2">
    <div class="col-lg-6">
      <b style="color:red" >contoh Foto Bersama Teman</b><br>
      <img style="height:500px;" src="<?=base_url('assets/peninjauan_absen/contoh/contoh_foto.png');?>" alt="">
    </div>
    <div class="col-lg-6">
    <!-- <b style="color:red">contoh Screenshot Whatsapp Grup</b><br>
    <img style="height:500px;" src="<?=base_url('assets/peninjauan_absen/contoh/contoh_ss.png');?>" alt=""> -->
    </div>
    </div>
    </div>
    <div class="col-lg-6 mt-3">
    <form method="post" id="form_tinjau_absen" enctype="multipart/form-data" >
    <input type="hidden" id="temp">
    <div class="form-group" >
    <label for="exampleFormControlInput1">Tanggal Absensi</label>
    <input  class="form-control customInput datepicker2" id="tanggal_absensi" name="tanggal_absensi" value="<?= date('Y-m-d');?>"  readonly required>
    </div>

    <div class="form-group mt-2">
         <label class="bmd-label-floating">Jenis Absensi </label>
         <select onchange="cekAbsenTeman()" class="form-control select2-navy select2" name="jenis_absensi" id="jenis_absensi"  required>
         <option value="" selected disabled>- Pilih Jenis Absen -</option>
         <option value="1" >Absen Pagi </option>
         <option value="2" >Absen Pulang </option>
         </select>
    </div>

    <div class="form-group mt-2">
         <label class="bmd-label-floating">Jenis Bukti Absensi </label>
         <select class="form-control select2-navy select2" name="jenis_bukti" id="jenis_bukti"  required>
         <option value="" selected disabled>- Pilih Jenis Bukti Absen -</option>
         <option value="1" >Foto Bersama Teman </option>
         <option value="2" >Screenshot Whatsapp Siladen</option>
         </select>
    </div>
    <div class="form-group mt-2" style="display:none;" id="teman_pegawai">
         <label class="bmd-label-floating">Nama Teman Pegawai </label>
         <select onchange="cekAbsenTeman()" class="form-control select2-navy select2" name="teman_absensi" id="teman_absensi" >
         <option value="" selected>- Pilih Pegawai -</option>
         <?php if($pegawai){ foreach($pegawai as $r){ ?>
                        <option value="<?=$r['id']?>"><?=$r['gelar1']?><?=$r['nama']?><?=$r['gelar2']?></option>
                    <?php } } ?>
         </select>
    </div>


    <script>


      // $('#teman_absensi').on('change', function() {
      function cekAbsenTeman() {

      var id_user = null;
       
      var id_user =  $('#teman_absensi').val()
      var tanggal_absensi = $('#tanggal_absensi').val()
      var jenis_absensi = $('#jenis_absensi').val()
      var jenis_bukti = $('#jenis_bukti').val()


      if(jenis_bukti == null || jenis_bukti == 2){
        return false;
      }

      $.ajax({
              url : "<?php echo base_url();?>kinerja/C_Kinerja/getDataPengajuanAbsensiTemanPegawai",
              method : "POST",
              data : {tanggal_absensi: tanggal_absensi,
                id_user : id_user,
                jenis_absensi : jenis_absensi
              },
              async : false,
              dataType : 'json',
              success: function(res){
                console.log(res.success);
              if(res.success == true){
                $('#temp').val(1)
                // $('#teman_absensi').prop('selectedIndex',0);
                // $('#teman_absensi').val("");   
                // $('#teman_absensi option:selected').val()
                // errortoast(res.msg)
                // return false;
              } else {
                $('#temp').val('')
                errortoast(res.msg)
                res = null
              }
              }
              });
              };

    </script>
   

  <div class="form-group mt-2">
    <label>Dokumen Bukti  (Format PNG/JPG)</label>
    <input class="form-control my-image-field" type="file" id="image_file" name="files[]"  />

    <div id="uploadPreview"></div>

  </div>
  <div class="form-group col-lg-12 mt-2">
     <!-- <button class="btn btn-block btn-primary customButton" style="width:100%;" id="btn_upload"><i class="fa fa-save"></i> SIMPAN</button> -->
      <span id="ket" style="display:none;color:red"><b>Sudah ada 2 kali Pengajuan Absensi untuk bulan ini</b></span>
    </div>
</form> 
    </div>
    </div>

    <!-- <form method="post" id="form_tinjau_absen" enctype="multipart/form-data" >
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

   

  <div class="form-group mt-2">
    <label>Dokumen Bukti  (Format PNG/JPG)</label>
    <input class="form-control my-image-field" type="file" id="image_file" name="files[]"  multiple="multiple" />

    <div id="uploadPreview"></div>

  </div>
  <div class="form-group col-lg-12 mt-2">
     <button class="btn btn-block btn-primary customButton" style="width:100%;" id="btn_upload"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 

<span>
    <br>
    Keterangan : <br> 
    - Foto bersama teman adalah foto gandeng dengan teman saat melakukan presensi pada aplikasi AARS yang discreenshot lalu diupload sebagai bukti.<br>
    - Jika menggunakan foto berlatarbelakang stiker, upload foto tersebut ke grup kepegawaian masing - masing setelah itu discreenshot dan diupload sebagai bukti.<br>
    - Upload bukti pada hari yang sama. <br>
    - Maksimal Peninjauan Absensi per pegawai hanya 2 kali dalam sebulan.
</span> -->
    </div>

<div class="row ml-2">
<!-- <div class="col-lg-3">
  contoh Foto Bersama Teman<br>
  <img style="height:500px;" src="<?=base_url('assets/peninjauan_absen/contoh/contoh_foto.png');?>" alt="">
</div>
<div class="col-lg-6">
contoh Screenshot Whatsapp<br>
<img style="height:500px;" src="<?=base_url('assets/peninjauan_absen/contoh/contoh_ss.png');?>" alt="">
</div> -->
</div>
</div>

<h1 class="h3 mb-3">List Peninjauan Absensi</h1>
<div class="card card-default" id="list_kegiatan">
   
</div>
<button style="display:none" id="btnmodal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch static backdrop modal
</button>


<!-- Modal -->
<div class="modal fade" id="exampleModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <span>
        <div class="row">
    <div class="col-lg-6">
      <b style="color:red" >contoh Foto Bersama Teman</b><br>
      <img style="height:300px;" src="<?=base_url('assets/peninjauan_absen/contoh/contoh_foto.png');?>" alt="">
    </div>
    <div class="col-lg-6">
    <b style="color:red">contoh Screenshot Whatsapp Grup</b><br>
    <img style="height:300px;" src="<?=base_url('assets/peninjauan_absen/contoh/contoh_ss.png');?>" alt="">
    </div>
    </div>
   
    <br>
    Keterangan : <br> 
    <b style="font-size:20px;">-</b> Foto bersama teman adalah foto gandeng dengan teman saat melakukan presensi pada aplikasi AARS yang discreenshot lalu diupload sebagai bukti. 
    <b  style="color:red">Jam absensi dari teman pegawai akan dijadikan jam absensi untuk pegawai yang melakukan pengajuan</b><br>
    <b style="font-size:20px;">-</b> Jika menggunakan foto timestamp berlatarbelakang stiker, upload foto tersebut ke grup kepegawaian masing - masing setelah itu discreenshot dan diupload sebagai bukti. 
    <b  style="color:red">Jam pada keterangan timestamp akan menjadi jam absensi bagi pegawai yang melakukan pengajuan</b><br>
    <b style="font-size:20px;">-</b> Upload bukti pada hari yang sama. <br>
    <b style="font-size:20px;">-</b> Maksimal Peninjauan Absensi per pegawai hanya 2 kali dalam sebulan.
    </span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
 
</div>

<script>




$(function(){
  // $('#btnmodal').click()  
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});

        loadListPeninjauan()
        cekPengajuan()
    })

    var maxDate = "<?= $maxDate['max_date'];?>";

    var datearray = ["2025-07-04"];
$('.datepicker2').datepicker({
    format: 'yyyy-mm-dd',       
    datesDisabled: datearray,
    // daysOfWeekDisabled: [0],   //Disable sunday
    autoclose:true,
    // todayHighlight: true,
    startDate : maxDate,
    endDate: '-0d',
});


//     $('.datepicker2').datepicker({
//     format: 'yyyy-mm-dd',
//     // startDate: '-0d',
//     startDate : maxDate,
//     endDate: '-0d',
//     // todayBtn: true,
//     todayHighlight: true,
//     autoclose: true,
// });

function loadListPeninjauan(){
       $('#list_kegiatan').html('')
       $('#list_kegiatan').append(divLoaderNavy)
       $('#list_kegiatan').load('<?=base_url("kinerja/C_Kinerja/loadPeninjauanAbsensi/")?>', function(){
           $('#loader').hide()
       })
   }

   function cekPengajuan(){
    var tanggal = $('#tanggal_absensi').val()
   
    $.ajax({
              url : "<?php echo base_url();?>kinerja/C_Kinerja/getDataPengajuanAbsensiPegawai",
              method : "POST",
              data : {tanggal: tanggal},
              async : false,
              dataType : 'json',
              success: function(res){
                total = res[0].total_pengajuan - res[0].total_tolak
              <?php  if( $this->general_library->getId() != '000'){ ?>

                if(total >= 2) {

                  $('#btn_upload').hide()
                  $('#ket').show()
                } else {
                  $('#btn_upload').show()
                  $('#ket').hide()
                }
                <?php } ?>
               
              }
    });
 
   }

$('#form_tinjau_absen').on('submit', function(e){  
       
        e.preventDefault();
        var tanggal = $('#tanggal_absensi').val()
       if(tanggal == "" || tanggal == null){
        errortoast('Tanggal masih kosong')
       return false;
       }
        var formvalue = $('#form_tinjau_absen');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('image_file').files.length;
        var jenis_bukti = $('#jenis_bukti').val()
        var teman_absensi = $('#temp').val()

        if(jenis_bukti == 1) {
          if(teman_absensi == ""){
            errortoast('Teman Pegawai belum diisi')
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
                cekPengajuan()
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


const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];

if (!validImageTypes.includes(fileType)) {
    errortoast("Harus File Gambar")
    $(this).val('');
}

if (extension == "jfif"){
  errortoast("Harus File Gambar")
  $(this).val('');
}

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

          function readImage(file) {
        document.getElementById('btn_upload').disabled = true;
        $('#btn_upload').html('<i class="fas fa-spinner fa-spin"></i>')
        $('#uploadPreview').html('');
        var reader = new FileReader();
        var image  = new Image();
        reader.readAsDataURL(file);  
        reader.onload = function(_file) {
        image.src = _file.target.result; // url.createObjectURL(file);
        image.onload = function() {
        var w = this.width,
        h = this.height,
        t = file.type, // ext only: // file.type.split('/')[1],
        n = file.name,
        s = ~~(file.size/1024) +'KB';
        $('#uploadPreview').append('<img src="' + this.src + '" class="thumb">');
        document.getElementById('btn_upload').disabled = false;
        $('#btn_upload').html('<i class="fa fa-save"></i>  SIMPAN')
        };
        document.getElementById('btn_upload').disabled = false;
        $('#btn_upload').html('<i class="fa fa-save"></i>  SIMPAN')
        // image.onerror= function() {
        // alert('Invalid file type: '+ file.type);
        // };      
        };
        }
        
        
        $("#image_file").change(function (e) {
        if(this.disabled) {
        return alert('File upload not supported!');
        }
        // var F = this.files;
        // if (F && F[0]) {
        // for (var i = 0; i < F.length; i++) {
          
        // readImage(F[i]);
        // }
        // }
        });

</script>