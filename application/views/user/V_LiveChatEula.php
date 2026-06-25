<style>
    .p_point{
        font-size: 1rem;
        font-weight: bold;
    }

    .p_content{
        font-size: .7rem;
        font-weight: 600;
        margin-top: -15px;
        color: #3c3c3c;
        margin-left: 10px;
    }

    .p_content::before {
        content: "";
        width: 6px;         /* Width of the circle */
        height: 6px;        /* Height of the circle */
        background-color: #3c3c3c; /* Color of the circle */
        border-radius: 50%;  /* Makes the square element a perfect circle */
        display: inline-block;
        flex-shrink: 0;      /* Prevents the circle from squeezing on small screens */
        margin-right: 5px;
    }
</style>
<div class="row" style="
        max-height: 40vh;
        overflow-y: auto;
    ">
    <div class="col-lg-12 pt-2">
        <p><b>Selamat datang di Fitur OKTA (Online Konsultasi ASN)</b><br>Fitur ini disediakan untuk memfasilitasi komunikasi dan koordinasi pegawai. Dengan menggunakan fitur ini, Anda selaku Pegawai/Pengguna menyatakan bahwa Anda telah membaca, memahami, dan menyetujui seluruh aturan dan ketentuan yang berlaku di bawah ini.</p>

        <p class="p_point">1. Batasan Sesi Konsultasi Aktif</p>
        <p class="p_content">Setiap pegawai hanya diperbolehkan memiliki 1 (satu) sesi konsultasi yang aktif dalam satu waktu.</p>
        <p class="p_content">Pegawai tidak dapat membuat atau membuka sesi konsultasi baru jika masih memiliki sesi konsultasi lain yang belum diselesaikan (belum berakhir dan belum diberikan penilaian).</p>

        <p class="p_point">2. Ketentuan Pembukaan Sesi Baru</p>
        <p class="p_content">Untuk dapat membuat sesi konsultasi baru, pegawai wajib mengakhiri sesi konsultasi sebelumnya.</p>
        <p class="p_content">Pegawai diharuskan memberikan penilaian atas sesi konsultasi terdahulu sebelum sistem mengizinkan pembuatan sesi konsultasi yang baru.</p>

        <p class="p_point">3. Jam Operasional Layanan</p>
        <p class="p_content">Fitur OKTA memiliki batas waktu operasional harian yang terikat dengan jam kerja resmi:</p>
        <p class="p_content">Sesi konsultasi baru hanya dapat dibuka paling cepat 60 menit setelah jam masuk kerja.</p>
        <p class="p_content">Sesi konsultasi akan otomatis ditutup dan tidak dapat dibuka kembali 60 menit sebelum jam pulang kerja.</p>

        <p class="p_point">4. Kebijakan Keamanan Data dan Lampiran</p>
        <p class="p_content">Demi menjaga kapasitas penyimpanan dan keamanan data, sistem menerapkan kebijakan penghapusan otomatis (auto-purge).</p>
        <p class="p_content">Setiap dokumen, berkas (file), dan gambar yang dikirimkan di dalam percakapan sesi konsultasi akan dihapus secara permanen oleh sistem paling lambat 3x24 jam setelah file tersebut dikirim.</p>
        <p class="p_content">Pegawai diimbau untuk mengunduh dan menyimpan dokumen penting secara mandiri sebelum batas waktu tersebut.</p>

        <p class="p_point">5. Penutupan Sesi Otomatis (Idle Timeout)</p>
        <p class="p_content">Sesi konsultasi menuntut keaktifan dari kedua belah pihak.</p>
        <p class="p_content">Jika pegawai tidak mengirimkan balasan atau pesan baru dalam percakapan selama maksimal 30 menit, sistem akan menganggap sesi tersebut tidak aktif dan akan mengakhiri sesi konsultasi secara otomatis.</p>

        <p class="p_point">Pernyataan Persetujuan:<br>
        Dengan ini Saya, <?=getNamaPegawaiFull($this->general_library->getUserLoggedIn())?>, menyetujui dan tunduk pada seluruh ketentuan di atas. Pelanggaran atau penyalahgunaan terhadap fitur ini dapat ditindaklanjuti sesuai dengan kebijakan internal Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota Manado.</p>
    </div>
    <div class="col-lg-12 mt-2">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6 text-left">
                <div class="form-check" style="cursor: pointer;">
                    <input style="cursor: pointer;" class="form-check-input" type="checkbox" id="checkbox_eula_agree">
                    <label style="cursor: pointer;" class="form-check-label" for="checkbox_eula_agree">Ya, Saya setuju</label>
                </div>
            </div>
            <div class="col-lg-6 text-right">
                <button id="btn_eula_agree" disabled class="btn btn-navy btn-block" type="button">Lanjutkan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#checkbox_eula_agree').on('change', function(){
        if($(this).is(':checked')){
            $('#btn_eula_agree').prop("disabled", false);
        } else {
            $('#btn_eula_agree').prop("disabled", true);
        }
    })

    $('#btn_eula_agree').on('click', function(){
        $.ajax({
            url: '<?=base_url("user/C_User/liveChatEulaAgree")?>',
            method: 'post',
            data: null,
            success: function(data){
                hidePopupLiveChat()
                loadRiwayatChat()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>