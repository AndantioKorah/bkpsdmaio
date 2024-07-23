<?php
  if($profil_pegawai){
?>

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
	


	</script>
	<?php } else { ?>
	<div class="row">
		<div class="col-lg-12 text-center">
			<h5>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h5>
		</div>
	</div>
	<?php } ?>
