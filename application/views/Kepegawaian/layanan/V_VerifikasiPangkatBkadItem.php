<div class="card-body table-responsive">
<table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama</th>
          <th class="text-left">Unit Kerja</th>
          <th class="text-center">Tanggal Usul Ke BKAD</th>
          <th class="text-left">Status</th>
          <th class="text-left">Keterangan</th>
          <?php if($this->general_library->isHakAkses('verifikasi_pengajuan_kenaikan_pangkat')) { ?>
            <th class="text-center">Jenis Kenaikan Pangkat</th>
            <th class="text-center"></th>
          <?php } ?>
          <th></th>
          
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr class="text-left">
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"> <?=getNamaPegawaiFull($rs);?><br>
               <span>NIP. <?=$rs['nipbaru_ws']?></span> </td>
              <td class="text-left"><?=$rs['nm_unitkerja']?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tanggal_usul_bkad'])?></td>
              <td class="text-left">
              <span class="badge badge-<?php if($rs['status_pengajuan'] == '3') echo "success"; else if($rs['status_pengajuan'] == '5') echo "danger"; else echo "primary";?>"><?php if($rs['status_pengajuan'] == '3') echo "Usul BKPSDM"; else if($rs['status_pengajuan'] == '4') echo "Diterima"; else if($rs['status_pengajuan'] == '5') echo "ditolak"; ?>
              </span>
            </td>
            <td class="text-left"><?=$rs['keterangan']?></td>
           
          <?php if($this->general_library->isHakAkses('verifikasi_pengajuan_kenaikan_pangkat')) { ?>
            <td class="text-left">
            <?php if($rs['id_m_layanan'] == '6') echo "Kenaikan Pangkat Reguler"; else if($rs['id_m_layanan'] == '7') echo "Kenaikan Pangkat Jabatan Fungsional"; else if($rs['id_m_layanan'] == '8') echo "Kenaikan Pangkat Menduduki Jabatan Struktural"; else echo "3"?>  
            </td>
            <td class="text-center">
            <?php if($rs['status_layanan'] >= 3) { ?>
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
            <?php } ?>
             <td>
             <!-- <a href="<?= base_url();?>kepegawaian/verifikasi-layanan-detail/<?=$rs['id_pengajuan']?>/<?=$rs['id_m_layanan']?>">
                <button  class="btn btn-sm btn-primary">
                Verifikasi</button>
                </a> -->
                <button
                data-id="<?=$rs['id_pengajuan'];?>" 
                id="btn_verifikasi" type="button" class="btn btn-sm btn-primary ml-2" data-toggle="modal" data-target="#modelVerifBkad">
                Verifikasi
                </button>
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
<div class="modal fade" id="modelVerifBkad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verifikasi Layanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="form_verifikasi_layanan" enctype="multipart/form-data" >
        <input type="hidden" name="id_pengajuan" id="id_pengajuan">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Status</label>
        <select class="form-select" aria-label="Default select example" name="status" id="status">
        <option selected>--</option>
        <option value="4">ACC</option>
        <option value="5">TOLAK</option>
        <!-- <option value="3">TMS</option> -->
      </select>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Catatan</label>
        <textarea class="form-control customTextarea" name="keterangan" id="keterangan" rows="3" required></textarea>
      </div>
    
      <button id="btn_verif" class="btn btn-primary" style="float: right;">Simpan</button>
    </form>
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


$('#modelVerifBkad').on('show.bs.modal', function (event) {
    
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
            modal.find('#id_pengajuan').attr("value",div.data('id'));
        });
  

$('#form_verifikasi_layanan').on('submit', function(e){
          var status = $('#status').val()
          var catatan = $('#keterangan').val()
          if(status == "--"){
            errortoast('Silahkan Pilih Status')
            return false;
           }

          //  if(status == "2"){
           if(catatan == ""){
            errortoast('Silahkan mengisi catatan')
            return false;
           }
          //  }


            e.preventDefault()
            $.ajax({
                url: '<?=base_url("kepegawaian/C_Kepegawaian/submitVerifikasiPengajuanLayanan")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(datares){
                  
                  setTimeout(successtoast('Data Berhasil Diverifikasi'), 2000);
                //   setTimeout($('#form_search').submit(), 2000);

                  
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })

        $('#modelVerifBkad').on('hidden.bs.modal', function () {
            $('#form_search').submit()
        });
</script>