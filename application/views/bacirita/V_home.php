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
		

	 .myButton {
		background-color: #222e3c; /* Normal background color */
		border: 1px solid #000000;  /* The main border property */
		
		color: #fff;
		padding: 5px 22px;
		text-align: center;
		text-decoration: none;
		/* display: inline-block; */
		font-size: 13px;
		margin: 4px 2px;
		cursor: pointer; /* Changes cursor to a hand pointer */
		transition-duration: 0.4s; /* Smooth transition over 0.4 seconds */
		border-radius: 5px;   
		}

		.myButton:hover {
		background-color: #127cd4;
		color:#fff; /* Green background on hover */
		}
</style>

<div class="mt-3 card card-default">
	<div class="card-body">
		<div class="row">
			<div class="col-lg-12">

				<h4><button onclick="loadListKegiatan(1)" class="myButton">Semua Webinar</button>
				<button onclick="loadListKegiatan(2)" class="myButton">Diikuti</button></h4>

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
		loadListKegiatan('0')
	})

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

	function loadListKegiatan(id){
		$('#div_list_kegiatan').html()
		$('#div_list_kegiatan').append(divLoaderNavy)
		$('#div_list_kegiatan').load('<?=base_url("bacirita/C_Bacirita/loadListWebinar/")?>'+id, function(){
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