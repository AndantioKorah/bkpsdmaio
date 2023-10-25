   <canvas id="chartId" aria-label="chart" height="300" width="580"></canvas>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/chart.min.js"></script>
   <script>

    $(function(){          
    // renderChart()
    })

    var nilai = <?=json_encode($result)?>

    const staffsDetails = [
                            { name: "Jam Josh", age: 44, salary: 4000, currency: "USD" },
                            { name: "Justina Kap", age: 34, salary: 3000, currency: "USD" },
                            { name: "Chris Colt", age: 37, salary: 3700, currency: "USD" },
                            { name: "Jane Doe", age: 24, salary: 4200, currency: "USD" }
                            ];
  console.log(nilai)
  console.log(staffsDetails)


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


var c = [];
nilai.forEach((nilai) => {
  let poin = nilai.res_kinerja+' && '+nilai.res_potensial;
  var obj ='{x:' + nilai.res_kinerja + ',' + 'y:' + nilai.res_potensial + '}';
  var element = { x: nilai.res_kinerja, y: nilai.res_kinerja };
                c.push(obj);
});

// staffsDetails.forEach((staffDetail) => {
//   let sentence = `I am ${staffDetail.name} a staff of Royal Suites.`;
//   console.log(sentence);
// });




var data1 =  [{x:93.00,y:80.00}, {x:94.00,y:82.67}]
   

            
    // var data1 = [
    //   {x: 11, y: 30},
    //   {x: 10.5, y: 50},
    //   {x: 11.5, y: 30},
    //   {x: 12, y: 30},
    //   {x: 10.75, y: 30},
    //   {x: 12.4, y: 30},
    //   {x: 9.6 + 20, y: 30},
    //   {x: 10 + 20, y: 20},
    //   {x: 11 + 20, y: 30},
    //   {x: 10.5 + 20, y: 20},
    //   {x: 11.5 + 20, y: 30},
    //   {x: 12 + 20, y: 30},
    //   {x: 10.75 + 20, y: 10},
    //   {x: 12.4 + 20, y: 30},
    //   {x: 9.6 + 20, y: 10},
    // ];




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
      
   </script>
