<?php if($rating_pegawai){ ?>
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
   <center>
       <form id="form_penilaian_sejawat" method="post" enctype="multipart/form-data" style="align-items: center;">
       <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?=$rating_pegawai[0]['id_peg'];?>">   
       <div class="list-group">
       <?php $bobot = null; $no = 1; foreach($berakhlak as $b){ ?>
        <a class="list-group-item list-group-item-action" style="background-color:#d5dce4;">
           <h3> <b><?=$b['nama'];?></h3>
        </a>
        <a class="list-group-item list-group-item-action">
            
         <?php $nmr = 1; $nomor = 1;  foreach($result as $rs){ ?>
         <?php if($b['id_m_berakhlak'] == $rs['id_m_berakhlak']) { ?>
                     <?=$nomor++.". ";?>  <?=$rs['sub_berakhlak'];?> <br> 
                    <div class="rating">
                    <label for="radio-<?=$rs['id'];?>1" aria-label="Rating<?=$rs['id'];?> 1"><input type="radio" name="<?=$rs['id'];?>" id="radio-<?=$rs['id'];?>1" class="sr-only" value="20"></label>
                    <label for="radio-<?=$rs['id'];?>2" aria-label="Rating<?=$rs['id'];?> 2"><input type="radio" name="<?=$rs['id'];?>" id="radio-<?=$rs['id'];?>2" class="sr-only" value="40"></label>
                    <label for="radio-<?=$rs['id'];?>3" aria-label="Rating<?=$rs['id'];?> 3"><input type="radio" name="<?=$rs['id'];?>" id="radio-<?=$rs['id'];?>3" class="sr-only" value="60"></label>
                    <label for="radio-<?=$rs['id'];?>4" aria-label="Rating<?=$rs['id'];?> 4"><input type="radio" name="<?=$rs['id'];?>" id="radio-<?=$rs['id'];?>4" class="sr-only" value="80"></label>
                    <label for="radio-<?=$rs['id'];?>5" aria-label="Rating<?=$rs['id'];?> 5"><input type="radio" name="<?=$rs['id'];?>" id="radio-<?=$rs['id'];?>5" class="sr-only" value="100"></label>
                    </div>
                    <hr class="new5">
         <?php } ?>
         <?php } ?>

        <?php $no++;?>
        <div class="table-responsive">
        </div>
    </a>
    <?php } ?>
        </div>


      
        <!-- <center>    
       <h3>Berorientasi Pelayanan</h3>
       <div class="rating">
        <label for="radio-11" aria-label="Rating1 1"><input type="radio" name="berorientasi_pelayanan" id="radio-11" class="sr-only" value="20"></label>
        <label for="radio-12" aria-label="Rating1 2"><input type="radio" name="berorientasi_pelayanan" id="radio-12" class="sr-only" value="40"></label>
        <label for="radio-13" aria-label="Rating1 3"><input type="radio" name="berorientasi_pelayanan" id="radio-13" class="sr-only" value="60"></label>
        <label for="radio-14" aria-label="Rating1 4"><input type="radio" name="berorientasi_pelayanan" id="radio-14" class="sr-only" value="80"></label>
        <label for="radio-15" aria-label="Rating1 5"><input type="radio" name="berorientasi_pelayanan" id="radio-15" class="sr-only" value="100"></label>
      </div>
      <hr class="new5">
      <h3>Akuntabel</h3>
       <div class="rating">
        <label for="radio-21" aria-label="Rating2 1"><input type="radio" name="akuntabel" id="radio-21" class="sr-only" value="20"></label>
        <label for="radio-22" aria-label="Rating2 2"><input type="radio" name="akuntabel" id="radio-22" class="sr-only" value="40"></label>
        <label for="radio-23" aria-label="Rating2 3"><input type="radio" name="akuntabel" id="radio-23" class="sr-only" value="60"></label>
        <label for="radio-24" aria-label="Rating2 4"><input type="radio" name="akuntabel" id="radio-24" class="sr-only" value="80"></label>
        <label for="radio-25" aria-label="Rating2 5"><input type="radio" name="akuntabel" id="radio-25" class="sr-only" value="100"></label>
      </div>
      <hr class="new5"> -->

      <!-- <h3>Kompeten</h3>
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
      </center>  -->
        <button class="btn" id="btn_simpan" style="background-color:#222e3c;width:100%;border-color:#222e3c;color:#fff;">Simpan</button>
        </form>
      </center>
    <script>

$(document).ready(function() {

  

$('input[name=1]').attr('checked',false);
$('input[name=akuntabel]').attr('checked',false);
$('input[name=kompeten]').attr('checked',false);
$('input[name=harmonis]').attr('checked',false);
$('input[name=loyal]').attr('checked',false);
$('input[name=adaptif]').attr('checked',false);
$('input[name=kolaboratif]').attr('checked',false);


var berorientasi_pelayanan1 = "<?=$rating_pegawai[0]['berorientasi_pelayanan1'];?>";
var berorientasi_pelayanan2 = "<?=$rating_pegawai[0]['berorientasi_pelayanan2'];?>";
var berorientasi_pelayanan3 = "<?=$rating_pegawai[0]['berorientasi_pelayanan3'];?>";

var akuntabel1 = "<?=$rating_pegawai[0]['akuntabel1'];?>";
var akuntabel2 = "<?=$rating_pegawai[0]['akuntabel2'];?>";
var akuntabel3 = "<?=$rating_pegawai[0]['akuntabel3'];?>";

var kompeten1 = "<?=$rating_pegawai[0]['kompeten1'];?>";
var kompeten2 = "<?=$rating_pegawai[0]['kompeten2'];?>";
var kompeten3 = "<?=$rating_pegawai[0]['kompeten3'];?>";

var harmonis1 = "<?=$rating_pegawai[0]['harmonis1'];?>";
var harmonis2 = "<?=$rating_pegawai[0]['harmonis2'];?>";
var harmonis3 = "<?=$rating_pegawai[0]['harmonis3'];?>";

var loyal1 = "<?=$rating_pegawai[0]['loyal1'];?>";
var loyal2 = "<?=$rating_pegawai[0]['loyal2'];?>";
var loyal3 = "<?=$rating_pegawai[0]['loyal3'];?>";

var adaptif1 = "<?=$rating_pegawai[0]['adaptif1'];?>";
var adaptif2 = "<?=$rating_pegawai[0]['adaptif2'];?>";
var adaptif3 = "<?=$rating_pegawai[0]['adaptif3'];?>";

var kolaboratif1 = "<?=$rating_pegawai[0]['kolaboratif1'];?>";
var kolaboratif2 = "<?=$rating_pegawai[0]['kolaboratif2'];?>";
var kolaboratif3 = "<?=$rating_pegawai[0]['kolaboratif3'];?>";




if(berorientasi_pelayanan1 == 20){
  $("#radio-11").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(berorientasi_pelayanan1 == 40) {
  $("#radio-12").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(berorientasi_pelayanan1 == 60) {
  $("#radio-13").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(berorientasi_pelayanan1 == 80) {
  $("#radio-14").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(berorientasi_pelayanan1 == 100) {
  $("#radio-15").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-11" ).prop( "checked", false );
  $( "#radio-12" ).prop( "checked", false );
  $( "#radio-13" ).prop( "checked", false );
  $( "#radio-14" ).prop( "checked", false );
  $( "#radio-15" ).prop( "checked", false );
}

if(berorientasi_pelayanan2 == 20){
  $("#radio-21").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(berorientasi_pelayanan2 == 40) {
  $("#radio-22").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(berorientasi_pelayanan2 == 60) {
  $("#radio-23").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(berorientasi_pelayanan2 == 80) {
  $("#radio-24").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(berorientasi_pelayanan2 == 100) {
  $("#radio-25").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-21" ).prop( "checked", false );
  $( "#radio-22" ).prop( "checked", false );
  $( "#radio-23" ).prop( "checked", false );
  $( "#radio-24" ).prop( "checked", false );
  $( "#radio-25" ).prop( "checked", false );
}

if(berorientasi_pelayanan3 == 20){
  $("#radio-31").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(berorientasi_pelayanan3 == 40) {
  $("#radio-32").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(berorientasi_pelayanan3 == 60) {
  $("#radio-33").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(berorientasi_pelayanan3 == 80) {
  $("#radio-34").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(berorientasi_pelayanan3 == 100) {
  $("#radio-35").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-31" ).prop( "checked", false );
  $( "#radio-32" ).prop( "checked", false );
  $( "#radio-33" ).prop( "checked", false );
  $( "#radio-34" ).prop( "checked", false );
  $( "#radio-35" ).prop( "checked", false );
}

if(akuntabel1 == 20){
  $("#radio-41").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(akuntabel1 == 40) {
  $("#radio-42").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(akuntabel1 == 60) {
  $("#radio-43").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(akuntabel1 == 80) {
  $("#radio-44").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(akuntabel1 == 100) {
  $("#radio-45").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-41" ).prop( "checked", false );
  $( "#radio-42" ).prop( "checked", false );
  $( "#radio-43" ).prop( "checked", false );
  $( "#radio-44" ).prop( "checked", false );
  $( "#radio-45" ).prop( "checked", false );
}

if(akuntabel2 == 20){
  $("#radio-51").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(akuntabel2 == 40) {
  $("#radio-52").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(akuntabel2 == 60) {
  $("#radio-53").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(akuntabel2 == 80) {
  $("#radio-54").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(akuntabel2 == 100) {
  $("#radio-55").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-51" ).prop( "checked", false );
  $( "#radio-52" ).prop( "checked", false );
  $( "#radio-53" ).prop( "checked", false );
  $( "#radio-54" ).prop( "checked", false );
  $( "#radio-55" ).prop( "checked", false );
}

if(akuntabel3 == 20){
  $("#radio-61").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(akuntabel3 == 40) {
  $("#radio-62").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(akuntabel3 == 60) {
  $("#radio-63").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(akuntabel3 == 80) {
  $("#radio-64").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(akuntabel3 == 100) {
  $("#radio-65").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-61" ).prop( "checked", false );
  $( "#radio-62" ).prop( "checked", false );
  $( "#radio-63" ).prop( "checked", false );
  $( "#radio-64" ).prop( "checked", false );
  $( "#radio-65" ).prop( "checked", false );
}

if(kompeten1 == 20){
  $("#radio-71").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(kompeten1 == 40) {
  $("#radio-72").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(kompeten1 == 60) {
  $("#radio-73").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(kompeten1 == 80) {
  $("#radio-74").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(kompeten1 == 100) {
  $("#radio-75").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-71" ).prop( "checked", false );
  $( "#radio-72" ).prop( "checked", false );
  $( "#radio-73" ).prop( "checked", false );
  $( "#radio-74" ).prop( "checked", false );
  $( "#radio-75" ).prop( "checked", false );
}

if(kompeten2 == 20){
  $("#radio-81").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(kompeten2 == 40) {
  $("#radio-82").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(kompeten2 == 60) {
  $("#radio-83").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(kompeten2 == 80) {
  $("#radio-84").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(kompeten2 == 100) {
  $("#radio-85").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-81" ).prop( "checked", false );
  $( "#radio-82" ).prop( "checked", false );
  $( "#radio-83" ).prop( "checked", false );
  $( "#radio-84" ).prop( "checked", false );
  $( "#radio-85" ).prop( "checked", false );
}

if(kompeten3 == 20){
  $("#radio-91").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(kompeten3 == 40) {
  $("#radio-92").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(kompeten3 == 60) {
  $("#radio-93").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(kompeten3 == 80) {
  $("#radio-94").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(kompeten3 == 100) {
  $("#radio-95").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-91" ).prop( "checked", false );
  $( "#radio-92" ).prop( "checked", false );
  $( "#radio-93" ).prop( "checked", false );
  $( "#radio-94" ).prop( "checked", false );
  $( "#radio-95" ).prop( "checked", false );
}

if(harmonis1 == 20){
  $("#radio-101").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(harmonis1 == 40) {
  $("#radio-102").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(harmonis1 == 60) {
  $("#radio-103").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(harmonis1 == 80) {
  $("#radio-104").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(harmonis1 == 100) {
  $("#radio-105").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-101" ).prop( "checked", false );
  $( "#radio-102" ).prop( "checked", false );
  $( "#radio-103" ).prop( "checked", false );
  $( "#radio-104" ).prop( "checked", false );
  $( "#radio-105" ).prop( "checked", false );
}

if(harmonis2 == 20){
  $("#radio-111").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(harmonis2 == 40) {
  $("#radio-112").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(harmonis2 == 60) {
  $("#radio-113").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(harmonis2 == 80) {
  $("#radio-114").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(harmonis2 == 100) {
  $("#radio-115").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-111" ).prop( "checked", false );
  $( "#radio-112" ).prop( "checked", false );
  $( "#radio-113" ).prop( "checked", false );
  $( "#radio-114" ).prop( "checked", false );
  $( "#radio-115" ).prop( "checked", false );
}

if(harmonis3 == 20){
  $("#radio-121").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(harmonis3 == 40) {
  $("#radio-122").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(harmonis3 == 60) {
  $("#radio-123").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(harmonis3 == 80) {
  $("#radio-124").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(harmonis3 == 100) {
  $("#radio-125").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-121" ).prop( "checked", false );
  $( "#radio-122" ).prop( "checked", false );
  $( "#radio-123" ).prop( "checked", false );
  $( "#radio-124" ).prop( "checked", false );
  $( "#radio-125" ).prop( "checked", false );
}

if(loyal1 == 20){
  $("#radio-131").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(loyal1 == 40) {
  $("#radio-132").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(loyal1 == 60) {
  $("#radio-133").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(loyal1 == 80) {
  $("#radio-134").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(loyal1 == 100) {
  $("#radio-135").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-131" ).prop( "checked", false );
  $( "#radio-132" ).prop( "checked", false );
  $( "#radio-133" ).prop( "checked", false );
  $( "#radio-134" ).prop( "checked", false );
  $( "#radio-135" ).prop( "checked", false );
}

if(loyal2 == 20){
  $("#radio-141").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(loyal2 == 40) {
  $("#radio-142").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(loyal2 == 60) {
  $("#radio-143").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(loyal2 == 80) {
  $("#radio-144").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(loyal2 == 100) {
  $("#radio-145").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-141" ).prop( "checked", false );
  $( "#radio-142" ).prop( "checked", false );
  $( "#radio-143" ).prop( "checked", false );
  $( "#radio-144" ).prop( "checked", false );
  $( "#radio-145" ).prop( "checked", false );
}


if(loyal3 == 20){
  $("#radio-151").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(loyal3 == 40) {
  $("#radio-152").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(loyal3 == 60) {
  $("#radio-153").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(loyal3 == 80) {
  $("#radio-154").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(loyal3 == 100) {
  $("#radio-155").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-151" ).prop( "checked", false );
  $( "#radio-152" ).prop( "checked", false );
  $( "#radio-153" ).prop( "checked", false );
  $( "#radio-154" ).prop( "checked", false );
  $( "#radio-155" ).prop( "checked", false );
}


if(adaptif1 == 20){
  $("#radio-161").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(adaptif1 == 40) {
  $("#radio-162").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(adaptif1 == 60) {
  $("#radio-163").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(adaptif1 == 80) {
  $("#radio-164").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(adaptif1 == 100) {
  $("#radio-165").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-161" ).prop( "checked", false );
  $( "#radio-162" ).prop( "checked", false );
  $( "#radio-163" ).prop( "checked", false );
  $( "#radio-164" ).prop( "checked", false );
  $( "#radio-165" ).prop( "checked", false );
}

if(adaptif2 == 20){
  $("#radio-171").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(adaptif2 == 40) {
  $("#radio-172").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(adaptif2 == 60) {
  $("#radio-173").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(adaptif2 == 80) {
  $("#radio-174").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(adaptif2 == 100) {
  $("#radio-175").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-171" ).prop( "checked", false );
  $( "#radio-172" ).prop( "checked", false );
  $( "#radio-173" ).prop( "checked", false );
  $( "#radio-174" ).prop( "checked", false );
  $( "#radio-175" ).prop( "checked", false );
}

if(adaptif3 == 20){
  $("#radio-181").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(adaptif3 == 40) {
  $("#radio-182").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(adaptif3 == 60) {
  $("#radio-183").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(adaptif3 == 80) {
  $("#radio-184").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(adaptif3 == 100) {
  $("#radio-185").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-181" ).prop( "checked", false );
  $( "#radio-182" ).prop( "checked", false );
  $( "#radio-183" ).prop( "checked", false );
  $( "#radio-184" ).prop( "checked", false );
  $( "#radio-185" ).prop( "checked", false );
}

if(kolaboratif1 == 20){
  $("#radio-191").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(kolaboratif1 == 40) {
  $("#radio-192").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(kolaboratif1 == 60) {
  $("#radio-193").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(kolaboratif1 == 80) {
  $("#radio-194").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(kolaboratif1 == 100) {
  $("#radio-195").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-191" ).prop( "checked", false );
  $( "#radio-192" ).prop( "checked", false );
  $( "#radio-193" ).prop( "checked", false );
  $( "#radio-194" ).prop( "checked", false );
  $( "#radio-195" ).prop( "checked", false );
}

if(kolaboratif2 == 20){
  $("#radio-201").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(kolaboratif2 == 40) {
  $("#radio-202").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(kolaboratif2 == 60) {
  $("#radio-203").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(kolaboratif2 == 80) {
  $("#radio-204").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(kolaboratif2 == 100) {
  $("#radio-205").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-201" ).prop( "checked", false );
  $( "#radio-202" ).prop( "checked", false );
  $( "#radio-203" ).prop( "checked", false );
  $( "#radio-204" ).prop( "checked", false );
  $( "#radio-205" ).prop( "checked", false );
}

if(kolaboratif3 == 20){
  $("#radio-211").prop('checked',true);
  // $("#radio-1").attr('checked', 'checked');
} else if(kolaboratif3 == 40) {
  $("#radio-212").prop('checked',true);
  // $("#radio-2").attr('checked', 'checked');
} else if(kolaboratif3 == 60) {
  $("#radio-213").prop('checked',true);
  // $("#radio-3").attr('checked', 'checked');
} else if(kolaboratif3 == 80) {
  $("#radio-214").prop('checked',true);
  // $("#radio-4").attr('checked', 'checked');
} else if(kolaboratif3 == 100) {
  $("#radio-215").prop('checked',true);
  // $("#radio-5").attr('checked', 'checked');
} else {
  $( "#radio-211" ).prop( "checked", false );
  $( "#radio-212" ).prop( "checked", false );
  $( "#radio-213" ).prop( "checked", false );
  $( "#radio-214" ).prop( "checked", false );
  $( "#radio-215" ).prop( "checked", false );
}


});

 


    
        
     $('#form_penilaian_sejawat').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_penilaian_sejawat');
        var form_data = new FormData(formvalue[0]);

        document.getElementById('btn_simpan').disabled = true;
        $('#btn_simpan').html('Simpan.. <i class="fas fa-spinner fa-spin"></i>')

        $.ajax({  
        url:"<?=base_url("simata/C_Simata/submitPenilaianSejawat")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        success:function(res){ 
        document.getElementById('btn_simpan').disabled = false;
           $('#btn_simpan').html('Simpan')
          // successtoast()
          //  location.reload()
              console.log(res)
            var result = JSON.parse(res); 
            console.log(result)
            if(result.success == true){
            successtoast(result.msg)
              } else {
                errortoast(result.msg)
                return false;
              } 
                setTimeout(function() {$("#exampleModal").trigger( "click" );}, 1000);
                
        }  
        });  
          
        });


    </script>
<?php } else { ?>
<?php } ?>