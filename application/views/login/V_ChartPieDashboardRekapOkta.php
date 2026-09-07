
<script>
    $(function(){
        renderChart('<?=json_encode($result)?>')
    })

    function renderChart(rs){
        let dt = JSON.parse(rs)
        let labels = [];
        let values = [];
        let temp = Object.keys(dt)
        temp.forEach(function(i) {
            if(dt[i].total > 0){
                labels.push(dt[i].nama_layanan)
                values.push(dt[i].total)
            }
        })

        let colors = JSON.parse('<?=json_encode(CHART_COLORS)?>')                
        new Chart(document.getElementById('<?=$id_chart?>'), {
            type: "pie",
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