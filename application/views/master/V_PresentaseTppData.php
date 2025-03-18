<?php if($result){ ?>
    <h4><?=$result['unitkerja']['nm_unitkerja']?></h4>
    <hr>
    <table class="table table-hover table-striped table-sm">
        <thead>
            <!-- <th class="text-center">No</th> -->
            <th class="text-center">Kelas Jabatan</th>
            <th class="text-center">Prestasi Kerja</th>
            <th class="text-center">Beban Kerja</th>
            <th class="text-center">Kondisi Kerja</th>
            <th class="text-center">Total</th>
            <th class="text-center">Pilihan</th>
        </thead>
        <?php $no = 1; $i = 1; foreach($result['data'] as $rd){
            $total = formatTwoMaxDecimal($rd['prestasi_kerja'] + $rd['beban_kerja'] + $rd['kondisi_kerja']);
        ?>
            <form id="form_<?=$i?>">
                <tr>
                    <!-- <td class="text-center"><?=$no++;?></td> -->
                    <td class="text-center"><?=$rd['kelas_jabatan'].'  '.$rd['id']?></td>
                    <td class="">
                        <input class="form-control form-control-sm" value="<?=$rd['prestasi_kerja']?>" id="pk_val_<?=$i?>" name="pk_val_<?=$i?>" />
                    </td>
                    <td class="">
                        <input class="form-control form-control-sm" value="<?=$rd['beban_kerja']?>" id="bk_val_<?=$i?>" name="bk_val_<?=$i?>" />
                    </td>
                    <td class="">
                        <input class="form-control form-control-sm" value="<?=$rd['kondisi_kerja']?>" id="kk_val_<?=$i?>" name="kk_val_<?=$i?>" />
                    </td>
                    <td class="text-center"><span id="total_<?=$i?>"><?=$total == 0 ? "" : $total.' %'?></span></td>
                    <td class="text-center">
                        <button type="submit" onclick="saveForm('<?=$i?>')" class="btn btn-sm btn-navy"><i class="fa fa-save"></i> Simpan</button>
                    </td>
                </tr>
            </form>
        <?php $i++; } ?>
    </table>
    <script>
        function saveForm(kj){
            successtoast(kj)
            // $('#form_'+kj).on('submit', function(e){
                // e.preventDefault()
                $.ajax({
                    url: '<?=base_url("master/C_Master/savePresentaseTpp/".$result['unitkerja']['id_unitkerja'])?>',
                    method: 'post',
                    data: {
                        kelas_jabatan: kj,
                        prestasi_kerja: $('#pk_val_'+kj).val(),
                        beban_kerja: $('#bk_val_'+kj).val(),
                        kondisi_kerja: $('#kk_val_'+kj).val(),
                    },
                    success: function(data){
                        let resp = JSON.parse(data)
                        if(resp.code == 0){
                            successtoast('Data berhasil disimpan')
                            $('#total_'+kj).html(resp.data)
                        } else {
                            errortoast(resp.message)
                        }
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            // })
        }
    </script>
<?php } ?>