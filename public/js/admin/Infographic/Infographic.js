var path = $("#pathImg").val();

class Workspace
{
  constructor()
  { 
    /* Initial Function */
    this.initialAndRun = () => 
    {
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
    };
  
    /* Initial Action Function */
    var graphMenu = () => 
    {
      if($("#btnGraph").hasClass("actives"))
      {
        UnActive("btnGraph");
      }
      else
      {
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
    
    var mapMenu = () => 
    {
      if($("#btnMap").hasClass("actives"))
      {
        UnActive("btnMap");
      }
      else
      {
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
  
    var fontMenu = () => 
    {
      if($("#btnFont").hasClass("actives"))
      {
        UnActive("btnFont");
      }
      else
      {
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
  
    var imageMenu = () => 
    {
      if($("#btnImage").hasClass("actives"))
      {
        UnActive("btnImage");
      }
      else
      {
        SetActive("btnImage");
  
        $("#selectMenu").html(`<top href="#" class="head">Add Image<close><i class="fas fa-times"></i></close></top>
                                <sub href="#"><button type="button" class="btn btn-default btn-lg" >Browse</button></sub>`);
        
        $(".fa-times").unbind().click(function () {
          UnActive("btnImage");
        });
      }
    }
  
    var shapesMenu = () => 
    {
      if($("#btnShapes").hasClass("actives"))
      {
        UnActive("btnShapes");
      }
      else
      {
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
    var UnActive = (id) =>
    {
      $("#" + id).removeClass("actives");
      $("#selectMenu").html(``);
      $("#selectMenu").hide();
    }

    var SetActive = (id) =>
    {
      $("#selectMenu").show();
      $(".vertical-menu").find("a").removeClass("actives");
      $("#" + id).addClass("actives");
    }
  }
}

class Widget
{
  constructor()
  {
    /* Create freetranform */
    this.createWidget = (id, typeid) =>
    {
      var widgetObject = interact('#'+ typeid + id)  
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
      .on('doubletap',function (){
        $(".sPosition").removeClass("fCorner");

        /* Clear property */
        $(".propertyMenu").html(``);
      })
      .on('dragmove',function (event){
        changefocus(id, typeid);
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
      })
      .on('resizemove', function (event) {
        changefocus(id, typeid);
        var target = event.target,
            x = (parseFloat(target.getAttribute('data-x')) || 0),
            y = (parseFloat(target.getAttribute('data-y')) || 0);
    
        // update the element's style
        target.style.width  = event.rect.width + 'px';
        target.style.height = event.rect.height + 'px';
    
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
    let changefocus = (id, typeid) =>
    {
      $(".sPosition").removeClass("fCorner");
      $('#' + typeid + id).addClass("fCorner");
    }
  
    this.clearfocus = () =>
    {
      $(".sPosition").removeClass("fCorner");
    }
  }
}

/* Graph */
class Graph extends Widget
{
  constructor()
  {
    super();
    this.createLineGraph = () =>
    {
      var id = Math.floor(100000 + Math.random() * 900000);
      this.clearfocus();

      $("#workspace").append(`<canvas id="canvas_${id}" class="sPosition fCorner"/>`);

      var speedData = {
        labels: ["0s", "10s", "20s", "30s", "40s", "50s", "60s"],
        datasets: [{
          label: "Car Speed",
          data: [0, 59, 75, 20, 20, 55, 40],
        }]
      };
        
      var chartOptions = {
        legend: {
          display: true,
          position: 'top',
          labels: {
            boxWidth: 80,
            fontColor: 'black'
          }
        }
      };
      
      let ctx = document.getElementById("canvas_"+ id);
      var myChart = new Chart(ctx, {
        type: 'line',
        data: speedData,
        options: chartOptions
      });

      /* Clear other property */
      $(".propertyMenu").html(``);

      var property = new ContentProperty();
      property.createGraphProp(id);

      $("#width_" + id).val(Math.round($("#canvas_"+ id).width()));
      $("#height_" + id).val(Math.round($("#canvas_"+ id).height()));

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "canvas_");
      widgetObject.on('tap',function (event){
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#canvas_"+ id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createGraphProp(id);

        /* Set property value */
        $("#width_" + id).val(Math.round($("#canvas_"+ id).width()));
        $("#height_" + id).val(Math.round($("#canvas_"+ id).height()));

        console.log($("#workspace").html());
        
      })
    }
  }
}

/* Font */
class Font extends Widget
{
  constructor()
  {
    super();
    this.createHeadGraph = () =>
    {
      var id = Math.floor(100000 + Math.random() * 900000);
      this.clearfocus();

      $("#workspace").append(`<span id="span_${id}" class="sPosition fCorner" style="font-size: 100px;">Head</span>`);

      /* Clear other property */
      $(".propertyMenu").html(``);

      var property = new ContentProperty();
      property.createTextProp(id);

      $("#width_" + id).val(Math.round($("#span_"+ id).width()));
      $("#height_" + id).val(Math.round($("#span_"+ id).height()));

      /* Click each widget event */
      var widgetObject = this.createWidget(id, "span_");
      widgetObject.on('tap',function (event){
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#span_"+ id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createTextProp(id);

        /* Set property value */
        $("#width_" + id).val(Math.round($("#span_"+ id).width()));
        $("#height_" + id).val(Math.round($("#span_"+ id).height()));

        $("#inputtext_" + id).val($("#span_" + id).html());

        console.log($("#workspace").html());
        
      })
    }
  }
}

class Property
{
  constructor()
  {
    /* Create function property */
    $("#propertySpace").html('<div class="propertyMenu"></div>');

    this.createEditdata = (id) =>
    {
      $(".propertyMenu").append(`                
          <div class="Editdatacrispy">
            <button type="button" class="btn btn-default Editdata" >Edit data</button>
          </div>`);
    }

    this.createTextchange = (id) =>
    {
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
                </div>
            </div>
          </div>`);

      $("#inputtext_" + id).keyup(function () {
        $("#span_" + id).html($("#inputtext_" + id).val());
      });

    }

    this.createChartType = (id) =>
    {
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

    this.createScale = (id) => 
    {
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

      $("#width_" + id).unbind().change(function () {
        $("#canvas_" + id).css('width',$("#width_" + id).val());
        $("#canvas_" + id).css('height',$("#height_" + id).val());
      });

      $("#height_" + id).unbind().change(function () {
        $("#canvas_" + id).css('width',$("#width_" + id).val());
        $("#canvas_" + id).css('height',$("#height_" + id).val());
      });
    }

    this.createColorAndFont = (id) =>
    {
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
                    <input type="color" class="colorSP" value="#000">
                </div>
                <div class="col-8">
                    <select type="text" class="form-control">
                        <option>test</option>
                    </select>
                </div>
            </div>
          </div>`);
    }

    this.createFontSize = (id) =>
    {
      $(".propertyMenu").append(`                
          <div class="Scaling">
            <div class="row">
                <div class="col-8 rotates">
                    <span>Font size (pt)</span>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <input type="range" min="9" max="120" value="9" class="slider"/>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control crispysilde" />
                </div>
            </div>
          </div>`);
    }

    this.createRotation = (id) =>
    {
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

    this.createTransparency = (id) =>
    {
      $(".propertyMenu").append(`                
          <div class="Scaling">
            <div class="row">
                <div class="col-8 rotates">
                    <span>Transparency (%)</span>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <input type="range" min="0" max="100" value="0" class="slider"/>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control crispysilde" />
                </div>
            </div>
          </div>`);
    }

    this.createChartDetail = (id) =>
    {
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

    this.createColor = (id) =>
    {
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

    this.createLegend = (id) =>
    {
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

    this.createTooltips = (id) =>
    {
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

class ContentProperty extends Property
{
  constructor()
  {
    /* call function property */
    super();
    this.createGraphProp = (id) =>
    {
      this.createEditdata(id);
      this.createChartType(id);
      this.createScale(id);
      this.createRotation(id);
      this.createTransparency(id);
      this.createChartDetail(id);
      this.createColor(id);
      this.createLegend(id);
      this.createTooltips(id);
    }   

    this.createTextProp = (id) =>
    {
      this.createTextchange(id);
      this.createScale(id);
      this.createRotation(id);
      this.createTransparency(id);
      this.createColorAndFont(id);
      this.createFontSize(id);
    }
  }
}

/* Set initial value */
$(document).ready(function () {
  let workspace = new Workspace();
  workspace.initialAndRun({});

  /*var canvas = new fabric.Canvas('canvas');
  canvas.add(new fabric.Circle({ radius: 30, fill: '#f55', top: 100, left: 100 }));

  canvas.item(0).set({
    borderColor: 'red',
    cornerColor: 'green',
    cornerSize: 6,
    transparentCorners: false
  });
  canvas.setActiveObject(canvas.item(0));
  this.__canvases.push(canvas);*/
});
