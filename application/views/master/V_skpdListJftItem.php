<div class="card card-default">
    <div class="card-header" style="margin-bottom:-40px">
        <!-- <h4>Jabatan Fungsional</h4> -->
    </div>
    <div class="card-body" >
<?php if($result) { ?>
         <table class="table table-sm" style="border: 0px black solid;" border-collapse="collapse">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-left">Nama Jabatan</th>
                                    <!-- <th class="text-center">Kelas Jabatan</th> -->
                                    <th class="text-center">Jumlah Pemangku</th>
                                    <th class="text-center">Kebutuhan Tersedia</th>

                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($result as $lj){ ?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="text-left"><?=$lj['nama_jabatan']?></td>
                                            <!-- <td class="text-center"><?=$lj['kelas_jabatan']?></td> -->
                                            <td class="text-center"><?=$lj['total']?></td>
                                            <td class="text-center"><?php if($lj['kebutuhan'] == null) echo "-"; else echo $lj['kebutuhan'];?></td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php } else { ?>
                            <h5>Belum ada data kebutuhan</h5>
                            <?php } ?>
    </div>
</div>

<div class="row">
    
</div>

