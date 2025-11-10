<table style="border: 0; width: 100%;">
    <tr valign=top>
        <td style="width: 50%;">
            <?php
                $keyTemp = array_keys($result['temp']);
                foreach($keyTemp as $kt){
            ?>
                <div style="width: 100%;">
                    <span><?=$kt?></span>
                    <span style="font-weight: bold;"><?=$result['temp'][$kt]?></span>
                </div>
            <?php } ?> 
        </td>
        <td style="width: 50%;">
            <?php
                $keyDb = array_keys($result['db']);
                foreach($keyDb as $kd){
            ?>
                <div style="width: 100%;">
                    <span><?=$kd?></span>
                    <span style="font-weight: bold;"><?=$result['db'][$kd]?></span>
                </div>
            <?php } ?>
                <div style="width: 100%;">
                    <span>url_jabatan_new</span>
                    <?php $urlJabatanNew = "SK_".$result['temp']['nip']."_".$result['temp']['nama']."_sign_sign.pdf"; ?>
                    <span style="font-weight: bold;"><?=$urlJabatanNew?></span>
                    <?= file_exists("arsipjabatan/".$urlJabatanNew) ? "file_exists" : "404" ?>
                </div> 
                <div style="width: 100%;">
                    <span>url_berkas_new</span>
                    <?php $urlBerkasNew = "SK_".$result['temp']['nip']."_".$result['temp']['nama']."_sign_sign.pdf"; ?>
                    <span style="font-weight: bold;"><?=$urlBerkasNew?></span>
                    <?= file_exists("arsipberkas/".$urlBerkasNew) ? "file_exists" : "404" ?>
                </div>
                <div style="width: 100%;">
                    <span>url_spmt_new</span>
                    <?php 
                        $result['temp']['gelar1'] = $result['temp']['gelar_depan'];
                        $result['temp']['gelar2'] = $result['temp']['gelar_belakang'];
                        $urlSpmtNew = getNamaPegawaiFull($result['temp'], 1)."_sign.pdf";
                    ?>
                    <span style="font-weight: bold;"><?=$urlSpmtNew?></span>
                    <?= file_exists("arsiplain/".$urlSpmtNew) ? "file_exists" : "404" ?>
                </div> 
        </td>
    </tr>
</table>