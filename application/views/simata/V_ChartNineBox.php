
   <canvas id="chartId" aria-label="chart" height="300" width="580"></canvas>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/chart.min.js"></script>
   <script>
      var chrt = document.getElementById("chartId").getContext("2d");
      var chartId = new Chart(chrt, {
         type: 'scatter',
         data: {
            labels: ["HTML", "CSS", "JAVASCRIPT", "CHART.JS", "JQUERY", "BOOTSTRP"],
            datasets: [{
               label: "online tutorial subjects",
               data: [
                  {x:10, y:14},
                  {x:25, y:35},
                  {x:21, y:20},
                  {x:35, y:28},
                  {x:15, y:10},
                  {x:19, y:30},
               ],
               backgroundColor: ['yellow', 'aqua', 'pink', 'lightgreen', 'gold', 'lightblue'],
               borderColor: ['black'],
               radius: 8,
            }],
         },
         options: {
            responsive: false,
            scales: {
               x: {
                min: 0,
                max: 100,
                  type: 'linear',
                  position: 'bottom,'
               },
               y: {
                min: 0,
                max: 100,
                  type: 'linear',
                  position: 'bottom,'
               }
            }
         },
      });
   </script>
