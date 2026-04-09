<style>
    .jenis_layanan_item:hover{
        background-color: #dfdfdf;
        transition: .3s;
    }

    .pulse {
        background-color: white;
        /* name | duration | timing-function | iteration-count */
        animation: pulse-bg 5s ease-in-out;
    }

    @keyframes pulse-bg {
        0% { background-color: #ffffff; }
        10% { background-color: #f9f9a8; }
        25% { background-color: #fefe70; }
        50% { background-color: #f2f603; }
        75% { background-color: #fefe70; }
        90% { background-color: #f9f9a8; }
        100% { background-color: #ffffff; }
    }
</style>
<div class="row p-2">
    <?php if(isset($data['chat'])){ ?>
        <div class="col-lg-12">
            <span style="font-style: italic; font-weight: bold; font-size: .65rem">Jenis Layanan saat ini:</span><br>
            <span style="font-weight: bold; font-size: .85rem"><?=$data['chat']['nama_layanan']?></span>
        </div>
    <?php } ?>
    <form>
        <!-- <div class="col-lg-12">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default" style="font-size: 1.5rem;"><i class="fa fa-search"></i></span>
                </div>
                <input id="input_search" oninput=searchListJenisLayanan() type="text" class="form-control form-control-sm"
                    aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>
            <hr>
        </div> -->
        <div class="col-lg-12" style="
            padding: 5px;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: 40vh;
        ">
            <div class="row">
                <?php foreach($jenis_layanan as $jl){ ?>
                    <div class="col-lg-12 mt-2">
                        <span style="
                            color: grey;
                            font-weight: bold;
                            font-size: .65rem;
                            font-style: italic;
                            margin-top: 10px;
                        "><?=$jl['nama_bidang']?></span>
                        <div class="row">
                            <?php $i = 0; foreach($jl['layanan'] as $jll){
                                $i++;
                            ?>
                                <div class="col-lg-12" style="
                                    padding-left: 8px;
                                    padding-right: 8px;
                                ">
                                    <div class="jenis_layanan_item" onclick="openDivButton('<?=$jll['id']?>')" style="
                                        border: 1px solid black;
                                        border-radius: 5px;
                                        padding: 3px;
                                        cursor: pointer;
                                        margin-bottom: <?=$i != 0 ? "5px" : "0px"?>;
                                    ">
                                        <span style="
                                            color: black;
                                            font-size: .8rem;
                                            font-weight: bold;
                                        ">
                                            <?=$jll['nama_layanan']?>
                                        </span>
                                        <div style="
                                            display: none;
                                        " class="div_button div_button_<?=$jll['id']?>">
                                            <div class="row d-flex align-items-center">
                                                <div class="col-lg-8">
                                                    <span style="
                                                        color: red;
                                                        font-weight: bold;
                                                        font-size: .65rem;
                                                    ">Apakah Anda yakin?</span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <button type="button" onclick="openDivButton(0)" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    <button id="btn_save_<?=$jll['id']?>" type="button" onclick="submitGantiJenisLayanan('<?=$jll['id']?>')" class="btn btn-sm btn-success">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('#id_m_layanan_konsul').select2()
    })

    function openDivButton(id = 0){
        $('.div_button').hide()
        if(id != 0){
            $('.div_button_'+id).show()
        }
    }

    function submitGantiJenisLayanan(id){
        $('#btn_save_'+id).attr('disabled')
        $('#btn_save_'+id).html('<i class="fa fa-spin fa-spinner"></i>')
        $.ajax({
            url: '<?=base_url("user/C_User/submitGantiJenisLayanan/".$id)?>'+'/'+id,
            method: 'post',
            success: function(data){
                let resp = JSON.parse(data)
                if(resp.code == 0){
                    successtoast(resp.message)
                    hidePopupLiveChat()
                    <?php if($id != 0){ ?>
                        reloadLiveChatContainer(resp.id)
                    <?php } else { ?>
                        openKonsultasiDetail(resp.id)
                    <?php } ?>
                } else {
                    errortoast(resp.message)
                    $('#btn_save_'+id).prop('disabled', false);
                    $('#btn_save_'+id).html('<i class="fa fa-check"></i>');
                    hidePopupLiveChat()
                    console.log(resp.id)
                    $('.div_chat_item_'+resp.id).addClass('pulse')
                    
                    // if(resp.code == 2){
                    //     openKonsultasiDetail(resp.id)
                    // } else if(resp.code == 3){
                    //     $('#div_start_konsultasi').hide()
                    //     $('#div_chat_konsultasi').show()
                    //     $('#div_chat_konsultasi').html('')
                    //     $('#div_chat_konsultasi').append(divLoaderNavy)
                    //     $('#div_chat_konsultasi').load('<?=base_url('user/C_User/ratingKonsultasi/')?>'+resp.id, function(){
                    //         $('#loader').hide()
                    //     })
                    // }
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }
</script>