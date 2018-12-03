
var path = $("#pathImg").val();
let widgetObjectList = [];
var CircularJSON = window.CircularJSON;

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

        /* Update widget data */
        for (var i = 0; i < widgetObjectList.length; i++) {
          if (widgetObjectList[i].type == "line") {
            widgetObjectList[i].canvasTag = document.getElementById("canvas_" + widgetObjectList[i].id).outerHTML;
          }
          else if (widgetObjectList[i].type == "head") {
            widgetObjectList[i].spanTag = document.getElementById("span_" + widgetObjectList[i].id).outerHTML;
          }
        }
        console.log(widgetObjectList[0].chartData);
        /* Save to localstorage */
        localStorage.setItem("saveObject", CircularJSON.stringify(widgetObjectList));

        var object = CircularJSON.parse(localStorage.getItem("saveObject"));
      });

      $("#btn_fullscreen").unbind().click(function () {
        var popup = window.open();
        popup.document.write("<h1 id='loading'>Loading...</h1>");
        html2canvas(document.querySelector("#workfull")).then(canvas => {
          var myImage = canvas.toDataURL("image/png");
          var img = '<img src="' + myImage + '">';
          popup.document.write(img);
          popup.document.title = "Preview";
          popup.document.getElementById("loading").remove();
        });

      });

      $("#btn_download").unbind().click(function () {
        var popup = window.open();
        popup.document.write("<h1>Please wait for download...</h1>");

        html2canvas(document.querySelector("#workfull")).then(canvas => {
          popup.close();
          var myLinkImage = canvas.toDataURL("image/png");
          var a = $("<a>")
            .attr("href", myLinkImage)
            .attr("download", "ImageDownload.png")
            .appendTo("body");
          a[0].click();
          a.remove();
        });
      });
    };

    this.loadWidgetData = (object) => {
      for (var i = 0; i < object.length; i++) {
        if (object[i].type == "line") {
          var lineGraph = new Graph();
          lineGraph.loadLineGraph(object[i].id, object[i].canvasTag, object[i].chartData, object[i].options);
        }
        else if (object[i].type == "head") {
          var fontHead = new Font();
          fontHead.loadHeadGraph(object[i].id, object[i].spanTag);
        }
      }

    }

    /* Initial Action Function */
    var graphMenu = () => {
      if ($("#btnGraph").hasClass("actives")) {
        UnActive("btnGraph");
      }
      else {
        SetActive("btnGraph");

        $("#selectMenu").html(`<top class="head">Add Graph<close><i class="fas fa-times"></i></close></top>
                                <sub id="g1"><img src="${path}" style="width:100%; height:100%;"/><title>Line</title></sub>
                                <sub id="g2"><img src="${path}" style="width:100%; height:100%;"/><title>Bar</title></sub>
                                <sub id="g3"><img src="${path}" style="width:100%; height:100%;"/><title>Circle</title></sub>
                                <sub id="g4"><img src="${path}" style="width:100%; height:100%;"/><title>Stack</title></sub>`);

        $(".fa-times").unbind().click(function () {
          UnActive("btnGraph");
        });

        $("#g1").unbind().click(function () {
          var lineGraph = new Graph();
          lineGraph.createLineGraph();
        });

        $("#g2").unbind().click(function () {
          alert("g2");
        });

        $("#g3").unbind().click(function () {
          alert("g3");
        });

        $("#g4").unbind().click(function () {
          alert("g4");
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
                                <sub href="#"><img src="${path}" style="width:100%; height:100%;"/><title>North</title></sub>
                                <sub href="#"><img src="${path}" style="width:100%; height:100%;"/><title>South</title></sub>
                                <sub href="#"><img src="${path}" style="width:100%; height:100%;"/><title>East</title></sub>
                                <sub href="#"><img src="${path}" style="width:100%; height:100%;"/><title>Wast</title></sub>`);

        $(".fa-times").unbind().click(function () {
          UnActive("btnMap");
        });
      }
    }

    var fontMenu = () => {
      if ($("#btnFont").hasClass("actives")) {
        UnActive("btnFont");
      }
      else {
        SetActive("btnFont");

        $("#selectMenu").html(`<top href="#" class="head">Add Font<close><i class="fas fa-times"></i></close></top>
                                <sub id="f1"><img src="${path}" style="width:100%; height:100%;"/><title>Head</title></sub>
                                <sub id="f2"><img src="${path}" style="width:100%; height:100%;"/><title>Title</title></sub>
                                <sub id="f3"><img src="${path}" style="width:100%; height:100%;"/><title>Subtitle</title></sub>`);

        $(".fa-times").unbind().click(function () {
          UnActive("btnFont");
        });

        $("#f1").unbind().click(function () {
          var fontHead = new Font();
          fontHead.createHeadGraph();
        });

        $("#f2").unbind().click(function () {
          alert("f2");
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
                                <sub href="#"><button type="button" class="btn btn-default btn-lg" >Browse</button></sub>`);

        $(".fa-times").unbind().click(function () {
          UnActive("btnImage");
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
                                <sub href="#"><img src="${path}" style="width:100%; height:100%;"/><title>Square</title></sub>
                                <sub href="#"><img src="${path}" style="width:100%; height:100%;"/><title>Triangle</title></sub>
                                <sub href="#"><img src="${path}" style="width:100%; height:100%;"/><title>Line</title></sub>`);

        $(".fa-times").unbind().click(function () {
          UnActive("btnShapes");
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
  }
}

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
          edges: { left: true, right: true, bottom: true, top: true },

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
          target.style.width = event.rect.width + 'vw';
          target.style.height = event.rect.height + 'vh';
          //console.log(target);
          // $(target).attr('width', event.rect.width);
          // $(target).attr('height', event.rect.height);

          // translate when resizing from top or left edges
          x += event.deltaRect.left;
          y += event.deltaRect.top;

          target.style.webkitTransform = target.style.transform =
            'translate(' + x + 'px,' + y + 'px)';

          target.setAttribute('data-x', x);
          target.setAttribute('data-y', y);

          $("#width_" + id).val(Math.round(event.rect.width));
          $("#height_" + id).val(Math.round(event.rect.height));
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

      $("#workspace").append(`<canvas id="canvas_${id}" class="sPosition fCorner"/>`);

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
      property.createGraphProp(id, myChart, "#canvas_" + id);

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "canvas_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#canvas_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createGraphProp(id, myChart, "#canvas_" + id);
      })
        .on('dragmove', function (event) {
          /* Change focus */
          $(".sPosition").removeClass("fCorner");
          $("#canvas_" + id).addClass("fCorner");

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
          property.createGraphProp(id, myChart, "#canvas_" + id);
        })

      /* Save widget */
      let saveObject = new WidgetObject();
      console.log(myChart.data);
      saveObject.LineGraphObject(id, null, myChart.data, myChart.options, "line");
      widgetObjectList.push(saveObject);
      console.log(widgetObjectList[0].chartData);
    }

    this.loadLineGraph = (id, canvasTag, chartData, chartOptions) => {
      this.clearfocus();

      $("#workspace").append(canvasTag);

      let ctx = document.getElementById("canvas_" + id);
      var myChart2 = new Chart(ctx, {
        type: 'line',
        options: chartOptions
      });

      addLabel(myChart2, chartData.labels);
      addDatasets(myChart2, chartData.datasets);

      /* Clear other property */
      $(".propertyMenu").html(``);
      this.clearfocus();

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "canvas_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#canvas_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createGraphProp(id, myChart2, "#canvas_" + id);
      })
        .on('dragmove', function (event) {
          /* Change focus */
          $(".sPosition").removeClass("fCorner");
          $("#canvas_" + id).addClass("fCorner");

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
          property.createGraphProp(id, myChart2, "#canvas_" + id);
        })

      /* Save widget */
      let saveObject = new WidgetObject();
      saveObject.LineGraphObject(id, null, myChart2.data, myChart2.options, "line");
      widgetObjectList.push(saveObject);
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
}

/* Font */
class Font extends Widget {
  constructor() {
    super();
    this.createHeadGraph = () => {
      var id = Math.floor(100000 + Math.random() * 900000);
      this.clearfocus();

      $("#workspace").append(`<span id="span_${id}" class="sPosition fCorner" style="font-size: 100px;">Head</span>`);

      /* Clear other property */
      $(".propertyMenu").html(``);

      var property = new ContentProperty();
      property.createTextProp(id, "#span_" + id);

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "span_");
      widgetObject.on('tap', function (event) {
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#span_" + id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createTextProp(id, "#span_" + id);
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
          property.createTextProp(id, "#span_" + id);
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
        property.createTextProp(id, "#span_" + id);
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
          property.createTextProp(id, "#span_" + id);
        })

      /* Save widget */
      let saveObject = new WidgetObject();
      saveObject.HeadFontObject(id, null, "head");
      widgetObjectList.push(saveObject);
    }
  }
}

class Property {
  constructor() {
    /* Create function property */
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
        var transform = $(full_id).css('transform').split(',');
        var transformY = transform[5].split(')')[0];

        $(full_id).css('transform', 'translate(0px, ' + transformY + 'px)');
        $(full_id).attr('data-x', 0);
        $(full_id).attr('data-y', transformY);
      });

      $("#align_center_widget_" + id).click(function () {
        var transform = $(full_id).css('transform').split(',');
        var transformY = transform[5].split(')')[0];
        var transformX = (517 / 2) - ($(full_id).width() / 2);

        $(full_id).css('transform', 'translate(' + transformX + 'px, ' + transformY + 'px)');
        $(full_id).attr('data-x', transformX);
        $(full_id).attr('data-y', transformY);
      });

      $("#align_right_widget_" + id).click(function () {
        var transform = $(full_id).css('transform').split(',');
        var transformY = transform[5].split(')')[0];
        var transformX = 517 - $(full_id).width();

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
        var data_x = $(full_id).css('data-x');
        var data_y = $(full_id).css('data-y');
        var width = $(full_id).css('width');
        var height = $(full_id).css('height');

        $(full_id).css('transform', 'translate(0px, 0px)');
        $(full_id).css('data-x', 0);
        $(full_id).css('data-y', 0);
        $(full_id).css('width', 800);
        $(full_id).css('height', 450);
        $(full_id).removeClass("fCorner");

        html2canvas(document.querySelector(full_id)).then(canvas => {
          $(full_id).css('transform', transform);
          $(full_id).css('data-x', data_x);
          $(full_id).css('data-y', data_y);
          $(full_id).css('width', width);
          $(full_id).css('height', height);
          $(full_id).addClass("fCorner");

          popup.close();

          var myLinkImage = canvas.toDataURL("image/png");
          var a = $("<a>")
            .attr("href", myLinkImage)
            .attr("download", "ImageDownload.png")
            .appendTo("body");
          a[0].click();
          a.remove();
        });
      });

      $("#preview_widget_" + id).click(function () {
        var popup = window.open();
        popup.document.write("<h1 id='loading'>Loading...</h1>");

        var transform = $(full_id).css('transform');
        var data_x = $(full_id).css('data-x');
        var data_y = $(full_id).css('data-y');
        var width = $(full_id).css('width');
        var height = $(full_id).css('height');

        $(full_id).css('transform', 'translate(0px, 0px)');
        $(full_id).css('data-x', 0);
        $(full_id).css('data-y', 0);
        $(full_id).css('width', 800);
        $(full_id).css('height', 450);
        $(full_id).removeClass("fCorner");

        html2canvas(document.querySelector(full_id)).then(canvas => {
          $(full_id).css('transform', transform);
          $(full_id).css('data-x', data_x);
          $(full_id).css('data-y', data_y);
          $(full_id).css('width', width);
          $(full_id).css('height', height);
          $(full_id).addClass("fCorner");

          var myImage = canvas.toDataURL("image/png");
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
        widgetObjectList = arrayRemove(widgetObjectList, id);
        let ctx = document.getElementById("canvas_" + id);
        myChart.destroy();
        ctx.remove();
        console.log(widgetObjectList);
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

      $("#inputtext_" + id).val($("#span_" + id).html());

      $("#inputtext_" + id).keyup(function () {
        $("#span_" + id).html($("#inputtext_" + id).val());
      });

      $("#delete_text_widget_" + id).click(function () {
        widgetObjectList = arrayRemove(widgetObjectList, id);
        let ctx = document.getElementById("span_" + id);
        ctx.remove();
        console.log(widgetObjectList);
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

    this.createScale = (id, full_id) => {
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

      $("#width_" + id).val(Math.round($(full_id).width()));
      $("#height_" + id).val(Math.round($(full_id).height()));

      $("#width_" + id).unbind().change(function () {
        $(full_id).css('width', $("#width_" + id).val());
        $(full_id).css('height', $("#height_" + id).val());
      });

      $("#height_" + id).unbind().change(function () {
        $(full_id).css('width', $("#width_" + id).val());
        $(full_id).css('height', $("#height_" + id).val());
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

      $("#color_font_" + id).val(rgbToHex($("#span_" + id).css('color')));

      $("#color_font_" + id).unbind().change(function () {
        $("#span_" + id).css('color', $(this).val());
      });

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

      $("#slider_font_widget_" + id).val($(full_id).css('font-size'));
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
  }
}

class ContentProperty extends Property {
  constructor() {
    /* Call function property */
    super();
    this.createGraphProp = (id, myChart, full_id) => {
      this.createPosition(id, full_id);
      this.createDownload(id, full_id);
      this.createEditdata(id, myChart, full_id);
      this.createChartType(id, full_id);
      this.createScale(id, full_id);
      this.createRotation(id, full_id);
      this.createTransparency(id, full_id);
      this.createChartDetail(id, full_id);
      this.createColor(id, full_id);
      this.createLegend(id, full_id);
      this.createTooltips(id, full_id);
    }

    this.createTextProp = (id, full_id) => {
      this.createPosition(id, full_id);
      this.createDownload(id, full_id);
      this.createTextchange(id, full_id);
      this.createScale(id, full_id);
      this.createRotation(id, full_id);
      this.createTransparency(id, full_id);
      this.createColorAndFont(id, full_id);
      this.createFontSize(id, full_id);
    }
  }
}

/* Set initial value */
$(document).ready(function () {
  //localStorage.clear();
  let workspace = new Workspace();
  workspace.initialAndRun({});

  /* Get saved data */
  var object = CircularJSON.parse(localStorage.getItem("saveObject"));

  if (object != null) {
    /* Load saved widget */
    //console.log(object[0].data);
    workspace.loadWidgetData(object);
  }
  else {
    console.log("null");
  }

});

/* Globle function */
function arrayRemove(arr, value) {
  return arr.filter(function (ele) {
    return ele.id != value;
  });
}
