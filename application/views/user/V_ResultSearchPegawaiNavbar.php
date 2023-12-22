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

<div style="padding: 5px; background-color: #c6c6c6; color: var(--primary-color); font-weight: bold; font-size: .8rem;">
    <span class="title-search-navbar">DATA PEGAWAI</span>
</div>
<?php
    if($result_pegawai){
?>
    <div class="p-0">
        <?php $i = 0; foreach($result_pegawai as $rs){ ?>
            <div onclick="openProfilePegawai('<?=$rs['username']?>')" class="col_result col-lg-12">
                <div class="row" style="line-height: 1rem;">
                    <div class="col-lg-3 my-auto align-self-center">
                        <!-- <img src="<?=$this->general_library->getFotoPegawai('./assets/fotopeg/'.$rs['fotopeg'])?>"
                        style="border-radius: 30px !important; width: 6vw; object-fit: cover;" /> -->
                        <center>
                        <img style="width: 100%; height: 8vh; object-fit: cover" class="img-fluid rounded-circle b-lazy"
                            src="<?php
                                $path = './assets/fotopeg/'.$rs['fotopeg'];
                                // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                if($rs['fotopeg']){
                                if (file_exists($path)) {
                                   $src = './assets/fotopeg/'.$rs['fotopeg'];
                                  //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                } else {
                                  $src = './assets/img/user.png';
                                  // $src = '../siladen/assets/img/user.png';
                                }
                                } else {
                                  $src = './assets/img/user.png';
                                }
                                echo base_url().$src;?>" /> 
                        </center>
                    </div>
                    <div class="col-lg-9 my-auto align-self-center" style="margin-left: -10px; text-align: left;">
                        <span style="font-size: .85rem; font-weight: bold;"><?=($rs['nama'])?></span><br>
                        <span style="font-size: .70rem; font-weight: bold;">NIP. <?=formatNip($rs['username'])?></span>
                    </div>
                </div>
            </div>
            <?php if($i != count($result_pegawai) - 1){ ?>
                <div class="divider_col_result"></div>
            <?php } ?>
        <?php $i++; } ?>
    </div>
<?php } else { ?>
    <div style="padding: 5px; !important; color: black; font-weight: bold;">Data Tidak Ditemukan <i class="fa fa-exclamation"></i></div>
<?php } ?>
<div style="padding: 5px; background-color: #c6c6c6; color: var(--primary-color); font-weight: bold; font-size: .8rem;">
    <span class="title-search-navbar">PERANGKAT DAERAH</span>
</div>
<?php
    if($result_skpd){
?>
    <div class="p-0">
        <?php $i = 0; foreach($result_skpd as $rs){ ?>
            <div onclick="openSkpd('<?=$rs['id_unitkerja']?>')" class="col_result col-lg-12">
                <span style="font-size: .85rem; font-weight: bold;"><?=($rs['nm_unitkerja'])?></span><br>
            </div>
            <?php if($i != count($result_skpd) - 1){ ?>
                <div class="divider_col_result"></div>
            <?php } ?>
        <?php $i++; } ?>
    </div>
<?php } else { ?>
    <div style="padding: 5px; !important; color: black; font-weight: bold;">Data Tidak Ditemukan <i class="fa fa-exclamation"></i></div>
<?php } ?>

<script>
    $(function(){
        window.bLazy = new Blazy({
            container: '.container',
            success: function(element){
                console.log("Element loaded: ", element.nodeName);
            }, error: function(e){
                console.log('error b-lazy')
            }
        });
    })

    function openProfilePegawai(nip){
        window.location='<?=base_url('kepegawaian/profil-pegawai/')?>'+nip
    }

    function openSkpd(id_unitkerja){
        window.location='<?=base_url('master/perangkat-daerah/detail/')?>'+id_unitkerja
    }
</script>