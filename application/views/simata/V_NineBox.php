<style>

.chartBox {
  width: 100%;
  height: 100%;
  /* padding: 10px; */
  border-radius: 10px;
  border: solid 3px #222e3c;
  background: white;
}


</style>
    <div class="row ml-2">
    
    <div class="card card-default col-lg-7">
        <div class="card-body">
        <!-- <div class="chartCard"> -->
        <div class="chartBox">
        <canvas id="myChart" style="height:75vh; width:80vw"></canvas>
        </div>
        <!-- </div> -->
        </div>
    </div>
   
    <div class="card card-default col-lg-4 ml-3">
        <div class="card-body" >
        2
        </div>
    </div>

</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
<script>
    $(function(){
myChart.ctx.canvas.removeEventListener('wheel', myChart._wheelHandler);
      
    })

// setup 
const data = {
datasets: [{
  label : 'tes',
  data: [ 
      {x : 10, y:70},
      {x : 98, y:95},
      {x : 97, y:97}
      ],
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: "#dc3545",
      pointBorderColor: "#dc3545",
      

  borderWidth: 1
}],

};

const nineGridLabels = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   const nineLabels = {
      labels: [
          {name: 'I',    x: 16.65, y: 16.65},
          {name: 'II',   x: 16.65, y: 49.95},
          {name: 'IV',  x: 16.65, y: 83.25},
          {name: 'III',   x: 49.95, y: 16.65},
          {name: 'V',    x: 49.95, y: 49.95},
          {name: 'VII',   x: 49.95, y: 83.25},
          {name: 'VI',  x: 83.25, y: 16.65},
          {name: 'VIII', x: 83.25, y: 49.95},
          {name: 'IX',   x: 83.25, y: 83.25}
      ]
   }

   ctx.save();
   ctx.font = 'bold 16px sans-serif';
   ctx.fillStyle = "#97abc7";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
//    nineLabels.labels.forEach(label => {
//       ctx.fillText(label.name, x.getPixelForValue(label.x), y.getPixelForValue(label.y)) 
//    })
  }) 
}



// config 
const config = {
type: 'scatter',
data,
options: {
  plugins: {
      legend: {
          display: false
      }
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: 0,
     max: 100,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
      ctx.ticks.push({value:69.99, label: ''})
      ctx.ticks.push({value:84.99, label: ''})
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 2
      // dash: [6, 6]
     },
     title: {
      display: true,
      text: 'Potensial',
      font: {
        size: 20
      }
     }
    },
    y: {
     min: 0,
     max: 100,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
      ctx.ticks.push({value:69.99, label: ''})
      ctx.ticks.push({value:84.99, label: ''})
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 2
      // dash: [6, 6]
     },
     title: {
      display: true,
      text: 'Kinerja',
      font: {
        size: 20
      }
     }
    }
  }
},
plugins: [nineGridLabels]
};

// render init block
const myChart = new Chart(
document.getElementById('myChart'),
config
);


// Instantly assign Chart.js version
const chartVersion = document.getElementById('chartVersion');
// chartVersion.innerText = Chart.version;

$('#disable_zoom').click(function(){
    myChart.ctx.canvas.removeEventListener('wheel', myChart._wheelHandler);
});

</script>

