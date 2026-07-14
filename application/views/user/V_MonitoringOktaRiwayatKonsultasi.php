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

        .div_chat_konsul_item_monitoring:hover{
            cursor: pointer;
            background-color: #f0f0f0;
            border-radius: 10px;
        }

        .div_chat_konsul_item_monitoring{
            margin-top: 5px;
            /* border-bottom: 1px solid lightgrey; */
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

        .monitoring_item_open{
            border-left: 10px solid green !important;
            background-color: #f0f0f0;
            border-radius: 10px;
            transition: .2s;
        }
    </style>
    <div class="w-100 pl-2 pt-2">
        <?php
        $totalUnread = 0;
        foreach($result as $rs){
            $flagRead = 0; 
            if($this->general_library->isHakAkses('admin_live_chat_konsultasi') 
                    || $this->general_library->isProgrammer()
                    || $this->general_library->getId() == $rs['id_m_user_assigned']){
                $flagRead = $rs['flag_read_admin'];
            } else {
                $flagRead = $rs['flag_read_pegawai'];
            }
            if($flagRead == 0){
                $totalUnread++;
            }
        ?>
            <div id="div_chat_id_monitoring_<?=$rs['id']?>" class="div_chat_konsul_item_monitoring" onclick="openKonsultasiDetailMonitoring('<?=$rs['id']?>')">
                <div class="col-lg-12 text-left p-2">
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
                                <div class="ml-2" style="line-height: 17px;">
                                    <span class="sp_chat_id_rw_konsul ellipsis_this sp_chat_id_rw_konsul_admin">
                                        <?=$rs['flag_done'] == 0 ? '<i style="font-size: .6rem; color: green;" class="fa fa-circle"></i>' : ''?>
                                        <?=formatNamaPegawaiLiveChat($rs)?>
                                    </span>
                                    <?php if($rs['pesan'] || $rs['is_image'] || $rs['is_file']){ ?>
                                        <div class="text-left">
                                            <?php if($rs['pesan']){ ?>
                                                <label style="
                                                        color: <?=$flagRead == 0 ? '#e62329 !important' : 'grey'?>;
                                                        font-weight: <?=$flagRead == 0 ? '1000 !important' : 'normal'?>
                                                    " class="sp_last_chat_rw_konsul">
                                                    <?=$rs['pesan']?>
                                                </label>
                                            <?php } else if($rs['is_file'] == 1){ ?>
                                                <i style="color: <?=$flagRead == 0 ? '#e62329 !important' : 'grey'?>; font-size: .75rem;" class="fa fa-image"></i>
                                            <?php } else if($rs['is_image'] == 1){ ?>
                                                <i style="color: <?=$flagRead == 0 ? '#e62329 !important' : 'grey'?>; font-size: .75rem;" class="fa fa-file-pdf"></i>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <?php if($rs['id_m_layanan_konsul']){ ?>
                                        <div class="text-left">
                                            <span title="<?=$rs['nama_layanan']?>" class="ellipsis_this" style="
                                                color: grey;
                                                font-size: .6rem;
                                                font-weight: bold;
                                                font-style: italic;">
                                                <?=$rs['nama_layanan']?>
                                            </span>
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
                <div class="col-lg-12 p-2" style="margin-top: -15px;">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 text-left">
                            <?php if($rs['flag_rating_pegawai']){ ?>
                                <span class="sp_last_chat_date_rw_konsul"><i class="fa fa-user"></i></span>
                            <?php } ?>
                            <?php if($rs['flag_rating']){ ?>
                                <span class="sp_last_chat_date_rw_konsul"><i class="fa fa-star"></i></span>
                            <?php } ?>
                            <?php if($rs['id_m_user_assigned']){
                                $userAssign = [
                                    'nama' => $rs['nama_assign'],  
                                    'gelar1' => $rs['gelar1_assign'],  
                                    'gelar2' => $rs['gelar2_assign'],  
                                ];
                            ?>
                                <?php
                                    $colorAssign = "green";
                                    if($rs['flag_done'] == 1){
                                        $colorAssign = "grey";
                                    }
                                ?>
                                <?php if($rs['id_m_user_assigned'] == $this->general_library->getId()){ ?>
                                    <span
                                        style="color: <?=$colorAssign?>"
                                        class="sp_last_chat_date_rw_konsul"><i class="fa fa-headset"></i> Operator</span>
                                <?php } else { ?>
                                <span
                                    style="color: <?=$colorAssign?>"
                                    class="sp_last_chat_date_rw_konsul"><i class="fa fa-headset"></i> <?=getNamaPegawaiFull($userAssign, 1, 1)?></span>
                            <?php } } ?>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 text-right">
                            <?php if($rs['pesan']){ ?>
                                <span class="sp_last_chat_date_rw_konsul"><?=formatDateNotifikasi($rs['last_message_date'], 0)?></span>
                            <?php } else { ?>
                                <span class="sp_last_chat_date_rw_konsul"><?=formatDateNotifikasi($rs['created_date'], 0)?></span>
                            <?php } ?>
                                | <span style="color: <?=$flagRead == 0 ? '#e62329 !important' : 'grey'?>" class="sp_last_chat_date_rw_konsul"><?=$rs['chat_id']?></span>
                        </div>
                    </div>
                </div>
            </div> 
        <?php } ?>
    </div>
    <script>
        $(function(){
            if(id_konsul_aktif != 0){
                $('.div_chat_konsul_item_monitoring').removeClass('monitoring_item_open')
                $('#div_chat_id_monitoring_'+id_konsul_aktif).addClass('monitoring_item_open')
            }
        })

        function openKonsultasiDetailMonitoring(id){
            $('.div_chat_konsul_item_monitoring').removeClass('monitoring_item_open')
            $('#div_chat_id_monitoring_'+id).addClass('monitoring_item_open')

            id_konsul_aktif = id

            $('.div_monitoring_konsultasi_detail').html('')
            $('.div_monitoring_konsultasi_detail').append(divLoaderNavy)
            $('.div_monitoring_konsultasi_detail').load('<?=base_url("user/C_User/openDetailKonsultasiMonitoring/")?>'+id, function(){
                $('#loader').hide()
            })
        }

        function onHoverChat(id){
            // $('.div_profil_live_chat').hide()
            // $('.profile_chat_'+id).show()
            // $('.profile_chat_'+id).on('mouseleave', function(){
            //     $('.profile_chat_'+id).hide()
            // })
            // $('#div_chat_'+id).on('mouseover', function() {
            //     $('.div_profil_live_chat').hide()
            //     $('.profile_chat_'+id).fadeIn(20)
            // }).on('mouseleave', function() {
            //     $('.profile_chat_'+id).fadeOut(20)
            // });
        }
    </script>
<?php } else { ?>
    <div class="col-lg-12 text-center p-3">
        <?php if(isset($flag_search)){ ?>
            <i><h6>Data Tidak Ditemukan</h6></i>
        <?php } else { ?>
            <i><h6>Belum ada Riwayat Konsultasi</h6></i>
        <?php } ?>
    </div>
<?php } ?>