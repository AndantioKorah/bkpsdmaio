<?php if($all_list){ foreach($all_list as $lo){ ?>
    <div id="div_operator_item_<?=$lo['id_m_user']?>" onclick="openOption('<?=$lo['id_m_user']?>')" class="col-lg-12 mt-1 text-left div_operator_item">
        <span style="
            font-weight: bold;
            color: black;
            font-size: .8rem;
        "><?=getNamaPegawaiFull($lo, 1)?></span>
        <div style="display: none;" class="col-lg-12 text-right div_option_operator div_option_operator_<?=$lo['id_m_user']?>">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 text-rigt">
                    <p style="margin-top: 5px; color: orange; font-weight: bold; font-size: .65rem;">Apakah Anda yakin?</p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 text-right">
                    <button onclick="assignOperator('1', '<?=$lo['id_m_user']?>')" class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>
                    <button onclick="assignOperator('0', '<?=$lo['id_m_user']?>')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                </div>
            </div>
        </div>
    </div>
<?php } } ?>