
class Workspace
{
  constructor()
  {
    var path = $("#pathImg").val();
  
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
                                <sub id="g1"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Line</title></sub>
                                <sub id="g2"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Bar</title></sub>
                                <sub id="g3"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Circle</title></sub>
                                <sub id="g4"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Stack</title></sub>`);
        
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
                                <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>North</title></sub>
                                <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>South</title></sub>
                                <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>East</title></sub>
                                <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Wast</title></sub>`);
        
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
                                <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Head</title></sub>
                                <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Title</title></sub>
                                <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Subtitle</title></sub>`);
        
        $(".fa-times").unbind().click(function () {
          UnActive("btnFont");
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
                                <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Square</title></sub>
                                <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Triangle</title></sub>
                                <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Line</title></sub>`);
       
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
    this.createWidget = (id) =>
    {
      var widgetObject = interact('#canvas_' + id)  
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
        changefocus(id);
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
        changefocus(id);
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

    let changefocus = (id) =>
    {
      $(".sPosition").removeClass("fCorner");
      $("#canvas_"+ id).addClass("fCorner");
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

      $("#workspace").append(`<canvas id="canvas_`+ id +`" class="sPosition fCorner"/>`);

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

      var widgetObject = this.createWidget(id);
      widgetObject.on('tap',function (event){
        /* Change focus */
        $(".sPosition").removeClass("fCorner");
        $("#canvas_"+ id).addClass("fCorner");

        /* Clear other property */
        $(".propertyMenu").html(``);

        var property = new ContentProperty();
        property.createGraphProp(id);

        $("#width_" + id).val(Math.round($("#canvas_"+ id).width()));
        $("#height_" + id).val(Math.round($("#canvas_"+ id).height()));
      })
    }
  }
}

class Property
{
  constructor()
  {
    $("#propertySpace").html('<div class="propertyMenu"></div>');

    this.createScale = (id) => 
    {
      $(".propertyMenu").append(`                
        <div class="Scaling">
          <div class="row">
              <div class="col-6">
                  <span>Width (px)</span>
                  <input type="text" id="width_`+ id +`" class="form-control crispy"/>
              </div>
              <div class="col-6">
                  <span>Height (px)</span>
                  <input type="text" id="height_`+ id +`" class="form-control crispy" />
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
    super();
    this.createGraphProp = (id) =>
    {
      this.createScale(id);
      this.createChartDetail(id);
      this.createColor(id);
      this.createLegend(id);
      this.createTooltips(id);
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
