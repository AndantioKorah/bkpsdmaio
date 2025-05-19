<div class="card card-default p-3">
    <div class="row">
        <div class="col-lg-12 table-responsive">
            <table class="table table-hover table-striped" id="result_table">
                <thead>
                    <th class="text-center">No</th>
                    <th class="text-center">Batch ID</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Done</th>
                    <th class="text-center">Last Send</th>
                    <th class="text-center">Last Sent</th>
                </thead>
                <tbody>
                    <?php if($result){ $no = 1; foreach($result as $rs){ ?>
                        <tr>
                            <td class="text-center"><?=$no++;?></td>
                            <td class="text-left"><?=$rs['batchId']?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-danger" onclick="">
                                    <i class="fa fa-file"></i> Request
                                </button>
                                <?php if($rs['flag_send'] == 1){ ?>
                                    <button class="btn btn-sm btn-outline-success" onclick="">
                                        <i class="fa fa-file"></i> Response
                                    </button>
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <?php
                                    $content_sending = "<span class='badge badge-danger'><i class='fa fa-times'></i></span>";
                                    if($rs['flag_send'] == 1){
                                        $explDateSending = explode(" ", $rs['date_send']);
                                        $dateSending = formatDateNamaBulanWithTime($rs['date_send']);
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
                                    $content_sent = "<span class='badge badge-danger'><i class='fa fa-times'></i></span>";
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