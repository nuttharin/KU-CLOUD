var options = {
    cellHeight: 80,
    verticalMargin: 10,
    float: false
};

$(".grid-stack").gridstack(options);
    new function () {
        this.items = [{
            x: 0,
            y: 0,
            width: 3,
            height: 4,
        }];

    this.grid = $(".grid-stack").data("gridstack");

    this.addNewWidget = function () {
        var divId = Math.random();
        var node = this.items.pop() || {
            x: 3,
            y: 4,
            width: 3,
            height: 4,
        };

        var title_name = $("#title-name").val();
        var type_chart = $("#type-chart").val();
        
        var wi = "";

        if (type_chart === 'line') {
            wi = '<canvas id="myChart_' + divId + '"></canvas>'
        } else if (type_chart === 'Gauges') {
            wi = '<div id="' + divId + '" class="gauge"></div>'
        }

        var layout_widget = $("#layout-widget").html();
        layout_widget = layout_widget.replace("((wi))",wi)
        layout_widget = layout_widget.replace("((title_name))",title_name)

        var data_widget = {
            id:divId,
            type:type_chart
        }

        layout_widget = layout_widget.replace("((data_widget))",JSON.stringify(data_widget))

        console.log(layout_widget);
        
        this.grid.addWidget(
            $(layout_widget),
            node.x,
            node.y,
            node.width,
            node.height,
            node.id
        );

        var setting = {};
        switch (type_chart) {
            case 'line':
                var myChart = AddLine(divId);
                setInterval(function () {
                    updateData(myChart, [45, 50, 30, 34, 61, 53, 42], 0);
                }, 1000);
                break;
            case 'Gauges':
                var g = addGage(divId);
                setInterval(function () {
                    updateDateGauge(g);
                }, 1000);
                break;
        }

        return false;
    }.bind(this);

    this.saveGrid = function () {
        this.serializedData = _.map($('.grid-stack > .grid-stack-item:visible'), function (el) {
            el = $(el);
            var node = el.data('_gridstack_node');
            console.log(node);
            return {
                x: node.x,
                y: node.y,
                width: node.width,
                height: node.height,
            };
        });
        $('#saved-data').val(JSON.stringify(this.serializedData, null, '    '));
        return false;
    }.bind(this);

    $("#add-new-widget").click(this.addNewWidget);
    $("#saveW").click(this.saveGrid);
}();

$(document).ready(function () {
    $("#type-chart").change(function () {
        $(".value_widget").hide();
        var type = $(this).val();
        if (type == 'line') {
            $("#line").show();
        } else if (type == 'bar') {
            $("#bar").show();
        }
    });

    $("#btn-add-value-line").click(function () {
        var html = $("#line_value_layout").html()
        console.log(html);
        $("#line_value").append(html);
    });

    $("#settingW").click(function () {
        $(this).hide();
        $("#addW").show();
        $("#saveW").show();
    });

    $("#saveW").click(function () {
        $(this).hide();
        $("#addW").hide();
        $("#settingW").show();
    });
});


function AddLine(divId) {
    var ctx = document.getElementById("myChart_" + divId);
    var myChart = new Chart(ctx, {
        type: $("#type-chart").val(),
        data: {
            datasets: [{
                label: "# of Votes",
                backgroundColor: $("#rgba").val(),
                borderColor: $("#rgb").val(),
                borderWidth: 1
            }],

        },
        options: {
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    return myChart;

}

function addGage(divId) {
    var g1 = new JustGage({
        id: divId,
        value: getRandomInt(0, 100),
        min: 0,
        max: 100,
        title: "",
        relativeGaugeSize: true,

    });

    return g1;
}

function updateDateGauge(gg1) {
    gg1.refresh(getRandomInt(0, 100));
}


function updateData(myChart, data, datasetIndex) {
    var data = Math.random();
    var d = new Date();
    myChart.data.labels.push(d.toLocaleTimeString());
    myChart.data.datasets.forEach((dataset) => {
        if (dataset.data.length > 10) {
            dataset.data.splice(0, 1);
            myChart.data.labels.splice(0, 1);
        }
        dataset.data.push(data);
    });
    myChart.update();
}
