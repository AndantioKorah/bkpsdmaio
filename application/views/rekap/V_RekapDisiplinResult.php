<?php 
    // if($result){
    $skpd = explode(";",$parameter['skpd']);
    // if($flag_print == 1){
    //     $filename = 'REKAPITULASI PENILAIAN PRODUKTIVITAS KERJA '.$skpd[1].' Periode '.getNamaBulan($parameter['bulan']).' '.$parameter['tahun'].'.xls';
    //     header("Content-type: application/vnd-ms-excel");
    //     header("Content-Disposition: attachment; filename=$filename");
    // }
?>
    <style>
        .table-header{
            /* position: fixed;
            top: 0px; display:none; */
        }
    </style>
    <div class="col-lg-12 table-responsive" style="width: 100%;">
        <form action="<?=base_url('rekap/C_Rekap/saveExcelDisiplin')?>" method="post" target="_blank">
            <center><h5><strong>REKAPITULASI PENILAIAN DISIPLIN KERJA</strong></h5></center>
            <br>
            <?php if($flag_print == 0){ ?>
                <button style="display: block;" type="submit" class="text-right float-right btn btn-success btn-sm"><i class="fa fa-download"></i> Simpan sebagai Excel</button>
            <?php } ?>
            <button id="btn_save_db" style="display: block;" type="button" class="text-right float-right btn btn-info btn-sm mr-3"><i class="fa fa-save"></i> Simpan Data ke Database</button>
            <button id="btn_save_db_loading" style="display: none;" type="button" class="text-right float-right btn btn-info btn-sm mr-3"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
            <table style="width: 100%;">
                <tr>
                    <td>SKPD</td>
                    <td>:</td>
                    <td><?=$skpd[1]?></td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td>:</td>
                    <td><?=getNamaBulan($parameter['bulan']).' '.$parameter['tahun']?></td>
                </tr>
            </table>
            
            <div class="row">
                <div class="col-3"></div>
                <div class="col-3">
                    <button type="button" id="btn_database" class="btn btn-block btn-info">Database</button>
                </div>
                <div class="col-3">
                    <button type="button" id="btn_excel" class="btn btn-block btn-success">Excel</button>
                </div>
                <div class="col-3"></div>
            </div>

            <div class="row">
                <div class="col-12 mt-3" style="display: <?=$result_db ? 'block' : 'none'?>;" id="database_div">
                    <?php
                        $data['result'] = $result_db;
                        $data['parameter'] = $parameter;
                        $data['from'] = 'Database';
                        $this->load->view('rekap/V_RekapDisiplinData', $data); 
                    ?>
                </div>
                <div class="col-12 mt-3" style="display: <?=$result_db ? 'none' : 'block'?>;" id="excel_div">
                    <?php
                        $data['result'] = $result;
                        $data['parameter'] = $parameter;
                        $data['from'] = 'Uploaded Excel';
                        $this->load->view('rekap/V_RekapDisiplinData', $data); 
                    ?>
                    </div>
            </div>
        </form>
    </div>
    <script>
        $(function(){
            // var tableOffset = $("#table_data_disiplin").offset().top;
            // var $header = $("#table_data_disiplin > thead").clone();
            // var $fixedHeader = $(".table-header").append($header);

            // $(window).bind("scroll", function() {
            //     var offset = $(this).scrollTop();

            //     if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
            //         $fixedHeader.show();
            //     }
            //     else if (offset < tableOffset) {
            //         $fixedHeader.hide();
            //     }
            // });
        })

        $('#btn_save_db').on('click', function(){
            $('#btn_save_db').hide()
            $('#btn_save_db_loading').show()
            $.ajax({
                url: '<?=base_url("rekap/C_Rekap/saveDbRekapDisiplin")?>',
                method: 'post',
                // data: $(this).serialize(),
                data: null,
                success: function(data){
                    successtoast('Data Sudah Tersimpan')
                    $('#file_rekap').val('')
                    $('#btn_save_db').show()
                    $('#btn_save_db_loading').hide()
                }, error: function(e){
                    $('#btn_save_db').show()
                    $('#btn_save_db_loading').hide()
                    errortoast('Terjadi Kesalahan')
                }
            })
        })

        $('#btn_database').on('click', function(){
            $('#database_div').show()
            $('#excel_div').hide()
        })

        $('#btn_excel').on('click', function(){
            $('#database_div').hide()
            $('#excel_div').show()
        })
    </script>
<?php // } else { ?>
    <!-- <h5>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h5> -->
<?php // } ?>