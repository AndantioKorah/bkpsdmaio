<style>
    .div_operator{
        overflow-y: auto;
        max-height: 55vh;
    }

    .div_operator_item{
        border: 1px solid grey;
        padding: 5px;
        border-radius: 5px;
    }

    .div_operator_item:hover{
        cursor: pointer;
        background-color: #e9e9e9;
        transition: .2s;
    }
</style>
<div class="col-lg-2 col-md-2 col-sm-2">
    <i style="cursor: pointer;" id="btn_back_assign_operator" class="fa fa-chevron-left"></i>
</div>
<div class="col-lg-8 col-md-8 col-sm-8 text-center">
    <h3>Pilih Operator</h3>
</div>
<div class="col-lg-2 col-md-2 col-sm-2"></div>
<div class="col-lg-12 mt-2">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default" style="font-size: 1.5rem;"><i class="fa fa-search"></i></span>
        </div>
        <input id="input_search_list_operator" oninput=searchListOperator() type="text" id="input_search_operator" class="form-control form-control-sm" aria-label="Default" aria-describedby="inputGroup-sizing-default">
    </div>
</div>
<?php if($list_operator){ ?>
    <div class="div_operator col-lg-12" id="list_operator_all">
        <div class="row p-3">
            <?php foreach($list_operator as $lo){ ?>
                <div id="div_operator_item_<?=$lo['id_m_user']?>" onclick="openOption('<?=$lo['id_m_user']?>')" class="col-lg-12 mt-1 text-left div_operator_item">
                    <span style="
                        font-weight: bold;
                        color: black;
                        font-size: .8rem;
                    "><?=getNamaPegawaiFull($lo, 1)?></span>
                    <div style="display: none;" class="col-lg-12 text-right div_option_operator div_option_operator_<?=$lo['id_m_user']?>">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 text-rigt">
                                <p style="margin-top: 5px; color: orange; font-weight: bold; font-size: .65rem;">Apakah Anda yakin?</p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 text-right">
                                <button onclick="assignOperator('1', '<?=$lo['id_m_user']?>')" class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>
                                <button onclick="assignOperator('0', '<?=$lo['id_m_user']?>')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="div_operator col-lg-12" id="list_operator_search" style="display: none;">

    </div>
<?php } ?>
    
<script>
    $(function(){
        $('#form_send_message').hide()
    })

    function openOption(id){
        $('.div_option_operator').hide()
        $('.div_option_operator_'+id).show()
    }

    function assignOperator(state, id){
        if(state == 0){
            $('.div_option_operator').hide()
            return false
        }
        $.ajax({
            url: '<?=base_url("user/C_User/assignOperator")?>',
            method: 'post',
            data: {
                'id_m_user' : id,
                'id_t_live_chat' : '<?=$id?>'
            },
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    successtoast('Berhasil assign operator')
                    $('#btn_back_assign_operator').click()
                } else {
                    errortoast(rs.message)
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    function searchListOperator(){
        $.ajax({
            url: '<?=base_url("user/C_User/searchListOperator")?>',
            method: 'post',
            data: {
                'all_list' : '<?=json_encode($list_operator)?>',
                'search': $('#input_search_list_operator').val()
            },
            success: function(data){
                if($('#input_search_list_operator').val() == ""){
                    $('#list_operator_all').show()
                    $('#list_operator_search').hide()
                } else {
                    $('#list_operator_all').hide('')
                    $('#list_operator_search').html('')
                    $('#list_operator_search').show()
                    $('#list_operator_search').append(data)   
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    $('#input_search_list_operator').on('focus', function(){
        if($(this).val() == ""){
            $('#list_operator_all').show()
            $('#list_operator_search').hide()
        } else {
            searchListOperator() 
        }
    })

    $('#btn_back_assign_operator').on('click', function(){
        $('#div_live_chat_container').show()
        $('#div_assign_operator').hide()
    })
</script>