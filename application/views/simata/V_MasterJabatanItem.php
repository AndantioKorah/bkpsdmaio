<?php if($jabatan){ ?>
<style>
	.list-group-item.active {
		background-color: #222e3c;
		border-color: var(--bs-list-group-active-border-color);
		color: var(--bs-list-group-active-color);
		z-index: 2;
	}

</style>

	<div class="table-responsive">
		<table class="table table-hover table-striped table-bordered datatablex" style="width:100%;">
			<thead>
				<th class="text-center" style="width:5%;">No</th>
				<th style="width:40%;">Nama Jabatan</th>
				<th style="width:55%;">Rumpun Jabatan</th>
                <th></th>
			</thead>
			<tbody>
				<?php $nomor = 1; foreach($jabatan as $rs){ ?>
				<tr>
					<td class="align-top" align="center"><?=$nomor++;?></td>
					<td class="align-top">
						<?=$rs['nama_jabatan'];?>
					</td>
          <td></td>
					<td class="align-top">
              <button 
                data-toggle="modal" 
                data-id="<?=$rs['id_jabatanpeg']?>"
                data-nm_jabatan="<?=$rs['nama_jabatan']?>"
                href="#modal_input_rumpun_jabatan"
                class="open-DetailJabatan btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

	</div>


 
<div class="modal fade" id="modal_input_rumpun_jabatan" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rumpun Jabatan</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div id="form_tambah_rumpun">

            </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>



<script>
	$(function () {

		$('.js-example-basic-multiple').select2();
		$('.datatable').dataTable()
	})

    $(document).on("click", ".open-DetailJabatan", function () {
    var id = $(this).data('id');
    $('#form_tambah_rumpun').html('')
    $('#form_tambah_rumpun').append(divLoaderNavy)
    $('#form_tambah_rumpun').load('<?=base_url("simata/C_Simata/loadFormTambahRumpun/")?>'+id, function(){
      $('#loader').hide()
    })
    });

  //   $("#modal_input_rumpun_jabatan").on('hide.bs.modal', function(){
  //   loadListMasterJabatan()
  // });


</script>
<?php } else { ?>
<div class="col-12 text-center">
	<h5>DATA TIDAK DITEMUKAN !</h5>
</div>
<?php } ?>
