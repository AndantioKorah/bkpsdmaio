<link rel="stylesheet" href="<?php echo base_url()?>assets/siladen/plugins/dropzone/dropzone.css">
<!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/adminkit/css/modal.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
<!-- <link rel="stylesheet" href="<?=base_url('assets/css/datatable.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/jquery.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/responsive.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/datatable.bootstrap.min.css')?>"> -->
    <style>
    
     </style>

<!-- upload dokumen  -->
<div class="container-fluid p-0">
<h1 class="h3 mb-3">Upload Dokumen</h1>
<div class="row">
    <div class="col-12">
        
        <div class="card">
       
            <div class="card-body">
                
            <form id="upload" action="<?php echo site_url()?>Kepegawaian/C_Kepegawaian/doUpload" class="dropzone">						
            <input type="hidden" id="token" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
            </form>
			<br>
            <div class="col-12" >
			<button id="btn_format_dok" onclick="toggleFormatDok()" style="width:100%;" class="btn btn-primary btn-block customButton">Lihat Format Dokumen <i class="fa fa-angle-down" aria-hidden="true"></i></button>
            </div>
            
            <!-- format dokumen  -->
            <!-- <div class="table-responsive"> -->
            <div id="format-dokumen" style="display:none;">
            <br>
            <input type="text" class="cd-search table-filter " data-table="rekap-table" placeholder="Cari Format Dokumen" />
            <div class="tableFixHead">
										<table class="rekap-table table table-striped table-sm">
										<thead class="thead-dark">
											<tr>
												<th>No</th>
												<th>Nama</th>
												<th>Format</th>
												<th>Limit</th>
												<th>File</th>												
												<th>Keterangan</th>													
											</tr>
										</thead>   
										<tbody>	
											<?php $i=1;foreach($dokumen->result() as $value):?>
											<tr>
												<td><?php echo $i?></td>
												<td><?php echo $value->nama_dokumen?></td>
												<td><?php echo $value->format?></td>
												<td><?php echo ROUND($value->file_size/1024)." MB"?></td>
												<td>pdf</td>
												<td><?php echo $value->keterangan?></td>
											</tr>
											<?php $i++;endforeach;?>
										</tbody>
										</table>
									</div>	
                                </div>
                     <!-- tutup format dokumen  -->
            </div>
        </div>
    </div>
</div>
</div>
<!-- tutup upload dokumen  -->

<div class="container-fluid p-0">
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
</div>

 



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
