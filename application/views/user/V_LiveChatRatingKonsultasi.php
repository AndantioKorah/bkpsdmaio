<style>
    .lbl-main{
        font-size: 1.2rem;
        color: black;
        font-weight: bold;
        margin-top: 1rem;
    }

    .lbl-sec{
        font-size: .75rem;
        color: grey;
        font-weight: 450;
        font-style: italic;
    }
</style>
<div class="col-lg-12 text-center" style="
    height: 85vh;
    background-color: white;
    padding: 10px;
">
    <span style="cursor:pointer;" class="sp_chat_id_chatkonsul" onclick="backToStartView()"><i class="fa fa-chevron-left"></i></span>
    <?php if($result){ ?>
        <h6>Berikan Penilaian Anda:</h6>
        <strong><h3 style="font-weight: bold;">#<?=$result['chat_id']?></h3></strong>
        <div class="row">
            <div class="col-lg-12 text-center">
                <form id="form-rating" method="post" enctype="multipart/form-data">
                    <label class="lbl-main">Waktu Respon</label><br>
                    <label class="lbl-sec">(kecepatan balasan yang diterima)</label><br>
                    <?php $this->load->view('user/V_Rating', [
                        'data' => [
                            'skala' => 5,
                            'name' => 'rating_kecepatan'
                        ]
                    ]) ?>
                    <label class="lbl-main">Ketepatan Informasi</label><br>
                    <label class="lbl-sec">(informasi yang didapat sudah jelas dan tepat)</label><br>
                    <?php $this->load->view('user/V_Rating', [
                        'data' => [
                            'skala' => 5,
                            'name' => 'rating_ketepatan'
                        ]
                    ]) ?>
                    <label class="lbl-main">Kritik & Saran</label><br>
                    <label class="lbl-sec">(berikan komentar Anda untuk kami)</label>
                    <textarea rows=3 name="kritik_saran" style="
                        width: 100%;
                        resize: none;
                        border-radius: 10px;
                        padding: 5px;
                        border-color: grey;
                    "></textarea>
                    <button type="submit" style="width: 100%;" class="mt-4 btn btn-submit btn-navy">Submit Penilaian</button>
                </form>
            </div>
        </div>
    <?php } else { ?>
        <h4 style="color: red;"><i class="fa fa-exclamation"></i> Terjadi Kesalahan</h4>
    <?php } ?>
</div>
<script>
    $('#form-rating').on('submit', function(e){
        e.preventDefault()
        // $('#btn-submit').prop('disabled', true)
        // $('#btn-submit').text('<i class="fa fa-spin fa-spinner"></i>')
        var formvalue = $('#form-rating');
        var form_data = new FormData(formvalue[0]);
        $.ajax({
            url: '<?=base_url("user/C_User/submitRatingKonsultasi/".$result['id'])?>',
            method: 'post',
            data: form_data,
            contentType: false,  
            cache: false,  
            processData:false,
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 1){
                    errortoast(rs.message)
                } else {
                    successtoast('Terima Kasih atas penilaian yang telah Anda berikan')
                    backToStartView()
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>