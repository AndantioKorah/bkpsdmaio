<style>
    .divider_col_result{
        border-bottom: 1px solid black;
    }

    .col_result{
        padding: 5px;
    }

    .col_result:hover{
        background-color: var(--primary-color);
        color: white;
        cursor: pointer;
    }
</style>

<?php
    if($result){
?>
    <div class="p-0">
        <?php $i = 0; foreach($result as $rs){ ?>
            <div onclick="openProfilePegawai('<?=$rs['username']?>')" class="col_result col-lg-12">
                <span style="font-size: .75rem; font-weight: bold;"><?=formatNip($rs['username'])?></span><br>
                <!-- <span style="font-size: .65rem; font-weight: bold;"><?=($rs['nm_unitkerja'])?></span><br> -->
                <span style="font-size: .85rem; font-weight: bold;"><?=($rs['nama'])?></span>
            </div>
            <?php if($i != count($result) - 1){ ?>
                <div class="divider_col_result"></div>
            <?php } ?>
        <?php $i++; } ?>
    </div>
<?php } ?>

<script>
    function openProfilePegawai(nip){
        window.location='<?=base_url('kepegawaian/profil-pegawai/')?>'+nip
    }
</script>