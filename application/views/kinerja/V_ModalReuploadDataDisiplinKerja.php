<?php if($data){ ?>
    <div class="modal-body">
        <form id="form_input">
            <div class="row">
                <div class="col-lg-12 col-md-12 mt-3">
                    <label>Pilih Periode</label>  
                    <input class="form-control form-control-sm" id="range_periode" readonly name="range_periode"/>
                </div>
                <div class="col-lg-12 col-md-12 mt-3">
                    <label>Pilih Jenis Disiplin</label>  
                    <select class="form-control select2-navy" style="width: 100%" onchange="suratTugas(this);"
                        id="jenis_disiplin" data-dropdown-css-class="select2-navy" name="jenis_disiplin">
                        <?php foreach($jenis_disiplin as $j){ ?>
                            <option <?=$j['id'] == $data['id_m_jenis_disiplin_kerja'] ? 'selected' : '' ;?>
                                value="<?=$j['id'].';'.$j['nama_jenis_disiplin_kerja'].';'.$j['pengurangan'].';'.$j['batas_waktu']?>">
                                <?=$j['nama_jenis_disiplin_kerja']?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-lg-12 col-md-12 mt-3">
                    <label>Dokumen Pendukung</label>  
                    <input class="form-control" type="file" id="image_file" name="files[]" multiple="multiple" />
                    <label style="font-weight: bold; font-size: .8rem; font-style: italic; color: red;">
                        Biarkan kosong jika tidak ingin mengganti dokumen pendukung yang sudah diupload sebelumnya
                    </label>
                </div>
                <div class="col-lg-12 col-md-12 mt-3" style="margin-top: 28px;">
                    <h5 id="error_label" style="color: red; font-weight: bold; display: none;"></h5>
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
                format: 'DD/MM/YYYY',
                showDropdowns: true,
                startDate: '<?=formatDateOnlyForEdit3($data['tanggal_awal'])?>',
                endDate: '<?=formatDateOnlyForEdit3($data['tanggal_akhir'])?>',
                // minDate: firstDay
            });
            checkLockTpp()
        })

        $('#jenis_disiplin').on('change', function(){
        })

        $("#range_periode").on('change', function(){
            checkLockTpp()
        })

        function checkLockTpp(){
            $('#btn_tambah').hide()
            $('#btn_loading').show()
            $.ajax({
                url: '<?=base_url("kinerja/C_Kinerja/checkLockTpp")?>',
                method: 'post',
                data: {
                    periode: $("#range_periode").val()
                },
                success: function(data){
                    let rs = JSON.parse(data)
                    if(rs.code == 0){
                        $('#btn_tambah').show()
                        $('#btn_loading').hide()
                        $('#error_label').hide()
                    } else {
                        $('#btn_tambah').hide()
                        $('#btn_loading').hide()
                        $('#error_label').show()
                        $('#error_label').html(rs.message)
                    }
                }, error: function(e){
                    $('#btn_tambah').show()
                    $('#btn_loading').hide()
                    errortoast('Terjadi Kesalahan')
                }
            })
        }

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
                url: '<?=base_url("kinerja/C_Kinerja/reuploadDisiplinKerja/").$data['random_string']?>',
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
                        successtoast('Berhasil Mengupdate Data Disiplin Kerja')
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
<?php } else { ?>
    <div class="col-lg-12 text-center">
        <h5><i class="fa fa-exclamation"></i> DATA TIDAK DITEMUKAN. HARAP MENGHUBUNGI ADMINISTRATOR</h5>
    </div>
<?php } ?> 