<canvas id="bar-chart" width="100" height="500"></canvas>
<script>
    $(function() {
        var myChart;
        $data = {!! json_encode($data) !!};
        $data_x = {!! json_encode($data_x) !!};
        $data_y = {!! json_encode($data_y) !!};
        $data_label = {!! json_encode($data_label) !!};
        $('#bar-chart').attr("id", $data_label);

        $labels_x = [];
        $y = [];
        $x_y = [];
        $background_color = [];
        $.each($data, function(key, value) {
            $labels_x.push(value[$data_x]);
            $y.push(value[$data_y]);
            $x_y.push({
                x: value[$data_x],
                y: value[$data_y],
            });
            $background_color.push(getRandomColor());
        });
        myChart = new Chart(document.getElementById($data_label), {
            type: 'bar',
            data: {
                labels: $labels_x,
                datasets: [{
                    label: $data_label,
                    backgroundColor: $background_color,
                    data: $y
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    });

    function getRandomColor() {
        const randomBetween = (min, max) => min + Math.floor(Math.random() * (max - min + 1));
        const r = randomBetween(0, 255);
        const g = randomBetween(0, 255);
        const b = randomBetween(0, 255);
        const rgba = `rgba(${r},${g},${b},1)`;
        return rgba;
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
