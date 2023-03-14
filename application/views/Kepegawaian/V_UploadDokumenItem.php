
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
  <!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/adminkit/css/modal2.css"> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> -->

  <style>


		@media (max-width: 1280px){
			.md-dialog  {
				height:630px;
				width:800px;
			}
			.md-body {
				height: 500px;	
			}
		}
		/* .md-dialog  {
				height:630px;
				width:800px;
			}
			.md-body {
				height: 500px;	
                width:800px;
			} */

        @media (max-width< 1280px){
			.md-dialog  {
				height:630px;
				width:800px;
			}
			.md-body {
				height: 300px;	
			}
		}

		/* @media screen and (min-width:1281px) and (max-width:1600px){
			.md-dialog  {
				height:700px;
				width:1000px;
			}
			.md-body {
				height: 550px;	
			}
		}
		@media screen and (min-width:1601px) and (max-width:1920px){
			.md-dialog  {
				height:830px;
				width:1200px;
			}
			.md-body {
				height: 700px;	
			}
		}   */
        
        body:not(.modal-open){
        padding-right: 0px !important;
        }
        </style>

       
                            


  <table id="table_rencana_kinerja" class="table table-striped ">
									<thead>
										<tr>
											<th>Dokumen</th>
											<th>NIP</th>
											<th>Time</th>
											<th>Oleh</th>
											<th>Aksi</th>

										</tr>
									</thead>   
                                    <tbody>
                <?php $no=1; foreach($list_dokumen as $lk){ 
                    if($lk->minor_dok == 50){
                            $n = "S-3/Doktor";
                    } else if($lk->minor_dok ==  45){
                        $n = "S-2";
                    } else if($lk->minor_dok ==  40){
                        $n = "S-1/Sarjana";
                    } else if($lk->minor_dok == 35){
                        $n = "Diploma IV";
                    } else if($lk->minor_dok == 30){
                        $n = "Diploma III/Sarjana Muda";
                    } else if($lk->minor_dok == 25){
                        $n = "Diploma II";
                    } else if($lk->minor_dok == 20){
                        $n = "Diploma I";
                    } else if($lk->minor_dok == 18){
                        $n = "SLTA Keguruan";
                    } else if($lk->minor_dok == 17){
                        $n = "SLTA Kejuruan";
                    } else if($lk->minor_dok == 15){
                        $n = "SLTA";
                    } else if($lk->minor_dok == 12){
                        $n = "SLTP Kejuruan";
                    } else if($lk->minor_dok == 10){
                        $n = "SLTP";
                    } else if($lk->minor_dok == 05){
                        $n = "Sekolah Dasar";
                    } else {
                        $n = $lk->minor_dok;	   
                    } 
                    // dd($lk);
                    ?>
                    
                <tr>
                    <td class="text-left"><?=$lk->nama_dokumen;?> <?=$n;?></td>
                    <td class="text-left">
                    <?=$lk->nip;?><br>
                    <?=$lk->nama;?>
                    </td>
                    <td class="text-left">
                    <b><?=$lk->nama_status;?></b><br>
                    <?=$lk->update_date;?>
                </td>
                    <td class="text-left"><?=$lk->nama;?></td>
                    <td>
                   
                    <a class="nav-icon dropdown-toggle" href="#"  data-bs-toggle="dropdown">
								<div class="position-relative">
                                <i class="fa fa-lg fa-ellipsis-v" style="font-size:22px" aria-hidden="true"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="#" data-id="?id=<?=$lk->nip;?>&f=<?=$lk->orig_name;?>" data-toggle="modal" data-target="#skModal"><i class="fa fa-search m-r-5"></i> Lihat</a>
								<!-- <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a> -->
								
                    <!-- <div class="dropdown dropdown-action"><a href="#" class="action-icon " data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
								<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#" data-id="?id=<?=$lk->nip;?>&f=<?=$lk->orig_name;?>" data-toggle="modal" data-target="#skModal"><i class="fa fa-search m-r-5"></i> Lihat</a>
					</div></div> -->
                    </td>
                                    </tr>
                    <?php } ?>
                                    </tbody>                                          


                              </table>

      
<div class="container">
     <!-- Modal -->
     <div class="modal fade" id="skModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Dokumen Kepegawaian</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="height:500px;">
                                        <iframe   id="frame" width="100%" height="100%" frameborder="0" ></iframe>	
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
    <!-- tutup modal  -->

  

<script>
    $(document).ready(function() {
 $('#table_rencana_kinerja').DataTable({
    "ordering": false,
 });


 $('#skModal').on('show.bs.modal',function(e) {    	
                    var iframe = $('#frame');
					var id=  $(e.relatedTarget).attr('data-id');
                    var url = '<?php echo site_url()?>'+'kepegawaian/C_Kepegawaian/getInline/';
					console.log(url);
					iframe.attr('src', url+id);			
				});


});          
</script>  


