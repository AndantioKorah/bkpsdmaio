<?php if($result){ ?>
    <style>
      .list-group-item.active {
    background-color: #222e3c;
    border-color: var(--bs-list-group-active-border-color);
    color: var(--bs-list-group-active-color);
    z-index: 2;
}
    </style>

    <div class="table-responsive">
    <table id="table_jt" class="table table-hover table-striped table-bordered datatable" style="width:100%;">
    <thead >
    <th class="text-center" style="width:5%;">No</th>
                <th style="width:40%;">Nama/ NIP</th>
                <th style="width:55%;">Jabatan Target</th>
            </thead>
            <tbody>
                <?php $nomor = 1; foreach($result as $rs){ ?>
                  
                    <tr >
                    <td class="align-top" align="center"><?=$nomor++;?></td>
                        <td class="align-top">
                        <?=$rs['gelar1'];?><?=$rs['nama'];?><?=$rs['gelar2'];?> /<br><?=$rs['nipbaru'];?>
                        <br>
                        Pangkat : 
                        <b><?=$rs['nm_pangkat'];?></b><br>
                        
                        Jabatan Sekarang :<br>
                        <b><?=$rs['nama_jabatan'];?></b><br>
                       
                        </td>
                        <td class="align-top">
                <!-- <form method="post" action="submit-jabatan-target" enctype="multipart/form-data" > -->
                <form method="post" id="submit_jabatan_target" enctype="multipart/form-data" >

                    <div class="mb-3">
                    <div class="row">
    
                    <div class="col-lg-9 col-md-4">
                        <div class="form-group">
                        <input type="hidden" name="id_pegawai" value="<?=$rs['id_peg'];?>">
                        <select class="form-control js-example-basic-multiple" name="jabatan_target[]" multiple="multiple" required>
                        <!-- <option disabled selected>Pilih Jabatan Target</option> -->
                        <?php if($jabatan){ foreach($jabatan as $r){ ?>
                        <option value="<?=$r['id_jabatanpeg']?>"><?=$r['nama_jabatan']?> Pada <?=$r['nm_unitkerja']?> </option>
                         <?php } } ?>
                        </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="form-group">
                        <button class="btn btn-sm btn-navy float-right" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
                        </div>
                    </div>

                        </div>
                        <span class="mt-2">Jabatan Target :</span><br>
                        <?php  foreach($jabatan_target as $jt){ ?>
                            <?php if($rs['id_peg'] == $jt['id_peg']) { ?>
                               <table class="table table-hover table-striped table-bordered">
                                <tr >
                                    <td  valign="top">-</td>
                                    <td> <b><?=$jt['nama_jabatan'];?> Pada <?=$jt['nm_unitkerja'];?></b> 
                                </td>
                                <td>
                                <a onclick="deleteDataJt('<?=$jt['id']?>')" class="btn btn-sm"> <i style="color:red;" class="fa fa-trash"></i> </a>
                                </td>
                                </tr>
                               </table>
                        <?php } ?>
                         <?php } ?>
                         </form>
                    </td>
                    </tr>
                  
                <?php } ?>
            </tbody>
        </table>
      
        </div>
    

</div>

<script>
      $(function(){
        $('.js-example-basic-multiple').select2();
    $('.datatable').dataTable()
  })

  function deleteDataJt(id){
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("simata/C_Simata/deleteDataJabatanTarget/")?>'+id,
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


               $('#submit_jabatan_target').on('submit', function(e){  
                e.preventDefault();
                var formvalue = $('#form_cari');
                var form_data = new FormData(formvalue[0]);
             
                }); 

// var table = $('.datatable').DataTable();
  
//     $('.dataTables_filter input')
 
//     .on( 'keyup', function () {
//         table.column(2).search( this.value ).draw();
//     } );

</script>
<?php } else { ?>
    <div class="col-12 text-center">
        <h5>DATA TIDAK DITEMUKAN !</h5>
    </div>
<?php } ?>