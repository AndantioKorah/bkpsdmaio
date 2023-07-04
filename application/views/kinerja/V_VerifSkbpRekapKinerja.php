<style>
 .thCustom { 
              background-color: #464646 
              color: #d1d1d1;
              border-top: 5px;
              padding: 8px 15px; 
              font-weight: normal;
            } 
            
 .tdCustom {
              background-color: #464646;
              color: #d1d1d1;
              border-top: 5px;
              padding: 8px 15px; 
              font-weight: normal;
 }

 .tableFixHead2 { overflow-y: auto; height: 100%; }

.content_table{
                   font-size: 13px;
                   /* text-align: center; */
                      }

.tableFixHead2 table { 
            border: 1px solid #fff;
            font-size: 13px;
          } 
          
  .tableFixHead2 th { 
            background-color: #464646;
            color: #d1d1d1;
            border-top: 5px;
            padding: 8px 15px; 
            font-weight: normal;
          } 


      .tableFixHead2 tr:nth-child(even) th[scope=row] {
      background-color: #f2f2f2;
      color: black;
      }

  
      .tableFixHead2 tr:nth-child(odd) th[scope=row] {
      background-color: #fff;
      
      }

      .tableFixHead2 tr:nth-child(even) {
      background-color: rgba(0, 0, 0, 0.05);
      }

      .tableFixHead2 tr:nth-child(odd) {
      background-color: rgba(255, 255, 255, 0.05);
      }

      .tableFixHead2 td:nth-of-type(2) {
      width: 100px;
      }

      .tableFixHead2 th:nth-of-type(3),
      td:nth-of-type(3) {
      /* text-align: center; */
      } 



      .cd-search{
      padding: 10px;
      border: 1px solid #ccc;
      width: 100%;
      box-sizing: border-box;
      margin-bottom: 10px;
      border-radius: 0px;
                 }

      .tableFixHead tr:nth-child(odd) td {
          background: white;
         
      }

      .tableFixHead tr:nth-child(even) td {
          background: #f2f2f2;
      }

      .tr_click{
        cursor: pointer;
      }

      .tr_click:hover{
        background-color: #ededed !important;
        transition: .2s;
      }

      .tr_rekap_active{
        background-color: #ededed !important;
      }



    

    </style>
<?php if($list_rekap_kinerja){ ?>

<style>
      .progress {
  		background-color: #d6d6d6;
		}
</style>


    <div class="col-12 tableFixHead2">
    <table border="2"  class="table table-bordered" id="table_rekap_kinerja">
    <tbody >
        <tr height="20" style="height:15.0pt">
    <th rowspan="2" class="thCustom" height="40" >No</th>
    <th rowspan="2" class="thCustom">Uraian Tugas</th>
    <th rowspan="2" class="thCustom">Sasaran Kerja</th>
    <th rowspan="2" class="thCustom">Tahun</th>
    <th rowspan="2" class="thCustom">Bulan</th>
    <th colspan="3" class="text-center thCustom" width="265" style="border-left:none;width:199pt">Target<span style="mso-spacerun:yes">&nbsp;</span></th>
    <th colspan="3" class="text-center thCustom" width="192" style="border-left:none;width:144pt">Realisasi</th>
    </tr>
    <tr height="20" style="height:15.0pt">
    <td height="20" style="background-color: #464646;" class="tdCustom"> Kuantitas</td>
    <td style="background-color: #464646;color:#d1d1d1;"  >Satuan</td>
    <td style="background-color: #464646;color:#d1d1d1;"  >Capaian</td>
    <td style="background-color: #464646;color:#d1d1d1;"  >Kuantitas</td>
    <td style="background-color: #464646;color:#d1d1d1;" >Satuan</td>
    <td style="background-color: #464646;color:#d1d1d1;" >Capaian</td>
    </tr>
  
    <!--[if supportMisalignedColumns]-->
    <?php $no=1; 
           
            foreach($list_rekap_kinerja as $lp){ ?>
            
                <?php
                
                
                // $realisasi_kualitas = $lp['realisasi_target_kuantitas']/$lp['target_kuantitas'] * 100;
                // $progress = (floatval($lp['realisasi_target_kuantitas'])/floatval($lp['target_kuantitas'])) * 100;
                $progress = (floatval($lp['total_realisasi'])/floatval($lp['target_kuantitas'])) * 100;
                if($progress > 100){
                    $progress = 100;
                }
                $progress = formatTwoMaxDecimal($progress);
                ?>
                    <tr class="tr_click" onclick="openListKegiatan('<?=$lp['id']?>')">
                        <td class="text-left"><?=$no++;?></td>
                        <td class="text-left"><?=$lp['tugas_jabatan']?></td>
                        <td class="text-left"><?=$lp['sasaran_kerja']?></td>
                        <td class="text-left"><?=$lp['tahun']?></td>
                        <td class="text-left"><?= getNamaBulan($lp['bulan'])?></td>
                        <td class="text-left"><?=$lp['target_kuantitas']?></td>                       
                        <td class="text-left"><?=$lp['satuan']?></td>
                        <td class="text-left"><?=$lp['target_kualitas']?>%</td>
                        <td class="text-left">
                            <!-- <?=$lp['realisasi_target_kuantitas'] == '' ? '0' : $lp['realisasi_target_kuantitas']?></td> -->
                            <?=$lp['total_realisasi'] == '' ? '0' : $lp['total_realisasi']?></td>

                        <td class="text-left"><?=$lp['satuan']?></td>
                        <td class="text-left">
                        <div class="progress progress-sm" style="height:10px;">
                            <div class="progress-bar" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100"  style="height:10px; width: <?=$progress;?>%; background-color: <?=getProgressBarColor($progress)?>;">
                            </div>
                        </div>
                       
                        <small style="font-size: 90% !important; font-weight: bold !important;">
                            <?=$progress.' % selesai'?>
                        </small>
                        <!-- 
                        <div class="text-center" style="border: 2px solid #80808082; border-radius: 5px; width: 100%; height: 30px; padding-bottom: 27px;">
                                        <div class="text-center" style="border-radius: 3px; background-color: <?=getProgressBarColor($progress)?>; overflow: show; white-space: nowrap; width: <?=$progress.'%'?>; height: 27px;">
                                            <strong style="font-size: 18px; color: <?=$progress == 25 || $progress == 100 ? 'white' : 'black'?>;"><?=$progress.' %';?></td></strong>
                                        </div>
                                    </div> -->
                        </td>
                    </tr>
                <?php } ?>
 <!--[endif]-->
</tbody></table>


       
    </div>
    <div class="col-12" id="list_kegiatan" style="display: none;">
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-12">
            <h5 style="text-center">DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
        </div>
    </div>
<?php } ?>
        </div>
    </div>

    <script>
         function openListKegiatan(id){
            $('.tr_rekap_realisasi').removeClass('tr_rekap_active')
            $('#tr_rekap_'+id).addClass('tr_rekap_active')

            $('#list_kegiatan').show()
            $('#list_kegiatan').html('')
            $('#list_kegiatan').append(divLoaderNavy)
            $('#list_kegiatan').load('<?=base_url("kinerja/C_Kinerja/openListKegiatanKinerjaPegawai")?>'+'/'+id, function(){
                $('#loader').hide()
            })
        } 
    </script>