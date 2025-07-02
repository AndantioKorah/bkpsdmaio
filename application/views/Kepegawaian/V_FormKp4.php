

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }

    input[readonly] {
    background-color:rgb(223, 223, 223);
    }
</style>
<?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modaltambahkp4">
Data KP4
</button>

<!-- status pdm -->
<?php  if($this->general_library->isProgrammer() != true  && $this->general_library->isAdminAplikasi() != true){ ?>

<?php }  ?>
<?php }  ?>

<script>
    function openModalStatusPmd(jenisberkas){
        $(".modal-body #jenis_berkas").val( jenisberkas );
  }
</script>


<!-- <style>
  .modal:nth-of-type(even) {
    z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1051 !important;
}
   
</style> -->
<div class="modal fade" id="myModalArsip">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_arsip_lainnya"></div>
        </div>
       
      </div>
    </div>
</div>


<div class="modal fade" id="modal_view_file_arsip" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file_arsip"  frameborder="0" ></iframe>
     
          </div>
        </div>
      </div>
    </div>
</div>
         


<!-- Modal -->
<div class="modal fade" id="modaltambahkp4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data KP4</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    <form method="post" id="upload_form_kp4" enctype="multipart/form-data" >
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $kp4['id_peg']?>">
    <center><b>Data Pegawai</b></center>
    <hr style="margin-top:-1px;height:2px;border-width:1px;color:#000;background-color:#000">
    <div class="form-group">
    <label>Nama Lengkap</label>
      <input readonly  class="form-control " value="<?=getNamaPegawaiFull($kp4)?>" autocomplete="off"   id="kp4_nama_lengkap" name="kp4_nama_lengkap"  required/>
    </div>
    <div class="form-group">
    <label>NIP</label>
      <input readonly  class="form-control" value="<?=formatNip($kp4['nipbaru_ws'])?>" autocomplete="off"   id="kp4_nip" name="kp4_nip"  required/>
    </div>
    <div class="form-group">
    <label>Pangkat Gol/Ruang</label>
      <input readonly  class="form-control " autocomplete="off" value="<?= $kp4['nm_pangkat'];?>"   id="kp4_pangkat_gol" name="kp4_pangkat_gol"  required/>
    </div>
    <div class="form-group">
    <label>TMT Gol/Ruang</label>
      <input  readonly class="form-control" autocomplete="off" value="<?=formatDateNamaBulan($kp4['tmtpangkat']);?>"   id="kp4_tmt_pangkat_gol" name="kp4_tmt_pangkat_gol"  required/>
    </div>
    <div class="form-group">
    <label>Tempat / Tanggal lahir </label>
      <input readonly  class="form-control " autocomplete="off" value="<?=($kp4['tptlahir'].', '.formatDateNamaBulan($kp4['tgllahir']))?>"   id="kp4_ttl" name="kp4_ttl"  required/>
    </div>
    <div class="form-group">
    <label>Jenis Kelamin</label>
      <input readonly  class="form-control " autocomplete="off" value="<?=$kp4['jk'];?>"   id="kp4_jk" name="kp4_jk"  required/>
    </div>
    <div class="form-group">
    <label>Agama</label>
      <input readonly  class="form-control " autocomplete="off" value="<?=$kp4['nm_agama'];?>"   id="kp4_agama" name="kp4_agama"  required/>
    </div>
    <div class="form-group">
    <label>Alamat Lengkap</label>
      <input readonly  class="form-control " autocomplete="off" value="<?php if($kp4['nama_kelurahan']) { ?>Sulawesi Utara, <?=$kp4['nama_kabupaten_kota']?>, Kec. <?=$kp4['nama_kecamatan']?>, Kel. <?=$kp4['nama_kelurahan']?><?php } ?>"   id="kp4_alamat" name="kp4_alamat"  required/>
    </div>
    <div class="form-group">
    <label>TMT Pegawai</label>
      <input readonly  class="form-control " autocomplete="off" value="<?=formatDateNamaBulan($kp4['tmtcpns'])?>"   id="kp4_tmt_pegawai" name="kp4_tmt_pegawai"  required/>
    </div>
    <div class="form-group">
    <label>Jenis Kepegawaian</label>
      <input readonly class="form-control" autocomplete="off" value="<?=$kp4['nm_jenispeg'];?>"   id="kp4_jenis_kepeg" name="kp4_jenis_kepeg"  required/>
    </div>
     <div class="form-group">
    <label>Status Kepegawaian</label>
      <input readonly class="form-control" autocomplete="off" value="<?=$kp4['nm_statuspeg'];?>"   id="kp4_status_kepeg" name="kp4_status_kepeg"  required/>
    </div> 
    <div class="form-group">
    <label>Jabatan</label>
      <input readonly class="form-control" autocomplete="off" value="<?=$kp4['nama_jabatan'];?>"   id="kp4_jabatan" name="kp4_jabatan"  required/>
    </div> 
    <div class="form-group">
    <label>Jumlah Keluarga Tertanggung</label>
      <input  class="form-control" autocomplete="off"  value="<?=$kp4['jumlah_kel_tertanggung'];?>" id="kp4_jumlah_kel_tertanggung" name="kp4_jumlah_kel_tertanggung"  />
    </div> 
    <div class="form-group">
    <label>Sumber Gaji</label>
      <input  class="form-control" autocomplete="off" value="<?=$kp4['sumber_gaji'];?>"   id="kp4_sumber_gaji" name="kp4_sumber_gaji" value="Peraturan Pemerintah (PP) Nomor 5 Tahun 2024" />
    </div> 
    <div class="form-group">
    <label>Besarnya Penghasilan</label>
      <input  class="form-control" autocomplete="off" value="<?=$kp4['total_penghasilan'];?>"   id="kp4_total_penghasilan" name="kp4_total_penghasilan"  />
    </div> 
    <div class="form-group">
    <label>Gaji Pokok</label>
      <input  class="form-control" autocomplete="off" value="<?=$kp4['gaji_pokok'];?>"   id="kp4_gaji_pokok" name="kp4_gaji_pokok"  />
    </div> 
     <div class="form-group">
    <label>SK Terakhir yang dimiliki</label>
      <input  class="form-control" autocomplete="off" value="<?=$kp4['sk_terakhir'];?>"   id="kp4_sk_terakhir" name="kp4_sk_terakhir"  />
    </div> 
    <div class="form-group">
    <label>Masa Kerja Golongan</label>
      <input readonly class="form-control" autocomplete="off" value="<?=countDiffDateLengkap(date('Y-m-d'), $kp4['tmtpangkat'], ['tahun', 'bulan'])?>"   id="kp4_masa_kerja_gol" name="kp4_masa_kerja_gol"  required/>
    </div>
    <div class="form-group mb-4">
    <label>Masa Kerja  Keseluruhan</label>
      <input readonly class="form-control" autocomplete="off" value="<?=countDiffDateLengkap(date('Y-m-d'), $kp4['tmtcpns'], ['tahun', 'bulan'])?>"   id="kp4_masa_kerja_seluruh" name="kp4_masa_kerja_seluruh"  required/>
    </div>
    <center><b>Kawin Sah dengan <?php if($kp4['jk'] == "Laki-laki" || $kp4['jk'] == "Laki-Laki") echo "Istri"; else echo "Suami"; ?></b></center>
    <hr style="margin-top:-1px;height:1px;border-width:2px;color:#000;background-color:#000">
    <?php if($kp4['status'] == 1) { ?>
    <?php if($pasangan) { ?>
    <input readonly  type="hidden" class="form-control" autocomplete="off"  value="<?=$pasangan[0]['id'];?>"  id="kp4_id_pasangan" name="kp4_id_pasangan"  required readonly/>

   <div class="form-group">
    <label>Nama <?php if($kp4['jk'] == "Laki-laki" || $kp4['jk'] == "Laki-Laki") echo "Istri"; else echo "Suami"; ?></label>
    <input readonly  class="form-control" autocomplete="off"  value="<?=$pasangan[0]['namakel'];?>"  id="kp4_nama_pasangan" name="kp4_nama_pasangan"  required readonly/>
    </div> 
    <div class="form-group">
    <label>Tempat Lahir</label>
      <input readonly  class="form-control" autocomplete="off" value="<?=$pasangan[0]['tptlahir'];?>"   id="kp4_tempat_lahir_pasangan" name="kp4_tempat_lahir_pasangan"  required/>
    </div>
    <div class="form-group">
    <label>Tanggal Lahir</label>
      <input readonly class="form-control" autocomplete="off" value="<?=($pasangan[0]['tgllahir']);?>"    id="kpt_tgl_lahir_pasangan" name="kpt_tgl_lahir_pasangan"  required/>
    </div>    
    <div class="form-group">
    <label>NIP/NII</label>
      <input  class="form-control" value="<?=$kp4['nip_nii'];?>" autocomplete="off"   id="kp4_nip_pasangan" name="kp4_nip_pasangan"  />
    </div> 
    <div class="form-group">
    <label>Pekerjaan</label>
      <input readonly class="form-control" autocomplete="off"  value="<?=$pasangan[0]['pekerjaan'];?>"   id="kp4_pekerjaan_pasangan" name="kp4_pekerjaan_pasangan"  required/>
    </div> 
    <div class="form-group">
    <label>Tanggal Kawin</label>
      <input readonly class="form-control" autocomplete="off"  value="<?=($pasangan[0]['tglnikah']);?>"   id="kp4_tanggal_kawin" name="kp4_tanggal_kawin"  required/>
    </div> 
    <div class="form-group">
    <label><?php if($kp4['jk'] == "Laki-laki" || $kp4['jk'] == "Laki-Laki") echo "Istri"; else echo "Suami"; ?> Ke</label>
      <input readonly class="form-control" autocomplete="off" value="<?=$pasangan[0]['pasangan_ke'];?>"    id="kp4_pasangan_ke" name="kp4_pasangan_ke"  required/>
    </div>
     <div class="form-group">
    <label>Penghasilan</label>
      <input  class="form-control" autocomplete="off" value="<?=$pasangan[0]['penghasilan'];?>" id="kp4_pasangan_penghasilan" name="kp4_pasangan_penghasilan"  required/>
    </div>
    <?php } else { ?>
    <p>Tidak ada data Pasangan, Silahkan Input data Pasangan pada tab Keluarga jika sudah mempunyai pasangan</p>
    <?php } ?>
    <?php } ?>
    <center><b>Anak – anak yang menjadi tanggungan </b></center>
    <hr style="margin-top:-1px;height:1px;border-width:2px;color:#000;background-color:#000">
   <?php $no = 1; if($anak) { foreach($anak as $r) { ?>
    <input type="hidden" name="id_anak[]" class="ank"  value="<?=$r['id']?>" />
    <b><?=$no++;?>. <hr style="margin-top:-3px;border-width:2px;"></b> 
   <div class="form-group">
    <label>Nama Anak</label>
    <input readonly class="form-control" value="<?=$r['namakel'];?>" autocomplete="off"   id="kp4_nama_anak_<?=$r['id']?>" name="kp4_nama_anak_<?=$r['id']?>"  required/>
    </div> 

    <div class="form-group">
    <label>Tempat Lahir</label>
    <input readonly  class="form-control" value="<?=$r['tptlahir'];?>" autocomplete="off"    id="kp4_tpt_lahir_anak" name="kp4_tpt_lahir_anak"  required/>
    </div> 
   <div class="form-group">
    <label>Tanggal Lahir</label>
    <input readonly  class="form-control" value="<?=formatDateNamaBulan($r['tgllahir']);?>" autocomplete="off"    id="kp4_tgl_lahir_anak" name="kp4_tgl_lahir_anak"  required/>
    </div> 
    <div class="form-group">
    <label>Status Anak</label>
    <input readonly  class="form-control" value="<?php if($r['statusanak'] == 1) echo "Anak Kandung"; else echo "Anak Tiri"; ?>" autocomplete="off"    id="kp4_status_anak" name="kp4_status_anak"  required/>
    </div> 
    <div class="form-group">
    <label>Dari <?php if($kp4['jk'] == "Laki-laki" || $kp4['jk'] == "Laki-Laki") echo "Istri"; else echo "Suami"; ?></label>
    <input  class="form-control" value="<?=$r['nama_ortu_anak'];?>" autocomplete="off"    id="kp4_anak_dari_<?=$r['id']?>" name="kp4_anak_dari_<?=$r['id']?>"  required/>
    </div> 
    <div class="form-group">
    <label>Jenis Kelamin</label>
    <select class="form-control select2" data-dropdown-css-class="select2-navy" name="kp4_jk_anak_<?=$r['id']?>" id="kp4_jk_anak_<?=$r['id']?>" required>
			<option value="" disabled selected>Pilih</option>
        <option <?php if($r['jenis_kelamin'] == "Laki-Laki") echo "selected"; else echo "";?> value="Laki-Laki">Laki-Laki</option>
        <option <?php if($r['jenis_kelamin'] == "Perempuan") echo "selected"; else echo "";?> value="Perempuan">Perempuan</option>
		</select>
    </div> 
    <div class="form-group">
    <label>Dapat/Tidak Tunjangan</label>
    <select class="form-control select2" data-dropdown-css-class="select2-navy" name="kp4_tunjangan_anak_<?=$r['id']?>" id="kp4_tunjangan_anak_<?=$r['id']?>" required>
			<option value="" disabled selected>Pilih</option>
      <option <?php if($r['status_tunjangan'] == "Dapat") echo "selected"; else echo "";?> value="Dapat">Dapat</option>
      <option <?php if($r['status_tunjangan'] == "Tidak") echo "selected"; else echo "";?> value="Tidak">Tidak</option>
		</select>
    </div> 
    <div class="form-group">
    <label>Sudah/Belum Menikah</label>
    <select class="form-control select2" data-dropdown-css-class="select2-navy" name="kp4_status_kawin_anak_<?=$r['id']?>" id="kp4_status_kawin_anak_<?=$r['id']?>" required>
			<option value="" disabled selected>Pilih</option>
        <option <?php if($r['status_kawin'] == "Sudah") echo "selected"; else echo "";?> value="Sudah">Sudah</option>
        <option <?php if($r['status_kawin'] == "Belum") echo "selected"; else echo "";?> value="Belum">Belum</option>
		</select>
    </div>
    <div class="form-group">
    <label>Belum Kerja</label>
    <select class="form-control select2" data-dropdown-css-class="select2-navy" name="kp4_status_kerja_anak_<?=$r['id']?>" id="kp4_status_kerja_anak_<?=$r['id']?>" required>
			<option value="" disabled selected>Pilih</option>
        <option <?php if($r['status_kerja'] == "Sudah") echo "selected"; else echo "";?> value="Sudah">Sudah</option>
        <option <?php if($r['status_kerja'] == "Belum") echo "selected"; else echo "";?> value="Belum">Belum</option>
		</select>
    </div> 
    <div class="form-group">
    <label>Masih/Tidak Sekolah/Kuliah</label>
    <select class="form-control select2" data-dropdown-css-class="select2-navy" name="kp4_status_pendidikan_anak_<?=$r['id']?>" id="kp4_status_pendidikan_anak_<?=$r['id']?>" required>
			<option value="" disabled selected>Pilih</option>
        <option <?php if($r['status_pendidikan'] == "Masih Sekolah") echo "selected"; else echo "";?> value="Masih Sekolah">Masih Sekolah</option>
        <option <?php if($r['status_pendidikan'] == "Tidak Sekolah") echo "selected"; else echo "";?> value="Tidak Sekolah">Tidak Sekolah</option>
        <option <?php if($r['status_pendidikan'] == "Kuliah") echo "selected"; else echo "";?> value="Kuliah">Kuliah</option>
        
		</select>
    </div> 
    <div class="form-group">
    <label>Keputusan Pengadilan</label>
    <input  class="form-control" value="<?=$r['keputusan_pengadilan'];?>" autocomplete="off" name="kp4_keputusan_pengadilan_anak_<?=$r['id']?>" id="kp4_keputusan_pengadilan_anak_<?=$r['id']?>"  required/>
    </div> 
    <?php } }  else { ?>
    <p>Tidak ada data Anak, Silahkan Input data Anak pada tab Keluarga jika sudah mempunyai anak</p>
    <?php } ?>
  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton float-right"  id="btn_upload_arsip"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

   
<div id="list_arsip_lainnya">

</div>

<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="">
       
      </div>
    </div>
  </div>
</div>  



<!-- Modal -->
<div class="modal fade" id="modal_edit_arsip_lain" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail </h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit_arsip_lain_pegawai">
          
        </div>
    
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">


$(function(){
  $(".select2").select2({   
		width: '100%',
		// dropdownAutoWidth: true,
		allowClear: true,
	});
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    $('#upload_form_kp4').on('submit', function(e){  
        e.preventDefault();
        var formvalue = $('#upload_form_kp4');
        var form_data = new FormData(formvalue[0]);
        console.log(form_data);
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/simpanKp4")?>",
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
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 


</script>