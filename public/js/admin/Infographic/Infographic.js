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

    $("#workspace").append(`<div id="div_`+ id +`" style="width: 500px;">
                              <canvas id="canvas_`+ id +`"></canvas>
                            </div>`);

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

    var t = $('#div_' + id).freetrans({
      matrix: "matrix(.90,.25,-.25,.95,30,50)"
    });

  }
})

/* Set initial value */
$(document).ready(function () {
  var infoObject = InfographicRepository;
  infoObject.initialAndRun({});





  $('#ghost').freetrans({
      matrix: "matrix(.95,.25,-.25,.95,30,50)"
  });

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
