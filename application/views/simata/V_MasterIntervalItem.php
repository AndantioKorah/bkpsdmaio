<?php if($result){ ?>
    <style>
      .list-group-item.active {
    background-color: #222e3c;
    border-color: var(--bs-list-group-active-border-color);
    color: var(--bs-list-group-active-color);
    z-index: 2;
}
    </style>
    <div class="list-group">
  <a class="list-group-item list-group-item-action active" aria-current="true">
    A. Unsur Penilaian Kinerja
  </a>
    <a class="list-group-item list-group-item-action" style="background-color:#d5dce4;"></a>
    <a class="list-group-item list-group-item-action">
    
    <div class="table-responsive">
    <table class="table table-hover table-striped table-bordered" style="width:100%;">
    <thead >
    <th class="text-center">No</th>
                <th style="width:30%;">Kriteria</th>
                <th style="width:20%;">Dari</th>
                <th style="width:20%;">Sampai</th>
                <th style="width:20%;"></th>
            </thead>
            <tbody>
                <?php $nomor = 1; foreach($result as $rs){ ?>
                     <?php if($rs['id_m_unsur_penilaian'] == 1) { ?>
                    <tr>
                    <td align="center"><?=$nomor++;?></td>
                        <td><?=$rs['kriteria'];?></td>
                        <td><?=$rs['dari'];?></td>
                        <td><?=$rs['sampai'];?></td>
                        <td>
                        <button 
                        data-toggle="modal" 
                        data-id="<?=$rs['id']?>"
                        data-kriteria="<?=$rs['kriteria']?>"
                        data-dari="<?=$rs['dari']?>"
                        data-sampai="<?=$rs['sampai']?>"
                        data-unsur="Kinerja"
                        href="#modal_detail_interval"
                        title="Ubah Data" class="open-DetailIndikator btn btn-sm btn-info"> <i class="fa fa-edit"></i> Edit</button> 
                        <button onclick="deleteData('<?=$rs['id']?>')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button>
                    </td>
                    </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        </div>
    </a>

  <a class="list-group-item list-group-item-action active" aria-current="true">
  B. Unsur Penilaian Potensial
  </a>
 
       
    <a class="list-group-item list-group-item-action" style="background-color:#d5dce4;"><b></b></a>
    <a class="list-group-item list-group-item-action">

    <div class="table-responsive">
    <table class="table table-hover table-striped table-bordered" style="width:100%;">
    <thead >
                <th class="text-center">No</th>
                <th style="width:30%;">Kriteria</th>
                <th style="width:20%;">Dari</th>
                <th style="width:20%;">Sampai</th>
                <th style="width:20%;"></th>
            </thead>
            <tbody>
                <?php $nomor = 1; foreach($result as $rs){ ?>
                     <?php if($rs['id_m_unsur_penilaian'] == 2) { ?>
                    <tr>
                    <td align="center"><?=$nomor++;?></td>
                        <td><?=$rs['kriteria'];?></td>
                        <td><?=$rs['dari'];?></td>
                        <td><?=$rs['sampai'];?></td>
                        <td>
                        <button 
                        data-toggle="modal" 
                        data-id="<?=$rs['id']?>"
                        data-kriteria="<?=$rs['kriteria']?>"
                        data-dari="<?=$rs['dari']?>"
                        data-sampai="<?=$rs['sampai']?>"
                        data-unsur="Potensial" 
                        href="#modal_detail_interval"
                        title="Ubah Data" class="open-DetailIndikator btn btn-sm btn-info"> <i class="fa fa-edit"></i> Edit</button> 
                        <button onclick="deleteData('<?=$rs['id']?>')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button>
                    </td>
                    </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        </div>
    </a>
   
</div>

<!-- modal detail indikator -->
<div class="modal fade" id="modal_detail_interval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelIndikator" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabelIndikator"><span id="kriteriax"></span></h3>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="form_edit_interval" enctype="multipart/form-data" >
      <input type="hidden" class="form-control" id="edit_interval_id" name="edit_interval_id">
  <div class="mb-3">
    <label class="form-label">Kriteria</label>
    <input autocomplete="off" type="text" class="form-control" id="edit_interval_kriteria" name="edit_interval_kriteria">
  </div>
  <div class="mb-3">
    <label  class="form-label">Dari</label>
    <input min=0 step=0.01  required class="form-control" autocomplete="off" type="number" id="edit_interval_dari" name="edit_interval_dari">
  </div>

  <div class="mb-3">Sampai
    <label class="form-label"></label>
    <input min=0 step=0.01  required class="form-control" autocomplete="off" type="number" id="edit_interval_sampai" name="edit_interval_sampai">

  </div>

  <button  class="btn btn-primary float-right">Simpan</button>
</form>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
<!-- tutup modal detail indikator -->


<script>
    $(document).on("click", ".open-DetailIndikator", function () {
   
    var id = $(this).data('id');
    var kriteria = $(this).data('kriteria');
    var dari = $(this).data('dari');
    var sampai = $(this).data('sampai');
    var unsur = $(this).data('unsur');
    $("#kriteriax").html( unsur );

     
     $(".modal-body #edit_interval_id").val( id );
     $(".modal-body #edit_interval_kriteria").val( kriteria );
     $(".modal-body #edit_interval_dari").val( dari );
     $(".modal-body #edit_interval_sampai").val( sampai );

    });

    $(document).on("click", ".open-EditIndikator", function () {
     var id = $(this).data('id');
    
     var id = $(this).data('id');
    $('#list_kriteria_2').html('')
    $('#list_kriteria_2').append(divLoaderNavy)
    $('#list_kriteria_2').load('<?=base_url("simata/C_Simata/loadListIndikator/")?>', function(){
      $('#loader').hide()
    })
    });


    function deleteData(id){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("simata/C_Simata/deleteDataInterval/")?>'+id,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                                location.reload()
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }


               $('#form_edit_interval').on('submit', function(e){  
                e.preventDefault();
                var formvalue = $('#form_edit_interval');
                var form_data = new FormData(formvalue[0]);

                $.ajax({  
                url:"<?=base_url("simata/C_Simata/updateInterval")?>",
                method:"POST",  
                data:form_data,  
                contentType: false,  
                cache: false,  
                processData:false,  
                // dataType: "json",
                success:function(res){ 
                    console.log(res)
                    var result = JSON.parse(res); 
                    console.log(result)
                    if(result.success == true){
                        successtoast(result.msg)
                        setTimeout(function() {$("#modal_dismis").trigger( "click" );}, 1500);
                        // setTimeout(loadListJabatan, 1500);
                        location.reload();
                    
                    } else {
                        errortoast(result.msg)
                        return false;
                    } 
                    
                }  
                });  
                
                });

</script>
<?php } else { ?>
    <div class="col-12 text-center">
        <h5>DATA TIDAK DITEMUKAN !</h5>
    </div>
<?php } ?>