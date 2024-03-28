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
  <?php $bobot = null; $no = 1; foreach($sub_unsur as $su){ ?>
    <?php if($su['id_m_unsur_penilaian'] == 1) { ?>
    <a class="list-group-item list-group-item-action" style="background-color:#d5dce4;"><b>A.<?=$no;?>&nbsp;<?=$su['nm_sub_unsur_penilaian'];?></a>
    <a class="list-group-item list-group-item-action">
    <?php $no++;?>
    <div class="table-responsive">
    <table class="table table-hover table-striped table-bordered" style="width:100%;">
    <thead >
                <th class="text-center">No</th>
                <th style="width:50%;">Indikator</th>
                <th style="width:25%;">Bobot</th>
                <th style="width:25%;"></th>
            </thead>
            <tbody>
                <?php $nomor = 1;  foreach($result as $rs){ ?>
                 
                     <?php if($su['id'] == $rs['id_sub_unsur_penilaian']) { ?>
                      <?php $bobot += $rs['bobot'];?>
                    <tr>
                    <td align="center"><?=$nomor++;?></td>
                        <td><?=$rs['nm_indikator'];?></td>
                        <td><?=$rs['bobot'];?>%</td>
                        <td>
                        <button 
                        data-toggle="modal" 
                        data-id="<?=$rs['id']?>"
                        data-nm_indikator="<?=$rs['nm_indikator']?>"
                        data-nm_indikator="<?=$rs['nm_indikator']?>"
                        data-kode="1"
                        href="#modal_detail_indikator"
                        class="open-DetailIndikator btn btn-sm btn-primary"> <i class="fa fa-search"></i> Detail</button>
                        <button 
                        data-toggle="modal" 
                        data-id="<?=$rs['id']?>"
                        data-nm_indikator="<?=$rs['nm_indikator']?>"
                        data-nm_indikator="<?=$rs['nm_indikator']?>"
                        data-kode="2"
                        href="#modal_detail_indikator"
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
    <?php } ?>
    <?php } ?>
  
  <span style="margin-left:0px;">Total Bobot = <?= $bobot;?></span>
  
  <a class="list-group-item list-group-item-action active" aria-current="true">
  B. Unsur Penilaian Potensial
  </a>
  <?php $bobot = null; $no = 1; foreach($sub_unsur as $su){ ?>
    
    <?php if($su['id_m_unsur_penilaian'] == 2) { ?>
       
    <a class="list-group-item list-group-item-action" style="background-color:#d5dce4;"><b>B.<?=$no;?>&nbsp;<?=$su['nm_sub_unsur_penilaian'];?></b></a>
    <a class="list-group-item list-group-item-action">
    <?php $no++;?>
    <div class="table-responsive">
    <table class="table table-hover table-striped table-bordered " style="width:100%;">
            <thead>
            <th class="text-center">No</th>
                <th style="width:50%;">Indikator</th>
                <th style="width:25%;">Bobot</th>
                <th style="width:25%;"></th>
            </thead>
            <tbody>
                <?php $nomor = 1; foreach($result as $rs){ ?>
                     <?php if($su['id'] == $rs['id_sub_unsur_penilaian']) { ?>
                      <?php $bobot += $rs['bobot'];?>
                    <tr>
                    <td align="center"><?=$nomor++;?></td>
                        <td><?=$rs['nm_indikator'];?></td>
                        <td><?=$rs['bobot'];?>%</td>
                        <td>
                        <button 
                        data-toggle="modal" 
                        data-id="<?=$rs['id']?>"
                        data-nm_indikator="<?=$rs['nm_indikator']?>"
                        data-nm_indikator="<?=$rs['nm_indikator']?>"
                        data-kode="1"
                        href="#modal_detail_indikator"
                        class="open-DetailIndikator btn btn-sm btn-primary"> <i class="fa fa-search"></i> Detail</button>
                        <button 
                        data-toggle="modal" 
                        data-id="<?=$rs['id']?>"
                        data-nm_indikator="<?=$rs['nm_indikator']?>"
                        data-nm_indikator="<?=$rs['nm_indikator']?>"
                        data-kode="2"
                        href="#modal_detail_indikator"
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
    <?php } ?>
    <?php } ?>
    <span style="margin-left:0px;">Total Bobot = <?= $bobot;?></span>

    
  <a class="list-group-item list-group-item-action active" aria-current="true">
  C. Penilaian Kompetensi Teknis Bidang
  </a>
  <?php $bobot = null; $no = 1; foreach($sub_unsur as $su){ ?>
    
    <?php if($su['id_m_unsur_penilaian'] == 3) { ?>
       
    <!-- <a class="list-group-item list-group-item-action" style="background-color:#d5dce4;"><b>B.<?=$no;?>&nbsp;<?=$su['nm_sub_unsur_penilaian'];?></b></a> -->
    <a class="list-group-item list-group-item-action">
    <?php $no++;?>
    <div class="table-responsive">
    <table class="table table-hover table-striped table-bordered " style="width:100%;">
            <thead>
            <th class="text-center">No</th>
                <th style="width:50%;">Indikator</th>
                <th style="width:25%;">Bobot</th>
                <th style="width:25%;"></th>
            </thead>
            <tbody>
                <?php $nomor = 1; foreach($result as $rs){ ?>
                     <?php if($su['id'] == $rs['id_sub_unsur_penilaian']) { ?>
                      <?php $bobot += $rs['bobot'];?>
                    <tr>
                    <td align="center"><?=$nomor++;?></td>
                        <td><?=$rs['nm_indikator'];?></td>
                        <td><?=$rs['bobot'];?>%</td>
                        <td>
                        <button 
                        data-toggle="modal" 
                        data-id="<?=$rs['id']?>"
                        data-nm_indikator="<?=$rs['nm_indikator']?>"
                        data-nm_indikator="<?=$rs['nm_indikator']?>"
                        data-kode="1"
                        href="#modal_detail_indikator"
                        class="open-DetailIndikator btn btn-sm btn-primary"> <i class="fa fa-search"></i> Detail</button>
                        <button 
                        data-toggle="modal" 
                        data-id="<?=$rs['id']?>"
                        data-nm_indikator="<?=$rs['nm_indikator']?>"
                        data-nm_indikator="<?=$rs['nm_indikator']?>"
                        data-kode="2"
                        href="#modal_detail_indikator"
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
    <?php } ?>
    <?php } ?>
    <span style="margin-left:0px;">Total Bobot = <?= $bobot;?></span>

</div>

<!-- modal detail indikator -->
<div class="modal fade" id="modal_detail_indikator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelIndikator" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabelIndikator"><span id="nm_indikator"></span></h3>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div id="list_kriteria">
      
        </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
<!-- tutup modal detail indikator -->


<script>
    $(document).on("click", ".open-DetailIndikator", function () {
    $('#list_kriteria').html('')
    var id = $(this).data('id');
    var kode = $(this).data('kode');
    var nm_indikator = $(this).data('nm_indikator');
    $("#nm_indikator").html( nm_indikator );
    
    if(kode == 1){
    $('#list_kriteria').html('')
    $('#list_kriteria').append(divLoaderNavy)
    $('#list_kriteria').load('<?=base_url("simata/C_Simata/loadKriteriaPenilaian/")?>'+id, function(){
      $('#loader').hide()
    })
    } else {
    $('#list_kriteria').html('')
    $('#list_kriteria').append(divLoaderNavy)
    $('#list_kriteria').load('<?=base_url("simata/C_Simata/loadEditIndikator/")?>'+id, function(){
      $('#loader').hide()
    })
    }

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
                           url: '<?=base_url("simata/C_Simata/deleteData/")?>'+id,
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

</script>
<?php } else { ?>
    <div class="col-12 text-center">
        <h5>DATA TIDAK DITEMUKAN !</h5>
    </div>
<?php } ?>