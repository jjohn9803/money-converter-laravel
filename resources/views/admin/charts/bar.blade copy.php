{{-- <select class="form-select" aria-label="Default select example" id='canvas-curr'>
    <option selected>Open this select menu</option>
    <option value="1">USD</option>
    <option value="2">EUR</option>
    <option value="3">SGD</option>
    <option value="4">JPY</option>
    <option value="5">KRW</option>
</select> --}}
<canvas id="line-chart" width="100" height="500"></canvas>
<script>
    var myChart;
    $(function() {
        $labels_dates = [];
        $data_rate = [];
        $data_label = [];
        myChart = new Chart(document.getElementById("line-chart"), {
            type: 'line',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                title: {
                    display: true,
                    text: 'World population per region (in millions)'
                },
                responsive: true,
                maintainAspectRatio: false,
            }
            /* data: {
                labels: [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050],
                datasets: [{
                    data: [86, 114, 106, 106, 107, 111, 133, 221, 783, 2478],
                    label: "Africa",
                    borderColor: "#3e95cd",
                    fill: false
                }, {
                    data: [282, 350, 411, 502, 635, 809, 947, 1402, 3700, 5267],
                    label: "Asia",
                    borderColor: "#8e5ea2",
                    fill: false
                }, {
                    data: [168, 170, 178, 190, 203, 276, 408, 547, 675, 734],
                    label: "Europe",
                    borderColor: "#3cba9f",
                    fill: false
                }, {
                    data: [40, 20, 10, 16, 24, 38, 74, 167, 508, 784],
                    label: "Latin America",
                    borderColor: "#e8c3b9",
                    fill: false
                }, {
                    data: [6, 3, 2, 2, 7, 26, 82, 172, 312, 433],
                    label: "North America",
                    borderColor: "#c45850",
                    fill: false
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'World population per region (in millions)'
                }
            } */
        });
        //chart();
        //return;
        $.ajax({
            type: 'GET',
            url: '/admin/get-recent',
            dataType: "json",
            async: true,
            success: function(data) {
                $data_label = Object.keys(data);
                $.each(data, function(key, value) {
                    $arr_rate = [];
                    $arr_date = [];
                    $.each(value, function(key2, value2) {
                        var date = value2['date'];
                        var rate = value2['rate'];
                        $arr_rate.push(rate);
                        $arr_date.push(date);
                    });
                    $data_rate.push($arr_rate);
                    $labels_dates.push($arr_date);
                });
                /* console.log($data_label);
                console.log($data_rate);
                console.log($labels_dates[0]); */
                addLabel(myChart, $labels_dates[0]);
                //addData(myChart, $data_label[0], getRandomColor(), $data_rate[0], false);
                for (let index = 0; index < $data_label.length; index++) {
                    const dataset_label = $data_label[index];
                    const dataset_data = $data_rate[index];
                    //addData(myChart, dataset_label, getRandomColor(), dataset_data, true);
                    if (index == 0) {
                        addData(myChart, dataset_label, getRandomColor(), dataset_data, false);
                    } else {
                        addData(myChart, dataset_label, getRandomColor(), dataset_data, true);
                    }
                }
            },
            error: function(data) {
                console.log(data);
            }
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
            data: data
        });
        chart.update();
    }
</script>
