document.addEventListener("DOMContentLoaded", function () {
    am4core.useTheme(am4themes_animated);
    var chart = am4core.create("chartdiv", am4charts.PieChart);
    chart.hiddenState.properties.opacity = 0;

    fetch('chart-investments')
        .then(response => response.json())
        .then(data => {

            if (data && data.chartData && data.chartData.length > 0) {

                chart.data = data.chartData;

                chart.radius = am4core.percent(70);
                chart.innerRadius = am4core.percent(40);
                chart.startAngle = 180;
                chart.endAngle = 360;

                var series = chart.series.push(new am4charts.PieSeries());
                series.dataFields.value = "sectorsCount";
                series.dataFields.category = "sector"; 
                series.slices.template.cornerRadius = 10;
                series.slices.template.innerCornerRadius = 7;
                series.slices.template.draggable = true;
                series.slices.template.inert = true;

                var legend = new am4charts.Legend();
                chart.legend = legend;

                legend.align = "center";
                legend.width = am4core.percent(80);

                series.hiddenState.properties.startAngle = 90;
                series.hiddenState.properties.endAngle = 90;

                chart.invalidateData();
                chart.validateData();
            } else {
                console.error('Invalid or empty data:', data);
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
});