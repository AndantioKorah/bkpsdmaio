<?php if($list_pegawai){ ?>
  <style>
        *,
::before,
::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
/* body {
  min-height: 100svh;
  background-color: #022C22;
  display: grid;
  place-content: center;
} */
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}
.rating {
  
  --star-size: clamp(2rem, 5vw, 5rem);
  --star-clr-inactive: rgba(196, 194, 194, 0.7);
  /* --star-clr-active: rgb(245, 158, 11); */
  --star-clr-active: #222e3c;
  --star-clr-hover: rgba(97, 1, 15, 0.2);
  --star-clip-path: polygon(
    50% 0%,
    61% 35%,
    98% 35%,
    68% 57%,
    79% 91%,
    50% 70%,
    21% 91%,
    32% 57%,
    2% 35%,
    39% 35%
  );
  /* display: flex; */
  /* align-items: center; */
  gap: 0.5rem;
}

label {
  position: relative;
  cursor: pointer;
  width: var(--star-size);
  height: var(--star-size);
}
label::before {
  content: "";
  position: absolute;
  inset: 50%;
  border-radius: 50%;
  background-color: var(--star-clr-hover);
  transition: rotate 450ms ease-in-out, inset 300ms ease-in-out;
  clip-path: var(--star-clip-path);
}
label:hover::before {
  inset: -1rem;
  rotate: 45deg;
}
label::after {
  content: "";
  position: absolute;
  inset: 0;
  background-color: var(--star-clr-inactive);
  clip-path: var(--star-clip-path);
  transition: 300ms ease-in-out;
  scale: 0.75;
}
label:has(~ label:hover)::after,
label:has(~ label > :checked)::after,
label:has(:checked)::after,
label:hover::after {
  background-color: var(--star-clr-active); 
  scale: 1;
}

label:hover ~ label::after {
  scale: 0.75;
}
label:active::before {
  inset: -2rem;
}

hr.new5 {
  /* border: 3px solid green; */
  border: 1px solid #fff;
  /* color: green; */
  /* border-radius: 2px; */
}

h3 {
  color: #222e3c;
}
      </style>
   
    <div class="col-lg-12 table-responsive">
    <table class="table table-striped" id="table_list_pegawai">
            <thead>
                <th class="text-center">No</th>
                <th class="text-left">Nama Pegawai</th>
                <?php if($this->general_library->isWalikota() || $this->general_library->isSetda()){ ?>
                    <!-- <th class="text-left">Unit Kerja</th> -->
                  
                <?php } ?>
                <th class="text-left">Unit Kerja</th>
                <th class="text-left">Jabatan</th>
                <th class="text-center">Nilai</th>
                <th class="text-center">Kriteria</th>
                <!-- <th class="text-center">Pilihan</th> -->
            </thead>
            <tbody>
            <?php $no=1; foreach($list_pegawai as $p){?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td><?=getNamaPegawaiFull($p)?> </td>
                    <?php if($this->general_library->isWalikota() || $this->general_library->isSetda()){ ?>
                        <!-- <td class="text-left"><?=$p['nm_unitkerja']?></td> -->
                      
                    <?php } ?>
                    <td class="text-left"><?=$p['nm_unitkerja']?></td>
                    <td class="text-left"><?=$p['nama_jabatan']?></td>
                    <td class="text-left"><?=$p['nilai']?></td>
                    <td class="text-left"><?=$p['nm_kriteria']?></td>

                    
                  
                </tr>
            <?php } ?>
            </tbody>
          
        </table>
    </div>
 
    <script>

$(document).on("click", ".open-DetailPT", function () {
  

$('input[name=berorientasi_pelayanan]').attr('checked',false);
$('input[name=akuntabel]').attr('checked',false);
$('input[name=kompeten]').attr('checked',false);
$('input[name=harmonis]').attr('checked',false);
$('input[name=loyal]').attr('checked',false);
$('input[name=adaptif]').attr('checked',false);
$('input[name=kolaboratif]').attr('checked',false);

var id = $(this).data('id');
var foto = $(this).data('foto');
var nama = $(this).data('nama');
var berorientasi_pelayanan = $(this).data('berorientasi_pelayanan');
var akuntabel = $(this).data('akuntabel');
var kompeten = $(this).data('kompeten');
var harmonis = $(this).data('harmonis');
var loyal = $(this).data('loyal');
var adaptif = $(this).data('adaptif');
var kolaboratif = $(this).data('kolaboratif');
$('#foto_mini').attr('src', '<?=base_url('')?>assets/fotopeg/'+foto); 

$('#id_pegawai').val(id)
$('#nama_pegawai').html(nama)

if(berorientasi_pelayanan == 20){
  $("#radio-1").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(berorientasi_pelayanan == 40) {
  $("#radio-2").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(berorientasi_pelayanan == 60) {
  $("#radio-3").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(berorientasi_pelayanan == 80) {
  $("#radio-4").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(berorientasi_pelayanan == 100) {
  $("#radio-5").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-1" ).prop( "checked", false );
  $( "#radio-2" ).prop( "checked", false );
  $( "#radio-3" ).prop( "checked", false );
  $( "#radio-4" ).prop( "checked", false );
  $( "#radio-5" ).prop( "checked", false );
}

if(akuntabel == 20){
  $("#radio-12").prop('checked',true);
} else if(akuntabel == 40) {
  $("#radio-22").prop('checked',true);
} else if(akuntabel == 60) {
  $("#radio-32").prop('checked',true);
} else if(akuntabel == 80) {
  $("#radio-42").prop('checked',true);
} else if(akuntabel == 100) {
  $("#radio-52").prop('checked',true);
} else {
  $( "#radio-12" ).prop( "checked", false );
  $( "#radio-22" ).prop( "checked", false );
  $( "#radio-32" ).prop( "checked", false );
  $( "#radio-42" ).prop( "checked", false );
  $( "#radio-52" ).prop( "checked", false );
}

if(kompeten == 20){
  $("#radio-13").prop('checked',true);
} else if(kompeten == 40) {
  $("#radio-23").prop('checked',true);
} else if(kompeten == 60) {
  $("#radio-33").prop('checked',true);
} else if(kompeten == 80) {
  $("#radio-43").prop('checked',true);
} else if(kompeten == 100) {
  $("#radio-53").prop('checked',true);
} else {
  $( "#radio-13" ).prop( "checked", false );
  $( "#radio-23" ).prop( "checked", false );
  $( "#radio-33" ).prop( "checked", false );
  $( "#radio-43" ).prop( "checked", false );
  $( "#radio-53" ).prop( "checked", false );
}

if(harmonis == 20){
  $("#radio-14").prop('checked',true);
} else if(harmonis == 40) {
  $("#radio-24").prop('checked',true);
} else if(harmonis == 60) {
  $("#radio-34").prop('checked',true);
} else if(harmonis == 80) {
  $("#radio-44").prop('checked',true);
} else if(harmonis == 100) {
  $("#radio-54").prop('checked',true);
} else {
  $( "#radio-14" ).prop( "checked", false );
  $( "#radio-24" ).prop( "checked", false );
  $( "#radio-34" ).prop( "checked", false );
  $( "#radio-44" ).prop( "checked", false );
  $( "#radio-54" ).prop( "checked", false );
}

if(loyal == 20){
  $("#radio-15").prop('checked',true);
} else if(loyal == 40) {
  $("#radio-25").prop('checked',true);
} else if(loyal == 60) {
  $("#radio-35").prop('checked',true);
} else if(loyal == 80) {
  $("#radio-45").prop('checked',true);
} else if(loyal == 100) {
  $("#radio-55").prop('checked',true);
} else {
  $( "#radio-15" ).prop( "checked", false );
  $( "#radio-25" ).prop( "checked", false );
  $( "#radio-35" ).prop( "checked", false );
  $( "#radio-45" ).prop( "checked", false );
  $( "#radio-55" ).prop( "checked", false );
}

if(adaptif == 20){
  $("#radio-16").prop('checked',true);
} else if(adaptif == 40) {
  $("#radio-26").prop('checked',true);
} else if(adaptif == 60) {
  $("#radio-36").prop('checked',true);
} else if(adaptif == 80) {
  $("#radio-46").prop('checked',true);
} else if(adaptif == 100) {
  $("#radio-56").prop('checked',true);
} else {
  $( "#radio-16" ).prop( "checked", false );
  $( "#radio-26" ).prop( "checked", false );
  $( "#radio-36" ).prop( "checked", false );
  $( "#radio-46" ).prop( "checked", false );
  $( "#radio-56" ).prop( "checked", false );
}


if(kolaboratif == 20){
  $("#radio-17").prop('checked',true);
} else if(kolaboratif == 40) {
  $("#radio-27").prop('checked',true);
} else if(kolaboratif == 60) {
  $("#radio-37").prop('checked',true);
} else if(kolaboratif == 80) {
  $("#radio-47").prop('checked',true);
} else if(kolaboratif == 100) {
  $("#radio-57").prop('checked',true);
} else {
  $( "#radio-17" ).prop( "checked", false );
  $( "#radio-27" ).prop( "checked", false );
  $( "#radio-37" ).prop( "checked", false );
  $( "#radio-47" ).prop( "checked", false );
  $( "#radio-57" ).prop( "checked", false );
}



});

$('#table_list_pegawai').DataTable({
    "ordering": false,
    "aLengthMenu": [[50, 75, -1], [50, 75, "All"]],
     });
    
        
     $('#form_penilaian_sejawat').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_penilaian_sejawat');
        var form_data = new FormData(formvalue[0]);

        // document.getElementById('btn_simpan').disabled = true;
        // $('#btn_simpan').html('Simpan.. <i class="fas fa-spinner fa-spin"></i>')

        $.ajax({  
        url:"<?=base_url("simata/C_Simata/submitPenilaianSejawat")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        success:function(res){ 
           $('#btn_simpan').html('Simpan')
          //  location.reload()
                
        }  
        });  
          
        });


    </script>
<?php } else { ?>
<?php } ?>