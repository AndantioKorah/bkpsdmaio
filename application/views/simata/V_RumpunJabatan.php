<style>
    .label-filter{
        color: #434242;
        font-weight: bold;
        font-size: 15px;
    }
    
    .filter-option{
        overflow: auto;
        white-space: nowrap;
        padding-bottom: 5px;
        padding-top: 5px;
    }

    .filter-btn {
        display: inline-block;
        text-align: center;
        padding: 5px;
        border-radius: 5px;
        margin-right: 3px;
        transition: .2s;
    }

    .filter-unselect{
        border: 1px solid #939ba2;
        color: #939ba2;
    }

    .filter-unselect:hover{
        cursor: pointer;
        background-color: #43556b;
        color: white;
    }

    .filter-select{
        border: 1px solid #222e3c;
        color: white;
        font-weight: bold;
        background-color: #222e3c;
    }

    .filter-select:hover{
        cursor: pointer;
        background-color: #222e3c;
        color: white;
    }
</style>

<div class="card card-default">
    <div class="card-header">
        <h5 class="card-title">DATA PEGAWAI</h5>
        <hr>
    </div>
    <div class="card-body" style="margin-top: -30px;">
        <form id="form_search">
            <div class="row">
               
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="label-filter">Rumpun Jabatan</label>
                            <div class="">
                                <select class="form-control select2-navy" 
                                    id="rumpun" data-dropdown-css-class="select2-navy" name="rumpun" required>
                                    <option value="0" selected>Semua</option>
                                    <?php foreach($rumpun as $u){ ?>
                                        <option value="<?=$u['id']?>"><?=$u['nm_rumpun_jabatan']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label class="label-filter">Eselon</label>
                            <div class="filter-option">
                                <?php foreach($eselon as $e){ ?>
                                    <span id="btn_filter_eselon_<?=$e['id_eselon']?>" onclick="filterClicked('eselon_<?=$e['id_eselon']?>')"
                                    class="filter-btn filter-unselect"><?=$e['nm_eselon']?></span>
                                <?php } ?>
                            </div>
                        </div>
                       
                        
                    </div>
                </div>
                <div class="col-lg-9"></div>
                <div class="col-lg-3 text-right mt-2">
                    <button id="btn_search" type="submit" class="btn btn-navy"><i class="fa fa-search"></i> Cari</button>
                    <button style="display:none;" id="btn_loading" disabled type="button" class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default mt-2" id="div_result">
</div>
<script>
    
    let eselon = [];

    $(function(){
        // $('#form_search').submit()
        $('.select2-navy').select2()
        <?php if($search != "" && $search != null){ ?>
            $('#form_search').submit()
        <?php } ?>
    })

    $('#tahun').on('change', function(){
        $('#form_search').submit()
    })

    function filterClicked(btn){
        jenis = btn.split("_")
        if($('#btn_filter_'+btn).hasClass('filter-unselect')){
            $('#btn_filter_'+btn).removeClass('filter-unselect')
            $('#btn_filter_'+btn).addClass('filter-select')
            if(jenis[0] == 'eselon'){
                eselon.push(jenis[1])
            } 
        } else {
            $('#btn_filter_'+btn).addClass('filter-unselect')
            $('#btn_filter_'+btn).removeClass('filter-select')
            if(jenis[0] == 'eselon'){
                eselon = eselon.filter(function(e){
                    return e !== jenis[1]
                })
            }
        }
    }

    $('#form_search').on('submit', function(e){
        $('#btn_loading').show()
        $('#btn_search').hide()
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("simata/C_Simata/searchRumpunJabatan/")?>',
            method: 'post',
            data: {
                eselon: eselon,
                rumpun: $('#rumpun').val()
            },
            success: function(data){
                $('#div_result').html('')
                $('#div_result').append(divLoaderNavy)
                $('#div_result').html('')
                $('#div_result').append(data)

                $('#btn_loading').hide()
                $('#btn_search').show()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
                $('#btn_loading').hide()
                $('#btn_search').show()
            }
        })
    })
</script>