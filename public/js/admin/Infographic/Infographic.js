const END_POINT       = 'http://localhost:8000/api/';
var path              = $("#pathImg").val();
var infoID            = $("#infoID").val();
var CircularJSON      = window.CircularJSON;
let widgetObjectList  = [];

class Workspace {
  constructor() {
    /* Initial Function */
    this.initialAndRun = () => {
      $("#btnGraph").unbind().click(function () {
        graphMenu();
      });

      $("#btnMap").unbind().click(function () {
        mapMenu();
      });

      $("#btnFont").unbind().click(function () {
        fontMenu();
      });

      $("#btnImage").unbind().click(function () {
        imageMenu();
      });

      $("#btnShapes").unbind().click(function () {
        shapesMenu();
      });

      $("#btn_save").unbind().click(function () {
        /* Update position widget data */
        for (var i = 0; i < widgetObjectList.length; i++) {
          if (widgetObjectList[i].type == "line" || widgetObjectList[i].type == "bar" || widgetObjectList[i].type == "pie" || widgetObjectList[i].type == "radar") {
            widgetObjectList[i].canvasTag = document.getElementById("div_canvas_" + widgetObjectList[i].id).outerHTML;
          }
          else if (widgetObjectList[i].type == "head") {
            widgetObjectList[i].spanTag = document.getElementById("span_" + widgetObjectList[i].id).outerHTML;
          }
          else if (widgetObjectList[i].type == "square" || widgetObjectList[i].type == "circle" || widgetObjectList[i].type == "string") {
            widgetObjectList[i].divTag = document.getElementById("div_" + widgetObjectList[i].id).outerHTML;
          }
        }

        /* Save info data to database  */
        $.ajax({
          url: END_POINT + 'admin/infographic/updateInfoData',
          method: 'PUT',
          data: {
              info_id:   infoID,
              info_data: CircularJSON.stringify(widgetObjectList),
          },
          success: (res) => {
            console.log("success");
          },
          error: (res) => {
            console.log("error");
          }
        }); //Ajax
      }); //Btn save

      $("#btn_fullscreen").unbind().click(function () {
        var popup = window.open();
        popup.document.write("<h1 id='loading'>Loading...</h1>");

        //Set object for fullscreen
        $(".sPosition").removeClass("fCorner");
        $(".propertyMenu").html(``);

        //Generate to image
        html2canvas(document.querySelector("#workspace")).then(canvas => {
          var myImage = canvas.toDataURL("image/png");
          var img     = '<img src="' + myImage + '">';

          popup.document.write(img);
          popup.document.title = "Preview";
          popup.document.getElementById("loading").remove();
        }); //Html2canvas
      }); //Btn fullscreen

      $("#btn_download").unbind().click(function () {
        var popup = window.open();
        popup.document.write("<h1>Please wait for download...</h1>");

        //Set object for fullscreen
        $(".sPosition").removeClass("fCorner");
        $(".propertyMenu").html(``);

        //Generate to image
        html2canvas(document.querySelector("#workspace")).then(canvas => {
          popup.close();
          var myLinkImage = canvas.toDataURL("image/png");
          var pdf         = new jsPDF();

          pdf.addImage(myLinkImage, 'JPEG', 0, 0);
          pdf.save("ImageDownload.pdf");
        }); //Html2canvas
      }); //BTn download

    }; // Initial and run

    /* Load widget data from database */
    this.loadWidgetData = (object) => {
      for (var i = 0; i < object.length; i++) {
        if (object[i].type == "line" || object[i].type == "bar" || object[i].type == "pie" || object[i].type == "radar") {
          var Graphwidget = new Graph();
          Graphwidget.loadGraphData(object[i].id, object[i].canvasTag, object[i].chartData, object[i].chartOption, object[i].type);
        }
        else if (object[i].type == "head") {
          var fontHead = new Font();
          fontHead.loadHeadGraph(object[i].id, object[i].spanTag);
        }
        else if (object[i].type == "square" || object[i].type == "circle" || object[i].type == "string") {
          var shapewidget = new Shape();
          shapewidget.loadShapeWidget(object[i].id, object[i].divTag, object[i].type);
        }
      }
    } // Load widget data

    /* Initial Element Action Function */
    var graphMenu = () => {
      if ($("#btnGraph").hasClass("actives")) {
        UnActive("btnGraph");
      }
      else {
        SetActive("btnGraph");

        $("#selectMenu").html(`<top class="head">Add Graph<close><i class="fas fa-times"></i></close></top>
                                <sub id="g1"><img src="${path}/graph/line.png" style="width:60%; height:60%;"/><title>Line</title></sub>
                                <sub id="g2"><img src="${path}/graph/bar.png" style="width:60%; height:60%;"/><title>Bar</title></sub>
                                <sub id="g3"><img src="${path}/graph/pie.png" style="width:60%; height:60%;"/><title>Pie</title></sub>
                                <sub id="g4"><img src="${path}/graph/radar.png" style="width:60%; height:60%;"/><title>Radar</title></sub>`);

        $(".fa-times").unbind().click(function () {
          UnActive("btnGraph");
        });

        $("#g1").unbind().click(function () {
          var lineGraph = new Graph();
          lineGraph.createLineGraph();
        });

        $("#g2").unbind().click(function () {
          var barGraph = new Graph();
          barGraph.createBarGraph();
        });

        $("#g3").unbind().click(function () {
          var pieGraph = new Graph();
          pieGraph.createPieGraph();
        });

        $("#g4").unbind().click(function () {
          var radarGraph = new Graph();
          radarGraph.createRadarGraph();
        });
      }
    }

    var mapMenu = () => {
      if ($("#btnMap").hasClass("actives")) {
        UnActive("btnMap");
      }
      else {
        SetActive("btnMap");

        $("#selectMenu").html(`<top href="#" class="head">Add Map<close><i class="fas fa-times"></i></close></top>
                                <sub id="m1"><img src="${path}/map/map.png" style="width:60%; height:60%;"/><title>Map</title></sub>`);

        $(".fa-times").unbind().click(function () {
          UnActive("btnMap");
        });

        $("#m1").unbind().click(function () {
          var mapWidget = new Map();
          mapWidget.createMapWidget();
        });

      }
    }

    var fontMenu = () => {
      if ($("#btnFont").hasClass("actives")) {
        UnActive("btnFont");
      }
      else {
        SetActive("btnFont");

        $("#selectMenu").html(`<top href="#" class="head">Add Text<close><i class="fas fa-times"></i></close></top>
                                <sub id="f1"><img src="${path}/font/head.png" style="width:60%; height:60%;"/><title>Title</title></sub>
                                <sub id="f2"><img src="${path}/font/subtitle.png" style="width:60%; height:60%;"/><title>Subtitle</title></sub>
                                <sub id="f3"><img src="${path}/font/table.png" style="width:60%; height:60%;"/><title>Table</title></sub>`);

        $(".fa-times").unbind().click(function () {
          UnActive("btnFont");
        });

        $("#f1").unbind().click(function () {
          var fontHead = new Font();
          fontHead.createHeadGraph("title");
        });

        $("#f2").unbind().click(function () {
          var fontHead = new Font();
          fontHead.createHeadGraph("subtitle");
        });

        $("#f3").unbind().click(function () {
          alert("f3");
        });
      }
    }

    var imageMenu = () => {
      if ($("#btnImage").hasClass("actives")) {
        UnActive("btnImage");
      }
      else {
        SetActive("btnImage");

        $("#selectMenu").html(`<top href="#" class="head">Add Image<close><i class="fas fa-times"></i></close></top>
                                <sub id="i1">Browse</sub>
                                <input type="file" id="file_image" style="display:none;" />`);

        $(".fa-times").unbind().click(function () {
          UnActive("btnImage");
        });

        $("#i1").unbind().click(function () {
          var imageWidget = new Image();
          
          $("#file_image").click();

          $('#file_image').change(function () {
            var reader = new FileReader();
            reader.readAsDataURL($(this)[0].files[0]);
            reader.onload = function (e) 
            {
              imageWidget.createImageWidget(e.target.result);
              /*Reset button */
              $("#btnImage").click();
              $("#btnImage").click();
            }
          });
        });
      }
    }

    var shapesMenu = () => {
      if ($("#btnShapes").hasClass("actives")) {
        UnActive("btnShapes");
      }
      else {
        SetActive("btnShapes");

        $("#selectMenu").html(`<top href="#" class="head">Add Shape<close><i class="fas fa-times"></i></close></top>
                                <sub id="s1"><img src="${path}/shape/square.png" style="width:60%; height:60%;"/><title>Square</title></sub>
                                <sub id="s2"><img src="${path}/shape/circle.png" style="width:60%; height:60%;"/><title>Circle</title></sub>
                                <sub id="s3"><img src="${path}/shape/string.png" style="width:60%; height:60%;"/><title>Line</title></sub>`);

        $(".fa-times").unbind().click(function () {
          UnActive("btnShapes");
        });

        $("#s1").unbind().click(function () {
          var shapeWidget = new Shape();
          shapeWidget.createShapeWidget("square");
        });

        $("#s2").unbind().click(function () {
          var shapeWidget = new Shape();
          shapeWidget.createShapeWidget("circle");
        });

        $("#s3").unbind().click(function () {
          var shapeWidget = new Shape();
          shapeWidget.createShapeWidget("string");
        });
      }
    }

    /* Custom Function */
    var UnActive = (id) => {
      $("#" + id).removeClass("actives");
      $("#selectMenu").html(``);
      $("#selectMenu").hide();
    }

    var SetActive = (id) => {
      $("#selectMenu").show();
      $(".vertical-menu").find("a").removeClass("actives");
      $("#" + id).addClass("actives");
    }

  } // Constructor
} // Workspace

class Widget {
  constructor() {
    /* Create freetranform */
    this.createWidget = (id, typeid) => {
      var widgetObject = interact('#' + typeid + id)
        .draggable({
          autoScroll: true,
          inertia: true,
          restrict: {
            restriction: 'parent',
            endOnly: true,
            elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
          },
        })
        .resizable({
          // resize from all edges and corners
          edges: {left: true, right: true, bottom: true, top: true},

          // keep the edges inside the parent
          restrictEdges: {
            outer: 'parent',
            endOnly: true,
          },

          // minimum size
          restrictSize: {
            min: { width: 100, height: 50 },
          },

          inertia: true,
        })
        .on('doubletap', function () {
          $(".sPosition").removeClass("fCorner");

          /* Clear property */
          $(".propertyMenu").html(``);
        })
        .on('resizemove', function (event) {
          changefocus(id, typeid);
          var target = event.target,
            x = (parseFloat(target.getAttribute('data-x')) || 0),
            y = (parseFloat(target.getAttribute('data-y')) || 0);

          // update the element's style
          target.style.width = event.rect.width + 'px';
          target.style.height = event.rect.height + 'px';

          //console.log(target);
          //$(target).attr('width', event.rect.width);
          //$(target).attr('height', event.rect.height);

          // translate when resizing from top or left edges
          x += event.deltaRect.left;
          y += event.deltaRect.top;

          target.style.webkitTransform = target.style.transform =
            'translate(' + x + 'px,' + y + 'px)';

          target.setAttribute('data-x', x);
          target.setAttribute('data-y', y);

          $("#width_" + id).val(Math.round(event.rect.width));
          $("#height_" + id).val(Math.round(event.rect.height));
          $("#width_" + id).change();
          $("#height_" + id).change();
        });

      return widgetObject;
    }

    /* Custom function */
    let changefocus = (id, typeid) => {
      $(".sPosition").removeClass("fCorner");
      $('#' + typeid + id).addClass("fCorner");
    }

    this.clearfocus = () => {
      $(".sPosition").removeClass("fCorner");
    }
  }
}

/* Graph */
class Graph extends Widget {
  constructor() {
    super();
    this.createLineGraph = () => {
      var id = Math.floor(100000 + Math.random() * 900000);
      this.clearfocus();

      $("#workspace").append(`<div id="div_canvas_${id}" class="sPosition fCorner"><canvas id="canvas_${id}"/></div>`);

      var speedData = {
        labels: ["0s", "10s", "20s", "30s", "40s", "50s", "60s"],
        datasets: [{
          label: "Car Speed",
          data: [0, 59, 75, 20, 20, 55, 40],
        }, {
          label: "Car Speed2",
          data: [0, 29, 25, 20, 20, 25, 20],
        }]
      };

      var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: true,
          position: 'top',
          labels: {
            boxWidth: 80,
            fontColor: 'black'
          }
        }
      };

      let ctx = document.getElementById("canvas_" + id);
      var myChart = new Chart(ctx, {
        type: 'line',
        data: speedData,
        options: chartOptions
      });

      /* Clear other property */
      $(".propertyMenu").html(``);

      var property = new ContentProperty();
      property.createGraphProp(id, myChart, "#div_canvas_" + id, "graph");

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "div_canvas_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#div_canvas_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createGraphProp(id, myChart, "#div_canvas_" + id, "graph");
      })
        .on('dragmove', function (event) {
          /* Change focus */
          $(".sPosition").removeClass("fCorner");
          $("#div_canvas_" + id).addClass("fCorner");

          var target = event.target,
            // keep the dragged position in the data-x/data-y attributes
            x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
            y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

          // translate the element
          target.style.webkitTransform =
            target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';

          // update the posiion attributes
          target.setAttribute('data-x', x);
          target.setAttribute('data-y', y);

          /* Clear other property */
          $(".propertyMenu").html(``);

          var property = new ContentProperty();
          property.createGraphProp(id, myChart, "#div_canvas_" + id, "graph");
        })



      /* Save widget */
      let saveObject = new WidgetObject();
      console.log(myChart.options);
      saveObject.WidgetGraphObject(id, null, myChart.data, myChart.options, "line");
      console.log(saveObject.chartOption);
      widgetObjectList.push(saveObject);
      widgetObjectList = deepCopy(widgetObjectList);    
      console.log(widgetObjectList[0].chartOption);
    }

    this.createBarGraph = () => {
      var id = Math.floor(100000 + Math.random() * 900000);
      this.clearfocus();

      $("#workspace").append(`<div id="div_canvas_${id}" class="sPosition fCorner"><canvas id="canvas_${id}"/></div>`);

      var speedData = {
        labels: ["0s", "10s", "20s", "30s", "40s", "50s", "60s"],
        datasets: [{
          label: "Car Speed",
          data: [0, 59, 75, 20, 20, 55, 40],
        }, {
          label: "Car Speed2",
          data: [0, 29, 25, 20, 20, 25, 20],
        }]
      };

      var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: true,
          position: 'top',
          labels: {
            boxWidth: 80,
            fontColor: 'black'
          }
        }
      };

      let ctx = document.getElementById("canvas_" + id);
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: speedData,
        options: chartOptions
      });

      /* Clear other property */
      $(".propertyMenu").html(``);

      var property = new ContentProperty();
      property.createGraphProp(id, myChart, "#div_canvas_" + id, "graph");

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "div_canvas_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#div_canvas_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createGraphProp(id, myChart, "#div_canvas_" + id, "graph");
      })
      .on('dragmove', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#div_canvas_" + id).addClass("fCorner");

        var target = event.target,
          // keep the dragged position in the data-x/data-y attributes
          x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
          y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

        // translate the element
        target.style.webkitTransform =
          target.style.transform =
          'translate(' + x + 'px, ' + y + 'px)';

        // update the posiion attributes
        target.setAttribute('data-x', x);
        target.setAttribute('data-y', y);

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createGraphProp(id, myChart, "#div_canvas_" + id, "graph");
      })

      /* Save widget */
      let saveObject = new WidgetObject();
      console.log(myChart.options);
      saveObject.WidgetGraphObject(id, null, myChart.data, myChart.options, "bar");
      console.log(saveObject.chartOption);
      widgetObjectList.push(saveObject);
      widgetObjectList = deepCopy(widgetObjectList);    
      console.log(widgetObjectList[0].chartOption);
    }

    this.createPieGraph = () => {
      var id = Math.floor(100000 + Math.random() * 900000);
      this.clearfocus();

      $("#workspace").append(`<div id="div_canvas_${id}" class="sPosition fCorner"><canvas id="canvas_${id}"/></div>`);

      var speedData = {
        labels: ["0s", "10s", "20s", "30s", "40s", "50s", "60s"],
        datasets: [{
          label: "Car Speed",
          data: [0, 59, 75, 20, 20, 55, 40],
        }, {
          label: "Car Speed2",
          data: [0, 29, 25, 20, 20, 25, 20],
        }]
      };

      var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: true,
          position: 'top',
          labels: {
            boxWidth: 80,
            fontColor: 'black'
          }
        }
      };

      let ctx = document.getElementById("canvas_" + id);
      var myChart = new Chart(ctx, {
        type: 'pie',
        data: speedData,
        options: chartOptions
      });

      /* Clear other property */
      $(".propertyMenu").html(``);

      var property = new ContentProperty();
      property.createGraphProp(id, myChart, "#div_canvas_" + id, "graph");

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "div_canvas_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#div_canvas_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createGraphProp(id, myChart, "#div_canvas_" + id, "graph");
      })
      .on('dragmove', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#div_canvas_" + id).addClass("fCorner");

        var target = event.target,
          // keep the dragged position in the data-x/data-y attributes
          x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
          y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

        // translate the element
        target.style.webkitTransform =
          target.style.transform =
          'translate(' + x + 'px, ' + y + 'px)';

        // update the posiion attributes
        target.setAttribute('data-x', x);
        target.setAttribute('data-y', y);

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createGraphProp(id, myChart, "#div_canvas_" + id, "graph");
      })

      /* Save widget */
      let saveObject = new WidgetObject();
      console.log(myChart.options);
      saveObject.WidgetGraphObject(id, null, myChart.data, myChart.options, "pie");
      console.log(saveObject.chartOption);
      widgetObjectList.push(saveObject);
      widgetObjectList = deepCopy(widgetObjectList);    
      console.log(widgetObjectList[0].chartOption);
    }

    this.createRadarGraph = () => {
      var id = Math.floor(100000 + Math.random() * 900000);
      this.clearfocus();

      $("#workspace").append(`<div id="div_canvas_${id}" class="sPosition fCorner"><canvas id="canvas_${id}"/></div>`);

      var speedData = {
        labels: ["0s", "10s", "20s", "30s", "40s", "50s", "60s"],
        datasets: [{
          label: "Car Speed",
          data: [0, 59, 75, 20, 20, 55, 40],
        }, {
          label: "Car Speed2",
          data: [0, 29, 25, 20, 20, 25, 20],
        }]
      };

      var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: true,
          position: 'top',
          labels: {
            boxWidth: 80,
            fontColor: 'black'
          }
        }
      };

      let ctx = document.getElementById("canvas_" + id);
      var myChart = new Chart(ctx, {
        type: 'radar',
        data: speedData,
        options: chartOptions
      });

      /* Clear other property */
      $(".propertyMenu").html(``);

      var property = new ContentProperty();
      property.createGraphProp(id, myChart, "#div_canvas_" + id, "graph");

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "div_canvas_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#div_canvas_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createGraphProp(id, myChart, "#div_canvas_" + id, "graph");
      })
      .on('dragmove', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#div_canvas_" + id).addClass("fCorner");

        var target = event.target,
          // keep the dragged position in the data-x/data-y attributes
          x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
          y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

        // translate the element
        target.style.webkitTransform =
          target.style.transform =
          'translate(' + x + 'px, ' + y + 'px)';

        // update the posiion attributes
        target.setAttribute('data-x', x);
        target.setAttribute('data-y', y);

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createGraphProp(id, myChart, "#div_canvas_" + id, "graph");
      })

      /* Save widget */
      let saveObject = new WidgetObject();
      console.log(myChart.options);
      saveObject.WidgetGraphObject(id, null, myChart.data, myChart.options, "radar");
      console.log(saveObject.chartOption);
      widgetObjectList.push(saveObject);
      widgetObjectList = deepCopy(widgetObjectList);    
      console.log(widgetObjectList[0].chartOption);
    }

    this.loadGraphData = (id, canvasTag, chartData, chartOptions, chartType) => {
      this.clearfocus();
      $("#workspace").append(canvasTag);

      let ctx = document.getElementById("canvas_" + id);
      var myChart2 = new Chart(ctx, {
        type: chartType,
        options: chartOptions
      });

      addLabel(myChart2, chartData.labels);
      addDatasets(myChart2, chartData.datasets);

      /* Clear other property */
      $(".propertyMenu").html(``);
      this.clearfocus();

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "div_canvas_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#div_canvas_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createGraphProp(id, myChart2, "#div_canvas_" + id, "graph");
      })
        .on('dragmove', function (event) {
          /* Change focus */
          $(".sPosition").removeClass("fCorner");
          $("#div_canvas_" + id).addClass("fCorner");

          var target = event.target,
            // keep the dragged position in the data-x/data-y attributes
            x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
            y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

          // translate the element
          target.style.webkitTransform =
            target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';

          // update the posiion attributes
          target.setAttribute('data-x', x);
          target.setAttribute('data-y', y);

          /* Clear other property */
          $(".propertyMenu").html(``);

          var property = new ContentProperty();
          property.createGraphProp(id, myChart2, "#div_canvas_" + id, "graph");
        })

      /* Save widget */
      let saveObject = new WidgetObject();
      saveObject.WidgetGraphObject(id, null, myChart2.data, myChart2.options, chartType);
      widgetObjectList.push(saveObject);
      widgetObjectList = deepCopy(widgetObjectList);  
    }

    let addLabel = (chart, labels) => {
      for (var i = 0; i < labels.length; i++) {
        chart.data.labels.push(labels[i]);
      }
      chart.update();
    }

    let addDatasets = (chart, dataSets) => {
      for (var i = 0; i < dataSets.length; i++) {
        var newData =
        {
          label: dataSets[i].label,
          data: dataSets[i].data,
        };

        chart.data.datasets.push(newData);
      }
      chart.update();
    }
  }
} //Widget class

class Map extends Widget{
  constructor(){
    super();
    this.createMapWidget = () => {
      var id = Math.floor(100000 + Math.random() * 900000);
      this.clearfocus();

      $("#workspace").append(`<div id="div_map_${id}" class="sPosition fCorner crispyOutter"><div id="map_${id}" class="crispyInner"></div></div>`);

      $('#map_' + id).css('height', 300);
      $('#map_' + id).css('width', 300);

      let mymap;
      let mapid = "map_" + id;

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

      // mymap.on('mouseover', console.log("in"));
      // mymap.on('mouseout', console.log("out"));

      /* Clear other property */
      $(".propertyMenu").html(``);

      var property = new ContentProperty();
      property.createMapProp(id, "#div_map_" + id, "map", mymap);

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "div_map_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#div_map_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createMapProp(id, "#div_map_" + id, "map", mymap);
      })
        .on('dragmove', function (event) {
          /* Change focus */
          $(".sPosition").removeClass("fCorner");
          $("#div_map_" + id).addClass("fCorner");

          var target = event.target,
            // keep the dragged position in the data-x/data-y attributes
            x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
            y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

          // translate the element
          target.style.webkitTransform =
            target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';

          // update the posiion attributes
          target.setAttribute('data-x', x);
          target.setAttribute('data-y', y);

          /* Clear other property */
          $(".propertyMenu").html(``);

          var property = new ContentProperty();
          property.createMapProp(id, "#div_map_" + id, "map", mymap);
        })

      /* Save widget */
      let saveObject = new WidgetObject();
      saveObject.HeadFontObject(id, null, "head");
      widgetObjectList.push(saveObject);
    }
  }
}

/* Font */
class Font extends Widget {
  constructor() {
    super();
    this.createHeadGraph = (type) => {
      var id = Math.floor(100000 + Math.random() * 900000);
      this.clearfocus();

      if(type == "title")
      {
        $("#workspace").append(`<span id="span_${id}" class="sPosition fCorner" style="font-size: 100px;">Title</span>`);
      }
      else if(type == "subtitle")
      {
        $("#workspace").append(`<span id="span_${id}" class="sPosition fCorner" style="font-size: 40px; color: rgb(73, 73, 73);">subtitle</span>`);
      }
      
      /* Clear other property */
      $(".propertyMenu").html(``);

      var property = new ContentProperty();
      property.createTextProp(id, "#span_" + id, "text");

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "span_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#span_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createTextProp(id, "#span_" + id, "text");
      })
        .on('dragmove', function (event) {
          /* Change focus */
          $(".sPosition").removeClass("fCorner");
          $("#span_" + id).addClass("fCorner");

          var target = event.target,
            // keep the dragged position in the data-x/data-y attributes
            x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
            y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

          // translate the element
          target.style.webkitTransform =
            target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';

          // update the posiion attributes
          target.setAttribute('data-x', x);
          target.setAttribute('data-y', y);

          /* Clear other property */
          $(".propertyMenu").html(``);

          var property = new ContentProperty();
          property.createTextProp(id, "#span_" + id, "text");
        })

      /* Save widget */
      let saveObject = new WidgetObject();
      saveObject.HeadFontObject(id, null, "head");
      widgetObjectList.push(saveObject);
    }

    this.loadHeadGraph = (id, spanTag) => {
      this.clearfocus();

      $("#workspace").append(spanTag);

      /* Clear other property */
      $(".propertyMenu").html(``);
      this.clearfocus();

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "span_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#span_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createTextProp(id, "#span_" + id, "text");
      })
        .on('dragmove', function (event) {
          /* Change focus */
          $(".sPosition").removeClass("fCorner");
          $("#span_" + id).addClass("fCorner");

          var target = event.target,
            // keep the dragged position in the data-x/data-y attributes
            x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
            y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

          // translate the element
          target.style.webkitTransform =
            target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';

          // update the posiion attributes
          target.setAttribute('data-x', x);
          target.setAttribute('data-y', y);

          /* Clear other property */
          $(".propertyMenu").html(``);

          var property = new ContentProperty();
          property.createTextProp(id, "#span_" + id, "text");
        })

      /* Save widget */
      let saveObject = new WidgetObject();
      saveObject.HeadFontObject(id, null, "head");
      widgetObjectList.push(saveObject);
    }
  } //Constructor
} //Font class

class Image extends Widget{
  constructor(){
    super();
    this.createImageWidget = (src_image) => {
      var id = Math.floor(100000 + Math.random() * 900000);
      this.clearfocus();

      $("#workspace").append(`<div id="div_${id}" class="sPosition fCorner"><img id="image_${id}" src="${src_image}" class="scaleImage" /></div>`);
      
      $('#div_' + id).css('height', 150);
      $('#div_' + id).css('width', 150);

      /* Clear other property */
      $(".propertyMenu").html(``);

      var property = new ContentProperty();
      property.createImageProp(id, "#div_" + id, "#image_" + id, "image");

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "div_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#div_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createImageProp(id, "#div_" + id, "#image_" + id, "image");
      })
        .on('dragmove', function (event) {
          /* Change focus */
          $(".sPosition").removeClass("fCorner");
          $("#div_" + id).addClass("fCorner");

          var target = event.target,
            // keep the dragged position in the data-x/data-y attributes
            x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
            y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

          // translate the element
          target.style.webkitTransform =
            target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';

          // update the posiion attributes
          target.setAttribute('data-x', x);
          target.setAttribute('data-y', y);

          /* Clear other property */
          $(".propertyMenu").html(``);

          var property = new ContentProperty();
          property.createImageProp(id, "#div_" + id, "#image_" + id, "image");
        })

      /* Save widget */
      let saveObject = new WidgetObject();
      saveObject.WidgetShapeObject(id, null, "image");
      widgetObjectList.push(saveObject);
    }   
  } //Constructor
} //Image class

class Shape extends Widget{
  constructor(){
    super();
    this.createShapeWidget = (type) => {
      var id = Math.floor(100000 + Math.random() * 900000);
      this.clearfocus();

      if(type == "square")
      {
        $("#workspace").append(`<div id="div_${id}" class="sPosition fCorner"><div id="shape_${id}" class="square"></div></div>`);
      }
      else if(type == "circle")
      {
        $("#workspace").append(`<div id="div_${id}" class="sPosition fCorner"><div id="shape_${id}" class="circle"></div></div>`);
      }
      else if(type == "string")
      {
        $("#workspace").append(`<div id="div_${id}" class="sPosition fCorner"><div id="shape_${id}" class="string"></div></div>`);

      }

      $('#div_' + id).css('height', 150);
      $('#div_' + id).css('width', 150);

      /* Clear other property */
      $(".propertyMenu").html(``);

      var property = new ContentProperty();
      property.createShapeProp(id, "#div_" + id, "#shape_" + id, type);

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "div_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#div_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createShapeProp(id, "#div_" + id, "#shape_" + id, type);
      })
        .on('dragmove', function (event) {
          /* Change focus */
          $(".sPosition").removeClass("fCorner");
          $("#div_" + id).addClass("fCorner");

          var target = event.target,
            // keep the dragged position in the data-x/data-y attributes
            x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
            y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

          // translate the element
          target.style.webkitTransform =
            target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';

          // update the posiion attributes
          target.setAttribute('data-x', x);
          target.setAttribute('data-y', y);

          /* Clear other property */
          $(".propertyMenu").html(``);

          var property = new ContentProperty();
          property.createShapeProp(id, "#div_" + id, "#shape_" + id, type);
        })

      /* Save widget */
      let saveObject = new WidgetObject();
      saveObject.WidgetShapeObject(id, null, type);
      widgetObjectList.push(saveObject);
    }

    this.loadShapeWidget = (id, divTag, type) => {
      this.clearfocus();
      console.log(divTag);
      $("#workspace").append(divTag);

      /* Clear other property */
      $(".propertyMenu").html(``);
      this.clearfocus();

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "div_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#div_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createShapeProp(id, "#div_" + id, "#shape_" + id, type);
      })
        .on('dragmove', function (event) {
          /* Change focus */
          $(".sPosition").removeClass("fCorner");
          $("#div_" + id).addClass("fCorner");

          var target = event.target,
            // keep the dragged position in the data-x/data-y attributes
            x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
            y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

          // translate the element
          target.style.webkitTransform =
            target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';

          // update the posiion attributes
          target.setAttribute('data-x', x);
          target.setAttribute('data-y', y);

          /* Clear other property */
          $(".propertyMenu").html(``);

          var property = new ContentProperty();
          property.createShapeProp(id, "#div_" + id, "#shape_" + id, type);
        })

      /* Save widget */
      let saveObject = new WidgetObject();
      saveObject.WidgetShapeObject(id, null, type);
      widgetObjectList.push(saveObject);
    }
  } //Constructor
} //Shape class

class Property {
  constructor() {
    /* Create UI & function property */
    $("#propertySpace").html('<div class="propertyMenu"></div>');

    this.createPosition = (id, full_id) => {
      $(".propertyMenu").append(`                
          <div class="Editdatacrispy">
            <button type="button" id="backest_widget_${id}" class="btn btn-default positionset" ><i class="far fa-caret-square-down"></i></button>
            <button type="button" id="topest_widget_${id}" class="btn btn-default positionset" ><i class="far fa-caret-square-up"></i></button>
            <button type="button" id="align_left_widget_${id}" class="btn btn-default positionset" ><i class="fas fa-align-left"></i></button>
            <button type="button" id="align_center_widget_${id}" class="btn btn-default positionset" ><i class="fas fa-align-center"></i></button>
            <button type="button" id="align_right_widget_${id}" class="btn btn-default positionset" ><i class="fas fa-align-right"></i></button>
          </div>`);

      $("#backest_widget_" + id).click(function () {
        $(".sPosition").each(function (index) {
          if ($(this).hasClass("fCorner")) {
            $(this).css("z-index", 0);
          }
          else {
            $(this).css("z-index", index + 1);
          }
        });
      });

      $("#topest_widget_" + id).click(function () {
        $(".sPosition").each(function (index) {
          if ($(this).hasClass("fCorner")) {
            $(this).css("z-index", $(".sPosition").length);
          }
          else {
            $(this).css("z-index", index);
          }
        });
      });

      $("#align_left_widget_" + id).click(function () {
        var transform   = $(full_id).css('transform').split(',');
        var transformY  = transform[5].split(')')[0];

        $(full_id).css('transform', 'translate(0px, ' + transformY + 'px)');
        $(full_id).attr('data-x', 0);
        $(full_id).attr('data-y', transformY);
      });

      $("#align_center_widget_" + id).click(function () {
        var transform   = $(full_id).css('transform').split(',');
        var transformY  = transform[5].split(')')[0];
        var transformX  = (595 / 2) - ($(full_id).width() / 2);

        $(full_id).css('transform', 'translate(' + transformX + 'px, ' + transformY + 'px)');
        $(full_id).attr('data-x', transformX);
        $(full_id).attr('data-y', transformY);
      });

      $("#align_right_widget_" + id).click(function () {
        var transform   = $(full_id).css('transform').split(',');
        var transformY  = transform[5].split(')')[0];
        var transformX  = 595 - $(full_id).width();

        $(full_id).css('transform', 'translate(' + transformX + 'px, ' + transformY + 'px)');
        $(full_id).attr('data-x', transformX);
        $(full_id).attr('data-y', transformY);
      });
    }

    this.createDownload = (id, full_id) => {
      $(".propertyMenu").append(`
          <div class="Editdatacrispy">
            <button type="button" id="download_widget_${id}" class="btn btn-primary Editdata" >Download</button>
            <button type="button" id="preview_widget_${id}" class="btn btn-default" ><i class="fas fa-desktop"></i></button>
          </div>`);

      $("#download_widget_" + id).click(function () {
        var popup = window.open();
        popup.document.write("<h1>Please wait for download...</h1>");

        var transform = $(full_id).css('transform');
        var data_x    = $(full_id).css('data-x');
        var data_y    = $(full_id).css('data-y');

        $(full_id).css('transform', 'translate(0px, 0px)');
        $(full_id).css('data-x', 0);
        $(full_id).css('data-y', 0);
        $(full_id).removeClass("fCorner");

        html2canvas(document.querySelector(full_id)).then(canvas => {
          $(full_id).css('transform', transform);
          $(full_id).css('data-x', data_x);
          $(full_id).css('data-y', data_y);
          $(full_id).addClass("fCorner");

          var myLinkImage = canvas.toDataURL("image/png");
          var pdf         = new jsPDF();

          pdf.addImage(myLinkImage, 'JPEG', 0, 0);
          pdf.save("ImageDownload.pdf");

          popup.close();
        });
      });

      $("#preview_widget_" + id).click(function () {
        var popup = window.open();
        popup.document.write("<h1 id='loading'>Loading...</h1>");

        var transform = $(full_id).css('transform');
        var data_x = $(full_id).css('data-x');
        var data_y = $(full_id).css('data-y');

        $(full_id).css('transform', 'translate(0px, 0px)');
        $(full_id).css('data-x', 0);
        $(full_id).css('data-y', 0);
        $(full_id).removeClass("fCorner");

        html2canvas(document.querySelector(full_id)).then(div => {
          var myImage = div.toDataURL("image/png");

          $(full_id).css('transform', transform);
          $(full_id).css('data-x', data_x);
          $(full_id).css('data-y', data_y);
          $(full_id).addClass("fCorner");

          var img = '<img src="' + myImage + '">';
          popup.document.write(img);
          popup.document.title = "Preview";
          popup.document.getElementById("loading").remove();
        });
      });
    }

    this.createEditdata = (id, myChart, full_id) => {
      $(".propertyMenu").append(`                
          <div class="Editdatacrispy">
            <button type="button" class="btn btn-default Editdata" >Edit data</button>
            <button type="button" id="delete_canvas_widget_${id}" class="btn btn-default" ><i class="fas fa-trash-alt"></i></button>
          </div>`);

      $("#delete_canvas_widget_" + id).click(function () {
        widgetObjectList  = arrayRemove(widgetObjectList, id);
        let ctx           = document.getElementById("div_canvas_" + id);
        
        myChart.destroy();
        ctx.remove();

        $(".propertyMenu").html(``);
      });
    }

    this.createCropImage = (id, full_id, full_id_image) => {
      let cropObject;

      $(".propertyMenu").append(`                
          <div class="Editdatacrispy">
            <button type="button" id="crop_image_widget_${id}" class="btn btn-default Editdata" >Crop image</button>
            <button type="button" id="delete_image_widget_${id}" class="btn btn-default" ><i class="fas fa-trash-alt"></i></button>
          </div>`);

      $("#crop_image_widget_" + id).click(function () {
        $("#modelCrop_" + id).remove();
        var modalCrop = `
        <div class="modal" id="modelCrop_${id}" class="modelcropper">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crop image</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-11 text-center">
                                <img id="image_crop_${id}" style="max-width: 100%; max-height:50%;" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="save_image_crop_${id}" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>`;

        $('body').append(modalCrop);
        $("#modelCrop_" + id).modal('show');
        $("#image_crop_" + id).attr("src", $(full_id_image).attr("src"));
        let image = document.getElementById('image_crop_' + id);
        cropObject = new Cropper(image, {});

        $("#save_image_crop_" + id).click(function () {
          $(full_id_image).attr("src", cropObject.getCroppedCanvas({width: 500, height: 500}).toDataURL());
          cropObject.destroy();
          $("#modelCrop_" + id).modal('hide');
          $("#modelCrop_" + id).modal('dispose');
          $("#modelCrop_" + id).remove();
        });
      });

      $("#delete_image_widget_" + id).click(function () {
        let ctx = document.getElementById("div_" + id);   
        ctx.remove();
        
        $(".propertyMenu").html(``);
      });
    }

    this.createTextchange = (id, full_id) => {
      $(".propertyMenu").append(`                
          <div class="Scaling">
            <div class="row">
                <div class="col-8 rotates">
                    <span>Text change</span>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <input type="text" id="inputtext_${id}" class="form-control crispyText" value="Head"/>
                    <button type="button" id="delete_text_widget_${id}" class="btn btn-default" ><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
          </div>`);

      // Set start value
      $("#inputtext_" + id).val($("#span_" + id).html());

      $("#inputtext_" + id).keyup(function () {
        $("#span_" + id).html($("#inputtext_" + id).val());
      });

      $("#delete_text_widget_" + id).click(function () {
        widgetObjectList  = arrayRemove(widgetObjectList, id);
        let ctx           = document.getElementById("span_" + id);

        ctx.remove();

        $(".propertyMenu").html(``);
      });

    }

    this.createChartType = (id, full_id) => {
      $(".propertyMenu").append(`                
          <div class="Scaling">
            <div class="row">
                <div class="col-8 rotates">
                    <span>Chart type</span>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="bgbright"><img src="${path}" style="width:70%; height:70%;"/><title>Line</title></div>
                </div>
            </div>
          </div>`);
    }

    this.createScale = (id, full_id, type) => {
      $(".propertyMenu").append(`                
        <div class="Scaling">
          <div class="row">
              <div class="col-6">
                  <span>Width (px)</span>
                  <input type="text" id="width_${id}" class="form-control crispy"/>
              </div>
              <div class="col-6">
                  <span>Height (px)</span>
                  <input type="text" id="height_${id}" class="form-control crispy" />
              </div>
          </div>
        </div>`);

      // Set start value
      $("#width_" + id).val(Math.round($(full_id).width()));
      $("#height_" + id).val(Math.round($(full_id).height()));

      $("#width_" + id).unbind().change(function () {
        $(full_id).css('width', $("#width_" + id).val());
        $(full_id).css('height', $("#height_" + id).val());

        if(type == "map")
        {
          $("#map_" + id).css('width', $("#width_" + id).val() - 100);
          $("#map_" + id).css('height', $("#height_" + id).val() - 100);
        }
      });

      $("#height_" + id).unbind().change(function () {
        $(full_id).css('width', $("#width_" + id).val());
        $(full_id).css('height', $("#height_" + id).val());

        if(type == "map")
        {
          $("#map_" + id).css('width', $("#width_" + id).val() - 100);
          $("#map_" + id).css('height', $("#height_" + id).val() - 100);
        }
      });
    }

    this.createColorAndFont = (id, full_id) => {
      $(".propertyMenu").append(`                
          <div class="Scaling">
            <div class="row fontalign">
                <div class="col-4">
                    <span>Color</span>
                </div>
                <div class="col-8">
                    <span>Font</span>
                </div>
            </div>
            <div class="row inputalign">
                <div class="col-4">
                    <input type="color" id="color_font_${id}" class="colorSP">
                </div>
                <div class="col-8">
                    <select type="text" class="form-control">
                        <option>test</option>
                    </select>
                </div>
            </div>
          </div>`);

      // Set start value
      $("#color_font_" + id).val(rgbToHex($("#span_" + id).css('color')));

      $("#color_font_" + id).unbind().change(function () {
        $("#span_" + id).css('color', $(this).val());
      });

      // Convert rgb code to hex code
      function rgbToHex(color) {
        color = "" + color;
        if (!color || color.indexOf("rgb") < 0) {
          return;
        }

        if (color.charAt(0) == "#") {
          return color;
        }

        var nums = /(.*?)rgb\((\d+),\s*(\d+),\s*(\d+)\)/i.exec(color),
          r = parseInt(nums[2], 10).toString(16),
          g = parseInt(nums[3], 10).toString(16),
          b = parseInt(nums[4], 10).toString(16);

        return "#" + (
          (r.length == 1 ? "0" + r : r) +
          (g.length == 1 ? "0" + g : g) +
          (b.length == 1 ? "0" + b : b)
        );
      }
    }

    this.createColorAndDeleteForShape = (id, full_id, full_id_shape, type) => {
      $(".propertyMenu").append(`                
          <div class="Scaling">
            <div class="row fontalign">
                <div class="col-4">
                    <span>Color</span>
                </div>
            </div>
            <div class="row inputalign">
                <div class="col-8">
                    <input type="color" class="colorSP" id="color_shape_${id}" value="#f6b73c" style="width:100%;">
                </div>
                <div class="col-4">
                    <button type="button" id="delete_shape_widget_${id}" class="btn btn-default"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
          </div>`);
      
      if(type == "square" || type == "circle")
      {
        // Set start value
        console.log($(full_id_shape).css('background-color'));
        $("#color_shape_" + id).val(rgbToHex($(full_id_shape).css('background-color')));

        $("#color_shape_" + id).unbind().change(function () {
          $(full_id_shape).css('background-color', $(this).val());
        });
      }
      else if(type == "string")
      {
        // Set start value
        $("#color_shape_" + id).val(rgbToHex($(full_id_shape).css('border-right-color')));

        $("#color_shape_" + id).unbind().change(function () {
          $(full_id_shape).css('border-right-color', $(this).val());
        });
      }

      $("#delete_shape_widget_" + id).click(function () {
        widgetObjectList  = arrayRemove(widgetObjectList, id);
        let ctx           = document.getElementById("div_" + id);

        ctx.remove();

        $(".propertyMenu").html(``);
      });

      // Convert rgb code to hex code
      function rgbToHex(color) {
        color = "" + color;
        if (!color || color.indexOf("rgb") < 0) {
          return;
        }

        if (color.charAt(0) == "#") {
          return color;
        }

        var nums = /(.*?)rgb\((\d+),\s*(\d+),\s*(\d+)\)/i.exec(color),
          r = parseInt(nums[2], 10).toString(16),
          g = parseInt(nums[3], 10).toString(16),
          b = parseInt(nums[4], 10).toString(16);

        return "#" + (
          (r.length == 1 ? "0" + r : r) +
          (g.length == 1 ? "0" + g : g) +
          (b.length == 1 ? "0" + b : b)
        );
      }
    }

    this.createStringStyle = (id, full_id, full_id_shape) => {
      $(".propertyMenu").append(`                
          <div class="Editdatacrispy">
            <button type="button" id="solid_style_${id}" class="btn btn-default positionset" ><i class="fas fa-minus"></i></button>
            <button type="button" id="dotted_style_${id}" class="btn btn-default positionset" ><i class="fas fa-ellipsis-h"></i></button>
            <button type="button" id="dashed_style_${id}" class="btn btn-default positionset" ><i class="fas fa-ellipsis-h"></i></button>
          </div>`);
          
      $("#solid_style_" + id).unbind().click(function () {
        $(full_id_shape).css('border-right-style', "solid");
      });

      $("#dotted_style_" + id).unbind().click(function () {
        $(full_id_shape).css('border-right-style', "dotted");
      });

      $("#dashed_style_" + id).unbind().click(function () {
        $(full_id_shape).css('border-right-style', "dashed");
      });
    }

    this.createFontSize = (id, full_id) => {
      $(".propertyMenu").append(`                
          <div class="Scaling">
            <div class="row">
                <div class="col-8 rotates">
                    <span>Font size (px)</span>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <input type="range" min="9" max="120" value="9" id="slider_font_widget_${id}" class="slider"/>
                </div>
                <div class="col-4">
                    <input type="text" id="slider_font_input_widget_${id}" class="form-control crispysilde" />
                </div>
            </div>
          </div>`);

      // Set start value
      $("#slider_font_widget_" + id).val($(full_id).css('font-size').replace('px', ''));
      $("#slider_font_input_widget_" + id).val($(full_id).css('font-size').replace('px', ''));

      $("#slider_font_widget_" + id).unbind().change(function () {
        $("#slider_font_input_widget_" + id).val($(this).val());
        $(full_id).css('font-size', $(this).val() + "px");
      });

      $("#slider_font_input_widget_" + id).unbind().change(function () {
        if ($(this).val() < 9 || $(this).val() > 120) {
          alert("test : 9 - 120");
        }
        else {
          $("#slider_font_widget_" + id).val($(this).val());
          $(full_id).css('font-size', $(this).val() + "px");
        }
      });
    }

    this.createRotation = (id, full_id) => {
      $(".propertyMenu").append(`                
          <div class="Scaling">
            <div class="row">
                <div class="col-8 rotates">
                    <span>Rotation</span>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <input type="range" min="0" max="360" value="0" class="slider"/>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control crispysilde" />
                </div>
            </div>
          </div>`);
    }

    this.createTransparency = (id, full_id) => {
      $(".propertyMenu").append(`                
          <div class="Scaling">
            <div class="row">
                <div class="col-8 rotates">
                    <span>Transparency (%)</span>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <input type="range" min="0" max="100" value="1" id="slider_tran_widget_${id}" class="slider"/>
                </div>
                <div class="col-4">
                    <input type="text" id="slider_tran_input_widget_${id}" class="form-control crispysilde" value="0" />
                </div>
            </div>
          </div>`);
          
      // Set start value
      $("#slider_tran_widget_" + id).val(100 - ($(full_id).css('opacity') * 100));
      $("#slider_tran_input_widget_" + id).val(100 - ($(full_id).css('opacity') * 100));

      $("#slider_tran_widget_" + id).unbind().change(function () {
        var opacityValue = (100 - $(this).val()) / 100;
        $("#slider_tran_input_widget_" + id).val($(this).val());
        $(full_id).css('opacity', opacityValue);
      });

      $("#slider_tran_input_widget_" + id).unbind().change(function () {
        if ($(this).val() < 0 || $(this).val() > 100) {
          alert("test : 0 - 100");
        }
        else {
          var opacityValue = (100 - $(this).val()) / 100;
          $("#slider_tran_widget_" + id).val($(this).val());
          $(full_id).css('opacity', opacityValue);
        }
      });
    }

    this.createBorderRadius = (id, full_id, full_id_shape) => {
      $(".propertyMenu").append(`                
          <div class="Scaling">
            <div class="row">
                <div class="col-8 rotates">
                    <span>Border Radius (%)</span>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <input type="range" min="0" max="50" value="0" id="slider_radius_widget_${id}" class="slider" />
                </div>
                <div class="col-4">
                    <input type="text" id="slider_radius_input_widget_${id}" class="form-control crispysilde value= 0" />
                </div>
            </div>
          </div>`);
          
      // Set start value
      $("#slider_radius_widget_" + id).val($(full_id_shape).css('border-radius').replace('%', ''));
      $("#slider_radius_input_widget_" + id).val($(full_id_shape).css('border-radius').replace('%', ''));

      $("#slider_radius_widget_" + id).unbind().change(function () {
        var radiusValue = $(this).val();
        $("#slider_radius_input_widget_" + id).val($(this).val());
        $(full_id_shape).css('border-radius', radiusValue + "%");
      });

      $("#slider_radius_input_widget_" + id).unbind().change(function () {
        if ($(this).val() < 0 || $(this).val() > 50) {
          alert("test : 0 - 50");
        }
        else {
          var radiusValue = $(this).val();
          $("#slider_radius_widget_" + id).val($(this).val());
          $(full_id_shape).css('border-radius', radiusValue + "%");
        }
      });
    }

    this.createBorderWidth = (id, full_id, full_id_shape) => {
      $(".propertyMenu").append(`                
          <div class="Scaling">
            <div class="row">
                <div class="col-8 rotates">
                    <span>Border Width (px)</span>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <input type="range" min="5" max="20" value="0" id="slider_width_widget_${id}" class="slider" />
                </div>
                <div class="col-4">
                    <input type="text" id="slider_width_input_widget_${id}" class="form-control crispysilde" />
                </div>
            </div>
          </div>`);
          
      // Set start value
      $("#slider_width_widget_" + id).val($(full_id_shape).css('border-right-width').replace('px', ''));
      $("#slider_width_input_widget_" + id).val($(full_id_shape).css('border-right-width').replace('px', ''));

      $("#slider_width_widget_" + id).unbind().change(function () {
        var widthValue = $(this).val();
        $("#slider_width_input_widget_" + id).val($(this).val());
        $(full_id_shape).css('border-right-width', widthValue + "px");
      });

      $("#slider_width_input_widget_" + id).unbind().change(function () {
        if ($(this).val() < 5 || $(this).val() > 20) {
          alert("test : 0 - 50");
        }
        else {
          var widthValue = $(this).val();
          $("#slider_width_widget_" + id).val($(this).val());
          $(full_id_shape).css('border-right-width', widthValue + "px");
        }
      });
    }

    this.createChartDetail = (id, full_id) => {
      $(".propertyMenu").append(`                
        <div class="Grouping">
          <div class="GroupTitle" data-toggle="collapse" data-target="#demo">
              <i class="far fa-chart-bar"></i><span>Chart properties</span>
          </div>
          <div class="GroupBody" id="demo" class="collapse">
              Lorem ipsum
          </div>
        </div>`);
    }

    this.createColor = (id, full_id) => {
      $(".propertyMenu").append(`                
        <div class="Grouping">
          <div class="GroupTitle" data-toggle="collapse" data-target="#demo2">
            <i class="fas fa-palette"></i><span>Color</span>
          </div>
          <div class="GroupBody" id="demo2" class="collapse">
              Lorem ipsum
          </div>
        </div>`);
    }

    this.createLegend = (id, full_id) => {
      $(".propertyMenu").append(`                
        <div class="Grouping">
          <div class="GroupTitle" data-toggle="collapse" data-target="#demo3">
              <i class="fas fa-list-ul"></i><span>Legend</span>
          </div>
          <div class="GroupBody" id="demo3" class="collapse">
              Lorem ipsum
          </div>
        </div>`);
    }

    this.createTooltips = (id, full_id) => {
      $(".propertyMenu").append(`                
        <div class="Grouping">
          <div class="GroupTitle" data-toggle="collapse" data-target="#demo4">
            <i class="fas fa-comment"></i><span>Tooltips</span>
          </div>
          <div class="GroupBody" id="demo4" class="collapse">
              Lorem ipsum
          </div>
        </div>  `);
    }

    this.createMapEvent = (mapObject, full_id) => {
      mapObject.on('mousemove', disableDraggable);
      mapObject.on('mouseout', enableDraggable);

      function disableDraggable(){
        interact(full_id).draggable(false);
        return;
      }

      function enableDraggable(){
        interact(full_id).draggable(true);
        return;
      }
    }
  } // Constructor
} // Property class

class ContentProperty extends Property {
  constructor() {
    /* Call function property */
    /* Select property for each widget type */
    super();
    this.createGraphProp = (id, myChart, full_id, type) => {
      this.createPosition(id, full_id);
      this.createDownload(id, full_id);
      this.createEditdata(id, myChart, full_id);
      this.createScale(id, full_id, type);
      this.createRotation(id, full_id);
      this.createTransparency(id, full_id);
      this.createChartDetail(id, full_id);
      this.createColor(id, full_id);
      this.createLegend(id, full_id);
      this.createTooltips(id, full_id);
    }

    this.createMapProp = (id, full_id, type, mapObject) => {
      this.createPosition(id, full_id);
      this.createDownload(id, full_id);
      this.createScale(id, full_id, type);
      this.createRotation(id, full_id);
      this.createTransparency(id, full_id);
      this.createMapEvent(mapObject, full_id);
    }

    this.createTextProp = (id, full_id, type) => {
      this.createPosition(id, full_id);
      this.createDownload(id, full_id);
      this.createTextchange(id, full_id);
      this.createScale(id, full_id, type);
      this.createRotation(id, full_id);
      this.createTransparency(id, full_id);
      this.createColorAndFont(id, full_id);
      this.createFontSize(id, full_id);
    }

    this.createImageProp = (id, full_id, full_id_image, type) =>{
      this.createPosition(id, full_id);
      this.createDownload(id, full_id);
      this.createCropImage(id, full_id, full_id_image);
      this.createScale(id, full_id, type);
      this.createRotation(id, full_id);
      this.createTransparency(id, full_id);
      this.createBorderRadius(id, full_id, full_id_image);
    }

    this.createShapeProp = (id, full_id, full_id_shape, type) =>{
      this.createPosition(id, full_id);
      this.createDownload(id, full_id);
      this.createColorAndDeleteForShape(id, full_id, full_id_shape, type);

      if(type == "string")
      {
        this.createStringStyle(id, full_id, full_id_shape);
      }

      this.createScale(id, full_id, type);
      this.createRotation(id, full_id);
      this.createTransparency(id, full_id);

      if(type == "string")
      {
        this.createBorderWidth(id, full_id, full_id_shape);
      }
      else
      {
        this.createBorderRadius(id, full_id, full_id_shape);   
      }
    }
  } // Constructor
} // ContentProperty class

/* Set initial value */
$(document).ready(function () {
  let workspace = new Workspace();
  var object    = null;

  /* Setting element */
  workspace.initialAndRun({});

  /* Get saved data */
  $.ajax({
    url: END_POINT + 'admin/infographic/getInfoByInfoID',
    method: 'GET',
    data: {
        info_id: infoID
    },
    success: (res) => {
      if(res.data.info_data != null)
      {
        object = CircularJSON.parse(res.data.info_data);
        workspace.loadWidgetData(object);
      }
    },
    error: (res) => {
      console.log("error");
    }
  }); //Ajax
}); //Document ready

/* Globle function */
function arrayRemove(arr, value) {
  return arr.filter(function (ele) {
    return ele.id != value;
  });
}

let deepCopy = (data) => {
  return data.map((item) => {
      return Object.assign({}, item);
  });
};

