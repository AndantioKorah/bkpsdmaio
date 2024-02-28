<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
    <form method="post" id="form_hasil"  enctype="multipart/form-data" >
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered" >
        <thead style="background-color:#222e3c;color:#fff;">
          <th class="text-left">Rumpun Jabatan</th>
          <th></th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
                <td >
                <?=$rs['nm_rumpun_jabatan']?>
                </td>
                <td>
                <a onclick="deleteRumpunJabatan('<?=$rs['id_rumpun']?>')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </a>  
              </td>
            </tr>
          <?php } ?>
           
        </tbody>
      </table>
      </div>
      <div class="modal-footer" style="margin-bottom:5px;">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      </form>
    </div>
  </div>
       

 
<script>
 

 $("#modal_input_rumpun_jabatan").on('hide.bs.modal', function(){
    loadListMasterJabatan()
  });


 function deleteRumpunJabatan(id){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("simata/C_Simata/deleteRumpunJabatan/")?>'+id,
                           method: 'post',
                           data: null,
                           success: function(){
                            loadListRumpunJabatan()
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }

</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>