<style>
	.top_header{
		font-weight: bold;
		font-size: 25px;
		margin-bottom: 0px;
		margin-top: 0px;
	}

	.address_header{
		font-weight: 500;
		font-size: 20px;
		margin-bottom: 0px;
		margin-top: 0px;
	}

	.footer_header{
		font-weight: 500;
		font-size: 14px;
		margin-bottom: 0px;
		margin-top: 0px;
	}

    table {
    font-size: 13px; /* Sets the default font size for all text within the table */
    }

  .info_card:hover{
    cursor: pointer;
    transition: .2s;
    background-color: #ececed;
  }
</style>
  

<body style="font-family: Tahoma; font-size: 13px;">
<table style="width: 100%; height: 300px;">
	<tr>
		<td valign=bottom style="width: 5%;">
			<img style="width: 80px; height: 100px;" src="<?=urlencode('assets/adminkit/img/logo-pemkot-small.png')?>">
		</td>
		<td valign=bottom style="width: 90%; text-align:center;">
			<h5 class="top_header">PEMERINTAH KOTA MANADO</h5>
			<h5 class="top_header">BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA</h5>
			<h5 class="address_header">Jalan Balai Kota No. 1, Manado, 95124</h5>
			<h5 class="footer_header">website: bkd.manadokota.go.id | email: bkdkotamanado@gmail.com</h5>
		</td>
		<td valign=bottom style="width: 5%;">
			<!-- <img style="width: 90px; height: 100px;" src="<?=urlencode(('assets/adminkit/img/logo-siladen-small.png'))?>"> -->
		</td>
	</tr>
	<tr>
		<td colspan=3 style="border-bottom: 3px solid black;"></td>
	</tr>
</table>


<br>
<span style='font-family:"Arial",sans-serif;'><b>Jumlah ASN Kota Manado Menurut Jenis Jabatan Per Unit Kerja Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
<table style="border-collapse: collapse; border: none; width: 100%;border: 1pt solid black;" class="fr-table-selection-hover">
    <tbody>
        <tr style="">
            <td style="width: 5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>No</span></p>
            </td>
            <td style="width: 57.5%; border-top: 1pt solid black; border-right: 1pt solid black; border-bottom: 1pt solid black; border-image: initial; border-left: none; padding: 0cm 5.4pt; height: 12.3pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Unit Kerja</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Struktural</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Fungsional</span></p>
            </td>
              <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Fungsional</span></p>
            </td>
           
        </tr>
         <?php $no = 1;  
      
          foreach($result['skpd'] as $lj){ ?>
        <tr>
              <td style="width: 5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$no++?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'><?=$lj['nama']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?php if(isset($lj['total_struktural'])) echo $lj['total_struktural']; else echo 0;?></p>
            </td>
             <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?php if(isset($lj['total_jft'])) echo $lj['total_jft']; else echo 0;?></p>
            </td>
              <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?php if(isset($lj['total_pelaksana'])) echo $lj['total_pelaksana']; else echo 0;?></p>
            </td>
          
        </tr>
<?php } ?>
    
    </tbody>
</table>




<script>
    $(function(){
      renderChart('<?=json_encode($data_statuspeg)?>')
    })

    function renderChart(rs){
      let dt = JSON.parse(rs)
      console.log("yor")
      // document.addEventListener("DOMContentLoaded", function() {
        let labels = [];
        let values = [];
        let temp = Object.keys(dt.result)
        temp.forEach(function(i) {
          if(dt.result[i].jumlah > 0){
            labels.push(dt.result[i].nama)
            values.push(dt.result[i].jumlah)
          }
        })

        console.log(values)
       

        let colors = JSON.parse('<?=json_encode(CHART_COLORS)?>')                
        // let data_labels = 
        new Chart(document.getElementById(dt.id_chart), {
          type: "doughnut",
          data: {
            labels: labels,
            datasets: [{
              data: values,
              backgroundColor: colors,
              borderColor: "transparent"
            }]
          },
          options: {
            maintainAspectRatio: false,
            legend: {
              display: false
            }
          }
        });
      // });
    }

   
</script>