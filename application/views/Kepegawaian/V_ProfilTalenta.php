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
<tab-container  id="tabs-mt">
	<!-- TAB CONTROLS -->
	 <?php if($profil_pegawai['eselon'] == "IV A" || $profil_pegawai['eselon'] == "IV B") { ?>
	<!-- <input type="radio" id="tabToggle02" name="tabs" value="1" />
	<label class="tab-label" id="tab-promosi"  onclick="LoadNilaiTalenta(1)" for="tabToggle02">Rotasi</label> -->
	<input type="radio" id="tabToggle022" name="tabs" value="2" />
	<label class="tab-label" id="tab-promosi-iv"  onclick="LoadNilaiTalenta(2)" for="tabToggle02">Promosi</label>
	<?php } else if($profil_pegawai['eselon'] == "III A" || $profil_pegawai['eselon'] == "III B") { ?>
	<!-- <input type="radio" id="tabToggle01" name="tabs" value="1" checked />
	<label class="tab-label" id="tab-rotasi"  onclick="LoadNilaiTalenta(2)" for="tabToggle01" checked="checked">Rotasi</label> -->
	<input type="radio" id="tabToggle02" name="tabs" value="2" />
	<label class="tab-label" id="tab-promosi"  onclick="LoadNilaiTalenta(3)" for="tabToggle02">Promosi</label>
	<?php } else { ?>
	<input type="radio" id="tabToggle02" name="tabs" value="2" />
	<label class="tab-label" id="tab-promosi"  onclick="LoadNilaiTalenta(1)" for="tabToggle02">Promosi</label>
	<?php } ?>
		
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
  var eselon = "<?= $this->general_library->getIdEselon();?>";
  var eselonby_admin = "<?=$profil_pegawai['eselon'];?>"
  $(function(){
    if(eselon == 4 || eselon == 5) {
      $('#tab-promosi').click()
      $("#tabs-mt").hide();
    } else if(eselon == 6 || eselon == 7) {
    //   $('#tab-rotasi').click()
      $('#tab-promosi').click()

    }

	if(eselonby_admin == 'II A' || eselonby_admin == 'II B') {
      $('#tab-promosi').click()
      $("#tabs-mt").hide();
    } else if(eselonby_admin == 'III A' || eselonby_admin == 'III B') {
    //   $('#tab-rotasi').click()
      $('#tab-promosi').click()

    }
   
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