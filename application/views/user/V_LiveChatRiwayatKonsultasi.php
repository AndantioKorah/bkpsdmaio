<?php if($result){ ?>
    <style>
        .sp_chat_id_rw_konsul{
            font-size: 1.1rem;
            color: black;
            font-weight: bold;
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
    </style>
    <div class="row">
        <?php foreach($result as $rs){ ?>
            <div class="div_chat_konsul_item pt-2" onclick="openKonsultasiDetail('<?=$rs['id']?>')">
                <div class="col-lg-12 text-left">
                    <?php if($rs['flag_done'] == 0){ ?>
                        <span><i style="font-size: .75rem; color: green;" class="fa fa-circle"></i></span>
                    <?php } ?>
                    <span class="sp_chat_id_rw_konsul">#<?=$rs['chat_id']?></span>
                </div>
                <?php if($rs['pesan']){ ?>
                    <div class="col-lg-12 text-left" style="display: flex; align-items: center; gap: 5px;">
                        <?php 
                            $flagRead = 0; 
                            if($this->general_library->isHakAkses('admin_live_chat_konsultasi')){
                                $flagRead = $rs['flag_read_admin'];
                            } else {
                                $flagRead = $rs['flag_read_pegawai'];
                            }
                        ?>
                        <i style="display: <?=$flagRead == 1 ? 'none' : 'block'?>; font-size: .75rem; color: lightblue;" class="fa fa-circle"></i>
                        <label class="sp_last_chat_rw_konsul">
                            <?=$rs['pesan']?>
                        </label>
                    </div>
                    <div class="col-lg-12 text-right">
                        <span class="sp_last_chat_date_rw_konsul"><?=formatDateNotifikasi($rs['last_message_date'], 0)?></span>
                    </div>
                <?php } else { ?>
                    <div class="col-lg-12 text-right">
                        <span class="sp_last_chat_date_rw_konsul"><?=formatDateNotifikasi($rs['created_date'], 0)?></span>
                    </div>
                <?php } ?>
            </div>  
        <?php } ?>
    </div>
<?php } else { ?> 
    <div class="col-lg-12 text-center">
        <i><h4>Belum ada Riwayat Konsultasi</h4></i>
    </div>
<?php } ?>