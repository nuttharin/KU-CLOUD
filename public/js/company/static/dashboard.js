class Widget {

    constructor(widget) {

        this.itemId = widget.itemId;
        this.widgetId = widget.widgetId;
        this.type = widget.type;
        this.title_name = widget.title_name;
        this.lastUpdate = widget.lastUpdate;
        this.timeInterval = widget.timeInterval;
        this.wi = widget.wi;

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

        let bindWidgetElement = () => {
            $(".btn-delete-wi").unbind().click(function () {
                onDeleteWidgetClick($(this));
            })
        };

        let onDeleteWidgetClick = (el) => {
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
        };

        let submitDeleteWidget = (el) => {
            let item = $(el).attr("item");
            grid.removeWidget($('#' + item).closest(".grid-stack-item"));

            // widgetList = widgetList.find(widget => {
            //     return widget.itemId != item
            // })
            // widgetList = [];
            // widgetList.push(widgetList);

            return false;
        };


        let formateDataSave = (data) => {
            let formateDate = {
                type: data.type,
            };

            if (data.type === "MutiLine") {
                formateDate['title_name'] = data.title_name;
                formateDate['datasets'] = data.datasets;
            }
            else if (data.type === "text-line") {
                formateDate['title_name'] = data.title_name;
                formateDate['unit'] = data.unit;
                formateDate['rgb'] = data.rgb;
            }

            return formateDate;

        }

        this.createWidget = (gridData = null) => {

            let node = items.pop() || {
                x: 3,
                y: 4,
                width: 6,
                height: 7,
            };

            $(".grid-stack").gridstack(options);
            grid = $(".grid-stack").data("gridstack");

            let layout_widget = $("#layout-widget").html();
            layout_widget = layout_widget.replace(/div_id/g, this.itemId)
            layout_widget = layout_widget.replace("((wi))", this.wi)
            layout_widget = layout_widget.replace("((title_name))", this.title_name)

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
        }
    }
}

class MutiLine extends Widget {
    constructor(widget) {
        super(widget);

        this.chart = null;
        this.datasets = widget.datasets;

        this.createMutiLine = () => {
            let ctx = document.getElementById(this.widgetId);
            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: this.datasets
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
            this.chart = myChart;
        }
    }
}

class ChartTextLine extends MutiLine {
    constructor(widget) {
        super(widget);
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


        this.createTextLine = (data) => {
            let ctx = document.getElementById(this.widgetId);
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
                            this.rgb
                        ],
                        borderWidth: 2
                    }]
                },
                options: optionChartLineNotLable
            });

            this.chart = myChart;
            return myChart;
        }
    }
}

class Dashboard {
    constructor() {
        let widgetList = [];

        let options = {
            cellHeight: 80,
            verticalMargin: 10,
            float: false
        };

        let time = null;

        let getWigetType = () => {
            return $("#widget_type").val();
        }

        let getTitleName = () => {
            return $("#title-name").val();
        }

        let getTimeInterval = () => {
            return $("#MutiLine").find("#time-interval").val();
        }

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
                }
                data_line.push({ ...data });
            }

            let data_widget = {
                itemId: "item-" + divId,
                widgetId: "myChart_" + divId,
                type: getWigetType(),
                title_name: getTitleName(),
                lastUpdate: "lastUpdate",
                datasets: [...data_line],
                wi: `<canvas id="myChart_${divId}"></canvas>`
            }
            return data_widget;
        }

        let getValueTextLine = (divId) => {
            let unit = $("#text-line").find("#unit").val();
            let rgb = $("#value-text-line").find("#rgb").val();

            let data_widget = {
                itemId: "item-" + divId,
                widgetId: "myChart_" + divId,
                type: getWigetType(),
                title_name: getTitleName(),
                lastUpdate: "lastUpdate",
                rgb: rgb,
                unit: unit,
                wi: `<h2 class="text-left"><span id="value_${divId}">0</span> ${unit}</h2>
                        <canvas id="myChart_${divId}"></canvas>`
            }
            return data_widget;
        }

        let createFormBodyInputWidget = (type) => {
            $(".value_widget").hide();
            if (type === "MutiLine") {
                $("#MutiLine").show();
            }
            else if (type === "text-line") {
                $("#text-line").show();
            }
            else if (type === "text") {
                $("#text-box").show();
            }
            else {
                $("#form-input-widget").html("");
            }
        };

        let onAddValueMutiLineClick = () => {
            let formhtml = $("#line_value_layout").html();
            $("#Mutiline_value").append(formhtml);
        }

        let onAddWidgetClick = () => {
            let type = getWigetType();
            var divId = Math.floor(100000 + Math.random() * 900000);
            let obj_widget = null;
            let widget = null;

            if (type === "MutiLine") {
                widget = getValueMutiLine(divId)
                obj_widget = new MutiLine(widget);
                obj_widget.createWidget();
                obj_widget.createMutiLine();
            }
            else if (type === "text-line") {
                widget = getValueTextLine(divId)
                obj_widget = new ChartTextLine(widget);
                obj_widget.createWidget();
                obj_widget.createTextLine();
            }
            //console.log(obj_widget);
            widgetList.push(obj_widget);
        }

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
        }

        let bindElement = () => {
            $("#settingW").click(function () {
                clearInterval(time);
                $(this).hide();
                $(".edit-widget").show();
                $("#addW").show();
                $("#saveW").show();
            });

            $("#widget_type").change(function () {
                $(".value_widget").hide();
                createFormBodyInputWidget(getWigetType());
            });

            $("#addW").unbind().click(function () {
                $("#myModal").modal('show');
            });

            $("#add-new-widget").unbind().click(function () {
                onAddWidgetClick();
            });

            $("#saveW").unbind().click(function () {
                $("#saveW").hide();
                $("#addW").hide();
                $("#settingW").show();
                $(".edit-widget").hide();
                updateDatalast();
                saveGrid();
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
            }, 1000)
        }

        let updateData = (widgets) => {
            for (var i = 0; i < widgets.length; i++) {
                if (widgets[i].type === 'MutiLine') {
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
                    let value = widgets[i].widgetId;
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

        let createDashboardInit = (dashboard) => {
            let obj_widget = null;
            let widgets = null;
            let gridData = null;
            let type = "";
            for (var key in dashboard) {

                var divId = Math.floor(100000 + Math.random() * 900000);
                obj_widget = null;
                widgets = { ...dashboard[key].widget };
                gridData = { ...dashboard[key] };
                widgets["itemId"] = "item_" + divId;
                type = widgets.type;

                if (type === "MutiLine") {
                    widgets["widgetId"] = "myChart_" + divId;
                    widgets["wi"] = `<canvas id="myChart_${divId}"></canvas>`

                    obj_widget = new MutiLine(widgets);
                    obj_widget.createWidget(gridData);
                    obj_widget.createMutiLine()
                }
                else if (type === "text-line") {
                    widgets["widgetId"] = "myChart_" + divId;
                    widgets["wi"] =
                        `<h2 class="text-left"><span id="value_${divId}">0</span> ${widgets.unit}</h2>
                        <canvas id="myChart_${divId}"></canvas>
                        `
                    obj_widget = new ChartTextLine(widgets);
                    obj_widget.createWidget(gridData);
                    obj_widget.createTextLine()
                }
                widgetList.push(obj_widget)
            }

            $(".edit-widget").hide();
        }

        this.getWidgetList = () => {
            return widgetList;
        };

        this.setWidgetList = (data) => {
            return widgetList.push(data);
        };

        this.initDashboard = () => {
            bindElement();
            // set widget $.ajax
            // test use localstorage
            let dashboard = "";
            if (getStorage("dashboard") != "") {
                dashboard = getStorage("dashboard");
                createDashboardInit(dashboard);
                //console.log(dashboard);
            }

            updateDatalast();
        };
    }
}

$(document).ready(function () {
    let dashboard = new Dashboard;
    dashboard.initDashboard();
})