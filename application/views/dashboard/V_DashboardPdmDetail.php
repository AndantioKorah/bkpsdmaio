<?php if($result){ ?>
    <style>
        .knob{
            font-size: 3.5rem !important;
        }

        .knob-bidang{
            font-size: 1.6rem !important;
            text-align: center !important;
        }
    </style>
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-default" style="height: 50vh;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h3 style="font-weight: bold;">PROGRESS KESELURUHAN</h3>
                            <input data-readonly="true" disabled type="number" class="knob" 
                            value="<?=formatTwoMaxDecimal($result['total_progress'])?>"
                            data-width="300" data-height="300" data-fgColor="<?=getProgressBarColor(formatTwoMaxDecimal($result['total_progress']), false)?>">
                            <!-- <div class="knob-label">
                                <strong>PRESENTASE CAPAIAN REALISASI TARGET</strong>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-default" style="height: 50vh; overflow-y: scroll;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h3 style="font-weight: bold;">JENIS BERKAS</h3>
                            <table class="table table-sm table-hover table-striped">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-left">Nama Berkas</th>
                                    <th class="text-center">Progress</th>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($result['master'] as $m){
                                        $progress_master = $m['progress']['total'] == 0 ? 0 : ($m['progress']['total'] / count($result['list_pegawai'])) * 100;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="text-left"><?=$m['nama_berkas']?></td>
                                            <td class="text-center">
                                                <span style="color: black; font-weight: bold !important;"><?=formatTwoMaxDecimal($progress_master).' %'?></span>
                                                <div class="progress progress-sm" style="height: 1rem !important; border-radius: 10px;">
                                                    <div class="progress-bar" role="progressbar"
                                                        aria-valuenow="<?=$progress_master?>" aria-valuemin="0" 
                                                        aria-valuemax="<?=$m['progress']['total']?>" 
                                                        style="width: <?=formatTwoMaxDecimal($progress_master)?>%; 
                                                        background-color: <?=getProgressBarColor($progress_master)?>;">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php if($result['bidang']){ foreach($result['bidang'] as $b){ ?>
            <div class="col">
                <div class="card card-default text-center">
                    <div class="card-header" style="height: 8vh;">
                        <h5 class="nama_bidang" style="color: grey; font-weight: bold; font-size: .8rem;"><?=$b['nama_bidang']?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <input data-readonly="true" disabled type="number" class="knob knob-bidang" 
                                value="<?=formatTwoMaxDecimal($b['total_progress'])?>"
                                data-width="150" data-height="150" data-fgColor="<?=getProgressBarColor(formatTwoMaxDecimal($b['total_progress']), false)?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } } ?>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="col-lg-12 table-responsive p-3" style="overflow-x: scroll;">
                <table class="data_table_dashboard table table-hover table-striped" style="width: 100%;">
                    <thead>
                        <th style="width: 5%;" class="text-center">No</th>
                        <th style="width: 35%;" class="text-left">Pegawai</th>
                        <th style="width: 25%;" class="text-center">Bidang</th>
                        <th style="width: 35%;" class="text-center">Progress</th>
                        <!-- <?php foreach($result['master'] as $rm){ ?>
                            <th style="width: 5%;" class="text-center"><?=$rm['nama_berkas']?></th>
                        <?php } ?> -->
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($result['list_pegawai'] as $l){
                            $total_progress_pegawai = $l['progress']['total'] == 0 ? 0 : ($l['progress']['total'] / count($result['master'])) * 100; 
                        ?>
                            <tr>
                                <td class="text-center"><?=$no++;?></td>
                                <td class="text-left">
                                    <span style="color: black; font-size: .9rem; font-weight: bold;"><?=getNamaPegawaiFull($l)?></span><br>
                                    <span style="color: grey; font-size: .8rem;">NIP. <?=formatNip($l['nipbaru_ws'])?></span><br>
                                    <span style="color: grey; font-size: .8rem;"><?=($l['nm_pangkat'])?></span><br>
                                    <span style="color: grey; font-size: .8rem;"><?=($l['nama_jabatan'])?></span>
                                </td>
                                <td class="text-left"><?=$l['nama_bidang']?></td>
                                <td class="text-center">
                                    <span style="color: black; font-weight: bold !important;"><?=formatTwoMaxDecimal($total_progress_pegawai).' %'?></span>
                                    <div class="progress progress-sm" style="height: 1rem !important; border-radius: 10px;">
                                        <div class="progress-bar" role="progressbar"
                                            aria-valuenow="<?=$total_progress_pegawai?>" aria-valuemin="0" 
                                            aria-valuemax="<?=count($result['master'])?>" 
                                            style="width: <?=formatTwoMaxDecimal($total_progress_pegawai)?>%; 
                                            background-color: <?=getProgressBarColor($total_progress_pegawai)?>;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('.data_table_dashboard').dataTable()
            $('.knob').knob({
                /*change : function (value) {
                //console.log("change : " + value);
                },
                release : function (value) {
                console.log("release : " + value);
                },
                cancel : function () {
                console.log("cancel : " + this.value);
                },*/
                draw: function () {

                    // "tron" case
                    if (this.$.data('skin') == 'tron') {

                        var a   = this.angle(this.cv)  // Angle
                            ,
                            sa  = this.startAngle          // Previous start angle
                            ,
                            sat = this.startAngle         // Start angle
                            ,
                            ea                            // Previous end angle
                            ,
                            eat = sat + a                 // End angle
                            ,
                            r   = true

                        this.g.lineWidth = this.lineWidth

                        this.o.cursor
                        && (sat = eat - 0.3)
                        && (eat = eat + 0.3)

                        if (this.o.displayPrevious) {
                            ea = this.startAngle + this.angle(this.value)
                            this.o.cursor
                            && (sa = ea - 0.3)
                            && (ea = ea + 0.3)
                            this.g.beginPath()
                            this.g.strokeStyle = this.previousColor
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
                            this.g.stroke()
                        }

                        this.g.beginPath()
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
                        this.g.stroke()

                        this.g.lineWidth = 2
                        this.g.beginPath()
                        this.g.strokeStyle = this.o.fgColor
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
                        this.g.stroke()

                        return false
                    }
                }
            })
        })
    </script>
<?php } ?>