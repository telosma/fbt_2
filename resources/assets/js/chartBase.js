/* global MONTHS, SendRequest */

function chartBase(url, type, canvas, units) {
    var current = this;
    this.chart = null;
    this.url = url;
    this.units = typeof units !== 'undefined' ? units : 'Revenue';
    this.canvas = typeof canvas !== 'undefined' ? canvas : $('#canvas');
    this.labels = [];
    this.values = [];
    this.type = typeof type !== 'undefined' ? type : 'bar';
    this.loadData = function () {
        SendRequest.send(current.url, null, 'get', function (data) {
            current.labels = data.responseJSON.labels;
            current.values = data.responseJSON.values;
            console.log(data);
        });
    };
    this.drawChart = function () {
        current.loadData();
        current.chart = new Chart(current.canvas, {
            type: current.type,
            data: {
                labels: current.labels,
                datasets: [{
                        label: current.units,
                        backgroundColor: randomColor(),
                        data: current.values,
                    }],

            },
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(0, 0, 0)',
                        borderSkipped: 'bottom',
                    },
                },
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });
    };
    return this;
}