<link rel="stylesheet" href="<?php echo base_url()?>assets/siladen/plugins/dropzone/dropzone.css">

<!-- <link rel="stylesheet" href="<?=base_url('assets/css/datatable.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/jquery.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/responsive.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/datatable.bootstrap.min.css')?>"> -->



<!-- upload dokumen  -->
<div class="container-fluid p-0">
<h1 class="h3 mb-3">Upload Dokumen</h1>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Upload</h5>
            </div>
            <div class="card-body">
            <form id="upload" action="<?php echo site_url()?>/arsip/doUpload" class="dropzone">
									
                                    <input type="hidden" id="token" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">

            </form>
			<br>
			<button class="btn btn-primary"></button>
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
            <div class="card-header">
                <h5 class="card-title mb-0">Upload</h5>
            </div>
            <div class="card-body">
                <style>
                    .tableFixHead { overflow-y: auto; height: 600px; }

.content_table{
                   font-size: 13px;
                   /* text-align: center; */
                      }

.tableFixHead table { 
            border: 1px solid #fff;
            font-size: 13px;
          } 
          
  .tableFixHead th { 
            background-color: #464646;
            color: #d1d1d1;
            border-top: 5px;
            padding: 8px 15px; 
            font-weight: normal;
          } 


      .tableFixHead tr:nth-child(even) th[scope=row] {
      background-color: #f2f2f2;
      color: black;
      }

  
      .tableFixHead tr:nth-child(odd) th[scope=row] {
      background-color: #fff;
      
      }

      .tableFixHead tr:nth-child(even) {
      background-color: rgba(0, 0, 0, 0.05);
      }

      .tableFixHead tr:nth-child(odd) {
      background-color: rgba(255, 255, 255, 0.05);
      }

      .tableFixHead td:nth-of-type(2) {
      width: 100px;
      }

      .tableFixHead th:nth-of-type(3),
      td:nth-of-type(3) {
      /* text-align: center; */
      } 



     /* @media screen and (width> 600px) {
      .tableFixHead th[scope=row] {
      position: -webkit-sticky;
      position: sticky;
      left: 0;
      z-index: 0;
      }
     } */


      /* .tableFixHead th[scope=row] {
      vertical-align: top;
      color: inherit;
      background-color: inherit;
      background: linear-gradient(90deg, transparent 0%, transparent calc(100% - .05em), #d6d6d6 calc(100% - .05em), #d6d6d6 100%);
      z-index: 0;
      }
       */

      /* .tableFixHead table:nth-of-type(2)  th:not([scope=row]):first-child {
      left: 0;
      z-index: 0;
      background: linear-gradient(90deg, #666 0%, #666 calc(100% - .05em), #ccc calc(100% - .05em), #ccc 100%);
      } */


      /* .tableFixHead th[scope=row] + td {

      }

      .tableFixHead th[scope=row] {
      z-index: 0;
      min-width: 20em;
      } */


      .cd-search{
      padding: 10px;
      border: 1px solid #ccc;
      width: 100%;
      box-sizing: border-box;
      margin-bottom: 10px;
      border-radius: 0px;
                 }

      .tableFixHead tr:nth-child(odd) td {
          background: white;
         
      }

      .tableFixHead tr:nth-child(even) td {
          background: #f2f2f2;
      }

      /* @media screen and (width> 600px) {
      .tableFixHead tr>td:first-child + td {
      position: sticky;
      left: 0;
      min-width: 20em;
      }
     } */

                </style>
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

    function loadDokumenPns(bulan,tahun){
    

        $('#list_dokumen_pns').html('')
        // $('#list_dokumen_pns').append(divLoaderNavy)
        $('#list_dokumen_pns').load('<?=base_url("kepegawaian/C_Kepegawaian/loadDokumenPns")?>', function(){
            $('#loader').hide()
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
				},
				error: function(file, response){
					$('#token').val(response.token);
					if(file.previewElement){
						$(file.previewElement).addClass("dz-error").find('.dz-error-message').text(response.error);
                      
					}	
				}
			};
			
			$('[data-tooltip="tooltip"]').tooltip();
            

			
			
    

		</script>