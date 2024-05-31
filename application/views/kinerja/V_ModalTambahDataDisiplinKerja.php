<div class="modal-body">
    <form id="form_input">
        <div class="row">
        <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getBidangUser() == ID_BIDANG_PEKIN)  { ?>
                <div class="col-lg-12 col-md-12 mt-2">
                    <label>Pilih Unit Kerja</label>
                    <select class="form-control select2-navy select2 " style="width: 100%"
                            id="cariunitkerja" data-dropdown-css-class="select2-navy" >
                            <?php foreach($skpd as $s){ ?>
                                <option value="<?=$s['id_unitkerja']?>"><?=$s['nm_unitkerja']?></option>
                            <?php } ?>
                        </select>
                </div>
            <?php } ?>

            <?php if($this->general_library->isProgrammer() || 
            $this->general_library->isAdminAplikasi() || 
            isKasubKepegawaian($this->general_library->getNamaJabatan()) || 
            $this->general_library->isHakAkses('verifikasi_keterangan_presensi') ||
            $this->general_library->getBidangUser() == ID_BIDANG_PEKIN) {
            ?>
                 <div class="col-lg-12 col-md-12 mt-2">
                    <label>Pilih Pegawai</label>
                    <select required multiple="multiple" class="form-control select2-navy" style="width: 100%"
                        id="pegawai" data-dropdown-css-class="select2-navy" name="pegawai[]">
                        <?php foreach($pegawai as $p){ ?>
                            <option value="<?=$p['id_m_user']?>"><?=getNamaPegawaiFull($p)?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } else {  ?>
                <input style="display: none;" class="form-control form-control-sm" readonly name="pegawai[]" value="<?=$this->general_library->getId()?>" />
            <?php } ?>
           

            <div class="col-lg-12 col-md-12 mt-3">
                <label>Pilih Periode</label>  
                <input class="form-control form-control-sm" id="range_periode" readonly name="range_periode"/>
            </div>
            <div class="col-lg-12 col-md-12 mt-3">
                <label>Pilih Jenis Disiplin</label>  
                <select class="form-control select2-navy" style="width: 100%" onchange="suratTugas(this);"
                    id="jenis_disiplin" data-dropdown-css-class="select2-navy" name="jenis_disiplin">
                    <?php foreach($jenis_disiplin as $j){ ?>
                        <option value="<?=$j['id'].';'.$j['nama_jenis_disiplin_kerja'].';'.$j['pengurangan']?>"><?=$j['nama_jenis_disiplin_kerja']?></option>
                    <?php } ?>
                </select>
            </div>


            <div class="col-lg-12 col-md-12 mt-3" id="jenistugasluar" style="display:none">
               
               <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_tugas_luar" id="jenistugasluar1" value="Tugas Luar Pagi">
                <label class="form-check-label" for="jenistugasluar1">Pagi</label>
                </div>
                <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_tugas_luar" id="jenistugasluar2" value="Tugas Luar Sore">
                <label class="form-check-label" for="jenistugasluar2">Sore</label>
                </div>
                <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_tugas_luar" id="jenistugasluar3" value="Tugas Luar">
                <label class="form-check-label" for="jenistugasluar3">Semua</label>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 mt-3">
                <label>Dokumen Pendukung</label>  
                <input class="form-control" type="file" id="image_file" name="files[]" multiple="multiple" />
            </div>
            <div class="col-lg-12 col-md-12 mt-3" style="margin-top: 28px;">
                <button id="btn_tambah" type="submit" class="btn btn-block btn-navy"><i class="fa fa-input"></i> Tambah</button>
                <button style="display: none;" id="btn_loading" disabled type="button" class="btn btn-block btn-navy"><i class="fa fa-spin fa-spinner"></i> Loading....</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(function(){
        var firstDay = getFirstDayOfMonth(
            date.getFullYear(),
            date.getMonth(),
        );

        $('#pegawai').select2()
        $('#jenis_disiplin').select2()
        $('#cariunitkerja').select2()
        $("#range_periode").daterangepicker({
            showDropdowns: true,
            minDate: firstDay
        });
      

    })

    // function tambahData(){
    //     $('#tambah_data_disiplin_kerja_content').html('')
    //     $('#tambah_data_disiplin_kerja_content').append(divLoaderNavy)
    //     $('#tambah_data_disiplin_kerja_content').load('<?=base_url("")?>', function(){
    //         $('#loader').hide()
    //     })
    // }

    $('#form_input').submit(function(e){
        $('#btn_tambah').hide()
        $('#btn_loading').show()
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/insertDisiplinKerja")?>',
            method: 'post',
            data: new FormData($('#form_input')[0]),
            contentType: false,  
            cache: false,  
            processData:false,
            success: function(data){
                $('#btn_tambah').show()
                $('#btn_loading').hide()
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    successtoast('Berhasil Menambahkan Data Disiplin Kerja')
                    $('#form_search_disiplin_kerja').submit()
                } else {
                    errortoast(rs.message)
                }
            }, error: function(e){
                $('#btn_tambah').show()
                $('#btn_loading').hide()
                errortoast('Terjadi Kesalahan')
            }
        })
    })

  
                function suratTugas(sel)
                {
                    if(sel.value == "14;Tugas Luar;0"){
                      $('#jenistugasluar').show()
                    } else {
                        $('#jenistugasluar').hide()
                    }
                }
       

    $("#cariunitkerja").change(function() {
      var id = $("#cariunitkerja").val();
     
      $.ajax({
              url : "<?php echo base_url();?>kepegawaian/C_Kepegawaian/getSearchPegawai",
              method : "POST",
              data : {id: id},
              async : false,
              dataType : 'json',
              success: function(data){
              var html = '';
                      var i;
                      for(i=0; i<data.length; i++){
                          html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                      }
                      $('#pegawai').html(html);
                        }
                  });
  });

</script>