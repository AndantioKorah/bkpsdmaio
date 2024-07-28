<?php if($result){ ?>
    <div class="row p-3">
        <div class="col-lg-12 form-group">
            <form id="form_submit_edit">
                <div class="row">
                    <div class="col-lg-12">
                        <label>NAMA JABATAN SILADEN</label><br>
                        <label style="font-weight: bold; font-size: 1.5rem;"><?=$result['nama_jabatan']?></label>
                        <input class="form-control" value="<?=$result['id_jabatanpeg']?>" name="id_jabatanpeg" style="display: none;" />
                    </div>
                    <div class="col-lg-12"><hr></div>
                    <div class="col-lg-12">
                        <label>JABATAN SIASN</label>
                        <!-- <select class="form-control select2-navy" style="width: 100%;"
                            id="id_jabatan_siasn" data-dropdown-css-class="select2-navy" name="id_jabatan_siasn">
                            <?php if($list_jabatan_siasn){
                                foreach($list_jabatan_siasn as $ljs){
                                ?>
                                <option <?=$ljs['id'] == $result['id_jabatan_siasn'] ? 'selected' : '';?> value="<?=$ljs['id']?>">
                                    <?=$ljs['nama_jabatan_siasn']?>
                                </option>
                            <?php } } ?>
                        </select> -->
                       	<!-- Select Element -->
                        <select class="form-control select2-navy" id='selJabatan'>
                            <option value='0'>-- Pilih Jabatan --</option>
                        </select>
                    </div>
                    <div class="col-lg-12 mt-3 text-right">
                        <button class="btn btn-navy btn-block" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php } else { ?>
    <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
<?php } ?>
<script>
    $(function(){
        // $('#id_jabatan_siasn').select2()

        $("#selJabatan").select2({
			  	ajax: { 
			   		url: '<?= base_url()?>master/C_Master/getRefJabatanFungsional',
			   		type: "post",
			   		dataType: 'json',
			   		delay: 250,
			   		data: function (params) {
			    		return {
			      			searchTerm: params.term // search term
			    		};
			   		},
			   		processResults: function (response) {
			     		return {
			        		results: response
			     		};
			   		},
			   		cache: true
			  	},
				  minimumInputLength: 3

			});

    })

    // $('#form_submit_edit').on('submit', function(e){
    //     e.preventDefault()
    //     $.ajax({
    //         url: '<?=base_url("master/C_Master/saveEditMappingUnor/")?>',
    //         method: 'post',
    //         data: $(this).serialize(),
    //         success: function(data){
    //             let rs = JSON.parse(data)
    //             successtoast('Edit Berhasil')
    //             $('#modal_edit_unor').modal('hide')
    //         }, error: function(e){
    //             errortoast('Terjadi Kesalahan')
    //         }
    //     })
    // })
</script>