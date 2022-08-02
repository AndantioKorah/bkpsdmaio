
    <div class="card-header">
        <h3 class="card-title">List Realisasi Kegiatan</h3>
    </div>
    <div class="card-body">
    <div class="col-12">
    <form class="form-inline" method="post">
  <div class="form-group">
    <label for="email" class="mr-2">Tahun </label>
    <input  class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y');?>">
  </div>
  <div class="form-group">
    <label for="pwd" class="mr-2 ml-3"> Bulan</label>
    <select class="form-control select2-navy" 
                 id="bulan" data-dropdown-css-class="select2-navy" name="bulan" required>
                 <option <?=$bulan == 1 ? 'selected' : '';?> value="1">Januari</option>
                 <option <?=$bulan == 2 ? 'selected' : '';?> value="2">Februari</option>
                 <option <?=$bulan == 3 ? 'selected' : '';?> value="3">Maret</option>
                 <option <?=$bulan == 4 ? 'selected' : '';?> value="4">April</option>
                 <option <?=$bulan == 5 ? 'selected' : '';?> value="5">Mei</option>
                 <option <?=$bulan == 6 ? 'selected' : '';?> value="6">Juni</option>
                 <option <?=$bulan == 7 ? 'selected' : '';?> value="7">Juli</option>
                 <option <?=$bulan == 8 ? 'selected' : '';?> value="8">Agustus</option>
                 <option <?=$bulan == 9 ? 'selected' : '';?> value="9">September</option>
                 <option <?=$bulan == 10 ? 'selected' : '';?> value="10">Oktober</option>
                 <option <?=$bulan == 11 ? 'selected' : '';?> value="11">November</option>
                 <option <?=$bulan == 12 ? 'selected' : '';?> value="12">Desember</option>
                 </select>
         </div>
        <!-- <button type="button" onclick="searchListKegiatan()" class="btn btn-primary ml-3">Cari</button> -->
        </form>
     <br>
    </div>
        <div id="" class="row">
        <?php if($list_kegiatan){ ?>
        <div class="col-12 table-responsive">
        <table class="table table-hover table-striped" id="table_realisasi_kinerja" width="100%">
            <thead>
                <th class="text-center table-danger">No</th>
                <th class="text-left table-danger">Kegiatan Tugas Jabatan</th>
                <th class="text-left table-danger">Tanggal Kegiatan</th>
                <th class="text-left table-danger">Detail Kegiatan</th>
                <th class="text-left table-danger">Realisasi Target (Kuantitas)</th>
                <th class="text-left table-danger">Satuan</th>
                <th class="text-center table-danger">Status</th>
                <th class="text-center table-danger">Dokumen Bukti Kegiatan</th>
               
                <th class="table-danger"></th>
            </thead>
            <tbody>
            <?php $no=1; foreach($list_kegiatan as $lp){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$lp['tugas_jabatan']?></td>
                        <td class="text-left"><?= formatDateNamaBulanWT($lp['tanggal_kegiatan'])?></td>                       
                        <td class="text-left"><?=$lp['deskripsi_kegiatan']?></td>
                        <td class="text-left" style="width:10%;"><?=$lp['realisasi_target_kuantitas']?></td>
                        <td class="text-left"><?=$lp['satuan']?></td>
                        <td class="text-left">
                        <button class="btn btn-<?php if($lp['id_status_verif'] == 0) echo  "warning";
                                                    else if($lp['id_status_verif'] == 1) echo "success";
                                                    else if($lp['id_status_verif'] == 2) echo "danger";
                                                    else if($lp['id_status_verif'] == 3) echo "warning";   ?> btn-sm" type="button" >
                        <?= $lp['status_verif'];?>
                            </button></td>
                        <td class="text-center">  
                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-file"></i> Lihat File
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php 
                            
                            $file = json_decode($lp['bukti_kegiatan']);
                            $nodok = 1;
                            foreach($file as $file_name)
                                {
                                    if($file_name == null){
                                        echo "<a class='dropdown-item' >Tidak Ada File</a>";
                                    } else {
                                        echo "<a class='dropdown-item' href=".base_url('assets/bukti_kegiatan/'.$file_name.'')." target='_blank'>Dokumen ".$nodok."</a>";
                                    }
                                   $nodok++;
                                } 
                            ?>
   
                        </div>
                           
                        </td>
                        
                        <td class="text-center">
                       
                        <?php if($lp['id_status_verif'] != 1){ ?>
                            <span href="#edit_realisasi_kinerja" data-toggle="modal" >
                            <button href="#edit_realisasi_kinerja" data-toggle="tooltip" class="btn btn-sm btn-navy" data-placement="top" title="Edit" 
                             onclick="openModalEditRealisasiKinerja('<?=$lp['id']?>')"><i class="fa fa-edit"></i> </button>
                                 </span>  
                            <button onclick="deleteKegiatan('<?=$lp['id']?>','<?=$lp['tanggal_kegiatan']?>')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash" ></i></button>
                            <?php } ?>
                        </td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
        </div>
    </div>


    


   
<?php } else { ?>
    <div class="row">
        <div class="col-12">
            <h5 style="text-center">DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
        </div>
    </div>
<?php } ?>

<script>
        // $(document).ready(function () {
        // $('#table_realisasi_kinerja').DataTable({
        // "scrollX": true
        // });
        // $('.dataTables_length').addClass('bs-select');
        // });

        function deleteKegiatan(id,tgl){
           
           var d = new Date(tgl);

            var bulan = d.getMonth() + 1;
            var tahun = d.getFullYear();
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("kinerja/C_Kinerja/deleteKegiatan/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(){
                        successtoast('Data sudah terhapus')
                        loadListKegiatan(tahun,bulan)
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }

   $('#tanggal_kegiatan').change(function(){ 
            var tanggal=$(this).val();
            var date = new Date(tanggal);

            var bulan = date.getMonth()+1;
            var tahun = date.getFullYear();
         
           
                $.ajax({
                    url : "<?php echo site_url('kinerja/C_Kinerja/getRencanaKerja');?>",
                    method : "POST",
                    data : {tahun: tahun, bulan:bulan},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                         
                     
                        var i;
                        var html = '<option>- Pilih Tugas Jabatan -</option>';
                        for(i=0; i<data.length; i++){
                       
                            html += '<option value='+data[i].id+'>'+data[i].tugas_jabatan+'</option>';
                        }
                        $('#tugas_jabatan').html(html);
 
                    }
                });
                return false;
            }); 

            $('#bulan').on('change', function(){
                       searchListKegiatan()
                 })

              $('#tahun').on('change', function(){
                 searchListKegiatan()
            })

    function searchListKegiatan(){
        if($('#bulan').val() == '')  
        {  
        errortoast(" Pilih Bulan terlebih dahulu");  
        return false
        } 
        var tahun = $('#tahun').val(); 
        var bulan = $('#bulan').val();
        $('#list_kegiatan').html(' ')
        $('#list_kegiatan').append(divLoaderNavy)
        $('#list_kegiatan').load('<?=base_url('kinerja/C_Kinerja/loadKegiatan/')?>'+tahun+'/'+bulan+'', function(){
            $('#loader').hide()
           
        })
    }

    $('.datepicker').datepicker({
    format: 'yyyy',
    startView: "years", 
    orientation: 'bottom',
    autoclose: true,
    todayBtn: true,
    viewMode: "years",
    minViewMode: "years"
});
        
    </script>
<script>
    $('#table_realisasi_kinerja').DataTable({
    "ordering": false
     } );
    
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    })
</script>