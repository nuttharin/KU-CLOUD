/* Model */
var InfographicRepository = new (function () {
  var path = $("#pathImg").val();
  var y;

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
      $("#btnGraph").removeClass("actives");
      $("#selectMenu").html(``);
      $("#selectMenu").hide();
    }
    else
    {
      $("#selectMenu").show();
      $(".vertical-menu").find("a").removeClass("actives");
      $("#btnGraph").addClass("actives");

      $("#selectMenu").html(`<top class="head">Add Graph<close><i class="fas fa-times"></i></close></top>
                              <sub id="g1"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Line</title></sub>
                              <sub id="g2"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Bar</title></sub>
                              <sub id="g3"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Circle</title></sub>
                              <sub id="g4"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Stack</title></sub>`);
      
      $(".fa-times").unbind().click(function () {
        $("#btnGraph").removeClass("actives");
        $("#selectMenu").html(``);
        $("#selectMenu").hide();
      });

      $("#g1").unbind().click(function () {
        var id = Math.floor(100000 + Math.random() * 900000)
        createGraph(1, id);

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
      $("#btnMap").removeClass("actives");
      $("#selectMenu").html(``);
      $("#selectMenu").hide();
    }
    else
    {
      $("#selectMenu").show();
      $(".vertical-menu").find("a").removeClass("actives");
      $("#btnMap").addClass("actives");

      $("#selectMenu").html(`<top href="#" class="head">Add Map<close><i class="fas fa-times"></i></close></top>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>North</title></sub>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>South</title></sub>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>East</title></sub>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Wast</title></sub>`);
      
      $(".fa-times").unbind().click(function () {
        $("#btnMap").removeClass("actives");
        $("#selectMenu").html(``);
        $("#selectMenu").hide();
      });
    }   
  }

  var fontMenu = () => 
  {
    if($("#btnFont").hasClass("actives"))
    {
      $("#btnFont").removeClass("actives");
      $("#selectMenu").html(``);
      $("#selectMenu").hide();
    }
    else
    {
      $("#selectMenu").show();
      $(".vertical-menu").find("a").removeClass("actives");
      $("#btnFont").addClass("actives");
      
      $("#selectMenu").html(`<top href="#" class="head">Add Font<close><i class="fas fa-times"></i></close></top>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Head</title></sub>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Title</title></sub>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Subtitle</title></sub>`);
      
      $(".fa-times").unbind().click(function () {
        $("#btnFont").removeClass("actives");
        $("#selectMenu").html(``);
        $("#selectMenu").hide();
      });
    }  
  }

  var imageMenu = () => 
  {
    if($("#btnImage").hasClass("actives"))
    {
      $("#btnImage").removeClass("actives");
      $("#selectMenu").html(``);
      $("#selectMenu").hide();
    }
    else
    {
      $("#selectMenu").show();
      $(".vertical-menu").find("a").removeClass("actives");
      $("#btnImage").addClass("actives");

      $("#selectMenu").html(`<top href="#" class="head">Add Image<close><i class="fas fa-times"></i></close></top>
                              <sub href="#"><button type="button" class="btn btn-default btn-lg" >Browse</button></sub>`);
      
      $(".fa-times").unbind().click(function () {
        $("#btnImage").removeClass("actives");
        $("#selectMenu").html(``);
        $("#selectMenu").hide();
      });
    }
  }

  var shapesMenu = () => 
  {
    if($("#btnShapes").hasClass("actives"))
    {
      $("#btnShapes").removeClass("actives");
      $("#selectMenu").html(``);
      $("#selectMenu").hide();
    }
    else
    {
      $("#selectMenu").show();
      $(".vertical-menu").find("a").removeClass("actives");
      $("#btnShapes").addClass("actives");

      $("#selectMenu").html(`<top href="#" class="head">Add Shape<close><i class="fas fa-times"></i></close></top>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Square</title></sub>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Triangle</title></sub>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Line</title></sub>`);
     
      $(".fa-times").unbind().click(function () {
        $("#btnShapes").removeClass("actives");
        $("#selectMenu").html(``);
        $("#selectMenu").hide();
      });
    }
  }

  var createGraph = (type, id) =>
  {
    clearfocus();
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

    interact('#canvas_' + id)  
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
    .on('tap',function (){
      changefocus(id);
      showPropertyMenu(id);
    })
    .on('doubletap',function (){
      clearfocus();
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
    });
  }

  var showPropertyMenu = (id) =>
  {

  }

  var changefocus = (id) =>
  {
    $(".sPosition").removeClass("fCorner");
    $("#canvas_"+ id).addClass("fCorner");
  }

  var clearfocus = () =>
  {
    $(".sPosition").removeClass("fCorner");
  }
})

/* Set initial value */
$(document).ready(function () {
  var infoObject = InfographicRepository;
  infoObject.initialAndRun({});



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
