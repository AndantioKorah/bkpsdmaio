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
  --star-clr-inactive: rgba(128, 128, 128, 0.7);
  --star-clr-active: rgb(245, 158, 11);
  --star-clr-hover: rgba(236, 201, 136, 0.2);
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
  color: #fff;
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
                <th class="text-left">Jabatan</th>
                <th class="text-center"></th>
                <!-- <th class="text-center">Rotasi Jabatan</th> -->
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
                    <td class="text-left"><?=$p['nama_jabatan']?></td>
                    <td class="text-left">
                    <button 
                    data-id="<?=$p['id_peg']?>"
                    data-berorientasi_pelayanan="<?=$p['berorientasi_pelayanan']?>"
                      data-akuntabel="<?=$p['akuntabel']?>"
                        data-kompeten="<?=$p['kompeten']?>"
                          data-harmonis="<?=$p['harmonis']?>"
                            data-loyal="<?=$p['loyal']?>"
                              data-adaptif="<?=$p['adaptif']?>"
                                data-kolaboratif="<?=$p['kolaboratif']?>"
                    type="button" class="btn btn-primary btn-sm open-DetailPT" data-toggle="modal" data-target="#exampleModal">
                        Beri Nilai
                        </button>
                    </td>
                  
                </tr>
            <?php } ?>
            </tbody>
          
        </table>
    </div>
    <div class="modal fade" id="modal_edit_data_nilai" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div id="modal-dialog" class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Sasaran Kerja Bulanan Pegawai</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_edit_data_nilai_content">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div   class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" >
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color: #022C22;">

       <form id="form_penilaian_sejawat" method="post" enctype="multipart/form-data" >
       <input type="hidden" name="id_pegawai" id="id_pegawai">         
       <h3 >Berorientasi Pelayanan</h3>
       <div class="rating">
        <label for="radio-1" aria-label="Rating 1"><input type="radio" name="berorientasi_pelayanan" id="radio-1" class="sr-only" value="20"></label>
        <label for="radio-2" aria-label="Rating 2"><input type="radio" name="berorientasi_pelayanan" id="radio-2" class="sr-only" value="40"></label>
        <label for="radio-3" aria-label="Rating 3"><input type="radio" name="berorientasi_pelayanan" id="radio-3" class="sr-only" value="60"></label>
        <label for="radio-4" aria-label="Rating 4"><input type="radio" name="berorientasi_pelayanan" id="radio-4" class="sr-only" value="80"></label>
        <label for="radio-5" aria-label="Rating 5"><input type="radio" name="berorientasi_pelayanan" id="radio-5" class="sr-only" value="100"></label>
      </div>
      <hr class="new5">
     
      <h3>Akuntabel</h3>
       <div class="rating">
        <label for="radio-12" aria-label="Rating2 1"><input type="radio" name="akuntabel" id="radio-12" class="sr-only" value="20"></label>
        <label for="radio-22" aria-label="Rating2 2"><input type="radio" name="akuntabel" id="radio-22" class="sr-only" value="40"></label>
        <label for="radio-32" aria-label="Rating2 3"><input type="radio" name="akuntabel" id="radio-32" class="sr-only" value="60"></label>
        <label for="radio-42" aria-label="Rating2 4"><input type="radio" name="akuntabel" id="radio-42" class="sr-only" value="80"></label>
        <label for="radio-52" aria-label="Rating2 5"><input type="radio" name="akuntabel" id="radio-52" class="sr-only" value="100"></label>
      </div>
      <hr class="new5">
      <h3>Kompeten</h3>
       <div class="rating">
        <label for="radio-13" aria-label="Rating3 1"><input type="radio" name="kompeten" id="radio-13" class="sr-only" value="20"></label>
        <label for="radio-23" aria-label="Rating3 2"><input type="radio" name="kompeten" id="radio-23" class="sr-only" value="40"></label>
        <label for="radio-33" aria-label="Rating3 3"><input type="radio" name="kompeten" id="radio-33" class="sr-only" value="60"></label>
        <label for="radio-43" aria-label="Rating3 4"><input type="radio" name="kompeten" id="radio-43" class="sr-only" value="80"></label>
        <label for="radio-53" aria-label="Rating3 5"><input type="radio" name="kompeten" id="radio-53" class="sr-only" value="100"></label>
      </div>
      <hr class="new5">
      <h3>Harmonis</h3>
       <div class="rating">
        <label for="radio-14" aria-label="Rating4 1"><input type="radio" name="harmonis" id="radio-14" class="sr-only" value="20"></label>
        <label for="radio-24" aria-label="Rating4 2"><input type="radio" name="harmonis" id="radio-24" class="sr-only" value="40"></label>
        <label for="radio-34" aria-label="Rating4 3"><input type="radio" name="harmonis" id="radio-34" class="sr-only" value="60"></label>
        <label for="radio-44" aria-label="Rating4 4"><input type="radio" name="harmonis" id="radio-44" class="sr-only" value="80"></label>
        <label for="radio-54" aria-label="Rating4 5"><input type="radio" name="harmonis" id="radio-54" class="sr-only" value="100"></label>
      </div>
      <hr class="new5">
      <h3>Loyal</h3>
       <div class="rating">
        <label for="radio-15" aria-label="Rating5 1"><input type="radio" name="loyal" id="radio-15" class="sr-only" value="20"></label>
        <label for="radio-25" aria-label="Rating5 2"><input type="radio" name="loyal" id="radio-25" class="sr-only" value="40"></label>
        <label for="radio-35" aria-label="Rating5 3"><input type="radio" name="loyal" id="radio-35" class="sr-only" value="60"></label>
        <label for="radio-45" aria-label="Rating5 4"><input type="radio" name="loyal" id="radio-45" class="sr-only" value="80"></label>
        <label for="radio-55" aria-label="Rating5 5"><input type="radio" name="loyal" id="radio-55" class="sr-only" value="100"></label>
      </div>
      <hr class="new5">
      <h3>Adaptif</h3>
       <div class="rating">
        <label for="radio-16" aria-label="Rating6 1"><input type="radio" name="adaptif" id="radio-16" class="sr-only" value="20"></label>
        <label for="radio-26" aria-label="Rating6 2"><input type="radio" name="adaptif" id="radio-26" class="sr-only" value="40"></label>
        <label for="radio-36" aria-label="Rating6 3"><input type="radio" name="adaptif" id="radio-36" class="sr-only" value="60"></label>
        <label for="radio-46" aria-label="Rating6 4"><input type="radio" name="adaptif" id="radio-46" class="sr-only" value="80"></label>
        <label for="radio-56" aria-label="Rating6 5"><input type="radio" name="adaptif" id="radio-56" class="sr-only" value="100"></label>
      </div>
      <hr class="new5">
      <h3>Kolaboratif</h3>
       <div class="rating">
        <label for="radio-17" aria-label="Rating7 1"><input type="radio" name="kolaboratif" id="radio-17" class="sr-only" value="20"></label>
        <label for="radio-27" aria-label="Rating7 2"><input type="radio" name="kolaboratif" id="radio-27" class="sr-only" value="40"></label>
        <label for="radio-37" aria-label="Rating7 3"><input type="radio" name="kolaboratif" id="radio-37" class="sr-only" value="60"></label>
        <label for="radio-47" aria-label="Rating7 4"><input type="radio" name="kolaboratif" id="radio-47" class="sr-only" value="80"></label>
        <label for="radio-57" aria-label="Rating7 5"><input type="radio" name="kolaboratif" id="radio-57" class="sr-only" value="100"></label>
      </div>
      <hr class="new5">
     
        <button class="btn btn-primary" style="width:100%;border-color:#fff">Simpan</button>
        </form>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
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
var berorientasi_pelayanan = $(this).data('berorientasi_pelayanan');
var akuntabel = $(this).data('akuntabel');
var kompeten = $(this).data('kompeten');
var harmonis = $(this).data('harmonis');
var loyal = $(this).data('loyal');
var adaptif = $(this).data('adaptif');
var kolaboratif = $(this).data('kolaboratif');

$( "#radio-5" ).prop( "checked", false );

$('#id_pegawai').val(id)
if(berorientasi_pelayanan == 20){
  $("#radio-1").attr('checked', 'checked');
} else if(berorientasi_pelayanan == 40) {
  $("#radio-2").attr('checked', 'checked');
} else if(berorientasi_pelayanan == 60) {
  $("#radio-3").attr('checked', 'checked');
} else if(berorientasi_pelayanan == 80) {
  $("#radio-4").attr('checked', 'checked');
} else if(berorientasi_pelayanan == 100) {
  $("#radio-5").attr('checked', 'checked');
} else {
  $('input[name=berorientasi_pelayanan]').attr('checked',false);
}

if(akuntabel == 20){
  $("#radio-12").attr('checked', 'checked');
} else if(akuntabel == 40) {
  $("#radio-22").attr('checked', 'checked');
} else if(akuntabel == 60) {
  $("#radio-32").attr('checked', 'checked');
} else if(akuntabel == 80) {
  $("#radio-42").attr('checked', 'checked');
} else if(akuntabel == 100) {
  $("#radio-52").attr('checked', 'checked');
} else {
  $('input[name=akuntabel]').attr('checked',false);
}

if(kompeten == 20){
  $("#radio-13").attr('checked', 'checked');
} else if(kompeten == 40) {
  $("#radio-23").attr('checked', 'checked');
} else if(kompeten == 60) {
  $("#radio-33").attr('checked', 'checked');
} else if(kompeten == 80) {
  $("#radio-43").attr('checked', 'checked');
} else if(kompeten == 100) {
  $("#radio-53").attr('checked', 'checked');
} else {
  $('input[name=kompeten]').attr('checked',false);
}

if(harmonis == 20){
  $("#radio-14").attr('checked', 'checked');
} else if(harmonis == 40) {
  $("#radio-24").attr('checked', 'checked');
} else if(harmonis == 60) {
  $("#radio-34").attr('checked', 'checked');
} else if(harmonis == 80) {
  $("#radio-44").attr('checked', 'checked');
} else if(harmonis == 100) {
  $("#radio-54").attr('checked', 'checked');
} else {
  $('input[name=harmonis]').attr('checked',false);
}

if(loyal == 20){
  $("#radio-15").attr('checked', 'checked');
} else if(loyal == 40) {
  $("#radio-25").attr('checked', 'checked');
} else if(loyal == 60) {
  $("#radio-35").attr('checked', 'checked');
} else if(loyal == 80) {
  $("#radio-45").attr('checked', 'checked');
} else if(loyal == 100) {
  $("#radio-55").attr('checked', 'checked');
} else {
  $('input[name=loyal]').attr('checked',false);
}

if(adaptif == 20){
  $("#radio-16").attr('checked', 'checked');
} else if(adaptif == 40) {
  $("#radio-26").attr('checked', 'checked');
} else if(adaptif == 60) {
  $("#radio-36").attr('checked', 'checked');
} else if(adaptif == 80) {
  $("#radio-46").attr('checked', 'checked');
} else if(adaptif == 100) {
  $("#radio-56").attr('checked', 'checked');
} else {
  $('input[name=adaptif]').attr('checked',false);
}


if(kolaboratif == 20){
  $("#radio-17").attr('checked', 'checked');
} else if(kolaboratif == 40) {
  $("#radio-27").attr('checked', 'checked');
} else if(kolaboratif == 60) {
  $("#radio-37").attr('checked', 'checked');
} else if(kolaboratif == 80) {
  $("#radio-47").attr('checked', 'checked');
} else if(kolaboratif == 100) {
  $("#radio-57").attr('checked', 'checked');
} else {
  $('input[name=kolaboratif]').attr('checked',false);
}



});

$('#table_list_pegawai').DataTable({
    "ordering": false,
    "aLengthMenu": [[20, 50, 75, -1], [20, 50, 75, "All"]],
     });
    
        
     $('#form_penilaian_sejawat').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_penilaian_sejawat');
        var form_data = new FormData(formvalue[0]);

       
      

        $.ajax({  
        url:"<?=base_url("simata/C_simata/submitPenilaianSejawat")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        success:function(res){ 
           location.reload()
                
        }  
        });  
          
        });


        function verifDokumen(val,id){
            alert(val) 
          }

    function handleChange(src,id) {
   
      $.ajax({
            url: '<?=base_url("simata/C_Simata/submitPenilaianPimpinan/")?>',
            method: 'post',
            data: {
                nilai : src.value,
                id_peg: id
            },
            success: function(data){
                
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }
    </script>
<?php } else { ?>
<?php } ?>