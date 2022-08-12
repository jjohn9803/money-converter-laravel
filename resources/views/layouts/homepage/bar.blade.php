<canvas id="line-chart"></canvas>
<script>
    var myChart;
    const option = {
        tooltips: {
            mode: 'index',
        },
        interaction: {
            mode: 'index'
        },
        pointHoverBackgroundColor: "red",
        hoverBorderJoinStyle: 'round',
        title: {
            display: true,
            text: 'Fxes Rate'
        },
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                ticks: {
                    color: '#2e2d2f'
                }
            },
            y: {
                ticks: {
                    color: '#2e2d2f'
                }
            },
        },
        legend: {
            labels: {
                fontColor: "blue",
                fontSize: 18
            }
        },
    };

    const tooltipLine = {
        id: 'tooltipLine',
        beforeDraw: chart => {
            const ctx = chart.ctx;
            ctx.save();
            const activePoint = chart.tooltip._active[0];
            if ($(activePoint)[0]) {
                //console.log($(activePoint)[0]['element']['x']);
                ctx.beginPath();
                ctx.setLineDash([5, 7]);
                ctx.moveTo(activePoint.element.x, chart.chartArea.top);
                ctx.lineTo(activePoint.element.x, activePoint.element.y);
                ctx.lineWidth = 2;
                ctx.strokeStyle = 'grey';
                ctx.stroke();
                ctx.restore();

                ctx.beginPath();
                ctx.moveTo(activePoint.element.x, activePoint.element.y);
                ctx.lineTo(activePoint.element.x, chart.chartArea.bottom);
                ctx.lineWidth = 2;
                ctx.strokeStyle = 'grey';
                ctx.stroke();
                ctx.restore();
            }
        }
    };

    const config = {
        type: 'line',
        data: {
            labels: [],
            datasets: []
        },
        options: option,
        plugins: [
            tooltipLine
        ]
    };

    function doTheThing() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    key: 'value',
                },
                success: function(data) {
                    resolve(data)
                },
                error: function(error) {
                    reject(error)
                },
            })
        })
    }

    $(function() {
        $labels_dates = [];
        $data_rate = [];
        $data_label = [];
        //chart();
        //return;
        $.ajax({
            type: 'GET',
            url: '/rt_fxes',
            dataType: "json",
            data: {
                num_dates: 10,
                currency_code: 'USD'
            },
            success: function(data) {
                myChart = new Chart(document.getElementById("line-chart"), config);
                //console.log(data);
                $data_label = "{!! __('content.bank') !!}";
                $our_data = [];
                $.each(data[0], function(key, value) {
                    $data_rate.push(value['rate']);
                    $labels_dates.push(value['date']);
                    var min = 1.0005;
                    var max = 1.00001;
                    var rand = Math.random() * (max - min) + max;
                    //var rand = 1 + (0.00005 * (key + 1));
                    /* $arr_rate = [];
                    $arr_date = [];
                    $.each(value, function(key2, value2) {
                        var date = value2['date'];
                        var rate = value2['rate'];
                        $arr_rate.push(rate);
                        $arr_date.push(date);
                    });
                    $data_rate.push($arr_rate);
                    $labels_dates.push($arr_date); */
                });
                $.each(data[1], function(key, value) {
                    $our_data.push(value['rate']);
                });
                //console.log($data_label);
                //console.log($data_rate);
                //console.log($labels_dates);
                addLabel(myChart, $labels_dates);
                addData(myChart, $data_label, '#d52ac9', $data_rate, false);
                addData(myChart, "{!! __('content.title') !!}", '#d3402c', $our_data, false);
                resetChart();
                return;
                //addData(myChart, $data_label[0], getRandomColor(), $data_rate[0], false);
                for (let index = 0; index < $data_label.length; index++) {
                    const dataset_label = $data_label[index];
                    const dataset_data = $data_rate[index];
                    //addData(myChart, dataset_label, getRandomColor(), dataset_data, true);
                    if (index == 0) {
                        addData(myChart, dataset_label, '#e7e7e8', dataset_data, false);
                    } else {
                        addData(myChart, dataset_label, '#e7e7e8', dataset_data, true);
                    }
                }
            },
            error: function(data) {
                console.log(data);
            }
        });

        $(window).resize(function() {
            resetChart();
        });
    });

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function resetChart() {
        if (typeof myChart !== 'undefined') {
            myChart.destroy();
            myChart = new Chart(document.getElementById("line-chart"), config);
        }
    }

    function chart() {
        addLabel(myChart, [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050]);
        addData(myChart, 'test', '#ff0000', [1, 2, 3, 4, 5]);
        addData(myChart, 'test2', '#ff0000', [12, 28, 32, 41, 55]);
        addData(myChart, 'test3', '#ff0000', [9, 7, 3, 12, 58]);
    }

    function addLabel(chart, label) {
        chart.data.labels = label;
        chart.update();
    }

    function addData(chart, label, color, data, hidden) {
        chart.data.datasets.push({
            label: label,
            hidden: hidden,
            borderColor: color,
            backgroundColor: addAlpha(color, 0.5),
            data: data,
            fill: false,
            lineTension: 0.4,
            radius: 6,
        });
        chart.update();
    }

    function addAlpha(color, opacity) {
        // coerce values so ti is between 0 and 1.
        var _opacity = Math.round(Math.min(Math.max(opacity || 1, 0), 1) * 255);
        return color + _opacity.toString(16).toUpperCase();
    }
</script>
