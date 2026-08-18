<style>
  .lbl_status_pengajuan_1, .lbl_status_pengajuan_2{
    padding: 5px;
    border-radius: 5px;
    background-color: yellow;
    font-weight: bold;
    font-size: .7rem;
  }

  .lbl_status_pengajuan_3, .lbl_status_pengajuan_5{
    padding: 5px;
    border-radius: 5px;
    background-color: red;
    font-weight: bold;
    font-size: .7rem;
    color: white;
  }

  .lbl_status_pengajuan_4{
    padding: 5px;
    border-radius: 5px;
    background-color: green;
    font-weight: bold;
    font-size: .7rem;
    color: white;
  }
</style>

<style>
  .switch {
  position: relative;
  display: inline-block;
  width: 100px;
  height: 24px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ca2222;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2ab934;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(55px);
  -ms-transform: translateX(55px);
  transform: translateX(115px);
}

/*------ ADDED CSS ---------*/
.on
{
  display: none;
}

.on, .off
{
  color: white;
  position: absolute;
  transform: translate(-50%,-50%);
  top: 50%;
  left: 50%;
  font-size: 10px;
  font-family: Verdana, sans-serif;
}

input:checked+ .slider .on
{display: block;}

input:checked + .slider .off
{display: none;}

/*--------- END --------*/

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;}
</style>

<div class="card card-default">
    
 <div class="row">
 	<div class="col-lg-12">
	
		

		
	</div>
</div>



<?php if($result) { ?>
<div class="card-header" style="margin-bottom:-40px">
 <form  method="post" enctype="multipart/form-data" class="float-right mr-1 mb-4" action="<?=base_url('kepegawaian/C_Kepegawaian/openListUploadBangkomSkpdItemExcel')?>" target="_blank">
                <input type="hidden" name="unitkerja" value="<?=$skpd;?>">
                <input type="hidden" name="tahun" value="<?=$tahun;?>">
            	<input type="hidden" name="bulan" value="<?=$bulan;?>">
                <button type="submit" class="btn btn-success"><i class="fa fa-file"></i> Download as Excel</button>
		</form>
</div>
<div class="card-body table-responsive" >

<div class="table-responsive">
         <table class="table datatable" style="border: 0px black solid;" border-collapse="collapse">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-left" style="width:10%;">Nama </th>
                                    <th class="text-center">Unit Kerja</th>
                                    <th class="text-center">Tahun</th>
                                    <?php if(isset($result[0]['riwayat'])) { ?>
                                    <th class="text-center">Semua Data</th>
                                    <th>Kecualikan dari perhitungan bulan <?=getNamaBulan($bulan);?></th>
                                     <?php } else { ?>
                                    <th class="text-center">Bulan</th>
                                    <th class="text-center">Data Bangkom</th>
                                    <th class="text-center">Total JP</th>
                                     <?php }  ?>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($result as $lj){ ?>
                                    <?php
                                    $fe = 0;
                                     $id = 0;
                                        $badge_status = 'badge-cpns';
                                        if($lj['statuspeg'] == 2){
                                        $badge_status = 'badge-pns';
                                        } else if($lj['statuspeg'] == 3){
                                        $badge_status = 'badge-pppk';
                                        } else if($lj['statuspeg'] == 6){
                                        $badge_status = 'badge-pppk-pw';
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="text-left">
                                                <?= getNamaPegawaiFull($lj)?><br>
                                                 <span class="badge <?=$badge_status?>"> <?php  if($lj['statuspeg'] == 1) echo "CPNS"; else if($lj['statuspeg'] == 2) echo "PNS"; else if($lj['statuspeg'] == 3) echo "PPPK"; else echo "PPPK Paruh Waktu";?> </span>
                                            </td>
                                            <td class="text-center"><?=$lj['nm_unitkerja']?></td>
                                            <td class="text-center"><?=$tahun?></td>
                                            <?php if(isset($lj['riwayat'])) { ?>
                                            <td class="text-center">
                                            <?php $i = 0; foreach($lj['riwayat'] as $l){ ?>
                                            <span class="badge badge-dark"><?php echo  getNamaBulan($l['bulan'])." : ".$l['jumlah_jp']." JP";?></span>
                                            <br>
                                            <?php  if($bulan == $l['bulan']){ $fe = $l['flag_exception']; $id = $l['id']; $nip = $l['nip'];  } $i++; }
                                           
                                            ?>
                                           <?php if($this->general_library->isProgrammer() || $this->general_library->isHakAkses('akses_pengecualian_bangkom')) { ?>
                                            <td>  
                                            <?php if($id != 0) {?>
                                             <label class="switch ml-2"><input  id="t_cek_bangkom_<?=$l['id']?>" type="checkbox" id="togBtn" onchange="myToggleFunction(this,'<?=$nip?>','<?=$bulan?>')" <?php if($fe == 1) echo "checked"; else echo "";?>><div class="slider round">
                                            <span class="on" style="font-size:11px;">Ya </span>
                                            <span class="off" style="font-size:11px;"> Tidak </span></div></label> 
                                            </td>
                                             <?php } ?>
                                            <?php } else {  ?>
                                            <td>  
                                             <label class="switch ml-2"><input disabled type="checkbox"  <?php if($fe == 1) echo "checked"; else echo "";?>><div class="slider round">
                                            <span class="on" style="font-size:11px;">Ya </span>
                                            <span class="off" style="font-size:11px;"> Tidak </span></div></label> 
                                            </td>
                                            <?php } ?>
                                            <?php } else { ?>
                                            <td class="text-center"><?= getNamaBulan($bulan)?></td>
                                            <td class="text-center"><?php if($lj['id'] == null) echo "-"; else echo "Ada";?></td>
                                            <td class="text-center"><?=$lj['total_jp']?></td>
                                            <?php } ?>
                                        </td>

                                            <!-- <td class="text-center">
                                                <?php if($lj['status'] == null) echo "-"; else if($lj['status'] == 2) echo "Sudah Verif"; else echo "Belum Verif";?>
                                            </td> -->

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                            <?php } else { ?>
                            <h5>Tidak ada data </h5>
                            <?php } ?>
    </div>
</div>

<div class="row">
    
</div>

<script>
      $(function(){
    // $('.datatable').dataTable()
    	$('.datatable').dataTable({
			"pageLength": 50
		}) 
  })

function myToggleFunction(id,nip,bulan){

    if(id.checked) {
    var flag_exception = 1
    } else {
    var flag_exception = 0
    }

    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/updateFlagExceptionBangkom/")?>',
      method: 'post',
      data : {nip: nip, flag_exception : flag_exception, bulan : bulan},
      success: function(res){
         var result = JSON.parse(res); 
        if(result.code == 0){
        successtoast(result.message);
        } else {
        errortoast(result.message);
        }


      }, error: function(e){
      errortoast('Terjadi Kesalahan')
      }
    })
            
        }

</script>