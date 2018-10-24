/* Model */
var InfographicRepository = new (function () {
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
      $("#btnGraph").removeClass("actives");
      $("#selectMenu").html(``);
      $("#selectMenu").hide();
    }
    else
    {
      $("#selectMenu").show();
      $(".vertical-menu").find("a").removeClass("actives");
      $("#btnGraph").addClass("actives");

      $("#selectMenu").html(`<sub href="#" class="head">Add Graph<close><i class="fas fa-times" style="cursor:pointer"></i></close></sub>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Line</title></sub>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Bar</title></sub>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Circle</title></sub>
                              <sub href="#"><img src="`+ path + `" style="width:100%; height:100%;"/><title>Stack</title></sub>`);
      
      $(".fa-times").unbind().click(function () {
        $("#btnGraph").removeClass("actives");
        $("#selectMenu").html(``);
        $("#selectMenu").hide();
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

      $("#selectMenu").html(`<sub href="#" class="head">Add Map<close><i class="fas fa-times" style="cursor:pointer"></i></close></sub>
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
      
      $("#selectMenu").html(`<sub href="#" class="head">Add Font<close><i class="fas fa-times" style="cursor:pointer"></i></close></sub>
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

      $("#selectMenu").html(`<sub href="#" class="head">Add Image<close><i class="fas fa-times" style="cursor:pointer"></i></close></sub>
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

      $("#selectMenu").html(`<sub href="#" class="head">Add Shape<close><i class="fas fa-times" style="cursor:pointer"></i></close></sub>
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

})

/* Set initial value */
$(document).ready(function () {
  var infoObject = InfographicRepository;
  infoObject.initialAndRun({});
});

/*$(document).ready(function () {

    
    var canvas = new fabric.Canvas('canvas');
    canvas.add(new fabric.Circle({ radius: 30, fill: '#f55', top: 100, left: 100 }));
  
    canvas.item(0).set({
      borderColor: 'red',
      cornerColor: 'green',
      cornerSize: 6,
      transparentCorners: false
    });
    canvas.setActiveObject(canvas.item(0));
    this.__canvases.push(canvas);

    
   
});*/