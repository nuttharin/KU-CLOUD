var options = {
    cellHeight: 80,
    verticalMargin: 10,
    float: false
};

class gridDashboard{

    constructor(x,y,width,height,id,type)
    {
        this.x = x;
        this.y = y;
        this.width = width;
        this.height = height;
        this.id = id;
        this.type = type;
    }
}

class gridList extends gridDashboard{
    constructor(grid)
    {
        super(grid.x,grid.y,grid.width,grid.height,grid.id,grid.type);
    }

}



var obj_grid = [];

$(".grid-stack").gridstack(options);
new function () {
    this.items = [{
        x: 0,
        y: 0,
        width: 6,
        height: 7,
    }];

    this.grid = $(".grid-stack").data("gridstack");

    this.addNewWidget = function () {
        var divId = Math.random();
        var divIdMap = Math.floor(100000 + Math.random() * 900000);
        var node = this.items.pop() || {
            x: 3,
            y: 4,
            width: 6,
            height: 7,
        };

        var title_name = $("#title-name").val();
        var type_chart = $("#type-chart").val();

        var wi = "";

        if (type_chart === 'line') {
            wi = '<canvas id="myChart_' + divId + '"></canvas>'
        } else if (type_chart === 'Gauges') {
            wi = '<div id="' + divId + '" class="gauge"></div>'
        } else if (type_chart === 'Map') {
            wi = '<div id="mymap_' + divIdMap + '"></div>'
        }

        var layout_widget = $("#layout-widget").html();
        layout_widget = layout_widget.replace("((wi))", wi)
        layout_widget = layout_widget.replace("((title_name))", title_name)

        var data_widget = {
            id: divId,
            type: type_chart,
            x: 3,
            y: 4,
            width: 6,
            height: 7,
        }
        
        var test = new gridList(data_widget);
        obj_grid.push(test);

        console.log(obj_grid);

        layout_widget = layout_widget.replace("((data_widget))", JSON.stringify(data_widget))


        var g = this.grid.addWidget(
            $(layout_widget),
            node.x,
            node.y,
            node.width,
            node.height,
        );

        g.attr('id',divId);
        g.attr('type',type_chart);
        
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
            case 'Map':
                var mymap = addMap(divIdMap);
                break;
        }
        console.log(obj_grid);
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
                id:el[0].id
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
        } else if (type == 'Map') {
            $("#map").show();
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
var mymap;

function addMap(divIdMap) {
    var mapid = "mymap_" + divIdMap;
    
    $('#' + mapid).css('height', '100%');
    $('#' + mapid).css('width', 'auto');

    mymap = L.map(mapid, {
        dragging: false,
        zoomAnimation: false,
        zoomControl: false,
        scrollWheelZoom:false,
    });




    //var marker = L.marker([13.746159, -259.971886]).addTo(mymap).bindPopup("Hello World");
    //var marker2 = L.marker([13.947812, -259.196320]).addTo(mymap).bindPopup("Hello World 2");

    $.getJSON('https://raw.githubusercontent.com/apisit/thailand.json/master/thailand.json').then(function (geoJSON) {
        var osm = new L.TileLayer.BoundaryCanvas("https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}", {
            boundary: geoJSON,
            minZoom: 5,
            maxZoom: 9,
            invalidateSize:true,
            attribution: '&copy; Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ'
        });

        mymap.addLayer(osm);
        var ukLayer = L.geoJSON(geoJSON);
        mymap.fitBounds(ukLayer.getBounds());
    });

    //L.control.pan().addTo(mymap);
    //L.control.zoom().addTo(mymap);

    /*function onMapClick(e) {
        marker = new L.marker(e.latlng, { draggable: 'true' }).bindPopup(e.latlng.lat + " " + e.latlng.lng);
        marker.on('dragend', function (event) {
            var marker = event.target;
            var position = marker.getLatLng();
            marker.setLatLng(new L.LatLng(position.lat, position.lng), { draggable: 'true' }).bindPopup(position.lat + " " + position.lng);
            mymap.panTo(new L.LatLng(position.lat, position.lng))
        });
        mymap.addLayer(marker);
    };*/

    //mymap.on('click', onMapClick);

    setTimeout(function(){ mymap.invalidateSize()}, 400);
}


$('.grid-stack').on('change', function (e, items) {
    if(mymap != null)
    mymap.invalidateSize(true)
});

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

function updateDateGauge(gg1) {
    gg1.refresh(getRandomInt(0, 100));
}
