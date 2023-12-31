document.addEventListener("DOMContentLoaded", function () {

    am4core.useTheme(am4themes_animated);

    var chart = am4core.create("chart-div", am4plugins_forceDirected.ForceDirectedTree);

    var networkSeries = chart.series.push(new am4plugins_forceDirected.ForceDirectedSeries())

    fetch('http://localhost:8080/chart-investments')
        .then(response => response.json())
        .then(data => {
            if (data && data.chartData && data.chartData.length > 0) {

                chart = data.chartData;
                chartLagi = data.chartInnov
                investment = data.invest;
                investmentCount = data.investmentsCount;
                innovations = data.innov;
                innovationsCount = data.innovationsCount;

                networkSeries.data = [{
                    name: investment,
                    value: ' (' + investmentCount + ')',
                    fixed: false,
                    x: am4core.percent(50),
                    y: am4core.percent(50),
                    children: chart.map(function (val) {
                        return {
                            name: val.sector,
                            value: ' (' + val.sectorsCount + ')',
                            children: val.sectorsIdCount.map(function (idCount) {
                                return {
                                    name: idCount.id + ' : ' + idCount.idsector
                                };
                            })
                        };
                    })
                }
                ];

                networkSeries.dataFields.linkWith = "linkWith";
                networkSeries.dataFields.name = "name";
                networkSeries.dataFields.id = "name";
                networkSeries.dataFields.value = "value";
                networkSeries.dataFields.children = "children";
                networkSeries.dataFields.fixed = "fixed";

                networkSeries.nodes.template.propertyFields.x = "x";
                networkSeries.nodes.template.propertyFields.y = "y";

                networkSeries.nodes.template.tooltipText = "{name} {value}" ? "{name} {value}" : "{name}";
                networkSeries.nodes.template.fillOpacity = 1;

                networkSeries.nodes.template.label.text = "{name}";
                networkSeries.fontSize = 10;
                networkSeries.maxLevels = 3;
                networkSeries.nodes.template.label.hideOversized = true;
                networkSeries.nodes.template.label.truncate = true;
            } else {
                console.error('Invalid or empty data:', data);
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
});