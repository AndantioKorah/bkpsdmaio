<style>
  .label_filename, .value_filename, .label_loading{
    font-weight: bold;
  }

  .lable_filename{
    font-size: 1rem;
    color: grey;
  }

  .value_filename{
    font-size: 1.5rem;
    color: black;
    word-wrap: break-word;
  }

  .label_loading{
    font-size: 1rem;
    color: black;
  }
</style>

<div class="row" style="margin-top: -20px;">
  <div class="col-lg-12 text-center">
    <span class="label_filename">NAMA FILE:</span><br>
    <span class="value_filename"><?=$filename?></span><br>
    <span class="label_loading"><i class="fa fa-spin fa-spinner"></i> Mohon menunggu, proses verifikasi sedang berlangsung...</span>
  </div>
  <div class="col-lg-12 text-center" id="result">
  </div>
</div>
<script>
  $(function(){
    verifPdf()
  })

  function verifPdf(){
    // $('#result').html('')
    // // $('#result').append(divloadernavy)
    // $('#result').load('<?=base_url("kepegawaian/C_VerifTte/verifByFilePath/".$filepath)?>', function(){
    //   $('.label_loading').hide()
    //   $('#loader').hide()
    // })

    $.ajax({
        url: '<?=base_url("kepegawaian/C_VerifTte/verifByFilePath")?>',
        method: 'post',
        data: {
          filepath: '<?=$filepath?>'
        },
        success: function(data){
          $('.label_loading').hide()
          $('#result').html('')
          $('#result').append(data)
        }, error: function(e){
            alert('Terjadi Kesalahan')
        }
    })   
  }
</script>