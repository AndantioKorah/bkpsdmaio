<?php if($result){ ?>
<style>
	.list-group-item.active {
		background-color: #222e3c;
		border-color: var(--bs-list-group-active-border-color);
		color: var(--bs-list-group-active-color);
		z-index: 2;
	}
 
        /* Important part */
        .modal-dialog{
            overflow-y: initial !important
        }
        .modal-body{
            height: 80vh;
            overflow-y: auto;
        }

</style>

<div class="table-responsive">


<style>
	tr.group,
	tr.group:hover {
		background-color: #2e4963 !important;
		color: #fff;
        
	}
</style>
<div class="table-responsive">
<table id="example2" class="display table table-bordered" style="width:100%;color:#000">
        <thead>
            <tr>
                <!-- <th>Jabatan Target</th> -->
                <th class="text-center">Nilai Kinerja </th>
                <th>Nama</th>
                <th class="text-center">Nilai Potensial</th>
                <th class="text-center">Total Nilai</th>
                <th class="text-center">Hasil Pemetaan Talenta</th>
                <?php if($jt == 0) { ?>
                <th>Rekomendasi</th>
                <?php } else { ?>
                <th>Peringkat</th>
               <?php } ?>
            </tr>
        </thead>
        <tbody >
		<?php $no = 1; foreach($result as $rs2){ ?>
			<?php $total_nilai = $rs2['res_kinerja'] + $rs2['res_potensial_total'];?>
            <?php ;?>
            <tr data-toggle="modal" data-id="<?=$rs2['id']?>" data-nip="<?=$rs2['nipbaru']?>" data-jt="<?=$jenis_pengisian;?>" data-kode="1"
            href="#exampleModal2"  class="open-DetailPT">
            
                <!-- <td><?=$rs2['nama_jabatan'];?></td> -->
                <td class="text-center"><?=$rs2['res_kinerja'];?></td>
                <td><a target="_blank" href="<?= base_url('kepegawaian/profil-pegawai/')?><?=$rs2['nipbaru_ws'];?>" style="color:#fff"><b><?=$rs2['gelar1'];?> <?=$rs2['nama'];?> <?=$rs2['gelar2'];?></b> | NIP. <?=formatNip($rs2['nipbaru_ws']);?></a><br><i><?=$rs2['jabatan_sekarang'];?></i></td>
                <td class="text-center"><?=$rs2['res_potensial_total'];?> </td>
                <td class="text-center"><?=$total_nilai/2;?> </td>
                <td class="text-center"><?=numberToRoman($kotak);?></td>
                <?php if($jt == 0) { ?>
                <td class="text-left">
                    <?= rekomendasi($rs2['res_potensial_total'],$rs2['res_kinerja'])  ?>
                </td>
                <?php } else { ?>
                <td class="text-center"><?=$no++;?></td>
               <?php } ?>

              
				
            </tr>
			<?php } ?>
            
        </tbody>
        <tfoot>
            <tr >
                
           <!-- <th>Jabatan Target</th> -->
                <th class="text-center">Nilai Kinerja</th>
                
                <th>Nama
                    
                </th>
                <th class="text-center">Nilai Potensial </th>
                <th class="text-center">Total Nilai</th>
                <th class="text-center">Hasil Pemetaan Talenta</th>
                <?php if($jt == 0) { ?>
                <th>Rekomendasi</th>
                <?php } else { ?>
                <th>Peringkat</th>
               <?php } ?>
            </tr>
        </tfoot>
    </table>


<!-- Modal -->
<div style="margin-left:-1px;" class="modal fade" id="exampleModal2" >
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#2e4963x;">
        <h5 style="color:#2e4963" class="modal-title" id="exampleModalLabel"><b>Detail Penilaian</b></h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body" id="div_modal_detail_profil_talenta">
        ...
      </div>
      <div class="modal-footer" style="background-color:#2e4963x;">
       
      </div>
    </div>
  </div>
</div>

    </div>
</div>

</div>

<script>
var groupColumn = 1;
var table = $('#example2').DataTable({
    order: [[3, 'desc']],
    columnDefs: [{ visible: false, targets: groupColumn },
    {targets: [0],orderable: false}],

    displayLength: 100,
    // ordering: false,
    drawCallback: function (settings) {
        var api = this.api();
        var rows = api.rows({ page: 'current' }).nodes();
        var last = null;
       
        let no = 0;
 
        api.column(groupColumn, { page: 'current' })
            .data()
            .each(function (group, i) {
                if (last !== group) {
                    no += 1;
                    $(rows)
                        .eq(i)
                        .before(
                            '<tr class="group"><td colspan="7">'+no+'. '+
                            group + 
                                '</td></tr>'
                        );
 
                    last = group;
                }
            });
    }
});
 
// Order by the grouping
$('#example2 tbody').on('click', 'tr.group', function () {
    var currentOrder = table.order()[0];
    if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
        // table.order([groupColumn, 'desc']).draw();
    }
    else {
        // table.order([groupColumn, 'asc']).draw();
    }
});

$(document).on("click", ".open-DetailPT", function () {

var id = $(this).data('id');
var nip = $(this).data('nip');
var kode = $(this).data('kode');
var jt = $(this).data('jt');

if(id == ""){
  id = 0;
}

if(jt == ""){
  jt = 0;
}


$('#div_modal_detail_profil_talenta').html('')
$('#div_modal_detail_profil_talenta').append(divLoaderNavy)
$('#div_modal_detail_profil_talenta').load('<?=base_url("simata/C_Simata/loadModalDetailProfilTalenta/")?>'+id+'/'+nip+'/'+kode+'/'+jt, function(){
$('#loader').hide()
})

});

</script>


<?php } else { ?>
<div class="col-12 text-center">
	<h5>TIDAK ADA DATA !</h5>
</div>
<?php } ?>
