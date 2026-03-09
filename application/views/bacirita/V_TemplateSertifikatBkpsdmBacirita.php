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
                font-family: "Tahoma";
            }
        </style>
        <body>
            <div style="background-image: url('<?= base_url($result['url_template']) ?>')" class="template-sertifikat">
            </div>
        </body>
    </html>
<?php } ?>