<div class="row">
    <div class="col-12">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td style="font-weight: bold;"><?=getNamaPegawaiFull($pegawai)?></td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td style="font-weight: bold;"><?=formatNip($pegawai['nipbaru'])?></td>
                </tr>
                <tr>
                    <td>Pangkat</td>
                    <td>:</td>
                    <td style="font-weight: bold;"><?=$pegawai['nm_pangkat']?></td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td style="font-weight: bold;"><?=$pegawai['nama_jabatan']?></td>
                </tr>
            </thead>
        </table>
        <hr>
        <?php if($result) { ?><?php } ?>
        <form id="form_nilai_komponen">
            <input style="display: none;" name="id_m_user" value="<?=$pegawai['id_m_user']?>" />
            <input style="display: none;" name="tahun" value="<?=$tahun?>" />
            <input style="display: none;" name="bulan" value="<?=$bulan?>" />
            <input style="display: none;" name="id_t_komponen_kinerja" value="<?=$result ? $result['id_t_komponen_kinerja'] : null ?>" />
           
            <table border="1" style="width: 100%;" class="table table-hover table-striped">
            <tr>
                    <td style="padding: 5px; font-weight: bold; width: 5%; text-align: center;">NO</td>
                    <td style="padding: 5px; font-weight: bold; width: 70%; text-align: center;">KOMPONEN KINERJA</td>
                    <td style="padding: 5px; font-weight: bold; width: 25%; text-align: center;">NILAI</td>
                </tr>
            <!-- baru -->
             <?php $no=1; 
           foreach($list_perilaku_kerja as $lp){ ?>
           <?php $name = $lp['name_id']; ?>
            <tr>
                    <td style="text-align: center; padding: 5px;"><b><?=$no++;?></b></td>
                    <td style="padding: 5px;"><b><?=$lp['nama_perilaku_kerja']?></b>
                    <td><input oninput="countNilaiKomponen()"  type="number" id="<?=$lp['name_id'];?>" class="form-control form-control-sm" name="<?=$lp['name_id'];?>" value="<?=$result ? $result[$name] : 97; ?>" max="100" /> </td>
                     <!-- <?php foreach($lp['sub_perilaku_kerja'] as $sp){ ?>
                        <tr rowspan="3">
                            <td></td>
                            <td><?=$sp['nama_sub_perilaku_kerja'];?></td>
                            <td>
                            <input  type="hidden" class="form-control form-control-sm" name="id_m_sub_perilaku_kerja[]" value="<?=$sp['id_m_sub_perilaku_kerja'];?>"  /> 
                                <input  oninput="countNilaiKomponen()" type="number" id="<?=$sp['name_id'];?>" class="form-control form-control-sm hsl" name="nilai[]" max="100"  value="<?=$sp['nilai'] ? $sp['nilai'] : '' ?>"/> </td>
                        </tr>
                        <?php } ?>  -->
             
                    </td>
                </tr>
            <?php } ?> 
            <!-- baru -->

                <!-- <tr>
                    <td style="text-align: center; padding: 5px;">1</td>
                    <td style="padding: 5px;">Berorientasi Pelayanan</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="efektivitas_input" class="form-control form-control-sm"
                    name="efektivitas" max="100" value="<?=$result ? $result['berorientasi_pelayanan'] : 97;?>" /></td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 5px;">2</td>
                    <td style="padding: 5px;">Akuntabe</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="efisiensi_input" class="form-control form-control-sm"
                    name="efisiensi" max="100" value="<?= $result ? $result['akuntabel'] : 97; ?>" /></td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 5px;">3</td>
                    <td style="padding: 5px;">Kompeten</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="inovasi_input" class="form-control form-control-sm"
                    name="inovasi" max="100" value="<?=$result ? $result['kompeten'] : 97;?>" /></td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 5px;">4</td>
                    <td style="padding: 5px;">Harmonis</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="kerjasama_input" class="form-control form-control-sm"
                    name="kerjasama" max="100" value="<?=$result ? $result['harmonis'] : 97;?>" /></td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 5px;">5</td>
                    <td style="padding: 5px;">Loyal</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="kecepatan_input" class="form-control form-control-sm"
                    name="kecepatan" max="100" value="<?=$result ? $result['loyal'] : 97;?>" /></td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 5px;">6</td>
                    <td style="padding: 5px;">Adaptif</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="tanggungjawab_input" class="form-control form-control-sm"
                    name="tanggungjawab" max="100" value="<?=$result ? $result['adaptif'] : 97;?>" /></td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 5px;">7</td>
                    <td style="padding: 5px;">Kolaboratif</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="ketaatan_input" class="form-control form-control-sm"
                    name="ketaatan" value="<?=$result ? $result['kolaboratif'] : 97;?>" /></td>
                </tr>  -->
                <tr>
                    <td colspan=2 style="padding: 5px; text-align: right;"><strong>JUMLAH NILAI CAPAIAN</strong></td>
                    <td class="text-center" style="padding: 5px;"><span style="font-weight:bold; font-size: 20px;" id="capaian"></span> <input type="hidden" name="nilai_capaian" id="nilai_capaian"> </td>
                </tr>
                <tr>
                    <td colspan=2 style="padding: 5px; text-align: right;"><i>HASIL PEMBOBOTAN</i></td>
                    <td class="text-center" style="padding: 5px;"><i><span style="font-weight:bold; font-size: 18px;" id="bobot"></span></i> <input type="hidden" name="nilai_bobot"  id="nilai_bobot"></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php if($result){ ?>
                            <button type="button" id="btn_delete" onclick="deleteNilai('<?=$result['id']?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus Nilai Komponen</button>
                            <button id="btn_loading_delete" style="display: none;" disabled class="btn btn-sm btn-danger"><i class="fa fa-spin fa-spinner"></i> Menyimpan....</button>
                        <?php } ?>
                        <button id="btn_submit" type="submit" class="float-right text-right btn btn-sm btn-navy"><i class="fa fa-save"></i> Simpan Nilai Komponen</button>
                        <button id="btn_loading" style="display: none;" disabled class="float-right text-right btn btn-sm btn-navy"><i class="fa fa-spin fa-spinner"></i> Menyimpan....</button>
                    </td>
                </tr>
            </table>
        </form>  
    </div>
</div>
<script>
    $(function(){
        countNilaiKomponen()
    })

    function countNilaiKomponen(){
        let nilaiDefault = 97;
      
    //    for (x = 0; x <= 21; x++) {
    //     if($('#sub_perilaku_'+x).val() == ""){
    //         $('#sub_perilaku_'+x).val(nilaiDefault)
    //     }
    //     }
       
       

        const toFixedWithoutZeros = (num, precision) =>
        `${1 * num.toFixed(precision)}`;

      
        // let perilaku1 = parseInt($('#sub_perilaku_1').val())
        //             + parseInt($('#sub_perilaku_2').val())
        //             + parseInt($('#sub_perilaku_3').val())
        // let total_perilaku1 = perilaku1 / 3;
        // let perilaku_1 = parseFloat(total_perilaku1.toFixed(2))
        // $('#perilaku_1').val(perilaku_1)
        

        // let perilaku2 = parseInt($('#sub_perilaku_4').val())
        //             + parseInt($('#sub_perilaku_5').val())
        //             + parseInt($('#sub_perilaku_6').val())
        // let total_perilaku2 = perilaku2 / 3;
        // let perilaku_2 = parseFloat(total_perilaku2.toFixed(2)) 
        // $('#perilaku_2').val(perilaku_2)

        // let perilaku3 = parseInt($('#sub_perilaku_7').val())
        //             + parseInt($('#sub_perilaku_8').val())
        //             + parseInt($('#sub_perilaku_9').val())
        // let total_perilaku3 = perilaku3 / 3;
        // let perilaku_3 = parseFloat(total_perilaku3.toFixed(2)) 
        // $('#perilaku_3').val(perilaku_2)

        // let perilaku4 = parseInt($('#sub_perilaku_10').val())
        //             + parseInt($('#sub_perilaku_11').val())
        //             + parseInt($('#sub_perilaku_12').val())
        // let total_perilaku4 = perilaku4 / 3;
        // let perilaku_4 = parseFloat(total_perilaku4.toFixed(2)) 
        // $('#perilaku_4').val(perilaku_4)

        // let perilaku5 = parseInt($('#sub_perilaku_13').val())
        //             + parseInt($('#sub_perilaku_14').val())
        //             + parseInt($('#sub_perilaku_15').val())
        // let total_perilaku5 = perilaku5 / 3;
        // let perilaku_5 = parseFloat(total_perilaku5.toFixed(2)) 
        // $('#perilaku_5').val(perilaku_5)

        // let perilaku6 = parseInt($('#sub_perilaku_16').val())
        //             + parseInt($('#sub_perilaku_17').val())
        //             + parseInt($('#sub_perilaku_18').val())
        // let total_perilaku6 = perilaku6 / 3;
        // let perilaku_6 = parseFloat(total_perilaku6.toFixed(2))
        // $('#perilaku_6').val(perilaku_6)

        // let perilaku7 = parseInt($('#sub_perilaku_19').val())
        //             + parseInt($('#sub_perilaku_20').val())
        //             + parseInt($('#sub_perilaku_21').val())
        // let total_perilaku7 = perilaku7 / 3;
        // let perilaku_7 = parseFloat(total_perilaku7.toFixed(2))
        // $('#perilaku_7').val(perilaku_7)
        


        let capaian = parseFloat($('#perilaku_1').val())
                    + parseFloat($('#perilaku_2').val())
                    + parseFloat($('#perilaku_3').val())
                    + parseFloat($('#perilaku_4').val())
                    + parseFloat($('#perilaku_5').val())
                    + parseFloat($('#perilaku_6').val())
                    + parseFloat($('#perilaku_7').val())

        // $('#capaian').html(capaian.toFixed(2))
        // $('#nilai_capaian').val(capaian.toFixed(2))

        $('#capaian').html(toFixedWithoutZeros(capaian, 2))
        $('#nilai_capaian').val(toFixedWithoutZeros(capaian, 2))
        
        $('#nilai_bobot').val(countBobotNilaiKomponenKinerja(capaian).toFixed(2))
        $('#bobot').html(countBobotNilaiKomponenKinerja(capaian).toFixed(2)+'%')
    }

    function deleteNilai(id){
        if (confirm('Apakah Anda yakin ingin menghapus data?')){
            $('#btn_delete').hide()
            $('#btn_loading_delete').show()
            $.ajax({
                url: '<?=base_url("kinerja/C_Kinerja/deleteNilaiKomponen")?>'+'/'+id,
                method: 'post',
                data: null,
                success: function(data){
                    let res = JSON.parse(data)
                    if(res.code != 0){
                        errortoast(res.message)
                    } else {
                        successtoast('Data berhasil dihapus')
                        $('#capaian_<?=$pegawai['id_m_user']?>').html('')
                        $('#pembobotan_<?=$pegawai['id_m_user']?>').html('')
                        $('#btn_delete_'+id).hide()
                        $('#btn_loading_delete').hide()
                    }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }

    $('#form_nilai_komponen').on('submit', function(e){
        // $('#btn_submit').hide()
        // $('#btn_loading').show()
        e.preventDefault()
        var count_data = 0;
        $('.hsl').each(function(){
        count_data = count_data + 1;
        });
   
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/saveNilaiKomponenKinerja")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let res = JSON.parse(data)
                if(res.code != 0){
                    errortoast(res.message)
                } else {
                    successtoast('Data berhasil disimpan')
                    // $('#capaian_<?=$pegawai['id_m_user']?>').html(res.data.capaian)
                    // $('#pembobotan_<?=$pegawai['id_m_user']?>').html(countBobotNilaiKomponenKinerja(res.data.capaian).toFixed(2)+'%')
                    const myTimeout = setTimeout(sukses, 500);
                    $('#btn_submit').show()
                    $('#btn_loading').hide()
                    $('#modal_edit_data_nilai').modal('hide')
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function sukses(){
        $('#form_search_komponen_kinerja').submit()
    }
</script>