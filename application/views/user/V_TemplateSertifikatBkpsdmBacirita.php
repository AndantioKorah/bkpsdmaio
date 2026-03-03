<?php
    if($result){
?>
    <style>
        .template-sertifikat{
            background-repeat: no-repeat;
            background-size: cover;
            width: 100%;
            height: 100%;
            text-align: center;
            position: absolute;
        }
    </style>
    <div style="background-image: url('<?= base_url($result['url_template']) ?>')" class="template-sertifikat">
        <div class="text-center" style="
            position: fixed;
            overflow: visible;
            width: auto;
            size: 5rem;
            opacity: 0;
            color: rgba(255, 255, 255, 0);
        ">.</div>
        <div class="text-center" style="
            color: black;
            font-weight: bold;
            text-align: center;
            position: fixed;
            overflow: visible;
            width: auto;
            margin-top: <?=$result['nomor_surat']['margin-top']?>;
            margin-left: <?=$result['nomor_surat']['margin-left']?>;
        "><span style="font-size: <?=$result['nomor_surat']['font-size']?>;"><?=$result['nomor_surat']['content']?></span></div>
        <div class="text-center" style="
            color: black;
            font-weight: bold;
            text-align: center;
            position: fixed;
            overflow: visible;
            width: auto;
            margin-top: <?=$result['nama_lengkap']['margin-top']?>;
            margin-left: <?=$result['nama_lengkap']['margin-left']?>;
        "><span style="font-size: <?=$result['nama_lengkap']['font-size']?>;"><?=$result['nama_lengkap']['content']?></span></div>
        <div style="
            color: black;
            font-weight: bold;
            text-align: center;
            position: fixed;
            overflow: visible;
            width: auto;
            margin-top: <?=$result['qr']['margin-top']?>;
            margin-left: <?=$result['qr']['margin-left']?>;
        "><img style="width: <?=$result['qr']['width'].'px'?>;" src="<?=$result['qr']['src']?>" /></div>
    </div>
<?php } ?>