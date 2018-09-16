var options = {
    cellHeight: 80,
    verticalMargin: 10,
    float: false
};

var weather;

var obj_grid = [];

class GridDashboard {

    constructor(widget) {
        this.name = widget.name;
        this.x = widget.x;
        this.y = widget.y;
        this.width = widget.width;
        this.height = widget.height;
        this.id = widget.id;
        this.type = widget.type;
        this.lastUpdate = widget.lastUpdate;
        this.timeInterval = widget.timeInterval;
    }

    getGrid() {
        return this;
    }
}

class ChartLine extends GridDashboard{
    
    constructor(widget)
    {
        super(widget);
        this.valX = widget.valX;
        this.valY = widget.valY;
        this.deviceName = widget.deviceName;
    }
}

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

        var data_widget = {
            id: divId,
            type: type_chart,
            x: 3,
            y: 4,
            width: 6,
            height: 7,
        }

        var widget = new GridDashboard(data_widget);
        obj_grid.push(widget);

        var layout_widget = $("#layout-widget").html();
        layout_widget = layout_widget.replace("((wi))", wi)
        layout_widget = layout_widget.replace("((title_name))", title_name)
        layout_widget = layout_widget.replace("((data_widget))", JSON.stringify(data_widget))


        var g = this.grid.addWidget(
            $(layout_widget),
            node.x,
            node.y,
            node.width,
            node.height,
        );

        //g.attr('id', divId);
        //g.attr('type', type_chart);

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
                id: el[0].id
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

function addMap(divIdMap) {
    var mymap;
    var mapid = "mymap_" + divIdMap;
    $('#' + mapid).css('height', '100%');
    $('#' + mapid).css('width', 'auto');

    mymap = L.map(mapid, {
        dragging: true,
        zoomControl: true,
        scrollWheelZoom: false,
        zoomAnimation: false,
    });

    //var marker = L.marker([13.746159, -259.971886]).addTo(mymap).bindPopup("Hello World");
    //var marker2 = L.marker([13.947812, -259.196320]).addTo(mymap).bindPopup("Hello World 2");

    $.getJSON('https://raw.githubusercontent.com/apisit/thailand.json/master/thailand.json').then(function (geoJSON) {
        var osm = new L.TileLayer.BoundaryCanvas("https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}", {
            boundary: geoJSON,
            minZoom: 5,
            maxZoom: 9,
            attribution: '&copy; Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ'
        });

        mymap.addLayer(osm);
        var ukLayer = L.geoJSON(geoJSON);
        mymap.fitBounds(ukLayer.getBounds());
    });

    //L.control.pan().addTo(mymap);
    //L.control.zoom().addTo(mymap);

    /*function onMapClick(e) 
    {
        marker = new L.marker(e.latlng, { draggable: 'true' }).bindPopup(e.latlng.lat + " " + e.latlng.lng);
        marker.on('dragend', function (event) {
            var marker = event.target;
            var position = marker.getLatLng();
            marker.setLatLng(new L.LatLng(position.lat, position.lng), { draggable: 'true' }).bindPopup(position.lat + " " + position.lng);
            mymap.panTo(new L.LatLng(position.lat, position.lng))
        });
        mymap.addLayer(marker);
    };*/

    function disableGrid() {
        //$("#" + divIdContent).draggable( { obstacle: ".grid-stack", preventCollision: true } );
        var grid = $('.grid-stack').data('gridstack');
        grid.enableMove(false);
    }

    function enableGrid() {
        var grid = $('.grid-stack').data('gridstack');
        grid.enableMove(true);
    }

    $('.grid-stack').on('change', function (e, items) {
        if (mymap != null) {
            mymap.invalidateSize(true);
        }
    });

    //mymap.on('click', onMapClick);
    mymap.on('mousemove', disableGrid);
    mymap.on('mouseout', enableGrid);

    weather();

    var heat = [];
    var WeatherForecasts = weather.WeatherForecasts
    for (let i in WeatherForecasts) {
        L.marker([WeatherForecasts[i].location.lat, WeatherForecasts[i].location.lon]).addTo(mymap).bindPopup(WeatherForecasts[i].location.province + " " + "อ ุณหภูมิที่ระดับพื้นผิว : " + WeatherForecasts[i].forecasts[1].data.tc + " °C");
        heat.push([WeatherForecasts[i].location.lat, WeatherForecasts[i].location.lon, WeatherForecasts[i].forecasts[1].data.tc / 100])

    }
    L.heatLayer(heat, {
        radius: 75
    }).addTo(mymap);


}

function weather() {
    //headers:{'Content-Type':'application/json' , 'authorization':'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImU3Njk5YzY5ZDY0YjVkNDUzNGFiOGUyM2QyMmY0MTdmMjA0NTQ2ZGU5N2Q2OGZjOGU3MTFjNWRjYjJlZTk0NDE0OWNmMjBiZDIzYmIwMmZlIn0.eyJhdWQiOiIyIiwianRpIjoiZTc2OTljNjlkNjRiNWQ0NTM0YWI4ZTIzZDIyZjQxN2YyMDQ1NDZkZTk3ZDY4ZmM4ZTcxMWM1ZGNiMmVlOTQ0MTQ5Y2YyMGJkMjNiYjAyZmUiLCJpYXQiOjE1MzY5MzA1OTQsIm5iZiI6MTUzNjkzMDU5NCwiZXhwIjoxNTY4NDY2NTk0LCJzdWIiOiIyNjUiLCJzY29wZXMiOltdfQ.YpNDR_qqohsKFikhEl1Ghc06yK7E6Aqeg8khUInXuNPKSw6X7_isXZgb3CYZFY9rYLt28VGrHmvqJMUM3Qz13vdI0G2BtEjtvAmoKVgaTWOGkT34igx68AyIDrzw2g-dD6aFlo50KCMMnAP8u7dwqBX9VU4yKc3dsMAIkGu9-lkmuJKL0_Tfx_DiNfIr5AOZAX_ME6R5zjVoiCFnGtX6frVoLc8WH6N5AK2yQrN-gjJwnLYFCS7lkmEtTSxavf-MigVijYRDtjAeO5vqd_uADCjyWsLMQ2BX27pnq09srvfgrhrUGq7w9Qm4IhYRUMHqKouQT9AyGC9nQm_EBHAovtXkjWMObw87ucewTK2BXDhaV3zOe9Ww_Nv2kVMvf5mIl4zMZKp-BjRY0RKBoDg1xfm11IdVzwaiHYSRnMhMDgXcAYRBgxdTNjWLlGlVrapA6GgYatG6-Mie1iuuuhJfah2EzYwTwEuXqwh3cctl5FSxC0JsDtAo8DOYCq_Esbth0nPc4cpFL9YFHaE-vO1Sj-qNBA4b6x8EOGh_rdkOnqEOAVqxKe9lio9jM1N8EOenOlTpmUDB95w8hfI1j_KdpqQqy1zgGRn_BgrHnZJxDeOXKNMfgBtMfD3aQreU75InECJ8_5uCmgtSeYF0bjgAmBYd37yJo9zprO0MNBeEGLk'},
    //url: 'http://data.tmd.go.th/nwpapi/v1/forecast/location/hourly/region?region=C&fields=tc,rh&date=2018-09-15&hour=8&duration=2',
    $.ajax({
        dataType: "json",
        url: '/js/company/test-api.json',
        async: false,
        success: function (data) {
            weather = data;
        }
    });
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

function updateDateGauge(gg1) {
    gg1.refresh(getRandomInt(0, 100));
}
