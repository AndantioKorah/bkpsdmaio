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
  padding: 0.15rem;
  width: 100%;
  font-size: 10px;
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

.radio-inputs .radio .name2 {
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
  background-color: #1f7640;
  font-weight: 600;
  color: #fff;
  
}

.radio-inputs .radio input:checked + .name2 {
  background-color: #f5d60a;
  font-weight: 600;
  color: #000;
}
   </style>
   
    <div class="col-lg-12 table-responsive">
    <table class="table table-striped" id="table_list_pegawai">
            <thead>
                <th class="text-center">No</th>
                <th class="text-left">Nama Pegawai</th>
                <?php if($this->general_library->isWalikota() || $this->general_library->isSetda()){ ?>
                    <!-- <th class="text-left">Unit Kerja</th> -->
                  
                <?php } ?>
                <th class="text-left">Jabatan</th>
                <th class="text-center"></th>
                <!-- <th class="text-center">Rotasi Jabatan</th> -->
                <!-- <th class="text-center">Pilihan</th> -->
            </thead>
            <tbody>
            <?php $no=1; foreach($list_pegawai as $p){?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td><?=getNamaPegawaiFull($p)?> </td>
                    <?php if($this->general_library->isWalikota() || $this->general_library->isSetda()){ ?>
                        <!-- <td class="text-left"><?=$p['nm_unitkerja']?></td> -->
                      
                    <?php } ?>
                    <td class="text-left"><?=$p['nama_jabatan']?></td>
                    <td class="text-left">
                    <div class="radio-inputs mb-3">
                    <label class="radio">
                        <input type="radio" onchange="handleChange(this,'<?=$p['id_peg']?>');" name="radio_<?=$p['id_m_user']?>" <?php if($p['pertimbangan_pimpinan'] == 124) echo "checked" ?>  value="124">
                        <span class="name">Sangat Mendukung</span>
                    </label>

                  

                    <label class="radio">
                        <input type="radio" onchange="handleChange(this,'<?=$p['id_peg']?>');" name="radio_<?=$p['id_m_user']?>"  <?php if($p['pertimbangan_pimpinan'] == 125) echo "checked" ?>  value="125">
                        <span class="name2">Tidak Mendukung</span>
                    </label>
                    </div>
                    </td>
                    <!-- <td class="text-left">
                    <div class="radio-inputs mb-3">
                    <label class="radio">
                        <input type="radio" name="radio2_<?=$p['id']?>" checked="" value="124">
                        <span class="name">Sangat Mendukung</span>
                    </label>

                    <label class="radio">
                        <input type="radio" name="radio2_<?=$p['id']?>" checked="" value="0">
                        <span class="name">|</span>
                    </label>

                    <label class="radio">
                        <input type="radio" name="radio2_<?=$p['id']?>" value="125">
                        <span class="name">Tidak Mendukung</span>
                    </label>
                    </div>
                    </td> -->
                     <!-- <td class="text-center">                                             
                        <button data-id="<?=$p['id_peg']?>" type="button" class="btn btn-primary btn-sm open-DetailPT"  data-toggle="modal" data-target="#exampleModal">
                        Input Nilai
                        </button>
                    </td> -->
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
       <input type="hidden" name="id_pegawai" id="id_pegawai">
       <!-- <span>Promosi Jabatan</span> -->
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

        <!-- <span>Rotasi Jabatan</span>
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
        </div> -->

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

       
      

        $.ajax({  
        url:"<?=base_url("simata/C_simata/submitPenilaianPimpinan")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        success:function(res){ 
          //  location.reload()
                
        // }  
        // });  
          
        });


        function verifDokumen(val,id){
       alert(val)
        
    }

    function handleChange(src,id) {
   
      $.ajax({
            url: '<?=base_url("simata/C_Simata/submitPenilaianPimpinan/")?>',
            method: 'post',
            data: {
                nilai : src.value,
                id_peg: id
            },
            success: function(data){
                
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }
    </script>
<?php } else { ?>
<?php } ?>