<?php
    if($result){
?>
    <html>
        <style>
            .template-sertifikat{
                background-repeat: no-repeat;
                background-size: cover;
                width: 100%;
                height: 100%;
                text-align: center;
                position: relative;
            }
        </style>
        <body>
            <div style="background-image: url('<?= base_url($result['url_template']) ?>')" class="template-sertifikat">
                <div class="text-center" style="
                    position: fixed;
                    overflow: visible;
                    width: auto;
                    size: 5rem;
                    opacity: 0;
                    color: rgba(255, 255, 255, 0);
                ">.</div>
                <?php foreach($result as $k => $v){ if($k != "url_template"){ ?>
                    <div class="text-center" style="
                        color: black;
                        font-weight: bold;
                        text-align: center;
                        position: absolute;
                        overflow: visible;
                        width: 100%;
                        margin-top: <?=$v['margin-top'].'px'?>;
                        margin-left: <?=$v['margin-left'].'px'?>;
                    ">
                        <?php if($k != "qr"){ ?>
                            <span style="font-size: <?=$v['font-size'].'rem'?>;"><?=$v['content']?></span>
                        <?php } else { ?>
                            <img style="width: <?=$result['qr']['width'].'px'?>;" src="<?=$result['qr']['src']?>"/>
                        <?php } ?>
                    </div>
                <?php } } ?>
            </div>
        </body>
    </html>
<?php } ?>