<?php

    $filename = 'DATA Upload Bangkom SKPD '.formatDateNamaBulan(date('Y-m-d')).'.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=$filename");
?>
         <table class="table datatable" style="border: 0px black solid;" border-collapse="collapse">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-left" style="width:10%;">Nama </th>
                                    <th class="text-center">Unit Kerja</th>
                                    <th class="text-center">Tahun</th>
                                    <th class="text-center">Bulan</th>
                                    <th class="text-center">Data Bangkom</th>
                                    <!-- <th class="text-center">Total JP</th> -->
                                    <!-- <th class="text-center">Status</th> -->

                                    

                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($result as $lj){ ?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="text-left"><?= getNamaPegawaiFull($lj)?></td>
                                            <td class="text-center"><?=$lj['nm_unitkerja']?></td>
                                            <td class="text-center"><?=$tahun?></td>
                                            <td class="text-center"><?= getNamaBulan($bulan)?></td>
                                            <td class="text-center"><?php if($lj['id'] == null) echo "-"; else echo "Ada";?></td>
                                            <!-- <td class="text-center"><?=$lj['total_jp']?></td> -->
                                            <!-- <td class="text-center">
                                                <?php if($lj['status'] == null) echo "-"; else if($lj['status'] == 2) echo "Sudah Verif"; else echo "Belum Verif";?>
                                            </td> -->

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
