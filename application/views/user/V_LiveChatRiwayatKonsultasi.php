<?php if($result){ ?>
    <style>
        .sp_chat_id_rw_konsul{
            font-size: 1rem;
            color: black;
            font-weight: bold;
        }

        .sp_chat_id_rw_konsul_admin{
            font-size: .8rem !important;
        }

        .sp_last_chat_rw_konsul_admin{
            font-size: .65rem;
        }

        .sp_last_chat_rw_konsul{
            font-size: .8rem;
            color: grey;
            font-weight: bold;
            display: -webkit-box; /* Required for older browser compatibility */
            -webkit-box-orient: vertical; /* Required for older browser compatibility */
            -webkit-line-clamp: 1; /* Limits text to 3 lines */
            overflow: hidden;
            text-overflow: ellipsis; /* Ensures the ellipsis appears */
        }

        .sp_last_chat_date_rw_konsul{
            font-size: .65rem;
            color: grey;
            font-weight: bold;
        }

        .div_chat_konsul_item:hover{
            cursor: pointer;
            background-color: #f0f0f0;
        }

        .div_chat_konsul_item{
            border-bottom: 1px solid lightgrey;
        }

        .div_profil_live_chat{
            position: absolute;
            left: -255px;
            width: 250px;
            background-color: white;
            /* height: 300px; */
            border-radius: 10px;
            box-shadow: -3px 2px 18px 6px rgba(124,124,124,1);
            -webkit-box-shadow: -3px 2px 18px 6px rgba(124,124,124,1);
            -moz-box-shadow: -3px 2px 18px 6px rgba(124,124,124,1);
            padding: 10px;
            line-height: 15px;
            display: none;
        }

        .sp_profil_pegawai_live_chat{
            font-size: .65rem;
            color: grey;
            font-weight: bold;
        }

        .sp_profil_nama_pegawai_live_chat{
            font-size: .8rem;
            color: black;
            font-weight: bold;
        }
    </style>
    <div class="row">
        <?php foreach($result as $rs){
            $flagRead = 0; 
            if($this->general_library->isHakAkses('admin_live_chat_konsultasi')){
                $flagRead = $rs['flag_read_admin'];
            } else {
                $flagRead = $rs['flag_read_pegawai'];
            }
        ?>
            <?php if($this->general_library->isHakAkses('admin_live_chat_konsultasi')){ ?>
                <div class="div_profil_live_chat profile_chat_<?=$rs['id']?>">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <img id="search_profile_pic" style="
                                border-radius: 50% !important;
                                width: 30%;
                                aspect-ratio: 1;
                                object-fit: cover" class="img-fluid b-lazy"
                                    src="<?php
                                        $path = './assets/fotopeg/'.$rs['fotopeg'];
                                        // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                        if($rs['fotopeg']){
                                        if (file_exists($path)) {
                                        $src = './assets/fotopeg/'.$rs['fotopeg'];
                                        //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                        } else {
                                        $src = './assets/img/user.png';
                                        // $src = '../siladen/assets/img/user.png';
                                        }
                                        } else {
                                        $src = './assets/img/user.png';
                                        }
                                        echo base_url().$src;?>" /> 
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-1">
                            <span class="sp_profil_nama_pegawai_live_chat"><?=getNamaPegawaiFull($rs)?></span><br>
                            <span class="sp_profil_pegawai_live_chat"><?=($rs['nipbaru_ws'])?></span><br>
                            <span style="line-height: 10px !important;" class="sp_profil_pegawai_live_chat"><?=($rs['nama_jabatan'])?></span><br>
                            <span style="line-height: 10px !important;" class="sp_profil_pegawai_live_chat"><?=($rs['nm_unitkerja'])?></span>
                        </div>
                    </div>
                </div>
                <div onmouseover="onHoverChat('<?=$rs['id']?>')" id="div_chat_<?=$rs['id']?>" class="div_chat_konsul_item pt-2" onclick="openKonsultasiDetail('<?=$rs['id']?>')">
                    <div class="col-lg-12 text-left">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 15%;" rowspan=2>
                                    <img style="border-radius: 50% !important; width: 100%; aspect-ratio: 1; object-fit: cover" class="img-fluid b-lazy"
                                    src="<?php
                                        $path = './assets/fotopeg/'.$rs['fotopeg'];
                                        // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                        if($rs['fotopeg']){
                                        if (file_exists($path)) {
                                        $src = './assets/fotopeg/'.$rs['fotopeg'];
                                        //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                        } else {
                                        $src = './assets/img/user.png';
                                        // $src = '../siladen/assets/img/user.png';
                                        }
                                        } else {
                                        $src = './assets/img/user.png';
                                        }
                                        echo base_url().$src;?>" /> 
                                </td>
                                <td style="width: 80%;" rowspan=1>
                                    <div class="ml-2">
                                        <?php if($rs['flag_done'] == 0){ ?>
                                            <span><i style="font-size: .6rem; color: green;" class="fa fa-circle"></i></span>
                                        <?php } ?>
                                        <span class="sp_chat_id_rw_konsul sp_chat_id_rw_konsul_admin"><?=formatNamaPegawaiLiveChat($rs)?></span>
                                        <?php if($rs['pesan']){ ?>
                                            <div class="text-left">
                                                <label style="
                                                        color: <?=$flagRead == 0 ? '#e62329 !important' : 'grey'?>;
                                                        font-weight: <?=$flagRead == 0 ? '1000 !important' : 'normal'?>
                                                    " class="sp_last_chat_rw_konsul">
                                                    <?=$rs['pesan']?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td style="width: 5%;" rowspan=1>
                                    <i style="display: <?=$flagRead == 1 ? 'none' : 'block'?>; font-size: .6rem; color: #e62329;" class="fa fa-circle"></i>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-12 text-right">
                        <?php if($rs['pesan']){ ?>
                            <span class="sp_last_chat_date_rw_konsul"><?=formatDateNotifikasi($rs['last_message_date'], 0)?></span>
                        <?php } else { ?>
                            <span class="sp_last_chat_date_rw_konsul"><?=formatDateNotifikasi($rs['created_date'], 0)?></span>
                        <?php } ?>
                            | <span style="color: <?=$flagRead == 0 ? '#e62329 !important' : 'grey'?>" class="sp_last_chat_date_rw_konsul"><?=$rs['chat_id']?></span>
                    </div>
                </div> 
            <?php } else { ?> 
                <div class="div_chat_konsul_item pt-2" onclick="openKonsultasiDetail('<?=$rs['id']?>')">
                    <div class="col-lg-12 text-left">
                        <?php if($rs['flag_done'] == 0){ ?>
                            <span><i style="font-size: .75rem; color: green;" class="fa fa-circle"></i></span>
                        <?php } ?>
                        <span class="sp_chat_id_rw_konsul">#<?=$rs['chat_id']?></span>
                    </div>
                    <?php if($rs['pesan']){ ?>
                        <div class="col-lg-12 text-left" style="display: flex; align-items: center; gap: 5px;">
                            <i style="display: <?=$flagRead == 1 ? 'none' : 'block'?>; font-size: .75rem; color: #e62329;" class="fa fa-circle"></i>
                            <label class="sp_last_chat_rw_konsul">
                                <?=$rs['pesan']?>
                            </label>
                        </div>
                        <div class="col-lg-12 text-right">
                            <span style="color: <?=$flagRead == 1 ? "grey" : "#e62329" ?>" class="sp_last_chat_date_rw_konsul"><?=formatDateNotifikasi($rs['last_message_date'], 0)?></span>
                        </div>
                    <?php } else { ?>
                        <div class="col-lg-12 text-right">
                            <span style="color: <?=$flagRead == 1 ? "grey" : "#e62329" ?>" class="sp_last_chat_date_rw_konsul"><?=formatDateNotifikasi($rs['created_date'], 0)?></span>
                        </div>
                    <?php } ?>
                </div> 
            <?php } ?>
        <?php } ?>
    </div>
    <script>
        function onHoverChat(id){
            // $('.div_profil_live_chat').hide()
            // $('.profile_chat_'+id).show()
            // $('.profile_chat_'+id).on('mouseleave', function(){
            //     $('.profile_chat_'+id).hide()
            // })
            $('#div_chat_'+id).on('mouseover', function() {
                $('.div_profil_live_chat').hide()
                $('.profile_chat_'+id).fadeIn(20)
            }).on('mouseleave', function() {
                $('.profile_chat_'+id).fadeOut(20)
            });
        }
    </script>
<?php } else { ?> 
    <div class="col-lg-12 text-center">
        <i><h4>Belum ada Riwayat Konsultasi</h4></i>
    </div>
<?php } ?>