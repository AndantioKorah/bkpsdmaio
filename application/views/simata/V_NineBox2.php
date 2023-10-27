   <canvas id="chartId" aria-label="chart" height="300" width="580"></canvas>


<?php
           $data_pendidikan['result'] = $chart['pendidikan'];
           $data_pendidikan['id_chart'] = 'chart_pendidikan';
           $nilai['result'] = $result;
           $data_pendidikan['id_chart'] = 'chart_pendidikan';
          ?>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/chart.min.js"></script>
   <script>
     
    $(function(){
    //   render3('<?=json_encode($data_pendidikan)?>')
    })

 


  
       
    

    var dx = JSON.parse('<?=json_encode($nilai)?>');
    var c = [];
    let elementx = [];
    let tempx = Object.keys(dx.result)

    tempx.forEach((i) => {
          elementx.push({ x: dx.result[i].res_kinerja, y: dx.result[i].res_potensial_cerdas })
    });

    console.log("xx")
      console.log(elementx)


    // function render3(){
       
      let dt = JSON.parse('<?=json_encode($data_pendidikan)?>')
      
      let labels = [];
      let values = [];
      let obj = [];
      var z = [];
      let element = [];
      let temp = Object.keys(dt.result)

      temp.forEach(function(i) {
          labels.push(dt.result[i].nama)
          values.push(dt.result[i].jumlah)
          obj.push('{x:' + dt.result[i].jumlah + ',' + 'y:' + dt.result[i].jumlah + '}')
          element.push({ x: dt.result[i].jumlah, y: dt.result[i].jumlah })
          z.push(values);
      })
      console.log("zz")
      console.log(element)

// }

var data1 = elementx        
    // var data1 = [
    //   {x: 11, y: 30},
    //   {x: 10.5, y: 50},
    //   {x: 11.5, y: 30},
    //   {x: 12, y: 30},
    //   {x: 10.75, y: 30},
    //   {x: 12.4, y: 30},
    //   {x: 20, y: 30},
    // ];

    const staffsDetails = [
                        { name: "Jam Josh", age: 44, salary: 4000, currency: "USD" },
                        { name: "Justina Kap", age: 34, salary: 3000, currency: "USD" },
                        { name: "Chris Colt", age: 37, salary: 3700, currency: "USD" },
                        { name: "Jane Doe", age: 24, salary: 4200, currency: "USD" }
                        ];
                        
console.log(data1)





    //   var ctx = document.getElementById("chartId").getContext("2d");

//  function renderChart(){
    
        new Chart(document.getElementById("chartId"), {
            type: 'bubble',
            data: {
                labels: ["HTML", "CSS", "JAVASCRIPT", "CHART.JS", "JQUERY", "BOOTSTRP"],
                datasets: [{
                label: "online tutorial subjects",
                data:  data1,
                backgroundColor: ['yellow', 'aqua', 'pink', 'lightgreen', 'gold', 'lightblue'],
                borderColor: ['black'],
                radius: 3,
                }],
            },
            aspectRatio : 1   ,
            options: {
                plugins: {
                legend: {
                    display: false
                    }
                    },
                responsive: false,
                scales: {
                x: {
                    min: 0,
                    max: 100,
                    afterTickToLabelConversion: (ctx) => {
                    console.log(ctx)
                    //   ctx.ticks = [];
                    }
                },
                y: {
                    min: 0,
                    max: 100,
                    afterTickToLabelConversion: (ctx) => {
                    console.log(ctx)
                    //   ctx.ticks = [];
                    }
                }
                }
            },
        });
//  }
      
 





function getNilaiPegawai(){
            $.ajax({
              url: '<?=base_url("simata/C_Simata/getPenilaianPegawai")?>',
              method: 'post',
              data: null,
              success: function(data){
                let rs = JSON.parse(data)
               const dataa = data
                
              }, error: function(e){
                  errortoast('Terjadi Kesalahan')
                  console.log(e)
              }
            })
          }

   </script>
