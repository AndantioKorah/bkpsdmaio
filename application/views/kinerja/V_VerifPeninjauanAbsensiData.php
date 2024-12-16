<?php if($result){ ?>



    <div class="table-responsive">
    <table border=1 class="table table-hover" id="table_list_peninjauan">
        <thead>
            <th class="text-center">No</th>
            <th class="text-left">Pegawai</th>
            <!-- <th class="text-left">Foto Pegawai</th> -->
            <th class="text-left">Unit Kerja</th>
            <th class="text-center">Tanggal Absensi</th>
            <th class="text-center">Jenis Absensi</th>
            <th class="text-center">Jenis Bukti Absensi</th>
            <th class="text-center">Teman Absensi</th>
            <th class="text-center">Dokumen</th>
            <th class="text-center">Keterangan Verif</th>
            <th></th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $r){
               $nama_peg = getNamaPegawaiFull($r);
                ?>
                <tr id="tr_<?=$r['id']?>" style="<?php if($status == 0) { if($r['total_diverif'] >= 5) echo 'background-color:#f0a095'; }?>">
                    <td class="text-center"><?=$no?></td>
                    <td class="text-left">
                    <a target="_blank" href="<?= base_url('kepegawaian/profil-pegawai/')?><?=$r['nipbaru'];?>" style="color:#495057"><?=getNamaPegawaiFull($r).'<br>NIP. '.$r['nipbaru']?></a></td>
                   <!-- <td class="text-left">
                    <img onclick="loadFotoPeg('<?=$r['fotopeg']?>')" data-toggle="modal" data-target="#exampleModal" style="height:80px;width:50px" src="<?=base_url('assets/fotopeg/')?><?=$r['fotopeg'];?>" alt="">
                   </td> -->
                    <td class="text-left"><?=($r['nm_unitkerja'])?> </td>
                    <?php
                        // $bulan = $r['bulan'] < 10 ? '0'.$r['bulan'] : $r['bulan'];
                        // $tanggal = $r['tanggal'] < 10 ? '0'.$r['tanggal'] : $r['tanggal'];
                    ?>
                  
                    <td class="text-center"><?= formatDateNamaBulan($r['tanggal_absensi'])?></td>
                    <td class="text-left">
                          <?php if($r['jenis_absensi'] == 1) echo "Absen Pagi"; else echo "Absen Sore";?>
                        </td>
                        <td class="text-left">
                          <?php if($r['jenis_bukti'] == 1) echo "Foto Bersama Teman"; else echo "Screenshot Whatsapp";?>
                        </td>
                        <td class="text-left">
                        <a target="_blank" href="<?= base_url('kepegawaian/profil-pegawai/')?><?=$r['teman_nip'];?>" style="color:#495057"><?=$r['teman_gelar1']?><?=$r['teman_nama']?><?=$r['teman_gelar2']?></a></td>

                    <td class="text-center">  
                    <?php 
                            $file = json_decode($r['bukti_kegiatan']);
                            $nodok = 1;
                            $tanggal = new DateTime($r['tanggal_absensi']);
                            $tahun = $tanggal->format("Y");
                            $bulan = $tanggal->format("m");
                            $file_name =$file[0];
                            ?>
                        <button 
                        data-id="<?=$r['id'];?>" 
                        data-jenis_bukti="<?=$r['jenis_bukti'];?>" 
                        data-jenis_absen="<?=$r['jenis_absensi'];?>" 
                        data-nama="<?=$nama_peg;?>" 
                        data-tgl_absen="<?=formatDateNamaBulan($r['tanggal_absensi']);?>" 
                        data-nip="<?=$r['nipbaru'];?>" 
                        data-fotopeg="<?=$r['fotopeg'];?>" 
                        data-bulan="<?=$bulan;?>" 
                        data-tahun="<?=$tahun;?>"  
                        data-gambar="<?=$file_name;?>" 
                        data-toggle="modal" 
                        data-target="#exampleModalb"
                        class="btn btn-info btn-sm " type="button" id="dropdownMenuButton"  aria-haspopup="true" aria-expanded="false"><i class="fa fa-file"></i> Dokumen</button>

                             <!-- <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-file"></i> Dokumen
                            </button> -->
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php 
                            
                            $file = json_decode($r['bukti_kegiatan']);
                            $nodok = 1;
                            $tanggal = new DateTime($r['tanggal_absensi']);
                            $tahun = $tanggal->format("Y");
                            $bulan = $tanggal->format("m");
                            if($file) {
                            foreach($file as $file_name)
                                {
                                  $data = $file_name;    
                                  // $ekstension = substr($data, strpos($data, ".") + 1); 
                                  $ekstension = pathinfo($data, PATHINFO_EXTENSION);
                                  
                                    if($file_name == null){
                                        echo "<a class='dropdown-item' >Tidak Ada File</a>";
                                    } else {
                                      if($ekstension == "png" || $ekstension == "jpg" || $ekstension == "jpeg"){
                                        // echo "<a class='dropdown-item' href=".base_url('assets/peninjauan_absen/'.$tahun.'/'.$bulan.'/'.$file_name.'')." target='_blank'>Dokumen ".$nodok."</a>";
                                        echo "<a class='dropdown-item'   href='javascript:;' data-id='".$r['id']."' data-jenis_bukti='".$r['jenis_bukti']."' data-jenis_absen='".$r['jenis_absensi']."' data-nama='".$nama_peg."' data-tgl_absen='".formatDateNamaBulan($r['tanggal_absensi'])."' data-nip='".$r['nipbaru']."' data-fotopeg='".$r['fotopeg']."' data-bulan='".$bulan."' data-tahun='".$tahun."'  data-gambar='".$file_name."' data-toggle='modal' data-target='#exampleModalb'>Dokumen ".$nodok."</a>";

                                      } else {
                                        echo "<a class='dropdown-item' href=".base_url('assets/peninjauan_absen/'.$tahun.'/'.$bulan.'/'.$file_name.'')." target='_blank'>Dokumen ".$nodok."</a>";
                                        // echo "<a class='dropdown-item'  href='javascript:;' data-id='".$r['id']."'  data-gambar='".$file_name."' data-toggle='modal' data-target='#edit-data'>Dokumen ".$nodok."</a>";
                                      }
                                    }
                                   $nodok++;
                                } 
                              } else {
                                echo "<a class='dropdown-item' >Tidak Ada File</a>";
                              }
                            ?>
   
                        </div>
                           
                        </td>
                    <td>
                        <?php if($status == 1 || $status == 2){ ?>
                            <span><strong><?=$r['keterangan_verif']?></strong></span><br>
                            <input type="hidden" class="form-control" id="id_user_<?=$r['id']?>" value="<?=$r['id_m_user']?>"/>
                            
                            <!-- <span style="font-size: 14px;"><?='(oleh '.$r['nama_verif'].' pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span> -->
                            <span style="font-size: 14px;"><?='(pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span>
                        <?php } else if($status == 0) { ?> 
                            
                            <input class="form-control" id="ket_verif_<?=$r['id']?>" />
                            <?php if($r['jenis_bukti'] == 2) { ?>
                            <input type="time" class="form-control" id="jam_<?=$r['id']?>"/>
                            <?php } ?>

                            <input type="hidden" class="form-control" id="jenis_bukti_<?=$r['id']?>" value="<?=$r['jenis_bukti']?>"/>
                            <input type="hidden" class="form-control" id="teman_absensi_<?=$r['id']?>" value="<?=$r['teman_absensi']?>"/>
                            <input type="hidden" class="form-control" id="tanggal_absensi_<?=$r['id']?>" value="<?=$r['tanggal_absensi']?>"/>
                            <input type="hidden" class="form-control" id="id_user_<?=$r['id']?>" value="<?=$r['id_m_user']?>"/>
                            <input type="hidden" class="form-control" id="jenis_absensi_<?=$r['id']?>" value="<?=$r['jenis_absensi']?>"/>
                       
                            <?php } else if($status == 3){ ?>
                            <input type="hidden" class="form-control" id="id_user_<?=$r['id']?>" value="<?=$r['id_m_user']?>"/>
                            <input class="form-control" id="ket_verif_<?=$r['id']?>" />
                            <?php if($r['jenis_bukti'] == 2) { ?>
                            <input type="time" class="form-control" id="jam_<?=$r['id']?>" />
                            <?php } ?>
                            
                            <input type="hidden" class="form-control" id="jenis_bukti_<?=$r['id']?>" value="<?=$r['jenis_bukti']?>"/>
                            <input type="hidden" class="form-control" id="teman_absensi_<?=$r['id']?>" value="<?=$r['teman_absensi']?>"/>
                            <input type="hidden" class="form-control" id="tanggal_absensi_<?=$r['id']?>" value="<?=$r['tanggal_absensi']?>"/>
                            <input type="hidden" class="form-control" id="id_user_<?=$r['id']?>" value="<?=$r['id_m_user']?>"/>
                            <input type="hidden" class="form-control" id="jenis_absensi_<?=$r['id']?>" value="<?=$r['jenis_absensi']?>"/>
                            

                            <span style="font-size: 14px;"><?='(DIBATALKAN pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <?php if($r['total_diverif'] < 5) { ?>
                            <button data-list_id='<?=json_encode($r['list_id'])?>' onclick="verifDokumen(1, '<?=$r['id']?>',<?=$status?>,'<?=$r['jenis_bukti']?>')" style="display: <?=$status == 0 || $status == 3 ? 'block' : 'none'?>" class="btn_verif_<?=$r['id']?> btn btn-sm btn-success" title="Terima"><i class="fa fa-check"></i></button>
                            <?php } ?>
                            <button data-list_id='<?=json_encode($r['list_id'])?>' onclick="verifDokumen(2, '<?=$r['id']?>',<?=$status?>,'<?=$r['jenis_bukti']?>')" style="display: <?=$status == 0 || $status == 3 ? 'block' : 'none'?>" class="btn_verif_<?=$r['id']?> btn btn-sm btn-danger" title="Tolak"><i class="fa fa-times"></i></button>
                            <button data-list_id='<?=json_encode($r['list_id'])?>' onclick="verifDokumen(3, '<?=$r['id']?>',<?=$status?>,'<?=$r['jenis_bukti']?>')" style="display: <?=$status == 0 || $status == 3 ? 'none' : 'block'?>" class="btn_batal_<?=$r['id']?> btn btn-sm btn-warning" title="Batal"><i class="fa fa-trash"></i></button>
                            <button disabled style="display: none;" id="btn_loading_<?=$r['id']?>" class="btn btn-sm btn-info"><i class="fa fa-spin fa-spinner"></i></button>
                        </div>
                    </td>
                </tr>
            <?php $no++; } ?>
        </tbody>
    </table>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1"  data-keyboard="false" 
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="col-lg-12 float-right text-right">
    <button type="button" class="btn-close btn-close-modal-announcement btn-light" style="width: 50px; height: 50px; background-color: white;" data-dismiss="modal"><i class="fa fa-3x fa-times"></i></button>
  </div>
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div id="modal-announcement-content">
        <div class="col-lg-12" style="margin: auto;">
  <center>

    <img id="pegawai_image" style="max-height: 75vh; max-width: 90vw;"  />
  </center>
</div>
        <!-- <img  data-toggle="modal" data-target="#exampleModal" style="height:80px;width:50px" src="<?=base_url('assets/fotopeg/199401042020121011_profile_pict_241120100015_PhotoRoom-20231103_1254142.png')?>" alt=""> -->
            
        </div>
    </div>
  </div>

  <!-- Modal -->
   <style>
    .modal-ku {
  width: 1200px;
  /* margin: auto; */
}
   </style>
<div  class="modal fade " id="exampleModalb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div style="width:100%;" class="modal-dialog modal-xl" role="document">
    <div class="modal-content " >
      <div class="modal-header " >
        <h4 class="modal-title col-lg-11" id="exampleModalLabel"> 
            <div class="row" >
            <div style="width:65%;"   id="nama_peg"></div>  <div  style="width:35%"   id="input_jam"> </div> 
            </div>
       </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    
      <div class="row">
      <div class="col-lg-4">
        <b >Foto Pegawai</b>
        <img  id="foto_pegawai" class="mt-3" style="width:375px;height:510px;"  alt="">
      </div>
      <div class="col-lg-8">
      <style>
    .popup figure {
  width: 100%;
  height: 510px;
  overflow: hidden;
}

.popup img {
  width: 200px;
  height: 200px;
  cursor: pointer;
  overflow: scroll;
}

.btnZoom {
  /* z-index: 99999; */
  cursor: pointer;
  font-size: 14px;
  /* font-weight: 200; */
  background: #222e3c;
  padding: 5px;
  text-align: center;
  border-radius: 5px;
  color:#fff;
  margin-top:-13px;
  margin-bottom:-10px;

}
</style>
      <b class="mb-2">Bukti Peninjauan </b>
      <button class="btn btn-sm btnZoom plus" title="ZoomIn"> <i class="fas fa-search-plus"></i></button>
      <button class="btn btn-sm btnZoom minus" title="ZoomOut"><i class="fas fa-search-minus"></i></button>
      <button class="btn btn-sm btnZoom reset" title="Reset"><i class="fa fa-sync"></i></button> 


<div class="popup mt-3">
    
    <figure>
      <img id="bukti_absen" class="workspace"        alt="">
    </figure>
  </div>
      </div>
     



  <script>
    $(function () {
  $(".plus").on("click", function () {
    const ximg = $(this).parent().find("figure img").width();
    let img_widht = $(this).parent().find("figure img").width();
    let new_widht = img_widht + 50;
    $(this).parent().find("figure img").width(new_widht);
    $(this).parent().find("figure img").height("auto");
  });
  $(".minus").on("click", function () {
    let img_widht = $(this).parent().find("figure img").width();
    let new_widht = img_widht - 50;
    if (new_widht < 200) {
      new_widht = 200;
    }
    $(this).parent().find("figure img").width(new_widht);
    $(this).parent().find("figure img").height("auto");
  });

  $(".reset").on("click", function () {

    var myImg = document.querySelector("#bukti_absen");
    var realWidth = myImg.naturalWidth;

    // $(this).parent().find("figure img").width(ximg);
    // $(this).parent().find("figure img").height("auto");

    $(this).parent().find("figure img").css({
      width: "auto",
      height: "100%",
      top: "0",
      left: "0"
    });
  });

  // let ovrflow_width
  $("figure img").each(function () {
    $(this).draggable({
      scroll: true,
      stop: function () {},
      drag: function (e, ui) {
        let popup_img_width = $(this).width();
        let popup_width = $(this).parent("figure").width();
        // let new_img_width = popup_width - popup_img_width;
        let new_img_width = "100%";

        let popup_img_height = $(this).height();
        let popup_height = $(this).parent("figure").height();
        // let new_img_height = popup_height - popup_img_height;
        let new_img_height = "100%";

        if (ui.position.left > 0) {
          ui.position.left = 0;
        }
        if (ui.position.left < new_img_width) {
          ui.position.left = new_img_width;
        }

        if (ui.position.top > 0) {
          ui.position.top = 0;
        }
        if (ui.position.top < new_img_height) {
          ui.position.top = new_img_height;
        }
      }
    });
  });
});


  </script>

      
        </div>

      </div>
    </div>
  </div>
</div>


<?php } else { ?>
    <div class="col-12 text-center">
        <h6>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h6>
    </div>
<?php } ?>
<script>
    $(function(){
        var table = $('#table_list_peninjauan').DataTable({
                columnDefs: [
                {
                    targets: 2,
                    className: 'zoom'
                }
                ]
            });
       
            // sidebar
        // $("#sidebar").hide();
        // $(".sidebar-content").hide();
        // $("#sidebar_toggle" ).trigger( "click" );
        $('#table_list_peninjauan').dataTable()
    })

    function verifDokumen(status, id, tab,jenis_absen){

        if(jenis_absen == 2){
            if(status == 1){
           if($('#jam_'+id).val() == "" || $('#jam_'+id).val() == null){
            errortoast('Jam belum diisi')
            return false;
           }
        }

           
        }

        $('.btn_verif_'+id).hide()
        $('#btn_loading_'+id).show()
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/verifPeninjauanAbsensi/")?>'+'/'+id+'/'+status,
            method: 'post',
            data: {
                list_id : $('.btn_verif_'+id).data('list_id'),
                keterangan: $('#ket_verif_'+id).val(),
                jenis_bukti: $('#jenis_bukti_'+id).val(),
                teman_absensi: $('#teman_absensi_'+id).val(),
                tanggal_absensi: $('#tanggal_absensi_'+id).val(),
                jenis_absensi: $('#jenis_absensi_'+id).val(),
                jam_absen : $('#jam_'+id).val(),
                id_user: $('#id_user_'+id).val()
            },
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    // successtoast('Data Berhasil Diverifikasi')
                    // openListData(active_status)
                    // $('#count_pengajuan').html(rs.data.pengajuan)
                    // $('#count_diterima').html(rs.data.diterima)
                    // $('#count_ditolak').html(rs.data.ditolak)
                    // $('#count_batal').html(rs.data.batal)
                    // $('#tr_'+id).hide();
                    console.log(tab)
                    if(tab == 0){
                        // openListData(0)
                        $('#tr_'+id).hide();
                    } else if(tab == 3) {
                        openListData(3)
                    } else {
                        $('#tr_'+id).hide();
                    }
             
                    // 
                } else {
                    errortoast(rs.message)
                }
                $('.btn_verif_'+id).show()
                $('#btn_loading_'+id).hide()
            }, error: function(e){
                $('.btn_verif_'+id).show()
                $('#btn_loading_'+id).hide()
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    function loadFotoPeg(src){
        // alert(src)
            // $('#modal-announcement-content').html('')
            // $('#modal-announcement-content').append(divLoaderNavy)
            // $('#modal-announcement-content').load('<?=base_url('master/C_Master/loadAnnouncement/')?>'+id)
            imgsrc = "<?=base_url('assets/fotopeg/')?>"+src;
            $('#pegawai_image').attr('src',imgsrc);
        }

        $('#exampleModalb').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal          = $(this)

            if(div.data('jenis_absen') == 1){
                var jenis_absen = "Pagi"
            } else {
                var jenis_absen = "Sore"
            }
            $('#nama_peg').html('');
            $('#input_jam').html('');
            modal.find("figure img").css({
                  width: "auto",
                  height: "510px",
                  top: "0",
                  left: "0"
                });

            modal.find('#nma_peg').html(div.data('nama'));
            modal.find('#id').attr("value",div.data('id'));
            modal.find('#foto_pegawai').attr("src","<?=base_url('assets/fotopeg/')?>"+div.data('fotopeg'));
            modal.find('#bukti_absen').attr("src","<?=base_url('assets/peninjauan_absen/')?>"+div.data('tahun')+'/'+div.data('bulan')+'/'+div.data('gambar'));
           
            $('#nama_peg').append('<a href="<?= base_url()?>kepegawaian/profil-pegawai/'+div.data('nip')+'" target="_blank"><span class="badge badge-pns">'+div.data('nama')+'</span></a> Absen '+jenis_absen+' Tanggal '+div.data('tgl_absen'));
            if(div.data('jenis_bukti') == 2){

            // $('#input_jam').append('<input type="time" onchange="myFunction('+div.data('id')+')" style="width:30%" class="form-control col-lg-4" id="verifjam_'+div.data('id')+'"/> ');
            $('#input_jam').append('<div style="width:65%" class="input-group col-lg-2">'+
            '<input type="time" onchange="myFunction('+div.data('id')+')" style="width:30%" class="form-control col-lg-4" id="verifjam_'+div.data('id')+'"/>'+
                '<div class="input-group-append">'+
                '<span class="input-group-text">Input Jam</span>'+
            '</div>'+
            '</div>');
        }
            
        });

       
        


        function myFunction(id) {
            var verif_jam = $('#verifjam_'+id).val();
            $('#jam_'+id).val(verif_jam);
            }
</script>

