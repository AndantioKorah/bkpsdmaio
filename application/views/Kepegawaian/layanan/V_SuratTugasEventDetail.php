<style>
    .stevent_text_label{
        font-size: .65rem;
        color: grey;
        font-weight: bold;
        font-style: italic;
    }

    .stevent_text_value{
        font-size: 1rem;
        color: black;
        font-weight: bold;
    }
</style>
<?php if($result['data']){ ?>
    <div class="row p-3">
        <div class="col-lg-12">
            <div class="row">
                <div style="border-right: 1px grey solid;" class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5>LIST PEGAWAI (<span id="sp_total_pegawai"></span>)</h5>
                            <div class="row">
                                <div class="col-lg-12" style="max-height: 85vh; overflow-x: auto;" id="div_list_pegawai"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="stevent_text_label">Event</label><br>
                            <span class="stevent_text_value"><?=$result['data']['judul']?></span>
                        </div>
                        <div class="col-lg-4 mt-3">
                            <label class="stevent_text_label">Absen Masuk</label><br>
                            <span class="stevent_text_value"><?=(formatTimeAbsen($result['data']['buka_masuk'])." - ".formatTimeAbsen($result['data']['batas_masuk']))?></span>
                        </div>
                        <div class="col-lg-4 mt-3">
                            <label class="stevent_text_label">Absen Pulang</label><br>
                            <span class="stevent_text_value"><?=(formatTimeAbsen($result['data']['buka_pulang'])." - ".formatTimeAbsen($result['data']['batas_pulang']))?></span>
                        </div>
                        <div class="col-lg-4 mt-3">
                            <label class="stevent_text_label">Radius</label><br>
                            <span class="stevent_text_value"><?=$result['data']['radius']." m"?></span>
                        </div>
                        <div class="col-lg-4 mt-3">
                            <label class="stevent_text_label">Tanggal Event</label><br>
                            <span class="stevent_text_value"><?=formatDateNamaBulan($result['data']['tgl'])?></span>
                        </div>
                        <div class="col-lg-4 mt-3">
                            <label class="stevent_text_label">Batas Input</label><br>
                            <span class="stevent_text_value"><?=formatDateNamaBulan($result['data']['max_input_date'])?></span>
                        </div>
                        <div class="col-lg-4 mt-3">
                            <label class="stevent_text_label">Tanggal Edit</label><br>
                            <span class="stevent_text_value"><?=formatDateNamaBulan($result['data']['max_change_date'])?></span>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <label class="stevent_text_label">Keterangan</label><br>
                            <span class="stevent_text_value"><?=$result['data']['ket']?></span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <hr>
                            <?php if(date('Y-m-d') <= $result['data']['max_change_date']){ ?>
                                <h5>EDIT LIST PEGAWAI</h5>
                                <form id="form_edit_st">
                                    <div class="col-lg-12 col-md-12 mt-2">
                                        <label>Pilih Pegawai</label>
                                        <select multiple="multiple" class="form-control select2-navy" style="width: 100%"
                                            id="list_pegawai_edit" data-dropdown-css-class="select2-navy" name="list_pegawai_edit[]">
                                            <?php foreach($list_pegawai as $p){ ?>
                                                <option value="<?=$p['skpd'].";".$p['nipbaru_ws'].";".$p['id_m_user']?>"><?=getNamaPegawaiFull($p)?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>Upload Surat Tugas:</label>                                
                                        <input class="form-control" type="file" id="file_st" name="file_st" accept="application/pdf" />
                                        <span style="color:red; font-size: .7rem; font-weight: bold; font-style: italic;">
                                            *diisi hanya jika ada perubahan Nama Pegawai pada Surat Tugas
                                        </span>
                                    </div>
                                    <div class="col-lg-12 mt-2 text-right">
                                        <button id="btn_edit_data" type="submit" class="btn btn-navy"><i class="fa fa-save"></i> Simpan</button>
                                    </div>
                                </form>
                            <?php } else { ?>
                                <span style="color:red; font-size: .7rem; font-weight: bold; font-style: italic;">
                                    Batas Waktu perubahan data Surat Tugas sudah lewat yaitu pada <?=formatDateNamaBulan($result['data']['max_change_date'])?>
                                </span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            loadListPegawaiSTEvent()
            $('#list_pegawai_edit').select2()
        })

        function loadListPegawaiSTEvent(){
            $('#div_list_pegawai').html('')
            $('#div_list_pegawai').append(divLoaderNavy)
            $('#div_list_pegawai').load('<?=base_url("kepegawaian/C_Layanan/getListPegawaiEventDetail/".$result['data']['id_t_pegawai_event'])?>', function(){
                $('#loader').hide()
            })
        }

        $('#form_edit_st').on('submit', function(e){
            e.preventDefault();
            btnLoader('btn_edit_data')
            var formvalue = $('#form_edit_st');
            var form_data = new FormData(formvalue[0]);
            var ins = document.getElementById('file_st').files.length;

            $.ajax({  
                url:"<?=base_url("kepegawaian/C_Layanan/editSuratTugasEvent/".$result['data']['id_t_pegawai_event'])?>",
                method:"POST",  
                data:form_data,  
                contentType: false,  
                cache: false,  
                processData:false,  
                // dataType: "json",
                success:function(res){ 
                    var rs = JSON.parse(res); 
                    if(rs.code == 0){
                        successtoast('Data berhasil ditambahkan')
                        loadListPegawaiSTEvent()
                    } else {
                        errortoast(rs.message)
                    }
                    btnLoader("btn_edit_data")
                }, error: function(e){
                    btnLoader("btn_edit_data")
                    errortoast('Terjadi Kesalahan')
                }   
            });
        })
    </script>
<?php } ?>