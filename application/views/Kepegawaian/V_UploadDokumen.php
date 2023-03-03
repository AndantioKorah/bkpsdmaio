<link rel="stylesheet" href="<?php echo base_url()?>assets/siladen/plugins/dropzone/dropzone.css">

<link rel="stylesheet" href="<?=base_url('assets/css/datatable.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/jquery.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/responsive.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/datatable.bootstrap.min.css')?>">



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
            <table id="table_rencana_kinerja" class="table table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Billing Name</th>
										<th>Date</th>
										<th>Total</th>
										<th>Payment Status</th>
										<th>Payment Method</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><strong>#0001</strong></td>
										<td>Brian Smith</td>
										<td>2021-12-04</td>
										<td>$353.00</td>
										<td><span class="badge badge-success-light">Paid</span></td>
										<td><i class="fab fa-cc-mastercard me-1"></i> Mastercard</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0002</strong></td>
										<td>Patrick Babcock</td>
										<td>2021-12-05</td>
										<td><s>$939.00</s></td>
										<td><span class="badge badge-danger-light">Chargeback</span></td>
										<td><i class="fab fa-cc-visa me-1"></i> Visa</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0003</strong></td>
										<td>Ronald Woods</td>
										<td>2021-12-12</td>
										<td><s>$965.00</s></td>
										<td><span class="badge badge-warning-light">Refunded</span></td>
										<td><i class="fab fa-cc-visa me-1"></i> Visa</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0004</strong></td>
										<td>Morris Evans</td>
										<td>2021-12-21</td>
										<td>$247.00</td>
										<td><span class="badge badge-success-light">Paid</span></td>
										<td><i class="fab fa-cc-mastercard me-1"></i> Mastercard</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0005</strong></td>
										<td>Kirk Batts</td>
										<td>2022-01-05</td>
										<td>$187.00</td>
										<td><span class="badge badge-success-light">Paid</span></td>
										<td><i class="fab fa-cc-visa me-1"></i> Visa</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0006</strong></td>
										<td>Mark Lebron</td>
										<td>2022-01-11</td>
										<td>$784.00</td>
										<td><span class="badge badge-success-light">Paid</span></td>
										<td><i class="fab fa-cc-mastercard me-1"></i> Mastercard</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0007</strong></td>
										<td>Waylon Atkinson</td>
										<td>2022-02-01</td>
										<td>$258.00</td>
										<td><span class="badge badge-success-light">Paid</span></td>
										<td><i class="fab fa-cc-mastercard me-1"></i> Mastercard</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0008</strong></td>
										<td>David Larose</td>
										<td>2022-02-26</td>
										<td><s>$933.00</s></td>
										<td><span class="badge badge-danger-light">Chargeback</span></td>
										<td><i class="fab fa-cc-visa me-1"></i> Visa</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0009</strong></td>
										<td>Shawn Rapp</td>
										<td>2022-03-09</td>
										<td>$928.00</td>
										<td><span class="badge badge-success-light">Paid</span></td>
										<td><i class="fab fa-cc-visa me-1"></i> Visa</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0010</strong></td>
										<td>Chad Smith</td>
										<td>2022-03-17</td>
										<td><s>$715.00</s></td>
										<td><span class="badge badge-warning-light">Refunded</span></td>
										<td><i class="fab fa-cc-visa me-1"></i> Visa</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0011</strong></td>
										<td>Kenneth Garcia</td>
										<td>2022-04-06</td>
										<td>$534.00</td>
										<td><span class="badge badge-success-light">Paid</span></td>
										<td><i class="fab fa-cc-mastercard me-1"></i> Mastercard</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0012</strong></td>
										<td>Charles Trombly</td>
										<td>2022-04-19</td>
										<td><s>$334.00</s></td>
										<td><span class="badge badge-warning-light">Refunded</span></td>
										<td><i class="fab fa-cc-visa me-1"></i> Visa</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0013</strong></td>
										<td>Carlton Dillow</td>
										<td>2022-05-09</td>
										<td>$874.00</td>
										<td><span class="badge badge-success-light">Paid</span></td>
										<td><i class="fab fa-cc-mastercard me-1"></i> Mastercard</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0014</strong></td>
										<td>Hubert Ezell</td>
										<td>2022-05-14</td>
										<td>$963.00</td>
										<td><span class="badge badge-success-light">Paid</span></td>
										<td><i class="fab fa-cc-visa me-1"></i> Visa</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
									<tr>
										<td><strong>#0015</strong></td>
										<td>Paul Banks</td>
										<td>2022-06-03</td>
										<td><s>$898.00</s></td>
										<td><span class="badge badge-warning-light">Refunded</span></td>
										<td><i class="fab fa-cc-visa me-1"></i> Visa</td>
										<td>
											<a href="#" class="btn btn-primary btn-sm">View</a>
											<a href="#" class="btn btn-primary btn-sm">Edit</a>
										</td>
									</tr>
								</tbody>
							</table>
</div>
            </div>
        </div>
    </div>
</div>
</div>



                         
<script type="text/javascript">
		   
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