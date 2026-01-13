<div class="card card-default">
    <div class="card-header" style="margin-bottom:-40px">
        <!-- <h4>Jabatan Fungsional</h4> -->
    </div>
    <div class="card-body" >
<?php if(isset($result['list_jft'])) { ?>
         <table class="table table-sm" style="border: 0px black solid;" border-collapse="collapse">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-left">Nama Jabatan</th>
                                    <!-- <th class="text-center">Kelas Jabatan</th> -->
                                    <!-- <th class="text-center">Jumlah</th> -->
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($result['list_jft'] as $lj){ ?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="text-left"><?=$lj['nama_jabatan']?></td>
                                            <!-- <td class="text-center"><?=$lj['kelas_jabatan']?></td> -->
                                            <!-- <td class="text-center"><?=$lj['total']?></td> -->
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php } else { ?>
                            <h5>Tidak ada Jabatan Fungsional</h5>
                            <?php } ?>
    </div>
</div>

<div class="row">
    
</div>

