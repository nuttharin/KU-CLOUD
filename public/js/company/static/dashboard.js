Chart.defaults.global.defaultFontFamily = "'Poppins', 'Kanit', 'sans-serif'";

class Widget {

    constructor(widget) {

        this.itemId = widget.itemId;
        this.widgetId = widget.widgetId;
        this.type = widget.type;
        this.lastUpdateId = widget.lastUpdateId;
        this.title_name = widget.title_name;
        this.lastUpdate = widget.lastUpdate;
        this.timeInterval = widget.timeInterval;
        this.wi = widget.wi;

        this.updateLastUpdate = (time = null) => {
            if (time) {
                this.lastUpdate = new Date(time);
                $("#" + this.lastUpdateId).html(this.lastUpdate.toDateString() + " " + this.lastUpdate.toLocaleTimeString());
            }
            else {
                this.lastUpdate = new Date();
                $("#" + this.lastUpdateId).html(this.lastUpdate.toDateString() + " " + this.lastUpdate.toLocaleTimeString());
            }
        };

        let options = {
            cellHeight: 80,
            verticalMargin: 10,
            float: false
        };

        let items = [{
            x: 0,
            y: 0,
            width: 6,
            height: 7,
        }];

        let grid = null;

        let ModalDeleteWidget = null;

        let ModalEditWidget = null;

        let onEditWidgetClick = (el) => {
            let _el = $(el);
            let itemId = _el.attr("item");
            let widget = Dashboard.getWidgetById(itemId);
            let modal = new ModalEditWidget(widget);
            modal.initCreate();
            // if (ModalEditWidget === null) {
            //     ModalEditWidget = `
            //         < div class="modal fade" id = "EditWidget" >
            //             <div class="modal-dialog modal-lg">
            //                 <div class="modal-content">
            //                     <div class="modal-header">
            //                         <h5 class="modal-title">Edit Widget</h5>
            //                         <button type="button" class="close" data-dismiss="modal">&times;</button>
            //                     </div>

            //                     <div class="modal-body" id="form-edit-widget">
            //                         <div class="row" id="div-title">
            //                             <div class="col-6">
            //                                 <lable>Title</label>
            //                                 <input type="text" class="form-control" id="edit-title" />
            //                             </div>
            //                         </div>

            //                         <div id="edit-text-line" class="edit-widget-form">
            //                             <div class="row">
            //                                 <div class="col-6">
            //                                     <lable>Unit</label>
            //                                     <input type="text" class="form-control" id="edit-unit" />
            //                                 </div>
            //                             </div>
            //                         </div>

            //                         <div id="edit-Gauges" class="edit-widget-form">
            //                             <div class="row">
            //                                 <div class="col-6">
            //                                     <lable>Unit</label>
            //                                     <input type="text" class="form-control" id="edit-unit" />
            //                                 </div>
            //                             </div>
            //                         </div>

            //                         <div id="edit-text-box" class="value_widget" style="display:none;">
            //                             <div class="row">
            //                                 <div class="col-6">
            //                                     <label>Text</label>
            //                                     <input type="text" id="edit-text-custom" class="form-control" />
            //                                 </div>
            //                                 <div class="col-6">
            //                                     <label>Font Size (px)</label>
            //                                     <input type="number" id="edit-font-size" class="form-control" />
            //                                 </div>
            //                             </div>
            //                         </div>

            //                     </div>

            //                     <div class="modal-footer">
            //                         <button type="button" id="" class="btn btn-success btn-block btn-submit-edit-widget">Done</button>
            //                     </div>
            //                 </div>
            //             </div>
            //     </div > `;

            //     $('body').append(ModalEditWidget);
            // }

            // let formEditWidget = $("#form-edit-widget");
            // $(".edit-widget-form").hide();
            // $("#div-title").show();

            // if (widget.type === "MutiLine") {
            //     formEditWidget.find("#edit-title").val(widget.title_name);
            // }
            // else if (widget.type === "text-line") {
            //     formEditWidget.find("#edit-title").val(widget.title_name);
            //     $("#edit-text-line").show();
            //     formEditWidget.find("#edit-text-line #edit-unit").val(widget.unit);
            // }
            // else if (widget.type === "Gauges") {
            //     formEditWidget.find("#edit-title").val(widget.title_name);
            //     $("#edit-Gauges").show();
            //     formEditWidget.find("#edit-Gauges  #edit-unit").val(widget.unit);
            // }
            // else if (widget.type === "TextBox") {
            //     formEditWidget.find("#edit-text-box #edit-text-custom").val(widget.textbox);
            //     formEditWidget.find("#edit-text-box #edit-font-size").val(widget.fontsize);
            //     $("#edit-text-box").show();
            //     $("#div-title").hide();
            // }

            // $("#EditWidget").modal('show');
        };

        let submitEditWidget = () => {

        };

        let bindWidgetElement = () => {
            $(".btn-delete-wi").unbind().click(function () {
                onDeleteWidgetClick($(this));
            });

            $(".btn-edit-wi").unbind().click(function () {
                onEditWidgetClick($(this));
            });

            $(".btn-full-screen").unbind().click(function () {
                onFullScreenClick($(this));
            });
        };

        let onFullScreenClick = (el) => {
            let obj = Dashboard.getWidgetById(el.attr("item"));
            $("#modal-full-screen").modal('show');
            $("#content-widget").html(obj.selectWiContentFull());
            obj.createFullWidget();
        };

        let onDeleteWidgetClick = (el) => {
            if (ModalDeleteWidget === null) {
                ModalDeleteWidget = `
                    < div class="modal fade" id = "DeleteWidget" >
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
                </div > `;

                $('body').append(ModalDeleteWidget);
            }

            $('#DeleteWidget').modal('show');

            $('.btn-submit-delete-widget').unbind().click(function () {
                submitDeleteWidget($(el));
                $('#DeleteWidget').modal('hide');
            });
        };

        let submitDeleteWidget = (el) => {
            let item = $(el).attr("item");
            grid.removeWidget($('#' + item).closest(".grid-stack-item"));
            let index = widgetList.findIndex(widget => widget.itemId == item);
            widgetList.splice(index, 1);
        };

        let formateDataSave = (data) => {
            let formateDate = {
                type: data.type,
                timeInterval: data.timeInterval,
            };

            if (data.type === "MutiLine") {
                formateDate.title_name = data.title_name;
                formateDate.datasets = data.datasets;
            }
            else if (data.type === "text-line") {
                formateDate.title_name = data.title_name;
                formateDate.unit = data.unit;
                formateDate.rgb = data.rgb;
            }
            else if (data.type === "Gauges") {
                formateDate.title_name = data.title_name;
                formateDate.opts = data.opts;
                formateDate.limitMin = data.limitMin;
                formateDate.limitMax = data.limitMax;
                formateDate.unit = data.unit;
            }
            else if (data.type === "Map") {
                formateDate.title_name = data.title_name;
            }
            else if (data.type === "TextBox") {
                formateDate.textbox = data.textbox;
                formateDate.fontsize = data.fontsize;
            }

            return formateDate;

        };

        this.selectWiContent = () => {
            let valueId = "";
            switch (this.type) {
                case 'MutiLine':
                    return `< canvas id = "${this.widgetId}" ></canvas > `;
                case 'text-line':
                    valueId = this.itemId.replace("item-", "value_");
                    return ` < h2 class="text-left" > <span id="${valueId}">0</span> ${this.unit}</h2 >
                    <canvas id="${this.widgetId}"></canvas>
                `;
                case 'Gauges':
                    valueId = this.itemId.replace("item-", "gauges-text-");
                    return `
                    < h2 > <span id="${valueId}">0</span> <span>${this.unit}</span></h2 >
                        <canvas id="${this.widgetId}"></canvas>
                `;
                case 'Map':
                    return `
                    < div id = "${this.widgetId}" ></div >
                        `;
                case 'TextBox':
                    return `< span id = "${this.widgetId}" ></span > `;
                default:
                    break;
            }
        };

        this.selectWiContentFull = () => {
            let valueId = "";
            switch (this.type) {
                case 'MutiLine':
                    return `< canvas id = "${this.fullScreenId}" ></canvas > `;
                case 'text-line':
                    valueId = this.itemId.replace("item-", "value_full");
                    return ` < h2 class="text-left" > <span id="${valueId}">0</span> ${this.unit}</h2 >
                    <canvas id="${this.fullScreenId}"></canvas>
                `;
                case 'Gauges':
                    valueId = this.itemId.replace("item-", "gauges-text-full");
                    return `
                    < h2 > <span id="${valueId}">0</span> <span>${this.unit}</span></h2 >
                        <canvas id="${this.fullScreenId}"></canvas>
                `;
                case 'Map':
                    return `
                    < div id = "${this.fullScreenId}" ></div >
                        `;
                default:
                    break;
            }
        };

        this.createWidget = (gridData = null) => {

            let node = items.pop() || {
                x: 3,
                y: 4,
                width: 6,
                height: 7,
            };

            $(".grid-stack").gridstack(options);
            grid = $(".grid-stack").data("gridstack");

            let layout_widget = "";
            if (this.type !== "TextBox") {
                layout_widget = $("#layout-widget").html();
                layout_widget = layout_widget.replace(/div_id/g, this.itemId);
                layout_widget = layout_widget.replace("((wi))", this.selectWiContent());
                layout_widget = layout_widget.replace("((title_name))", this.title_name);
                layout_widget = layout_widget.replace("{last_update}", this.lastUpdateId);
            }
            else {
                node.width = 6;
                node.height = 1;
                layout_widget = $("#layout-widget-text").html();
                layout_widget = layout_widget.replace(/div_id/g, this.itemId);
                layout_widget = layout_widget.replace("((wi))", this.selectWiContent());
            }

            node.id = this.itemId;
            let g = null;
            if (gridData) {
                g = grid.addWidget(
                    $(layout_widget),
                    gridData.x,
                    gridData.y,
                    gridData.width,
                    gridData.height,
                    true, null, null, null, null, node.id
                );
            } else {
                g = grid.addWidget(
                    $(layout_widget),
                    node.x,
                    node.y,
                    node.width,
                    node.height,
                    true, null, null, null, null, node.id
                );
            }
            g.data('_gridstack_data', JSON.stringify(formateDataSave(this)));

            bindWidgetElement();
        };
    }
}

class MutiLine extends Widget {
    constructor(widget) {
        super(widget);

        this.fullScreenId = widget.fullScreenId;
        this.chart = null;
        this.datasets = widget.datasets;

        let options = {
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        beginAtZero: true,
                        fontFamily: "'Poppins', 'Kanit', 'sans-serif'",
                        fontStyle: "bold",
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        fontFamily: "'Poppins', 'Kanit', 'sans-serif'",
                        fontStyle: "bold",
                    }
                }],

            },
            legend: {
                labels: {
                    fontFamily: "'Poppins', 'Kanit', 'sans-serif'",
                    fontColor: 'black'
                }
            }
        };

        this.createMutiLine = () => {
            let ctx = document.getElementById(this.widgetId);
            console.log(this.datasets);
            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: this.datasets.map((item) => { return Object.assign({}, item); })
                },
                options: options
            });
            this.chart = myChart;
        };

        this.createFullWidget = () => {
            let ctx = document.getElementById(this.fullScreenId);
            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: this.datasets.map((item) => { return Object.assign({}, item); })
                },
                options: options
            });
        };

        this.updateData = () => {
            let myChart = this.chart;
            let data = Math.random();
            let d = new Date();
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
            this.updateLastUpdate();
        };
    }
}

class ChartTextLine extends MutiLine {
    constructor(widget) {
        super(widget);
        this.fullScreenId = widget.fullScreenId;
        this.unit = widget.unit;
        this.rgb = widget.rgb;

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


        this.createTextLine = () => {
            let ctx = document.getElementById(this.widgetId);
            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: '',
                        data: [],
                        backgroundColor: [
                            'rgba(255, 255, 255, 0)',
                        ],
                        borderColor: [
                            this.rgb
                        ],
                        borderWidth: 2
                    }]
                },
                options: optionChartLineNotLable
            });
            this.chart = myChart;
            this.updateData();
            return myChart;
        };

        this.createFullWidget = () => {
            let ctx = document.getElementById(this.fullScreenId);
            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: '',
                        data: [],
                        backgroundColor: [
                            'rgba(255, 255, 255, 0)',
                        ],
                        borderColor: [
                            this.rgb
                        ],
                        borderWidth: 2
                    }]
                },
                options: optionChartLineNotLable
            });
        };

        this.updateData = () => {

            //test get api 
            // $.ajax({
            //     url: "http://data.tmd.go.th/nwpapi/v1/forecast/location/hourly/region?region=C&fields=tc,rh&date=2018-10-25",
            //     headers: { 'Content-Type': 'application/json', 'authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImU3Njk5YzY5ZDY0YjVkNDUzNGFiOGUyM2QyMmY0MTdmMjA0NTQ2ZGU5N2Q2OGZjOGU3MTFjNWRjYjJlZTk0NDE0OWNmMjBiZDIzYmIwMmZlIn0.eyJhdWQiOiIyIiwianRpIjoiZTc2OTljNjlkNjRiNWQ0NTM0YWI4ZTIzZDIyZjQxN2YyMDQ1NDZkZTk3ZDY4ZmM4ZTcxMWM1ZGNiMmVlOTQ0MTQ5Y2YyMGJkMjNiYjAyZmUiLCJpYXQiOjE1MzY5MzA1OTQsIm5iZiI6MTUzNjkzMDU5NCwiZXhwIjoxNTY4NDY2NTk0LCJzdWIiOiIyNjUiLCJzY29wZXMiOltdfQ.YpNDR_qqohsKFikhEl1Ghc06yK7E6Aqeg8khUInXuNPKSw6X7_isXZgb3CYZFY9rYLt28VGrHmvqJMUM3Qz13vdI0G2BtEjtvAmoKVgaTWOGkT34igx68AyIDrzw2g-dD6aFlo50KCMMnAP8u7dwqBX9VU4yKc3dsMAIkGu9-lkmuJKL0_Tfx_DiNfIr5AOZAX_ME6R5zjVoiCFnGtX6frVoLc8WH6N5AK2yQrN-gjJwnLYFCS7lkmEtTSxavf-MigVijYRDtjAeO5vqd_uADCjyWsLMQ2BX27pnq09srvfgrhrUGq7w9Qm4IhYRUMHqKouQT9AyGC9nQm_EBHAovtXkjWMObw87ucewTK2BXDhaV3zOe9Ww_Nv2kVMvf5mIl4zMZKp-BjRY0RKBoDg1xfm11IdVzwaiHYSRnMhMDgXcAYRBgxdTNjWLlGlVrapA6GgYatG6-Mie1iuuuhJfah2EzYwTwEuXqwh3cctl5FSxC0JsDtAo8DOYCq_Esbth0nPc4cpFL9YFHaE-vO1Sj-qNBA4b6x8EOGh_rdkOnqEOAVqxKe9lio9jM1N8EOenOlTpmUDB95w8hfI1j_KdpqQqy1zgGRn_BgrHnZJxDeOXKNMfgBtMfD3aQreU75InECJ8_5uCmgtSeYF0bjgAmBYd37yJo9zprO0MNBeEGLk' },
            //     success: (res) => {
            //         console.log(res);
            //         let data = res.WeatherForecasts.find(t => {
            //             return t.location.province == "สมุทรปราการ";
            //         });
            //         let value = this.widgetId;
            //         value = value.replace("myChart_", "value_");
            //         let myChart = this.chart;
            //         let time = data.forecasts[0].time;
            //         data = data.forecasts[0].data.rh;
            //         let d = new Date();
            //         myChart.data.labels.push(d.toLocaleTimeString());
            //         myChart.data.datasets.forEach((dataset) => {
            //             if (dataset.data.length > 10) {
            //                 dataset.data.splice(0, 1);
            //                 //myChart.data.labels.splice(0, 1);
            //             }
            //             dataset.data.push(data);
            //             $("#" + value).html(data);
            //         });

            //         if (myChart.data.labels.length > 10) myChart.data.labels.splice(0, 1);

            //         myChart.update();
            //         this.updateLastUpdate(time);
            //     },
            //     error: (res) => {
            //         console.log(res);
            //     }
            // });

            let value = this.widgetId;
            value = value.replace("myChart_", "value_");
            let myChart = this.chart;
            let data = Math.floor(100 + Math.random() * 900);
            let d = new Date();
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
            this.updateLastUpdate();
        };

        this.liveData = () => {
            let value = this.widgetId;
            value = value.replace("myChart_", "value_");
            let myChart = this.chart;
            let d = new Date();
            myChart.data.labels.push(d.toLocaleTimeString());
            myChart.data.datasets.forEach((dataset) => {
                if (dataset.data.length > 10) {
                    dataset.data.splice(0, 1);
                    //myChart.data.labels.splice(0, 1);
                }
                let data = dataset.data[dataset.data.length - 1];
                dataset.data.push(data);
            });

            if (myChart.data.labels.length > 10) myChart.data.labels.splice(0, 1);

            myChart.update();
            //this.updateLastUpdate();
        };
    }
}

class Gauges extends Widget {
    constructor(widget) {
        super(widget);
        this.fullScreenId = widget.fullScreenId;
        this.textId = widget.textId;
        this.gaugeWidget = null;
        this.opts = widget.opts;
        this.limitMax = widget.limitMax;
        this.limitMin = widget.limitMin;
        this.unit = widget.unit;

        this.createGages = () => {
            let target = document.getElementById(this.widgetId); // your canvas element
            let gauge = new Gauge(target).setOptions(this.opts); // create sexy gauge!
            gauge.maxValue = this.limitMax; // set max gauge value
            gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
            gauge.animationSpeed = 32; // set animation speed (32 is default value)
            gauge.set(0); // set actual value
            this.gaugeWidget = gauge;
            this.updateData();
        };

        this.updateData = () => {
            let data = Math.floor(Math.random() * (100 - 1));
            $("#" + this.textId).html(data);
            this.gaugeWidget.set(data);
            this.updateLastUpdate();
        };
    }
}

class Map extends Widget {
    constructor(widget) {
        super(widget);
        this.fullScreenId = widget.fullScreenId;
        this.myMap = null;

        this.createMap = () => {
            let mymap;
            let mapid = this.widgetId;
            let height = $("#" + this.itemId).height() - 100;
            $('#' + mapid).css('height', height);
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
                let grid = $('.grid-stack').data('gridstack');
                grid.enableMove(false);
            }

            function enableGrid() {
                let grid = $('.grid-stack').data('gridstack');
                grid.enableMove(true);
            }

            $('.grid-stack').on('change', function (e, items) {
                if (mymap != null) {
                    mymap.invalidateSize(true);
                }
            });

            // mymap.on('mousemove', disableGrid);
            // mymap.on('mouseout', enableGrid);

            this.myMap = mymap;
        };

        this.createFullWidget = () => {
            let mymap;
            let mapid = this.fullScreenId;
            let height = "450px";
            $('#' + mapid).css('height', height);
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


            }).then(() => {
                setTimeout(() => {
                    mymap.invalidateSize(true);
                    $.ajax({
                        dataType: "json",
                        url: '/js/company/test-api.json',
                        async: false,
                        success: function (data) {
                            weather1 = data;
                            var heat = [];
                            var WeatherForecasts = weather1.WeatherForecasts;
                            for (let i in WeatherForecasts) {
                                //L.marker([WeatherForecasts[i].location.lat, WeatherForecasts[i].location.lon]).addTo(mymap).bindPopup(WeatherForecasts[i].location.province + " " + "อ ุณหภูมิที่ระดับพื้นผิว : " + WeatherForecasts[i].forecasts[1].data.tc + " °C");
                                heat.push([WeatherForecasts[i].location.lat, WeatherForecasts[i].location.lon, WeatherForecasts[i].forecasts[1].data.tc / 100])

                            }
                            L.heatLayer(heat, {
                                radius: 75
                            }).addTo(mymap);
                        }
                    });

                }, 1000);
            }
            );




        };
    }
}

class TextBox extends Widget {
    constructor(widget) {
        super(widget);
        this.textbox = widget.textbox;
        this.fontsize = widget.fontsize;
        this.createTextBox = () => {
            console.log($("#" + this.widgetId));
            $("#" + this.widgetId).html(this.textbox);
            $("#" + this.widgetId).css({ "font-size": this.fontsize + "px" });
        };
    }
}

var widgetList = [];

class Dashboard {
    constructor() {

        let options = {
            cellHeight: 80,
            verticalMargin: 10,
            float: false
        };

        let grid = null;

        let time = null;

        let getWigetType = () => {
            return $("#widget_type").val();
        };

        let getTitleName = () => {
            return $("#title-name").val();
        };

        let getTimeInterval = () => {
            return $("#time-interval").val();
        };

        let getDateTimeNow = () => {
            let d = new Date();
            //return d.getDate() + "-" + d.getMonth() + "-" + d.getFullYear() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
            return d.toUTCString();
        };

        let getValueMutiLine = (divId) => {
            let length_label = $("#Mutiline_value").find(".label-y-chart-line").length;
            let data_line = [];
            for (let i = 0; i < length_label; i++) {
                let label_y = $("#Mutiline_value").find(".label-y-chart-line");
                let rgb = $("#Mutiline_value").find(".rgb-chart-line");
                let rgba = 'rgba(255,255,255,0.0)';
                let data = null;
                data = {
                    label: $(label_y[i]).val(),
                    backgroundColor: rgba,
                    borderColor: $(rgb[i]).val(),
                    borderWidth: 2
                };
                data_line.push(data);
            }

            let data_widget = {
                itemId: "item-" + divId,
                widgetId: "myChart_" + divId,
                lastUpdateId: "myChartLastUpdate_" + divId,
                fullScreenId: "myChartFull_" + divId,
                type: getWigetType(),
                title_name: getTitleName(),
                lastUpdate: getDateTimeNow(),
                timeInterval: getTimeInterval(),
                datasets: [...data_line],
            };
            return data_widget;
        };

        let getValueTextLine = (divId) => {
            let unit = $("#text-line").find("#unit").val();
            let rgb = $("#value-text-line").find("#rgb").val();

            let data_widget = {
                itemId: "item-" + divId,
                widgetId: "myChart_" + divId,
                lastUpdateId: "myChartLastUpdate_" + divId,
                fullScreenId: "myChartFull_" + divId,
                type: getWigetType(),
                title_name: getTitleName(),
                lastUpdate: getDateTimeNow(),
                timeInterval: getTimeInterval(),
                rgb: rgb,
                unit: unit,
            };
            return data_widget;
        };

        let getValueGauges = (divId) => {
            let limitMin = $("#Gauges").find("#g_limitMin").val();
            let limitMax = $("#Gauges").find("#g_limitMax").val();
            let unit = $("#Gauges").find("#unit").val();

            let data_widget = {
                textId: "gauges-text-" + divId,
                itemId: "item-" + divId,
                widgetId: "gauges-" + divId,
                lastUpdateId: "gaugesLastUpdate-" + divId,
                fullScreenId: "gaugesFull-" + divId,
                type: getWigetType(),
                title_name: getTitleName(),
                lastUpdate: getDateTimeNow(),
                timeInterval: getTimeInterval(),
                limitMax: limitMax,
                limitMin: limitMin,
                unit: unit,
                opts: {
                    angle: 0, // The span of the gauge arc
                    lineWidth: 0.23, // The line thickness
                    radiusScale: 1, // Relative radius
                    pointer: {
                        length: 0.6, // // Relative to gauge radius
                        strokeWidth: 0.035, // The thickness
                        color: '#000000' // Fill color
                    },
                    limitMax: false,     // If false, max value increases automatically if value > maxValue
                    limitMin: false,     // If true, the min value of the gauge will be fixed
                    colorStart: '#6FADCF',   // Colors
                    colorStop: '#8FC0DA',    // just experiment with them
                    strokeColor: '#E0E0E0',  // to see which ones work best for you
                    generateGradient: true,
                    highDpiSupport: true,     // High resolution support
                    staticLabels: {
                        font: "10px Poppins",  // Specifies font
                        labels: [0, Number(limitMax)],  // Print labels at these values
                        color: "#000000",  // Optional: Label text color
                        fractionDigits: 0  // Optional: Numerical precision. 0=round off.
                    },
                },
            };

            return data_widget;
        };

        let getValueMap = (divId) => {
            let data_widget = {
                itemId: "item-" + divId,
                widgetId: "map-" + divId,
                lastUpdateId: "mapLastUpdate-" + divId,
                fullScreenId: "mapFull-" + divId,
                type: getWigetType(),
                title_name: getTitleName(),
                lastUpdate: getDateTimeNow(),
                timeInterval: getTimeInterval(),
            };

            return data_widget;
        };


        let getValueWigetText = (divId) => {
            let textbox = $("#text-box").find("#text-custom").val();
            let fontsize = $("#text-box").find("#font-size").val();
            let data_widget = {
                itemId: "item-" + divId,
                widgetId: "text-" + divId,
                type: getWigetType(),
                title_name: null,
                lastUpdate: null,
                timeInterval: null,
                textbox: textbox,
                fontsize: fontsize
            };

            return data_widget;
        };

        let createFormBodyInputWidget = (type) => {
            $(".value_widget").hide();
            $("#default-value").show();
            if (type === "MutiLine") {
                $("#MutiLine").show();
            }
            else if (type === "text-line") {
                $("#text-line").show();
            }
            else if (type === "Gauges") {
                $("#Gauges").show();
            }
            else if (type === "TextBox") {
                $("#text-box").show();
                $("#default-value").hide();
            }

            else {
                $("#form-input-widget").html("");
            }
        };

        let onAddValueMutiLineClick = () => {
            let formhtml = $("#line_value_layout").html();
            $("#Mutiline_value").append(formhtml);
        };

        let onAddWidgetClick = () => {
            let type = getWigetType();
            var divId = Math.floor(100000 + Math.random() * 900000);
            let obj_widget = null;
            let widget = null;

            if (type === "MutiLine") {
                widget = getValueMutiLine(divId);
                obj_widget = new MutiLine(Object.assign({}, widget));
                obj_widget.createWidget();
                obj_widget.createMutiLine();
            }
            else if (type === "text-line") {
                widget = getValueTextLine(divId);
                obj_widget = new ChartTextLine(widget);
                obj_widget.createWidget();
                obj_widget.createTextLine();
            }
            else if (type === "Gauges") {
                widget = getValueGauges(divId);
                obj_widget = new Gauges(widget);
                obj_widget.createWidget();
                obj_widget.createGages();
            }
            else if (type === "Map") {
                widget = getValueMap(divId);
                obj_widget = new Map(widget);
                obj_widget.createWidget();
                obj_widget.createMap();
            }
            else if (type === "TextBox") {
                widget = getValueWigetText(divId);
                obj_widget = new TextBox(widget);
                obj_widget.createWidget();
                obj_widget.createTextBox();
            }
            widgetList.push(obj_widget);

        };

        let saveGrid = () => {
            let serializedData = _.map($('.grid-stack > .grid-stack-item:visible'), function (el) {
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
            //console.log(JSON.stringify(serializedData, null, '        '))
            setStorage("dashboard", serializedData);
            // $('#saved-data').val(JSON.stringify(serializedData, null, '        '));
        };

        let bindElement = () => {
            $("#settingW").click(function () {
                clearInterval(time);
                $(this).hide();
                $(".full-screen").hide();
                $(".edit-widget").show();
                $("#addW").show();
                $("#saveW").show();
                $("#cancelW").show();
                grid.enableMove(true);
                grid.enableResize(true);
            });

            $("#widget_type").change(function () {
                $(".value_widget").hide();
                createFormBodyInputWidget(getWigetType());
            });

            $("#addW").unbind().click(function () {
                $("input[type=text]").val("");
                $("#myModal").modal('show');
            });

            $("#add-new-widget").unbind().click(function () {
                onAddWidgetClick();
            });

            $("#saveW").unbind().click(function () {
                $("#saveW").hide();
                $("#addW").hide();
                $("#cancelW").hide();
                $("#settingW").show();
                $(".full-screen").show();
                $(".edit-widget").hide();
                updateDatalast();
                saveGrid();
                grid.enableMove(false);
                grid.enableResize(false);
            });

            $("#cancelW").unbind().click(function () {
                $("#saveW").hide();
                $("#addW").hide();
                $(".edit-widget").hide();
                $(".full-screen").show();
                $("#cancelW").hide();
                $("#settingW").show();
                updateDatalast();
                grid.enableMove(false);
                grid.enableResize(false);
            });

            $("#btn-add-value-Mutiline").unbind().click(function () {
                onAddValueMutiLineClick();
            });
        };

        let updateDatalast = () => {
            time = setInterval(() => {
                if (widgetList.length > 0) {
                    updateData([...widgetList]);
                }
            }, 1000);
        };

        let updateData = (widgets) => {
            for (var i = 0; i < widgets.length; i++) {
                let widget = widgets[i];
                if (widget.updateData) {
                    if (Dashboard.diffTime(widget.lastUpdate, widget.timeInterval) >= widget.timeInterval) {
                        widget.updateData();
                    }
                    else if (widget.liveData) {
                        widget.liveData();
                    }
                }
            }
        };

        let createDashboardInit = (dashboard) => {
            let obj_widget = null;
            let widgets = null;
            let gridData = null;
            let type = "";
            for (var key in dashboard) {

                var divId = Math.floor(100000 + Math.random() * 900000);
                obj_widget = null;
                widgets = dashboard[key].widget;
                gridData = dashboard[key];
                type = widgets.type;
                widgets.itemId = "item-" + divId;
                widgets.lastUpdate = getDateTimeNow();
                if (type === "MutiLine") {
                    widgets.widgetId = "myChart_" + divId;
                    widgets.fullScreenId = "myChartFull_" + divId;
                    widgets.lastUpdateId = "myChartLastUpdate_" + divId;
                    obj_widget = new MutiLine(widgets);
                    obj_widget.createWidget(gridData);
                    obj_widget.createMutiLine();
                }
                else if (type === 'Gauges') {
                    widgets.textId = "gauges-text-" + divId;
                    widgets.widgetId = "gauges-" + divId;
                    widgets.lastUpdateId = "gaugesLastUpdate-" + divId;
                    widgets.fullScreenId = "gaugesFull-" + divId;
                    obj_widget = new Gauges(widgets);
                    obj_widget.createWidget(gridData);
                    obj_widget.createGages();
                }
                else if (type === "text-line") {
                    widgets.widgetId = "myChart_" + divId;
                    widgets.lastUpdateId = "myChartLastUpdate_" + divId;
                    widgets.fullScreenId = "myChartFull_" + divId;
                    obj_widget = new ChartTextLine(widgets);
                    obj_widget.createWidget(gridData);
                    obj_widget.createTextLine();
                }
                else if (type === "Map") {
                    widgets.widgetId = "map-" + divId;
                    widgets.lastUpdateId = "mapLastUpdate_" + divId;
                    widgets.fullScreenId = "mapFull-" + divId;
                    obj_widget = new Map(widgets);
                    obj_widget.createWidget(gridData);
                    obj_widget.createMap();
                }
                else if (type === "TextBox") {
                    widgets.widgetId = "text-" + divId;
                    obj_widget = new TextBox(widgets);
                    obj_widget.createWidget(gridData);
                    obj_widget.createTextBox();
                }
                widgetList.push(obj_widget);
            }

            $(".edit-widget").hide();
        };

        this.initDashboard = () => {
            bindElement();
            // set widget $.ajax
            // test use localstorage
            let dashboard = "";
            if (getStorage("dashboard") != "") {
                dashboard = GridStackUI.Utils.sort(getStorage("dashboard"));
                createDashboardInit(dashboard);
                //console.log(dashboard);
            }

            updateDatalast();

            $(".grid-stack").gridstack(options);
            grid = $(".grid-stack").data("gridstack");
            grid.enableMove(false);
            grid.enableResize(false);

            $("#loading").remove();
        };
    }

    static diffTime(lastUpdate, timeInterval = 0) {
        //console.log(lastUpdate);
        let current = new Date();
        let _lastUpdate = new Date(lastUpdate);

        let diff = (current.getTime() - _lastUpdate.getTime()) / 1000;
        //หน่วยวินาที
        //console.log(diff);
        // diff /= 60;

        return Math.abs(Math.round(diff));
    }

    static updateGridData(id) {

    }

    static getWidgetById(itemId) {
        return widgetList.find(widget => {
            return widget.itemId == itemId;
        });
    }
}

$(document).ready(function () {
    $("#sidebarCollapse").click();
    let dashboard = new Dashboard();
    dashboard.initDashboard();

    $('.grid-stack').on('gsresizestop', function (event, elem) {
        let el = $(elem);
        let data_widget = JSON.parse(el.data('_gridstack_data'));
        let node = el.data('_gridstack_node');
        console.log(node);
        let type = data_widget.type;
        if (type === "Gauges") {

            // let element = event.target;
            // let width = el.find('.panel__content').width();
            // let height = el.find('.panel__content').height();
            // let panel = el.find('.panel__content');
            // let id = $(panel).find('canvas');
            // console.log($(id).attr("width"));
            // $(id).attr("width", width - 30)
            // $(id).attr("height", height - 30)

            // document.getElementById('gauge').getContext('2d').save();
            // document.getElementById('gauge').getContext('2d').setTransform(1, 0, 0, 1, 0, 0);
            // document.getElementById('gauge').getContext('2d').clearRect(0, 0, document.getElementById('gauge').getContext('2d').canvas.width, document.getElementById('gauge').getContext('2d').canvas.height);
            // document.getElementById('gauge').getContext('2d').restore();
        }
        else if (type === "Map") {
            let map = Dashboard.getWidgetById(node.id);
            console.log(map);
            map.myMap.invalidateSize();
        }
    });
});

let weather1 = [];

function weather() {
    //headers:{'Content-Type':'application/json' , 'authorization':'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImU3Njk5YzY5ZDY0YjVkNDUzNGFiOGUyM2QyMmY0MTdmMjA0NTQ2ZGU5N2Q2OGZjOGU3MTFjNWRjYjJlZTk0NDE0OWNmMjBiZDIzYmIwMmZlIn0.eyJhdWQiOiIyIiwianRpIjoiZTc2OTljNjlkNjRiNWQ0NTM0YWI4ZTIzZDIyZjQxN2YyMDQ1NDZkZTk3ZDY4ZmM4ZTcxMWM1ZGNiMmVlOTQ0MTQ5Y2YyMGJkMjNiYjAyZmUiLCJpYXQiOjE1MzY5MzA1OTQsIm5iZiI6MTUzNjkzMDU5NCwiZXhwIjoxNTY4NDY2NTk0LCJzdWIiOiIyNjUiLCJzY29wZXMiOltdfQ.YpNDR_qqohsKFikhEl1Ghc06yK7E6Aqeg8khUInXuNPKSw6X7_isXZgb3CYZFY9rYLt28VGrHmvqJMUM3Qz13vdI0G2BtEjtvAmoKVgaTWOGkT34igx68AyIDrzw2g-dD6aFlo50KCMMnAP8u7dwqBX9VU4yKc3dsMAIkGu9-lkmuJKL0_Tfx_DiNfIr5AOZAX_ME6R5zjVoiCFnGtX6frVoLc8WH6N5AK2yQrN-gjJwnLYFCS7lkmEtTSxavf-MigVijYRDtjAeO5vqd_uADCjyWsLMQ2BX27pnq09srvfgrhrUGq7w9Qm4IhYRUMHqKouQT9AyGC9nQm_EBHAovtXkjWMObw87ucewTK2BXDhaV3zOe9Ww_Nv2kVMvf5mIl4zMZKp-BjRY0RKBoDg1xfm11IdVzwaiHYSRnMhMDgXcAYRBgxdTNjWLlGlVrapA6GgYatG6-Mie1iuuuhJfah2EzYwTwEuXqwh3cctl5FSxC0JsDtAo8DOYCq_Esbth0nPc4cpFL9YFHaE-vO1Sj-qNBA4b6x8EOGh_rdkOnqEOAVqxKe9lio9jM1N8EOenOlTpmUDB95w8hfI1j_KdpqQqy1zgGRn_BgrHnZJxDeOXKNMfgBtMfD3aQreU75InECJ8_5uCmgtSeYF0bjgAmBYd37yJo9zprO0MNBeEGLk'},
    //url: 'http://data.tmd.go.th/nwpapi/v1/forecast/location/hourly/region?region=C&fields=tc,rh&date=2018-09-15&hour=8&duration=2',
    $.ajax({
        dataType: "json",
        url: '/js/company/test-api.json',
        async: false,
        success: function (data) {
            weather1 = data;
        }
    });
}
