<style>
  :root {
	--page-height: 100vh;
	--page-width: 100vw;
	--page-margin: 0;
	--page-padding: 0;
	--page-font-family: Calibri, "Gill Sans", "Gill Sans MT", "Trebuchet MS", sans-serif;
	--page-text-color: #000;
	--page-text-color-hover: rgba(255,255,255,1.0);
	--page-background-color: #1a1e23;
	--tab-display: grid;
	--tab-background-color: #a8c4e8;
	--display-none: none;
	--box-sizing: border-box;
}

tab-container {
	display: var(--tab-display);
	/* margin-top: 50px; */
	grid-template-columns: 1fr 1fr 1fr 1fr;
	grid-template-rows: auto 1fr;
	border: solid rgba(255,255,255,0.03);
	border-radius: .5em;
}
/*
TAB CONTROLS
Hide radios */
input {display: none;}
input:checked + label {
	color: var(--page-text-color-hover);
	background-color: #222e3c;
	transition: all 250ms;
}
.tab-label {
	cursor: pointer;
	transition: color 250ms;
	padding: 1em;
	border-right: solid 2px var(--page-background-color);
	background-color: var(--tab-background-color);
	text-align: center;
	transition: all 250ms;
}
label:last-of-type {border: none; }
label:hover {
	color: var(--page-text-color-hover);
	background-color: rgba(255,255,255,0.05);
}

tab-content {
	display: var(--tab-display);
	grid-column: 1 / -1;
}
/*
Why doesn't this work!? 
input ~ tab-content {display: none;}
input:checked ~ tab-content {display: var(--tab-display);}*/

/* input#tabToggle01:checked ~ tab-content:not(:nth-of-type(1)),
input#tabToggle02:checked ~ tab-content:not(:nth-of-type(2)),
input#tabToggle03:checked ~ tab-content:not(:nth-of-type(3)),
input#tabToggle04:checked ~ tab-content:not(:nth-of-type(4)) {display: none;} */

</style>
<tab-container>
	<!-- TAB CONTROLS -->
	<input type="radio" id="tabToggle01" name="tabs" value="1" checked />
	<label class="tab-label" id="tab-rotasi"  onclick="LoadNilaiTalenta(2)" for="tabToggle01" checked="checked">Rotasi</label>
	<input type="radio" id="tabToggle02" name="tabs" value="2" />
	<label class="tab-label" onclick="LoadNilaiTalenta(3)" for="tabToggle02">Promosi</label>

	<tab-content>
		<!-- <p>TAB [ <tab-number>01</tab-number> ] content</p>
		<p>CSS...</p>
	</tab-content>
	<tab-content>
		<p>TAB [ <tab-number>02</tab-number> ] content</p>
		<p>CSS Grid...</p>
	</tab-content>
   -->
</tab-container>
<div id="div_detail_profil_talenta" ></div>

<!-- 
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-items" role="presentation">
    <button onclick="LoadNilaiTalenta(2)" class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Rotasi</button>
  </li>
  <li class="nav-items" role="presentation">
    <button onclick="LoadNilaiTalenta(3)" class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Promosi</button>
  </li>

</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" ></div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"></div>
  <div id="div_detail_profil_talenta"></div>
</div> -->



 
<!-- modal detail indikator -->
<div class="modal fade" id="modal_detail_profil_talenta" tabindex="-1" role="dialog" aria-labelledby="table-admModalLabelIndikator" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="table-admModalLabelIndikator"><span id="nm_indikator"></span></h3>
        <!-- <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
      <div id="div_modal_detail_profil_talenta">
      
        </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
<!-- tutup modal detail indikator -->

<script>
  var nip = "<?= $nip;?>";
  $(function(){
    $('#tab-rotasi').click()
    })

 function LoadNilaiTalenta($jenis_pengisian){
  $('#div_detail_profil_talenta').html(' ')
    $('#div_detail_profil_talenta').append(divLoaderNavy)
    $('#div_detail_profil_talenta').load('<?=base_url('kepegawaian/C_Kepegawaian/loadListProfilTalenta/')?>'+nip+'/'+$jenis_pengisian, function(){
    $('#loader').hide()    
    })
 }

 $(document).on("click", ".open-DetailPT", function () {

var id = $(this).data('id');
var nip = $(this).data('nip');
var kode = $(this).data('kode');
var jt = $(this).data('jt')

if(id == ""){
  id = 0;
}


$('#div_modal_detail_profil_talenta').html('')
$('#div_modal_detail_profil_talenta').append(divLoaderNavy)
$('#div_modal_detail_profil_talenta').load('<?=base_url("simata/C_Simata/loadModalDetailProfilTalenta/")?>'+id+'/'+nip+'/'+kode+'/'+jt, function(){
$('#loader').hide()
})

});
</script>