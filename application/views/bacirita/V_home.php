<style>
	.lbl-form-input-kegiatan{
		font-size: .8rem;
		color: grey;
		font-weight: bold;
		font-style: italic;
	}

	.lbl-form-divider{
		font-size: .9rem;
		color: black;
		font-weight: bold;
	}

	.tab-webinar{
		font-size: .85rem;
		border: 1px solid var(--primary-color);
		padding: 5px;
		border-radius: 10px;
		background-color: ghostwhite;
		font-weight: 600;
		color: var(--primary-color);
		cursor: pointer;
	}

	.tab-webinar-active{
		background-color: var(--primary-color) !important;
		font-weight: bold !important;
		color: ghostwhite !important;
	}
</style>

<div class="mt-3 card card-default">
	<div class="card-body">
		<div class="row">
			<div class="col-lg-12">
				<span id="tab-webinar-all" onclick="filterWebinar('all')" class="tab-webinar tab-webinar-active">Semua Webinar</span>
				<span id="tab-webinar-personal" onclick="filterWebinar('personal')" class="tab-webinar">Webinar Saya</span>
				<hr>
			</div>
			<div id="div_list_kegiatan" class="col-lg-12">
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_detail_kegiatan" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" 
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">DETAIL KEGIATAN</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal_detail_kegiatan_content">
            </div>
        </div>
    </div>
  </div>
<script>
	$(function(){
		$('#tipe_kegiatan').select2()
		refreshDatePicker()
		loadListKegiatan('all')
	})

	function filterWebinar(tab){
		$('.tab-webinar').removeClass('tab-webinar-active')
		$('#tab-webinar-'+tab).addClass('tab-webinar-active')
		loadListKegiatan(tab)
	}

	function refreshDatePicker(){
		$('#tanggal').datepicker({
			format: 'yyyy-mm-dd',
			orientation: 'bottom',
			autoclose: true,
			todayBtn: true
		})

		$('#tanggal_batas_absensi').datepicker({
			format: 'yyyy-mm-dd',
			orientation: 'bottom',
			autoclose: true,
			// todayBtn: true,
			startDate: $('#tanggal').val()
		})

		$('#tanggal_batas_pendaftaran').datepicker({
			format: 'yyyy-mm-dd',
			orientation: 'bottom',
			autoclose: true,
			// todayBtn: true,
			endDate: $('#tanggal').val()
		})
	}

	function loadListKegiatan(tab){
		$('#div_list_kegiatan').html('')
		$('#div_list_kegiatan').append(divLoaderNavy)
		$('#div_list_kegiatan').load('<?=base_url("bacirita/C_Bacirita/loadListWebinar/")?>'+tab, function(){
			$('#loader').hide()
		})
	}

	$('#form_input_kegiatan').on('submit', function(e){
		e.preventDefault()
		// $('#btn_simpan').hide()
		// $('#btn_simpan_loading').show()
		var formvalue = $('#form_input_kegiatan');
		var form_data = new FormData(formvalue[0]);

		$.ajax({  
        url: '<?=base_url("bacirita/C_Bacirita/saveDataKegiatan")?>',
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        // dataType: "json",
           success: function(data){
                let resp = JSON.parse(data)
                if(resp.code == 0){
                    $('#topik').val('')
					$('#div_form_input_kegiatan').hide()
					successtoast('Data berhasil disimpan')
					loadListKegiatan()
                } else {
                    errortoast(resp.message)
                }
				$('#btn_simpan').show()
				$('#btn_simpan_loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
				$('#btn_simpan').show()
				$('#btn_simpan_loading').hide()
            }  
        });
	})
</script>