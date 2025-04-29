<div class="card card-default p-3">
    <div class="row">
        <div class="col-lg-12 table-responsive">
            <table class="table table-hover table-striped" id="result_table">
                <thead>
                    <th class="text-center">No</th>
                    <th class="text-center">Tujuan</th>
                    <th class="text-center">Pesan</th>
                    <th class="text-center">Mengirim</th>
                    <th class="text-center">Terkirim</th>
                    <th class="text-center">Status</th>
                </thead>
                <tbody>
                    <?php if($result){ $no = 1; foreach($result as $rs){ ?>
                        <tr>
                            <td class="text-center"><?=$no++;?></td>
                            <td class="text-left">
                                <?php if($rs['nama']){
                                    echo "<span style='font-weight: bold; font-size: 1rem;'>".getNamaPegawaiFull($rs).'</span><br>';
                                } ?>
                                <?=$rs['handphone'] ? $rs['handphone'] : $rs['sendTo']?>
                            </td>
                            <td class="text-left">
                                <?=$rs['message']?>
                                <?php
                                    if($rs['fileurl']){
                                    $explFilename = explode("/", $rs['fileurl']);
                                    $filename = $explFilename[count($explFilename)-1];
                                ?>
                                    <br>
                                    <a class="btn btn-sm btn-danger" href="<?=base_url($rs['fileurl'])?>" target="_blank"><i class="fa fa-file"></i> <?=$filename?></a>
                                <?php
                                    }
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                    $content_sending = "<span class='badge badge-danger'><i class='fa fa-cancel'></i></span>";
                                    if($rs['flag_sending'] == 1){
                                        $explDateSending = explode(" ", $rs['date_sending']);
                                        $dateSending = formatDateNamaBulanWithTime($rs['date_sending']);
                                        if($explDateSending[0] == date('Y-m-d')){
                                            $dateSending = trim($explDateSending[1]);
                                        }
                                        $content_sending = "<span class='badge badge-success'><i class='fa fa-check'></i></span> <br>".$dateSending;
                                    }

                                    echo $content_sending;
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                    $content_sent = "<span class='badge badge-danger'><i class='fa fa-cancel'></i></span>";
                                    if($rs['flag_sent'] == 1){
                                        $explDateSent = explode(" ", $rs['date_sent']);
                                        $dateSent = formatDateNamaBulanWithTime($rs['date_sent']);
                                        if($explDateSent[0] == date('Y-m-d')){
                                            $dateSent = trim($explDateSent[1]);
                                        }
                                        $content_sent = "<span class='badge badge-success'><i class='fa fa-check'></i></span> <br>".$dateSent;
                                    }

                                    echo $content_sent;
                                ?>
                            </td>
                            <td class="text-center">
                                <?=$rs['status']?>
                            </td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#result_table').dataTable()
    })
</script>