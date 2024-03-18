<?php if($result){ ?>
    <style>
    
/* .modal-fullscreen */
#myModalLabel {
  text-align: center;
  padding-top: 50px;
  margin-bottom: 50px;
}

.center-content {
				text-align:center;
				margin-top: 50px;
			}

			.content-wrapper {
				height: 100%;
				
				.content {
					line-height: 1.5em;
					
					font-weight: 300;
					color: $gray;
				}
				.l-content-help{
					margin: 50px 50px;
				}
				.l-text-indent {
					text-indent: -1.1em;
				}
				.large-text{
					font-size: 1.5em;
					// margin-top: -20px;
					
				}
				.btn-large {
					font-size: 1.3em;
					font-weight: 300;
					letter-spacing: 1px;
					// border-color: #624E7A;
				}

				
				.fa {
					color: $purple-dark;
					// border-color: #624E7A;
					border-color: $purple-dark;
				}
				i.fa.fa-lg.fa-download {
					color: $gray !important;
				}
			}
		}
.modal-fullscreen {
  /*background: transparent;*/
}
.modal-fullscreen .modal-content {
  background: transparent;
  border: 0;
  -webkit-box-shadow: none;
  box-shadow: none;
}
.modal-backdrop.modal-backdrop-fullscreen {
  background: #ffffff;
}
.modal-backdrop.modal-backdrop-fullscreen.in {
  /*opacity: .97;
  filter: alpha(opacity=97);*/
}

/* .modal-fullscreen size: we use Bootstrap media query breakpoints */

.modal-fullscreen .modal-dialog {
  margin: 0;
  margin-right: auto;
  margin-left: auto;
  width: 100%;
}
@media (min-width: 768px) {
  .modal-fullscreen .modal-dialog {
    width: 100%;
  }
}
@media (min-width: 992px) {
  .modal-fullscreen .modal-dialog {
    width: 100%;
  }
}
@media (min-width: 1200px) {
  .modal-fullscreen .modal-dialog {
    width: 100%;
  }
}

.spanverifikator{
  font-size: .7rem;
  font-weight: 600;
}

.tr_terima{
  background-color: #b2ffdc !important;
}

.tr_ditolak{
  background-color: #ffcbcb !important;
}


</style>
    <hr>
    <div  class="col-12 table-responsive">
    <table border=0 class="table" id="table_list_kegiatan_detail_rekap">
        <thead>
            <th style="padding: 0px; width: 5%;" class="text-center">No</th>
            <th style="padding: 0px; width: 10%;" class="text-center">Tanggal Kegiatan</th>
            <th style="padding: 0px; width: 45%;" class="text-center">Kegiatan</th>
            <th style="padding: 0px; width: 10%;" class="text-center">Realisasi</th>
            <th style="padding: 0px; width: 5%;" class="text-center">Bukti Realisasi</th>
            <th style="padding: 0px; width: 25%;" class="text-center">Verifikasi</th>
        </thead>
        <tbody>
            <?php $no=1; foreach($result as $rs){
                $tr_class = "";
                $status_verif = '<span style="font-size: .7rem; font-weight: bold; color: white; padding: 3px; background-color: grey;"><i class="fa fa-dot-circle"></i> Belum Verif</span>';
                if($rs['status_verif'] == 1){
                    $tr_class = 'tr_terima';
                    $status_verif = '<span style="font-size: .7rem; font-weight: bold; color: white; padding: 3px; background-color: green;"><i class="fa fa-check-circle"></i> Verified</span>';
                } else if($rs['status_verif'] == 2){
                    $tr_class = 'tr_ditolak';
                    $status_verif = '<span style="font-size: .7rem; font-weight: bold; color: white; padding: 3px; background-color: red;"><i class="fa fa-times-circle"></i> Ditolak</span>';
                } else if($rs['status_verif'] == 3){
                    $status_verif = '<span style="font-size: .7rem; font-weight: bold; color: black; padding: 3px; background-color: yellow;"><i class="fa fa-minus-circle"></i> Verifikasi Dibatalkan</span>';
                }
            ?>
                <tr class="<?=$tr_class?>">
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-center"><?=formatDateOnly($rs['tanggal_kegiatan']);?></td>
                    <td><?=$rs['deskripsi_kegiatan'];?></td>
                    <td class="text-center"><?=$rs['realisasi_target_kuantitas'].' '.$rs['satuan']?></td>
                    <td class="text-center">
                    <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-file"></i> Lihat File
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php 
                                $file = json_decode($rs['bukti_kegiatan']);
                                $tanggal = new DateTime($rs['tanggal_kegiatan']);
                                $tahun = $tanggal->format("Y");
                                $bulan = $tanggal->format("m");
                                $nomor = 1;
                                if($file) {
                                foreach($file as $file_name)
                                    {
                                         $data = $file_name;    
                                        //  $ekstension = substr($data, strpos($data, ".") + 1); 
                                         $ekstension = pathinfo($data, PATHINFO_EXTENSION);

                                        if($file_name == null){
                                            echo "<a class='dropdown-item' >Tidak Ada File</a>";
                                        } else {
                                            echo "<a class='dropdown-item' href=".base_url('assets/bukti_kegiatan/'.$tahun.'/'.$bulan.'/'.$file_name.'')." target='_blank'>Dokumen ".$nomor."</a>";  
                                            // echo "<a class='dropdown-item'  href='javascript:;' data-id='".$rs['id']."' data-bulan='".$bulan."' data-tahun='".$tahun."'  data-gambar='".$file_name."' data-toggle='modal' data-target='#edit-data'>Dokumen ".$nomor."</a>";
                                        }
                                    $nomor++;
                                    } 
                                  } else {
                                    echo "<a class='dropdown-item' >Tidak Ada File</a>";
                                  }
                                ?>
    
                            </div>
                    </td>
                    <td>
                        <?=$status_verif?><br>
                        <?php if($rs['status_verif'] != 0){ ?>
                            <span class="spanverifikator">oleh: <?=$rs['verifikator']?></span><br>
                            <span class="spanverifikator">pada: <?=formatDateNamaBulanWT($rs['tanggal_verif'])?></span>
                        <?php } ?>
                        <div class="col-lg-12 row mt-2">
                          <div class="col-lg-12">
                            <textarea style="width: 100%;" id="keterangan_verif_modal_<?=$rs['id']?>"><?=$rs['keterangan_verif']?></textarea>
                          </div>
                          <div class="col-lg-6">
                            <button onclick="saveKeteranganVerif('<?=$rs['id']?>')" class="btn btn-sm btn-warning"><i class="fa fa-save"></i> Simpan</button>
                          </div>
                          <div class="col-lg-6 text-right">
                            <?php if($rs['status_verif'] == 1){?>
                              <button onclick="checkVerifModal('2','<?=$rs['id']?>')" class="btn_batal_verif_modal_<?=$rs['id']?> btn btn-sm btn-danger"><i class="fa fa-times"></i> Tolak</button>
                              <button disabled style="display: none;" class="btn_loading_batal_verif_modal_<?=$rs['id']?> btn btn-sm btn-danger"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
                            <?php } else { ?>
                              <button onclick="checkVerifModal('1','<?=$rs['id']?>')" class="btn_verif_modal_<?=$rs['id']?> btn btn-sm btn-success"><i class="fa fa-check"></i> Terima</button>
                              <button disabled style="display: none;" class="btn_loading_verif_modal_<?=$rs['id']?> btn btn-sm btn-success"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
                            <?php } ?>
                          </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
    <div aria-hidden="true" aria-labelledby="myLargeModalLabel" role="dialog" tabindex="-1" id="edit-data" class="modal modal-fullscreen fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
          
            <div class="modal-body">
            <style>
                .button_wrapper {
                  width: 33%;
                  float: left;
              }

              .button {
                  display: inline-block;
                  /* background-color: yellow; */
              }
              </style>
               <div class="button_wrapper">
            <div class="button">
            <button onClick="rotateImgLeft()"   type="button" class="next btn btn-info alignleft" value=""> <i class="fa fa-undo" aria-hidden="true"></i> </button>
            </div>
            </div>
            <div class="button_wrapper" style="text-align: center;">
                <div class="button">
                <!-- <button class="btn_close" type="button" class="close" aria-label="Close"> -->
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                <!-- <i class="fa fa-window-close" aria-hidden="true"></i> -->
                </button>
                </div>
            </div>
            <div class="button_wrapper" style="text-align: right;">
                <div class="button">
            <button onClick="rotateImgRight()"  type="button" class="next btn btn-info alignright" value=""> <i class="fa fa-redo" aria-hidden="true"></i> </button>

                </div>
            </div>
            <style>
                .alignleft {
                    float: left;
                }
                .alignright {
                    float: right;
                }
            </style>
            <script>
              $( ".btn_close" ).on( "click", function() {
                $('#edit-data').modal('hide');
            } );
            </script>

           
                <center>
                        <div class="container" style="margin-top:50px;">
                        <div id="gambar_lama"></div>
                        </div>
                 </center>      
         </div>
                
         

            </div>
        </div>
    </div>
</div>
    <script>
        $(function(){
            $('#table_list_kegiatan_detail_rekap').dataTable()
        })

     


// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
// img.onclick = function(){
//   modal.style.display = "block";
//   modalImg.src = this.src;
//   captionText.innerHTML = this.alt;
// }

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
// span.onclick = function() { 
//   modal.style.display = "none";
// }
</script>
<script>
    let rotation = 0;
    function rotateImgRight() {
      rotation += 90; // add 90 degrees, you can change this as you want
      if (rotation === 360) { 
        // 360 means rotate back to 0
        rotation = 0;
      }
      document.querySelector("#img").style.transform = `rotate(${rotation}deg)`;
    }

    function rotateImgLeft() {
      // let rotation = 0;
      rotation += -90; // add 90 degrees, you can change this as you want
      if (rotation === 360) { 
        // 360 means rotate back to 0
        rotation = 0;
      }
      document.querySelector("#img").style.transform = `rotate(${rotation}deg)`;
    }
  </script>

<script>
           $('#edit-data').on('show.bs.modal', function (event) {
            $('#gambar_lama').html('');
          
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal          = $(this)
           
            // Isi nilai pada field
            modal.find('#id').attr("value",div.data('id'));

            modal.find('#img2').attr("src","http://placekitten.com/120/120/");
            // console.log(div.data('gambar'))
            $('#gambar_lama').append('<img id="img" class="img-fluid" alt="Responsive image"  src="<?php echo base_url();?>/assets/bukti_kegiatan/'+div.data('tahun')+'/'+div.data('bulan')+'/'+div.data('gambar')+'?=t'+new Date().getTime()+'" class="thumb">');

            
        });
  
        function checkVerifModal(status, id){
          if(status == '1'){
            $('.btn_verif_modal_'+id).hide()
            $('.btn_loading_verif_modal_'+id).show()
          } else {
            $('.btn_batal_verif_modal_'+id).hide()
            $('.btn_loading_batal_verif_modal_'+id).show()
          }
          $.ajax({
              url: '<?=base_url("kinerja/C_VerifKinerja/checkVerif")?>'+'/'+status+'/'+id,
              method: 'post',
              data: {
                  'keterangan_verif' : $('#keterangan_verif_modal_'+id).val()
              },
              success: function(data){
                  let rs = JSON.parse(data)
                  if(rs.code == 0){
                    openListKegiatan('<?=$id_rencana_kegiatan?>')
                    // loadKinerjaUser()
                  } else {
                      errortoast(rs.message)
                  }
                  if(status == '1'){
                    $('.btn_verif_modal_'+id).show()
                    $('.btn_loading_verif_modal_'+id).hide()
                  } else {
                    $('.btn_batal_verif_modal_'+id).show()
                    $('.btn_loading_batal_verif_modal_'+id).hide()
                  }
              }, error: function(e){
                  errortoast('Terjadi Kesalahan')
              }
          })
      }

      function saveKeteranganVerif(id){
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/saveKeteranganVerif")?>'+'/'+id,
            method: 'post',
            data: {
                'keterangan_verif' : $('#keterangan_verif_modal_'+id).val()
            },
            success: function(data){
              openListKegiatan('<?=$id_rencana_kegiatan?>')
              successtoast('Berhasil menyimpan data')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
      }
</script>
    </script>
<?php } else { ?>
    <center><b>Tidak ada data<b></center>
<?php } ?>