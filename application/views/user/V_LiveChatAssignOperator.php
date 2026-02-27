<div class="col-lg-2 col-md-2 col-sm-2">
    <i style="cursor: pointer;" id="btn_back_assign_operator" class="fa fa-chevron-left"></i>
</div>
<div class="col-lg-8 col-md-8 col-sm-8 text-center">
    <h3>Pilih Operator</h3>
</div>
<div class="col-lg-2 col-md-2 col-sm-2"></div>
<div class="col-lg-12 mt-2">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa fa-search"></i></span>
        </div>
        <input oninput=searchListOperator() type="text" id="input_search_operator" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
    </div>
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm">Small</span>
        </div>
        <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
    </div>
</div>
<?php if($list_operator){ ?>
    <div class="col-lg-12 mt-2" id="list_operator">
    </div>
<?php } ?>
    
<script>
    function searchListOperator(){
        $.ajax({
            url: '<?=base_url("user/C_User/searchListOperator/".$id)?>',
            method: 'post',
            data: {
                'all_list' : '<?=json_encode($list_operator)?>',
                'search': $('#input_search_operator').val()
            },
            success: function(data){
               $('#list_operator').html('')
               $('#list_operator').append(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    $('#btn_back_assign_operator').on('click', function(){
        console.log('asd')
        $('#div_live_chat_container').show()
        $('#div_assign_operator').hide()
    })
</script>