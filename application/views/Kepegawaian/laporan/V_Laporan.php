
 <style>
   table {
      /* font-size: 14px;  */
    }
 </style>

  <div class="row">
 	<div class="col-lg-12">
 		<div class="card card-default">
 			<div class="row p-3">
 				<div class="col-md-12 col-sm-12">
                <form id="form_search">
				 <select class="form-control select2-navy" 
                                    id="jenis_laporan" data-dropdown-css-class="select2-navy" name="jenis_laporan" required>
									<option value="" selected disabled>Pilih Jenis Laporan</option>
                                    <option value="0">Semua Jenis Laporan</option>
									<option value="7">Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Unit Kerja</option>
									<option value="6">Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Jabatan</option>
									<option value="9">Jumlah Pegawai Negeri Sipil (PNS) Pemerintah Kota Manado Menurut Jabatan</option>
									<option value="10">Jumlah Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Pemerintah Kota Manado Menurut Jabatan</option>
                                    <option value="1">Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Pangkat/Golongan</option>
									<option value="2">Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Tingkat Pendidikan</option>
									<option value="3">Jumlah Pegawai Negeri Sipil (PNS) Pemerintah Kota Manado Menurut Tingkat Pendidikan</option>
									<option value="4">Jumlah Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Pemerintah Kota Manado Menurut Tingkat Pendidikan</option>
									<option value="5">Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado per Kecamatan</option>
									<option value="8">Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Sesuai Jenis Jabatan Per Unit Kerja</option>

                </select>
			    </div>
				<div class="col-md-12 col-sm-12 mt-2 ">
				<button id="btn_search" type="submit" class="btn btn-navy float-right"><i class="fa fa-search"></i> Cari</button>
                 <button style="display:none;" id="btn_loading" disabled type="button" class="btn btn-navy float-right"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
            </div>
                </form>
		    </div>
	   </div>
    </div>
  </div>

  <div id="div_result">

  </div>

<script>
	    $(document).ready( function() {
			// $('.datatable').dataTable()
  $('.select2-navy').select2()
          var table = $('.datatable').DataTable({
           "pageLength": 25,
        //    dom: 'Bfrtip',
           buttons: [
                {
                    extend: 'excel',
                    orientation: 'landscape',
                    title: 'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Tingkat Pendidikan',
                    // messageTop:
                    //     'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Tingkat Pendidikan'
                },
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    title: 'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Tingkat Pendidikan'
                }
           ],
        });

		} )

$('#form_search').on('submit', function(e){
        $('#div_result').html('')
        $('#div_result').append(divLoaderNavy)

        $('#btn_loading').show()
        $('#btn_search').hide()
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("kepegawaian/C_Kepegawaian/laporanJumlahASN/")?>',
            method: 'post',
            data: {
                jenis_laporan: $('#jenis_laporan').val()
            },
            success: function(data){
                $('#div_result').html('')
                $('#div_result').append(data)

                $('#btn_loading').hide()
                $('#btn_search').show()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
                $('#btn_loading').hide()
                $('#btn_search').show()
            }
        })
    })

</script>