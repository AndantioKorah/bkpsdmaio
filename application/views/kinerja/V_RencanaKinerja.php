<!-- <h1 class="h3 mb-3">Penetapan Sasaran Kerja</h1> -->
<h1 class="h3 mb-3">Sasaran Kerja Bulanan Pegawai</h1>

<div class="card card-default">

    <div class="card-body" style="display: block;">
        <table>
          <tr>
          <td>
          <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="checkBoxID">
      <label class="form-check-label" for="checkBoxID">
      Ikut Sasaran Kerja Bulan Sebelumnya    
      </label> 
    </div>
          </td>
          <td>
          <button id="buttonID" onclick="inputSasaranPrevMonth()" class="btn btn-primary mb-2" disabled>Simpan</button>
          </td>
          </tr>
        </table>
       
<script>

$("#checkBoxID").click(function() {
  $("#buttonID").attr("disabled", !this.checked);
});

  function inputSasaranPrevMonth() {

    document.getElementById('buttonID').disabled = true;
    $('#buttonID').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
    
    const d = new Date();
    let month = d.getMonth();
    let year = new Date().getFullYear()

    if(month == 0){
      month = 12;
      year = year-1;
    }

    

    $.ajax({  
        url:"<?=base_url("kinerja/C_Kinerja/inputSasaranPrevMonth")?>",
        method: 'post',
            data: {
                bulan: month,
                tahun: year
            },
        
        success:function(res){ 
            console.log(res)
            var result = JSON.parse(res); 
            console.log(result)
            if(result.success == true){
              $("html, body").animate({ scrollTop: $(document).height() }, 1000);
               successtoast('Data berhasil ditambahkan')
                loadRencanaKinerja($('#bulan').val(), $('#tahun').val())
                $("html, body").animate({ scrollTop: $(document).height() }, 500);
                $('#buttonID').html('Simpan')
                $("#buttonID").attr("disabled", false);
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });

    // $.ajax({
    //         url: '<?=base_url("kinerja/C_Kinerja/inputSasaranPrevMonth")?>',
    //         method: 'post',
    //         data: {
    //             bulan: month,
    //             tahun: year
    //         },
    //         success: function(data){
            
    //         }, error: function(e){
    //             $('.class_form').show()
    //             errortoast('Terjadi Kesalahan')
    //         }
    //     })

}
</script>

    <form method="post" id="form_tambah_rencana_kinerja">
   
  <div class="form-group" >
    <label for="exampleFormControlInput1">Uraian Tugas</label>
    <!-- <input required class="form-control " id="tugas_jabatan" name="tugas_jabatan" autocomplete="off"> -->
    <input class="form-control customInput"  type="text" list="tugasjabatan" id="tugas_jabatan" name="tugas_jabatan" autocomplete="off" required/>
      <datalist id="tugasjabatan">
      <?php if($list_rencana_kinerja){
                                foreach($list_rencana_kinerja as $ls){
                                ?>
                                <option value="<?=$ls['tugas_jabatan']?>">
                                    <?=$ls['tugas_jabatan']?>
                                </option>
                                <?php } } ?>
      </datalist>
  </div>

  <div class="form-group" >
    <label for="exampleFormControlInput1">Sasaran Kerja</label>
    <input required class="form-control customInput" list="sasarankerja"  id="sasaran_kerja" name="sasaran_kerja" autocomplete="off">
    <datalist id="sasarankerja">
      <?php if($list_sasaran_kerja){
                                foreach($list_sasaran_kerja as $ls){
                                ?>
                                <option value="<?=$ls['sasaran_kerja']?>">
                                    <?=$ls['sasaran_kerja']?>
                                </option>
                                <?php } } ?>
      </datalist>
        </div>

    <div class="form-group" >
    <label for="exampleFormControlInput1">Tahun</label>
    <input  class="form-control yearpicker customInput" id="tahun" name="tahun" value="<?= date('Y');?>">
  </div>

    <div class="form-group" >
    <label for="exampleFormControlInput1">Bulan</label>
    <select class="form-control select2-navy customInput" style="width: 100%"
                 id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                 <option selected>- Pilih Bulan -</option>
                 <option <?=date('m') == 1 ? 'selected' : '';?> value="1">Januari</option>
                 <option <?=date('m') == 2 ? 'selected' : '';?> value="2">Februari</option>
                 <option <?=date('m') == 3 ? 'selected' : '';?> value="3">Maret</option>
                 <option <?=date('m') == 4 ? 'selected' : '';?> value="4">April</option>
                 <option <?=date('m') == 5 ? 'selected' : '';?> value="5">Mei</option>
                 <option <?=date('m') == 6 ? 'selected' : '';?> value="6">Juni</option>
                 <option <?=date('m') == 7 ? 'selected' : '';?> value="7">Juli</option>
                 <option <?=date('m') == 8 ? 'selected' : '';?> value="8">Agustus</option>
                 <option <?=date('m') == 9 ? 'selected' : '';?> value="9">September</option>
                 <option <?=date('m') == 10 ? 'selected' : '';?> value="10">Oktober</option>
                 <option <?=date('m') == 11 ? 'selected' : '';?> value="11">November</option>
                 <option <?=date('m') == 12 ? 'selected' : '';?> value="12">Desember</option>
                 </select>
  </div>

      
 <div class="form-group" >
    <div class="row">
    <div class="col">
    <label >Target Kuantitas</label>
      <input required type="number" min=0 class="form-control customInput" name="target_kuantitas" id="target_kuantitas"   onkeyup="cekJumlahTarget()" autocomplete="off">
    </div>
    <!-- <div class="col">
    <label >Capaian Kuantitas</label>
      <input required type="text" class="form-control customInput" name="total_realisasi" id="total_realisasi" autocomplete="off">
    </div> -->
    <div class="col">
    <label >Satuan</label>
      <input required type="text" class="form-control customInput" name="satuan" id="satuan" autocomplete="off" list="sat" >
      <datalist id="sat">
        <option >Dokumen</option>
        <option >Data</option>
        <option >Pegawai</option>
        <option >SKPD</option>
        <option >Hari</option>
        <option >Tugas</option>
      </datalist>
   
    </div>
  </div>
  </div>

  <div class="form-group">
    <label>Target Kualitas (%)</label>
    <input  class="form-control customInput" type="text" id="target_kualitas" name="target_kualitas" value="100" readonly/>
  </div>
  <div class="form-group">
     <button class="btn btn-block btn-primary customButton" style="width:100%" id="btn_upload"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 

    </div>
</div>


<h1 class="h3 mb-3">List Sasaran Kerja</h1>
<div class="card card-default" id="list_rencana_kinerja">
    
</div>

<div class="modal fade" id="edit_rencana_kinerja" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">EDIT SASARAN KERJA</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="edit_rencana_kinerja_content">
          </div>
      </div>
  </div>
</div>




<script>

    $(function(){
      var tahun = '<?=date("Y")?>'
      var bulan = '<?=date("m")?>'
         
      var $src = $('#target_kuantitas'),
      $dst = $('#total_realisasi');
      $src.on('input', function () {
      $dst.val($src.val());
      
    });

    loadRencanaKinerja(bulan,tahun)

    })

 

    function loadRencanaKinerja(bulan,tahun){
      

        $('#list_rencana_kinerja').html('')
        $('#list_rencana_kinerja').append(divLoaderNavy)
        $('#list_rencana_kinerja').load('<?=base_url("kinerja/C_Kinerja/loadRencanaKinerja")?>'+'/'+bulan+'/'+tahun, function(){
            $('#loader').hide()
        })
    }

    $('#search_bulan').on('change', function(){
      searchListRencanaKinerja()
    })

    $('#search_tahun').on('change', function(){
        searchListRencanaKinerja()
    })

    function searchListRencanaKinerja(){
        if($('#search_bulan').val() == '')  
        {  
        errortoast(" Pilih Bulan terlebih dahulu");  
        return false
        } 
        var tahun = $('#search_tahun').val(); 
        var bulan = $('#search_bulan').val();
        $('#list_rencana_kinerja').html(' ')
        $('#list_rencana_kinerja').append(divLoaderNavy)
        $('#list_rencana_kinerja').load('<?=base_url('kinerja/C_Kinerja/loadRencanaKinerja/')?>'+bulan+'/'+tahun+'', function(){
            $('#loader').hide()
           
        })
    }

    function cekJumlahTarget(){

      var target_kuantitas = $('#target_kuantitas').val(); 
      if(target_kuantitas == "0" || target_kuantitas < 0) {
          errortoast("Target Kuantitas tidak boleh 0")
          $('#target_kuantitas').val(null); 
      }
    }


    $('#bulan').on('change', function(){
       
  var bulanSearch = $('#bulan').val()
  var date = new Date();
  var tanggal = new Date().getDate();
  var bulanCurrent = date.getMonth()+1;
  var tahun = date.getFullYear();

  var firstDay = getFirstDayOfMonth(
    date.getFullYear(),
    date.getMonth(),
  );

  var previousMonth = bulanCurrent - 1;
  var batasMonth = previousMonth - 1;

  var statusLock = "<?=$status_lock[0]['status'];?>"
  
    if(statusLock == 0){
      $('.customButton').show()
    } else {
      if(bulanSearch != bulanCurrent){
        if(bulanSearch < previousMonth) {
          $('.customButton').hide()
        } else {
          if(tanggal <= 3) {
            $('.customButton').show()
        } else {
            $('.customButton').hide()
        }
        }
      } else {
        $('.customButton').show()
      }
    }
    })

    // $('#search_tahun').on('changeDate', function(){
    //     loadRencanaKinerja($('#search_bulan').val(), $('#search_tahun').val())
    // })

    $('#form_tambah_rencana_kinerja').on('submit', function(e){
      document.getElementById('btn_upload').disabled = true;
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/createRencanaKinerja")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
              document.getElementById('btn_upload').disabled = false;
                successtoast('Data berhasil ditambahkan')
                loadRencanaKinerja($('#bulan').val(), $('#tahun').val())
                document.getElementById("form_tambah_rencana_kinerja").reset();
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })



    function openModalEditRencanaKinerja(id = 0, jumlahRealisasi){
    $('#edit_rencana_kinerja_content').html('')
    $('#edit_rencana_kinerja_content').append(divLoaderNavy)
    $('#edit_rencana_kinerja_content').load('<?=base_url("kinerja/C_Kinerja/loadEditRencanaKinerja")?>'+'/'+id+'/'+jumlahRealisasi, function(){
      $('#loader').hide()
    })
  }


</script>

