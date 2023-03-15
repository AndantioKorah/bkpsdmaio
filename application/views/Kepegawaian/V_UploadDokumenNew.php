<link rel="stylesheet" href="<?php echo base_url()?>assets/siladen/plugins/dropzone/dropzone.css">
<!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/adminkit/css/modal.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
<!-- <link rel="stylesheet" href="<?=base_url('assets/css/datatable.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/jquery.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/responsive.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/datatable.bootstrap.min.css')?>"> -->
    <style>

h2{
  color:#000;
  text-align:center;
  font-size:2em;
}
.warpper{
  display:flex;
  flex-direction: column;
  align-items: left;
}
.tab{
  cursor: pointer;
  padding:10px 20px;
  margin:0px 2px;
  /* background:#000; */
  background:#222e3c;
  display:inline-block;
  color:#fff;
  border-radius:3px 3px 0px 0px;
  box-shadow: 0 0.5rem 0.8rem #00000080;
  margin-bottom: 10px;
  font-size : 12px;
}
.panels{
  /* background:#000; */
  /* box-shadow: 0 2rem 2rem #00000080; */
  min-height:200px;
  width:100%;
  max-width:500px;
  border-radius:3px;
  overflow:hidden;
  padding:20px;  
}
.panel{
  display:none;
  animation: fadein .8s;
}
@keyframes fadein {
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
}
.panel-title{
  font-size:1.5em;
  /* font-weight:bold */
}
.radio{
  display:none;
}
#pangkat:checked ~ .panels #pangkat-panel,
#gb:checked ~ .panels #gb-panel,
#pendidikan:checked ~ .panels #pendidikan-panel,
#jabatan:checked ~ .panels #jabatan-panel,
#diklat:checked ~ .panels #diklat-panel,
#disiplin:checked ~ .panels #disiplin-panel,
#organisasi:checked ~ .panels #organisasi-panel,
#penghargaan:checked ~ .panels #penghargaan-panel,
#sj:checked ~ .panels #sj-panel,
#keluarga:checked ~ .panels #keluarga-panel,
#penugasan:checked ~ .panels #penugasan-panel,
#cuti:checked ~ .panels #cuti-panel,
#arsip:checked ~ .panels #arsip-panel{
  display:block
}
#pangkat:checked ~ .tabs #pangkat-tab,
#gb:checked ~ .tabs #gb-tab,
#pendidikan:checked ~ .tabs #pendidikan-tab,
#jabatan:checked ~ .tabs #jabatan-tab,
#diklat:checked ~ .tabs #diklat-tab,
#disiplin:checked ~ .tabs #disiplin-tab,
#organisasi:checked ~ .tabs #organisasi-tab,
#penghargaan:checked ~ .tabs #penghargaan-tab,
#sj:checked ~ .tabs #sj-tab,
#keluarga:checked ~ .tabs #keluarga-tab,
#penugasan:checked ~ .tabs #penugasan-tab,
#cuti:checked ~ .tabs #cuti-tab,
#arsip:checked ~ .tabs #arsip-tab{
  background:#fffffff6;
  color:#000;
  border-top: 3px solid #000;
}
     </style>

<!-- upload dokumen  -->
<div class="container-fluid p-0">
<h1 class="h3 mb-3">Upload Dokumen</h1>
<div class="row">
    <div class="col-12">
        
        <div class="card">
       
            <div class="card-body">
                
<div class="warpper">
  <input class="radio" id="pangkat" name="group" type="radio" checked>
  <input class="radio" id="gb" name="group" type="radio">
  <input class="radio" id="pendidikan" name="group" type="radio">
  <input class="radio" id="jabatan" name="group" type="radio">
  <input class="radio" id="diklat" name="group" type="radio">
  <input class="radio" id="disiplin" name="group" type="radio">
  <input class="radio" id="organisasi" name="group" type="radio">
  <input class="radio" id="penghargaan" name="group" type="radio">
  <input class="radio" id="sj" name="group" type="radio">
  <input class="radio" id="keluarga" name="group" type="radio">
  <input class="radio" id="penugasan" name="group" type="radio">
  <input class="radio" id="cuti" name="group" type="radio">
  <input class="radio" id="arsip" name="group" type="radio">
  <div class="tabs">
  <label class="tab" id="pangkat-tab" for="pangkat">Pangkat</label>
  <label class="tab" id="gb-tab" for="gb">Gaji Berkala</label>
  <label class="tab" id="pendidikan-tab" for="pendidikan">Pendidikan</label>
  <label class="tab" id="jabatan-tab" for="jabatan">Jabatan</label>
  <label class="tab" id="diklat-tab" for="diklat">Diklat</label>
  <label class="tab" id="disiplin-tab" for="disiplin">Disiplin</label> 
  <label class="tab" id="organisasi-tab" for="organisasi">Organisasi</label>
  <label class="tab" id="penghargaan-tab" for="penghargaan">Penghargaan</label>
  <label class="tab" id="sj-tab" for="sj">Sumpah/Janji</label>
  <label class="tab" id="keluarga-tab" for="keluarga">Keluarga</label>
  <label class="tab" id="penugasan-tab" for="penugasan">Penugasan</label>
  <label class="tab" id="cuti-tab" for="cuti">Cuti</label>
  <label class="tab" id="arsip-tab" for="arsip">Arsip Lainnya</label>
    </div>
  <div class="panels">

  <div class="panel" id="pangkat-panel">
    <div class="panel-title">Pangkat</div>
    <div id="form_pangkat"></div>
  </div>

  <div class="panel" id="gb-panel">
    <div class="panel-title">Gaji Berkala</div>
  </div>

  <div class="panel" id="pendidikan-panel">
    <div class="panel-title">Pendidikan</div>
  </div>

  <div class="panel" id="jabatan-panel">
    <div class="panel-title">Jabatan</div>
  </div>

  <div class="panel" id="diklat-panel">
    <div class="panel-title">Diklat</div>
  </div>

  <div class="panel" id="organisasi-panel">
    <div class="panel-title">Organisasi</div>
  </div>

  <div class="panel" id="penghargaan-panel">
    <div class="panel-title">Penghargaan</div>
  </div>

  <div class="panel" id="sj-panel">
    <div class="panel-title">Sumpah/Janji</div>
  </div>

  <div class="panel" id="keluarga-panel">
    <div class="panel-title">Keluarga</div>
  </div>

  <div class="panel" id="penugasan-panel">
    <div class="panel-title">Penugasan</div>
  </div>

  <div class="panel" id="cuti-panel">
    <div class="panel-title">Cuti</div>
  </div>

  <div class="panel" id="arsip-panel">
    <div class="panel-title">Arsip Lainnya</div>
  </div>

  </div>
</div>


<script>

$(function(){
  $('#form_pangkat').html(' ')
    // $('#form_pangkat').append(divLoaderNavy)
    $('#form_pangkat').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormDokPangkat/')?>', function(){
    $('#loader').hide()    
    })

        
  })

  $('#pangkat').click(function(e) {  
    $('#form_pangkat').html(' ')
    // $('#form_pangkat').append(divLoaderNavy)
    $('#form_pangkat').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormDokPangkat/')?>', function(){
    $('#loader').hide()    
    })
});
</script>

          
            </div>
        </div>
    </div>
</div>
</div>
<!-- tutup upload dokumen  -->

<!-- <div class="container-fluid p-0">
<h1 class="h3 mb-3">Lihat Dokumen</h1>
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- <div class="card-header">
                <h5 class="card-title mb-0">Upload</h5>
            </div> -->
            <div class="card-body">
            
            <div class="col-12 tableFixHead">
			<div class="card card-default" id="list_dokumen_pns">
			
	</div>
			
</div>
            </div>
        </div>
    </div>
</div>
</div> -->

 



		<script src="<?php echo base_url()?>assets/siladen/plugins/dropzone/dropzone.js"></script>
                         
<script type="text/javascript">

$(function(){
        loadDokumenPns()
    })

    function loadDokumenPns(){
    

        $('#list_dokumen_pns').html('')
        // $('#list_dokumen_pns').append(divLoaderNavy)
        $('#list_dokumen_pns').load('<?=base_url("kepegawaian/C_Kepegawaian/loadDokumenPns")?>', function(){
            // $('#loader').hide()
        })
    }

		   
			Dropzone.options.upload = {
                
				addRemoveLinks : true,
				dictDefaultMessage: "Click atau Letakkan file disini",
				success: function(file, response){
					$('#token').val(response.token);
					if(file.previewElement){
						$(file.previewElement).addClass("dz-success").find('.dz-error-message').text(response.error);
                    }
                    loadDokumenPns()	
				},
				error: function(file, response){
					$('#token').val(response.token);
					if(file.previewElement){
						$(file.previewElement).addClass("dz-error").find('.dz-error-message').text(response.error);
                      
					}	
				}
			};
			
			$('[data-tooltip="tooltip"]').tooltip();
            

//  Search table
'use strict';

var TableFilter = (function() {
 var Arr = Array.prototype;
		var input;
  
		function onInputEvent(e) {
			input = e.target;
			var table1 = document.getElementsByClassName(input.getAttribute('data-table'));
			Arr.forEach.call(table1, function(table) {
				Arr.forEach.call(table.tBodies, function(tbody) {
					Arr.forEach.call(tbody.rows, filter);
				});
			});
		}

		function filter(row) {
			var text = row.textContent.toLowerCase();
       //console.log(text);
      var val = input.value.toLowerCase();
      //console.log(val);
			row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
		}

		return {
			init: function() {
				var inputs = document.getElementsByClassName('table-filter');
				Arr.forEach.call(inputs, function(input) {
					input.oninput = onInputEvent;
				});
			}
		};
 
	})();
 TableFilter.init(); 
 // Tutup Search table		
		
       function toggleFormatDok(){
       
                    var x = document.getElementById("format-dokumen");
                    if (x.style.display === "none") {
                        // x.style.display = "block";
                        $("#format-dokumen").show('fast');
                        $('#btn_format_dok').html('Lihat Format Dokumen <i class="fa fa-angle-up" aria-hidden="true"></i>')
                    } else {
                        $('#btn_format_dok').html('Lihat Format Dokumen <i class="fa fa-angle-down" aria-hidden="true"></i>')
                        $("#format-dokumen").hide('fast');
                        // x.style.display = "none";
                    }
                  
                }

</script>
