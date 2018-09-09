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
        height: 4
    }];

    this.grid = $(".grid-stack").data("gridstack");

    this.addNewWidget = function () {
        var node = this.items.pop() || {
            x: 3,
            y: 4,
            width: 3,
            height: 4
        };
        var divId = Math.random();
        var title_name = $("#title-name").val();
        this.grid.addWidget(
            $(
                '<div><div class="panel grid-stack-item-content "><div class="panel__header__min"><div class="panel__edit-buttons"> <i class="fas fa-cog"></i></div></div><header class="panel__header__min"><h5>' +
                title_name +
                '</h5></header><div class="panel__content"><canvas id="myChart_' +
                divId +
                '"></canvas></div></div></div>'
            ),
            node.x,
            node.y,
            node.width,
            node.height
        );

        switch($("#type-chart").val()) {
            case 'line':

                var myChart = AddLine(divId);
                setInterval(function() {
                    updateData(myChart, [45, 50, 30, 34, 61, 53, 42], 0);
                 }, 1000);
                break;
        }

        return false;
    }.bind(this);

    $("#add-new-widget").click(this.addNewWidget);
}();

$(document).ready(function(){
    $("#type-chart").change(function(){
        $(".value_widget").hide();
        var type = $(this).val();
        if(type == 'line')
        {
            $("#line").show();
        }
        else if(type == 'bar')
        {
            $("#bar").show();
        }
    });

    $("#btn-add-value-line").click(function(){
        var html = $("#line_value_layout").html()
        console.log(html);
        $("#line_value").append(html);
    });

    $("#settingW").click(function(){
        $(this).hide();
        $("#addW").show();
        $("#saveW").show();
    });

    $("#saveW").click(function(){
        $(this).hide();
        $("#addW").hide();
        $("#settingW").show();
    });
});


function AddLine(divId)
{
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


function updateData(myChart, data, datasetIndex) {
    var data = Math.random();
    var d = new Date();
    myChart.data.labels.push( d.toLocaleTimeString());
    myChart.data.datasets.forEach((dataset) => {
        if(dataset.data.length > 10)
        {
            dataset.data.splice(0, 1);
            myChart.data.labels.splice(0, 1);
        }
        dataset.data.push(data);
    });
    myChart.update();
    
 
}


