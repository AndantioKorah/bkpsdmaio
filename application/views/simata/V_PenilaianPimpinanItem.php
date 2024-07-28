<?php if($list_pegawai){ ?>
   <style>
.radio-inputs {
  position: relative;
  display: flex;
  flex-wrap: wrap;
  border-radius: 0.5rem;
  /* background-color: #EEE; */
  background-color: #dbd7d7;
  
  box-sizing: border-box;
  box-shadow: 0 0 0px 1px rgba(0, 0, 0, 0.06);
  padding: 0.25rem;
  width: 100%;
  font-size: 14px;
}

.radio-inputs .radio {
  flex: 1 1 auto;
  text-align: center;
}

.radio-inputs .radio input {
  display: none;
}

.radio-inputs .radio .name {
  display: flex;
  cursor: pointer;
  align-items: center;
  justify-content: center;
  border-radius: 0.5rem;
  border: none;
  padding: .5rem 0;
  color: rgba(51, 65, 85, 1);
  transition: all .15s ease-in-out;
}

.radio-inputs .radio input:checked + .name {
  background-color: #fff;
  font-weight: 600;
}
   </style>
   
    <div class="col-lg-12 table-responsive">
    <table class="table table-striped" id="table_list_pegawai">
            <thead>
                <th class="text-center">No</th>
                <th class="text-left">Nama Pegawai</th>
                <?php if($this->general_library->isWalikota()){ ?>
                    <th class="text-left">Unit Kerja</th>
                    <th class="text-left">Jabatan</th>
                <?php } ?>
               <th class="text-left">Promosi Jabatan</th>
               <th class="text-left">Rotasi Jabatan</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
            <?php $no=1; foreach($list_pegawai as $p){
                $capaian = null;
                $pembobotan = null;
               
                if(isset($p['komponen_kinerja']) && $p['komponen_kinerja']){
                    // dd($p['komponen_kinerja']);
                    list($capaian, $pembobotan) = countNilaiKomponen($p['komponen_kinerja']);
                    // $pembobotan = $pembobotan * 100;
                    // dd($p['created_by']);
                    // dd($this->general_library->getId());
                    // $pembobotan = (formatTwoMaxDecimal($pembobotan)).'%';
                    $pembobotan = number_format((float)$pembobotan, 2, '.', '').'%';
                    // $capaian = $p['komponen_kinerja']['capaian'];
                    // $pembobotan = $p['komponen_kinerja']['bobot']."%";
                }
            ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td><?=getNamaPegawaiFull($p)?></td>
                    <?php if($this->general_library->isWalikota()){ ?>
                        <td class="text-left"><?=$p['nm_unitkerja']?></td>
                        <td class="text-left"><?=$p['nama_jabatan']?></td>
                    <?php } ?>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                     <td class="text-center">




                     <!-- <form id="form_penilaian_pimpinan" method="post" enctype="multipart/form-data">
       <input type="hidden" id="id_pegawai">
       <div class="radio-inputs mb-3">
        <label class="radio">
            <input type="radio" name="radio" checked="" value="124">
            <span class="name">Sangat Mendukung</span>
        </label>

        <label class="radio">
            <input type="radio" name="radio" checked="" value="0">
            <span class="name">|</span>
        </label>


        <label class="radio">
            <input type="radio" name="radio" value="125">
            <span class="name">Tidak Mendukung</span>
        </label>
        </div>
       
        </form> -->
                       
      
                        <button data-id="<?=$p['id_peg']?>" type="button" class="btn btn-primary btn-sm open-DetailPT"  data-toggle="modal" data-target="#exampleModal">
                        Input Nilai
                        </button>

                        <?php // if($p['komponen_kinerja'] && $p['created_by'] == $this->general_library->getId()){ ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
          
        </table>
    </div>
    <div class="modal fade" id="modal_edit_data_nilai" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div id="modal-dialog" class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Sasaran Kerja Bulanan Pegawai</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_edit_data_nilai_content">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
       <form id="form_penilaian_pimpinan" method="post" enctype="multipart/form-data">
        <span>Promosi Jabatan</span>
       <input type="hidden" id="id_pegawai">
       <div class="radio-inputs mb-3">
        <label class="radio">
            <input type="radio" name="radio" checked="" value="124">
            <span class="name">Sangat Mendukung</span>
        </label>

        <label class="radio">
            <input type="radio" name="radio" checked="" value="0">
            <span class="name">|</span>
        </label>


        <label class="radio">
            <input type="radio" name="radio" value="125">
            <span class="name">Tidak Mendukung</span>
        </label>
        </div>
        
        <span>Rotasi Jabatan</span>
       <input type="hidden" id="id_pegawai">
       <div class="radio-inputs mb-3">
        <label class="radio">
            <input type="radio" name="radio2" checked="" value="124">
            <span class="name">Sangat Mendukung</span>
        </label>

        <label class="radio">
            <input type="radio" name="radio2" checked="" value="0">
            <span class="name">|</span>
        </label>


        <label class="radio">
            <input type="radio" name="radio2" value="125">
            <span class="name">Tidak Mendukung</span>
        </label>
        </div>

        <button class="btn btn-primary float-right">Simpan</button>
        </form>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

    <script>

$(document).on("click", ".open-DetailPT", function () {

var id = $(this).data('id');

$('#id_pegawai').val(id)


});

$('#table_list_pegawai').DataTable({
    "ordering": false,
    "aLengthMenu": [[20, 50, 75, -1], [20, 50, 75, "All"]],
     });
    
        
     $('#form_penilaian_pimpinan').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_penilaian_pimpinan');
        var form_data = new FormData(formvalue[0]);


       location.reload()   
       
      

        // $.ajax({  
        // url:"<?=base_url("simata/C_simata/submitPenilaianPimpinan")?>",
        // method:"POST",  
        // data:form_data,  
        // contentType: false,  
        // cache: false,  
        // processData:false,  
        // success:function(res){ 
        //     console.log(res)
        //     var result = JSON.parse(res); 
        //     console.log(result)
                
        // }  
        // });  
          
        });

    </script>
<?php } else { ?>
<?php } ?>