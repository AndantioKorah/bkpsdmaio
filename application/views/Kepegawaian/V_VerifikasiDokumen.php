<div class="row">
  <div class="col-lg-12">
    <div class="card card-default p-3">
      <form class="form-custom" id="form_search_dokumen_verif">
        <div class="row">
          <div class="col-lg-4">
            <label>Tanggal Usul</label>
            <input class="form-control form-custom-input daterangepickerthis" id="tanggal" readonly name="tanggal"/>
          </div>
          <div class="col-lg-4">
            <label>Nama Pegawai</label>
            <input class="form-control form-custom-input" autocomplete="off" id="nama" name="nama"/>
          </div>
          <div class="col-lg-4">
            <label>NIP</label>
            <input class="form-control form-custom-input" autocomplete="off" id="nip" name="nip"/>
          </div>
          <div class="col-lg-4">
            <label>Unit Kerja</label>
            <select class="form-control form-custom-input select2-navy select2_this" style="width: 100%"
                id="unitkerja" data-dropdown-css-class="select2-navy" name="unitkerja">
                <option selected value="0">Semua</option>
                <?php foreach($list_skpd as $skpd){ ?>
                    <option value="<?=$skpd['id_unitkerja']?>"><?=$skpd['nm_unitkerja']?></option>
                <?php } ?>
            </select>
          </div>
          <div class="col-lg-4">
            <label>Jenis Dokumen</label>
            <select class="form-control form-custom-input select2-navy select2_this" style="width: 100%"
                id="jenisdokumen" data-dropdown-css-class="select2-navy" name="jenisdokumen">
                <?php foreach($list_dokumen as $ld){ ?>
                  <option value="<?=$ld['db']?>"><?=$ld['nama']?></option>
                <?php } ?>
            </select>
          </div>
          <div class="col-lg-4">
            <label>Status</label>
            <select class="form-control form-custom-input select2-navy select2_this" style="width: 100%"
                id="status" data-dropdown-css-class="select2-navy" name="status">
                  <option selected value="0">Semua</option>
                  <option value="1">Pengajuan</option>
                  <option value="2">Diterima</option>
                  <option value="3">Ditolak</option>
                  <option value="4">Dibatalkan</option>
            </select>
          </div>
          <div class="col-lg-12 mt-3 text-right">
            <button type="submit" style="width: 25% !important; height: 35px !important; font-size: .8rem;"
            class="btn btn-navy btn-sm">SUBMIT PENCARIAN <i class="fa fa-search"></i></button>
          </div>
        </div>
      </form>
    </div>
  </div>
  
  <div class="col-lg-12 p-3" style="display: none;" id="wrapper_result">
    <div id="result" class="card card-default p-3">
                  
    </div>
  </div>
</div>
<script>
  $(function(){
    $('#form_search_dokumen_verif').on('submit', function(e){
      $('#wrapper_result').show()
      $('#result').html('')
      $('#result').append(divLoaderNavy)
      e.preventDefault()
      $.ajax({
        url: '<?=base_url('Kepegawaian/C_Kepegawaian/searchDokumenUsul')?>',
        method: 'post',
        data: $(this).serialize(),
        success: function(data){
          $('#result').html('')
          $('#result').append(data)
        }, error: function(e){
          errortoast('Terjadi Kesalahan')
          console.log(e)
        }
      })
    })
  })
</script>