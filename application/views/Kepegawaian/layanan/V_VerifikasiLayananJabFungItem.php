<div class="card-body table-responsive">
<table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama</th>
          <th class="text-left">Unit Kerja</th>
          <th class="text-center">Tanggal Pengajuan</th>
          <th class="text-left">Status</th>
          <th class="text-left">Keterangan</th>
          <?php if($this->general_library->isHakAkses('verifikasi_pengajuan_kenaikan_pangkat')) { ?>
            <th class="text-center">Jenis Layanan</th>
            <th class="text-center"></th>
          <?php } ?>
          <th></th>
          <th>Verifikator</th>
          
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr class="text-left">
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"> <?=getNamaPegawaiFull($rs);?><br>
               <span>NIP. <?=$rs['nipbaru_ws']?></span> </td>
              <td class="text-left"><?=$rs['nm_unitkerja']?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tanggal_pengajuan'])?></td>
              <td class="text-left">
              <span class="badge badge-primary"><?php echo $rs['status_verif']  ?>
              </span>
            </td>
            <td class="text-left">
              <?php if($rs['status_layanan'] < 4 ) echo $rs['ket_layanan']; else echo $rs['keterangan'];?></td>
           
            <td class="text-left">
            <?php if($rs['id_m_layanan'] == '12') echo "Kenaikan Jabatan Fungsional"; else if($rs['id_m_layanan'] == '13') echo "Perpindahan Dari Jabatan Lain"; else if($rs['id_m_layanan'] == '14') echo "Penyesuaian/Inpassing"; else if($rs['id_m_layanan'] == '15') echo "Pemberhentian dari Jabatan Fungsional Atas Permintaan Sendiri"; else  echo "Pengangkatan Kembali"?>  
            </td>
            <td class="text-center">
            <?php if($rs['status_layanan'] == 1 || $rs['status_layanan'] == 3 || $rs['status_layanan'] == 4 || $rs['status_layanan'] == 5) { ?>
              <?php if($rs['reference_id_dok'] != null) { ?>
                <button href="#modal_view_file" onclick="openFilePangkat('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                <i class="fa fa-file-pdf"></i></button>
                <?php } else { ?>
                  <!-- <button 
                data-toggle="modal" 
                data-id="<?=$rs['id_pengajuan']?>"
                href="#modal_upload_sk"
                onclick="loadModalUploadSK('<?=$rs['id_pengajuan']?>','<?=$rs['id_m_layanan']?>')" title="Ubah Data" class="btn btn-sm btn-primary"> 
                <i class="fa fa-upload" aria-hidden="true"></i></button> -->
                <?php } ?>
            <?php } ?>
              </td>
             <td>

             <!-- <a id="btn_tolak_verifikasi" onclick="kerjakanBerkas('<?=$rs['id_pengajuan']?>','<?=$rs['id_m_layanan']?>')" type="button" class="btn btn-sm btn-primary ml-2">
             Verifikasi
                </a> -->
             <a href="<?= base_url();?>kepegawaian/verifikasi-layanan-detail/<?=$rs['id_pengajuan']?>/<?=$rs['id_m_layanan']?>">
                <button  class="btn btn-sm btn-primary">
                Verifikasi</button>
                </a>
             </td>
              <td>
              <?=$rs['verifikator']?> 
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
</div>
<div class="modal fade" id="modal_detail_cuti" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div id="modal-dialog" class="modal-dialog modal-xl">
		<div class="modal-content" id="content_modal_detail_cuti">
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_upload_sk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        ...
      </div>
     
    </div>
  </div>
</div>


<div class="modal fade" id="modal_view_file" >
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
           <div id="modal_view_file_content">
            <h5  class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file"  frameborder="0" ></iframe>	

          </div>
        </div>
      </div>
    </div>
</div>

<script>
  $(function(){
    $('.datatable').dataTable()
  })

  function loadDetailCutiVerif(id){
    $('#result_search').html('')
    $('#result_search').append(divLoaderNavy)
    $('#result_search').load('<?=base_url('kepegawaian/C_Kepegawaian/loadDetailCutiVerif/')?>'+id, function(){
      $('#loader').hide()
    })
  }


  function loadModalUploadSK(id,id_m_layanan){
  $('#modal_body').html('')
  $('#modal_body').append(divLoaderNavy)
  $('#modal_body').load('<?=base_url("kepegawaian/C_Kepegawaian/loadModalUploadSK")?>'+'/'+id+'/'+id_m_layanan, function(){
    $('#loader').hide()
  })
  }

async function openFilePangkat(filename){

$('#iframe_view_file').hide()
$('.iframe_loader').show()  

var number = Math.floor(Math.random() * 2000);
$link = "<?=base_url();?>/arsipelektronik/"+filename+"?v="+number;

$('#iframe_view_file').attr('src', $link)
$('#iframe_view_file').on('load', function(){
  $('.iframe_loader').hide()
  $(this).show()
})
}


function kerjakanBerkas(id_usul){
          
          if(confirm('Kerjakan pengajuan layanan pangkat ini ?')){
          $.ajax({
              url: '<?=base_url("kepegawaian/C_Kepegawaian/batalVerifikasiPengajuanLayanan")?>',
              method: 'post',
              // data: $(this).serialize(),
              data: {
              id_batal: id_usul
          },
              success: function(data){
               
              }, error: function(e){
                  errortoast('Terjadi Kesalahan')
              }
          })

          
        }
}
  
</script>