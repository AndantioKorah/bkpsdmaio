

	<!-- Select2 CSS -->
	<link href="<?= base_url() ?>assets/select2/dist/css/select2.min.css" rel="stylesheet" />

	<!-- jQuery library -->
	<script src="<?= base_url() ?>assets/jquery-3.3.1.min.js"></script>

	<!-- Select2 JS -->
	<script src="<?= base_url() ?>assets/select2/dist/js/select2.min.js"></script>
	


	<!-- Select Element -->
	<select id='selUser' style='width: 200px;'>
		<option value='0'>-- Select user --</option>
	</select>




<div class="card card-default">
    <div class="card-header">
        <h4>Penilaian Rekan Sejawat</h4>
    </div>
    <div class="card-body">
        <form id="form_search_komponen_kinerja" style="display:none">
            
            <div class="row">
           
                <?php if($this->general_library->getIdEselon() == 5){ ?>
                <div class="col-lg-3 col-md-12">
                    <div class="col">
                        <label class="bmd-label-floating">Filter</label>
                        <select class="form-control select2-navy" style="width: 100%"
                            id="filter" data-dropdown-css-class="select2-navy" name="filter">
                            <option value="0" selected>Semua Bidang/Bagian</option>
                            <option value="eselon_tiga">Eselon III</option>
                            <option value="eselon_empat">Eselon IV</option>
                            <?php if($list_bidang){ foreach($list_bidang as $lb){ ?>
                                <option value="<?=$lb['id']?>"><?=$lb['nama_bidang']?></option>
                            <?php } } ?>
                        </select>
                    </div>
                    </div>
                    <?php } else if($this->general_library->getIdEselon() == 4 || $this->general_library->isWalikota()) { ?>
                    <div class="col">
                        <label class="bmd-label-floating">Filter Berdasarkan</label>
                        <select class="form-control select2-navy" style="width: 100%"
                            id="filter_walikota" data-dropdown-css-class="select2-navy" name="filter_walikota">
                            <option value="skpd" selected>SKPD</option>
                            <option value="eselon_dua">Eselon II</option>
                            <option value="eselon_tiga">Eselon III</option>
                            <!-- <option value="eselon_empat">Eselon IV</option> -->
                            <!-- <option value="pegawai">Pegawai</option> -->
                        </select>
                    </div>
                    <div id="div_skpd" class="col">
                        <label class="bmd-label-floating">Pilih SKPD</label>
                        <select class="form-control select2-navy select2" style="width: 100%"
                            id="filter_skpd" data-dropdown-css-class="select2-navy" name="filter_skpd">
                            <?php foreach($list_skpd as $skpd){ ?>
                                <option value="<?=$skpd['id_unitkerja']?>"><?=$skpd['nm_unitkerja']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div id="div_pegawai" class="col" style="display: none;">
                        <label class="bmd-label-floating">NIP / Nama Pegawai</label>
                        <input class="form-control" name="nama_pegawai" />
                    </div>  
                <?php } ?>
               
                <div class="col-lg-3 col-md-12">
                    <label>Pilih Bulan</label>  
                    <select class="form-control select2-navy select2" style="width: 100%"
                        id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                        <option <?=date('m') == '01' ? 'selected' : ''?> value="01">Januari</option>
                        <option <?=date('m') == '02' ? 'selected' : ''?> value="02">Feburari</option>
                        <option <?=date('m') == '03' ? 'selected' : ''?> value="03">Maret</option>
                        <option <?=date('m') == '04' ? 'selected' : ''?> value="04">April</option>
                        <option <?=date('m') == '05' ? 'selected' : ''?> value="05">Mei</option>
                        <option <?=date('m') == '06' ? 'selected' : ''?> value="06">Juni</option>
                        <option <?=date('m') == '07' ? 'selected' : ''?> value="07">Juli</option>
                        <option <?=date('m') == '08' ? 'selected' : ''?> value="08">Agustus</option>
                        <option <?=date('m') == '09' ? 'selected' : ''?> value="09">September</option>
                        <option <?=date('m') == '10' ? 'selected' : ''?> value="10">Oktober</option>
                        <option <?=date('m') == '11' ? 'selected' : ''?> value="11">November</option>
                        <option <?=date('m') == '12' ? 'selected' : ''?> value="12">Desember</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-12">
                    <label>Pilih Tahun</label>  
                    <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                </div>
                <div class="col-lg-3 col-md-12" style="margin-top: 28px;">
                    <button type="submit" class="btn btn-block btn-navy"><i class="fa fa-file-export"></i> Submit</button>
                </div>
            </div>
        </form>
        <div id="result">
           
        </div>
    </div>
</div>

<div class="col-12 card card-default p-3" >
</div>

<script>
    $(function(){
        $('.select2').select2()
        $('#form_search_komponen_kinerja').submit() 

        $("#selUser").select2({
			  	ajax: { 
			   		url: '<?= base_url()?>simata/C_Simata/getJabatan',
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
				  minimumInputLength: 1

			});

        })

    $('#form_search_komponen_kinerja').submit(function(e){
        $('#result').show()
        $('#result').html('')
        $('#result').append(divLoaderNavy)
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("simata/C_Simata/loadPegawaiPenilaianSejawat")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#result').html('')
                $('#result').append(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $('#filter_walikota').on('change', function() {
    if( this.value != "skpd" ){
         $('#div_skpd').hide(); 
        } else {
        $('#div_skpd').show(); 
        }
    });
</script>