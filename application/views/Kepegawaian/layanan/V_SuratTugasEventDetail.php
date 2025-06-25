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
            <div class="col-lg-12 mt-2">
                <hr>
                <div class="row">
                    <div class="col-lg-4">
                        <h5>LIST PEGAWAI</h5>
                        <div class="row">
                            <div class="col-lg-12" style="max-height: 75vh; overflow-x: auto;" id="div_list_pegawai"></div>
                        </div>
                    </div>
                    <div class="col-lg-8"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            loadListPegawaiSTEvent()
        })

        function loadListPegawaiSTEvent(){
            $('#div_list_pegawai').html('')
            $('#div_list_pegawai').append(divLoaderNavy)
            $('#div_list_pegawai').load('<?=base_url("kepegawaian/C_Layanan/getListPegawaiEventDetail/".$result['data']['id_t_pegawai_event'])?>', function(){
                $('#loader').hide()
            })
        }
    </script>
<?php } ?>