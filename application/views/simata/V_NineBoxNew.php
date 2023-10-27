<style>


.parent {
display: grid;
grid-template-columns: repeat(5, 1fr);
grid-template-rows: repeat(5, 1fr);
grid-column-gap: 0px;
grid-row-gap: 0px;
}

.div4 { grid-area: 1 / 1 / 2 / 2;border: 2px solid;background-color: #fcb92c }
.div7 { grid-area: 1 / 2 / 2 / 3;border-top: 2px solid;border-bottom: 2px solid;background-color: #1cbb8c }
.div9 { grid-area: 1 / 3 / 2 / 4;border: 2px solid;background-color: #1cbb8c }
.div2 { grid-area: 2 / 1 / 3 / 2;border-left: 2px solid; border-right: 2px solid; background-color: #be4d4d}
.div5 { grid-area: 2 / 2 / 3 / 3;background-color: #fcb92c }
.div8 { grid-area: 2 / 3 / 3 / 4;border-right: 2px solid;border-left: 2px solid;background-color: #1cbb8c }
.div1 { grid-area: 3 / 1 / 4 / 2;border: 2px solid; background-color: #be4d4d}
.div3 { grid-area: 3 / 2 / 4 / 3;border-bottom: 2px solid;border-top: 2px solid; background-color: #be4d4d}
.div6 { grid-area: 3 / 3 / 4 / 4;border: 2px solid;background-color: #fcb92c }

/* .div4 { grid-area: 1 / 1 / 2 / 2;background-color: #fcb92c }
.div7 { grid-area: 1 / 2 / 2 / 3;background-color: #1cbb8c }
.div9 { grid-area: 1 / 3 / 2 / 4;background-color: #1cbb8c }
.div2 { grid-area: 2 / 1 / 3 / 2;background-color: #be4d4d}
.div5 { grid-area: 2 / 2 / 3 / 3;background-color: #fcb92c }
.div8 { grid-area: 2 / 3 / 3 / 4;background-color: #1cbb8c }
.div1 { grid-area: 3 / 1 / 4 / 2;background-color: #be4d4d}
.div3 { grid-area: 3 / 2 / 4 / 3;background-color: #be4d4d}
.div6 { grid-area: 3 / 3 / 4 / 4;background-color: #fcb92c } */

.divred {  }

table.divred td {
  
}

table tr td.red
{
    background-color: #be4d4d;
    width: 10vw;
    height: 25vh;
}

table tr td.orange
{
    background-color: #fcb92c;
    width: 10vw;
    height: 25vh;
}

table tr td.green
{
    background-color: #1cbb8c;
    width: 10vw;
    height: 25vh;
}
</style>
    <div class="row ml-2">
    
    <div class="card card-default col-lg-6">
        <div class="card-body">

        <!-- <table class="table table-bordered" border="1">
<tbody border="1">
<tr>
<td class="orange"  >
4
</td>
<td  class="green">&nbsp;7</td>
<td class="green">&nbsp;9</td>
</tr>
<tr>
<td class="red"  >
3
</td>
<td class="orange"  >
5
</td>
<td class="green">&nbsp;8</td>
</tr>
<tr>
<td class="red" >
1

</td>
<td class="red" >
3
</td>
<td class="orange"   >&nbsp;6 </td>
</tr>
</tbody>
</table> -->

       
        <div class="parent">
        <div class="div4">
        <canvas id="myChart4" style="height:25vh; width:10vw"></canvas>
        </div>
        <div class="div7">
        <canvas id="myChart7" style="height:25vh; width:10vw"></canvas>
        </div>
        <div class="div9">
        <canvas id="myChart9" style="height:25vh; width:10vw"></canvas>
        </div>
        <div class="div2">
        <canvas id="myChart2" style="height:25vh; width:10vw"></canvas>
        </div>
        <div class="div5">
        <canvas id="myChart5" style="height:25vh; width:10vw"></canvas>
        </div>
        <div class="div8">
        <canvas id="myChart8" style="height:25vh; width:10vw"></canvas>
        </div>
        <div class="div1">
        <canvas id="myChart" style="height:25vh; width:10vw"></canvas>
        </div>
        <div class="div3">
        <canvas id="myChart3" style="height:25vh; width:10vw"></canvas>
        </div>
        <div class="div6">
        <canvas id="myChart6" style="height:25vh; width:10vw"></canvas>
        </div>
        </div>

        </div>
    </div>
   
  
</div>

<?php

           $nilai['result'] = $result;
           $data_pendidikan['id_chart'] = 'chart_pendidikan';
          ?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
<script>

$(function(){          
    // renderChart()
    })

    
    var dx = JSON.parse('<?=json_encode($nilai)?>');
    var c = [];
    let point = [];
    let temp = Object.keys(dx.result)
    temp.forEach((i) => {
          var nilaiy =  parseFloat(dx.result[i].res_potensial_cerdas) + parseFloat(dx.result[i].res_potensial_rj) + parseFloat(dx.result[i].res_potensial_lainnya);
          point.push({ x: dx.result[i].res_kinerja, y: nilaiy, nama:"Youri" })
    });
    console.log(point)
    var data1 = point;
    
const data = {
datasets: [{
  // label : 'tes',
  data: data1,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: "#000",
      pointBorderColor: "#000",
      pointRadius: 2,
      pointHoverRadius: 2,  
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

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('I', x.getPixelForValue(35), y.getPixelForValue(30)) 
  }) 
}

const config = {
type: 'scatter',
data,
options: {
  plugins: {
      legend: {
          display: false
      }, 
      tooltip:{
        callbacks:{
          label: (context) => {
            console.log(context)
            // return `Nama new line Pegawai - x: ${context.raw.x} and y: ${context.raw.y}`;
            return ["Kinerja: "+context.raw.x, "Potensial: "+context.raw.y, context.raw.nama];
          },
          labelColor: function(context) {
                        return {
                            borderColor: 'rgb(0, 0, 255)',
                            backgroundColor: 'rgb(255, 0, 0)',
                            borderWidth: 1,
                            // borderDash: [1, 1],
                            borderRadius: 1,
                        };
                    },
          // labelTextColor: function(context) {
          // return '#543453';
          // }
        }
      }
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: 0,
     max: 69.99,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: 0,
     max: 69,
     afterTickToLabelConversion: (ctx) => {
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels]
};

// function renderChart(){  
const myChart = new Chart(
document.getElementById('myChart'),
config
);
// }


</script>

<!-- dua  -->
<script>
const nineGridLabels2 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('II', x.getPixelForValue(35), y.getPixelForValue(77)) 
  }) 
}

const config2 = {
type: 'scatter',
data: {datasets: [{
  data: data1,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: "#000",
      pointBorderColor: "#000",
      pointRadius: 2,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
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
     max: 69.99,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: 70,
     max: 84.99,
     afterTickToLabelConversion: (ctx) => {
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels2]
};

const myChart2 = new Chart(
document.getElementById('myChart2'),
config2
);
</script>



<script>
const nineGridLabels3 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('III', x.getPixelForValue(77), y.getPixelForValue(30)) 
  }) 
}

const config3 = {
type: 'scatter',
data: {datasets: [{
  data: data1,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: "#000",
      pointBorderColor: "#000",
      pointRadius: 2,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      }
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: 70,
     max: 85,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: 0,
     max: 69,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels3]
};

const myChart3 = new Chart(
document.getElementById('myChart3'),
config3
);
</script>


<!-- empat -->
<script>
const nineGridLabels4 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('IV', x.getPixelForValue(35), y.getPixelForValue(92)) 
  }) 
}

const config4 = {
type: 'scatter',
data: {datasets: [{
  data: data1,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: "#000",
      pointBorderColor: "#000",
      pointRadius: 2,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
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
     max: 69.99,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: 85    ,
     max: 100,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels4]
};

const myChart4 = new Chart(
document.getElementById('myChart4'),
config4
);
</script>



<!-- lima -->
<script>
const nineGridLabels5 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('V', x.getPixelForValue(77), y.getPixelForValue(77)) 
  }) 
}

const config5 = {
type: 'scatter',
data: {datasets: [{
  data: data1,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: "#000",
      pointBorderColor: "#000",
      pointRadius: 2,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      }
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: 70,
     max: 84.99,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: 70,
     max: 84.99,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels5]
};

const myChart5 = new Chart(
document.getElementById('myChart5'),
config5
);
</script>



<!-- enam -->
<script>
const nineGridLabels6 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('VI', x.getPixelForValue(92), y.getPixelForValue(31)) 
  }) 
}

const config6 = {
type: 'scatter',
data: {datasets: [{
  data: data1,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: "#000",
      pointBorderColor: "#000",
      pointRadius: 2,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      }
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: 85,
     max: 100,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: 0,
     max: 69.99,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels6]
};

const myChart6 = new Chart(
document.getElementById('myChart6'),
config6
);
</script>



<!-- tujuh -->
<script>
const nineGridLabels7 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('VII', x.getPixelForValue(77), y.getPixelForValue(92)) 
  }) 
}

const config7 = {
type: 'scatter',
data: {datasets: [{
  data: data1,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: "#000",
      pointBorderColor: "#000",
      pointRadius: 2,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      }
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: 70,
     max: 84.99,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: 85,
     max: 100,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels7]
};

const myChart7 = new Chart(
document.getElementById('myChart7'),
config7
);
</script>



<!-- delapan -->
<script>
const nineGridLabels8 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('VIII', x.getPixelForValue(92), y.getPixelForValue(77)) 
  }) 
}

const config8 = {
type: 'scatter',
data: {datasets: [{
  data: data1,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: "#000",
      pointBorderColor: "#000",
      pointRadius: 2,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      }
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: 85,
     max: 100,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: 70,
     max: 84.99,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels8   ]
};

const myChart8 = new Chart(
document.getElementById('myChart8'),
config8
);
</script>



<!-- sembilan -->
<script>
const nineGridLabels9 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('IX', x.getPixelForValue(92), y.getPixelForValue(92)) 
  }) 
}

const config9 = {
type: 'scatter',
data: {datasets: [{
  data: data1,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: "#000",
      pointBorderColor: "#000",
      pointRadius: 2,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      },
      tooltip:{
        callbacks:{
          label: (context) => {
            console.log(context)
            return ["Kinerja: "+context.raw.x, "Potensial: "+context.raw.y, context.raw.nama];
          },
          labelColor: function(context) {
                        return {
                            borderColor: 'rgb(0, 0, 255)',
                            backgroundColor: 'rgb(255, 0, 0)',
                            borderWidth: 1,
                            borderRadius: 1,
                        };
            }
        }
      }
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: 85,
     max: 100,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: 85,
     max: 100,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels9]
};

const myChart9 = new Chart(
document.getElementById('myChart9'),
config9
);
</script>