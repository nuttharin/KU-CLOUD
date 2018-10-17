var options = {
    cellHeight: 80,
    verticalMargin: 10,
    float: false
};

var weather;

var obj_grid = [];

class GridDashboard {

    constructor(widget) {
        this.item = widget.divId;
        this.name = widget.name;
        this.id = widget.id;
        this.type = widget.type;
        this.title_name = widget.title_name;
        this.lastUpdate = widget.lastUpdate;
        this.timeInterval = widget.timeInterval;
    }

    getId() {
        return this.id;
    }

    getGrid() {
        return this;
    }
}

class ChartLine extends GridDashboard {
    constructor(widget) {
        super(widget);
        this.chart = widget.chart;
        this.deviceName = widget.deviceName;
        this.datasets = widget.datasets;
    }
}

class ChartTextLine extends ChartLine {
    constructor(widget) {
        super(widget);
        this.unit = widget.unit;
        this.rgb = widget.rgb;
    }
}


$(".grid-stack").gridstack(options);

var Static = new function () {

    this.items = [{
        x: 0,
        y: 0,
        width: 6,
        height: 7,
    }];

    const optionChartLineNotLable = {
        maintainAspectRatio: false,
        responsive: true,
        scales: {
            yAxes: [{
                display: false
            }],
            xAxes: [{
                display: false
            }]
        },
        legend: {
            display: false
        },
        elements: {
            point: {
                radius: 0
            },
            line: {
                tension: 0
            }
        },
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 30
            }
        },
        stepsize: 100
    };

    var ModalDeleteWidget = null;

    time = null;

    this.grid = $(".grid-stack").data("gridstack");

    widgets = [];

    this.addNewWidget = function () {
        clearInterval(time);
        var divId = Math.floor(100000 + Math.random() * 900000);
        var divIdMap = Math.floor(100000 + Math.random() * 900000);
        var node = this.items.pop() || {
            x: 3,
            y: 4,
            width: 6,
            height: 7,
        };

        var title_name = $("#title-name").val();
        var widget_type = $("#widget_type").val();

        var data_line = [];
        var d = new Date();
        var lastUpdate = d.getDate() + "-" + d.getMonth() + "-" + d.getFullYear() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds()

        switch (widget_type) {
            case 'text-line':
                let unit = $("#unit").val();
                console.log(unit);
                wi = `  <h2 class="text-left"><span id="value_${divId}">0</span> ${unit}</h2>
                        <canvas id="myChart_${divId}"></canvas>
                     `;
                data_widget = {
                    divId: "item-" + divId,
                    id: "myChart_" + divId,
                    type: widget_type,
                    title_name: title_name,
                    lastUpdate: lastUpdate,
                    unit: unit,
                    rgb: $("#value-text-line").find('.rgb-chart-line').val()
                }
                obj = new ChartTextLine({ ...data_widget });
                widgets.push(obj);
                break;
            case 'line':
                let length_label = $(".label-y-chart-line").length - 1;
                for (let i = 0; i < length_label; i++) {
                    let label_y = $(".label-y-chart-line");
                    let rgb = $(".rgb-chart-line");
                    let rgba = 'rgba(255,255,255,0.0)';
                    let data = null;
                    data = {
                        label: $(label_y[i]).val(),
                        backgroundColor: rgba,
                        borderColor: $(rgb[i]).val(),
                        borderWidth: 2
                    }
                    data_line.push({ ...data });
                }

                data_widget = {
                    divId: "item-" + divId,
                    id: "myChart_" + divId,
                    type: widget_type,
                    title_name: title_name,
                    lastUpdate: lastUpdate,
                    datasets: [...data_line]
                }

                wi = '<canvas id="myChart_' + divId + '"></canvas>'
                obj = new ChartLine({ ...data_widget });
                widgets.push(obj);
                break;
            case 'Map':
                data_widget = {
                    id: "mymap_" + divIdMap,
                    type: widget_type,
                    title_name: title_name,
                    lastUpdate: lastUpdate,
                }

                wi = '<div id="mymap_' + divIdMap + '"></div>'
                obj = new GridDashboard({ ...data_widget });
                widgets.push(obj);
                break;
            case 'Half Circle':
                data_widget = {
                    id: "circle_" + divId,
                    type: widget_type,
                    title_name: title_name,
                    lastUpdate: lastUpdate,
                }

                wi = '<div id="circle_' + divId + '" data-animation="1" data-animationStep="5" data-percent="58"></div>'
                obj = new GridDashboard({ ...data_widget });
                break;
            case 'text':
                data_widget = {
                    divId: "item-" + divId,
                    id: "text_" + divId,
                    type: widget_type,
                    title_name: title_name,
                    lastUpdate: lastUpdate,
                }
                let text = $("#text-custom").val();
                console.log(text);
                wi = `<h3> ${text} </h3>`;
                obj = new GridDashboard({ ...data_widget });
                break;

        }

        var layout_widget = $("#layout-widget").html();
        layout_widget = layout_widget.replace(/div_id/g, "item-" + divId)
        layout_widget = layout_widget.replace("((wi))", wi)
        layout_widget = layout_widget.replace("((title_name))", title_name)

        node.id = "item-" + divId;

        var g = this.grid.addWidget(
            $(layout_widget),
            node.x,
            node.y,
            node.width,
            node.height,
            true, null, null, null, null, node.id
        );

        g.data('_gridstack_data', JSON.stringify({ ...data_widget }));

        $(".btn-delete-wi").unbind().click(function () {
            onDeleteWidget($(this));
        })

        var widgetC = this.createWidget({ ...obj });
        if (widgetC) {
            if (obj.type === 'line' || obj.type === 'text-line') {
                obj.chart = widgetC;
            }
            else if (obj.type === 'Map') {
                obj.map = widgetC;
            }
        }
        this.initialAndRun();
        return false;
    }.bind(this);

    onDeleteWidget = function (el) {
        if (ModalDeleteWidget === null) {
            ModalDeleteWidget = `
            <div class="modal fade" id="DeleteWidget">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Widget</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <h6>Are you sure to delete this widget?</h6>
                        </div>

                        <div class="modal-footer">
                            <button type="button" id="" class="btn btn-danger btn-block btn-submit-delete-widget">Delete</button>
                        </div>
                    </div>
                </div>
            </div>`

            $('body').append(ModalDeleteWidget);
        }

        $('#DeleteWidget').modal('show');
        $('.btn-submit-delete-widget').unbind().click(function () {
            submitDeleteWidget($(el));
            $('#DeleteWidget').modal('hide');
        })

    }.bind(this);

    submitDeleteWidget = function (el) {
        let item = $(el).attr("item");
        this.grid.removeWidget($('#' + item).closest(".grid-stack-item"));
        widgets = widgets.find(widget => {
            return widget.item != item
        })
        console.log(widgets);
        return false;
    }.bind(this);

    this.createWidget = function (obj) {
        switch (obj.type) {
            case 'text-line':
                var chartText = this.createLineText(obj);
                return chartText
            case 'line':
                var chartline = this.createLine(obj);
                return chartline;
            case 'Gauges':
                var g = addGage(obj);
                break;
            case 'Map':
                var mymap = this.createMap(obj);
                break;
            case 'Half Circle':
                $("#circle_" + "1").circliful({
                    animationStep: 5,
                    foregroundBorderWidth: 5,
                    backgroundBorderWidth: 15,
                    percent: 80,
                    halfCircle: 1,
                });
                break;
            default:
                break;
        }
    }.bind(this);

    this.createLine = function (obj) {
        let ctx = document.getElementById(obj.id);
        var myChart = new Chart(ctx, {
            type: obj.type,
            data: {
                datasets: obj.datasets
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
    }.bind(this);

    this.createLineText = function (obj) {
        let ctx = document.getElementById(obj.id);
        console.log(obj.rgb);
        console.log(obj);
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: [
                        'rgba(255, 255, 255, 0)',
                    ],
                    borderColor: [
                        obj.rgb
                    ],
                    borderWidth: 2
                }]
            },
            options: optionChartLineNotLable
        });

        return myChart;
    }.bind(this);

    this.createMap = function (obj) {
        var mymap;
        var mapid = obj.id;
        $('#' + mapid).css('height', '100%');
        $('#' + mapid).css('width', 'auto');

        mymap = L.map(mapid, {
            dragging: true,
            zoomControl: true,
            scrollWheelZoom: false,
            zoomAnimation: false,
        });

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

        function disableGrid() {
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

        mymap.on('mousemove', disableGrid);
        mymap.on('mouseout', enableGrid);

    }.bind(this);


    this.saveGrid = function () {
        this.serializedData = _.map($('.grid-stack > .grid-stack-item:visible'), function (el) {
            el = $(el);
            var node = el.data('_gridstack_node');
            var widget = el.data('_gridstack_data');
            console.log(widget);
            return {
                x: node.x,
                y: node.y,
                width: node.width,
                height: node.height,
                widget: JSON.parse(widget)
            };
        });
        console.log(JSON.stringify(this.serializedData, null, '        '))
        $('#saved-data').val(JSON.stringify(this.serializedData, null, '        '));

        $("#saveW").hide();
        $("#addW").hide();
        $("#settingW").show();
        $(".edit-widget").hide();

        return false;
    }.bind(this);

    this.initialAndRun = function () {
        this.showLastestWidget();
        time = setInterval(() => {
            if (widgets.length > 0) {
                this.updateData([...widgets]);
            }
        }, 1000)
    }.bind(this);

    this.showLastestWidget = function () {

        $("#add-new-widget").unbind().click(this.addNewWidget);

        $("#saveW").unbind().click(this.saveGrid);

        // $("#addW").unbind().click(function () {
        //     $("#myModal").modal('show');
        // });
    }.bind(this);

    this.updateData = function (widgets) {
        //console.log(widgets);
        for (var i = 0; i < widgets.length; i++) {
            if (widgets[i].type === 'line') {
                var myChart = widgets[i].chart;
                var data = Math.random();
                var d = new Date();
                myChart.data.labels.push(d.toLocaleTimeString());
                myChart.data.datasets.forEach((dataset) => {
                    if (dataset.data.length > 10) {
                        dataset.data.splice(0, 1);
                        //myChart.data.labels.splice(0, 1);
                    }
                    var data2 = Math.random();
                    dataset.data.push(data + data2);
                });

                if (myChart.data.labels.length > 10) myChart.data.labels.splice(0, 1);

                myChart.update();
            }
            else if (widgets[i].type === 'text-line') {
                let value = widgets[i].id;
                value = value.replace("myChart_", "value_");
                var myChart = widgets[i].chart;
                var data = Math.floor(100 + Math.random() * 900);
                var d = new Date();
                myChart.data.labels.push(d.toLocaleTimeString());
                myChart.data.datasets.forEach((dataset) => {
                    if (dataset.data.length > 10) {
                        dataset.data.splice(0, 1);
                        //myChart.data.labels.splice(0, 1);
                    }
                    dataset.data.push(data);
                    $("#" + value).html(data);
                });

                if (myChart.data.labels.length > 10) myChart.data.labels.splice(0, 1);

                myChart.update();
            }
        }
    }




}();

$(document).ready(function () {

    var widget = Static;
    widget.initialAndRun({});

    $("#widget_type").change(function () {
        $(".value_widget").hide();
        var type = $(this).val();
        if (type == 'line') {
            $("#line").show();
        } else if (type === 'bar') {
            $("#bar").show();
        } else if (type === 'Map') {
            $("#map").show();
        }
        else if (type === 'text') {
            $("#text-box").show();
        }
        else if (type === 'text-line') {
            $("#text-line").show();
        }
    });

    $("#btn-add-value-line").click(function () {
        var html = $("#line_value_layout").html()
        $("#line_value").append(html);
        updateMinicolor();
    });

    $("#settingW").click(function () {
        $(this).hide();
        $(".edit-widget").show();
        $("#addW").show();
        $("#saveW").show();
    });


    $('.grid-stack').on('resizestop', function (event, ui) {
        let el = $(this).find('.grid-stack-item')
        var data_widget = JSON.parse(el.data('_gridstack_data'));
        console.log(data_widget.type);
        if (data_widget.type === 'Half Circle') {
            var grid = this;
            var element = event.target;
            let width = $(this).find('.panel__content').width();
            let height = $(this).find('.panel__content').height();
            var panel = $(this).find('.panel__content');
            var id = $(panel).children().children();
            $(id).width(width + 30);
            $(id).height(height + 50);
        }
        else if (data_widget.type === 'text-line') {
            // var grid = this;
            // var element = event.target;
            // let width = $(this).find('.panel__content').width();
            // let height = $(this).find('.panel__content').height();
            // var panel = $(this).find('.panel__content');
            // var id = $(panel).find('canvas');
            // $(id).height(height - 90)
        }
    });
});


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

function updateData(myChart) {
    var data = Math.random();
    var d = new Date();
    myChart.data.labels.push(d.toLocaleTimeString());
    var i = 0;
    myChart.data.datasets.forEach((dataset) => {
        if (dataset.data.length > 10) {
            dataset.data.splice(0, 1);
            //myChart.data.labels.splice(0, 1);
        }
        var data2 = Math.random();
        dataset.data.push(data + data2);
    });

    if (myChart.data.labels.length > 10) myChart.data.labels.splice(0, 1);

    myChart.update();
}

function updateDateGauge(gg1) {
    gg1.refresh(getRandomInt(0, 100));
}
